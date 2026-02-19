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

// crea un canale per consumare i messaggi
$channel = '';

// dichiara l'exchange
$exchange_name = '';
$exchange_type = '';
$channel = '';

// dichiara la coda
list($queue_name, ,) = '';

// dichiara il binding
$channel = '';

// crea la funzione di callback per stampare i messaggi ricevuti
$callback = function () {

};

// dichiara il consumer
$channel = '';

// attendi i messaggi
try {
    while(true){
        $channel = '';
    }

} catch (\Throwable $exception) {
    echo $exception->getMessage();
}

// chiusura delle connessioni
$channel->close();
$connection->close();

?>