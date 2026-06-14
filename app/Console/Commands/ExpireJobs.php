<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Modules\Jobs\Entities\JobPost;
use Carbon\Carbon;

class ExpireJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jobs:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find jobs whose deadline has passed and update status to expired';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking for expired jobs...');

        if (!class_exists(JobPost::class)) {
            $this->error('JobPost class does not exist.');
            return Command::FAILURE;
        }

        $now = Carbon::now();

        $updatedCount = JobPost::where('status', '!=', 'expired')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', $now)
            ->update(['status' => 'expired']);

        $this->info("Successfully updated {$updatedCount} job(s) status to expired.");

        return Command::SUCCESS;
    }
}
