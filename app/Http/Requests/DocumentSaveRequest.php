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
            'path'          => 'required|array',
            'path.*'        => function ($attribute, $value, $fail) {
                $index = str_replace(['path.', 'path[', ']'], '', $attribute); // Index olish

                if (request()->input("type.$index") === 'file') {
                    if (!is_file($value) || !in_array($value->getClientOriginalExtension(), ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'])) {
                        $fail("{$index}-mezon uchun noto‘g‘ri fayl formati yuklandi.");
                    }
                }

                if (request()->input("type.$index") === 'link') {
                    if (!filter_var($value, FILTER_VALIDATE_URL)) {
                        $fail("{$index}-mezon uchun noto‘g‘ri URL kiritildi.");
                    }
                }
            },
        ];
    }
}
