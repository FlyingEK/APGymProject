<?php
namespace App\Http\Controllers;
use App\Models\User;
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
        $users = User::all();
        return view('user.all',compact('users'));
    }

    public function editUser()
    {
        return view('user.edit');
    }


}
?>