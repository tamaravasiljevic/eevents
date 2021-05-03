<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
//        dd(request()->all());
        return [
            'name' => 'required|min:5|max:255',
            'slug' => 'required',
            'company_id'    =>  'required',
            'venue_id'      => 'required',
            'description'   => 'required',
            'currency'      => 'required|max:3',
            'visibility'    => 'required',
            'status'        => 'required',
            'total_capacity'=> 'required|integer',
            'event_type_id' => 'required',
            'sold_out'      => 'required',
//            'starts_at'     => 'required',
//            'ends_at'     => 'required',
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
