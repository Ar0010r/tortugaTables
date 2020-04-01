<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'courier_id',
        'direction',
        'condition',
        'content',
        'quantity',
        'price',
        'shop',
        'tracking_number',
        'holder'
    ];

    protected const TEST_DIRECTION = 0;
    protected const FOR_SELL_DIRECTION = 1;
    protected const FOR_US_DIRECTION = 2;


    public $timestamps = true;

    public static function store()
    {
        $request = request()->all();
        $data = [];
        $formFields = (new Order())->fillable;
        $ordersCount = count($request) / count($formFields);

        for ($i = 0; $i < $ordersCount; $i++) {
            foreach ($formFields as $key => $fieldName) {
                $data[$i][$fieldName] = $request[$fieldName . $i] ?? "";
            };
            $courierName = $request['name' . $i];
            $courierId = Courier::where('name', $courierName)->get('id');

            if (count($courierId) == 1) {
                $courierId = $courierId->pluck('id')[0];
                $data[$i]['courier_id'] = $courierId;
            } else {
                return 'Есть ' . count($courierId) . ' курьеров с именем ' . $courierName .
                    'пожалуйста удалите этот заказ и добавьте его вручную';
            };
            $data[$i]['direction'] = self::TEST_DIRECTION;
        }
        return Order::insert($data);
    }

    public function courier()
    {
        $this->belongsTo(Courier::class, 'courier_id', 'id');
    }
}
