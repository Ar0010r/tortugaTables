<?php

namespace App;

use App\Http\Requests\CourierStoreRequest;
use Illuminate\Database\Eloquent\Model;

class Courier extends Model
{
    protected $fillable = [
        'manager_id',
        'name',
        'email',
        'payment_method',
        'paypal_email',
        'address',
        'city',
        'state',
        'zip',
        'phone_1',
        'phone_2'
    ];

    protected const PAYMENT_METHOD_PAYPAL = 0;
    protected const PAYMENT_METHOD_MONEYGRAMM = 1;

    /**
     * Функция сохраняет курьеров в бд
     *
     * @param CourierStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public static function store(CourierStoreRequest $request): \Illuminate\Http\Response
    {
        //Скрипт валидирующий данные находится в app/Http/Requests/CourierStoreRequest

        try {
            //Записываем данные из отправленной формы в переменную
            $request = $request->all();
            $couriers = $request['couriers'] ?? [];

            //подготавливаем данные к записи в бд
            $data = self::prepareDataForInsert($couriers);
            $result = Courier::insert($data);

            return response($result);
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }
    }

    /**
     * Функция добавляет в полученные из формы данные информацию о методе отплаты и id менеджера который их добавил
     *
     * @param array $couriers
     * @return array
     * @throws \Exception
     */
    private static function prepareDataForInsert(array $couriers): array
    {
        if (count($couriers) > 0) {
            //создаем пустой массив куда будем записывать данные
            $data = [];
            foreach ($couriers as $key => $courier) {
                $data[$key] = $courier;

                //дополняем в данные ID менеджера который их добавил и метод оплаты.
                //(Все ранво Мани Грамм никогда не используем, решил не выносить это в форму)
                $data[$key]['manager_id'] = auth()->id();
                $data[$key]['payment_method'] = self::PAYMENT_METHOD_PAYPAL;
            }
            return $data;
        }
        throw new \Exception('Массив с данными курьеров пуст');
    }


    /**
     * Функция определяющая связи между SQL таблицами
     */
    public function manager()
    {
        $this->belongsTo(Manager::class, 'manager_id', 'id');
    }

    /**
     * Функция определяющая связи между SQL таблицами
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
