@extends('layouts.admin')

@section('title', 'Edit Layanan')

@section('content')
    <h1 class="h3 mb-3">Edit Layanan</h1>
    <div class="card card-salon">
        <div class="card-body p-4">
            <form method="POST" action="{{ route('admin.services.update', $service) }}">
                @csrf
                @method('PUT')
                @include('admin.services._form')
            </form>
        </div>
    </div>
@endsection
