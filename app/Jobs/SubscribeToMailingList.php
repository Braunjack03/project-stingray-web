<?php

namespace App\Jobs;

use MailerLiteApi\MailerLite;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use Config;

class SubscribeToMailingList implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $subscriber = [
            'email' => $this->user->email,
        ];

        $groupsApi = (new Mailerlite(Config('mailerlite.api_key')))->groups();
        $response = $groupsApi->addSubscriber(Config('mailerlite.group_id'), $subscriber);
        return $response;


        //
    }
}
