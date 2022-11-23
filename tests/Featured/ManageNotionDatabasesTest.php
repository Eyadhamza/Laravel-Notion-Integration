<?php

namespace Pi\Notion\Tests\Featured;

use Illuminate\Support\Collection;
use Pi\Notion\Filter;
use Pi\Notion\NotionDatabase;

use Pi\Notion\Exceptions\NotionDatabaseException;
use Pi\Notion\NotionPage;
use Pi\Notion\Property;
use Pi\Notion\Sort;
use Pi\Notion\Tests\TestCase;
use Pi\Notion\Workspace;

class ManageNotionDatabasesTest extends TestCase
{

    private string $notionPageId = 'b4f8e429038744ca9c8d5afa93ea2edd';
    private string $notionDatabaseId = '632b5fb7e06c4404ae12065c48280e4c';

    /** @test */
    public function return_database_info()
    {

        $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');

        $this->assertArrayHasKey('object', $database->get());

    }

    /** @test */
    public function test_it_can_create_a_database_object()
    {

        $database = (new NotionDatabase)
            ->setParentPageId('fa4379661ed948d7af52df923177028e')
            ->setTitle('Test Database2')
            ->setProperties([
                Property::title(),
                Property::select('Status')->setOptions([
                    ['name' => 'A', 'color' => 'red'],
                    ['name' => 'B', 'color' => 'green']
                ]),
                Property::date()
            ])
            ->create();

        $this->assertArrayHasKey('object', $database);

    }
    /** @test */
    public function test_it_can_update_a_database_object()
    {

        $database = (new NotionDatabase)
            ->setDatabaseId('a5f8af6484334c09b69d5dd5f54b378f')
            ->setProperties([
                Property::select('Status2')->setOptions([
                    ['name' => 'A', 'color' => 'red'],
                    ['name' => 'B', 'color' => 'green']
                ]),
                Property::date('Created')
            ])
            ->update();

        $this->assertArrayHasKey('object', $database);

    }
    /** @test */
    public function throw_exception_database_not_found()
    {
        $id = '632b5fb7e06c4404ae12asdasd065c48280e4asdc';

        $this->expectException(NotionDatabaseException::class);

        (new NotionDatabase($id))->get();


    }

    /** @test */
    public function throw_exception_database_not_authorized()
    {
        $id = '632b5fb7e06c4404ae12065c48280e4asdc';
        $this->expectException(NotionDatabaseException::class);
        (new NotionDatabase($id))->get();


    }


    /** @test */
    public function test_database_can_be_filtered_with_one_filter()
    {

        $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');

        $response = $database->filter(
            Filter::make('title', 'Name')
                ->apply('contains', 'MMMM')
        )->query();

        $this->assertArrayHasKey('results', $response);


    }

    /** @test */
    public function test_database_can_be_filtered_with_many_filters()
    {

        $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');

        $response = $database->filters([
            Filter::groupWithAnd([
                Filter::select('Status')
                    ->equals('Reading'),
                Filter::multiSelect('Status2')
                    ->contains('A'),
                Filter::title('Name')
                    ->contains('MMMM')
            ])
        ])->query();

        $this->assertCount('1', $response['results']);
        $response = $database->filters([
            Filter::groupWithOr([
                Filter::select('Status')
                    ->equals('Reading'),
                Filter::multiSelect('Status2')
                    ->contains('A'),
                Filter::title('Name')
                    ->contains('MMMM')
            ])
        ])->query();
        $this->assertCount('4', $response['results']);

    }

    public function test_database_can_be_filtered_with_nested_filters()
    {

        $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');

        $response = $database->filters([
            Filter::select('Status')
                ->equals('Reading')
                ->nestedOrGroup([
                    Filter::multiSelect('Status2')
                        ->contains('A'),
                    Filter::title('Name')
                        ->contains('MMMM')
                ], 'and')
        ])->query();
        $this->assertArrayHasKey('results', $response);

    }

    /** @test */
    public
    function i_can_sort_database_results()
    {

        $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');
        $database->sort([
            Sort::property('Name')->ascending(),
        ])->filter(
            Filter::title('Name')
                ->contains('A'),
        )->query();

        $this->assertObjectHasAttribute('properties', $database);
    }
}
