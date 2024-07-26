<?php
namespace App\Http\Controllers;
use App\Models\GymConstraint;
use Illuminate\Http\Request;

class ConstraintController extends Controller
{
    public function viewConstraint($id)
    {
        $constraint = GymConstraint::findOrFail($id);
        return view('constraint.view', compact('constraint'));
    }

    public function addConstraint()
    {
        return view('constraint.add');
    }

    public function storeConstraint(Request $request){
        $request->validate([
            'constraint_name' => 'required|string|max:255',
            'constraint_value' => 'required|string|max:255',

        ]);

        GymConstraint::create([
            'constraint_name' => $request->constraint_name,
            'constraint_value' => $request->constraint_value,
        ]);

        return redirect()->route('constraint-all')->with('success', 'Constraint added successfully.');
    }

    public function allConstraint()
    {
        $constraints = GymConstraint::all();
        return view('constraint.all',compact('constraints'));
    }

    public function editConstraint($id)
    {
        $constraint = GymConstraint::findOrFail($id);
        return view('constraint.edit', compact('constraint'));
    }

    public function deleteConstraint(Request $request)
    {
        $constraintId = $request->input('id');

        $constraint = GymConstraint::find($constraintId);

        if ($constraint) {
            $constraint->delete();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false]);
        }
    }


    public function updateConstraint(Request $request, $id)
    {
        $request->validate([
            'constraint_name' => 'required|string|max:255',
            'constraint_value' => 'required|string|max:255',
        ]);

        $constraint = GymConstraint::findOrFail($id);
        $constraint->constraint_name = $request->input('constraint_name');
        $constraint->constraint_value = $request->input('constraint_value');
        $constraint->save();

        if(!$constraint->save()){
            return redirect()->back()->with('error', 'Failed to update the constraint.');
        }
        return redirect()->route('constraint-view', $id)->with('success', 'Constraint updated successfully.');
    }


}
?>