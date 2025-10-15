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
                    {{-- Kasutaja menüü (dropdown) --}}
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userMenu" role="button"
                           data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user me-2"></i>
                            <span class="d-none d-sm-inline">{{ Auth::user()->name }}</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userMenu">
                            <li class="dropdown-header">
                                <strong>{{ Auth::user()->name }}</strong><br>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            <li class="px-3 py-1 small">
                                @php($provider = Auth::user()->last_login_method === 'google' ? 'google' : 'local')
                                @if($provider === 'google')
                                    <i class="fa-brands fa-google me-2 text-danger" aria-hidden="true"></i> Google konto
                                @else
                                    <i class="fa-solid fa-house-chimney me-2 text-primary" aria-hidden="true"></i> Lokaalne konto
                                @endif
                            </li>

                            <li><hr class="dropdown-divider"></li>

                            {{-- Üldlingid sisseloginule --}}
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="fa-solid fa-gauge-high me-2" aria-hidden="true"></i> Töölaud
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('admin.password.change') }}">
                                    <i class="fa-solid fa-key me-2" aria-hidden="true"></i> Muuda parooli
                                </a>
                            </li>

                            {{-- Admin lingid --}}
                            @can('manage-users')
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('/admin/authors') }}">
                                        <i class="fa-solid fa-pen-nib me-2" aria-hidden="true"></i> Autorid
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ url('/admin/books') }}">
                                        <i class="fa-solid fa-book me-2" aria-hidden="true"></i> Raamatud
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.users.create') }}">
                                        <i class="fa-solid fa-user-plus me-2" aria-hidden="true"></i> Uus kasutaja
                                    </a>
                                </li>
                            @endcan

                            <li><hr class="dropdown-divider"></li>

                            {{-- Logi välja (POST) --}}
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fa-solid fa-right-from-bracket me-2" aria-hidden="true"></i> Logi välja
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
