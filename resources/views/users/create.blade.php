@extends('layouts.app')

@section('content')

<div class="card shadow">
    <div class="card-header bg-primary text-white">
        Шинэ хэрэглэгч нэмэх
    </div>

    <div class="card-body">

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="mb-3">
                <label>Нэр</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Нэвтрэх нэр (username)</label>
                <input type="text" name="username" value="{{ old('username') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Имэйл</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Нууц үг</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Нууц үг давтах</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Харьяа байгууллага</label>
                <select name="org_id" class="form-select">
                    <option value="">-- Сонгох --</option>
                    @foreach($orgs as $org)
                        <option value="{{ $org->id }}" {{ old('org_id') == $org->id ? 'selected' : '' }}>
                            {{ $org->org_name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Эрх (Role)</label>
                <select name="role_id" class="form-select">
                    <option value="">-- Сонгох --</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">Буцах</a>
            <button class="btn btn-success">Хадгалах</button>

        </form>

    </div>
</div>

@endsection
