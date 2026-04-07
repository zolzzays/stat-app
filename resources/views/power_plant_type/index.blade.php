@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-3">
    <h4>Станцын төрөл жагсаалт</h4>
    <a href="{{ route('powerplant.create') }}" class="btn btn-primary">+ Нэмэх</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Нэр</th>
            <th>Үйлдэл</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $key => $row)
        <tr>
            <td>{{ $key+1 }}</td>
            <td>{{ $row->t_name }}</td>
            <td>
                <a href="{{ route('powerplant.edit', $row->id) }}" class="btn btn-warning btn-sm">Засах</a>
                <a href="{{ route('powerplant.delete', $row->id) }}" class="btn btn-danger btn-sm"
                   onclick="return confirm('Устгах уу?')">Устгах</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection