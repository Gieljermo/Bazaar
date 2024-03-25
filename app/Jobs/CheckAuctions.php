<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Bid;
use App\Models\Listing;
use App\Models\Purchase;
use Carbon\Carbon;

class CheckAuctions implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {   
        $endedAuctions = Listing::Where('bid_until', '>', Carbon::now())
            ->where('ended', 0)->get();

        foreach($endedAuctions as $auction){
            $highestBid = $auction->highestBid();

            if($highestBid){
                $purchase = Purchase::create([
                    'user_id' => $highestBid->user_id,
                    'date' => Carbon::now(),
                ]);
    
                $auction->purchase_id = $purchase->id;
            }

            $auction->ended = true;
            $auction->save();
        }
    }
}
