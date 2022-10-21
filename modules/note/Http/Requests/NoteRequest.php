<?php

namespace Modules\note\Http\Requests;

use App\Http\Requests\CFormRequest;

class NoteRequest extends CFormRequest
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
        $rules=[
            'title'=>'required',
            'date'=>'required|date',
        ];
        return  $rules;
    }
    public function attributes()
    {
        return [
            'title'=>'عنوان یادداشت',
            'date'=>'تاریخ یادآروی',
        ];
    }

}

