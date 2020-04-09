<?php

namespace App\Http\Requests;

use App\Rules\UniqueName;
use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'orders.*.content' => 'required|string',
            'orders.*.quantity' => 'required|integer',
            'orders.*.price' => 'required|integer',
            'orders.*.tracking_number' => 'required|integer',
            'orders.*.holder' => 'nullable|string',
            'orders.*.shop' => 'nullable|string'
        ];
    }
}
