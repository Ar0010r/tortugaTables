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
    protected const FOR_SERVICE_DIRECTION = 3;

    public static function store()
    {
        $request = request()->all();
        $formFields = (new Order())->fillable;
        $ordersCount = count($request) / count($formFields);
        $data = self::prepareDataForInsert($ordersCount, $formFields);
        return Order::insert($data);
    }

    private static function prepareDataForInsert(int $ordersCount, array $formFields)
    {
        $data = [];
        for ($i = 0; $i < $ordersCount; $i++) {
            foreach ($formFields as $key => $fieldName) {
                $data[$i][$fieldName] = $request[$fieldName . $i] ?? "";
            };

            $courierName = $request['name' . $i] ?? "";

            $courierId = self::getCourierId($courierName);

            if ($courierId) {
                $data[$i]['courier_id'] = $courierId;
                $data[$i]['direction'] = self::TEST_DIRECTION;
            } else {
                return 'Есть несколько курьеров с именем ' . $courierName .
                    'пожалуйста удалите строку с этим заказом и добавьте его с админки';
            }
        }

        return $data;
    }

    private static function getCourierId(string $courierName)
    {
        $couriersIds = Courier::where('name', $courierName)->get('id');

        if (count($couriersIds) === 1) {
            $courierId = $couriersIds->pluck('id')[0];
            return $courierId;
        } else {
            return false;
        }
    }

    public function courier()
    {
        $this->belongsTo(Courier::class, 'courier_id', 'id');
    }
}
