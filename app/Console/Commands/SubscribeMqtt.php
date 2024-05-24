<?php

namespace App\Console\Commands;

use App\Models\Desiccator;
use App\Models\Robot;
use App\Models\Oven;
use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;

class SubscribeMqtt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sub-mqtt';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscribe MQTT';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mqtt = MQTT::connection();

        /*
        /robot/data
        {
        "pick_oven": 0,
        "put_oven": 0,
        "pick_desiccator": 0,
        "put_desiccator": 0,
        "pick_count": 0,
        "stop": 1
        }
        */
        $mqtt->subscribe('/robot/data', function (string $topic, string $message) {
            echo sprintf('Received message on topic [%s]: %s', $topic, $message);
            $robot = json_decode($message, true);

            Robot::create($robot);
        });

        /*
        /desiccator/data
        {
        "limit_switches": [
            0,
            0,
            0,
            0
        ],
        "cylinder_top": 0,
        "cylinder_bottom": 1,
        "safety_curtain": 1,
        "temperature": null,
        "humidity": null,
        "alarm": 0,
        "gas": 0
        }
        */
        $mqtt->subscribe('/desiccator/data', function (string $topic, string $message) {
            echo sprintf('Received message on topic [%s]: %s', $topic, $message);
            $desiccator = json_decode($message, true);
            if (isset($desiccator['limit_switches'])) {
                foreach ($desiccator['limit_switches'] as $k => $l) {
                    $desiccator['switch' . ($k + 1)] = $l;
                }
            }
            Desiccator::create($desiccator);
        });

        /*
        /desiccator/command
        alarm_off
        */
        // $mqtt->subscribe('/desiccator/command', function (string $topic, string $message) {
        //     echo sprintf('Received message on topic [%s]: %s', $topic, $message);
        // });


        $mqtt->subscribe('/oven/data', function (string $topic, string $message) {
            echo sprintf('Received message on topic [%s]: %s', $topic, $message);
            $oven = json_decode($message, true);

            Oven::create($oven);
        });

        $mqtt->loop(true);
        return Command::SUCCESS;
    }
}
