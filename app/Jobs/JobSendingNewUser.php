<?php

namespace App\Jobs;

use App\Mail\SendingNewUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class JobSendingNewUser implements ShouldQueue
{
    use Queueable;

    /**
     * @param $userid
     */
    public function __construct(private $userid){}

    /**
     * @return void
     */
    public function handle(): void
    {
        $user = User::query()->firstWhere('id', '=', $this->userid);

        Mail::to($user->email)->queue(new SendingNewUser($user));
    }

    /**
     * @param \Exception|\Throwable|null $e
     * @return void
     */
    public function fail(\Exception|\Throwable $e = null): void
    {
        if (config('app.debug') === 'local') {
            Log::channel('log-queues')->error([
                'created_at' => Carbon::now(),
                'ip' => request()->ip(),
                'user_id' => $this->userid,
                'message' => $e->getMessage(),
                'trace' => $e->getTrace()
            ]);
        } else {
            Log::channel('log-queues')->error([
                'created_at' => Carbon::now(),
                'ip' => request()->ip(),
                'user_id' => $this->userid,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
