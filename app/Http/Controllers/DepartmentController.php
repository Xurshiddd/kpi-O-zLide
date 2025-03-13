<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('departments.index', ['departments' => Department::with('category')->paginate(10)]);
    }

    public function create()
    {
        return view('departments.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
        ]);
        Department::create($request->all());
        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }
    public function show(Department $department)
    {

    }
    public function edit(Department $department)
    {
        return view('departments.create', compact('department'));
    }
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
        ]);
        $department->update($request->all());
        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}
