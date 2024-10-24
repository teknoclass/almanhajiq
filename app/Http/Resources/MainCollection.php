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

                $this->collectionKey => $this->collection,
                "pagination"=>[
                    'current_page' => $this->currentPage(),
                    'from' => $this->firstItem(),
                    'last_page' => $this->lastPage(),
                    'per_page' => $this->perPage(),
                    'to' => $this->lastItem(),
                    'total' => $this->total(),
                ]
            ];
        }
        return   [$this->collectionKey => $this->collection];

    }
}
