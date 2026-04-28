@extends('layouts.app')

@section('title', 'Миний мэдээлэл')

@section('content')

<h4 class="fw-bold mb-4">👤 Миний мэдээлэл</h4>

<div class="row g-4">

    {{-- ── Хувийн мэдээлэл ── --}}
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold" style="background:#eef3fb; border-bottom:2px solid #1a4fa0;">
                Хувийн мэдээлэл
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Нэр <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                               value="{{ old('name', $user->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Нэвтрэх нэр</label>
                        <input type="text" class="form-control bg-light" value="{{ $user->username }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Имэйл</label>
                        <input type="text" class="form-control bg-light" value="{{ $user->email }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Байгууллага</label>
                        <input type="text" class="form-control bg-light"
                               value="{{ $user->organization?->org_name ?? '—' }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Албан тушаал</label>
                        <input type="text" name="position" class="form-control @error('position') is-invalid @enderror"
                               value="{{ old('position', $user->position) }}" placeholder="Жишээ: Инженер">
                        @error('position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Утасны дугаар</label>
                        <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                               value="{{ old('phone', $user->phone) }}" placeholder="99xxxxxx">
                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Хадгалах</button>
                </form>

            </div>
        </div>
    </div>

    {{-- ── Нууц үг солих ── --}}
    <div class="col-md-6" id="password">
        <div class="card shadow-sm">
            <div class="card-header fw-semibold" style="background:#fff3cd; border-bottom:2px solid #e6a817;">
                Нууц үг солих
            </div>
            <div class="card-body">

                @if(session('success_password'))
                    <div class="alert alert-success alert-dismissible fade show">
                        {{ session('success_password') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('profile.password') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Одоогийн нууц үг <span class="text-danger">*</span></label>
                        <input type="password" name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Шинэ нууц үг <span class="text-danger">*</span></label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               minlength="6" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Шинэ нууц үг давтах <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-warning">Нууц үг солих</button>
                </form>

            </div>
        </div>
    </div>

</div>

@endsection
