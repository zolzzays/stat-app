@extends('layouts.app')

@section('title', 'Борлуулалтын мэдээ')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold">Борлуулалтын мэдээ</h4>
    @if(auth()->user()->role?->name !== 'admin')
        <a href="{{ route('energy_sales.create') }}" class="btn btn-success btn-sm">+ Шинэ нэмэх</a>
    @endif
</div>

@include('partials.filter_bar', ['action' => route('energy_sales.index'), 'year' => $year, 'month' => $month, 'regTypes' => $regTypes, 'regTypeId' => $regTypeId])

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center mb-0" style="font-size: 0.82rem;">
        <thead class="table-light">
            <tr>
                <th rowspan="3" class="align-middle">#</th>
                <th rowspan="3" class="align-middle">Байгууллага</th>
                <th rowspan="3" class="align-middle">Станц</th>
                <th rowspan="3" class="align-middle">Бүртгэлийн төрөл</th>
                <th rowspan="3" class="align-middle">Бүтээгдэхүүн</th>
                <th rowspan="3" class="align-middle">Нэгж</th>
                <th colspan="2" class="text-center table-info">Өмнөх сар</th>
                <th colspan="2" class="text-center table-warning">Тайлант сар</th>
                <th colspan="2" class="text-center table-success">Өөрийн хэрэглээ</th>
                <th colspan="2" class="text-center table-secondary">Жилийн эхнээс</th>
                <th rowspan="3" class="align-middle">Үйлдэл</th>
            </tr>
            <tr>
                <th class="table-info">Биет хэмжээ</th>
                <th class="table-info">Үнийн дүн<br>(мян.төг)</th>
                <th class="table-warning">Биет хэмжээ</th>
                <th class="table-warning">Үнийн дүн<br>(мян.төг)</th>
                <th class="table-success">Биет хэмжээ</th>
                <th class="table-success">Үнийн дүн<br>(мян.төг)</th>
                <th class="table-secondary">Биет хэмжээ</th>
                <th class="table-secondary">Үнийн дүн<br>(мян.төг)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $i => $sale)
            <tr>
                <td class="text-muted">{{ $i + 1 }}</td>
                <td class="text-start">{{ $sale->organization?->org_name ?? '—' }}</td>
                <td class="text-start fw-semibold">{{ $sale->powerPlant->plant_name }}</td>
                <td class="text-start">{{ $sale->powerPlant->regType?->type_name ?? '—' }}</td>
                <td class="text-start">{{ $sale->product_name }}</td>
                <td>{{ $sale->unit_name }}</td>
                <td>{{ number_format($sale->before_month, 2) }}</td>
                <td>{{ number_format($sale->before_sal, 2) }}</td>
                <td>{{ number_format($sale->this_month, 2) }}</td>
                <td>{{ number_format($sale->this_sal, 2) }}</td>
                <td>{{ number_format($sale->year_usage, 2) }}</td>
                <td>{{ number_format($sale->year_sal, 2) }}</td>
                <td>{{ number_format($sale->this_musage, 2) }}</td>
                <td>{{ number_format($sale->this_msal, 2) }}</td>
                <td>
                    @if(auth()->user()->role?->name !== 'admin')
                    <div class="d-flex justify-content-center gap-1">
                        <a href="{{ route('energy_sales.edit', $sale->id) }}"
                           class="btn btn-warning btn-sm">Засах</a>
                        <form action="{{ route('energy_sales.destroy', $sale->id) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Устгах уу?')">Устгах</button>
                        </form>
                    </div>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="14" class="text-center text-muted py-4">Мэдээлэл байхгүй байна.</td>
            </tr>
            @endforelse
        </tbody>
        @if($sales->count() > 0)
        <tfoot class="table-light fw-semibold">
            <tr>
                <td colspan="6" class="text-end">Нийт дүн:</td>
                <td>{{ number_format($sales->sum('before_month'), 2) }}</td>
                <td>{{ number_format($sales->sum('before_sal'), 2) }}</td>
                <td>{{ number_format($sales->sum('this_month'), 2) }}</td>
                <td>{{ number_format($sales->sum('this_sal'), 2) }}</td>
                <td>{{ number_format($sales->sum('year_usage'), 2) }}</td>
                <td>{{ number_format($sales->sum('year_sal'), 2) }}</td>
                <td>{{ number_format($sales->sum('this_musage'), 2) }}</td>
                <td>{{ number_format($sales->sum('this_msal'), 2) }}</td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>

@endsection
