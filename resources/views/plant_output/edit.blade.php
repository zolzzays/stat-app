@extends('layouts.app')

@section('title', 'Мэдээ засах')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold">Үйлдвэрлэлийн мэдээ засах</h4>
    <a href="{{ route('plant_output.index') }}" class="btn btn-secondary btn-sm">← Буцах</a>
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

<form action="{{ route('plant_output.update', $plant_output->id) }}" method="POST">
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
                                {{ $plant->id == $plant_output->power_plant_id ? 'selected' : '' }}>
                                {{ $plant->plant_name }}
                                @if($plant->regType) ({{ $plant->regType->type_name }}) @endif
                            </option>
                        @endforeach
                    </select>
                    @if(count($plants) === 1)
                        <input type="hidden" name="power_plant_id" value="{{ $plants->first()->id }}">
                    @endif
                </div>

                <div class="col-md-3">
                    <label class="form-label">Бүтээгдэхүүний нэр <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="product_name"
                           value="{{ old('product_name', $plant_output->product_name) }}" required>
                </div>

                <div class="col-md-1">
                    <label class="form-label">Нэгж <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="unit_name"
                           value="{{ old('unit_name', $plant_output->unit_name) }}" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Он <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="year"
                           value="{{ old('year', $plant_output->year) }}" min="2000" max="2100" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Сар <span class="text-danger">*</span></label>
                    <select class="form-select" name="month" required>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}"
                                {{ old('month', $plant_output->month) == $m ? 'selected' : '' }}>
                                {{ $m }} сар
                            </option>
                        @endfor
                    </select>
                </div>

            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header fw-semibold">Үйлдвэрлэлийн тоо мэдээ</div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-3">
                    <label class="form-label">Өмнөх сарын үйлдвэрлэл
                        <small class="text-muted d-block">(өөрийн хэрэглээг хасаагүй)</small>
                    </label>
                    <input type="number" step="0.01" min="0" class="form-control decimal-input" name="before_month"
                           value="{{ number_format($plant_output->before_month, 2, '.', '') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Тайлант сарын үйлдвэрлэл</label>
                    <input type="number" step="0.01" min="0" class="form-control decimal-input" name="this_month"
                           value="{{ number_format($plant_output->this_month, 2, '.', '') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Тайлант сарын өөрийн хэрэглээ
                        <small class="text-muted d-block">(дотоод хэрэгцээ)</small>
                    </label>
                    <input type="number" step="0.01" min="0" class="form-control decimal-input" name="year_usage"
                           value="{{ number_format($plant_output->year_usage, 2, '.', '') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Жилийн эхнээс үйлдвэрлэл
                        <small class="text-muted d-block">(өөрийн хэрэглээг хасаагүй)</small>
                    </label>
                    <input type="number" step="0.01" min="0" class="form-control decimal-input" name="this_musage"
                           value="{{ number_format($plant_output->this_musage, 2, '.', '') }}" required>
                </div>

            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success">Шинэчлэх</button>

</form>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.decimal-input').forEach(function (input) {
    input.addEventListener('blur', function () {
        if (this.value !== '') {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });
    input.addEventListener('input', function () {
        if (this.value < 0) this.value = 0;
    });
});
</script>
@endpush
