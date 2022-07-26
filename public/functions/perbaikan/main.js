function getData() {
    $.ajax({
        type: "get",
        url: "/perbaikan/render",
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
        url: "/perbaikan/create",
        dataType: "json",
        success: function (response) {
            $(".render").html(response.data);
        },
        error: function (error) {
            console.log("Error", error);
        },
    });
}

function filterData(start_date, end_date, status) {
    $.ajax({
        type: "get",
        url: "/perbaikan/filter/"+start_date+"/"+end_date+"/"+status,
        dataType: "json",
        success: function (response) {
            $(".render").html(response.data);
            $('#start_date').val(start_date);
            $('#end_date').val(end_date);
            $('#status').val(status);
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

function toRupiah(angka) {
    var rupiah = '';
    var angkarev = angka.toString().split('').reverse().join('');
    for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
    return 'Rp'+rupiah.split('',rupiah.length-1).reverse().join('');
}

$(document).ready(function () {
    getData();
    var i = 0;
    
    // function findData() {
    //     return $('body').find('.test') == undefined ? 0 : $('body').find('.test').length
    // }
    // var test = findData();

    $('body').on('click', '.btn-add', function () {
        tambah();
    });

    $("body").on("keyup", '#biaya', function (e) {
        $("#biaya").val(convertToRupiah($(this).val(), "Rp. "))
    });

    $('body').on('click', '.btn-data', function () {
        i = 0;
        getData();
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
                //     '<label>Nama Barang</label>' +
                //     '<input type="text" class="form-control nama'+i+'" name="nama['+i+']" id="nama'+i+'" placeholder="masukkan nama barang">' +
                //     '<div class="invalid-feedback error-nama'+i+'"></div>' +
                // '</div>' +
                '<div class="form-group">' +
                        '<label>Nama Barang</label>' +
                        '<select name="nama['+i+']" id="nama'+i+'" class="form-control nama'+i+' nama-barang" data-id="'+i+'">' +
                        // '<select class="form-control nama'+i+' nama-barang" name="nama['+i+']" id="nama'+i+'">' +
                            
                        '</select>' +
                        '<div class="invalid-feedback error-nama'+i+'"></div>' +
                    '</div>' +
                '<div class="form-group">' +
                    '<label>Spesifikasi Barang</label>' +
                    '<textarea class="form-control spesifikasi'+i+'" name="spesifikasi['+i+']" id="spesifikasi'+i+'" readonly></textarea>' +
                    '<div class="invalid-feedback error-spesifikasi'+i+'"></div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label>Uraian Kerusakan Barang</label>' +
                    '<textarea class="form-control uraian'+i+'" name="uraian['+i+']" id="uraian'+i+'" placeholder="masukkan uraian perbaikan barang"></textarea>' +
                    '<div class="invalid-feedback error-uraian'+i+'"></div>' +
                '</div>' +
                '<div class="form-group">' +
                    '<label>Keterangan Perbaikan</label>' +
                    '<textarea class="form-control keterangan'+i+'" name="keterangan['+i+']" id="keterangan'+i+'" placeholder="masukkan keterangan perbaikan barang"></textarea>' +
                    '<div class="invalid-feedback error-keterangan'+i+'"></div>' +
                '</div>' +
            '</div>' +
        '</div>';

        $.get("/barang/data-barang", function(response){
            $.each(response, function(key, value){
                $("#nama"+i).append('<option value="'+key+'">'+value+'</option>');
            });
        });

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
        let form = $('#formAdd')[0]
        let data = new FormData(form)
        $.ajax({
            type: "POST",
            url: "/perbaikan/store",
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
                    formName.push(field.name.replace(/\[|\]/g, ''))
                });
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
            url: "/perbaikan/edit/" + id,
            dataType: "json",
            success: function (response) {
                $(".render").html(response.data);
                i = $('body').find('.test') == undefined ? 0 : $('body').find('.test').length-1
                console.log(i)
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
            url: "/perbaikan/update",
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
                            $.inArray(field, errorName) == -1 ? $('.'+field).removeClass('is-invalid') : $('.'+field).addClass('is-invalid');
                        });
                    }
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
                    url: "/perbaikan/delete/" + id,
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
            title: 'Cetak data perbaikan?',
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
                    url: "/perbaikan/print/"+$('#start_date').val()+"/"+$('#end_date').val()+"/"+$('#status').val(),
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
        var id_maintenance = $(this).data('id')
        var status = $(this).data('status')
        // alert(status)
        var table = $('#tableData').DataTable();
        var tr = $(this).closest('tr');
        var row = table.row( tr );
        var pemohon = $(this).data('pemohon');
        var jabatan_pemohon = $(this).data('jabatan');
        if (row.child.isShown()) {
            // This row is already open - close it.
            row.child.hide();
            tr.removeClass('shown');
        } else {
            // Open row.

            var row_div = '<div class="row">' +
            '<div class="col-md-6">' +
                '<div class="row">' +
                    '<div class="col-md-4">' +
                        'Nama Pemohon' +
                    '</div>' +
                    '<div class="col-md-8">' +
                        ': ' + pemohon +
                    '</div>' +
                    '<div class="col-md-4 mt-2">' +
                        'Jabatan Pemohon' +
                    '</div>' +
                    '<div class="col-md-8 mt-2">' +
                        ': ' + jabatan_pemohon +
                    '</div>' +
                '</div>' +
            '</div>' +
            '<div class="col-md-6">' +
                '<div class="row">' +
                    '<div class="col-md-4"></div>' +
                    '<div class="col-md-8 div-btn-penerimaan"></div>' +
                    '<div class="col-md-4">' +
                        'Tanggal Penyelesaian' +
                    '</div>' +
                    '<div class="col-md-8 tanggal-penerimaan'+id_maintenance+'">: ' +
                        '-' +
                    '</div>' +
                    '<div class="col-md-4">' +
                        'Biaya Perbaikan' +
                    '</div>' +
                    '<div class="col-md-8 nama-penerima'+id_maintenance+'">: ' +
                        '-' +
                    '</div>' +
                    '<div class="col-md-4">' +
                        'Uraian Kerusakan' +
                    '</div>' +
                    '<div class="col-md-8 uraian-perbaikan'+id_maintenance+'">: ' +
                        '-' +
                    '</div>' +
                '</div>' +
            '</div>' +
                
            '<div class="col-md-12 mt-2 text-center">' +
                '<h4><strong>Detail Item Perbaikan</strong></h4>' +
            '</div>' +
            '<table class="table table-stripped table-hover mt-2" id="tableItem">' +
                '<thead>' +
                '<tr>' +
                    '<th>No</th>' +
                    '<th>Nama Barang</th>' +
                    '<th>Spesifikasi</th>' +
                    '<th>Uraian Perbaikan</th>' +
                    '<th>Keterangan</th>' +
                '</tr>' +
                '</thead>' +
                '<tbody id="item'+id_maintenance+'">' +
                '</tbody>' +
            '</table>';
            '</div>';
            $.get('/perbaikan/item-perbaikan/'+id_maintenance, function(data) {
                $('.div-btn-penerimaan').html("<button type=button class='btn btn-primary btn-sm btn-edit-penerima' data-id='"+id_maintenance+"' data-status='"+status+"'>Edit</button>");
                $('.nama-penerima'+id_maintenance).html(": " + (data.biaya_perbaikan != 'Belum diterima' ? toRupiah(data.biaya_perbaikan) : 'Belum diterima'));
                $('.tanggal-penerimaan'+id_maintenance).html(": " + data.tanggal_penyelesaian);
                $('.uraian-perbaikan'+id_maintenance).html(": " + data.uraian_perbaikan);
                data.user_login != 'Staf Administrasi' ? $('.btn-edit-penerima').hide() : $('.btn-edit-penerima').show();
                $.each(data.data, function(i, item) {
                    var tr_row = '<tr>' +
                        '<td>' + (i+1) + '</td>' +
                        '<td>' + item.nama_barang + '</td>' +
                        '<td>' + item.spesifikasi_barang + '</td>' +
                        '<td>' + item.uraian + '</td>' +
                        '<td>' + item.keterangan + '</td>' +
                    '</tr>';
                    $('#item'+id_maintenance).append(tr_row);
                });
                // $('#tableItem tbody').html(data);
            })
            row.child(row_div).show();
            tr.addClass('shown');
        }
    });

    $('body').on('click', '.btn-edit-penerima', function(){
        var id = $(this).data('id');
        var status = $(this).data('status');
        $('#modalPenerimaan').find('#id_maintenance').val(id);
        if(status != 'Diterima'){
            Swal.fire({
                title: 'Peringatan',
                text: 'Perbaikan ini belum divalidasi, tidak dapat mengubah penerimaan',
                icon: 'warning',
            })
        } else {
            $('#modalPenerimaan').modal('show');
        }
    });

    $('body').on('click', '.btn-proses-penerimaan', function(){
        var id = $('#modalPenerimaan').find('#id_maintenance').val();
        var tanggal = $('#modalPenerimaan').find('#tanggal_penerimaan').val();
        var uraian = $('#modalPenerimaan').find('#uraian_perbaikan').val();
        // console.log(id);
        // if(penerima == '' || tanggal == ''){
        //     $('#modalPenerimaan').modal('hide');
        //     Swal.fire({
        //         title: 'Peringatan',
        //         text: 'Mohon untuk melengkapi data penerimaan',
        //         icon: 'warning',
        //     })
        // } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/perbaikan/proses-penerimaan',
                type: 'POST',
                data: {
                    id_maintenance: id,
                    // id_pegawai: penerima,
                    // penerima: penerima,
                    biaya: $('#modalPenerimaan').find('#biaya').val(),
                    tanggal: tanggal,
                    uraian: uraian
                },
                success: function(data){
                    getData()
                    $('#modalPenerimaan').modal('hide');
                    Swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: data.status,
                    });
                },
                error: function(data){
                    console.log(data);
                    // $('#modalPenerimaan').modal('hide');
                    // Swal.fire({
                    //     title: 'Peringatan',
                    //     text: 'Terjadi kesalahan',
                    //     icon: 'warning',
                    // });
                }
            });
        // }
    });

    $('body').on('click', '.btn-validasi', function() {
        let status = $(this).data('status')
        let id = $(this).data('id')
        let validasi = $(this).data('validasi')
        if(validasi == '') {
            Swal.fire({
                title: 'Info',
                text: "Data ini belum divalidasi oleh wakil sarpras",
                icon: 'info',
            })
        } else {
            $('#modalValidasi').modal('show')
            $('#modalValidasi').find('#id_maintenance').val(id)
            $('#modalValidasi').find('#status_perbaikan').val(status)
            $('#modalValidasi').find('#keterangan_grup').prop('hidden', true)
        }
    })

    $('body').on('change', '#status_perbaikan', function() {
        $('#modalValidasi').find('#keterangan').removeClass('is-invalid')
        $('.error-keterangan').html('')
        $('#modalValidasi').find('#status_perbaikan').removeClass('is-invalid')
        $('.error-status').html('')
        let status = $(this).val()
        if(status != 'Ditolak') {
            $('#modalValidasi').find('#keterangan_grup').prop('hidden', true)
            $('#keterangan').val('')
        } else{
            $('#modalValidasi').find('#keterangan_grup').prop('hidden', false)
        }
    });

    function validasi(data = {}) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: "/perbaikan/validasi",
            data: data,
            beforeSend: function () {
                $('.btn-proses-validasi').attr('disable', 'disabled')
                $('.btn-proses-validasi').html('<i class="fa fa-spin fa-spinner"></i>')
            },
            complete: function () {
                $('.btn-proses-validasi').removeAttr('disable')
                $('.btn-proses-validasi').html('Validasi')
            },
            success: function (response) {
                $('#modalValidasi').modal('hide')
                $(".invalid-feedback").html('')
                getData();
                Swal.fire(
                    response.title,
                    response.message,
                    response.status
                );
            },
            error: function (error) {
                console.log("Error", error);
            }
        });
    }

    $('body').on('click', '.btn-proses-validasi', function() {
        let status = $('#status_perbaikan').val()
        let keterangan = $('#keterangan').val()
        let id = $('#modalValidasi').find('#id_maintenance').val()
        // alert(id)
        let data = {
            status: status,
            keterangan: keterangan,
            id_maintenance: id
        }

        if(status == 'Ditolak') {
            if(keterangan == '') {
                $('#modalValidasi').find('#keterangan').addClass('is-invalid')
                $('.error-keterangan').html('Keterangan harus diisi')
                $('#modalValidasi').find('#keterangan').trigger('focus')
                return false
            } else {
                $('#modalValidasi').find('#keterangan').removeClass('is-invalid')
                $('.error-keterangan').html('')
                $('#modalValidasi').find('#keterangan').trigger('focus')
                validasi(data)
            }
        } else if(status == '') {
            $('#modalValidasi').find('#status_pengadaan').addClass('is-invalid')
            $('.error-status').html('Status harus diisi')
            $('#modalValidasi').find('#status_pengadaan').trigger('focus')
            return false
        } else {
            $('#modalValidasi').find('#status_pengadaan').removeClass('is-invalid')
            $('.error-status').html('')
            $('#modalValidasi').find('#keterangan').removeClass('is-invalid')
            $('.error-keterangan').html('')

            validasi(data)
        }
    });

    $('body').on('click', '.btn-detail-validasi', function() {
        let id = $(this).data('id')
        $('#modalStatusValidasi').find('#tableValidasi tbody').empty()
        $('#modalStatusValidasi').find('#tableValidasi tfoot').empty()
        $.ajax({
            type: "GET",
            url: "/perbaikan/detail-validasi/" + id,
            dataType: "json",
            success: function (response) {
                var keterangan = ''
                var note = 'Buat perbaikan barang baru atau hubungi yang bersangkutan'
                $('#modalStatusValidasi').modal('show')
                if(response.approve_kepala_sekolah == null && response.approve_wakil_sarpras == null) {
                    keterangan = 'Belum ada validasi'
                } else if(response.approve_kepala_sekolah == 'Ditolak' && response.approve_wakil_sarpras == 'Ditolak') {
                    keterangan = 'Ditolak'
                } else if(response.approve_kepala_sekolah == 'Ditolak' && response.approve_wakil_sarpras == 'Diterima') {
                    keterangan = 'Ditolak oleh Kepala Sekolah' + '<br>' + note
                } else if(response.approve_kepala_sekolah == 'Diterima' && response.approve_wakil_sarpras == 'Ditolak') {
                    keterangan = 'Ditolak oleh Wakil Sarpras' + '<br>' + note
                } else if(response.approve_kepala_sekolah == 'Ditolak' && response.approve_wakil_sarpras == 'Diproses') {
                    keterangan = 'Ditolak oleh Kepala Sekolah' + '<br>' + note
                } else if(response.approve_kepala_sekolah == 'Diterima' && response.approve_wakil_sarpras == 'Diproses') {
                    keterangan = 'Menunggu validasi oleh Wakil Sarpras'
                } else if(response.approve_kepala_sekolah == 'Diproses' && response.approve_wakil_sarpras == 'Ditolak') {
                    keterangan = 'Ditolak oleh Wakil Sarpras' + '<br>' + note
                } else if(response.approve_wakil_sarpras == 'Diproses' && response.approve_kepala_sekolah == 'Diterima') {
                    keterangan = 'Menunggu validasi oleh Kepala Sekolah'
                } else if(response.approve_wakil_sarpras == 'Diproses' && response.approve_kepala_sekolah == 'Ditolak') {
                    keterangan = 'Ditolak oleh Kepala Sekolah' + '<br>' + note
                } else if(response.approve_kepala_sekolah == 'Diterima' && response.approve_wakil_sarpras == 'Diterima') {
                    keterangan = 'Diterima'
                } else if(response.approve_kepala_sekolah == null) {
                    keterangan = 'Kepala Sekolah belum melakukan validasi'
                } else if(response.approve_wakil_sarpras == null) {
                    keterangan = 'Wakil Sarpras belum melakukan validasi'
                } else if(response.approve_kepala_sekolah == 'Diproses' && response.approve_wakil_sarpras == 'Diproses') {
                    keterangan = 'Diproses'
                } else if(response.approve_kepala_sekolah == 'Diproses' && response.approve_wakil_sarpras == 'Diterima') {
                    keterangan = 'Menunggu validasi oleh Kepala Sekolah'
                } else if(response.approve_kepala_sekolah == 'Diterima' && response.approve_wakil_sarpras == 'Diproses') {
                    keterangan = 'Menunggu validasi oleh Wakil Sarpras'
                } else {
                    keterangan = 'Belum ada validasi'
                }
                var tbody = '<tr>' +
                        '<td>' + (response.approve_kepala_sekolah != null ? response.approve_kepala_sekolah : '-') + '</td>' +
                        '<td>' + (response.tanggal_approve_kepala_sekolah != null ? response.tanggal_approve_kepala_sekolah : '-') + '</td>' +
                        '<td>' + (response.approve_wakil_sarpras != null ? response.approve_wakil_sarpras : '-') + '</td>' +
                        '<td>' + (response.tanggal_approve_wakil_sarpras != null ? response.tanggal_approve_wakil_sarpras : '-') + '</td>' +
                        '<td>' + (response.keterangan == null ? keterangan : response.keterangan) + '</td>' +
                    '</tr>';

                var tfoot = '<tr>' +
                        '<td colspan=3 class=text-end>Status Terakhir</td>' +
                        '<td>' + keterangan + '</td>' +
                        // '<td colspan=4>' + (response.keterangan == null ? keterangan : response.keterangan) + '</td>' +
                    '</tr>';

                $('#modalStatusValidasi').find('#tableValidasi tbody').append(tbody)
                $('#modalStatusValidasi').find('#tableValidasi tfoot').append(tfoot)
            }
        });
    });

    function swalNota(id) {
        Swal.fire({
            title: 'Nota',
            icon: 'info',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Unggah',
            cancelButtonText: 'Batal',
            showLoaderOnConfirm: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            reverseButtons: true,
            input: 'file',
            onBeforeOpen: () => {
                $('.swal2-file').change(function(){
                    var reader = new FileReader();
                    reader.readAsDataURL(this.files[0]);
                })
            },
            inputAttributes: {
                'accept': 'image/*',
                'aria-label': 'Upload Nota'
            },
            inputValidator: (value) => {
                return !value && 'Nota tidak boleh kosong'
            }
        }).then((result) => {
            if (result.value) {
                var formData = new FormData();
                var file = $('.swal2-file')[0].files[0];
                formData.append('id_maintenance', id);
                formData.append('nota', file);
                formData.append('_token', $('meta[name="csrf-token"]').attr('content'));
                $.ajax({
                    url: '/perbaikan/unggah-nota',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    cache: false,
                    success: function (response) {
                        getData();
                        Swal.fire(
                            response.title,
                            response.message,
                            response.status
                        );
                    },
                    error: function (error) {
                        console.log("Error", error);
                    }
                });
            }
        });
    }

    $('body').on('click', '.btn-nota', function () {
        var id = $(this).data('id');
        $('#modalDetailNota').modal('hide');``
        swalNota(id);
    })

    $('body').on('click', '.btn-detail-nota', function () {
        var id = $(this).data('id');

        var image = '<h4><strong>Detail Nota</strong></h4>';
        image += '<img src="' + $(this).data('nota') + '" class="img-fluid" alt="Responsive image">';

        $('#modalDetailNota').modal('show');
        $('#modalDetailNota').find('.detail-nota').html(image);
        $('#modalDetailNota').find('.btn-nota').attr('data-id', id);
    }); 

    $('body').on('change', '.nama-barang', function () {
        let div_id = $(this).data('id');
        let id_barang = $(this).val();
        console.log(div_id);
        if(id_barang != '') {
            $.get('/barang/get-detail-barang/' + id_barang, function (response) {
                console.log(response);
                // $('#merek' + div_id).val(response.merek);
                $('#spesifikasi' + div_id).val(response.merek);
                // $.each(array, function (index, value) {
                //     $('#' + value + div_id).val(response[value])
                // }
            })
        } else {
            // $('#merek' + div_id).val('');
            $('#spesifikasi' + div_id).val('');
            // $('#' + div_id).html('');
        }
    })

    $('body').on('click', '.btn-batal', function(){
        var id = $(this).data('id');
        var status = $(this).data('status');
        $('#modalPembatalan').find('#id_maintenance').val(id);
        $('#modalPembatalan').modal('show');
    });

    $('body').on('click', '.btn-proses-pembatalan', function(){
        var id = $('#id_maintenance').val();
        var pegawai = $('#id_pegawai').val();
        var tanggal = $('#tanggal_pembatalan').val();
        var keterangan = $('#keterangan').val();
        if(pegawai == '' || tanggal == '' || keterangan == '') {s
            $('#modalPembatalan').modal('hide');
            Swal.fire({
                title: 'Peringatan',
                text: 'Mohon untuk melengkapi data penerimaan',
                icon: 'warning',
            })
        } else {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/perbaikan/proses-pembatalan',
                type: 'POST',
                data: {
                    id_maintenance: id,
                    id_pegawai: pegawai,
                    tanggal: tanggal,
                    keterangan: keterangan,
                },
                success: function(data){
                    getData()
                    $('#modalPembatalan').modal('hide');
                    Swal.fire({
                        title: data.title,
                        text: data.message,
                        icon: data.status,
                    });
                },
                error: function(data){
                    $('#modalPembatalan').modal('hide');
                    Swal.fire({
                        title: 'Peringatan',
                        text: 'Terjadi kesalahan',
                        icon: 'warning',
                    });
                }
            });
        }
    });

    $('body').on('click', '.btn-detail-pembatalan', function() {
        let id = $(this).data('id')
        $('#modalStatusPembatalan').find('#tablePembatalan tbody').empty()
        $('#modalStatusPembatalan').modal('show')
        $.ajax({
            type: "GET",
            url: "/perbaikan/detail-pembatalan/" + id,
            dataType: "json",
            success: function (response) {
                var tbody = '<tr>' +
                        '<td>' + response.nama_pembatal + '</td>' +
                        '<td>' + response.tanggal_pembatalan + '</td>' +
                        '<td>' + response.keterangan + '</td>' +
                    '</tr>';
                $('#modalStatusPembatalan').find('#tablePembatalan tbody').append(tbody)            }
        });
    });

    $('body').on('click', '#btn-search', function(){
        let start_date = $('#start_date').val();
        let end_date = $('#end_date').val();
        let status = $('#status').val();

        filterData(start_date, end_date, status);
    })

    $('body').on('click', '#btn-refresh', function(){
        getData();
    })
});