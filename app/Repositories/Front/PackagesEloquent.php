<?php

namespace App\Repositories\Front;

use App\Models\Category;
use App\Models\Coupons;
use App\Models\CoursePriceDetails;
use App\Models\Packages;
use App\Models\User;
use App\Models\UserPackages;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class PackagesEloquent
{
    public function index($request)
    {
        $data = $this->getData($request);

        return $data;
    }

    public function getData($request, $count_itmes = 8)
    {
        $data['packages'] = Packages::with('translations:packages_id,title,locale,description')
            ->orderBy('id', 'desc');

        $title = $request->get('title');

        $data['packages'] = $data['packages']->paginate(9);

        return $data;
    }

    public function single($id)
    {
        $data['package'] = Packages::with('translations:packages_id,title,locale,description')
            ->where('id', $id)->first();

            // dd($data['package']);

        if (!$data['package']) abort(404);

        return $data;
    }
}
