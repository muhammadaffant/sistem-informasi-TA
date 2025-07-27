<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminDataUserController extends Controller
{
    public function index ()
    {
        $users = User::role('user')->get();
        return view('admin.datauser.index',[
            'title' => 'Data user',
            'active' => 'List user',
            'users' => $users
        ]);
    }
}
