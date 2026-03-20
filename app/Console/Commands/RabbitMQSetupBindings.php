<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class RabbitMQSetupBindings extends Command
{
    protected $signature = 'rabbitmq:setup-bindings';
    protected $description = 'Declare traitement_service_queue and bind it to the folder_events topic exchange';

    public function handle(): int
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST', 'rabbit'),
            (int) env('RABBITMQ_PORT', 5672),
            env('RABBITMQ_LOGIN', 'guest'),
            env('RABBITMQ_PASSWORD', 'guest'),
            env('RABBITMQ_VHOST', '/')
        );

        $channel = $connection->channel();

        $exchange = 'folder_events';
        $queue    = 'traitement_service_queue';

        $channel->exchange_declare($exchange, AMQPExchangeType::TOPIC, false, true, false);
        $this->info("Exchange '{$exchange}' declared.");

        $channel->queue_declare($queue, false, true, false, false);
        $this->info("Queue '{$queue}' declared.");

        $channel->queue_bind($queue, $exchange, 'folder.deleted');
        $this->info("Bound routing key 'folder.deleted' to '{$queue}'.");

        $channel->close();
        $connection->close();

        $this->info('RabbitMQ bindings setup complete.');
        return self::SUCCESS;
    }
}
