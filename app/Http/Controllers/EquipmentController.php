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
        $equipment = Equipment::all();
        // Pass the data to the view
        return view('equipment.all', compact('equipment'));
    }

    public function viewEquipment($id)
    {
        $equipment = Equipment::with(['tutorials', 'equipmentMachines'])->findOrFail($id);
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
            'has_weight' => 'required|boolean',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'quantity' => 'nullable|integer',
            'tutorial_youtube' => 'nullable|url|max:2083',
            'instructions' => 'sometimes|array',
            'instructions.*' => 'nullable|string|max:500',
            'labels' => 'sometimes|array',
            'labels.*' => 'nullable|string|max:255',
        ]);
        $directory = '/img/equipment';
        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory);
        }
        $imagePath = $request->file('image')->store($directory, 'public');

        $equipment = Equipment::create([
            'name' => $request->name,
            'description' => $request->description,
            'has_weight' => $request->has_weight,
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
         if ($request->has('labels')) {
            foreach ($request->labels as $label) {
                $equipment->equipmentMachines()->create(['label' => $label]);
            }
        }

        return redirect()->route('equipment-all')->with('success', 'Equipment added successfully.');
    }

    public function viewAllEquipment()
    {
        $equipment = Equipment::all();
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

    public function timeExceededEquipment()
    {
        return view('equipment.trainer.time-exceeded');
    }
}
?>