<?php

namespace App\Services;

use App\Models\Document;
use App\Repositories\DocumentRepository;

class DocumentService
{
    public function __construct(public DocumentRepository $documentRepository){}

    public function store($request)
    {
        $data = [];
        try {
            for ($i = 0; $i < count($request->path); $i++) {
                $data['type'] = $request->type[$request->criteria_id[$i]];
                $data['path'] = $this->checkData($request->type[$request->criteria_id[$i]], $request->path[$request->criteria_id[$i]]);
                $data['user_id'] = auth()->id();
                $data['criteria_id'] = $request->criteria_id[$i];
                $this->documentRepository->save($data);
            }
        }catch (\Exception $exception){
            \Log::error($exception->getMessage());
            return false;
        }
        return true;
    }
    protected function checkData($type, $path)
    {

        if ($type === 'file') {
            $filename = 'uploads/documents/'.$path->hashName();
            $path->move(public_path('uploads/documents/'), $path->hashName());
            return $filename;
        }else {
            return $path;
        }
    }
}
