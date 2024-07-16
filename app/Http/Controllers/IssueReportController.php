<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IssueReportController extends Controller
{
    public function indexUser()
    {
        return view('issue-report.index-user');
    }

    public function indexTrainer()
    {
        return view('issue-report.index-trainer');
    }


    public function create()
    {
        return view('issue-report.create');
    }

    public function edit()
    {
        return view('issue-report.edit');
    }

    public function viewUser()
    {
        return view('issue-report.view-user');
    }

    public function viewTrainer()
    {
        return view('issue-report.view-trainer');
    }

}
?>