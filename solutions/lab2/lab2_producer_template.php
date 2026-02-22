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

$exchange_name = "ROSSI-exchange-fanout";
$exchange_type = 'fanout';
$channel->exchange_declare($exchange_name, $exchange_type, false, false, false);

$data = 'Fanout su RabbitMQ!';
$msg = new AMQPMessage($data);

$channel->basic_publish($msg, $exchange_name);

$channel->close();
$connection->close();

?>