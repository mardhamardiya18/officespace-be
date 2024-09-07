<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfficeSpaceResource;
use App\Models\OfficeSpace;
use Illuminate\Http\Request;

class OfficeSpaceController extends Controller
{
    //
    public function index()
    {
        $offices = OfficeSpace::withCount('city')->get();

        return OfficeSpaceResource::collection($offices);
    }

    public function show(OfficeSpace $officeSpace)
    {
        $officeSpace->load(['city', 'photos', 'benefits']);
        $officeSpace->loadCount('officeSpaces');

        return new OfficeSpaceResource($officeSpace);
    }
}
