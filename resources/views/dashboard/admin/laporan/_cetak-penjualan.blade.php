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
        <div class="p-3" style="border-style: none none dashed none">
            <h4 class="text-center pb-3" style="border-style: none none double none"> Kasir Mart </h4>
            <table>
                <tr>
                    <td>
                        <small>No Order </small>
                    </td>
                    <td>
                        <small> : {{$penjualan->id}} </small>
                    </td>
                </tr>
                <tr>
                    <td>
                        <small>Kasir </small>
                    </td>
                    <td>
                        <small> : {{$penjualan->kasir->nama}} </small>
                    </td>
                </tr>
                <tr>
                    <td>
                        <small>Tanggal </small>
                    </td>
                    <td>
                        <small> : {{$penjualan->created_at}} </small>
                    </td>
                </tr>
                <tr>
                    <td>
                        <small>Pembayaran </small>
                    </td>
                    <td>
                        <small> : {{$penjualan->type}} </small>
                    </td>
                </tr>
            </table>
        </div>

        <div class="mt-3 pb-3">
            <table class="container">
                @foreach ($keranjang as $item)
                <tr>
                    <td>
                        <small>{{$loop->iteration}}.</small>
                        <small>{{$item->nama_barang}}</small>
                    </td>
                </tr>
                <tr>
                    <td class="ml-3">
                        <small>{{number_format($item->harga, '0', ',', '.')}} X
                        </small>
                        <small>{{$item->pcs}}</small>
                        <small> -
                            {{number_format($item->diskon, '0', ',', '.')}} (Diskon)</small>
                    </td>
                    <td>
                        <small style="font-size: 13px">{{ number_format( $item->total_harga, '0', ',', '.')}}</small>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>

        <div class="pl-4 mt-2 py-3" style="border-style: double none double none">
            <table>
                <tr>
                    <td>
                        <small> Total </small>
                    </td>
                    <td>
                        <small> : {{number_format($penjualan->harga_total, '0', ',', '.')}}</small>
                    </td>
                </tr>
                <tr>
                    <td>
                        <small> Diskon </small>
                    </td>
                    <td>
                        <small> : {{number_format($penjualan->diskon, '0', ',', '.')}}</small>
                    </td>
                </tr>
                <tr>
                    <td>
                        <small> Bayar </small>
                    </td>
                    <td>
                        <small> : {{number_format($penjualan->dibayar, '0', ',', '.')}}</small>
                    </td>
                </tr>
                <tr>
                    <td>
                        <small> Kembalian </small>
                    </td>
                    <td>
                        <small> : {{number_format($penjualan->kembalian, '0', ',', '.')}}</small>
                    </td>
                </tr>
            </table>
        </div>

        <h5 class="text-center pt-3">Terimakasih Atas Kunjungan Anda</h5>
        <p class="text-center">Barang yang sudah dibeli tidak dapat ditukar kembali</p>

    </div>


</body>

</html>
