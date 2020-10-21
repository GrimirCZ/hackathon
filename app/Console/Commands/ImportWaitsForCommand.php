<?php

namespace App\Console\Commands;

use App\Imports\WaitForImport;
use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class ImportWaitsForCommand extends Command
{
    protected $signature = 'import:waits-for';

    protected $description = 'Command description';

    public function handle()
    {
        Excel::import(new WaitForImport($this), storage_path() . '/waits.csv', null, \Maatwebsite\Excel\Excel::CSV);
        //
    }
}
