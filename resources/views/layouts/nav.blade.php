<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">Raamatukogu</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topnav"
                aria-controls="topnav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="topnav">
            {{-- Avalik menüü --}}
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="{{ route('books.index') }}">Raamatud</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('authors.index') }}">Autorid</a></li>
            </ul>

            {{-- Auth plokk --}}
            <ul class="navbar-nav ms-auto">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Logi sisse</a>
                    </li>
                @endguest

                @auth
                    {{-- Admin lingid otse menüüsse --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">Töölaud</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/authors') }}">Autorid</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/admin/books') }}">Raamatud</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.password.change') }}">Muuda parooli</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link">Logi välja</button>
                        </form>
                    </li>
                @endauth
            </ul>

        </div>
    </div>
</nav>
