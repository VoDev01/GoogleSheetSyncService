<x-layout>
    <x-slot name="title">Создать</x-slot>
    <form action="/products/create" method="post">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Название</label>
            <input type="text" class="form-control" name="name" id="name" />
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Статус</label>
            <select class="form-select form-select-lg" name="status" id="status">
                <option value="Allowed" selected>Разрешено</option>
                <option value="Prohibited">Запрещено</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">
            Отправить
        </button>
    </form>
</x-layout>