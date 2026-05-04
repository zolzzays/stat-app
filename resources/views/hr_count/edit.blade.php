@extends('layouts.app')

@section('title', 'Хүний нөөцийн мэдээ засах')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold">Хүний нөөцийн мэдээ засах</h4>
    <a href="{{ route('hr_count.index') }}" class="btn btn-secondary btn-sm">← Буцах</a>
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

<form action="{{ route('hr_count.update', $hr_count->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card mb-3">
        <div class="card-header fw-semibold">Ерөнхий мэдээлэл</div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-4">
                    <label class="form-label">Станц <span class="text-danger">*</span></label>
                    <select class="form-select" name="power_plant_id" required
                        {{ count($plants) === 1 ? 'disabled' : '' }}>
                        <option value="">-- Сонгоно уу --</option>
                        @foreach($plants as $plant)
                            <option value="{{ $plant->id }}"
                                {{ $plant->id == $hr_count->power_plant_id ? 'selected' : '' }}>
                                {{ $plant->plant_name }}
                                @if($plant->regType) ({{ $plant->regType->type_name }}) @endif
                            </option>
                        @endforeach
                    </select>
                    @if(count($plants) === 1)
                        <input type="hidden" name="power_plant_id" value="{{ $plants->first()->id }}">
                    @endif
                </div>

                <div class="col-md-4">
                    <label class="form-label">Он <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="year"
                           value="{{ old('year', $hr_count->year) }}" min="2000" max="2100" required>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Сар <span class="text-danger">*</span></label>
                    <select class="form-select" name="month" required>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}"
                                {{ old('month', $hr_count->month) == $m ? 'selected' : '' }}>
                                {{ $m }} сар
                            </option>
                        @endfor
                    </select>
                </div>

            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header fw-semibold">Ажиллагчдын тоо</div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-12"><p class="fw-semibold mb-1 text-muted">Нийт ажилчид</p></div>

                <div class="col-md-3">
                    <label class="form-label">Эрэгтэй <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="emp_male"
                           value="{{ old('emp_male', $hr_count->emp_male) }}" min="0" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Эмэгтэй <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="emp_female"
                           value="{{ old('emp_female', $hr_count->emp_female) }}" min="0" required>
                </div>

                <div class="col-12 mt-2"><p class="fw-semibold mb-1 text-muted">Нийт ИТА</p></div>

                <div class="col-md-3">
                    <label class="form-label">Эрэгтэй <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="work_male"
                           value="{{ old('work_male', $hr_count->work_male) }}" min="0" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Эмэгтэй <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="work_female"
                           value="{{ old('work_female', $hr_count->work_female) }}" min="0" required>
                </div>

            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success">Шинэчлэх</button>

</form>

@endsection
