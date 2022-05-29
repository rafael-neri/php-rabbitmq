<?php

namespace Src\controller;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use Exception;

class Consumer
{
    public function receive() {
        $connection = new AMQPStreamConnection(
            RABBITMQ_DEFAULT_HOST,
            RABBITMQ_DEFAULT_PORT,
            RABBITMQ_DEFAULT_USER,
            RABBITMQ_DEFAULT_PASS
        );

        if (!$connection->isConnected()) {
            throw new Exception('Não foi possível conectar ao RabbitMQ');
        }

        $channel = $connection->channel();

        if (!$channel->is_open()) {
            throw new Exception('Não foi possível abrir o canal');
        }

        $channel->queue_declare(MENSAGERIA_QUEUE_NAME);

        echo "<b>Carregando mensagens....</b>";

        $total = 0;

        $callback = function ($message) use(&$total) {
            $total++;
            
            echo "<br /><br />";
            echo "<b>Mensagem recebida:</b> {$message->body} <br /><br />";
            ob_flush();
        };

        $channel->basic_consume(
            MENSAGERIA_QUEUE_NAME,
            '', 
            false, 
            true, 
            false, 
            false, 
            $callback
        );

        while ($channel->is_open()) {
            try {
                $channel->wait(null, false, MENSAGERIA_QUEUE_TIMEOUT);
            } catch (Exception $e) {
                break;
            }
        }

        echo "<br /><br />";
        echo "<b>Consumidos {$total} mensagens</b>";

        $channel->close();
        $connection->close();
    } 
}
