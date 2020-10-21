<?php

namespace App\Imports;

use App\Models\Connection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WaitForImport implements ToCollection, WithHeadingRow
{
    public $logger;

    function __construct($logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            $id1 = "S-" . $row['line1'] . "-" . $row['service1'];
            $awaits = Connection::where("identifier", "=", $id1)->first();


            $id2 = "S-" . $row['line1'] . "-" . $row['service1'];
            $awaited_for = Connection::where("identifier", "=", $id2)->first();

            if($awaits != null && $awaited_for != null &&
                $awaits->whereHas("waits_for", function($q) use ($awaited_for){ $q->where("awaited_for_id", "=", $awaited_for->id); })->count() == 0
            ){

                $awaits->waits_for()->attach($awaited_for, [
                    'waits_for_minutes' => $row['waits_for'],
                    'waits_in' => $row['stop'],
                    'created_at' => DB::raw("CURRENT_TIMESTAMP"),
                    'updated_at' => DB::raw("CURRENT_TIMESTAMP"),
                ]);
            } else if($awaits == null && $awaited_for != null){
                $this->logger->warn($id1);
            } else if($awaits != null && $awaited_for == null){
                $this->logger->warn($id2);
            } else if($awaits == null && $awaited_for == null){
                $this->logger->warn($id1);
                $this->logger->warn($id2);
            }

        }
        //
    }
}
