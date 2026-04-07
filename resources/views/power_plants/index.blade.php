@extends('layouts.app')

@section('title', 'Станцын жагсаалт')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold">Станцын жагсаалт</h4>
    <a href="{{ route('power_plants.create') }}" class="btn btn-primary btn-sm">+ Нэмэх</a>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-light border-bottom border-secondary">
        <tr>
            <th>#</th>
            <th>Станцын нэр</th>
            <th>Төрөл</th>
            <th>Байгууллага</th>
            <th>Бүртгэлийн төрөл</th>
            <th>Үйлдэл</th>
        </tr>
    </thead>
    <tbody>
        @forelse($plants as $plant)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $plant->plant_name }}</td>
            <td>{{ $plant->type->t_name }}</td>
            <td>{{ $plant->organization?->org_name ?? '—' }}</td>
            <td>{{ $plant->regType?->type_name ?? '—' }}</td>
            <td>
                <a href="{{ route('power_plants.edit', $plant->id) }}" class="btn btn-warning btn-sm">Засах</a>
                <form action="{{ route('power_plants.destroy', $plant->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Устгах уу?')">Устгах</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center text-muted py-4">Мэдээлэл байхгүй байна.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection
