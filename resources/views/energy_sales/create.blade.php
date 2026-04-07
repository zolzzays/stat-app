@extends('layouts.app')

@section('title', 'Борлуулалтын мэдээ нэмэх')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold">Борлуулалтын мэдээ нэмэх</h4>
    <a href="{{ route('energy_sales.index') }}" class="btn btn-secondary btn-sm">← Буцах</a>
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

<form action="{{ route('energy_sales.store') }}" method="POST">
    @csrf

    {{-- Ерөнхий мэдээлэл --}}
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
                                {{ (old('power_plant_id') == $plant->id || count($plants) === 1) ? 'selected' : '' }}>
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
                           value="{{ old('product_name') }}" required>
                </div>

                <div class="col-md-1">
                    <label class="form-label">Нэгж <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="unit_name"
                           value="{{ old('unit_name') }}" placeholder="МВт·ц" required>
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

    {{-- Борлуулалтын тоо мэдээ --}}
    <div class="card mb-4">
        <div class="card-header fw-semibold">Борлуулалтын тоо мэдээ</div>
        <div class="card-body">

            {{-- Өмнөх сар --}}
            <div class="mb-3">
                <div class="fw-semibold text-info mb-2 border-bottom pb-1">Өмнөх сар</div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Биет хэмжээ <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control decimal-input" name="before_month"
                               value="{{ number_format(old('before_month', 0), 2, '.', '') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Үнийн дүн<br>(мян.төг) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control decimal-input" name="before_sal"
                               value="{{ number_format(old('before_sal', 0), 2, '.', '') }}" required>
                    </div>
                </div>
            </div>

            {{-- Тайлант сар --}}
            <div class="mb-3">
                <div class="fw-semibold text-warning mb-2 border-bottom pb-1">Тайлант сар</div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Биет хэмжээ <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control decimal-input" name="this_month"
                               value="{{ number_format(old('this_month', 0), 2, '.', '') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Үнийн дүн<br>(мян.төг) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control decimal-input" name="this_sal"
                               value="{{ number_format(old('this_sal', 0), 2, '.', '') }}" required>
                    </div>
                </div>
            </div>

            {{-- Өөрийн хэрэглээ --}}
            <div class="mb-3">
                <div class="fw-semibold text-success mb-2 border-bottom pb-1">Өөрийн хэрэглээ</div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Биет хэмжээ <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control decimal-input" name="year_usage"
                               value="{{ number_format(old('year_usage', 0), 2, '.', '') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Үнийн дүн<br>(мян.төг) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control decimal-input" name="year_sal"
                               value="{{ number_format(old('year_sal', 0), 2, '.', '') }}" required>
                    </div>
                </div>
            </div>

            {{-- Жилийн эхнээс --}}
            <div class="mb-1">
                <div class="fw-semibold text-secondary mb-2 border-bottom pb-1">Жилийн эхнээс</div>
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Биет хэмжээ <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control decimal-input" name="this_musage"
                               value="{{ number_format(old('this_musage', 0), 2, '.', '') }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Үнийн дүн<br>(мян.төг) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" min="0" class="form-control decimal-input" name="this_msal"
                               value="{{ number_format(old('this_msal', 0), 2, '.', '') }}" required>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <button type="submit" class="btn btn-success">Хадгалах</button>

</form>

@endsection

@push('scripts')
<script>
document.querySelectorAll('.decimal-input').forEach(function (input) {
    if (input.value !== '') input.value = parseFloat(input.value).toFixed(2);
    input.addEventListener('blur', function () {
        if (this.value !== '') this.value = parseFloat(this.value).toFixed(2);
    });
    input.addEventListener('input', function () {
        if (this.value < 0) this.value = 0;
    });
});
</script>
@endpush
