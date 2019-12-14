<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Task;

class RunTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'runtask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'A simple command to run a taskS';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $task = new Task();
        $task->task_name = "Created a task";
        $task->save();
    }
}
