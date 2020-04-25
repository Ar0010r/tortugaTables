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

    /**
     * Функция сохраняет заказы в бд
     *
     * @param OrderStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public static function store(OrderStoreRequest $request): \Illuminate\Http\Response
    {
        //Скрипт валидирующий данные находится в app/Http/Requests/OrderStoreRequest

        try {
            //Записываем данные из отправленной формы в переменную
            $request = $request->all();
            $orders = $request['orders'] ?? [];

            //подготавливаем данные к записи в бд
            $data = self::prepareDataForInsert($orders);
            $result = Order::insert($data);

            return response($result);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Функция заменяет имя курьера (на которого добавлен заказ) на его id
     *
     * @param array $orders
     * @return array
     * @throws \Exception
     */
    private static function prepareDataForInsert(array $orders): array
    {
        try {
            if (count($orders) > 0) {
                //создаем пустой массив куда будем записывать данные
                $data = [];
                foreach ($orders as $key => $order) {
                    $courierName = $order['name'];
                    //получаем айди курьера
                    $courierId = self::getCourierId($courierName);

                    //записываем айди в массив с данными
                    $order['courier_id'] = $courierId;
                    $order['direction'] = self::TEST_DIRECTION;

                    //удаляем из массива с данными имя курьера
                    unset($order['name']);

                    //записываем все в новый массив. (иначе не работает)
                    $data[$key] = $order;
                }
                return $data;
            }
            throw new \Exception('Массив с данными о заказах пуст либо их не удалось считать');
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Функция определяей айди курьера соответвующией переданному ей имени
     *
     * @param string $courierName
     * @return int
     * @throws \Exception
     */
    private static function getCourierId(string $courierName): int
    {
        //находим в бд курьеров с именем $courierName
        $couriersIds = Courier::where('name', $courierName)->get('id');
        //если имени курьера соответствует более отдой записи, либо вообще записей с таким именем нет, то вернет ошибку
        //но эта логика прописана не здесь, а в app/Http/Requests/OrderStoreRequest

        // "достаем" айди курьера из того что вернула ORM. Не нашел более красивого способа это сделать
        $courierId = $couriersIds->pluck('id')[0];

        //если все ок то возвращаем айди
        if (is_int($courierId)) {
            return $courierId;
        }
        throw new \Exception('некак считать айди курьера');
    }

    /**
     * Функция определяющая связи между SQL таблицами
     */
    public function courier()
    {
        $this->belongsTo(Courier::class, 'courier_id', 'id');
    }
}
