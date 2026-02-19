<?php

require __DIR__ . '/../../common/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$ip = getenv("RABBITMQ_IP");
$port = getenv("RABBITMQ_PORT");
$username = getenv("RABBITMQ_USERNAME");
$password = getenv("RABBITMQ_PASSWORD");

// crea la connessione a RabbitMQ
$connection = '';

// crea un canale per pubblicare i messaggi
$channel = '';

// dichiara l'exchange (se non usi quello di default)
$exchange_name = '';
$exchange_type = '';
$channel = '';

// oppure dichiara la coda
$queue_name = '';
$channel->queue_declare($queue_name, false, false, false, false);

// prepara il messaggio
$data = '';
$msg = '';
$routing_key = '';

// pubblica il messaggio
$channel = '';

// chiusura delle connessioni
$channel->close();
$connection->close();

?>