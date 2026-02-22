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
$channel->exchange_declare($exchange_name, $exchange_type, false, false, false);

$data1 = 'Direct su RabbitMQ con key1!';
$msg1 = new AMQPMessage($data1);

$data2 = 'Direct su RabbitMQ con key2!';
$msg2 = new AMQPMessage($data2);

$routing_key_1 = "key1";
$routing_key_2 = "key2";
$channel->basic_publish($msg1, $exchange_name, $routing_key_1);
$channel->basic_publish($msg2, $exchange_name, $routing_key_2);

$channel->close();
$connection->close();

?>