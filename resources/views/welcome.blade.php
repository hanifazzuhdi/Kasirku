<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Kasirku</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .content .d {
            text-decoration: none;
            color: #636b6f;
            cursor: initial;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">

        <div class="top-right links">
            @auth

            @if (Auth::user()->role_id != 3)
            <a href="{{ Auth::user()->role_id == 1 ? '/dashboard/admin' : '/dashboard/staff'}}">Home</a>
            @else
            <a href="{{route('kasir')}}">Kembali Kerja</a>
            @endif

            <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            @endauth
        </div>

        <div class="content">
            <div class="title m-b-md">
                Kasir <a class="d" href="{{route('login')}}">Ku</a>
            </div>

            <div class="links">
                <a href="https://github.com/zem-art">Zaim (Mobile)</a>
                <a href="https://github.com/hanifazzuhdi">Hanif (Backend)</a>
            </div>
        </div>
    </div>
</body>

</html>
