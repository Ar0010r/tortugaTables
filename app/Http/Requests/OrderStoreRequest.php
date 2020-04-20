<?php

namespace App\Http\Requests;

use App\Rules\UniqueName;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends ApiRequest
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
            'orders.*.name' => ['required', 'string', 'exists:couriers,name', new UniqueName()],
            'orders.*.content' => 'required',
            'orders.*.quantity' => 'required|integer',
            'orders.*.price' => 'required|integer',
            'orders.*.holder' => 'nullable|string',
        ];
    }

    /**
     * Get the validation error messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'orders.*.name.required' => 'Введите имя',
            'orders.*.name.string' => 'В имени допустимы только буквы',
            'orders.*.name.exists' => 'Курьера с именем :input нет в базе данных',
            'orders.*.content.required' => 'Введите содержимое',
            'orders.*.quantity.required' => 'Введите количество',
            'orders.*.quantity.integer' => 'Количество должно быть целым числом',
            'orders.*.price.required' => 'Введите цену',
            'orders.*.price.integer' => 'Цена должна быть целым числом',
            'orders.*.holder.string' => 'В имени холдера допустимы только буквы',
        ];
    }
}
