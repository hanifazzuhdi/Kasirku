<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

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
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @if (Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
            @endif
            @endauth
        </div>
        @endif

        <div class="content">

            <table class="table" border="1px" cellspacing='1' cellpadding="10">
                <tr>
                    <td>Order_id</td>
                    <td>Jumlah</td>
                    <td>kode_member</td>
                    <td>nama_member</td>
                    <td>nomor_member</td>
                    <td>bank</td>
                    <td>status</td>
                </tr>
                @foreach ($datas as $data)
                <tr>
                    <td>{{$data->order_id}}</td>
                    <td>{{$data->jumlah}}</td>
                    <td>{{$data->kode_member}}</td>
                    <td>{{$data->nama_member}}</td>
                    <td>{{$data->nomor_member}}</td>
                    <td>{{$data->bank}}</td>
                    <td>{{$data->status == 0 ? 'Pending' : 'Success'}}
                        @if ($data->status == 2)
                        'Failed'
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>

        </div>
    </div>

    <div class="content">
        <form action="/api/coba" method="post">
            <div>
                <label for="">Jumlah Topup : </label>
                <br>
                <input type="text" name="jumlah">
            </div>
            <br>
            <div>
                <select name="bank" id="">
                    <option value="bni">BNI</option>
                    <option value="bri">BRI</option>
                    <option value="bca">BCA</option>
                    <option value="mandiri">Mandiri</option>
                </select>
            </div>
            <br><br>
            <button type="submit">Topup</button>

            <br><br><br><br><br><br><br><br>
        </form>
    </div>

    <div class="content">

        Nomor Telpon lupa password anda +628999981907

        <form action="/lupa/password" method="post">

            @isset($nomor, $token)
            <input name="nomor" type="hidden" value="{{$nomor}}">
            <input name="token" type="hidden" value="{{$token}}">
            @endisset

            <br>
            <label for="">Password Baru: </label>
            <br>
            <input type="text" name="password">

            <br><br>
            <label for="">Konfirmasi Password: </label>
            <br>
            <input type="text" name="password_confirmation">

            <br><br>
            <button type="submit">Submit</button>

            @csrf
        </form>
        <br><br><br><br><br><br><br><br>
    </div>

</body>

</html>
