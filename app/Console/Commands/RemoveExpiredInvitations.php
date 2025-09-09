<?php

namespace App\Console\Commands;

use App\Services\InvitationService;
use Illuminate\Console\Command;

class RemoveExpiredInvitations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-expired-invitations';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes expired invitations from the database';

    /**
     * Execute the console command.
     */
    public function handle(InvitationService $invitationService): int
    {
        $invitationService->removeExpiredInvitations();
        $this->info('Removed expired invitations.');

        return 0;
    }
}
