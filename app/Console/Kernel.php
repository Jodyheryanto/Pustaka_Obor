<?php

namespace App\Console;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DB;
use App\Models\JualBuku;
use App\Models\BatasanWaktu;
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
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            //Set batasan royalti otomatis
            date_default_timezone_set("Asia/Bangkok");
$now = new DateTime();
            // $batasan = BatasanWaktu::where('id', 1)->first();
            // $batasan2 = BatasanWaktu::where('id', 2)->first();
            // if(date('Y-m-d', strtotime($now->format('Y-m-d'))) > date('Y-m-d', strtotime($batasan->tanggal_selesai))){
            //     JualBuku::where('status_royalti', 0)
            //     ->where('updated_at', '>=', date('Y-m-d', strtotime($batasan->tanggal_mulai)))->where('updated_at', '<=', date('Y-m-d', strtotime($batasan->tanggal_selesai)))
            //     ->update(['status_royalti' => 1]);
            // }elseif(date('Y-m-d', strtotime($now->format('Y-m-d'))) > strtotime($batasan2->tanggal_selesai)){
            //     JualBuku::where('status_royalti', 1)
            //     ->update(['status_royalti' => 2]);
            //     BatasanWaktu::where('id', 1)
            //     ->update(['tanggal_mulai' => date('Y-m-d', strtotime("+6 months", strtotime($batasan->tanggal_mulai))), 'tanggal_selesai' => date('Y-m-d', strtotime("+6 months", strtotime($batasan->tanggal_selesai)))]);
            //     BatasanWaktu::where('id', 2)
            //     ->update(['tanggal_mulai' => date('Y-m-d', strtotime("+6 months", strtotime($batasan2->tanggal_mulai))), 'tanggal_selesai' => date('Y-m-d', strtotime("+6 months", strtotime($batasan2->tanggal_selesai)))]);
            // }

            //Backup database otomatis
            $filename = "backup-" . date('Y-m-d', strtotime($now->format('Y-m-d'))) . ".gz";
            $command = "mysqldump --opt --databases ".env('DB_DATABASE')." -h ".env('DB_HOST')." -u " . env('DB_USERNAME') ." -p'" . env('DB_PASSWORD') . "' | gzip > " . storage_path() . "/app/" . $filename;
            $returnVar = NULL;
            $output  = NULL;
            exec($command, $output, $returnVar);
        })->daily();
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
