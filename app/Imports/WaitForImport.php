<?php

namespace App\Imports;

use App\Models\Connection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use const App\Autobus;
use const App\Vlak;

class WaitForImport implements ToCollection, WithHeadingRow
{
    public $logger;

    function __construct($logger)
    {
        $this->logger = $logger;
    }

    function get_train_id($line)
    {
        return preg_replace("/([a-zA-Z]+)(\d+)/", "K-$2", $line);
    }


    function get_data_for_connection($identifier, $type)
    {
        $res = Connection::where("identifier", "=", $identifier)->first();

        if($res != null){
            return $res;
        }

        $res = Http::get("http://tabule.oredo.cz/idspublicservices/api/servicedetail?id=$identifier")
            ->throw()
            ->json();

        if(!isset($res['vehicleType'])){ // check if data present
            return null;
        }

        $this->logger->info("creating " . $identifier);

        sleep(rand(0, 4));

        $con_data = [
            'identifier' => $identifier,
            'vehicle_type' => $res['vehicleType'],
            'operator' => $res['operator']
        ];

        if($type == "BUS"){
            $con_data['line_number'] = $res['lineNumber'];
            $con_data['service_number'] = $res['serviceNumber'];
            $con_data['name'] = $res['lineNumber'] . "/" . $res['serviceNumber'];
        } else if($type == "Vlak"){
            $con_data['train_number'] = $res['trainNumber'];
            $con_data['name'] = $res['trainKind'] . " " . $res['trainNumber'];
        }

        $con_data['from'] = $res['stations'][0]['name'];
        $con_data['to'] = $res['stations'][count($res['stations']) - 1]['name'];

        $res = Connection::create($con_data);
        return $res;
    }

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        foreach($rows as $row){
            DB::transaction(function() use ($row){


                $id1 = "S-" . $row['line1'] . "-" . $row['service1'];

                if($row['vehicletype'] == "BUS"){
                    $id2 = "S-" . $row['line2'] . "-" . $row['service2'];
                } else{
                    $id2 = $this->get_train_id($row['line2']);
                }

                if($id1 == $id2){
                    $this->logger->info("id1 = id2 (" . $id2 . ")");
                    return;
                }

                $this->logger->info("id1: " . $id1 . " id2: " . $id2);


                $awaits = $this->get_data_for_connection($id1, "BUS");

                $awaited_for = $this->get_data_for_connection($id2, $row['vehicletype']);

                if($awaits != null && $awaited_for != null &&
                    $awaits->whereHas("waits_for", function($q) use ($awaited_for){ $q->where("awaited_for_id", "=", $awaited_for->id); })->count() == 0
                ){

                    $awaits->waits_for()->attach($awaited_for, [
                        'minutes' => $row['minutes'],
                        'station' => $row['stop'],
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
            });
        }
        //
    }
}
