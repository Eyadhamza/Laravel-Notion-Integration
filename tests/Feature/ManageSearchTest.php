<?php

namespace Pi\Notion\Tests\Feature;

use Pi\Notion\Core\Query\NotionSearch;
use Pi\Notion\Core\Query\NotionSort;
use Pi\Notion\Tests\TestCase;

class ManageSearchTest extends TestCase
{
    /** @test */
    public function it_returns_search_result_of_page()
    {
        $response = NotionSearch::inPages('Eyad')
            ->apply(50);
        $this->assertCount(50, $response->getResults());

    }
    /** @test */
    public function it_returns_search_result_of_databases()
    {
        $response = NotionSearch::inDatabases('test')
            ->sorts([
                NotionSort::make('last_edited_time',  'descending')
            ])->apply(50);

        $this->assertGreaterThan(43, $response->getResults()->count());

    }
}
