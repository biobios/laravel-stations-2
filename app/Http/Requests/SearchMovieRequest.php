<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchMovieRequest extends FormRequest
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

    public $doFilterByKeyword = false;
    public $doFilterByIsShowing = false;

    public function prepareForValidation()
    {
        if($this->has('keyword')){
            $this->doFilterByKeyword = true;
        }

        if($this->has('is_showing') && ($this->is_showing === '0' or $this->is_showing === '1')){
            $this->doFilterByIsShowing = true;
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
            //
        ];
    }

    public function search($query)
    {
        if($this->doFilterByKeyword){
            $query->searchByKeyword($this->keyword);
        }

        if($this->doFilterByIsShowing){
            $query->matchByIsShowing($this->is_showing);
        }

        return $query;
    }

    /**
     * パラメータのリストを取得する
     */
    public function getParams()
    {
        $params = [];
        if($this->doFilterByKeyword){
            $params['keyword'] = $this->keyword;
        }

        if($this->doFilterByIsShowing){
            $params['is_showing'] = $this->is_showing;
        }

        return $params;
    }
}
