<x-layout>
    <x-slot name="title">Удалить</x-slot>
    <form action="/products/destroy" method="post">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Название</label>
            <input type="text" class="form-control" name="name" id="name" required />
        </div>
        <button type="submit" class="btn btn-primary">
            Отправить
        </button>
    </form>
</x-layout>