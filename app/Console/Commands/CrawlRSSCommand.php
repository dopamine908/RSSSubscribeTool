<?php

namespace App\Console\Commands;

use App\Jobs\FetchRSSJob;
use Illuminate\Console\Command;

class CrawlRSSCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rss:go';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '派發所有訂閱的RSS檢查';

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
        $subscribes = collect(array_keys(config('rss_notification.subscribe')));
        $subscribes->each(function ($subscribe_key_name){
            FetchRSSJob::dispatch($subscribe_key_name)->onQueue('Subscribe');
        });
    }
}
