<?php

namespace App\Jobs;

use App\Mail\NewsCreated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class NewsCreatedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $author;

    protected $news;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($author, $news)
    {
        $this->author = $author;
        $this->news = $news;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->author)->queue(new NewsCreated($this->news));
    }
}
