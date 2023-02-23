<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
                'content' => 'required',
                'user_id' => 'required|exists:users,id',
                'article_id' => 'required|exists:articles,id'
            ];
            case 'PATCH':
            case 'PUT' : return [
                // TODO implement this...
            ];
            default : return [];
        }
    }
}
