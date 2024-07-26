<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\GymUser;
use App\Models\GymUserAchievement;
use App\Models\Achievement;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */

     public function view(Request $request): View
     {
        $achievement = GymUserAchievement::with('achievement')
        ->where('gym_user_id', Auth::user()->gymUser->gym_user_id)->get();
        $lockAchievement = Achievement::whereNotIn('achievement_id', $achievement->pluck('achievement_id'))->get();
         return view('profile.view', [
             'user' => $request->user(),
             'achievements' => $achievement,
             'lockAchievements' => $lockAchievement
         ]);
     }

     public function profileDetails(Request $request)
     {
         $user = User::find($request->id);
     
         if ($user) {
             return response()->json([
                 'success' => true,
                 'user' => $user,
             ]);
         } else {
             return response()->json([
                 'success' => false,
                 'message' => 'User not found',
             ]);
         }
     }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        // Handle image upload
        if ($request->hasFile('image')) {
            $directory = 'img/profile';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            $imagePath = $request->file('image')->store($directory, 'public');
            $request->user()->image = $imagePath;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
