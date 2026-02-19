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

## Struttura dei laboratori

Ogni laboratorio contiene:

* file template da completare
* README con l'esercizio da completare

I laboratori coprono:

1. Worker Queue (point-to-point)
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
