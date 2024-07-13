<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConstraintController extends Controller
{
    public function viewConstraint()
    {
        return view('constraint.view');
    }

    public function addConstraint()
    {
        return view('constraint.add');
    }

    public function allConstraint()
    {
        return view('constraint.all');
    }

    public function editConstraint()
    {
        return view('constraint.edit');
    }


}
?>