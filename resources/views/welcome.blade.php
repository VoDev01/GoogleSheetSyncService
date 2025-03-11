<x-layout>
    <x-slot name="title">Главная страница сервиса</x-slot>
    <h1>Функции сервиса</h1>
    <div class="row mb-3">
        <div class="col">
            <a class="text-decoration-none btn btn-primary" href="/products/index">Все записи таблицы</a>
        </div>
        <div class="col">
            <a class="text-decoration-none btn btn-success" href="/products/create">Создать</a>
        </div>
        <div class="col">
            <a class="text-decoration-none btn btn-warning" href="/products/update">Изменить</a>
        </div>
        <div class="col">
            <a class="text-decoration-none btn btn-danger" href="/products/destroy">Удалить</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-4">
            <form action="/products/generate" method="POST">
                @csrf
                <button type="submit" class="btn btn-success">Сгенерировать строки</button>
            </form>
        </div>
        <div class="col-4">
            <form action="/products/clear" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Очистить таблицу</button>
            </form>
        </div>
    </div>
</x-layout>
