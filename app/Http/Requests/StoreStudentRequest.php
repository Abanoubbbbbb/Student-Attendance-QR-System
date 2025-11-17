<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use function Symfony\Component\String\s;

class StoreStudentRequest extends FormRequest
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
            'student_code' => 'required|unique:students',
            'name' => 'required|string|max:255',
            'stage' => 'required',
            'class' => 'required',

        ];
    }
    public function massages()
    {
        return [
            'student_code.required' => 'يرجي ادخال كود الطالب',
            'name.required' => 'يرجي ادخال اسم الطالب',
            'stage.required' => 'يرجي ادخال المرحلة',
            'class.required' => 'يرجي ادخال الفصل',
        ];
    }
}
