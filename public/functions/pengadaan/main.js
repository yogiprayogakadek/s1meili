function getData() {
    $.ajax({
        type: "get",
        url: "/pengadaan/render",
        dataType: "json",
        success: function (response) {
            $(".render").html(response.data);
        },
        error: function (error) {
            console.log("Error", error);
        },
    });
}

function tambah() {
    $.ajax({
        type: "get",
        url: "/pengadaan/create",
        dataType: "json",
        success: function (response) {
            $(".render").html(response.data);
        },
        error: function (error) {
            console.log("Error", error);
        },
    });
}

// convert to rupiah
var rupiah = $("#biaya");
function convertToRupiah(number, prefix) {
    var number_string = number.replace(/[^,\d]/g, "").toString(),
        split = number_string.split(","),
        remaining = split[0].length % 3,
        rupiah = split[0].substr(0, remaining),
        thousand = split[0].substr(remaining).match(/\d{3}/gi);

    if (thousand) {
        separator = remaining ? "." : "";
        rupiah += separator + thousand.join(".");
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
}

$(document).ready(function () {
    getData();
    var i = 0;

    $('body').on('click', '.btn-add', function () {
        tambah();
    });

    $('body').on('click', '.btn-data', function () {
        i = 0;
        getData();
    });

    $("body").on("keyup", '#biaya', function (e) {
        $("#biaya").val(convertToRupiah($(this).val(), "Rp. "))
    });

    $("body").on("keyup", '.harga-satuan', function (e) {
        var id_harga = $(this).data("harga");
        $("#"+ id_harga).val(convertToRupiah($(this).val(), "Rp. "))
    });

    $('body').on('click', '.btn-add-item', function(){
        i++;

        var html = '<div class="card">' +
            '<div class="card-header">' +
                '<h5 class="card-title">Item Barang</h5>' +
                '<div class="card-options">' +
                    '<button class="btn btn-danger btn-delete-item"><i class="fa fa-trash"></i> Hapus</button>' +
                '</div>' +
            '</div>' +
            '<div class="card-body">' +
                // '<div class="form-group">' +
                //     '<label>Kode Barang</label>' +
                //     '<input type="text" class="form-control kode'+i+'" name="kode['+i+']" id="kode'+i+'" placeholder="masukkan kode barang">' +
                //     '<div class="invalid-feedback error-kode'+i+'"></div>' +
                // '</div>' +
                '<div class="form-group">' +
                    '<label>Nama Barang</label>' +
                    '<input type="text" class="form-control nama'+i+'" name="nama['+i+']" id="nama'+i+'" placeholder="masukkan nama barang">' +
                    '<div class="invalid-feedback error-nama'+i+'"></div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label>Merek Barang</label>' +
                    '<input type="text" class="form-control merek'+i+'" name="merek['+i+']" id="merek'+i+'" placeholder="masukkan merek barang">' +
                    '<div class="invalid-feedback error-merek'+i+'"></div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label>Spesifikasi Barang</label>' +
                    '<textarea class="form-control spesifikasi'+i+'" name="spesifikasi['+i+']" id="spesifikasi'+i+'" placeholder="masukkan spesifikasi barang"></textarea>' +
                    '<div class="invalid-feedback error-spesifikasi'+i+'"></div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label>Jumlah Barang</label>' +
                    '<input type="number" class="form-control jumlah'+i+'" name="jumlah['+i+']" id="jumlah'+i+'" placeholder="masukkan jumlah barang">' +
                    '<div class="invalid-feedback error-jumlah'+i+'"></div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label>Harga Satuan</label>' +
                    '<input type="text" class="form-control harga-satuan harga'+i+'" name="harga['+i+']" id="harga'+i+'" data-harga="harga'+i+'" placeholder="masukkan harga satuan">' +
                    '<div class="invalid-feedback error-harga'+i+'"></div>' +
                '</div>' +
            '</div>' +
        '</div>';

        $('#item-barang').append(html);
    })

    $('body').on('click', '.btn-delete-item', function(){
        $(this).closest('.card').remove();
    });

    // on save button
    $('body').on('click', '.btn-save', function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        // $('.invalid-feedback').html('');
        // $('body').find('.is-invalid').removeClass('is-invalid');
        let form = $('#formAdd')[0]
        let data = new FormData(form)
        $.ajax({
            type: "POST",
            url: "/pengadaan/store",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                $('.btn-save').attr('disable', 'disabled')
                $('.btn-save').html('<i class="fa fa-spin fa-spinner"></i>')
            },
            complete: function () {
                $('.btn-save').removeAttr('disable')
                $('.btn-save').html('Simpan')
            },
            success: function (response) {
                $('#formAdd').trigger('reset')
                $(".invalid-feedback").html('')
                getData();
                Swal.fire(
                    response.title,
                    response.message,
                    response.status
                );
            },
            error: function (error) {
                let formName = []
                let errorName = []
                $.each($('#formAdd').serializeArray(), function (i, field) {
                    // formName.push((field.name.replace(/\[\d+\]/g, '')).replace('.', ''))
                    formName.push(field.name.replace(/\[|\]/g, ''))
                });
                // console.log(formName)
                if (error.status == 422) {
                    if (error.responseJSON.errors) {
                        $.each(error.responseJSON.errors, function (key, value) {
                            errorName.push(key.replace('.', ''))
                            if($('.'+key.replace('.', '')).val() == '') {
                                $('.'+key.replace('.', '')).addClass('is-invalid');
                                $('.error-'+key.replace('.', '')).html(value);
                            }
                        });
                        $.each(formName, function (i, field) {
                            // if(!errorName.includes(field)) {
                            //     $('.'+field).removeClass('is-invalid');
                            //     $('.error-'+field).html('');
                            // }
                            $.inArray(field, errorName) == -1 ? $('.'+field).removeClass('is-invalid') : $('.'+field).addClass('is-invalid');
                        });
                    }
                    // console.log(errorName);
                }
            }
        });
    });

    $('body').on('click', '.btn-edit', function () {
        let id = $(this).data('id')
        $.ajax({
            type: "get",
            url: "/pengadaan/edit/" + id,
            dataType: "json",
            success: function (response) {
                $(".render").html(response.data);
            },
            error: function (error) {
                console.log("Error", error);
            },
        });
    });

    // on update button
    $('body').on('click', '.btn-update', function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        let form = $('#formEdit')[0]
        let data = new FormData(form)
        $.ajax({
            type: "POST",
            url: "/pengadaan/update",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function () {
                $('.btn-update').attr('disable', 'disabled')
                $('.btn-update').html('<i class="fa fa-spin fa-spinner"></i>')
            },
            complete: function () {
                $('.btn-update').removeAttr('disable')
                $('.btn-update').html('Simpan')
            },
            success: function (response) {
                $('#formEdit').trigger('reset')
                $(".invalid-feedback").html('')
                getData();
                Swal.fire(
                    response.title,
                    response.message,
                    response.status
                );
            },
            error: function (error) {
                let formName = []
                let errorName = []
                $.each($('#formEdit').serializeArray(), function (i, field) {
                    // formName.push((field.name.replace(/\[\d+\]/g, '')).replace('.', ''))
                    formName.push(field.name.replace(/\[|\]/g, ''))
                });
                // console.log(formName)
                if (error.status == 422) {
                    if (error.responseJSON.errors) {
                        $.each(error.responseJSON.errors, function (key, value) {
                            errorName.push(key.replace('.', ''))
                            if($('.'+key.replace('.', '')).val() == '') {
                                $('.'+key.replace('.', '')).addClass('is-invalid');
                                $('.error-'+key.replace('.', '')).html(value);
                            }
                        });
                        $.each(formName, function (i, field) {
                            // if(!errorName.includes(field)) {
                            //     $('.'+field).removeClass('is-invalid');
                            //     $('.error-'+field).html('');
                            // }
                            $.inArray(field, errorName) == -1 ? $('.'+field).removeClass('is-invalid') : $('.'+field).addClass('is-invalid');
                        });
                    }
                    // console.log(errorName);
                }
            }
        });
    });

    $('body').on('click', '.btn-delete', function () {
        let id = $(this).data('id')
        Swal.fire({
            title: 'Apakah anda yakin?',
            text: "Data yang sudah dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "get",
                    url: "/pengadaan/delete/" + id,
                    dataType: "json",
                    success: function (response) {
                        $(".render").html(response.data);
                        getData();
                        Swal.fire(
                            response.title,
                            response.message,
                            response.status
                        );
                    },
                    error: function (error) {
                        console.log("Error", error);
                    },
                });
            }
        })
    });

    $('body').on('click', '.btn-print', function () {
        Swal.fire({
            title: 'Cetak data kategori?',
            text: "Laporan akan dicetak",
            icon: 'success',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, cetak!'
        }).then((result) => {
            if (result.value) {
                var mode = "iframe"; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close,
                    popTitle: 'Sarpras',
                };
                $.ajax({
                    type: "GET",
                    url: "/pengadaan/print/",
                    dataType: "json",
                    success: function (response) {
                        document.title= 'Laporan - ' + new Date().toJSON().slice(0,10).replace(/-/g,'/')
                        $(response.data).find("div.printableArea").printArea(options);
                    }
                });
            }
        })
    });

    $('body').on('click', '#tableData td:first-child', function () {
        var id_pengadaan = $(this).data('id')
        var table = $('#tableData').DataTable();
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        var keterangan = $(this).data('keterangan');
        var pemohon = $(this).data('pemohon');
        var jabatan_pemohon = $(this).data('jabatan');
        if (row.child.isShown()) {
            // This row is already open - close it.
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open row.

            var row_div = '<div class="row">' +
                '<div class="col-md-2">' +
                    'Nama Pemohon' +
                '</div>' +
                '<div class="col-md-10">' +
                    pemohon +
                '</div>' +
                '<div class="col-md-2 mt-2">' +
                    'Jabatan Pemohon' +
                '</div>' +
                '<div class="col-md-10 mt-2">' +
                    jabatan_pemohon +
                '</div>' +
                '<div class="col-md-2 mt-2">' +
                    'Keterangan' +
                '</div>' +
                '<div class="col-md-10 mt-2">' +
                    keterangan +
                '</div>' +

                '<div class="col-md-12 mt-2 text-center">' +
                    '<h4><strong>Detail Item Pengadaan</strong></h4>' +
                '</div>' +
                
                '<table class="table table-stripped table-hover mt-2" id="tableItem">' +
                    '<thead>' +
                    '<tr>' +
                        '<th>No</th>' +
                        '<th>Nama Barang</th>' +
                        '<th>Harga Satuan Barang</th>' +
                        '<th>Jumlah Barang</th>' +
                        '<th>Total Harga</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody id="item'+id_pengadaan+'">' +
                    '</tbody>' +
                '</table>';
            '</div>';
            $.get('/pengadaan/item-pengadaan/'+id_pengadaan, function(data) {
                $.each(data, function(i, item) {
                    var tr_row = '<tr>' +
                        '<td>' + (i+1) + '</td>' +
                        '<td>' + item.nama_barang + '</td>' +
                        '<td>' + item.harga_satuan + '</td>' +
                        '<td>' + item.jumlah_barang + '</td>' +
                        '<td>' + item.total + '</td>' +
                    '</tr>';
                    $('#item'+id_pengadaan).append(tr_row);
                });
                // $('#tableItem tbody').html(data);
            })
            row.child(row_div).show();
            tr.addClass('shown');
        }
    });
});