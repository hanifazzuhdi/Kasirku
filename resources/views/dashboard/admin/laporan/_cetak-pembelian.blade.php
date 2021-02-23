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
                <th>Supplier</th>
                <th>Nama Barang</th>
                <th>Total</th>
                <th>Harga Satuan</th>
                <th>Total Harga</th>
                <th>Data Dibuat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr>
                <td>{{$data->id}}</td>
                <td>{{$data->supplier->nama_supplier}}</td>
                <td>{{$data->barang}}</td>
                <td>{{$data->total_barang}}</td>
                <td>Rp. {{ number_format($data->harga_satuan, '0', ',', '.')}}</td>
                <td>Rp. {{ number_format($data->total_harga, '0', ',', '.')}}</td>
                <td>{{$data->created_at}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>
