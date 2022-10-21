@extends('layouts.error_pages')
@section('title')
    <title>ERROR 500</title>
@endsection
@section('content')
    <img src="{{asset('files/images/500.svg')}}" alt="">
    <h1>متاسفانه در ارتباط با سرور مشکلی بوجود آمده است، همکاران ما در حال رفع مشکل هستند.</h1>
@endsection
