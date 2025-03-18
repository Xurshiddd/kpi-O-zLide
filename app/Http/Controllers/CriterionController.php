<?php

namespace App\Http\Controllers;

use App\Models\Criterion;
use App\Models\Department;
use Illuminate\Http\Request;

class CriterionController extends Controller
{
    public function index()
    {
        return view('criterion.index', ['criterions' => Criterion::with('department')->get()]);
    }
    public function create()
    {
        $departments = Department::all();
        return view('criterion.create', ['departments' => $departments]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'department_id' => 'required',
            'score' => 'required',
        ]);
        Criterion::create($request->all());
        return redirect()->route('criterion.index')->with('success', 'Criterion created successfully');
    }

    public function edit(Criterion $criterion)
    {
        $departments = Department::all();
        return view('criterion.create', ['criterion' => $criterion, 'departments' => $departments]);
    }
    public function update(Request $request, Criterion $criterion)
    {
        $request->validate([
            'name' => 'required',
            'department_id' => 'required',
            'score' => 'required',
        ]);
        $criterion->update($request->all());
        return redirect()->route('criterion.index')->with('success', 'Criterion updated successfully');
    }
    public function destroy(Criterion $criterion)
    {
        $criterion->delete();
        return redirect()->route('criterion.index')->with('success', 'Criterion deleted successfully');
    }
}
