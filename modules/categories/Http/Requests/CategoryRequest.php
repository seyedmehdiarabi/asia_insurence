<?php

namespace Modules\categories\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
        $array=[
            'name'=>'required',
            'pic' => 'mimes:jpeg,gif,png'
        ];
        if(empty($this->request->get('ename')))
        {
            $array['search_url']='required';
        }
        else{
            $array['ename']='unique:category,ename,'.$this->category;
        }
        return $array;
    }
    public function attributes()
    {
        return [
            'name'=>'نام دسته',
            'pic'=>'ایکون دسته',
            'ename'=>'نام انگلیسی دسته'
        ];
    }
    public function messages()
    {
        return [
            'search_url.required'=>'برای دسته باید نام لاتین یا url ثبت شود'
        ];
    }
}
