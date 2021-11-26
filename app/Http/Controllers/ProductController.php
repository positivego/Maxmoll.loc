<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Возвразаем view основной страницы
    public function index()
    {
        $products = Product::get();

        return view('components.products.index', compact('products'));
    }

    // Возвращаем view формы создания
    public function create()
    {
        return view('components.products.store');
    }

    //Получаем параметры из request и при удачном ::create
    //происходит редирект на основную страницу
    public function store(Request $request)
    {
        $params = $request->only(['name', 'price', 'stock']);

        Product::create($params);

        return redirect()->route('products');
    }

    // Возвращаем view формы редайтирования
    public function edit(Product $product)
    {
        return view('components.products.edit', compact('product'));
    }

    //Получаем параметры из request и при удачном ->update
    //происходит редирект на основную страницу
    public function update(Request $request, Product $product)
    {
        $params = $request->only(['name', 'price', 'stock']);
        
        $product->update($params);

        return redirect()->route('products');
    }

    //Удаляем запись
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products');
    }
}
