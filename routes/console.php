<?php

use App\Jobs\SendNotificationJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| CalmAcad Scheduler
|--------------------------------------------------------------------------
|
| Laravel 11 mendaftarkan jadwal cron langsung di sini (tidak lagi lewat
| app/Console/Kernel.php). Pastikan satu entri cron berikut sudah aktif
| di server produksi supaya scheduler ini benar-benar jalan tiap menit:
|
|   * * * * * cd /path/to/calmacad && php artisan schedule:run >> /dev/null 2>&1
|
| Saat development lokal, jalankan: php artisan schedule:work
|
*/

// Kirim notifikasi (reminder, kritis, broadcast) yang sudah jatuh tempo, setiap jam
Schedule::job(new SendNotificationJob)->hourly();

// Bersihkan data konsultasi guest yang lebih dari 30 hari (privasi tamu), tiap tengah malam
Schedule::command('calmacad:cleanup-guest')->daily();