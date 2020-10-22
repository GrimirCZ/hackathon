<?php

namespace App\Http\Controllers;

use App\Http\Resources\ConnectionResource;
use App\Models\Connection;
use Illuminate\Support\Facades\DB;
use Request;

class SearchController extends Controller
{
    public function __invoke($query)
    {
        $connections = Connection::where(DB::raw("LOWER(REPLACE(`name`, ' ', ''))"), "like", DB::raw("LOWER(REPLACE('%$query%', ' ',''))"))
            ->join("snapshots", "snapshots.connection_id", "=", "connections.id")
            ->orderByDesc("snapshots.time")
            ->select("snapshots.time as time", "snapshots.connection_id as con_id")
        ->distinct();

        return ConnectionResource::collection(
            Connection::joinSub($connections, "snp", function($join){
                $join->on("connections.id", "=", "snp.con_id");
            })->orderByDesc("snp.time")
                ->select("connections.*")
                ->get()
        );
        //
    }
}
