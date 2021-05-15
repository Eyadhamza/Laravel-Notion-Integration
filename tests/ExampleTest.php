<?php

namespace Pi\Notion\Tests;

use Pi\Notion\Notion;
use Pi\Notion\Workspace;

class ExampleTest extends TestCase
{
    /** @test */
    public function true_is_true()
    {
        dd(Workspace::workspace());
        $this->assertTrue(true);
    }
}
