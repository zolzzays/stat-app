@extends('layouts.app')

@section('title', 'Хүний нөөцийн мэдээ')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold">Хүний нөөцийн мэдээ</h4>
    <a href="{{ route('hr_count.create') }}" class="btn btn-success btn-sm">+ Шинэ нэмэх</a>
</div>

@include('partials.filter_bar', ['action' => route('hr_count.index'), 'year' => $year, 'month' => $month, 'regTypes' => $regTypes, 'regTypeId' => $regTypeId])

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center" style="font-size:0.875rem;">
        <thead class="table-light border-bottom border-secondary">
            <tr>
                <th rowspan="2" class="align-middle">#</th>
                <th rowspan="2" class="align-middle">Байгууллага</th>
                <th rowspan="2" class="align-middle">Станц</th>
                <th rowspan="2" class="align-middle">Бүртгэлийн төрөл</th>
                <th colspan="3" class="text-center">Нийт ажиллагчид</th>
                <th colspan="3" class="text-center">Нийт ажилчид</th>
                <th rowspan="2" class="align-middle">Үйлдэл</th>
            </tr>
            <tr>
                <th class="table-secondary">Эрэгтэй</th>
                <th class="table-secondary">Эмэгтэй</th>
                <th class="table-secondary">Нийт</th>
                <th class="table-secondary">Эрэгтэй</th>
                <th class="table-secondary">Эмэгтэй</th>
                <th class="table-secondary">Нийт</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $i => $row)
            <tr>
                <td class="text-muted">{{ $i + 1 }}</td>
                <td class="text-start">{{ $row->organization?->org_name ?? '—' }}</td>
                <td class="text-start fw-semibold">{{ $row->powerPlant->plant_name }}</td>
                <td class="text-start">{{ $row->powerPlant->regType?->type_name ?? '—' }}</td>
                <td>{{ $row->emp_male }}</td>
                <td>{{ $row->emp_female }}</td>
                <td class="fw-semibold">{{ $row->emp_male + $row->emp_female }}</td>
                <td>{{ $row->work_male }}</td>
                <td>{{ $row->work_female }}</td>
                <td class="fw-semibold">{{ $row->work_male + $row->work_female }}</td>
                <td>
                    <div class="d-flex justify-content-center gap-1">
                        <a href="{{ route('hr_count.edit', $row->id) }}" class="btn btn-warning btn-sm">Засах</a>
                        <form action="{{ route('hr_count.destroy', $row->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Устгах уу?')">Устгах</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="11" class="text-center text-muted py-4">Мэдээлэл байхгүй байна.</td>
            </tr>
            @endforelse
        </tbody>
        @if($rows->count() > 0)
        <tfoot class="table-light fw-semibold">
            <tr>
                <td colspan="4" class="text-end">Нийт дүн:</td>
                <td>{{ $rows->sum('emp_male') }}</td>
                <td>{{ $rows->sum('emp_female') }}</td>
                <td>{{ $rows->sum('emp_male') + $rows->sum('emp_female') }}</td>
                <td>{{ $rows->sum('work_male') }}</td>
                <td>{{ $rows->sum('work_female') }}</td>
                <td>{{ $rows->sum('work_male') + $rows->sum('work_female') }}</td>
                <td></td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>

@endsection
