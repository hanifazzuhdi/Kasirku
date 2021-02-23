<!doctype html>
<html lang="en">

<head>
    <title>Laporan Transaksi Pembelian</title>
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
                <th>ID</th>
                <th>Total Harga</th>
                <th>Dibayar</th>
                <th>Kembalian</th>
                <th>Kode Member</th>
                <th>Kasir</th>
                <td>Dibuat Pada</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>Rp. {{ number_format($data->harga_total, '0', ',', '.')}}</td>
                <td>Rp. {{ number_format($data->dibayar, '0', ',', '.')}}</td>
                <td>Rp. {{ number_format($data->kembalian, '0', ',', '.')}}</td>
                <th>{{$data->kode_member}}</th>
                <th>{{$data->kasir->nama}}</th>
                <td>{{$data->created_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
