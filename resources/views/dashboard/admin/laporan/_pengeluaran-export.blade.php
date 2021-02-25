<!doctype html>
<html lang="en">

<head>
    <title>Laporan Pemasukan Bulanan</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Pengeluaran</th>
                <th>Total Pemasukan</th>
                <th>Jenis Pengeluaran</th>
                <td>Dibuat Pada</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$data->nama_pengeluaran}}</td>
                <td>Rp. {{ number_format($data->harga_total, '0', ',', '.')}}</td>
                <td>{{$data->jenis}}</td>
                <td>{{$data->created_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
