<?php

namespace App\Console\Commands;

use App\Services\DentistTransitionService;
use Illuminate\Console\Command;

class DeactivateExpiredDentistsCommand extends Command
{
    protected $signature = 'dentists:deactivate-expired';

    protected $description = 'Deactivate dentist accounts whose approved access expiration has already passed.';

    public function handle(DentistTransitionService $service): int
    {
        $count = $service->deactivateExpiredDentists();

        $this->info("Processed {$count} expired dentist transition(s).");

        return self::SUCCESS;
    }
}
