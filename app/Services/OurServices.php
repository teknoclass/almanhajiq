<?php

namespace App\Services;

use App\Models\OurServices as Service;

class OurServices extends MainService
{
    function lastServices(){

        $services = Service::take(10)->get();

        return $services;

    }

    function allOpinions()
    {
        $opinions = Service::paginate(10);
        return $opinions;
    }

}
