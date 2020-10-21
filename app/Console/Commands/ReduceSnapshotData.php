<?php

namespace App\Console\Commands;

use App\Models\Connection;
use App\Models\Delay;
use App\Models\Snapshot;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ReduceSnapshotData extends Command
{
    protected $signature = 'reduce-data';

    protected $description = 'Reduce snapshot data to 5 minute aggregates';

    public function handle()
    {
        Snapshot::whereNull("delay")->where("is_old", true)->delete();

        while(Snapshot::orderBy("time")->first()->is_old){
            DB::transaction(function(){
                $snp = Snapshot::orderBy("time")->first();

                $time_frame_start = new Carbon($snp->time);

                $min_start = floor($time_frame_start->minute / 5) * 5; // round to 5
                $hour_start = $time_frame_start->hour;
                $time_frame_start->setMinutes($min_start);
                $time_frame_start->setSeconds(0);
                $time_frame_start->setMicroseconds(0);

                $min_end = ($min_start + 5) % 60;
                if($min_end < $min_start)
                    $hour_start++;

                $time_frame_end = new Carbon($snp->time);
                $time_frame_end->setHours($hour_start);
                $time_frame_end->setMinutes($min_end);
                $time_frame_end->setSeconds(0);
                $time_frame_end->setMicroseconds(0);

                // do not reduce if in future
                if($time_frame_end >= Carbon::now()){
                    return;
                }

//                $this->info("Reducing: " . $snp->connection_id . " from: $time_frame_start to: $time_frame_end");

                $delay = Snapshot::where("time", ">=", $time_frame_start)
                    ->where("time", "<", $time_frame_end)
                    ->where("connection_id", $snp->connection_id)
                    ->avg("delay");

                Delay::create([
                    'delay' => $delay,
                    'start' => $time_frame_start,
                    'end' => $time_frame_end,
                    'connection_id' => $snp->connection_id
                ]);

                Snapshot::where("time", ">=", $time_frame_start)
                    ->where("time", "<", $time_frame_end)
                    ->where("connection_id", $snp->connection_id)
                    ->delete();
            });
        }
        //
    }
}
