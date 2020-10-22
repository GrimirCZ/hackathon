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
            ->orderByDesc(DB::raw("max(snapshots.time)"))
            ->select(DB::raw("max(snapshots.time) as time"), "connections.id as con_id")
            ->groupBy("connections.id")
            ->distinct();

        $connections_with_snapshot = Connection::joinSub($connections, "snp", function($join){
            $join->on("connections.id", "=", "snp.con_id");
        })->orderByDesc("snp.time")
            ->select("connections.*", "snp.time as time")
            ->distinct();

        $connections_without_snapshot = Connection::where(DB::raw("LOWER(REPLACE(`name`, ' ', ''))"), "like", DB::raw("LOWER(REPLACE('%$query%', ' ',''))"))
            ->joinSub($connections, "snp", function($join){
                $join->on("connections.id", "!=", "snp.con_id");
            }, "outer")->orderByDesc("snp.time")
            ->select("connections.*", DB::raw("0 as time"))
            ->distinct();

        return ConnectionResource::collection(
            $connections_with_snapshot
                ->union($connections_without_snapshot)
                ->orderByDesc("time")
                ->get()
        );

        //
    }
}