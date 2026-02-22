<?php

require __DIR__ . '/../../common/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$ip = getenv("RABBITMQ_IP");
$port = getenv("RABBITMQ_PORT");
$username = getenv("RABBITMQ_USERNAME");
$password = getenv("RABBITMQ_PASSWORD");

$connection = new AMQPStreamConnection($ip, $port, $username, $password);

$channel = $connection->channel();

$exchange_name = "ROSSI-exchange-direct";
$exchange_type = 'direct';
$channel = '';

list($queue_name, ,) = $channel->queue_declare("",false, false, true, false);

$channel->queue_bind($queue_name, $exchange_name, "key1");

$callback = function (AMQPMessage $msg) {
    echo "Ricevuto: " . $msg->getBody() . "\n";
};

$channel->basic_consume($queue_name, '', false, true, false, false, $callback);

try {
    while(true){
        $channel->wait();
    }

} catch (\Throwable $exception) {
    echo $exception->getMessage();
}

$channel->close();
$connection->close();

?>