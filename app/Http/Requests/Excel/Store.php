<?php

namespace App\Http\Requests\Excel;

use Illuminate\Foundation\Http\FormRequest;

class Store extends FormRequest
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

    public function prepareForValidation()
    {
        $data = json_decode(request('data'));
        $formattedData = [];
        foreach ($data as $row) {
            $formattedData[] = [
                'nama' => $row[0],
                'email' => $row[1],
            ];
        }

        $this->merge(['data' => $formattedData]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'data.*.nama' => ['required'],
            'data.*.email' => ['required'],
        ];
    }
}
