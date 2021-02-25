<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Cetak Data Pembelian</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <div class="container p-3">
        @foreach ($pembelians as $pembelian)

        <div class="border-bottom text-center p-3">
            <h4 class="text-center"> DATA PEMBELIAN </h4>
            <small class="d-block">ID Pembelian : {{$pembelian->id}}</small>
            <small> Registrasi pada : {{$pembelian->created_at}} </small>
        </div>

        <div class="p-3">
            <table>
                <tr>
                    <td>Nama Barang </td>
                    <td class="pl-3"> : &nbsp; {{$pembelian->nama_barang}}</td>
                </tr>
                <tr>
                    <td>Nama Supplier</td>
                    <td class="pl-3"> : &nbsp; {{$pembelian->supplier->nama_supplier}}</td>
                </tr>
                <tr>
                    <td>Total Barang</td>
                    <td class="pl-3"> : &nbsp; {{$pembelian->pcs}}</td>
                </tr>
                <tr>
                    <td>Harga Satuan</td>
                    <td class="pl-3"> : &nbsp; Rp. {{number_format($pembelian->harga_satuan, '0', ',', '.')}}</td>
                </tr>
                <tr>
                    <td>Total Harga</td>
                    <td class="pl-3"> : &nbsp; Rp. {{number_format($pembelian->total_harga, '0', ',', '.')}}</td>
                </tr>
            </table>
        </div>

        @endforeach
    </div>

</body>

</html>
