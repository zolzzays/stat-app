@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Хэрэглэгчдийн жагсаалт</h4>
    <a href="{{ route('users.create') }}" class="btn btn-primary">+ Нэмэх</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Нэр</th>
            <th>Нэвтрэх нэр</th>
            <th>Имэйл</th>
            <th>Байгууллага</th>
            <th>Эрх</th>
            <th>Үйлдэл</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $key => $user)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->username }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->organization?->org_name ?? '—' }}</td>
            <td>{{ $user->role?->name ?? '—' }}</td>
            <td>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Засах</a>
                <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-sm"
                   onclick="return confirm('Устгах уу?')">Устгах</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection
