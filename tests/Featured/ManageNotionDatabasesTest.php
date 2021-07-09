<?php

namespace Pi\Notion\Tests\Featured;

use Illuminate\Support\Collection;
use Pi\Notion\NotionDatabase;

use Pi\Notion\Exceptions\NotionDatabaseException;
use Pi\Notion\NotionPage;
use Pi\Notion\Properties\MultiSelect;
use Pi\Notion\Properties\Select;
use Pi\Notion\Properties\Title;
use Pi\Notion\Query\MultiSelectFilter;
use Pi\Notion\Query\SelectFilter;
use Pi\Notion\Tests\TestCase;
use Pi\Notion\Workspace;

class ManageNotionDatabasesTest extends TestCase
{


    /** @test */
    public function return_database_info()
    {
        $response =  (new NotionDatabase)->get('632b5fb7e06c4404ae12065c48280e4c');


        $this->assertObjectHasAttribute('properties',$response);

        $response =  (new NotionDatabase)->get('632b5fb7e06c4404ae12065c48280e4c');

        $this->assertObjectHasAttribute('properties',$response);

    }

    /** @test */
    public function throw_exception_database_not_found()
    {
        $id = '632b5fb7e06c4404ae12asdasd065c48280e4asdc';

        $this->expectException(NotionDatabaseException::class);

        $response =  (new NotionDatabase($id))->get();


    }
    /** @test */
    public function throw_exception_database_not_authorized()
    {
        $id = '632b5fb7e06c4404ae12065c48280e4asdc';
        $this->expectException(NotionDatabaseException::class);
        (new NotionDatabase($id))->get();


    }
    /** @test */
    public function return_database_contents_with_single_query()
    {

        $filter =( new SelectFilter('Status'))->equals('Reading');
        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c'))->getContents($filter);

        $this->assertObjectHasAttribute('properties',$response);

    }

    /** @test */
    public function return_database_contents_with_multiple_query()
    {


        $filters = new Collection();
        $filters->add((new SelectFilter('Status'))->equals('Reading'))
                ->add((new SelectFilter('Publisher'))->equals('NYT'));


        $database =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c' ))->getContents($filters,filterType: 'and');
        $this->assertObjectHasAttribute('properties',$database);

    }
    /** @test */
    public function i_can_sort_database_results()
    {
        $filters = new Collection();
        $filters->add((new SelectFilter('Status'))->equals('Reading'))
            ->add((new SelectFilter('Publisher'))->equals('NYT'));


        $database =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c' ))->getContents($filters,filterType: 'and');

        $this->assertObjectHasAttribute('properties',$database);
    }
    /** @test */
    public function return_database_contents_with_multiple_query_with_different_conditions()
    {


        $filters = new Collection();
        $filters->add((new SelectFilter('Status'))->equals('Reading')->isNotEmpty())
            ->add((new SelectFilter('Publisher'))->notEqual('NN')->isEmpty());


        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c' ))->getContents($filters,filterType: 'and');
        $this->assertObjectHasAttribute('properties',$response);



    }
    /** @test */
    public function return_database_contents_with_multiple_query_using_multiselect_property()
    {


        $filters = new Collection();
        $filters->add((new MultiSelectFilter('Status1','blue'))->contains('B'))
                   ->add((new MultiSelectFilter('Status2','blue'))->contains('A'));


        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c' ))->getContents($filters,filterType: 'and');
        $this->assertObjectHasAttribute('properties',$response);

    }

    /** @test */
    public function return_database_contents_with_multiple_query_using_multiselect_property_with_conditions()
    {


        $filters = new Collection();
        $filters->add((new MultiSelectFilter('StatusMulti'))->notContain('Ba'))
            ->add((new MultiSelectFilter('StatusMulti'))->contains('B'));

        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c' ))->getContents($filters,filterType: 'and');
        $this->assertObjectHasAttribute('properties',$response);

    }


}
