<?php

namespace App\Jobs;

use App\NewService\RSSFeed\RSS;
use App\Notifications\MessengerNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class NotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $RSSItem;
    private $Observer;
//    private $Type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(RSS $RSSItem, string $observer)
    {
        $this->RSSItem = $RSSItem;
        $this->Observer = $observer;
//        $this->Type = $type;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        dump($this->RSSItem->Subscribe->Type);
        dump('send to ' . $this->Observer);
        $this->RSSItem->setTargetObserver($this->Observer);
        $this->RSSItem->notify(new MessengerNotification($this->Observer));
    }
}
