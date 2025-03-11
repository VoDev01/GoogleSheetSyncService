<x-layout>
    <x-slot name="title">Все записи таблицы</x-slot>
    <table class="table table-bordered">
        <thead>
            <td>Id</td>
            <td>Название</td>
            <td>Статус</td>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr>
                    <td>{{$product->id}}</td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->status}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{$products->links()}}
</x-layout>
