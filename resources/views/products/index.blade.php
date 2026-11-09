@extends('layouts.app')
@section('title', 'محصولات')

@section('content')
    <a href="{{ route('products.create') }}">+ محصول جدید</a>

    <table border="1" cellpadding="6">
        <tr>
            <th>نام</th><th>SKU</th><th>قیمت</th><th>عملیات</th>
        </tr>
        @forelse ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->sku }}</td>
                <td>{{ number_format($product->price) }}</td>
                <td>
                    <a href="{{ route('products.edit', $product) }}">ویرایش</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST"
                          style="display:inline" onsubmit="return confirm('مطمئنی؟')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">حذف</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="4">محصولی وجود ندارد.</td></tr>
        @endforelse
    </table>

    {{ $products->links() }}
@endsection