@extends('layouts.app')
@section('title', 'Otsing')
@section('content')

<h1>Otsingumootor</h1>

{{-- ✅ Kuvame veateate, kui otsing on alla 3 märgi --}}
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('search') }}" method="GET">
    <input type="text" name="query" placeholder="Sisesta vähemalt 3 märki" value="{{ old('query') }}" required">
    <button type="submit">Otsi</button>
</form>

@if(isset($books))
    <h2>Tulemused:</h2>
    @if($books->isEmpty())
        <p>Tulemusi ei leitud.</p>
    @else
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr>
                        <th>Pealkiri</th>
                        <th>Autor</th>
                        <th>Aasta</th>
                        <th>Lehti</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author?->name ?? '—' }}</td>
                            <td>{{ $book->published_year ?? '—' }}</td>
                            <td>{{ $book->pages ?? '—' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endif

@endsection
