<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GymQueue;
use App\Models\GymConstraint;

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