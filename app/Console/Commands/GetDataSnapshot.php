<?php

namespace App\Console\Commands;

use App\Models\Connection;
use App\Models\Snapshot;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use const App\Autobus;
use const App\Vlak;

class GetDataSnapshot extends Command
{
    protected $signature = 'get:data-snapshot';

    protected $description = 'Get data snapshot from OREDO';

    private function make_datetime($time)
    {
        return date("Y-m-d") . " " . $time;
    }

    public function handle()
    {
        Snapshot::query()->update([
            'is_old' => true
        ]);

        $res = collect(Http::get("https://tabule.oredo.cz/idspublicservices/api/service/position")
            ->throw()
            ->json());

        foreach($res as $row){
            $con_data = [
                'name' => $row['name'],
                'vehicle_type' => $row['vehicleType'],
                'from' => $row['dep'],
                'to' => $row['dest'],
                'operator' => $row['operator']
            ];

            if($row['vehicleType'] == Autobus){
                $con_data['line_number'] = $row['lineNumber'];
                $con_data['service_number'] = $row['serviceNumber'];
            } else if($row['vehicleType'] == Vlak){
                $con_data['train_number'] = $row['trainNumber'];
            }

            $con = Connection::firstOrCreate(['identifier' => $row['id']], $con_data);

            Snapshot::create([
                'lat' => $row['lat'],
                'lon' => $row['lon'],

                'time' => $this->make_datetime($row['time']),
                'delay' => $row['delay'] ?? null,

                'depart_time' => $this->make_datetime($row['depTime']),
                'dest_time' => $this->make_datetime($row['destTime']),

                'is_old' => false,

                'connection_id' => $con->id
            ]);
        }
        //
    }
}
