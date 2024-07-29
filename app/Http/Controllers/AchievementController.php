<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Achievement;
use App\Models\GymUserAchievement;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AchievementUnlocked;
use App\Models\GymUser;
use App\Models\User;

class AchievementController extends Controller
{

    public function addAchievement()
    {
        return view('achievement.admin.add');
    }

    public function storeUserAchievement($achievementId, $userId){
        $gymUser = GymUser::where('user_id', $userId)->first();
        if(!$gymUser){
            return redirect()->back()->with('error', 'User not found.');
        }

        GymUserAchievement::create([
            'achievement_id' => $achievementId,
            'gym_user_id' => $gymUser->gym_user_id,
        ]);

        $condition = Achievement::find($achievementId)->condition;
        Notification::send(User::find($userId), new AchievementUnlocked($achievementId, lcfirst($condition)));
        

        return redirect()->route('achievement-all')->with('success', 'Achievement added successfully.');
    }

    public function storeAchievement(Request $request){
        $request->validate([
            'condition' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',

        ]);
        $directory = '/img/achievement';
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }
        $imagePath = $request->file('image')->store($directory, 'public');
        Achievement::create([
            'condition' => $request->condition,
            'image' => $imagePath,
        ]);

        return redirect()->route('achievement-all')->with('success', 'Achievement added successfully.');
    }

    public function allAchievement()
    {
        $achievements = Achievement::all();
        return view('achievement.admin.all',compact('achievements'));
    }

    public function editAchievement($id)
    {
        $achievement = Achievement::findOrFail($id);
        return view('achievement.admin.edit', compact('achievement'));
    }

    public function updateAchievement(Request $request, $id)
    {
        $request->validate([
            'condition' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $achievement = Achievement::findOrFail($id);

        // Check if the image is updated
        if ($request->hasFile('image')) {
            $directory = '/img/equipment';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            // Delete the old image
            if ($achievement->image && Storage::exists($achievement->image)) {
                Storage::delete($achievement->image);
            }

            $imagePath = $request->file('image')->store($directory, 'public');
        } else {
            $imagePath = $achievement->image;
        }
        $achievement->image = $imagePath;
        $achievement->condition = $request->input('condition');
        $achievement->save();

        if(!$achievement->save()){
            return redirect()->route('achievement-all')->with('error', 'Failed to update the achievement.');
        }
        return redirect()->route('achievement-all')->with('success', 'Achievement updated successfully.');
    }

    public function deleteAchievement(Request $request)
    {
        $achievementId = $request->input('id');

        // Find the achievement by ID
        $achievement = Achievement::find($achievementId);

        if ($achievement) {
            // Delete the achievement
            $achievement->delete();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }

}
?>