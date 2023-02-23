<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'database:backup';

    /**
     * The console command description.
     *
     * @var string
     */

    protected $description = 'Take backup of database and save it on storage folder';

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
     * @return int
     */

    public function handle()
    {
        // which mysqldump
        $randomId = Str::random(8);
        $todayDate = Carbon::now()->format('Y-m-d');
        $todayTime =  Carbon::now()->format('H:i:s');
        $path = Storage::disk('backup')->path('');

        $databasePassword = env('DB_PASSWORD');
        $filename = $randomId . "--backup--" . $todayDate . "--" . $todayTime . ".sql";

        if ($databasePassword != '') {
            $command = "" . env('DUMP_PATH') . " --user=" . env('DB_USERNAME') . " --password='$databasePassword'" . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . $path . $filename;
        } else {
            $command = "" . env('DUMP_PATH') . " --user=" . env('DB_USERNAME') . " --password=$databasePassword" . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  > " . $path . $filename;
        }

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        exec($command);
    }
}
