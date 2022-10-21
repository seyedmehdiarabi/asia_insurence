<?php

namespace Modules\products\Http\Requests;

use App\Http\Requests\CFormRequest;

class ProductRequest extends CFormRequest
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
            'title'=>'required',
            'cat_id'=>'required',
            'brand_id'=>'required',
            'unit_id'=>'required',
        ];
    }
    public function attributes()
    {
        return [
            'title'=>'عنوان محصول',
            'cat_id'=>'دسته محصول',
            'brand_id'=>'برند محصول',
            'unit_id'=>'واحد محصول',
        ];
    }
}
