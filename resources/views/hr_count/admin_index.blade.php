@extends('layouts.app')

@section('title', 'Хүний нөөцийн мэдээ')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold">Хүний нөөцийн мэдээ — нийт</h4>
</div>

@include('partials.filter_bar', ['action' => route('hr_count.index'), 'year' => $year, 'month' => $month])

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle text-center" style="font-size:0.875rem;">
        <thead class="table-light border-bottom border-secondary">
            <tr>
                <th rowspan="2" class="align-middle">#</th>
                <th rowspan="2" class="align-middle">Байгууллага</th>
                <th rowspan="2" class="align-middle">Станц</th>
                <th colspan="3" class="text-center bg-info bg-opacity-25">Нийт ажилчид</th>
                <th colspan="3" class="text-center bg-warning bg-opacity-25">Нийт ИТА</th>
            </tr>
            <tr>
                <th class="table-secondary">Эрэгтэй</th>
                <th class="table-secondary">Эмэгтэй</th>
                <th class="table-secondary fw-bold">Нийт</th>
                <th class="table-secondary">Эрэгтэй</th>
                <th class="table-secondary">Эмэгтэй</th>
                <th class="table-secondary fw-bold">Нийт</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $i => $row)
            <tr>
                <td class="text-muted">{{ $i + 1 }}</td>
                <td class="text-start">{{ $row->organization?->org_name ?? '—' }}</td>
                <td class="text-start fw-semibold">{{ $row->powerPlant->plant_name }}</td>
                <td>{{ $row->emp_male }}</td>
                <td>{{ $row->emp_female }}</td>
                <td class="fw-semibold">{{ $row->emp_male + $row->emp_female }}</td>
                <td>{{ $row->work_male }}</td>
                <td>{{ $row->work_female }}</td>
                <td class="fw-semibold">{{ $row->work_male + $row->work_female }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="9" class="text-center text-muted py-4">Мэдээлэл байхгүй байна.</td>
            </tr>
            @endforelse
        </tbody>
        @if($rows->count() > 0)
        <tfoot class="table-light fw-bold">
            <tr>
                <td colspan="3" class="text-end">Нийт дүн:</td>
                <td>{{ $rows->sum('emp_male') }}</td>
                <td>{{ $rows->sum('emp_female') }}</td>
                <td>{{ $rows->sum('emp_male') + $rows->sum('emp_female') }}</td>
                <td>{{ $rows->sum('work_male') }}</td>
                <td>{{ $rows->sum('work_female') }}</td>
                <td>{{ $rows->sum('work_male') + $rows->sum('work_female') }}</td>
            </tr>
        </tfoot>
        @endif
    </table>
</div>

@endsection
