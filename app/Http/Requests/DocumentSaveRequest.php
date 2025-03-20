<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'criteria_id'   => 'required|array',
            'criteria_id.*' => 'exists:criteria,id',
            'type'          => 'required|array',
            'type.*'        => 'in:file,link',
            'path'          => 'nullable|array',
            'path.*'        => function ($attribute, $value, $fail) {
                $index = str_replace(['path.', 'path[', ']'], '', $attribute);
                $type = request()->input("type.$index");

                $today = now(); // Bugungi sana
                $userId = auth()->id(); // Foydalanuvchi ID
                $criteriaId = request()->input("criteria_id.$index");

                // 🛑 Ushbu criteria uchun foydalanuvchi shu oyda yuklaganmi?
                $exists = \App\Models\Document::where('user_id', $userId)
                    ->where('criteria_id', $criteriaId)
                    ->whereMonth('created_at', $today->month)
                    ->whereYear('created_at', $today->year)
                    ->exists();

                if ($exists) {
                    $fail("{$criteriaId}-mezon uchun ushbu oyda hujjat allaqachon yuklangan.");
                    return;
                }

                if ($today->day <= 25) {
                    $fail("Hujjat yuklash faqat oyning 26-sanasidan boshlab mumkin.");
                    return;
                }

                // 📝 Agar path mavjud bo‘lsa, tekshirish!
                if (!is_null($value)) {
                    if ($type === 'file') {
                        if (!($value instanceof \Illuminate\Http\UploadedFile) ||
                            !in_array($value->getClientOriginalExtension(), ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])) {
                            $fail("{$criteriaId}-mezon uchun noto‘g‘ri fayl yuklandi.");
                        }
                    }

                    if ($type === 'link') {
                        if (!filter_var($value, FILTER_VALIDATE_URL)) {
                            $fail("{$criteriaId}-mezon uchun noto‘g‘ri URL kiritildi.");
                        }
                    }
                }
            },
        ];
    }
}
