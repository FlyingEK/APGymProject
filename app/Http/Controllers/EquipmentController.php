<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        return view('equipment.index');
    }

    public function viewEquipment()
    {
        return view('equipment.view');
    }

    public function addEquipment()
    {
        return view('equipment.admin.add');
    }

    public function viewAllEquipment()
    {
        return view('equipment.admin.all');
    }

    public function adminViewEquipment()
    {
        return view('equipment.admin.view');
    }

    public function editEquipment()
    {
        return view('equipment.admin.edit');
    }

}
?>