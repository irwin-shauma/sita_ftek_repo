@extends('template.main')
@section('title', 'Home')
@section('content')
Selamat Datang {{ Auth::user()->name }}
@endsection