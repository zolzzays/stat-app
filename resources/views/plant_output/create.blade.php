@extends('layouts.app')

@section('title', 'Мэдээ нэмэх')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold">Үйлдвэрлэлийн мэдээ нэмэх</h4>
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

<form action="{{ route('plant_output.store') }}" method="POST">
    @csrf

    <div class="card mb-3">
        <div class="card-header fw-semibold">Ерөнхий мэдээлэл</div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Станц <span class="text-danger">*</span></label>
                    <select class="form-select" name="power_plant_id" required
                        {{ count($plants) === 1 ? 'disabled' : '' }}>
                        <option value="">-- Сонгоно уу --</option>
                        @foreach($plants as $plant)
                            <option value="{{ $plant->id }}"
                                {{ (old('power_plant_id') == $plant->id || count($plants) === 1) ? 'selected' : '' }}>
                                {{ $plant->plant_name }}
                                @if($plant->regType) ({{ $plant->regType->type_name }}) @endif
                            </option>
                        @endforeach
                    </select>
                    {{-- disabled select утга submit болдоггүй тул hidden input нэмнэ --}}
                    @if(count($plants) === 1)
                        <input type="hidden" name="power_plant_id" value="{{ $plants->first()->id }}">
                    @endif
                </div>

                <div class="col-md-3">
                    <label class="form-label">Бүтээгдэхүүний нэр <span class="text-danger">*</span></label>
                    <select class="form-select" name="product_name" id="product_name" required>
                        <option value="">-- Сонгоно уу --</option>
                        <option value="Цахилгаан" {{ old('product_name') === 'Цахилгаан' ? 'selected' : '' }}>Цахилгаан</option>
                        <option value="Дулаан"    {{ old('product_name') === 'Дулаан'    ? 'selected' : '' }}>Дулаан</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Хэмжих нэгж <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="unit_name" id="unit_name"
                           value="{{ old('unit_name') }}" placeholder="мян.кВт.цаг, мян.Гкал" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Он <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="year"
                           value="{{ old('year', date('Y')) }}" min="2000" max="2100" required>
                </div>

                <div class="col-md-2">
                    <label class="form-label">Сар <span class="text-danger">*</span></label>
                    <select class="form-select" name="month" required>
                        @for($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ old('month', date('n')) == $m ? 'selected' : '' }}>
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
                           value="{{ number_format(old('before_month', 0), 2, '.', '') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Тайлант сарын үйлдвэрлэл</label>
                    <small class="text-muted d-block">(тайлант сар)</small>
                    <input type="number" step="0.01" min="0" class="form-control decimal-input" name="this_month"
                           value="{{ number_format(old('this_month', 0), 2, '.', '') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Тайлант сарын өөрийн хэрэглээ
                        <small class="text-muted d-block">(дотоод хэрэгцээ)</small>
                    </label>
                    <input type="number" step="0.01" min="0" class="form-control decimal-input" name="year_usage"
                           value="{{ number_format(old('year_usage', 0), 2, '.', '') }}" required>
                </div>

                <div class="col-md-3">
                    <label class="form-label">Жилийн эхнээс үйлдвэрлэл
                        <small class="text-muted d-block">(өөрийн хэрэглээг хасаагүй)</small>
                    </label>
                    <input type="number" step="0.01" min="0" class="form-control decimal-input" name="this_musage"
                           value="{{ number_format(old('this_musage', 0), 2, '.', '') }}" required>
                </div>

            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-success">Хадгалах</button>

</form>

@endsection

@push('scripts')
<script>
const unitMap = { 'Цахилгаан': 'мян.кВт.цаг', 'Дулаан': 'мян.Гкал' };
const productSel = document.getElementById('product_name');
const unitInput  = document.getElementById('unit_name');

function syncUnit() {
    const unit = unitMap[productSel.value];
    if (unit) unitInput.value = unit;
}
productSel.addEventListener('change', syncUnit);
if (productSel.value && !unitInput.value) syncUnit();

document.querySelectorAll('.decimal-input').forEach(function (input) {
    // Анх ачаалахад 2 орон харуулна
    if (input.value !== '') {
        input.value = parseFloat(input.value).toFixed(2);
    }

    // Фокус арилахад 2 орон болгоно
    input.addEventListener('blur', function () {
        if (this.value !== '') {
            this.value = parseFloat(this.value).toFixed(2);
        }
    });

    // Тоо биш зүйл бичихэд хаана
    input.addEventListener('input', function () {
        if (this.value < 0) this.value = 0;
    });
});
</script>
@endpush
