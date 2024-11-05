<?php

namespace App\Repositories\Front;

use App\Models\Pages;
use App\Models\OurMessages;
use App\Models\OurTeams;
use App\Models\OurPartners;

class PagesEloquent
{

    public function getPage($sulg)
    {
        $data['item'] = Pages::where('sulg', $sulg)->first();

        if ($data['item'] == '') {
            abort(404);
        }
        return $data;
    }

    public function about()
    {
        $data['item'] = Pages::where('sulg', 'about')->first();

        $data['messages'] = OurMessages::select('id', 'image')
            ->with('translations:our_messages_id,title,description,locale')->get();

        $data['teams'] = OurTeams::select('id', 'image')
            ->with('translations:our_teams_id,name,job,description,locale')->get();

        $data['partners'] = OurPartners::select('id','image')->
        with('translations:our_partners_id,title,locale')
            ->orderByDesc('created_at')->get();

        if ($data['item'] == '') {
            abort(404);
        }
        return $data;
        //return true;
    }
}
