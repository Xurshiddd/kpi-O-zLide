<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Confirmation;
use App\Models\Criterion;
use App\Models\Department;
use App\Models\Document;
use App\Models\Notification;
use App\Models\User;
use App\Repositories\DocumentRepository;
use Illuminate\Http\Request;

class DocumentService
{
    public function __construct(public DocumentRepository $documentRepository){}

    public function index($request)
    {
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

        $users = $users->with(['department', 'documents'])->whereNotIn('id', [1])->paginate(15);
        return $users;
    }

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

    public function documentShow($user, $request)
    {
        $query = User::with(['documents' => function ($q) use ($request) {
            if ($request->filled('year')) {
                $q->whereYear('created_at', $request->year);
            }
            if ($request->filled('month')) {
                $q->whereMonth('created_at', $request->month);
            }
        }])->find($user);

        return $query;
    }

    public function confirm($request)
    {
        try {
            if ($request->document_id){
                $doc = Document::find($request->document_id);
                $old = $doc->score;
                $doc->update([
                    'score' => $request->score,
                ]);
                Confirmation::create([
                    'document_id' => $request->document_id,
                    'user_id' => auth()->id(),
                    'old_score' => $old,
                    'after_score' => $request->score,
                ]);
            }else {
                $user = User::find($request->user_id);
                foreach ($user->documents as $document) {
                    Confirmation::create([
                        'document_id' => $document->id,
                        'user_id' => auth()->id(),
                        'old_score' => $document->score ? $document->score : 0,
                        'new_score' => $document->score ? $document->score : 0,
                    ]);
                }
                $score = $user->documents->sum('score');
                Notification::create([
                    'user_id' => $user->id,
                    'message' => "Sizning hujjatingiz $score ball bilan baholandi.",
                ]);
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
