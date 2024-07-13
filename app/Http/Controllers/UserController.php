<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function viewUser()
    {
        return view('user.view');
    }

    public function addUser()
    {
        return view('user.add');
    }

    public function allUser()
    {
        return view('user.all');
    }

    public function editUser()
    {
        return view('user.edit');
    }


}
?>