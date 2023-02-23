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
            case 'POST':
                return [
                    'title' => 'required|min:6',
                    'content' => 'required|min:6',
                    'description' => 'required|min:6',
                    'category_id' => 'required|integer|exists:categories,id',
                    'tags' => 'array',
                    'tags.*' => 'integer|exists:tags,id',
                ];
            case 'PATCH':
            case 'PUT' : return [
                                    // TODO implement this...
                                ];
            default : return [];
        }

    }
}
