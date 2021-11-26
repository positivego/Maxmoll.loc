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
        return view('components.index.index');
    }
}
