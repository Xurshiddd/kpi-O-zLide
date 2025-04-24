<?php

namespace App\Services;

use App\Models\Confirmation;
use App\Models\Criterion;
use App\Models\Document;
use App\Models\Notification;
use App\Models\User;
use App\Repositories\DocumentRepository;
use DB;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Style\Table;
use PhpOffice\PhpWord\Style\Cell;
use PhpOffice\PhpWord\Style\Font;
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
        $ids = DB::table('users')
        ->join('model_has_roles as m', 'm.model_id', '=', 'users.id')
        ->whereIn('m.role_id', [1,2,3])
        ->pluck('id');

        $users = $users->with(['department', 'documents'])->whereNotIn('id', $ids->toArray())->paginate(15);
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
                if ((int)$old<(int)$request->score){
                    return redirect()->back()->with('error', 'Siz Eng yuqori balldan baland ball qo\'yolmaysiz');
                }
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
    public function exportUsersDocx()
    {
//        $users = User::with('department') // Department bilan bog'lanadi
//        ->withSum('documents as total_score', 'score') // Umumiy ball
//        ->get();
        $phpWord = new PhpWord();
        $section = $phpWord->addSection();

// ✅ Shapka qo'shish
        $section->addText(
            "O‘zLiDeP Siyosiy Kengashi Ijroiya qo‘mitasi apparati hamda hududiy va\ntuman (shahar) Kengashlari mas’ul xodimlarining faoliyati\nsamaradorligini baholash va ularni munosib rag‘batlantirish bo‘yicha\nkomissiya yig‘ilishi qaroriga\n1-ilova",
            ['name' => 'Times New Roman', 'size' => 14, 'italic' => true, 'alignment' => 'center']
        );
        $section->addTextBreak(1);

        $section->addText(
            "O‘zLiDeP Siyosiy Kengashi Ijroiya qo‘mitasi apparati xodimlarining\nKPI natijalariga ko‘ra mart oyi yakunlari munosabati bilan\nrag‘batlantiruvchi tо‘g‘risida\n\nRЎYXAT",
            ['name' => 'Times New Roman', 'size' => 14, 'bold' => true, 'alignment' => 'center']
        );
        $section->addTextBreak(1);

// ✅ Jadval uchun uslub sozlash
        $styleTable = [
            'borderSize' => 6,
            'borderColor' => '000000',
            'cellMargin' => 80,
        ];
        $phpWord->addTableStyle('UserTable', $styleTable);

// ✅ Jadval yaratish
        $table = $section->addTable('UserTable');

// Sarlavha qatori
        $table->addRow();
        $table->addCell(500, ['bgColor' => 'FFFF00'])->addText("№", ['bold' => true]);
        $table->addCell(4000, ['bgColor' => 'FFFF00'])->addText("F.I.SH, tug'ilgan yili va joyi, millati", ['bold' => true]);
        $table->addCell(3000, ['bgColor' => 'FFFF00'])->addText("Lavozimi", ['bold' => true]);
        $table->addCell(1500, ['bgColor' => 'FFFF00'])->addText("Umumiy ball", ['bold' => true]);
        $table->addCell(1500, ['bgColor' => 'FFFF00'])->addText("Foizda (%)", ['bold' => true]);

// ✅ User ma'lumotlari (bazadan oling)
        $users = [
            ['name' => 'Admin Admin', 'position' => '1-bo\'lim', 'score' => 86, 'percentage' => 20],
            ['name' => 'Rajah Bray', 'position' => '1-bo\'lim', 'score' => 75, 'percentage' => 18],
            ['name' => 'Kitra Le', 'position' => '2-bo\'lim', 'score' => 65, 'percentage' => 15],
        ];

// ✅ Har bir user uchun yangi qator qo'shish
        $counter = 1;
        foreach ($users as $user) {
            $table->addRow();
            $table->addCell(500)->addText($counter++);
            $table->addCell(4000)->addText($user['name']);
            $table->addCell(3000)->addText($user['position']);
            $table->addCell(1500)->addText($user['score']);
            $table->addCell(1500)->addText($user['percentage']);
        }

// ✅ Faylni saqlash
        $savePath = public_path('uploads/dock/Foydalanuvchilar_Malumoti.docx');
        $phpWord->save($savePath, 'Word2007', true);
    }
}
