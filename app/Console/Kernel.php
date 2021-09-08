<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->command('bdmo:cron')
            ->hourly();
        $schedule->command('fuelsupply:cron')
            ->hourly();
        $schedule->command('coalexpedition:cron')
            ->hourly();
        $schedule->command('listcenterresult:cron')
            ->hourly();
        $schedule->command('listsupervisor:cron')
            ->hourly();
        $schedule->command('listoperator:cron')
            ->hourly();
        $schedule->command('listfactor:cron')
            ->hourly();
        $schedule->command('listshift:cron')
            ->hourly();
        $schedule->command('listmeasure:cron')
            ->hourly();
        $schedule->command('listobjectimplement:cron')
            ->hourly();
        $schedule->command('listoperation:cron')
            ->hourly();
        $schedule->command('listprovider:cron')
            ->hourly();
        $schedule->command('listclient:cron')
            ->hourly();
        $schedule->command('listproduct:cron')
            ->hourly();
        $schedule->command('objectnotefuellocal:cron')
            ->hourly();
        $schedule->command('pointobject:cron')
            ->hourly();
        $schedule->command('objectgroup:cron')
            ->hourly();
        $schedule->command('import:harvests')
            ->hourly();
        $schedule->command('import:registrations')
            ->hourly();
        $schedule->command('import:transport')
            ->hourly();
        $schedule->command('import:operations')
            ->hourly();
        $schedule->command('import:transportnote')
            ->hourly();
        $schedule->command('convert:dateharvests')
            ->hourly();
        $schedule->command('import:croci')
            ->hourly();
        $schedule->command('update:employees')
            ->hourly();
        $schedule->command('check:employees')
            ->hourly();
        $schedule->command('check:ldap')
            ->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
