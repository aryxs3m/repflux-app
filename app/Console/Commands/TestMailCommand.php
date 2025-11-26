<?php

namespace App\Console\Commands;

use App\Mail\TestMailableMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailCommand extends Command
{
    protected $signature = 'test:mail';

    protected $description = 'Command description';

    public function handle(): void
    {
        Mail::to('aryx@pvga.hu')->send(new TestMailableMail);
    }
}
