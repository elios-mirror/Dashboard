<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Elios Development</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/home') }}">
                <img src="/images/logo.png" alt="logo elios" width="35px" style="margin-right: .5rem;">
                Elios Development
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                        <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                    @else
                        <li>
                            <span class="badge badge-light badge-menu-buttons">
                                <a class="nav-link" href="{{ route('import-module') }}">
                                    <i class="fas fa-upload"></i> &nbsp;Upload
                                </a>
                            </span>
                        </li>
                        <li>
                            <span class="badge badge-light badge-menu-buttons">
                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                    <i class="fas fa-power-off"></i>
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </span>
                        </li>
                        {{--<li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('import-module') }}">
                                    {{ __('Import Application') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('modules-index') }}">
                                    {{ __('Update Application') }}
                                </a>

                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>--}}
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>

<!-- Scripts -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    function getFileDataLogo(myFile) {
        const file = myFile.files[0];
        const filename = file.name;
        document.getElementById('choose_logo').innerHTML = filename;
    }

    function getFileDataScreens(myFile) {
        let count = 0;
        Array.from(myFile.files).forEach(file => {
            count++
        });
        document.getElementById('choose_screens').innerHTML = count + ' files uploaded';
    }
</script>

</body>
</html>
