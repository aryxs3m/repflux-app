<?php

use App\Console\Commands\RemoveExpiredInvitations;

Schedule::command(RemoveExpiredInvitations::class);
