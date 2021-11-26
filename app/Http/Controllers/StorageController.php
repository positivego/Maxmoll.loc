<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Storage;
use App\Models\StorageItem;
use Illuminate\Http\Request;

class StorageController extends Controller
{
    // Возвразаем view основной  страницы
    public function index()
    {
        $storages = Storage::get();

        return view('components.storages.index', compact('storages'));
    }

    // Возвращаем страницу склада
    public function storage(Storage $storage)
    {
        return view('components.storages.storage', compact('storage'));
    }

    // Возвращаем форму добавления продукта на склад
    public function addProduct(Storage $storage)
    {
        $products = Product::get();

        return view('components.storages.storage-create', compact('storage', 'products'));
    }

    // Добавляем продукты в выбранный склад
    public function add(Request $request, Storage $storage)
    {
        //Параметры из запроса
        $params = $request->only(['product_id', 'stock']);
        
        //Получаем продукт
        $product = Product::where('id', $params['product_id'])->first();

        //Количество продукта после перемещения
        $newProductStock = intval($product->stock) - intval($params['stock']);

        //Проверяем достаточно ли товара и вводим новую переменную
        if($newProductStock < 0) {

            return redirect()->route('storages.storage.product', $storage)->withErrors(['stock' => 'Недостаточно товара']);

        }

        //Проверяем есть ли такой продукт на складе и просто увеличиваем его stock
        //Если нет то создаем новую запись

        if($item = StorageItem::where('storage_id', $storage['id'])->where('product_id', $params['product_id'])->first()) {
            
            $itemStock = intval($item['stock']) + intval($params['stock']);

            $item->update(['stock' => $itemStock]);

        } else {

            StorageItem::create([
                'storage_id' => $storage['id'],
                'product_id' => $params['product_id'],
                'stock' => $params['stock'],
            ]);

        }

        //Добавляем новый лог
        Log::create([
            'from_storage_id' => null,
            'to_storage_id' => $storage['id'],
            'log_type_id' => 1,
            'product_id' => $params['product_id'],
            'stock' => $params['stock'],
        ]);

        //Если все ок, обновляем stock у продукта
        $product->update(['stock' => $newProductStock]);

        //Возвращемся на страницу склада
        return redirect()->route('storages.storage', $storage);

    }

    // Логи по складу
    public function history(Storage $storage)
    {
        $logs = Log::where('from_storage_id', $storage->id)
                   ->orWhere('to_storage_id', $storage->id)
                   ->get();
                   
        return view('components.storages.history', compact('storage', 'logs'));
    }

    //По товару и складу
    public function productHistory(Storage $storage, Product $product)
    {
        $logs = Log::where('product_id', $product->id)
                    ->where('from_storage_id', $storage->id)
                    ->orWhere('to_storage_id', $storage->id)
                    ->where('product_id', $product->id)
                    ->get();
                   
        return view('components.storages.history', compact('storage', 'logs'));
    }

    //Перемещение продуктов между складами
    public function moveProduct(Storage $storage, $item)
    {
        // По какой то причине StorageItem $item вторым параметром ничего не возвращает
        // За время отведенное для решения ТЗ, причину найти не смог
        $item = StorageItem::where('id', $item)->first();
        $storages = Storage::get();
        
        return view('components.storages.move', compact('storages', 'storage', 'item'));
    }

    // Перемещаем продукт и добавляем лог
    public function move(Request $request, Storage $storage, $item)
    {
        //Получаем item
        $item = StorageItem::where('id', $item)->first();

        //Получаем параметры
        $params = $request->only(['storage_id', 'stock']);

        //Количество продукта после перемещения
        $newItemStock = intval($item['stock']) - intval($params['stock']);

        //Проверяем достаточно ли товара и вводим новую переменную
        if($newItemStock < 0) {

            return redirect()->route('storages.storage.move.product', [$storage, $item])->withErrors(['stock' => 'Недостаточно товара']);

        }

        //Проверяем есть ли такой продукт на складе в который перемещяем и просто увеличиваем его stock
        //Если нет то создаем новую запись
        if($newItem = StorageItem::where('storage_id', $params['storage_id'])->where('product_id', $item['product_id'])->first()) {
            
            $ItemStock = intval($newItem['stock']) + intval($params['stock']);

            $newItem->update(['stock' => $ItemStock]);

        } else {

            StorageItem::create([
                'storage_id' => $params['storage_id'],
                'product_id' => $item['product_id'],
                'stock' => $params['stock'],
            ]);

        }

        //Добавляем новый лог
        Log::create([
            'from_storage_id' => $storage['id'],
            'to_storage_id' => $params['storage_id'],
            'log_type_id' => 3,
            'product_id' => $item['product_id'],
            'stock' => $params['stock'],
        ]);

        //Если все ок, обновляем stock у продукта
        $item->update(['stock' => $newItemStock]);

        //Возвращемся на страницу склада
        return redirect()->route('storages.storage', $storage);
    }

    // Возвращаем view основной tools страницы
    public function indexTools()
    {
        $storages = Storage::get();

        return view('components.storages.list', compact('storages'));
    }

    // Возвращаем view формы создания
    public function create()
    {
        return view('components.storages.store');
    }

    //Получаем параметры из request и при удачном ::create
    //происходит редирект на основную страницу
    public function store(Request $request)
    {
        $params = $request->only(['name']);

        Storage::create($params);

        return redirect()->route('storages.tools');
    }

    // Возвращаем view формы редайтирования
    public function edit(Storage $storage)
    {
        return view('components.storages.edit', compact('storage'));
    }

    //Получаем параметры из request и при удачном ->update
    //происходит редирект на основную страницу
    public function update(Request $request, Storage $storage)
    {
        $params = $request->only(['name']);
        
        $storage->update($params);

        return redirect()->route('storages.tools');
    }

    //Удаляем запись
    public function destroy(Storage $storage)
    {
        $storage->delete();

        return redirect()->route('storages.tools');
    }
}
