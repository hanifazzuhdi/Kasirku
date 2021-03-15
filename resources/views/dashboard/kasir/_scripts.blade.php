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

        // Call toast
        function toast (icon, message){
            const Toast = Swal.mixin({
                    toast: true,
                    position: 'top',
                    showConfirmButton: false,
                    timer: 1500,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                    })

                    Toast.fire({
                    icon: icon,
                    title: message
                })

            return Toast;
        }

        // js waktu
        var renderTime = function () {
            var time = new Date();
            clock.textContent = time.toLocaleString('id-ID', {year: 'numeric', month: 'long', day: 'numeric', hour: 'numeric', minute: 'numeric', second: 'numeric'}) + ' WIB';
        };
        renderTime();

        setInterval(renderTime, 1000);

        // select 2
        $('select[name="uid"]').select2({
            placeholder: "Pilih atau cari UID produk",
            allowClear: true,
            theme: "bootstrap"
        });

        $('select#kode_member').select2({
            placeholder: "Masukkan Kode Member (Opsional)",
            allowClear: true,
            theme: "bootstrap"
        });

        // Kembalian
        $('.bayar').keyup(function () {
            let total = $('.bayar').val();
            // console.log(total);

            let tagihan = $('.tagihanHidden').val();
            // console.log(tagihan);

            $('.kembalian').val('Rp ' + new Intl.NumberFormat('id-ID').format(total - tagihan));
        });

        // Ajax Keranjang
        $('.tambah').click(function (){
            let member = $('#kode_member').val();
            let uid    = $('select[name="uid"]').val();
            let pcs    = $('input[name="pcs"]').val();

            // console.log(member + uid + pcs);

            if (uid == '' || pcs == ''){

                toast('warning', 'Isi UID dan jumlah dengan Benar !');

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
                        toast('warning', 'Stok barang tidak cukup !');

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

                    //total
                    let total = [];
                    data.forEach((v, k) => total.push(v.harga * v.pcs) );

                    $('.total').val( 'Rp ' + total.reduce((t, n) => new Intl.NumberFormat('id-ID').format(t + n) ));

                    // Diskon
                    let diskon = [];
                    data.forEach((v, k) => diskon.push(v.diskon));

                    $('.diskon').val( 'Rp ' + diskon.reduce((t,n) => new Intl.NumberFormat('id-ID').format(t + n) ));

                    // tagihan
                    var tagihan = [];
                    data.forEach((v, k) => tagihan.push(v.total_harga));

                    console.log(tagihan);

                    $('.tagihan').html('Rp ' + tagihan.reduce((t, n) => new Intl.NumberFormat('id-ID').format(t + n)));
                    $('.tagihan').val( 'Rp ' + tagihan.reduce((t, n) => new Intl.NumberFormat('id-ID').format(t + n)));

                    $('.tagihanHidden').val( tagihan.reduce((t, n) => t + n));

                },
                // Jika Error
                error: function ( xhr, errorType, exception ) {
                    var errorMessage = exception || xhr.statusText;

                    toast('error', 'Hub Administrator : ' + errorMessage );

                }
            });

            return false
        });

        // Hitung kembalian
        $('input[name="pcs"], input[name="harga_satuan"]').keyup(function(){
                var total = parseInt($('input[name="pcs"]').val()) || 0;
                var satuan = parseInt($('input[name="harga_satuan"]').val()) || 0;

                let totalHarga = parseInt(total) * parseInt(satuan);
                let res = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(totalHarga);

                // console.log(res);
                $('.total').html(res);
        });

        // Submit Transaksi Cash
        $('#transaksi').click(function (){

            let dibayar = parseInt($('.bayar').val());

            let total = parseInt($('.tagihanHidden').val());

            if (isNaN(dibayar) || dibayar < total){
                toast('warning', 'Uangnya kurang !');
                return false;
            }

            console.log($(this).data('url'));

            $.ajax({
                url: $(this).data('url'),
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    dibayar: dibayar
                },
                statusCode : {
                    404: function (){
                        toast('error', 'Data transaksi tidak ada !');
                    },
                    202: function (data){
                        Swal.fire({
                            title: 'Sukses',
                            text: "Transaksi berhasil dilakukan",
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'PRINT'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                $('.invisible form').submit();
                            } else {
                                setTimeout(function () {
                                    location.reload()
                                }, 200);
                            }
                        })
                    }
                },
            })

        });

        // Bayar Melalui Saldo
        $('#member').click(function (){

            let kode_member = $('#kode_member').val();

            if (kode_member == ''){
                toast('warning', 'Kode Member Kosong !');
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
                        toast('error', 'Data tidak ditemukan !');
                    },
                    400: function (){
                        toast('warning', 'Saldo member kurang !');
                    },
                    202: function (data){
                        Swal.fire({
                            title: 'Transaksi Sukses',
                            text: "Saldo member berhasil dikurangi",
                            icon: 'success',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'PRINT'
                            }).then((result) => {
                            if (result.isConfirmed) {
                                $('.invisible form').submit();
                            }else {
                                setTimeout(function () {
                                    location.reload()
                                }, 200);
                            }
                        })
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
                    toast('success', 'Transaksi berhasil dibatalkan');

                    setTimeout(function () {
                        location.reload()
                    }, 1000);
                }
            });
        })

        // Cari Kode member
        $('#kodeMember').click(function (){
            let keyword = $('input[name="kode_member"]').val();

            $.ajax({
                url: '/cari-member',
                method: 'POST',
                data: {
                    _token: "{{csrf_token()}}",
                    kode_member: keyword
                },statusCode: {
                    404: function (){
                        $('#detail_member').html(`
                        <div class="mt-3 p-4 text-center border">
                            <h3>Member Tidak Terdaftar !</h3>
                        </div>
                        `);
                    }
                },
                success: function (data){
                    // console.log(data)

                    $('#detail_member').html(`
                    <div class="mt-3 p-4 text-center border">
                        <h3>${data.data.kode_member}</h3>
                        <h4>An : ${data.data.nama} </h4>
                    </div>
                    `);
                }
            });
        });

        // submit topup
        $('#topup .modal-footer button[name="topup"]').click(function (){
            let kode = $('input[name="kode_member"]').val();
            let nominal = $('input[name="nominal"]').val();

            $.ajax({
                url: '/isi-saldo',
                method: 'POST',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_member: kode,
                    nominal: nominal
                },statusCode: {
                    404: function (){
                        toast('error','Member tidak ada !');
                    },
                    422: function (){
                        toast('warning', 'Isi Kode Member dan Nominal dengan benar !');
                    }
                },
                success: function (data){
                    toast('success', 'Topup Saldo Berhasil');
                }
            });
        });

        // Transaksi Belum selesai
        $('button[name="belumSelesai"]').click(function (){
            $.ajax({
                url: '/transaksi-belumselesai',
                method: 'GET',
                statusCode: {
                    404: function (){
                        toast('error', 'Keranjang Masih Kosong !');
                    }
                },
                success: function(data){
                    console.log(data);

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

                    $('.total').val( 'Rp ' + total.reduce((t, n) => new Intl.NumberFormat('id-ID').format(t + n) ));

                    // Diskon
                    let diskon = [];
                    data.forEach((v, k) => diskon.push(v.diskon));

                    $('.diskon').val( 'Rp ' + diskon.reduce((t,n) => new Intl.NumberFormat('id-ID').format(t + n) ));

                    // tagihan
                    var tagihan = [];
                    data.forEach((v, k) => tagihan.push(v.total_harga));

                    $('.tagihan').html('Rp ' + tagihan.reduce((t, n) => new Intl.NumberFormat('id-ID').format(t + n)));
                    $('.tagihan').val( 'Rp ' + tagihan.reduce((t, n) => new Intl.NumberFormat('id-ID').format(t + n)));
                    $('.tagihanHidden').val( tagihan.reduce((t, n) => t + n));

                    return false;
                }
            });
        });

    })
</script>
