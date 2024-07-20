<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Issue;
use App\Models\GymUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class IssueReportController extends Controller
{
    public function indexUser()
    {
        $userId = Auth::user()->user_id;
        $gymUser = GymUser::where('user_id', $userId)->first();
        if (!$gymUser) {
            return redirect()->back()->with('error', 'Gym user not found.');
        }
        $gymUserId = $gymUser->gym_user_id;
        $userIssues = Issue::where('created_by', $gymUserId)->get();
        $knownIssues = Issue::where('created_by', '!=', $gymUserId)
        ->where('status', '=', 'reported')
        ->get();
        return view('issue-report.index-user', compact('userIssues', 'knownIssues'));
    }

    public function indexTrainer()
    {
        return view('issue-report.index-trainer');
    }


    public function create()
    {
        $allEquipment = Equipment::where('is_deleted', false)->get();
        return view('issue-report.create', compact('allEquipment'));
    }

    public function store(Request $request){

        $userId = Auth::user()->user_id;
        $gymUser = GymUser::where('user_id', $userId)->first();
        if (!$gymUser) {
            return redirect()->back()->with('error', 'Gym user not found.');
        }
        $gymUserId = $gymUser->gym_user_id;
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:equipment,gym,other',
            'equipment_machine_id' => 'required_if:type,equipment|exists:equipment_machine,equipment_machine_id',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        $imagePath = null;
        if($request->hasFile('image')){
            $directory = '/img/issue';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }
            $imagePath = $request->file('image')->store($directory, 'public');
        }

        $data['image'] = $imagePath;
        $data['created_by'] = $gymUserId;
        $issue = Issue::create($data);
        return redirect()->route('issue-user-index')->with('success', 'Issue reported successfully.');
    }

    public function edit()
    {
        return view('issue-report.edit');
    }

    public function viewUser($id)
    {
        $issue = Issue::with('equipmentMachine.equipment')->findOrFail($id);
        return view('issue-report.view-user', compact('issue'));
    }

    public function viewTrainer()
    {
        return view('issue-report.view-trainer');
    }

}
?>