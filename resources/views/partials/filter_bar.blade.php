<form method="GET" action="{{ $action }}" class="row g-2 align-items-end mb-3">
    <div class="col-auto">
        <label class="form-label mb-1 small">Он</label>
        <input type="number" name="year" class="form-control form-control-sm"
               value="{{ $year ?? '' }}" placeholder="2026" min="2000" max="2100" style="width:90px">
    </div>
    <div class="col-auto">
        <label class="form-label mb-1 small">Сар</label>
        <select name="month" class="form-select form-select-sm" style="width:100px">
            <option value="">Бүгд</option>
            @for($m = 1; $m <= 12; $m++)
                <option value="{{ $m }}" {{ ($month ?? '') == $m ? 'selected' : '' }}>{{ $m }} сар</option>
            @endfor
        </select>
    </div>
    @if(!empty($regTypes) && $regTypes->count() > 0)
    <div class="col-auto">
        <label class="form-label mb-1 small">Бүртгэлийн төрөл</label>
        <select name="reg_type_id" class="form-select form-select-sm" style="width:160px">
            <option value="">Бүгд</option>
            @foreach($regTypes as $rt)
                <option value="{{ $rt->id }}" {{ ($regTypeId ?? '') == $rt->id ? 'selected' : '' }}>
                    {{ $rt->type_name }}
                </option>
            @endforeach
        </select>
    </div>
    @endif
    @if(isset($showProductFilter) && $showProductFilter)
    <div class="col-auto">
        <label class="form-label mb-1 small">Бүтээгдэхүүн</label>
        <select name="product_type" class="form-select form-select-sm" style="width:140px">
            <option value="">Бүгд</option>
            <option value="Цахилгаан" {{ ($productType ?? '') === 'Цахилгаан' ? 'selected' : '' }}>⚡ Цахилгаан</option>
            <option value="Дулаан"    {{ ($productType ?? '') === 'Дулаан'    ? 'selected' : '' }}>🔥 Дулаан</option>
        </select>
    </div>
    @endif
    <div class="col-auto">
        <button type="submit" class="btn btn-primary btn-sm">Шүүх</button>
        <a href="{{ $action }}" class="btn btn-outline-secondary btn-sm">Цэвэрлэх</a>
    </div>
    <div class="col-auto ms-auto">
        <button type="submit" name="export" value="excel" class="btn btn-success btn-sm">
            ⬇ Excel
        </button>
    </div>
</form>
