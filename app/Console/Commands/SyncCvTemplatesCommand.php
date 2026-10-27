<?php

namespace App\Console\Commands;

use App\Services\CvTemplateSyncService;
use Illuminate\Console\Command;

class SyncCvTemplatesCommand extends Command
{
    protected $signature = 'cv:sync-templates {--export : Export database templates into JSON}';
    protected $description = 'Synchronize CV templates between database and JSON file';

    public function handle(CvTemplateSyncService $syncService): int
    {
        if ($this->option('export')) {
            $res = $syncService->exportToJson();
            $this->info($res['message']);
            return Command::SUCCESS;
        }

        $res = $syncService->syncFromJson();
        if ($res['success']) {
            $this->info($res['message']);
            return Command::SUCCESS;
        }

        $this->error($res['message']);
        return Command::FAILURE;
    }
}
