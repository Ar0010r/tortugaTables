<?php

namespace App;

use App\Http\Requests\OrderStoreRequest;
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

    public static function store(OrderStoreRequest $request): \Illuminate\Http\Response
    {
        try {
            $request = $request->all();
            $orders = $request['orders'] ?? [];
            $data = self::prepareDataForInsert($orders);
            $result = Order::insert($data);
            return response($result);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    private static function prepareDataForInsert(array $orders): array
    {
        try {
            if (count($orders) > 0) {
                $data = [];
                foreach ($orders as $key => $order) {
                    $courierName = $order['name'];
                    $courierId = self::getCourierId($courierName);

                    $order['courier_id'] = $courierId;
                    $order['direction'] = self::TEST_DIRECTION;

                    unset($order['name']);

                    $data[$key] = $order;
                }
                return $data;
            }
            throw new \Exception('Массив с данными о заказах пуст');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    private static function getCourierId(string $courierName): int
    {
        $couriersIds = Courier::where('name', $courierName)->get('id');
        $courierId = $couriersIds->pluck('id')[0];
        if (is_int($courierId)) {
            return $courierId;
        }
        throw new \Exception('некак считать айди курьера');
    }

    public function courier()
    {
        $this->belongsTo(Courier::class, 'courier_id', 'id');
    }
}
