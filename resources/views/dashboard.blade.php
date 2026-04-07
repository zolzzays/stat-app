@extends('layouts.app')

@section('title', 'Хянах самбар')

@section('content')

<h4 class="fw-bold mb-4">Хянах самбар — {{ $currentYear }} он</h4>

{{-- ══════════════════════════════════════════
     ADMIN VIEW
══════════════════════════════════════════ --}}
@if($orgStats)
<div class="row g-3 mb-4">

    {{-- Үйлдвэрлэлийн мэдээ хяналт --}}
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
                <span>⚡ Үйлдвэрлэлийн мэдээ — {{ $orgStats['year'] }}.{{ str_pad($orgStats['month'], 2, '0', STR_PAD_LEFT) }} сар</span>
                <span class="badge bg-secondary">
                    {{ $orgStats['output']['submitted']->count() }} / {{ $orgStats['total'] }} байгууллага
                </span>
            </div>
            <div class="card-body p-0">
                @if($orgStats['output']['submitted']->count() > 0)
                <div class="px-3 pt-3 pb-1">
                    <p class="text-success fw-semibold mb-1 small">✔ Мэдээ өгсөн ({{ $orgStats['output']['submitted']->count() }})</p>
                    <ul class="list-group list-group-flush mb-2">
                        @foreach($orgStats['output']['submitted'] as $org)
                        <li class="list-group-item py-1 ps-2 text-success small">{{ $org->org_name }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if($orgStats['output']['not_submitted']->count() > 0)
                <div class="px-3 pb-3">
                    <p class="text-danger fw-semibold mb-1 small">✘ Мэдээ өгөөгүй ({{ $orgStats['output']['not_submitted']->count() }})</p>
                    <ul class="list-group list-group-flush">
                        @foreach($orgStats['output']['not_submitted'] as $org)
                        <li class="list-group-item py-1 ps-2 text-danger small">{{ $org->org_name }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if($orgStats['total'] === 0)
                <p class="text-muted text-center py-3 small">Байгууллага бүртгэгдээгүй байна.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Борлуулалтын мэдээ хяналт --}}
    <div class="col-md-6">
        <div class="card shadow-sm h-100">
            <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
                <span>📦 Борлуулалтын мэдээ — {{ $orgStats['year'] }}.{{ str_pad($orgStats['month'], 2, '0', STR_PAD_LEFT) }} сар</span>
                <span class="badge bg-secondary">
                    {{ $orgStats['sales']['submitted']->count() }} / {{ $orgStats['total'] }} байгууллага
                </span>
            </div>
            <div class="card-body p-0">
                @if($orgStats['sales']['submitted']->count() > 0)
                <div class="px-3 pt-3 pb-1">
                    <p class="text-success fw-semibold mb-1 small">✔ Мэдээ өгсөн ({{ $orgStats['sales']['submitted']->count() }})</p>
                    <ul class="list-group list-group-flush mb-2">
                        @foreach($orgStats['sales']['submitted'] as $org)
                        <li class="list-group-item py-1 ps-2 text-success small">{{ $org->org_name }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if($orgStats['sales']['not_submitted']->count() > 0)
                <div class="px-3 pb-3">
                    <p class="text-danger fw-semibold mb-1 small">✘ Мэдээ өгөөгүй ({{ $orgStats['sales']['not_submitted']->count() }})</p>
                    <ul class="list-group list-group-flush">
                        @foreach($orgStats['sales']['not_submitted'] as $org)
                        <li class="list-group-item py-1 ps-2 text-danger small">{{ $org->org_name }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if($orgStats['total'] === 0)
                <p class="text-muted text-center py-3 small">Байгууллага бүртгэгдээгүй байна.</p>
                @endif
            </div>
        </div>
    </div>

</div>
@endif

{{-- ══════════════════════════════════════════
     USER (STATION) VIEW
══════════════════════════════════════════ --}}
@if($userStats)

{{-- Анхааруулга: сарын 5-ны дотор мэдээ оруулах --}}
@if($userStats['showWarning'])
<div class="alert alert-warning border-warning shadow-sm mb-4" role="alert" style="border-left: 5px solid #f0ad4e;">
    <div class="d-flex align-items-start gap-2">
        <span style="font-size:1.4rem;">⚠️</span>
        <div>
            <div class="fw-bold mb-1">Мэдээ оруулах хугацааны анхааруулга</div>
            <div class="small">
                <strong>{{ $userStats['warnYear'] }} оны {{ $userStats['warnMonth'] }} сарын</strong> мэдээг
                энэ сарын <strong>05-ны дотор</strong> оруулсан байх шаардлагатай.
                @if(!$userStats['hasOutput'] || !$userStats['hasSales'] || !$userStats['hasHr'])
                <br>
                <span class="text-danger fw-semibold">Дараах мэдээ бүртгэгдээгүй байна:</span>
                @if(!$userStats['hasOutput']) <span class="badge bg-danger ms-1">Үйлдвэрлэл</span> @endif
                @if(!$userStats['hasSales'])  <span class="badge bg-danger ms-1">Борлуулалт</span> @endif
                @if(!$userStats['hasHr'])     <span class="badge bg-danger ms-1">Хүний нөөц</span> @endif
                @else
                <br><span class="text-success fw-semibold">✔ Бүх мэдээ бүртгэгдсэн байна.</span>
                @endif
            </div>
        </div>
    </div>
</div>
@endif

{{-- ── Хүний нөөцийн мэдээ ── --}}
<h5 class="fw-bold mb-3 mt-2">👥 Хүний нөөцийн мэдээ</h5>
@if($userStats['hrRecords']->count() > 0)
<div class="row g-3 mb-4">
    @foreach($userStats['hrRecords'] as $hr)
    <div class="col-sm-6 col-lg-4 col-xl-3">
        <div class="card shadow-sm h-100 border-0" style="border-top: 3px solid #1a4fa0 !important; border-top-width: 3px !important;">
            <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center"
                 style="background:#eef3fb; border-bottom:1px solid #d0ddf5;">
                <span class="fw-bold text-primary" style="font-size:0.9rem;">
                    {{ $hr->year }} он {{ $hr->month }} сар
                </span>
                <span class="badge" style="background:#1a4fa0; font-size:0.7rem;">Хүний нөөц</span>
            </div>
            <div class="card-body px-3 py-2" style="font-size:0.83rem;">
                <div class="mb-2">
                    <div class="text-muted small fw-semibold mb-1">Нийт ажиллагчид</div>
                    <div class="d-flex justify-content-between">
                        <span>Эрэгтэй</span><span class="fw-semibold">{{ $hr->emp_male }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Эмэгтэй</span><span class="fw-semibold">{{ $hr->emp_female }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-top mt-1 pt-1">
                        <span class="fw-bold">Нийт</span>
                        <span class="fw-bold text-primary">{{ $hr->emp_male + $hr->emp_female }}</span>
                    </div>
                </div>
                <div>
                    <div class="text-muted small fw-semibold mb-1">Нийт ажилчид</div>
                    <div class="d-flex justify-content-between">
                        <span>Эрэгтэй</span><span class="fw-semibold">{{ $hr->work_male }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Эмэгтэй</span><span class="fw-semibold">{{ $hr->work_female }}</span>
                    </div>
                    <div class="d-flex justify-content-between border-top mt-1 pt-1">
                        <span class="fw-bold">Нийт</span>
                        <span class="fw-bold text-primary">{{ $hr->work_male + $hr->work_female }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<p class="text-muted mb-4">Хүний нөөцийн мэдээ байхгүй байна.</p>
@endif

{{-- ── Үйлдвэрлэлийн мэдээ ── --}}
<h5 class="fw-bold mb-3">⚡ Үйлдвэрлэлийн мэдээ</h5>
@if($userStats['outputRecords']->count() > 0)
<div class="row g-3 mb-4">
    @foreach($userStats['outputRecords'] as $out)
    <div class="col-sm-6 col-lg-4 col-xl-3">
        <div class="card shadow-sm h-100 border-0" style="border-top: 3px solid #e6a817 !important;">
            <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center"
                 style="background:#fdf8ec; border-bottom:1px solid #f0dda0;">
                <span class="fw-bold" style="color:#8a6000; font-size:0.9rem;">
                    {{ $out->year }} он {{ $out->month }} сар
                </span>
                <span class="badge bg-warning text-dark" style="font-size:0.7rem;">Үйлдвэрлэл</span>
            </div>
            <div class="card-body px-3 py-2" style="font-size:0.83rem;">
                <div class="fw-semibold mb-2 text-truncate" title="{{ $out->product_name }}">
                    {{ $out->product_name }}
                    <span class="text-muted fw-normal">({{ $out->unit_name }})</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span class="text-muted" style="font-size:0.78rem;">Өмнөх сар<br><small>(өөрийн хэрэглээг хасаагүй)</small></span>
                    <span class="fw-semibold">{{ number_format($out->before_month, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mt-1">
                    <span class="text-muted" style="font-size:0.78rem;">Тайлант сарын үйлдвэрлэл</span>
                    <span class="fw-semibold">{{ number_format($out->this_month, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mt-1">
                    <span class="text-muted" style="font-size:0.78rem;">Тайлант сарын өөрийн хэрэглээ</span>
                    <span class="fw-semibold">{{ number_format($out->year_usage, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mt-1 border-top pt-1">
                    <span class="text-muted" style="font-size:0.78rem;">Тайлант сарын эцсийн үлдэгдэл (түгээлт)</span>
                    <span class="fw-bold text-success">{{ number_format($out->this_month - $out->year_usage, 2) }}</span>
                </div>
                <div class="d-flex justify-content-between mt-1 border-top pt-1">
                    <span class="fw-semibold" style="font-size:0.78rem;">Жилийн эхнээс<br><small class="fw-normal text-muted">(өөрийн хэрэглээг хасаагүй)</small></span>
                    <span class="fw-bold" style="color:#8a6000;">{{ number_format($out->this_musage, 2) }}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<p class="text-muted mb-4">Үйлдвэрлэлийн мэдээ байхгүй байна.</p>
@endif

{{-- ── Борлуулалтын мэдээ ── --}}
<h5 class="fw-bold mb-3">📦 Борлуулалтын мэдээ</h5>
@if($userStats['salesRecords']->count() > 0)
<div class="row g-3 mb-4">
    @foreach($userStats['salesRecords'] as $sale)
    <div class="col-sm-6 col-lg-4 col-xl-3">
        <div class="card shadow-sm h-100 border-0" style="border-top: 3px solid #198754 !important;">
            <div class="card-header py-2 px-3 d-flex justify-content-between align-items-center"
                 style="background:#edf7f1; border-bottom:1px solid #a8d9bc;">
                <span class="fw-bold text-success" style="font-size:0.9rem;">
                    {{ $sale->year }} он {{ $sale->month }} сар
                </span>
                <span class="badge bg-success" style="font-size:0.7rem;">Борлуулалт</span>
            </div>
            <div class="card-body px-3 py-2" style="font-size:0.8rem;">
                <div class="fw-semibold mb-2 text-truncate" title="{{ $sale->product_name }}">
                    {{ $sale->product_name }}
                    <span class="text-muted fw-normal">({{ $sale->unit_name }})</span>
                </div>

                {{-- Хүснэгт хэлбэрээр --}}
                <table class="table table-sm table-borderless mb-0" style="font-size:0.77rem;">
                    <thead>
                        <tr class="text-muted text-center" style="font-size:0.72rem; border-bottom:1px solid #dee2e6;">
                            <th class="text-start ps-0 fw-normal"></th>
                            <th class="fw-semibold">Биет хэмжээ</th>
                            <th class="fw-semibold">Үнийн дүн<br><span class="fw-normal">(мян.төг)</span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-muted ps-0">Өмнөх сар</td>
                            <td class="text-center fw-semibold">{{ number_format($sale->before_month, 2) }}</td>
                            <td class="text-center fw-semibold">{{ number_format($sale->before_sal, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Тайлант сар</td>
                            <td class="text-center fw-semibold">{{ number_format($sale->this_month, 2) }}</td>
                            <td class="text-center fw-semibold">{{ number_format($sale->this_sal, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted ps-0">Өөрийн хэрэглээ</td>
                            <td class="text-center fw-semibold">{{ number_format($sale->year_usage, 2) }}</td>
                            <td class="text-center fw-semibold">{{ number_format($sale->year_sal, 2) }}</td>
                        </tr>
                        <tr style="border-top:1px solid #dee2e6;">
                            <td class="fw-bold ps-0">Жилийн эхнээс</td>
                            <td class="text-center fw-bold text-success">{{ number_format($sale->this_musage, 2) }}</td>
                            <td class="text-center fw-bold text-success">{{ number_format($sale->this_msal, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>
@else
<p class="text-muted mb-4">Борлуулалтын мэдээ байхгүй байна.</p>
@endif

@endif

@endsection
