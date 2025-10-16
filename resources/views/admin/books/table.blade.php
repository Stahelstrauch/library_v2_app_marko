@extends('layouts.app')
@section('title', 'Raamatud')
@section('content')

<div class="container my-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h4 mb-0">Raamatud</h1>
  </div>

  @if($books->count())
    <div class="table-responsive">
      <table class="table table-sm align-middle">
        <thead>
            <tr>
                <th>
                <a href="{{ route(Route::currentRouteName(), ['sort' => 'title', 'direction' => request('direction') === 'asc' && request('sort') === 'title' ? 'desc' : 'asc']) }}">
                    Pealkiri
                    @if(request('sort') === 'title')
                    {{ request('direction') === 'asc' ? '↑' : '↓' }}
                    @endif
                </a>
                </th>
                <th>
                <a href="{{ route(Route::currentRouteName(), ['sort' => 'author', 'direction' => request('direction') === 'asc' && request('sort') === 'author' ? 'desc' : 'asc']) }}">
                    Autor
                    @if(request('sort') === 'author')
                    {{ request('direction') === 'asc' ? '↑' : '↓' }}
                    @endif
                </a>
                </th>
                <th>Aasta</th>
                <th>ISBN</th>
                <th>Lehti</th>
            </tr>
        </thead>

        <tbody>
        @foreach($books as $book)
          <tr>
            <td>{{ $book->title }}</td>
            <td>{{ $book->author?->name }}</td>
            <td>{{ $book->published_year ?? '—' }}</td>
            <td>{{ $book->isbn ?? '—' }}</td>
            <td>{{ $book->pages ?? '—' }}</td>
            </td>
          </tr>
        @endforeach
        </tbody>
      </table>
    </div>
      @else
    <div class="alert alert-info mb-0">Raamatud puuduvad. Lisa esimene raamat.</div>
  @endif
</div>

@endsection