<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GymController extends Controller
{
    public function gymUser()
    {
        return view('gym.gym-users');
    }
    public function gymIndex()
    {
        return view('gym.index');
    }


}
?>