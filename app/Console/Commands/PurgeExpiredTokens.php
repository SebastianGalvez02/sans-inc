<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\BlacklistedTokenRepository;

/**
 * PurgeExpiredTokens
 * Removes all blacklisted tokens whose expiry timestamp has already passed.
 * These tokens can no longer be reused regardless, so storing them wastes space.
 *
 * Register in app/Console/Kernel.php to run automatically:
 *
 *   protected function schedule(Schedule $schedule): void
 *   {
 *       $schedule->command('tokens:purge-expired')->daily();
 *   }
 *
 * Or run manually:
 *   php artisan tokens:purge-expired
 */
class PurgeExpiredTokens extends Command
{
    protected $signature   = 'tokens:purge-expired';
    protected $description = 'Delete all blacklisted JWT tokens that have already expired';

    public function __construct(
        protected BlacklistedTokenRepository $repository,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $deleted = $this->repository->purgeExpired();

        $this->info("Purged {$deleted} expired blacklisted token(s).");

        return Command::SUCCESS;
    }
}
