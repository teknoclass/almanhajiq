<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Pagination\AbstractPaginator;

abstract class MainCollection extends ResourceCollection
{
    protected string $collectionKey;
    public function __construct($resource, $collectionKey)
    {
        $this->collectionKey = $collectionKey;
        parent::__construct($resource);
    }

    /**
     * Transform the resource collection into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        if ($this->resource instanceof AbstractPaginator){
            return [
                'current_page' => $this->currentPage(),
                $this->collectionKey => $this->collection,
                'first_page_url' => $this->url(1),
                'from' => $this->firstItem(),
                'last_page' => $this->lastPage(),
                'last_page_url' => $this->url($this->lastPage()),
                'next_page_url' => $this->nextPageUrl(),
                'path' => $this->path(),
                'per_page' => $this->perPage(),
                'prev_page_url' => $this->previousPageUrl(),
                'to' => $this->lastItem(),
                'total' => $this->total(),
            ];
        }
        return   [$this->collectionKey => $this->collection];

    }
}
