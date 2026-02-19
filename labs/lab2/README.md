# Laboratorio 2 – Fanout Exchange (Publish/Subscribe)

## Obiettivo

Implementare il modello **publish/subscribe** utilizzando un **fanout exchange** in RabbitMQ.

In questo laboratorio:

* un publisher invia messaggi a un exchange
* l’exchange inoltra ogni messaggio a **tutte** le code collegate
* più consumer ricevono lo stesso messaggio

Questo rappresenta un classico scenario di comunicazione *broadcast*.

---

## Contesto Architetturale

Nel modello publish/subscribe con fanout exchange:

```
            → Queue 1 → Consumer 1
Publisher → Exchange
            → Queue 2 → Consumer 2
```

* Il producer pubblica un messaggio sull’exchange
* L’exchange di tipo **fanout** replica il messaggio verso tutte le queue bindate
* Ogni consumer riceve una copia del messaggio

---

## Fanout Exchange

Un exchange **fanout**:

* ignora completamente la routing key
* inoltra ogni messaggio a tutte le code collegate
* è adatto a notifiche, eventi globali e broadcast

---

## Attività da svolgere

1. Creare un exchange chiamato:

   ```
   COGNOME-exchange-fanout
   ```

   con le seguenti caratteristiche:

   * `type = fanout`
   * `durable = false`

2. Creare una queue dedicata per ogni consumer:

   * Consumer 1 → Queue 1
   * Consumer 2 → Queue 2

   Le code devono essere:

   * non durable
   * non exclusive

3. Collegare ogni queue all’exchange tramite binding:

   ```php
   $channel->queue_bind(queue, exchange);
   ```

4. Avviare due consumer, ciascuno in ascolto sulla propria queue

5. Pubblicare un messaggio sull’exchange

---

## Risultato Atteso

* Entrambi i consumer devono ricevere lo stesso messaggio.
* Ogni consumer riceve una copia indipendente dell’evento pubblicato.
* A differenza del modello worker queue, il messaggio non viene distribuito tra consumer, ma replicato.

Se vengono inviati più messaggi, ogni consumer li riceverà tutti, mantenendo l’ordine di consegna nella propria queue.

---

## Differenza rispetto alla Worker Queue

| Worker Queue (point-to-point) | Fanout Exchange (publish/subscribe) |
| ----------------------------- | ----------------------------------- |
| Un messaggio → un consumer    | Un messaggio → tutti i consumer     |
| Distribuzione round-robin     | Broadcast a tutte le code bindate   |
| Modello di bilanciamento      | Modello di notifica/eventi          |
