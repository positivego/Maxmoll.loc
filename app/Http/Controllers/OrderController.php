<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Storage;
use App\Models\StorageItem;
use App\Models\StorageToOrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Возвразаем view основной страницы и передаем заказы
    public function index()
    {
        $orders = Order::get();

        return view('components.orders.index', compact('orders'));
    }

    //Метод для получения продуктов в формах создания и редактирования заказов

    public function getProducts(Request $request)
    {
        $items = StorageItem::where('storage_id', $request->id)->get();
        
        foreach ($items as $item) {
            $item->product;
        }

        return response()->json($items, 200);
    }

    // Возвращаем форму создания с необходимыми переменными

    public function create()
    {
        $managers = User::get();
        $storages = Storage::get();
        return view('components.orders.store', compact('managers', 'storages'));
    }

    // Добавляем заказ в дб

    public function store(Request $request)
    {
        //Необходимые параметры из request
        $params = $request->only([
            'customer',
            'phone',
            'user_id',
            'type',
            'status',
            'storage',
            'product',
            'stock',
            'discount',
        ]);

        // Получаем продукт на выбранном складе,
        // необходимо для обновления stock в выбранном складе,
        $itemInStorage = StorageItem::where('storage_id', $params['storage'])->where('product_id', $params['product'])->first();
        // Новый stock
        $newStock = intval($itemInStorage['stock']) - intval($params['stock']);
        // Получаем продукт для определения cost
        $product = $itemInStorage->product;

        // Если newStock значит что на выбранном складе недостаточно товара, по этому мы вызывает редирект с ошибкой
        if($newStock < 0 ) {

            return redirect()->route('orders.create')->withErrors(['stock' => 'Недостаточно товара']);

        }

        // Создаем новый заказ в бд и возвращаем его в переменную order
        // Она необходима для OrderItem, StorageToOrderItem и Log
        $order = Order::create([
            'customer' => $params['customer'],
            'phone' => $params['phone'],
            'created_at' => Carbon::now(),
            'completed_at' => $params['status'] === 'completed' ? Carbon::now() : null,
            'user_id' => $params['user_id'],
            'type' => $params['type'],
            'status' => $params['status'],
        ]);

        // Создаем в бд запись выбранного продукта
        // так как я не успевал за 3 дня сделать возможность добавление нескольких товаров
        // сделал возможность добавление одного
        // В принцепи я понимаю что в форме создания мне нужно было указать параметр product как массив product[]
        // Но вся сложность в форме update, то как обновлять сразу несколько записей в OrderItem по определенному $order
        // На что мне хватило времени
        // 'cost' => считам общую стоимость всех товаров
        OrderItem::create([
            'order_id' => $order['id'],
            'product_id' => $params['product'],
            'count' => $params['stock'],
            'discount' => $params['discount'],
            'cost' => (intval($product['price']) - (intval($product['price']) * (intval($params['discount']) / 100))) * $params['stock'],
        ]);

        // Данная запись и таблица нужна, что бы я мог определить 
        // в форме update на каком складе находится выбранный продукт
        // Так как по условию ТЗ я не мог менять таблицу order_items,
        // Хотя я бы добавил дополнительное поле в выше упомянутую таблицу
        StorageToOrderItem::create([
            'order_id' => $order['id'],
            'storage_id' => $params['storage'],
        ]);

        // Создаем новый лог
        Log::create([
            'from_storage_id' => $params['storage'],
            'to_storage_id' => null,
            'log_type_id' => 2,
            'product_id' => $params['product'],
            'stock' => $params['stock'],
        ]);

        // Если заказ отменен изначально то и нет необходимости обновлять кол-во продуктов на выбранном складе
        if ($params['status'] !== 'canceled') {

            $itemInStorage->update(['stock' => $newStock]);

        }

        return redirect()->route('orders');

    }

    // Обновляем заказ, получаем необходимые параметры
    public function edit(Order $order)
    {
        $managers = User::get();
        $storages = Storage::get();
        $orderStorage = Storage::where('id', $order->storage->storage_id)->first();
        
        return view('components.orders.edit', compact('order', 'managers', 'storages', 'orderStorage'));
    }

    // Обновляем заказ
    public function update(Request $request, Order $order)
    {
        //Необходимые параметры из request
        $params = $request->only([
            'customer',
            'phone',
            'user_id',
            'type',
            'status',
            'storage',
            'product',
            'stock',
            'discount',
        ]);

        // Получаем продукт на выбранном складе,
        // необходимо для обновления stock в выбранном складе,
        $itemInStorage = StorageItem::where('storage_id', $params['storage'])->where('product_id', $params['product'])->first();
        // Получаем заказанный продукт, необходим для пересчета count
        $item = OrderItem::where('id', $order->id)->where('product_id', $params['product'])->first();
         // Получаем продукт для определения cost
        $product = $itemInStorage->product;

        if($item)
        {
            // Если кол-во продуктов меньше чем было указанно при создании
            // то нам нужно добавить кол-во продуктов на складе
            if ($item['count'] > $params['stock']) {
                // Обновляем stock склада
                $itemInStorage->update([
                    'stock' => $itemInStorage['stock'] + ($item['count'] - $params['stock']),
                ]);
                // Обновляем count
                $item->update([
                    'count' => $params['stock'],
                ]);

            }
            
            // Если кол-во продуктов больше чем было указанно при создании
            // то нам нужно убавить кол-во продуктов на складе
            if ($item['count'] < $params['stock']) {

                // Так как мы убавляем продукты со склада, необходимо проверить тостаточно ли выбранного продукта на выбранном складе
                $newStockToStorage = $itemInStorage['stock'] - ($params['stock'] - $item['count']);

                if ($newStockToStorage < 0) {

                    return redirect()->route('orders.edit', $order)->withErrors(['stock' => 'Недостаточно товара']);

                }
                // Обновляем stock склада
                $itemInStorage->update([
                    'stock' => $newStockToStorage,
                ]);
                // Обновляем count
                $item->update([
                    'count' => $params['stock'],
                ]);

            }

        }

        // Если мы меняем статус заказа с active на canceled
        // то необходимо добавить заказанные продукты на склад
        // с которого был заказан продукт
        if($order['status'] == 'active' && $params['status'] == 'canceled') {
            // Обновляем stock
            $itemInStorage->update([
                'stock' => $itemInStorage['stock'] + $params['stock'],
            ]);

        }

        // Если мы меняем статус заказа с canceled на active
        // то необходимо убавить заказанные продукты со склада
        // с которого был заказан продукт
        if($order['status'] == 'canceled' && $params['status'] == 'active') {
            //Так же проверяем достаточно ли продуктов на складе
            $newStockToStorage = $itemInStorage['stock'] - $params['stock'];

            if ($newStockToStorage < 0) {

                return redirect()->route('orders.edit', $order)->withErrors(['stock' => 'Недостаточно товара']);

            }
            // Обновляем stock
            $itemInStorage->update([
                'stock' => $itemInStorage['stock'] - $params['stock'],
            ]);

        }

        // Обновляем заказ
        $order->update([
            'customer' => $params['customer'],
            'phone' => $params['phone'],
            'completed_at' => $order['status'] !== 'completed' && $params['status'] === 'completed' ? Carbon::now() : null,
            'user_id' => $params['user_id'],
            'type' => $params['type'],
            'status' => $params['status'],
        ]);

        // обновляем заказанный продукт
        // 'cost' => считам общую стоимость всех товаров
        $item->update([
            'product_id' => $params['product'],
            'count' => $params['stock'],
            'discount' => $params['discount'],
            'cost' => (intval($product['price']) - (intval($product['price']) * (intval($params['discount']) / 100))) * $params['stock'],
        ]);

        // Не уверен что нужно удалять старый лог
        // по этому просто создаю новый
        // мне показалось это лучше нежели его обновлять или удалять
        Log::create([
            'from_storage_id' => $params['storage'],
            'to_storage_id' => null,
            'log_type_id' => 2,
            'product_id' => $params['product'],
            'stock' => $params['stock'],
        ]);

        return redirect()->route('orders');

    }

    // Не уверен что этот метод хорошее решение
    // вероятно было бы проще просто передать гет параметр
    public function getHistory(Request $request)
    {
        $data = collect();

        $orders = Order::get();

        foreach ($orders as $order) {
            
            if ($order->completed_at !== null && $order->completed_at->format('Y-m-d') === $request->date) {

                $data->push($order);

            }

        }

        // Сначала мы получаем заказы по переданной дате через форму
        // после пушим подходящие в коллекцию и передаем их через сессию в другой роут

        return redirect()->route('orders.history')->with('orders', $data);
    }

    // Возвращаем view c completed заказами за определенную дату

    public function history(Request $request)
    {
        // Получаем заказы из сессии
        $orders = $request->session()->get('orders');

        $cost = 0;
        
        // Считаем общую сумму
        foreach ($orders as $order) {
            $cost += $order->item->cost;
        }

        // И передаем их во view
        return view('components.orders.history', compact('orders', 'cost'));
    }
}
