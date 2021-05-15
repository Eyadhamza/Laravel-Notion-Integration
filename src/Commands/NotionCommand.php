<?php

namespace Pi\Notion\Commands;

use Illuminate\Console\Command;

class NotionCommand extends Command
{
    public $signature = 'notionlaravelwrapper';

    public $description = 'My command';

    public function handle()
    {
        $this->comment('All done');
    }
}
