@extends('layouts.app')
@section('title', 'ایجاد محصول')

@section('content')
    <form action="{{ route('products.store') }}" method="POST">
        @include('products.form')
    </form>
@endsection