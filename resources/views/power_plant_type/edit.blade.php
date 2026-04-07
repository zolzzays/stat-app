@extends('layouts.app')

@section('content')

<div class="card">
    <div class="card-header">Засах</div>

    <div class="card-body">

        <form method="POST" action="{{ route('powerplant.update', $item->id) }}">
            @csrf

            <div class="mb-3">
                <label>Төрлийн нэр</label>
                <input type="text" name="t_name" value="{{ $item->t_name }}" class="form-control">
            </div>

            <button class="btn btn-success">Шинэчлэх</button>

        </form>

    </div>
</div>

@endsection