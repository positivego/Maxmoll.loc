<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Storage;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $order = Order::where('id', 1)->first();

        dump($order->products);

        $user = User::where('id', 1)->first();

        dump($user);

        $storage = Storage::where('id', 1)->first();

        dump($storage->products);
        
        dd('--END--');

        return view('components.contents.index');
    }
}
