<?php

namespace App\Console\Commands;

use App\Services\MQTTService;
use Illuminate\Console\Command;

class TestMqtt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-mqtt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check able to send MQTT';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        MQTTService::sendTest();
    }
}
