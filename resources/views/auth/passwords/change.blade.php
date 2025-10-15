@extends('layouts.app')
@section('title', 'Muuda parooli')
@section('content')
    <div class="container d-flex justify-content-center align-item-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h1 class="h4 mb-4 text-center">Muuda parooli</h1>

                    @if (session('status'))
                        <div class="alert alert-success">{{ session('status')}}</div>
                    @endif

                    <form action="{{ route('admin.password.update') }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label">Praegune parool</label>
                        <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Uus parool</label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kinnita uus parool</label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-primary">Salvesta</button>
                    </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection