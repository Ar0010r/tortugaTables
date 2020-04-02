<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected array $fillable = [
        'manager_id', 'name', 'email', 'payment_method',
        'paypal_email', 'address', 'city', 'state', 'zip', 'phone_1', 'phone_2'
    ];

    protected const PAYMENT_METHOD_PAYPAL = 0;
    protected const PAYMENT_METHOD_MONEYGRAMM = 1;

    public static function store()
    {
        $request = request()->all();
        $courierDataFields = (new Courier())->fillable;
        $couriersCount = count($request) / count($courierDataFields);

        $data = self::prepareDataForInsert($couriersCount, $courierDataFields) ?? [];

        return Courier::insert($data);
    }

    private static function prepareDataForInsert(int $couriersCount, array $courierDataFields): array
    {
        $data = [];
        for ($i = 0; $i < $couriersCount; $i++) {
            foreach ($courierDataFields as $key => $fieldName) {
                $data[$i][$fieldName] = $request[$fieldName . $i] ?? "";
            };

            $data[$i]['manager_id'] = auth()->id();
            $data[$i]['payment_method'] = self::PAYMENT_METHOD_PAYPAL;
        };

        return $data;
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
