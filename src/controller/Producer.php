<?php

namespace Src\controller;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Src\app\LorenIpsum;
use Exception;

class Producer
{
    public function send()
    {
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
        
        if(!$channel->is_open()) {
            throw new Exception('Não foi possível abrir o canal');
        }
        
        $channel->exchange_declare(MENSAGERIA_EXCHANGE_NAME, MENSAGERIA_EXCHANGE_TYPE);
        $channel->queue_declare(MENSAGERIA_QUEUE_NAME);
        $channel->queue_bind(MENSAGERIA_QUEUE_NAME, MENSAGERIA_EXCHANGE_NAME, MENSAGERIA_ROUTING_KEY);

        $text_message = LorenIpsum::get();
        $message = new AMQPMessage($text_message);

        $channel->basic_publish($message, MENSAGERIA_EXCHANGE_NAME, MENSAGERIA_ROUTING_KEY);

        echo "<b>Mensagem Enviada:</b>";
        echo "<br  />";
        echo $text_message;

        $channel->close();
        $connection->close();
    }
}
