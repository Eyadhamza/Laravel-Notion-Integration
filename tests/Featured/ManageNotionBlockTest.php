<?php

namespace Pi\Notion\Tests\Featured;

use Illuminate\Support\Collection;
use Pi\Notion\Common\NotionRichText;
use Pi\Notion\Core\NotionBlock;
use Pi\Notion\Core\NotionDatabase;
use Pi\Notion\Core\NotionPage;
use Pi\Notion\Core\NotionProperty;
use Pi\Notion\Tests\TestCase;

class ManageNotionBlockTest extends TestCase
{
    private string $notionBlockId = 'b1cfe8df181543039b2f9e3f2c87516c';

    /** @test */
    public function it_should_return_block_info()
    {
        $this->withoutExceptionHandling();

        $block = NotionBlock::find('b1cfe8df181543039b2f9e3f2c87516c');

        $this->assertObjectHasAttribute('objectType', $block);
    }
    /** @test */
    public function it_should_return_block_children()
    {
        $this->withoutExceptionHandling();

        $block = NotionBlock::find('62ec21df1f9241ba9954828e0958da69');

        $paginatedObject = $block->addChildren([
            NotionBlock::headingTwo(NotionRichText::make('Eyad Hamza')
                ->bold()
                ->setLink('https://www.google.com')
                ->color('red')),
            NotionBlock::headingThree('Heading 3'),
            NotionBlock::numberedList('Numbered List'),
            NotionBlock::bulletedList('Bullet List'),
        ])->getChildren(50);
//        $paginatedObject->next(); Problem here!
        dd($paginatedObject);
        $this->assertCount(4, $paginatedObject->getResults());
    }

    /** @test */
    public function it_should_update_block()
    {
        $this->withoutExceptionHandling();

        $block = NotionBlock::headingOne('This is a paragraph')
            ->setId($this->notionBlockId)
            ->update();

        $this->assertObjectHasAttribute('objectType', $block);
    }

    /** @test */
    public function it_should_append_block_children()
    {
        $this->withoutExceptionHandling();

        $block = NotionBlock::find('62ec21df1f9241ba9954828e0958da69');

        $block = $block->addChildren([
            NotionBlock::headingTwo(NotionRichText::make('Eyad Hamza')
                ->bold()
                ->setLink('https://www.google.com')
                ->color('red')),
            NotionBlock::headingThree('Heading 3'),
            NotionBlock::numberedList('Numbered List'),
            NotionBlock::bulletedList('Bullet List'),
        ]);

        $this->assertObjectHasAttribute('objectType', $block);
    }

    /** @test */
    public function it_should_delete_block()
    {
        $this->withoutExceptionHandling();

        $block = NotionBlock::find('62ec21df1f9241ba9954828e0958da69');

        $this->assertObjectHasAttribute('objectType', $block);
    }
}
