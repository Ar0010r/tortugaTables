<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourierStoreRequest extends FormRequest
{
    private $states =
        'AL,AK,AS,AZ,AR,CA,CO,CT,DE,DC,FM,FL,GA,GU,HI,ID,IL,IN,IA,KS,KY,LA,ME,MH,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,
        NC,ND,MP,OH,OK,OR,PW,PA,PR,RI,SC,SD,TN,TX,UT,VT,VI,VA,WA,WV,WI,WY,AE,AA,AP';

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
            'couriers.*.name' => 'required|string',
            'couriers.*.email' => 'required|email',
            //'couriers.*.email' => 'required|email|unique:couriers,email|unique:couriers,paypal_email',
            'couriers.*.paypal_email' => 'nullable|email',
            //'couriers.*.paypal_email' => 'nullable|email|unique:couriers,email|unique:couriers,paypal_email',
            'couriers.*.city' => 'required|string',
            'couriers.*.state' => 'required|string|in:' . $this->states,
            'couriers.*.zip' => 'required|regex:/^\d{5}(-\d{4})?$/',
            'couriers.*.phone_1' => 'required|regex:/^\d{3}-\d{3}-\d{4}$/',
            'couriers.*.phone_2' => 'nullable|regex:/^\d{3}-\d{3}-\d{4}$/',
        ];
    }
}
