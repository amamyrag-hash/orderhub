@extends('layouts.app')
@section('title', 'ویرایش محصول')

@section('content')
    <form action="{{ route('products.update', $product) }}" method="POST">
        @method('PUT')
        @include('products.form')
    </form>
@endsection