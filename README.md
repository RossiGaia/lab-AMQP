# Laboratorio AMQP

## Messaging Systems e Modello Publish/Subscribe

Questo repository contiene il materiale e i template relativi al laboratorio su **Messaging Systems** e protocollo **AMQP**, con utilizzo di **RabbitMQ** e della libreria `php-amqplib`.

L’obiettivo del laboratorio è comprendere e sperimentare:

* comunicazione asincrona tramite broker
* modello point-to-point (queue)
* modello publish/subscribe
* utilizzo di exchange *fanout*, *direct* e *topic*
* gestione di publisher e consumer tramite AMQP

---

## Requisiti

Per eseguire i laboratori è necessario avere installato:

* **PHP**
* **Composer**

Verificare l’installazione con:

```bash
php -v
composer -v
```

In caso non siano installati:
```bash
sudo apt install php composer
```

---

## Installazione e configurazione

### 1. Clonare la repository

```bash
git clone https://github.com/RossiGaia/lab-AMQP
cd lab-AMQP
```

---

### 2. Installare le dipendenze

La libreria `php-amqplib` viene installata tramite Composer:

```bash
cd common
composer install
```

---

### 3. Configurare le variabili di ambiente

Prima di eseguire i laboratori, è necessario esportare le variabili di ambiente per la connessione a RabbitMQ:

```bash
export RABBITMQ_PASSWORD=""
export RABBITMQ_IP=""
export RABBITMQ_PORT=""
export RABBITMQ_USERNAME=""
```

> I valori delle variabili verranno comunicati durante il laboratorio.

---

## Snippet di codice base (php-amqplib)

Questi esempi mostrano le operazioni fondamentali per interagire con RabbitMQ tramite la libreria `php-amqplib`.
Possono essere riutilizzati come base per tutti i laboratori.

---

### Connessione e creazione di un channel

```php
$connection = new AMQPStreamConnection(
    $ip,
    $port,
    $username,
    $password
);

$channel = $connection->channel();
```

* La connessione TCP verso il broker è costosa
* I **channel** sono connessioni leggere usate per pubblicare e consumare messaggi

---

### Dichiarazione di un exchange

```php
$channel->exchange_declare(
    $exchange_name,
    $exchange_type,
    false,
    false,
    false
);
```

Tipi di exchange utilizzati nei laboratori:

* `fanout` → broadcast
* `direct` → routing per match esatto
* `topic` → routing gerarchico con wildcard

---

### Pubblicazione di un messaggio

```php
$data = "Hello AMQP 0-9-1";
$msg = new AMQPMessage($data);

$channel->basic_publish(
    $msg,
    $exchange_name,
    $routing_key
);
```

Le proprietà del messaggio possono includere:

* priorità
* persistenza
* delivery mode

---

### Creazione di una queue e binding

```php
list($queue_name, ,) = $channel->queue_declare(
    "",
    false,
    false,
    true,
    false
);

$channel->queue_bind(
    $queue_name,
    $exchange_name,
    $routing_key
);
```

* Una queue può essere creata come esclusiva per un consumer
* Il binding collega la queue a un exchange

---

### Callback per la ricezione dei messaggi

```php
$callback = function (AMQPMessage $msg) {
    echo "Received: " . $msg->getBody() . "\n";
};
```

---

### Registrazione di un consumer

```php
$channel->basic_consume(
    $queue_name,
    '',
    false,
    true,
    false,
    false,
    $callback
);
```

Questa funzione registra il consumer, ma non avvia ancora l’ascolto.

---

### Ciclo di ascolto

```php
try {
    while (true) {
        $channel->wait();
    }
} catch (\Throwable $exception) {
    echo $exception->getMessage();
}
```

Il consumer rimane in ascolto continuo e la callback viene eseguita alla ricezione di un messaggio.

---

### ACK manuale (opzionale)

Nei laboratori avanzati è possibile confermare manualmente la ricezione:

```php
$msg->ack();
```

Questo garantisce che il messaggio venga rimosso dalla queue solo dopo l’elaborazione.

---

### Chiusura della connessione

Al termine dell’esecuzione:

```php
$channel->close();
$connection->close();
```

---

## Struttura dei laboratori

Ogni laboratorio contiene:

* file template da completare
* esercizi progressivi
* configurazioni specifiche di exchange e queue

I laboratori coprono:

1. Worker Queue con ACK automatici
2. Worker Queue con ACK manuali
3. Fanout Exchange
4. Direct Exchange
5. Topic Exchange

---

## Esecuzione degli script

Per eseguire uno script PHP:

```bash
php nome_file.php
```

Assicurarsi di aver configurato correttamente le variabili di ambiente prima dell’esecuzione.

---

## Note

* I laboratori utilizzano **AMQP 0-9-1**
* RabbitMQ funge da message broker
* Alcuni esercizi sfruttano l’exchange di default (`""`)
* In caso di errori di connessione, verificare IP, porta e credenziali
