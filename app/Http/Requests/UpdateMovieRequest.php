<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateMovieRequest extends FormRequest
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
        // $this->merge([
        //     'is_showing' => $this->has('is_showing') && $this->is_showing !== 'false'
        // ]);

        if($this->has('is_showing') && $this->is_showing !== null){
            $this->merge([
                'is_showing' => $this->is_showing !== 'false'
            ]);
        }

        if(!$this->has('id')){
            $this->merge([
                'id' => $this->route('movie')->id
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'exists:movies'],
            'title' => ['required', Rule::unique('movies')->ignore($this->id)],
            'image_url' => ['required', 'url'],
            'published_year' => ['required', 'gte:1900'],
            'description' => ['required'],
            'is_showing' => ['required', 'boolean'],
            'genre' => ['required'],
        ];
    }
}
