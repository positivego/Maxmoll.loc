<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // Возвразаем view основной страницы
    public function index()
    {
        $users = User::get();

        return view('components.users.index', compact('users'));
    }

    // Возвращаем view формы создания
    public function create()
    {
        return view('components.users.store');
    }

    //Получаем параметры из request и при удачном ::create
    //происходит редирект на основную страницу
    public function store(Request $request)
    {
        $params = $request->only(['name']);

        User::create($params);

        return redirect()->route('users');
    }

    // Возвращаем view формы редайтирования
    public function edit(User $user)
    {
        return view('components.users.edit', compact('user'));
    }

    //Получаем параметры из request и при удачном ->update
    //происходит редирект на основную страницу
    public function update(Request $request, User $user)
    {
        $params = $request->only(['name']);
        
        $user->update($params);

        return redirect()->route('users');
    }

    //Удаляем запись
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users');
    }
}
