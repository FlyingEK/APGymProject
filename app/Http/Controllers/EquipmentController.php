<?php
namespace App\Http\Controllers;
use App\Models\Equipment;
use App\Models\EquipmentMachine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index()
    {

        return view('equipment.index');
    }

    public function allEquipment()
    {
        // Fetch all equipment data
        $equipment = Equipment::where('is_deleted', false)->get();
        // Pass the data to the view
        return view('equipment.all', compact('equipment'));
    }

    public function viewEquipment($id)
    {
        $equipment = Equipment::with(['tutorials', 'equipmentMachines'])
        ::where('is_deleted', false)
        ->findOrFail($id);
        return view('equipment.view', compact('equipment'));
    }

    public function addEquipment()
    {
        return view('equipment.admin.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category' => 'required|in:upper body machines,leg machines,cardio machines,free weightss',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'quantity' => 'nullable|integer',
            'tutorial_youtube' => 'nullable|url|max:2083',
            'instructions' => 'sometimes|array',
            'instructions.*' => 'nullable|string|max:500',
            'machineLabels' => 'sometimes|array',
            'machineLabels.*' => 'nullable|string|max:255',
        ]);
        $directory = '/img/equipment';
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }
        $imagePath = $request->file('image')->store($directory, 'public');

        $equipment = Equipment::create([
            'name' => $request->name,
            'description' => $request->description,
            'category'=> $request->category,
            'has_weight' => $request->category === 'cardio machines'? false : true,
            'image' => $imagePath,
            'quantity' => $request->quantity,
            'tutorial_youtube' => $request->tutorial_youtube,
        ]);

        //instruction
        // Create tutorials
        if ($request->has('instructions')) {
            foreach ($request->instructions as $instruction) {
                $equipment->tutorials()->create(['instruction' => $instruction]);
            }
        }

         // Save the equipment labels
         if ($request->has('machineLabels')) {
            foreach ($request->machineLabels as $label) {
                $equipment->equipmentMachines()->create(['label' => $label]);
            }
        }

        return redirect()->route('equipment-all')->with('success', 'Equipment added successfully.');
    }

    public function viewAllEquipment()
    {
        $equipment = Equipment::where('is_deleted', false)->get();
        return view('equipment.admin.all', compact('equipment'));
    }

    public function adminViewEquipment($id)
    {
        $equipment = Equipment::with(['tutorials', 'equipmentMachines'])->findOrFail($id);
        return view('equipment.admin.view', compact('equipment'));
    }

    public function editEquipment($id)
    {
        $equipment = Equipment::with(['tutorials', 'equipmentMachines'])->findOrFail($id);
        return view('equipment.admin.edit', compact('equipment'));
    }

    public function updateEquipment(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'category' => 'required|in:upper body machines,leg machines,free weights,cardio machines',
            'quantity' => 'required|integer|min:1|max:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tutorial_youtube' => 'nullable|url|max:2083',
            'instructions' => 'sometimes|array',
            'instructions.*' => 'nullable|string|max:500',
            'machineLabels' => 'sometimes|array',
            'machineLabels.*' => 'nullable|string|max:255',
        ]);

        $equipment = Equipment::findOrFail($id);

        // Check if the image is updated
        if ($request->hasFile('image')) {
            $directory = '/img/equipment';
            if (!Storage::exists($directory)) {
                Storage::makeDirectory($directory);
            }

            // Delete the old image
            if ($equipment->image && Storage::exists($equipment->image)) {
                Storage::delete($equipment->image);
            }

            $imagePath = $request->file('image')->store($directory, 'public');
        } else {
            $imagePath = $equipment->image;
        }

        $equipment->update([
            'name' => $request->name,
            'description' => $request->description,
            'category' => $request->category,
            'quantity' => $request->quantity,
            'image' => $imagePath,
            'tutorial_youtube' => $request->tutorial_youtube,
        ]);

        // Update instructions
        $equipment->tutorials()->delete();
        if ($request->has('instructions')) {
            foreach ($request->instructions as $instruction) {
                $equipment->tutorials()->create(['instruction' => $instruction]);
            }
        }

        // Update equipment machines
        $equipment->equipmentMachines()->delete();
        if ($request->has('machineLabels')) {
            foreach ($request->machineLabels as $label) {
                $equipment->equipmentMachines()->create(['label' => $label]);
            }
        }

        return redirect()->route('equipment-admin-view',$equipment->equipment_id)->with('success', 'Equipment updated successfully.');
    }

    public function timeExceededEquipment()
    {
        return view('equipment.trainer.time-exceeded');
    }
}
?>