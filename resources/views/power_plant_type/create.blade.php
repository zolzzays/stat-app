@extends('layouts.app')

@section('content')

<div class="card shadow">
    <div class="card-header bg-primary text-white">
        Станцын төрөл бүртгэх
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('powerplant.store') }}">
            @csrf

            <div class="mb-3">
                <label>Төрлийн нэр</label>
                <input type="text" name="t_name" class="form-control">
            </div>

            <button class="btn btn-success">Хадгалах</button>

        </form>

    </div>
</div>

@endsection