<?php

namespace App\Console\Commands;

use App\Models\Machine;
use App\Models\Status;
use App\Models\StatusRecord;
use App\Models\User;
use Illuminate\Console\Command;

class CreateStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $machine = Machine::with('segment')->with('machine_type')->where('active', true)->first();
        $data['machine_code'] = $machine->code;
        $data['segment_code'] = $machine->segment->code;
        $data['machine_type'] = $machine->machine_type->code;

        $status = Status::where('active', true)->first();
        $data['status_id'] = $status->id;
        
        $user = User::where('username', 'admin')->first();
        $data['employee_id'] = $user->id;
        $data['employee_code'] = $user->username;
        $data['employee_name'] = $user->name;
        $data['origin'] = WEB;

        $data = StatusRecord::create($data);
    }
}
