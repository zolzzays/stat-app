@extends('layouts.app')

@section('title', 'Байгууллага нэмэх')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold">Байгууллага нэмэх</h4>
    <a href="{{ route('organizations.index') }}" class="btn btn-secondary btn-sm">← Буцах</a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <form action="{{ route('organizations.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Байгууллагын нэр <span class="text-danger">*</span></label>
                <input type="text" name="org_name" class="form-control"
                       value="{{ old('org_name') }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Код <span class="text-danger">*</span></label>
                <input type="text" name="org_code" class="form-control"
                       value="{{ old('org_code') }}" required>
            </div>

            <button type="submit" class="btn btn-success">Хадгалах</button>
        </form>
    </div>
</div>

@endsection
