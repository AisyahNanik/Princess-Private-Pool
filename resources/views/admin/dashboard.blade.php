@extends('layouts.app')

@section('content')
    <h1>Admin Dashboard</h1>
    <p>Selamat datang, {{ auth()->user()->name }}!</p>
@endsection
