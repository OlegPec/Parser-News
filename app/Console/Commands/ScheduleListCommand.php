<?php

namespace App\Console\Commands;

use Cron\CronExpression;
use Illuminate\Console\Command;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleListCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'schedule:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List of the scheduled commands';

    /**
     * The schedule instance.
     *
     * @var \Illuminate\Console\Scheduling\Schedule
     */

    protected $schedule;


    public function __construct(Schedule $schedule)
    {
        $this->schedule = $schedule;
        parent::__construct();
    }


    public function handle()
    {
        $events = $this->schedule->events();
        $table = [];
        foreach ($events as $event) {
            echo $this->prepareCommandToDisplay($event->getSummaryForDisplay()) . PHP_EOL;
            $table[] = [
                'command' => $this->prepareCommandToDisplay($event->getSummaryForDisplay()),
                'expression' => $event->getExpression(),
                'next' => $this->getCommandNextRunTime($event->getExpression())->format('H:i:s Y-m-d')
            ];
        }
        $this->table(['command', 'expression', 'next time'], $table);
    }


    protected function prepareCommandToDisplay($eventCommand)
    {
        return preg_replace(
            '~^' . preg_quote('/usr/bin/php5 artisan ', '~') . '(.*)' . preg_quote(' > /dev/null 2>&1 &', '~') . '$~',
            '$1',
            $eventCommand
        );
    }


    protected function getCommandNextRunTime($eventCronExpression)
    {
        return CronExpression::factory($eventCronExpression)->getNextRunDate();
    }

}
