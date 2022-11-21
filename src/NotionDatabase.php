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
    private Collection $sorts;

    public function __construct($id = '', $title = '')
    {
        parent::__construct();
        $this->id = $id;
        $this->URL = Workspace::DATABASE_URL . "$id";;
        $this->title = $title;
        $this->properties = new Collection();
        $this->pages = new Collection();
    }

    public function get($id = null)
    {
        $id = $id ?? $this->id;
        $requestBody = [];
        isset($this->filters) ? $requestBody['filter'] = $this->getFilterResults() : null;
        isset($this->sorts) ? $requestBody['sorts'] = $this->getSortResults() : null;


        $response = Http::withToken(config('notion-wrapper.info.token'));
        $response = $requestBody ?
            $response->post($this->URL . "/query", $requestBody)
            : $response->get($this->URL);

        $this->throwExceptions($response);
//        $this->constructObject($response->json());

        return $response->json();

    }


    public function sort(Collection|array $sorts): self
    {
        $sorts = is_array($sorts) ? collect($sorts) : $sorts;

        $this->sorts = $sorts;

        return $this;
    }

    public function usingConnective(string $connective): self
    {
        $this->filters[0]->setConnective($connective);
        return $this;
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

    private function getSortResults(): array
    {
        return $this->sorts->map->get()->toArray();
    }
}
