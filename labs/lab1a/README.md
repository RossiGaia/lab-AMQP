# Laboratorio 1a – Worker Queue con ACK manuali

## Obiettivo

Estendere il modello **worker queue** introducendo la gestione degli **ACK manuali**.

In questo laboratorio:

* più consumer sono collegati alla stessa coda
* ogni messaggio viene consegnato a **un solo consumer**
* la conferma di ricezione viene inviata **manualmente** dal consumer

L’obiettivo è comprendere il ruolo degli acknowledgment nella garanzia di affidabilità del sistema.

---

## Contesto Architetturale

Il modello rimane invariato rispetto al laboratorio precedente:

```
Producer → Queue → Consumer 1
                   Consumer 2
```

La differenza principale riguarda la gestione della conferma di ricezione.

Con ACK manuali:

* il broker considera il messaggio “in elaborazione”
* il messaggio viene rimosso dalla coda **solo dopo** la chiamata esplicita a:

```php
$msg->ack();
```

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

   * ACK automatico **disabilitato** (`no_ack = false`)

4. All’interno della callback del consumer:

   * elaborare il messaggio
   * inviare manualmente l’ACK tramite:

     ```php
     $msg->ack();
     ```

5. Inviare uno o più messaggi alla queue

---

## Risultato Atteso

* Ogni messaggio deve essere ricevuto da un solo consumer.
* Il messaggio viene rimosso dalla coda solo dopo l’invio dell’ACK manuale.
* Se un consumer termina prima di inviare l’ACK, il messaggio rimane non confermato e può essere riassegnato a un altro consumer.

Se vengono inviati più messaggi, questi verranno distribuiti tra i consumer in modalità **round-robin**, analogamente al laboratorio precedente.

---

## Differenza rispetto agli ACK automatici

| ACK automatico                                                | ACK manuale                                             |
| ------------------------------------------------------------- | ------------------------------------------------------- |
| Il messaggio viene considerato consegnato immediatamente      | Il messaggio viene confermato solo dopo `$msg->ack()`   |
| Possibile perdita del messaggio in caso di crash del consumer | Maggiore affidabilità                                   |
| Minore controllo                                              | Controllo esplicito sul completamento dell’elaborazione |

---

## Considerazioni

Gli ACK manuali sono fondamentali nei sistemi distribuiti reali, in quanto:

* migliorano l’affidabilità
* permettono il recupero in caso di crash
* evitano la perdita silenziosa dei messaggi
