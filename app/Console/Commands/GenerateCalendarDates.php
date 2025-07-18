<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class GenerateCalendarDates extends Command
{
    protected $signature = 'generate:calendar-dates {start_date} {end_date}';
    protected $description = 'Generate calendar dates between two dates into calendar_dates table';

    public function handle()
    {
        $startDate = $this->argument('start_date');
        $endDate = $this->argument('end_date');

        $dates = [];
        $current = strtotime($startDate);
        $end = strtotime($endDate);

        while ($current <= $end) {
            $dates[] = ['tgl' => date('Y-m-d', $current)];
            $current = strtotime('+1 day', $current);
        }

        DB::table('calendar_dates')->insertOrIgnore($dates);

        $this->info(count($dates) . ' dates inserted into calendar_dates.');
    }
}
