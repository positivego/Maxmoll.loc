<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\LogType;
use Illuminate\Http\Request;

class LogController extends Controller
{
    // Возвразаем view основной страницы со всеми логами
    public function index()
    {
        $logs = Log::orderByDesc('id')->get();

        return view('components.logs.list', compact('logs'));
    }

    // Возвращаем view страницы с типами логов
    public function indexTypes()
    {
        $types = LogType::get();

        return view('components.logs.index', compact('types'));
    }

    // Возвращаем view формы создания
    public function create()
    {
        return view('components.logs.store');
    }

    // Получаем параметры из request и при удачном ::create
    // происходит редирект на основную страницу
    public function store(Request $request)
    {
        $params = $request->only(['name']);

        LogType::create($params);

        return redirect()->route('logs.type.index');
    }

    // Возвращаем view формы редайтирования
    public function edit(LogType $type)
    {
        return view('components.logs.edit', compact('type'));
    }

    // Получаем параметры из request и при удачном ->update
    // происходит редирект на основную страницу
    public function update(Request $request, LogType $type)
    {
        $params = $request->only(['name']);
        
        $type->update($params);

        return redirect()->route('logs.type.index');
    }

    // Удаляем запись
    public function destroy(LogType $type)
    {
        $type->delete();

        return redirect()->route('logs.type.index');
    }
}
