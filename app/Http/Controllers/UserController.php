<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;


class UserController extends Controller
{

    public function viewUser($id)
    {
        $user = User::findOrFail($id);
        return view('user.view', compact('user'));
    }


    public function addUser()
    {
        return view('user.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
        ]);

        $password = Str::random(8);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' =>  $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => 'trainer',
            'status' => 'active',
            'password' => Hash::make($password)
        ]);

        Mail::to($user->email)->send(new WelcomeMail($user, $password));

        return redirect()->route('user-all')->with('success', 'User added successfully.');
    }

    public function allUser()
    {
        $users = User::all();
        return view('user.all',compact('users'));
    }

    public function editUser(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|string|in:trainer,user',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Update the user's role
        $user->role = $request->input('role');
        $user->save();

        // Redirect back with a success message
        return redirect()->route('user-view', ['id' => $id])->with('success', 'User role updated successfully.');
    }


    public function deactivateUser(Request $request)
    {
        try{
            $userId = $request->input('id');

            $user = User::find($userId);
    
            if ($user) {
                $user->status = 'inactive';
                $user->save();
    
                return response()->json(['success' => true]);
            } else {
                return response()->json(['success' => false]);
            }
        }catch(Exception $e){
            return response()->json(['success' => false, $e->getMessage()]);

        }
       
    }
}
?>