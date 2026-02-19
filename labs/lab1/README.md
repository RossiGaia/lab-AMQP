# Laboratorio 1 – Worker Queue con ACK automatici

## Obiettivo

Implementare un modello **point-to-point** (worker queue) utilizzando RabbitMQ e AMQP 0-9-1.

In questo scenario:

* più consumer sono collegati alla stessa coda
* ogni messaggio viene consegnato a **un solo consumer**
* la conferma di ricezione (ACK) è **automatica**

Questo modello è tipicamente utilizzato per distribuire il carico di lavoro tra più worker.

---

## Contesto Architetturale

Nel modello *worker queue*:

```
Producer → Queue → Consumer 1
                   Consumer 2
```

* Il producer invia un messaggio alla coda
* RabbitMQ lo assegna a uno solo dei consumer attivi
* Gli altri consumer non ricevono lo stesso messaggio

Anche se non viene dichiarato esplicitamente un exchange, viene utilizzato l’**exchange di default** (`""`), che instrada automaticamente i messaggi verso la queue con nome uguale alla routing key.

---

## Attività da svolgere

1. Creare una queue chiamata:

   ```
   COGNOME-queue
   ```

   con le seguenti caratteristiche:

   * `durable = false`
   * `exclusive = false`

2. Collegare **due consumer** alla stessa queue

3. Configurare i consumer con:

   * ACK automatico (`no_ack = true`)

4. Inviare un messaggio alla queue

5. Verificare che:

   * solo uno dei due consumer riceva il messaggio
   * il messaggio non venga duplicato

---

## Risultato Atteso

* Il messaggio deve essere ricevuto da un solo consumer
* Il secondo consumer deve rimanere in attesa
* La distribuzione dei messaggi deve avvenire in modalità round-robin (se vengono inviati più messaggi)

---

## Note Tecniche

* L’exchange utilizzato è quello di default (`""`)
* In questa configurazione l’ACK è automatico:

  * il broker considera il messaggio consegnato immediatamente
  * se il consumer termina in modo anomalo, il messaggio può andare perso