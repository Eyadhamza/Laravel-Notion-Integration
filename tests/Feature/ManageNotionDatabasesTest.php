<?php

namespace Pi\Notion\Tests\Feature;

use Pi\Notion\Core\Builders\NotionPropertyBuilder;
use Pi\Notion\Core\Models\NotionDatabase;
use Pi\Notion\Core\Query\NotionFilter;
use Pi\Notion\Core\Query\NotionSort;
use Pi\Notion\Exceptions\NotionValidationException;
use Pi\Notion\Tests\TestCase;

class ManageNotionDatabasesTest extends TestCase
{

    private string $notionPageId = 'b4f8e429038744ca9c8d5afa93ea2edd';
    private string $notionDatabaseId = '632b5fb7e06c4404ae12065c48280e4c';

    /** @test */
    public function return_database_info()
    {

        $database = NotionDatabase::find('632b5fb7e06c4404ae12065c48280e4c');

        $this->assertObjectHasAttribute('objectType', $database);

    }

    /** @test */
    public function test_it_can_create_a_database_object()
    {

        $database = (new NotionDatabase)
            ->setParentPageId('fa4379661ed948d7af52df923177028e')
            ->setTitle(NotionPropertyBuilder::databaseTitle('Test Database'))
            ->setProperties([
                NotionPropertyBuilder::title('Name'),
                NotionPropertyBuilder::select('Status', [
                    ['name' => 'A', 'color' => 'red'],
                    ['name' => 'B', 'color' => 'green']
                ]),
                NotionPropertyBuilder::date(),
//                NotionPropertyBuilder::formula('Something'),
//                NotionPropertyBuilder::relation('Something'),
//                NotionPropertyBuilder::rollup('Something'),
//                NotionPropertyBuilder::people('Something'),
//                NotionPropertyBuilder::media('Something'),
//                NotionPropertyBuilder::checkbox('Something'),
//                NotionPropertyBuilder::email('Something'),
//                NotionPropertyBuilder::number('Something'),
//                NotionPropertyBuilder::phone('Something'),
//                NotionPropertyBuilder::url('Something'),
//                NotionPropertyBuilder::createdTime('Something'),
//                NotionPropertyBuilder::createdBy('Something'),
//                NotionPropertyBuilder::lastEditedTime('Something'),
//                NotionPropertyBuilder::lastEditedBy('Something'),

            ])
            ->create();

        $this->assertObjectHasAttribute('objectType', $database);

    }
    /** @test */
    public function test_it_can_update_a_database_object()
    {
        $database = (new NotionDatabase)
            ->setDatabaseId('a5f8af6484334c09b69d5dd5f54b378f')
            ->setTitle(NotionPropertyBuilder::databaseTitle('Test Database'))
            ->setProperties([
                NotionPropertyBuilder::select('Status2')->setOptions([
                    ['name' => 'A', 'color' => 'red'],
                    ['name' => 'B', 'color' => 'green']
                ]),
                NotionPropertyBuilder::date('Created')
            ])
            ->update();

        $this->assertObjectHasAttribute('objectType', $database);

    }
    /** @test */
    public function throw_exception_database_not_found()
    {
        $id = '632b5fb7e06c4404ae12asdasd065c48280e4asdc';

        $this->expectException(NotionValidationException::class);

        (new NotionDatabase($id))->get();


    }

    /** @test */
    public function throw_exception_database_not_authorized()
    {
        $id = '632b5fb7e06c4404ae12065c48280e4asdc';
        $this->expectException(NotionValidationException::class);
        (new NotionDatabase($id))->get();


    }


    /** @test */
    public function test_database_can_be_filtered_with_one_filter()
    {

        $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');

        $paginated = $database->filter(
            NotionFilter::title('Name')
                ->contains('MMMM'))
            ->query();
        $this->assertCount(4, $paginated->getResults());


    }

    /** @test */
    public function test_database_can_be_filtered_with_many_filters()
    {

        $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');

        $paginated = $database->filters([
            NotionFilter::groupWithAnd([
                NotionFilter::select('Status')
                    ->equals('Reading'),
                NotionFilter::multiSelect('Status2')
                    ->contains('A'),
                NotionFilter::title('Name')
                    ->contains('MMMM')
            ])
        ])->query();
        $this->assertCount(1, $paginated->getResults());

        $paginated = $database->filters([
            NotionFilter::groupWithOr([
                NotionFilter::select('Status')
                    ->equals('Reading'),
                NotionFilter::multiSelect('Status2')
                    ->contains('A'),
                NotionFilter::title('Name')
                    ->contains('MMMM')
            ])
        ])->query();
        $this->assertCount(4, $paginated->getResults());
    }

    public function test_database_can_be_filtered_with_nested_filters()
    {

        $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');

        $paginated = $database->filters([
            NotionFilter::select('Status')
                ->equals('Reading')
                ->compoundOrGroup([
                    NotionFilter::multiSelect('Status2')
                        ->contains('A'),
                    NotionFilter::title('Name')
                        ->contains('MMMM')
                ], 'and')
        ])->query();
        $this->assertCount(2, $paginated->getResults());

    }

    /** @test */
    public
    function i_can_sort_database_results()
    {

        $database = new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c');
        $paginated = $database->sorts([
            NotionSort::property('Name')->ascending(),
        ])->filter(
            NotionFilter::title('Name')
                ->contains('A'),
        )->query(50);
        $this->assertCount(50, $paginated->getResults());
        $this->assertTrue($paginated->hasMore());
        $paginated->next();
        $this->assertCount(50, $paginated->getResults());
        $this->assertIsString($paginated->getNextCursor());
    }
}
