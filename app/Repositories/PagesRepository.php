<?php

namespace App\Repositories;

use App\Models\OurMessages;
use App\Models\OurTeams;
use App\Models\Pages;
use Illuminate\Support\Collection;

class PagesRepository extends MainRepository
{
    public function __construct()
    {
        parent::__construct(new Pages());
    }

    public function getPage($sulg)
    {
        return $this->model::where('sulg', $sulg)->first();

    }

    public function about()
    {
        $aboutCollection = new Collection();
        $aboutCollection->add($this->model::where('sulg', 'about')->first());

        $aboutCollection->add(OurMessages::select('id', 'image')
                                         ->with('translations:our_messages_id,title,description,locale')->get());

        $aboutCollection->add(OurTeams::select('id', 'image')
                                      ->with('translations:our_teams_id,name,job,description,locale')->get());

        return $aboutCollection;
    }
}
