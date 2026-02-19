# Laboratorio 4 – Topic Exchange (Routing gerarchico con wildcard)

## Obiettivo

Implementare un modello **publish/subscribe con routing gerarchico** utilizzando un **topic exchange** in RabbitMQ.

In questo laboratorio:

* il publisher pubblica messaggi su un exchange di tipo *topic*
* l’exchange instrada i messaggi verso le code in base a una **routing key gerarchica**
* i consumer ricevono i messaggi in base a pattern di sottoscrizione con **wildcard**

---

## Contesto Architetturale

Nel topic exchange il routing avviene confrontando:

* **routing key** (usata dal publisher in pubblicazione)
* **binding key** (pattern usato nel binding tra queue ed exchange)

Schema:

```
Publisher → Topic Exchange → Queue (binding: logs.system.error) → Consumer 1
                          ↘→ Queue (binding: logs.system.*)     → Consumer 2
```

---

## Topic Exchange

Un exchange **topic**:

* usa routing key composte da parole separate da `.` (es. `logs.system.error`)
* instrada il messaggio alle code i cui binding pattern matchano la routing key

Wildcard supportate nei binding:

* `*` = matcha **una sola parola**

  * es. `logs.system.*` matcha `logs.system.error` ma non `logs.system.kernel.panic`
* `#` = matcha **zero o più parole**

  * es. `logs.#` matcha `logs.system.error` e `logs.system.kernel.panic`

---

## Attività da svolgere

1. Creare un exchange chiamato:

   ```
   COGNOME-exchange-topic
   ```

   con le seguenti caratteristiche:

   * `type = topic`
   * `durable = false`

2. Creare due queue (una per ciascun consumer), non durable e non exclusive.

3. Creare i binding tra exchange e queue:

   * Consumer 1: binding key `logs.system.error`
   * Consumer 2: binding key `logs.system.*`

4. Avviare due consumer, ciascuno in ascolto sulla propria queue.

5. Pubblicare messaggi sull’exchange usando routing key diverse, ad esempio:

   * `logs.system.error`
   * `logs.system.warning`
   * (opzionale) `logs.system.info`

---

## Risultato Atteso

* Il consumer con binding `logs.system.error` deve ricevere **solo** i messaggi con routing key esattamente `logs.system.error`.
* Il consumer con binding `logs.system.*` deve ricevere i messaggi con routing key:

  * `logs.system.error`
  * `logs.system.warning`
  * `logs.system.info`
    (cioè qualsiasi routing key con tre parole che inizi con `logs.system.`)

Di conseguenza:

* un messaggio pubblicato con routing key `logs.system.error` verrà ricevuto da **entrambi** i consumer
* un messaggio con routing key `logs.system.warning` verrà ricevuto **solo** dal secondo consumer

---

## Differenza rispetto al Direct Exchange

| Direct Exchange                            | Topic Exchange                                  |
| ------------------------------------------ | ----------------------------------------------- |
| Match esatto tra routing key e binding key | Match per pattern con wildcard (`*`, `#`)       |
| Routing “a etichette” semplici             | Routing gerarchico e flessibile                 |
| Utile per categorie rigide                 | Utile per sottoscrizioni per famiglie di eventi |
