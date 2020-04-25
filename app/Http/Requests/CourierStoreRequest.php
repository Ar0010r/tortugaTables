<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourierStoreRequest extends ApiRequest
{
    private const STATES =
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
            'couriers.*.email' => 'required|email|unique:couriers,email|unique:couriers,paypal_email',
            'couriers.*.paypal_email' => 'nullable|email|unique:couriers,email|unique:couriers,paypal_email',
            'couriers.*.city' => 'required|string',
            'couriers.*.state' => 'required|string|in:' . self::STATES,
            'couriers.*.zip' => 'required|regex:/^\d{5}(-\d{4})?$/',
            'couriers.*.phone_1' => 'required|regex:/^\d{3}-\d{3}-\d{4}$/',
            'couriers.*.phone_2' => 'nullable|regex:/^\d{3}-\d{3}-\d{4}$/',
        ];
    }

    /**
     * Get the validation error messages that apply to the request.
     * @return array
     */
    public function messages()
    {
        return [
            'couriers.*.name.required' => 'Введите имя',
            'couriers.*.name.string' => 'Имя не должно содержать ничего кроме букв',
            'couriers.*.email.required' => 'Введите имейл',
            'couriers.*.email.email' => 'Введите валидный имейл',
            'couriers.*.email.unique' => 'Курьер с имейлом :input уже есть в базе данных ' .
                'удалите его из формы, нажав на крестик',
            'couriers.*.paypal_email.email' => 'Введите валидный пейпал имейл',
            'couriers.*.paypal_email.unique' => 'Курьер с имейлом :input уже есть в базе данных ' .
                'удалите его из формы, нажав на крестик',
            'couriers.*.city.required' => 'Введите город',
            'couriers.*.city.string' => 'В имени города не должно быть ничего кроме букв',
            'couriers.*.state.required' => 'Введите штат',
            'couriers.*.state.string' => 'В имени штата не должно быть ничего кроме букв',
            'couriers.*.state.in' => 'Введите штат в двухбуквенном формате',
            'couriers.*.zip.required' => 'Введите зип код',
            'couriers.*.zip.regex' => 'ВВедите валидный зип код',
            'couriers.*.phone_1.required' => 'Введите телефон',
            'couriers.*.phone_1.regex' => 'Введите телефон в формате ххх-ххх-хххх',
            'couriers.*.phone_2.required' => 'Введите телефон',
            'couriers.*.phone_2.regex' => 'Введите телефон в формате ххх-ххх-хххх',
        ];
    }

}
