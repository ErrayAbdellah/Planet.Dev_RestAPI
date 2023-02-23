<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        switch ($this->method()){
            case 'POST': return [
            ];
            case 'PATCH':
                case 'PUT' : return [
                    // TODO implement this...
                    'name'=>'required',
                    'description'=>'required',
                    'content'=>'required',
                    'title'=>'required',
                    'title'=>'required',
                    
                                ];
            default : return [];
        }

    }
}
