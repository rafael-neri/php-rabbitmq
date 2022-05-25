<?php

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use flight\Engine;

require __DIR__ . '/../vendor/autoload.php';

$app = new Engine();

$app->route('GET /producer', function(){

    try {
        $connection = new AMQPStreamConnection(
            RABBITMQ_DEFAULT_HOST,
            RABBITMQ_DEFAULT_PORT,
            RABBITMQ_DEFAULT_USER,
            RABBITMQ_DEFAULT_PASS
        );

        $channel = $connection->channel();

        $channel->exchange_declare('testMsg', 'direct');
        $channel->queue_declare('monkey');

        $channel->queue_bind('monkey', 'testMsg', 'sendTest');

        $msg = new AMQPMessage('Coceira de Macaco');
        $channel->basic_publish($msg, 'testMsg', 'sendTest');

        echo "Sucesso!!";

    } catch (Exception $e) {
        dd($e->getMessage());
    }

});

$app->route('GET /consumer', function(){

    try {
        $connection = new AMQPStreamConnection(
            RABBITMQ_DEFAULT_HOST,
            RABBITMQ_DEFAULT_PORT,
            RABBITMQ_DEFAULT_USER,
            RABBITMQ_DEFAULT_PASS
        );

        $channel = $connection->channel();

        // $channel->queue_declare('monkey', false, false, false, false);

        echo 'Carregando mensagens....<br/>';

        $callback = function ($msg) {
            echo '<b>Mensagem recebida:</b>' . $msg->body . '<br/>';
            ob_flush();
        };

        $channel->basic_consume('monkey', '', false, true, false, false, $callback);

        while ($channel->is_open()) {
            $channel->wait(null, false, 30);
        }

        echo 'Sucesso!!';

        $channel->close();
        $connection->close();

    } catch (Exception $e) {
        dd($e->getMessage());
    }

});

Flight::start();