@extends('layouts.app')
@section('title', 'Kasutajad')
@section('content')

<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Kasutajad</h1>
  </div>

  @if ($users->count())
      <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead>
          <tr>
            <th>Kasutajanimi</th>
            <th>Email</th>
            <th>Loodud</th>
            <th>Viimati logis sisse</th>
            <th class="text-end">Kustuta</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
               @if ($user->id !=1) 
                <td>{{ $user->name }}</td>
                <td>{{ $user->email}}</td>
                <td>{{ $user->created_at->format('d.m.Y H:i:s')}}</td>
                <td>{{ $user->last_login_at ? $user->last_login_at->format('d.m.Y H:i:s') : '—' }}</td>

                <td class="text-end">
                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                        onsubmit="return confirm('Kustutan kindlasti?');">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Kustuta</button>
                </form>
                </td>
            </tr>
                @endif
         @endforeach
        </tbody>
      </table>
    </div>
    <div class="mt-3">
      {{ $users->links() }}
    </div>
  @else
    <div class="alert alert-info">Kasutajaid ei leitud.</div>
  @endif
</div>
@endsection