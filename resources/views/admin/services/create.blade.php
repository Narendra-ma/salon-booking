@extends('layouts.admin')

@section('title', 'Tambah Layanan')

@section('content')
    <h1 class="h3 mb-3">Tambah Layanan</h1>
    <div class="card card-salon">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.services.store') }}">
                @csrf
                @include('admin.services._form')
            </form>
        </div>
    </div>
@endsection
