<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'mail' => 'required',
            'limit_date' => 'required|date_format:Y-m-d',
            'exam_start' => 'required|date_format:Y-m-d',
            'exam_finish' => 'required|date_format:Y-m-d',
        ];
    }
}
