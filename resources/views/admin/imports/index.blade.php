@extends('layouts.app')
@section('title', 'Faili üleslaadimine')

@section('content')
<div class="container mt-4">
    <h2>Siin saab faili laadida</h2>

    @if(session('success'))
        <div class="alert alert-success">
            <strong>{{ session('success') }}</strong><br>
            @if(session('imported') !== null && session('skipped') !== null)
                <ul class="mb-0 mt-2">
                    <li>Imporditud: <strong>{{ session('imported') }}</strong></li>
                    <li>Vahele jäetud: <strong>{{ session('skipped') }}</strong></li>
                </ul>
            @endif
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.imports.index') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="csv_file" class="form-label">CSV fail</label>
            <input type="file" name="csv_file" id="csv_file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Impordi</button>
    </form>
</div>
@endsection
