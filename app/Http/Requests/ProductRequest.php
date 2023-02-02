<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'        => 'required|unique:products|string|min:3|max:255',
            'price'       => 'required|numeric',
            'description' => 'required|string',
            'category'    => 'required|string|max:255',
            'image_url'   => 'url|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório',
            'name.unique' => 'O nome não pode ser o mesmo de um produto existente',
            'name.string'   => 'O nome precisa ser uma string',
            'name.min'      => 'O nome precisa ter no mínimo 3 caracteres',
            'name.max'      => 'O nome precisa ter no máximo 255 caracteres',

            'price.required' => 'O preço é obrigatório',
            'price.numeric'  => 'O preço precisa ser um número',
    
            'description.required' => 'A descrição é obrigatória',
            'description.required' => 'A descrição precisa ser uma string',
    
            'category.required' => 'A categoria é obrigatória',
            'category.string'   => 'A categoria precisa ser uma string',
            'category.max'      => 'A categoria precisa ter no máximo 255 caracteres',

            'image_url.url' => 'A url da imagem precisa ser válida',
            'image_url.max' => 'A url da imagem precisa ter no máximo 255 caracteres',
        ];
    }
}
