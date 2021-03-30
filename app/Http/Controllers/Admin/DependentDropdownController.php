<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\District;
use App\Models\Village;

class DependentDropdownController extends Controller
{
    public function district($id)
    {
        $districts = District::where('city_id', $id)
            ->pluck('name', 'id');
    
        return response()->json($districts);
    }

    public function village($id)
    {
        $villages = Village::where('district_id', $id)
            ->pluck('name', 'id');
    
        return response()->json($villages);
    }
}
