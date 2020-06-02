<?php

namespace App\Http\Requests\Formulasi;

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

        foreach ($data as $index => $row) {
            $formattedData[] = [
                'Idx' => $row[0],
                // 'Kode' => $row[1],
                'FormID' => $row[1],
                'ItemName' => $row[3],
                'WT' => filter_var($row[4], FILTER_SANITIZE_NUMBER_INT),
                'PersenWT' => filter_var($row[5], FILTER_SANITIZE_NUMBER_INT),
                'WT1' => filter_var($row[6], FILTER_SANITIZE_NUMBER_INT),
                'PersenWT1' => filter_var($row[7], FILTER_SANITIZE_NUMBER_INT),
                'Note' => filter_var($row[8])
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
            // 'data.*.Kode' => ['required'],
            'data.*.ItemName' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            // 'data.*.Kode.required' => 'Kode wajib diisi',
            'data.*.ItemName.required' => 'Item Name wajib diisi',
        ];
    }
}
