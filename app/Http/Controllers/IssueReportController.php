<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Issue;
use App\Models\GymUser;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Notifications\ReportIssue;
use Illuminate\Support\Facades\Notification;

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
        $openIssues = Issue::where('status', "pending")
        ->orWhere('status', 'reported')
        ->get();
        $closedIssues = Issue::where('status', "resolved")->get();
        $rejectedIssues = Issue::where('status', "rejected")->get();
        return view('issue-report.index-trainer', compact('openIssues', 'closedIssues', 'rejectedIssues'));
    }

    public function reportedIssue()
    {
        $openIssues = Issue::where('status', "pending")
        ->orWhere('status', 'reported')
        ->orWhere('status', 'resolved')
        ->get();

        return view('issue-report.admin.reported_issue', compact('openIssues'));
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

    public function edit($id)
    {
        $issue = Issue::with('equipmentMachine.equipment')->findOrFail($id);
        $allEquipment = Equipment::where('is_deleted', false)->get();
        return view('issue-report.edit', compact('issue', 'allEquipment'));
    }

    public function update(Request $request, $id)
    {
        $issue = Issue::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:equipment,gym,other',
            'equipment_machine_id' => 'required_if:type,equipment|exists:equipment_machine,equipment_machine_id',
            'description' => 'nullable',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        // Check if the image is updated
        if ($request->hasFile('image')) {
            $directory = '/img/equipment';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            // Delete the old image
            if ($issue->image && Storage::exists($issue->image)) {
                Storage::delete($issue->image);
            }

            $imagePath = $request->file('image')->store($directory, 'public');
        } else {
            $imagePath = $issue->image;
        }

        $data['image'] = $imagePath;
        $issue->update($data);

        return redirect()->route('issue-user-view', $issue->issue_id )->with('success', 'Issue updated successfully.');
    }

    public function cancelIssue($id)
    {
        $issue = Issue::with('equipmentMachine')->findOrFail($id);
        $issue->update(['status' => 'cancelled']);
        if($issue->equipment_machine_id){
            $issue->equipmentMachine()->update([
                'status' => 'available'
            ]);
        }
        return redirect()->route('issue-user-index')->with('success', 'Issue cancelled successfully.');
    }

    public function viewUser($id)
    {
        $issue = Issue::with('equipmentMachine.equipment')->with('comment')->findOrFail($id);
        return view('issue-report.view-user', compact('issue'));
    }

    public function viewTrainer($id)
    {
        $issue = Issue::with('equipmentMachine.equipment')
        ->with('comment.user')             
        ->findOrFail($id);  
        $user = GymUser::with('user')->findOrFail($issue->created_by);
        return view('issue-report.view-trainer', compact('issue','user'));
    }

    public function viewAdmin($id)
    {
        $issue = Issue::with('equipmentMachine.equipment')
        ->with('comment.user')             
        ->findOrFail($id);  
        $user = GymUser::with('user')->findOrFail($issue->created_by);
        return view('issue-report.admin.view', compact('issue','user'));
    }

    
    public function updateStatus(Request $request, $id)
    {
        $sendNotification = false;
        $issue = Issue::with('comment','equipmentMachine')->findOrFail($id);
        $data = $request->validate([
            'status' => 'required|in:reported,resolved,rejected',
        ]);
        $issue->update($data);
        if($data['status'] == 'resolved' || $data['status'] == 'rejected' && $issue->equipment_machine_id){
            $issue->equipmentMachine()->update([
                'status' => 'available'
            ]);
        }else if($data['status'] == 'reported'){
            $issue->equipmentMachine()->update([
                'status' => 'maintenance'
            ]);

            if(Auth::user()->role != 'admin'){
                $admins = User::where('role', 'admin')->get();

                foreach($admins as $admin){
                    Notification::send($admin, new ReportIssue($issue));
                    $sendNotification = true;
                }
            }
        }
        if($request->has('comment')){
            if($issue->comment()){
                $issue->comment()->update([
                    'comment' => $request->comment,
                    'created_by' => Auth::user()->user_id,
                ]);
            }else{
                $issue->comment()->create([
                    'comment' => $request->comment,
                    'created_by' => Auth::user()->user_id,
                ]);
            }

        }

        if($sendNotification){
            return redirect()->back()->with('success', 'Issue status updated successfully. Issue is sent to the admin.');
        }
        return redirect()->back()->with('success', 'Issue status updated successfully.');
    }

}
?>