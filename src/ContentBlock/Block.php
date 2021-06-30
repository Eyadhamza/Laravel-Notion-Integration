<?php


namespace Pi\Notion\ContentBlock;


use Illuminate\Support\Collection;
use Pi\Notion\NotionPage;

class Block
{
    private ?string $object;
    private ?string $id;
    private ?string $created_time;
    private ?string $last_edited_time;
    private ?bool $has_children;
    private ?string $type;
    private ?string $body;
    private  $content;
    private ?NotionPage $notionPage;


    public function __construct($type = null,$body = null, $id= null, $created_time= null, $last_edited_time= null, $has_children= null)
    {


        $this->object = 'block';
        $this->id = $id;
        $this->created_time = $created_time;
        $this->last_edited_time = $last_edited_time;
        $this->has_children = $has_children;

        $this->type = $type;
        $this->body = $body;

    }

    public static function add($page)
    {

        return $page->getBlocks()->map(function ($block){
            return array(
                'object'=>$block->getObject(),
                'type' =>$block->getType(),
                $block->getType() => [
                    'text'=>[
                        [
                            'type'=>'text',
                            'text'=>[
                                'content'=>$block->getBody()
                            ]
                        ]

                    ]
                ]
            );

        });
    }
    public static function create( string $type = null,string $body = null)
    {

        return new self($type, $body);

    }


    public function ofType(string $type)
    {
        $this->setType($type);

        return $this;
    }

    public function ofBody(string $body)
    {
        $this->setBody($body);

        return $this;
    }
    public function createBlock()
    {

        Block::create($this->type,$this->body);



        return $this;
    }
    /**
     * @return string
     */
    public function getLastEditedTime(): string
    {
        return $this->last_edited_time;
    }

    /**
     * @param string $last_edited_time
     */
    public function setLastEditedTime(string $last_edited_time): void
    {
        $this->last_edited_time = $last_edited_time;
    }

    /**
     * @return bool
     */
    public function isHasChildren(): bool
    {
        return $this->has_children;
    }

    /**
     * @param bool $has_children
     */
    public function setHasChildren(bool $has_children): void
    {
        $this->has_children = $has_children;
    }

    /**
     * @return string
     */
    public function getCreatedTime(): string
    {
        return $this->created_time;
    }

    /**
     * @param string $created_time
     */
    public function setCreatedTime(string $created_time): void
    {
        $this->created_time = $created_time;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getObject(): string
    {
        return $this->object;
    }

    /**
     * @param string $object
     */
    public function setObject(string $object): void
    {
        $this->object = $object;
    }

    /**
     * @return mixed|null
     */
    public function getType(): mixed
    {
        return $this->type;
    }

    /**
     * @param mixed|null $type
     */
    public function setType(mixed $type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed|null
     */
    public function getBody(): mixed
    {
        return $this->body;
    }

    /**
     * @param mixed|null $body
     */
    public function setBody(mixed $body): void
    {
        $this->body = $body;
    }


}
