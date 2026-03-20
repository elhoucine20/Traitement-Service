<?php

namespace App\Jobs;

use App\Services\TraitementService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Throwable;
use VladimirYuldashev\LaravelQueueRabbitMQ\Queue\Jobs\RabbitMQJob;

class SyncDossierJob extends RabbitMQJob
{
    public function fire(): void
    {
        $traitementService = $this->container->make(TraitementService::class);
        try {
            $payload = json_decode($this->getRawBody(), true);
            $routingKey = $this->getRabbitMQMessage()->delivery_info['routing_key'] ?? '';

            match($routingKey) {
                'folder.deleted' => $traitementService->deleteByDossierId($payload['dossier_id']),
                default => Log::warning("Traitement service received an event with unknown routing key: $routingKey"),
            };

            $this->delete();
        } catch (Throwable $e) {
            Log::error('SyncDossierJob fire() failed', [
                'error' => $e->getMessage(),
                'file'  => $e->getFile() . ':' . $e->getLine(),
                'raw'   => $this->getRawBody(),
            ]);
            throw $e;
        }
    }

    public function payload(): array
    {
        return [
            'uuid'        => Str::uuid()->toString(),
            'displayName' => self::class,
            'job'         => self::class,
            'data'        => [],
        ];
    }

    public function getName(): string
    {
        return 'SyncDossierJob';
    }
}
