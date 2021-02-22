<script>
    $(function () {
        // modal
        $('a[data-toggle="modal"]').click(function (){
            let id = $(this).data('id');
            console.log(id);

            $.ajax({
                url: '/admin/produk/' + id,
                method: 'GET',
                dataType: 'JSON',
                success: function (data){
                    console.log(data);
                    $('#barcode').attr('src', data.barcode);
                    $('#nama').val(data.nama_barang);
                    $('#stok').val(data.stok);
                    $('#kategori').val(data.kategori_id);
                    $('#merek').val(data.merek_id);
                    $('#harga_beli').val(data.harga_beli);
                    $('#harga_jual').val(data.harga_jual);
                    $('#diskon').val(data.diskon);
                }
            });
        });

        // date picker
        $('input[name="datefilter"]').daterangepicker({
            autoUpdateInput: false,
            locale: {
            cancelLabel: 'Clear'
            }
        });

        $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        });

        $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        let myForm = $("#target");

        $(".applyBtn").click(function(){
            setTimeout(function () {
                myForm.submit();
            }, 10);
        });
    });
</script>
