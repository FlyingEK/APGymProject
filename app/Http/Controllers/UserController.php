<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string|in:trainer,user',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make('Admin1234!')
        ]);

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


}
?>