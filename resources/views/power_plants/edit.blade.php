@extends('layouts.app')

@section('title', 'Станц засах')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold">Станц засах</h4>
    <a href="{{ route('power_plants.index') }}" class="btn btn-secondary btn-sm">← Буцах</a>
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
        <form action="{{ route('power_plants.update', $power_plant->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Станцын нэр <span class="text-danger">*</span></label>
                    <input type="text" name="plant_name" class="form-control"
                           value="{{ old('plant_name', $power_plant->plant_name) }}" required>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Станцын төрөл <span class="text-danger">*</span></label>
                    <select name="type_id" class="form-select" required>
                        <option value="">-- Сонгоно уу --</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}"
                                {{ old('type_id', $power_plant->type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->t_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Байгууллага</label>
                    <select name="org_id" class="form-select">
                        <option value="">-- Сонгоно уу --</option>
                        @foreach($orgs as $org)
                            <option value="{{ $org->id }}"
                                {{ old('org_id', $power_plant->org_id) == $org->id ? 'selected' : '' }}>
                                {{ $org->org_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Бүртгэлийн төрөл</label>
                    <select name="reg_type_id" class="form-select">
                        <option value="">-- Сонгоно уу --</option>
                        @foreach($regTypes as $rt)
                            <option value="{{ $rt->id }}"
                                {{ old('reg_type_id', $power_plant->reg_type_id) == $rt->id ? 'selected' : '' }}>
                                {{ $rt->type_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success">Шинэчлэх</button>
            </div>

        </form>
    </div>
</div>

@endsection
