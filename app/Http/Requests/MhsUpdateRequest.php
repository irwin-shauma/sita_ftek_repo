<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Models\Mahasiswa;


class MhsUpdateRequest extends FormRequest
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
        $id = $this->request->get('mhs_id');
        return [
            'name' => ['required'],
            // 'nim' => ['required',  Rule::unique('mahasiswa')->ignore($user->id)],
            // Syntaxnya unique:table,column,except,idColumn 
            'nim' => ['required', "unique:mahasiswa,nim,$id"],

        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Silahkan diisi!',
            'nim.required' => 'Silahkan diisi!',
            'nim.unique' => 'Nim sudah ada!',
        ];
    }
}
