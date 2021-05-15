<?php

namespace Pi\Notion\Commands;

use Illuminate\Console\Command;

class NotionCommand extends Command
{
    public $signature = 'notion-wrapper';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
