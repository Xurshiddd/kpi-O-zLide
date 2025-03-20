<?php

namespace App\Services;

use App\Models\Criterion;
use App\Models\Document;
use App\Repositories\DocumentRepository;

class DocumentService
{
    public function __construct(public DocumentRepository $documentRepository){}

    public function store($request)
    {

        $score = 0;
        try {
            foreach ($request->criteria_id as $criteriaId) {
                if (!empty($request->path[$criteriaId] ?? null)) {
                    $data = [
                        'type'        => $request->type[$criteriaId],
                        'path'        => $this->checkData($request->type[$criteriaId], $request->path[$criteriaId]),
                        'user_id'     => auth()->id(),
                        'criteria_id' => $criteriaId,
                        'score'       => Criterion::find($criteriaId)->score,
                    ];
                    $this->documentRepository->save($data);
                    $score += (int) Criterion::find($criteriaId)->score;
                }
            }
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return false;
        }
        return $score;
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
