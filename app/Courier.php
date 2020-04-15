<?php

namespace App;

use App\Http\Requests\CourierStoreRequest;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $fillable = [
        'manager_id', 'name', 'email', 'payment_method',
        'paypal_email', 'address', 'city', 'state', 'zip', 'phone_1', 'phone_2'
    ];

    protected const PAYMENT_METHOD_PAYPAL = 0;
    protected const PAYMENT_METHOD_MONEYGRAMM = 1;

    public static function store(CourierStoreRequest $request): \Illuminate\Http\Response
    {
        try {
            $request = $request->all();
            $couriers = $request['couriers'] ?? [];
            $data = self::prepareDataForInsert($couriers);
            $result = Courier::insert($data);
            return response($result);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    private static function prepareDataForInsert(array $couriers): array
    {
        if (count($couriers) > 0) {
            $data = [];
            foreach ($couriers as $key => $courier) {
                $data[$key] = $courier;
                $data[$key]['manager_id'] = auth()->id();
                $data[$key]['payment_method'] = self::PAYMENT_METHOD_PAYPAL;
            }
            return $data;
        } throw new \Exception('Массив с данными курьеров пуст');
    }

    public function manager()
    {
        $this->belongsTo(Manager::class, 'manager_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
