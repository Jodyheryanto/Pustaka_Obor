<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DataAccount;

class AdminBukuBesarController extends Controller
{
    function index(Request $request){
        $dataaccount = DataAccount::all();
        return view('Admin.BukuBesar.index', compact(['dataaccount']));
    }
}
