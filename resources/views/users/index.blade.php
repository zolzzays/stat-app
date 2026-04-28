@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Хэрэглэгчдийн жагсаалт</h4>
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">+ Нэмэх</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle" style="font-size:0.88rem;">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Нэр</th>
                <th>Нэвтрэх нэр</th>
                <th>Имэйл</th>
                <th>Байгууллага</th>
                <th>Албан тушаал</th>
                <th>Утас</th>
                <th>Эрх</th>
                <th>Үйлдэл</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $key => $user)
            <tr>
                <td class="text-muted">{{ $key + 1 }}</td>
                <td class="fw-semibold">{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->organization?->org_name ?? '—' }}</td>
                <td>{{ $user->position ?? '—' }}</td>
                <td>{{ $user->phone ?? '—' }}</td>
                <td>
                    <span class="badge {{ $user->role?->name === 'admin' ? 'bg-danger' : 'bg-primary' }}">
                        {{ $user->role?->name ?? '—' }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Засах</a>
                    <a href="{{ route('users.destroy', $user->id) }}" class="btn btn-danger btn-sm"
                       onclick="return confirm('Устгах уу?')">Устгах</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
