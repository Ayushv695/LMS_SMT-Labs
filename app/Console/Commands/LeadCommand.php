<?php

namespace App\Console\Commands;

use App\Models\Lead;
use Carbon\Carbon;
use Illuminate\Console\Command;

class LeadCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:convert-lead-to-lost';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Everyday command to find leads with status new that haven't been followed up in 7+ days and mark them as lost";

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Lead::where('status',Lead::NEW)
        ->where(function($query){
            $query->where('followed_up_at','<=', Carbon::now()->subDays(7)->toDateString());
        })
        ->orWhere(function($query){
            $query->whereNull('followed_up_at')->where('created_at','<=', Carbon::now()->subDays(7));
        })->update(['status' => Lead::LOST]);
    }
}
