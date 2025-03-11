<x-layout>
    <x-slot name="title">Изменить</x-slot>
    <form action="/products/update" method="post">
        @csrf
        <div class="mb-3">
            <label for="id" class="form-label">Id</label>
            <input type="number" class="form-control" name="id" id="id" required/>
        </div>
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