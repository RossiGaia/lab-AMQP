# Laboratorio 3 – Direct Exchange (Routing selettivo)

## Obiettivo

Implementare un modello **publish/subscribe con routing selettivo** utilizzando un **direct exchange** in RabbitMQ.

In questo laboratorio:

* un publisher invia messaggi a un exchange
* l’exchange inoltra il messaggio **solo** alle code che hanno un binding con chiave corrispondente
* consumer diversi ricevono messaggi diversi in base alla *binding key*

---

## Contesto Architetturale

Nel direct exchange il routing avviene per corrispondenza esatta tra:

* **routing key** (usata dal publisher in pubblicazione)
* **binding key** (usata nel binding tra queue ed exchange)

Schema:

```
Publisher → Direct Exchange → Queue (binding: key1) → Consumer 1
                         ↘→ Queue (binding: key2) → Consumer 2
```

---

## Direct Exchange

Un exchange **direct**:

* inoltra un messaggio a una queue se `routing_key == binding_key`
* permette routing deterministico e semplice
* è adatto a scenari di instradamento per categoria, tipo, severità, ecc.

---

## Attività da svolgere

1. Creare un exchange chiamato:

   ```
   COGNOME-exchange-direct
   ```

   con le seguenti caratteristiche:

   * `type = direct`
   * `durable = false`

2. Creare due queue (una per ciascun consumer), non durable e non exclusive.

3. Creare i binding tra exchange e queue:

   * Consumer 1: binding key `key1`
   * Consumer 2: binding key `key2`

4. Avviare due consumer, ciascuno in ascolto sulla propria queue.

5. Pubblicare messaggi sull’exchange usando routing key diverse:

   * un messaggio con routing key `key1`
   * un messaggio con routing key `key2`

---

## Risultato Atteso

* Il consumer collegato alla queue con binding key `key1` deve ricevere solo i messaggi pubblicati con routing key `key1`.
* Il consumer collegato alla queue con binding key `key2` deve ricevere solo i messaggi pubblicati con routing key `key2`.
* I messaggi non devono essere duplicati tra consumer, a meno di binding multipli espliciti.

Se vengono inviati più messaggi con la stessa routing key, verranno tutti consegnati alla queue corrispondente, mantenendo l’ordine nella singola coda.

---

## Differenza rispetto al Fanout Exchange

| Fanout Exchange                            | Direct Exchange                                                          |
| ------------------------------------------ | ------------------------------------------------------------------------ |
| Broadcast: inoltra a tutte le code bindate | Routing selettivo: inoltra solo alle code con binding key corrispondente |
| Ignora la routing key                      | Usa routing key e binding key                                            |
| Utile per notifiche globali                | Utile per categorizzazione e instradamento                               |

---

## Considerazioni

Il direct exchange introduce un controllo esplicito su *chi* deve ricevere un messaggio, senza che il publisher conosca direttamente i consumer.

Questo pattern è spesso usato per:

* routing per livello di log (info/warn/error)
* eventi per tipo (order.created, order.cancelled, ecc. con direct semplice)
* separazione di flussi di lavoro indipendenti
