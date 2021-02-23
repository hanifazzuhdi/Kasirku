<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Cetak Data penjualan</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>

    <div class="container">
        <div class="border-bottom p-3">
            <h2 class="text-center pb-3"> Kasir Mart </h2>
            <table class="m-auto">
                <tr>
                    <td class="mr-3">
                        <small class="d-block" style="font-size: 13px">ID Pembelian : {{$penjualan->id}}</small>
                        <small style="font-size: 13px"> Tgl : {{$penjualan->created_at}} </small>
                    </td>
                    <td>
                        <small class="d-block" style="font-size: 13px"> Kasir : {{$penjualan->kasir->nama}}</small>
                        <small style="font-size: 13px"> Kode Member : {{$penjualan->kode_member}}</small>
                    </td>
                </tr>
            </table>
        </div>

        <div class="border-bottom mt-3 pb-3">
            <table class="container ">
                @foreach ($keranjang as $item)
                <tr>
                    <td>
                        <small style="font-size: 15px">{{$loop->iteration}}.</small>
                        <small style="font-size: 15px">{{$item->nama_barang}}</small>
                    </td>
                </tr>
                <tr>
                    <td class="ml-3">
                        <small style="font-size: 15px">{{number_format($item->harga, '0', ',', '.')}} X
                        </small>
                        <small style="font-size: 15px">{{$item->pcs}}</small>
                        <small style="font-size: 15px"> -
                            {{number_format($item->diskon, '0', ',', '.')}}</small>
                    </td>
                    <td>
                        <small style="font-size: 13px">{{ number_format( $item->total_harga, '0', ',', '.')}}</small>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        <div class="text-right pr-4 mt-3">
            <small class="d-block mb-1" style="font-size: 15px"> Total :
                {{number_format($penjualan->harga_total, '0', ',', '.')}} </small>
            <small class="d-block mb-1" style="font-size: 15px"> Bayar :
                {{number_format($penjualan->bayar, '0', ',', '.')}}
            </small>
            <small class="d-block mb-1" style="font-size: 15px"> Kembalian :
                {{number_format($penjualan->kembalian, '0', ',', '.')}} </small>
        </div>

    </div>


</body>

</html>
