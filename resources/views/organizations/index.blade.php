@extends('layouts.app')

@section('title', 'Байгууллага')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="mb-0 fw-bold">Байгууллагын жагсаалт</h4>
    <a href="{{ route('organizations.create') }}" class="btn btn-primary btn-sm">+ Нэмэх</a>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-light border-bottom border-secondary">
        <tr>
            <th>#</th>
            <th>Байгууллагын нэр</th>
            <th>Код</th>
            <th>Үйлдэл</th>
        </tr>
    </thead>
    <tbody>
        @forelse($organizations as $i => $org)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $org->org_name }}</td>
            <td>{{ $org->org_code }}</td>
            <td>
                <a href="{{ route('organizations.edit', $org->id) }}" class="btn btn-warning btn-sm">Засах</a>
                <form action="{{ route('organizations.destroy', $org->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm"
                            onclick="return confirm('Устгах уу?')">Устгах</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center text-muted py-4">Мэдээлэл байхгүй байна.</td>
        </tr>
        @endforelse
    </tbody>
</table>

@endsection
