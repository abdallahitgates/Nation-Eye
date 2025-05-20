<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
            'report_no' => 'required|unique:reports,report_no',
            'report_type_id' => 'required|exists:report_types,id',
            'description' => 'required|string',
            'location' => 'nullable|string',
            'll' => 'nullable',
            'lg' => 'nullable',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mp3,wav,pdf|max:20480',
        ];
    }
    public function attributes(): array
    {
        return [
            'report_no' => 'رقم البلاغ',
            'report_type_id' => 'نوع البلاغ',
            'description' => 'نص البلاغ',
            'location' => 'الموقع',
            'll' => 'خط العرض',
            'lg' => 'خط الطول',
            'file' => 'الملف',
        ];
    }
}
