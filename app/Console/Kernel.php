<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Setting; 

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
 
        $bkt=explode(",",Setting::getconfig('config_backup_time'));
        /*kiểm tra điều kiện backup 
        - lấy thời gian hiện tại để so sánh thời gian đặt lịch backup
        - cho khoảng chênh là 5' để có thể backup khi task schedular windown gọi 3' lần.    
        */
        $schedule->command('db:backup')->when(function () use ($bkt) {
            //https://www.php.net/manual/en/function.getdate.php
            $today = getdate();
            $phut=$today['minutes'];
            $gio=$today['hours'];
            $thu=$today['wday'];
            $ngay=$today['mday'];
            if($bkt[0]=='khongbk'){return false;}
            else/*mỗi giờ*/
            if($bkt[0]=='hourlyAt'){
                $pht=$phut;//phút hiện tại
                $pbk=$bkt[1];// phút backup
                if($pht>=$pbk && $pht<=($pbk+5)) return true;
                else return false;
            }
            else/*mỗi ngày*/
            if($bkt[0]=='dailyAt'){
                $pht=$gio*60+$phut;//phút hiện tại
                $pbk=$bkt[1]*60;// phút backup
                if($pht>=$pbk && $pht<=($pbk+5)) return true;
                else return false;
            }
            else/*mỗi tuần*/
            if($bkt[0]=='weeklyOn'){
                if($bkt[1]==7)$bkt[1]=0;
                if($thu!=$bkt[1]) return false;
                else{
                    $pht=$gio*60+$phut;//phút hiện tại
                    $pbk=$bkt[2]*60;// phút backup
                    if($pht>=$pbk && $pht<=($pbk+5)) return true;
                    else return false;
                }
            }
            else/*mỗi tháng*/
            if($bkt[0]=='monthlyOn'){
                if($ngay!=$bkt[1]) return false;
                else{
                    $pht=$gio*60+$phut;//phút hiện tại
                    $pbk=$bkt[2]*60;// phút backup
                    if($pht>=$pbk && $pht<=($pbk+5)) return true;
                    else return false;
                }
            }
           
        });
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
