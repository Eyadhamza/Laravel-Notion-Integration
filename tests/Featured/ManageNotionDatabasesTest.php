<?php

namespace Pi\Notion\Tests\Featured;

use Illuminate\Support\Collection;
use Pi\Notion\NotionDatabase;

use Pi\Notion\Exceptions\NotionDatabaseException;
use Pi\Notion\NotionPage;
use Pi\Notion\Properties\MultiSelect;
use Pi\Notion\Properties\Select;
use Pi\Notion\Properties\Title;
use Pi\Notion\Tests\TestCase;
use Pi\Notion\Workspace;

class ManageNotionDatabasesTest extends TestCase
{
    /** @test */
    public function return_database_info()
    {
        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c'))->get();


        $this->assertStringContainsString('database',$response['object']);

        $response =  (new NotionDatabase)->get('632b5fb7e06c4404ae12065c48280e4c');

        $this->assertStringContainsString('database',$response['object']);

        $this->assertStringNotContainsString('error',$response['object']);
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

        $filter =( new Select('Status'))->equals('Reading');
        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c'))->getContents($filter);

        $this->assertStringContainsString('list',$response['object']);

    }

    /** @test */
    public function return_database_contents_with_multiple_query()
    {


        $filters = new Collection();
        $filters->add((new Select('Status'))->equals('Reading'))
                ->add((new Select('Publisher'))->equals('NYT'));


        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c' ))->getContents($filters,filterType: 'and');

        $this->assertStringContainsString('list',$response['object']);



    }
    /** @test */
    public function return_database_contents_with_multiple_query_with_different_conditions()
    {


        $filters = new Collection();
        $filters->add((new Select('Status'))->equals('Reading')->isNotEmpty())
            ->add((new Select('Publisher'))->notEqual('NN')->isEmpty());


        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c' ))->getContents($filters,filterType: 'and');


        $this->assertStringContainsString('list',$response['object']);



    }
    /** @test */
    public function return_database_contents_with_multiple_query_using_multiselect_property()
    {


        $filters = new Collection();
        $filters->add((new MultiSelect('Status1','blue'))->contains('B'))
                   ->add((new MultiSelect('Status2','blue'))->contains('A'));


        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c' ))->getContents($filters,filterType: 'and');


        $this->assertStringContainsString('list',$response['object']);

    }

    /** @test */
    public function return_database_contents_with_multiple_query_using_multiselect_property_with_conditions()
    {


        $filters = new Collection();
        $filters->add((new MultiSelect('StatusMulti'))->notContain('Ba'))
            ->add((new MultiSelect('StatusMulti'))->contains('B'));

        $response =  (new NotionDatabase('632b5fb7e06c4404ae12065c48280e4c' ))->getContents($filters,filterType: 'and');


        $this->assertStringContainsString('list',$response['object']);

    }


}
