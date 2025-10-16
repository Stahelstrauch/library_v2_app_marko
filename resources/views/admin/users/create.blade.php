@extends('layouts.app')

@section('title','Loo kasutaja')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height:70vh;">
  <div class="col-md-6">
    <div class="card shadow-sm">
      <div class="card-body">
        <h1 class="h5 mb-3 text-center">Loo uus kasutaja</h1>

        @if(session('status')) <div class="alert alert-success">{{ session('status') }}</div> @endif

        <form method="POST" action="{{ route('admin.users.store') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Nimi</label>
            <input name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">E-post</label>
            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Ajutine parool</label>
            <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
          </div>

          <div class="mb-3">
            <label class="form-label">Kinnita parool</label>
            <input name="password_confirmation" type="password" class="form-control" required>
          </div>

          <div class="mb-3">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="is_admin" id="is_admin">
              <label class="form-check-label" for="is_admin">
                Administraator
              </label>
            </div>

          <div class="d-grid">
            <button class="btn btn-primary">Loo kasutaja</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
