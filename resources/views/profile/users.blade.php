@extends('layouts.app')

@section('title', 'Хэрэглэгчийн мэдээлэл')

@section('content')

<h4 class="fw-bold mb-4">👥 Хэрэглэгчийн мэдээлэл</h4>

<div class="table-responsive">
    <table class="table table-bordered table-hover align-middle" style="font-size:0.88rem;">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Нэр</th>
                <th>Имэйл</th>
                <th>Байгууллага</th>
                <th>Станц</th>
                <th>Албан тушаал</th>
                <th>Утасны дугаар</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $i => $user)
            <tr>
                <td class="text-muted">{{ $i + 1 }}</td>
                <td class="fw-semibold">{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->organization?->org_name ?? '—' }}</td>
                <td>{{ $user->powerPlant?->plant_name ?? '—' }}</td>
                <td>{{ $user->position ?? '—' }}</td>
                <td>{{ $user->phone ?? '—' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted py-4">Хэрэглэгч байхгүй байна.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
