<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class AdminController extends Controller
{
    //
    public function index (){
        return view("admin.dashboard.index");
    }

    public function viewUsers (){
        return view ("admin.users.index", ["users" => User::all()]);
    }
}
