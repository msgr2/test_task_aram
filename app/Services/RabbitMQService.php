<?php

namespace App\Services;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitMQService
{
    public function publish($message)
    {
        $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $channel = $connection->channel();
        $channel->exchange_declare('campaign_exchange', 'direct', false, false, false);
        $channel->queue_declare('campaign_queue', false, false, false, false);
        $channel->queue_bind('campaign_queue', 'campaign_exchange', 'campaign_key');
        $msg = new AMQPMessage($message);
        $channel->basic_publish($msg, 'campaign_exchange', 'campaign_key');
        echo " [x] Sent $message to campaign_exchange / campaign_queue.\n";
        $channel->close();
        $connection->close();
    }
    public function consume()
    {
        $connection = new AMQPStreamConnection(env('MQ_HOST'), env('MQ_PORT'), env('MQ_USER'), env('MQ_PASS'), env('MQ_VHOST'));
        $channel = $connection->channel();
        $callback = function ($msg) {
            echo ' [x] Received ', $msg->body, "\n";
        };
        $channel->queue_declare('campaign_queue', false, false, false, false);
        $channel->basic_consume('campaign_queue', '', false, true, false, false, $callback);
        echo 'Waiting for new message on campaign_queue', " \n";
        while ($channel->is_consuming()) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }
}
