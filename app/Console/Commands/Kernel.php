<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Jadwal kamu
        $schedule->call(function () {
            \App\Models\Post::where('status', 'private')
                ->whereNotNull('scheduled_at')
                ->where('scheduled_at', '<=', now())
                ->update(['status' => 'public']);
        })->everyMinute();
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
