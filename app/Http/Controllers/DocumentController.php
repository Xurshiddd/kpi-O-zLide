<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentSaveRequest;
use App\Models\Document;
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
    public function index()
    {
        $criterion = $this->documentRepository->getByCritery();
        return view('documents.index', compact('criterion'));
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
