<?php


namespace Pi\Notion;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Pi\Notion\Traits\HandleFilters;
use Pi\Notion\Traits\RetrieveResource;
use Pi\Notion\Traits\ThrowsExceptions;

class NotionDatabase extends Workspace
{
    use ThrowsExceptions;
    use HandleFilters;
    private string $id;
    private string $URL;
    private string $created_time;
    private string $last_edited_time;
    private string $title;
    private Collection $properties;
    private Collection $pages;
    private Collection $filters;
    private $parentObject;
    private string $filterConnective;

    public function __construct($id = '', $title = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->URL = Workspace::DATABASE_URL . "$id" . "/query";;
        $this->title = $title;
        $this->properties = new Collection();
        $this->pages = new Collection();
    }

    public function get($id = null, string $sort = '', $filterType = '')
    {
        $id = $id ?? $this->id;
        $response = Http::withToken(config('notion-wrapper.info.token'))
            ->post($this->URL,
                $this->getFilterResults()
            );
        $this->throwExceptions($response);

//        $this->constructObject($response->json());

        return $response->json();

    }


    public function sort()
    {
        // TODO, whenever i return objects !
    }


    public function setFilterConnective($filterConnective): void
    {
        $this->filterConnective = $filterConnective;
    }

    private function constructObject(mixed $json): self
    {
        if (array_key_exists('results', $json)) {
            $this->constructPages($json['results']);
            return $this;
        }
        $this->id = $json['id'];
        $this->title = $json['title'][0]['text']['content'];
        $this->constructProperties($json['properties']);
        return $this;

    }

    private function constructPages(mixed $results)
    {
        $pages = collect($results);
        $pages->map(function ($page) {

            $this->constructProperties($page['properties']);
            $page = (new NotionPage)->constructObject($page);

            $this->pages->add($page);
        });
    }

    private function constructProperties(mixed $properties)
    {

        $properties = collect($properties);
        $properties->map(function ($property) {
            $this->properties->add($property);
        });
    }

    public function setDatabaseId(string $notionDatabaseId)
    {
        $this->id = $notionDatabaseId;
    }

    protected function getDatabaseId(): string
    {
        return $this->id;
    }

}
//$response = $database->filters([
//    FilterGroup::setOrConnective([
//        Filter::select('Status')
//            ->equals('Reading'),
//        FilterGroup::setAndConnective([
//            Filter::select('Status')
//                ->equals('Reading'),
//            Filter::multiSelect('Status2')
//                ->contains('A'),
//            Filter::title('Name')
//                ->contains('MMMM')
//        ])
//    ])
//])->get();

//$response = $database->filters([
//    Filter::select('Status')
//        ->equals('Reading')
//        ->or(function () {
//            return [
//                Filter::multiSelect('Status2')
//                    ->contains('A')
//                    ->and()
//                    ->title('Name')
//                    ->contains('MMMM')
//            ];
//        })
//])->get();
//dd($response);
