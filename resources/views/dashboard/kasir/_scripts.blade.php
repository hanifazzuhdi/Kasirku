<script type="text/javascript">
    // Load Modal
    $(window).on('load', function() {
            $('#myModal').modal('show');
    });

    // Full Screen
    var elem = document.documentElement;
    function openFullscreen() {
        if (elem.requestFullscreen) {
            elem.requestFullscreen();
        } else if (elem.webkitRequestFullscreen) {
            elem.webkitRequestFullscreen();
        } else if (elem.msRequestFullscreen) {
            elem.msRequestFullscreen();
        }
    }

    $(function () {
        // select 2
        $('select[name="uid"]').select2({
            placeholder: "Pilih atau cari UID produk",
            allowClear: true,
            theme: "bootstrap"
        });

        // Kembalian
        $('.bayar').keyup(function () {
            let total = $('.bayar').val();
            // console.log(total);

            let tagihan = $('.tagihanHidden').val();
            // console.log(tagihan);

            $('.kembalian').val( 'Rp. ' + new Intl.NumberFormat('id-ID').format(total - tagihan));
        });

        // Ajax Keranjang
        $('.tambah').click(function (){
            let member = $('#kode_member').val();
            let uid    = $('select[name="uid"]').val();
            let pcs    = $('input[name="pcs"]').val();

            // console.log(member + uid + pcs);

            if (uid == '' || pcs == ''){
                alert('Isi UID dan PCS Dengan Benar !');

                return false;
            }

            $.ajax({
                url: '/tambah/keranjang',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    uid: uid,
                    pcs: pcs,
                    kode_member: member
                },
                success: function(data){
                    if (data == ''){
                        alert ('Stok Barang Tidak Cukup');

                        return false;
                    }

                    // console.log(data);

                    function tableTemplate(datas) {
                        return `
                            <tr>
                                <td>${datas.uid}</td>
                                <td>${datas.nama_barang}</td>
                                <td>${datas.pcs}</td>
                                <td>${datas.harga}</td>
                                <td>${datas.diskon}</td>
                                <td>${datas.total_harga}</td>
                                <td> <a href='/hapus/keranjang/${datas.id}' class="material-icons keranjang">
                                        delete
                                     </a>
                                </td>
                            </tr>
                        `;
                    }

                    $('#bodyTable').html(
                        `
                        ${data.map(tableTemplate).join("")}
                        `
                    );

                    // Isi ketempat masing masing

                    //total
                    let total = [];
                    data.forEach((v, k) => total.push(v.harga * v.pcs) );

                    $('.total').val( 'Rp. ' + total.reduce((t, n) => new Intl.NumberFormat('id-ID').format(t + n) ));

                    // Diskon
                    let diskon = [];
                    data.forEach((v, k) => diskon.push(v.diskon));

                    $('.diskon').val( 'Rp. ' + diskon.reduce((t,n) => new Intl.NumberFormat('id-ID').format(t + n) ));

                    // tagihan
                    var tagihan = [];
                    data.forEach((v, k) => tagihan.push(v.total_harga));

                    $('.tagihan').html('Rp. ' + tagihan.reduce((t, n) => new Intl.NumberFormat('id-ID').format(t + n)));
                    $('.tagihan').val( 'Rp. ' + tagihan.reduce((t, n) => new Intl.NumberFormat('id-ID').format(t + n)));
                    $('.tagihanHidden').val( tagihan.reduce((t, n) => t + n));

                },
                // Jika Error
                error: function ( xhr, errorType, exception ) {
                    var errorMessage = exception || xhr.statusText;

                    alert( "Hub Administrator : " + errorMessage );
                }
            });



            $('input[name="pcs"], input[name="harga_satuan"]').keyup(function(){
                var total = parseInt($('input[name="pcs"]').val()) || 0;
                var satuan = parseInt($('input[name="harga_satuan"]').val()) || 0;

                let totalHarga = parseInt(total) * parseInt(satuan);
                let res = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalHarga);

                console.log(res);
                $('.total').html(res);
            });

            return false

        });

        // Submit Transaksi Cash
        $('#transaksi').click(function (){

            let dibayar = parseInt($('.bayar').val());

            let total = parseInt($('.tagihanHidden').val());
            if (isNaN(dibayar) || dibayar < total){
                alert ('Uangnya Kurang !');
                return false;
            }

            $.ajax({
                url: $(this).data('url'),
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    dibayar: dibayar
                },
                statusCode : {
                    404: function (){
                        alert('Data Transaksi tidak ada');
                    },
                    202: function (data){
                        console.log(data);
                        alert (data.message);
                        location.reload();
                    }
                },
            })

        });

        // Bayar Melalui Saldo
        $('#member').click(function (){

            let kode_member = $('#kode_member').val();

            if (kode_member == ''){
                alert('Kode Member Kosong');
                return false
            }

            $.ajax({
                url: $(this).data('url'),
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_member: kode_member
                },
                statusCode: {
                    404: function (){
                        alert('Data tidak ditemukan');
                    },
                    400: function (){
                        alert('Saldo Member Kurang');
                    },
                    202: function (data){
                        alert(data.message + '. Saldo member dikurangi');
                        location.reload();
                    }
                },
            });

        });

        // Cancel Transaksi
        $('#cancel').click(function (){
            $.ajax({
                url: $(this).data('url'),
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function (data){
                    alert(data.message);
                    location.reload();
                }
            });
        })

    })
</script>
