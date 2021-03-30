<?php

namespace App\Http\Controllers\Admin;

use Alert;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator,Redirect,Response,File;
use Illuminate\Routing\UrlGenerator;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Hash;
use DateTime;
use DB;
use App\Models\User;
use App\Models\UserMobile;

class AdminUserController extends Controller
{
    function list(){
        $users = User::all();
        $usermobiles = UserMobile::all();
        return view('auth.list', compact(['users', 'usermobiles']));
    }

    function create(){
        return view('auth.register');
    }

    function store(Request $request){
        $this->validate($request, [
            'email' => 'required', 'string', 'email', 'max:255', 'unique:users'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);
        
        Alert::success('Success', 'Data berhasil disimpan');
        return redirect()->route('admin.user.list');
    }

    function edit(Request $request){
        $user = User::where('id',$request->id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->save();

        Alert::success('Success', 'Data berhasil diubah');
        return redirect()->route('admin.user.list');
    }

    function changePassword(Request $request){
        $user = User::where('id',$request->id)->first();
        if(Hash::check($request->password_old, $user->password)){
            if($request->password_old != $request->password){
                $user->password = Hash::make($request->password);
                Alert::success('Success', 'Password berhasil diubah');
            }else{
                Alert::warning('Gagal', 'Password anda sama dengan yang lama');
            }
        }else{
            Alert::warning('Gagal', 'Password lama anda salah');
        }
        return redirect()->route('admin.dashboard');
    }

    function showEditForm($id){
        $user = User::where('id', $id)->first();
        return view('auth.edit', compact(['user']));
    }

    public function ubahStatus(Request $request)
	{
        $user = UserMobile::find($request->id_user);
        $user->is_block = 1;
        $user->save();

        Alert::success('Success', 'Akun berhasil di block');
        return redirect()->route('admin.user.list');
    }
}
