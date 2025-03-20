<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentSaveRequest;
use App\Models\Category;
use App\Models\Department;
use App\Models\Document;
use App\Models\User;
use App\Repositories\DocumentRepository;
use App\Services\DocumentService;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function __construct(
        public DocumentRepository $documentRepository,
        public DocumentService $documentService
    ){}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::all();
        $departments = Department::all();

        $users = User::query();

        if ($request->filled('category_id')) {
            $users->whereHas('department', function ($query) use ($request) {
                $query->where('category_id', $request->category_id);
            });
        }

        if ($request->filled('department_id')) {
            $users->where('department_id', $request->department_id);
        }

        if ($request->filled('search')) {
            $users->where(function ($query) use ($request) {
                $query->where('first_name', 'like', "%{$request->search}%")
                    ->orWhere('last_name', 'like', "%{$request->search}%");
            });
        }

        $users = $users->with('department')->paginate(15);

        return view('documents.index', compact('users', 'categories', 'departments'));
    }
    public function getDepartmentsByCategory($categoryId)
    {
        $departments = Department::where('category_id', $categoryId)->get();
        return response()->json($departments);
    }

    // 📌 AJAX: Departament bo‘yicha foydalanuvchilarni olish
    public function getUsersByDepartment($departmentId)
    {
        $users = User::where('department_id', $departmentId)->get();
        return response()->json($users);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $criterion = $this->documentRepository->getByCritery();
        return view('documents.create', compact('criterion'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DocumentSaveRequest $request)
    {
        $saved = $this->documentService->store($request);
        if($saved === false){
            return redirect()->back()->with('error', $saved);
        }
        return redirect()->back(201)->with('success', $saved);
    }

    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Document $document)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Document $document)
    {
        //
    }
}
