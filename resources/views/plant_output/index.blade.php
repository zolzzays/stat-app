@extends('layouts.app')

@section('title', 'Үйлдвэрлэлийн мэдээ')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold">Үйлдвэрлэлийн мэдээ</h4>
    @if(auth()->user()->role?->name !== 'admin')
        <a href="{{ route('plant_output.create') }}" class="btn btn-success btn-sm">+ Шинэ нэмэх</a>
    @endif
</div>

@include('partials.filter_bar', ['action' => route('plant_output.index'), 'year' => $year, 'month' => $month, 'regTypes' => $regTypes, 'regTypeId' => $regTypeId])

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center mb-0" style="font-size: 0.875rem;">
        <thead class="table-light border-bottom border-secondary">
            <tr>
                <th rowspan="2" class="align-middle">#</th>
                <th rowspan="2" class="align-middle">Байгууллага</th>
                <th rowspan="2" class="align-middle">Станц</th>
                <th rowspan="2" class="align-middle">Бүртгэлийн төрөл</th>
                <th rowspan="2" class="align-middle">Бүтээгдэхүүн</th>
                <th rowspan="2" class="align-middle">Нэгж</th>
                <th colspan="5" class="text-center">Үйлдвэрлэлийн мэдээлэл</th>
                <th rowspan="2" class="align-middle">Үйлдэл</th>
            </tr>
            <tr>
                <th class="table-secondary">Өмнөх сар<br>(өөрийн хэрэглээг хасаагүй)</th>
                <th class="table-secondary">Тайлант сарын<br>үйлдвэрлэл</th>
                <th class="table-secondary">Тайлант сарын<br>өөрийн хэрэглээнд<br>ашигласан<br>дотоод хэрэгцээ</th>
                <th class="table-success">Тайлант сарын<br>эцсийн үлдэгдэл<br>(түгээлт)</th>
                <th class="table-secondary">Жилийн эхнээс<br>(өөрийн хэрэглээг хасаагүй)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($outputs as $i => $output)
            <tr>
                <td class="text-muted">{{ $i + 1 }}</td>
                <td class="text-start">{{ $output->organization?->org_name ?? '—' }}</td>
                <td class="text-start fw-semibold">{{ $output->powerPlant->plant_name }}</td>
                <td class="text-start">{{ $output->powerPlant->regType?->type_name ?? '—' }}</td>
                <td class="text-start">{{ $output->product_name }}</td>
                <td>{{ $output->unit_name }}</td>
                <td>{{ number_format($output->before_month, 2) }}</td>
                <td>{{ number_format($output->this_month, 2) }}</td>
                <td>{{ number_format($output->year_usage, 2) }}</td>
                <td class="fw-semibold text-success">{{ number_format($output->this_month - $output->year_usage, 2) }}</td>
                <td>{{ number_format($output->this_musage, 2) }}</td>
                <td>
                    @if(auth()->user()->role?->name !== 'admin')
                    <div class="d-flex justify-content-center gap-1">
                        <a href="{{ route('plant_output.edit', $output->id) }}"
                           class="btn btn-warning btn-sm">Засах</a>
                        <form action="{{ route('plant_output.destroy', $output->id) }}"
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
                <td colspan="12" class="text-center text-muted py-4">Мэдээлэл байхгүй байна.</td>
            </tr>
            @endforelse
        </tbody>
        @if($outputs->count() > 0)
        <tfoot class="table-light fw-semibold">
            <tr>
                <td colspan="6" class="text-end">Нийт дүн:</td>
                <td>{{ number_format($outputs->sum('before_month'), 2) }}</td>
                <td>{{ number_format($outputs->sum('this_month'), 2) }}</td>
                <td>{{ number_format($outputs->sum('year_usage'), 2) }}</td>
                <td class="text-success">{{ number_format($outputs->sum('this_month') - $outputs->sum('year_usage'), 2) }}</td>
                <td>{{ number_format($outputs->sum('this_musage'), 2) }}</td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>

@endsection
