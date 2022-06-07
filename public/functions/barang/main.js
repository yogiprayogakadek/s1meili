function getData() {
    $.ajax({
        type: "get",
        url: "/barang/render",
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
        url: "/barang/create",
        dataType: "json",
        success: function (response) {
            $(".render").html(response.data);
        },
        error: function (error) {
            console.log("Error", error);
        },
    });
}


$(document).ready(function () {
    getData();

    $('body').on('click', '.btn-add', function () {
        tambah();
    });

    $('body').on('click', '.btn-data', function () {
        getData();
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
            url: "/barang/store",
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
                if (error.status == 422) {
                    if (error.responseJSON.errors) {
                        if (error.responseJSON.errors.nama) {
                            $('#nama').addClass('is-invalid')
                            $('#nama').trigger('focus')
                            $('.error-nama').html(error.responseJSON.errors.nama)
                        } else {
                            $('#nama').removeClass('is-invalid')
                            $('.error-nama').html('')
                        }
                        if (error.responseJSON.errors.kode) {
                            $('#kode').addClass('is-invalid')
                            $('#kode').trigger('focus')
                            $('.error-kode').html(error.responseJSON.errors.kode)
                        } else {
                            $('#kode').removeClass('is-invalid')
                            $('.error-kode').html('')
                        }
                        if (error.responseJSON.errors.merek) {
                            $('#merek').addClass('is-invalid')
                            $('#merek').trigger('focus')
                            $('.error-merek').html(error.responseJSON.errors.merek)
                        } else {
                            $('#merek').removeClass('is-invalid')
                            $('.error-merek').html('')
                        }
                        if (error.responseJSON.errors.spesifikasi) {
                            $('#spesifikasi').addClass('is-invalid')
                            $('#spesifikasi').trigger('focus')
                            $('.error-spesifikasi').html(error.responseJSON.errors.spesifikasi)
                        } else {
                            $('#spesifikasi').removeClass('is-invalid')
                            $('.error-spesifikasi').html('')
                        }
                        // if (error.responseJSON.errors.tahun) {
                        //     $('#tahun').addClass('is-invalid')
                        //     $('#tahun').trigger('focus')
                        //     $('.error-tahun').html(error.responseJSON.errors.tahun)
                        // } else {
                        //     $('#tahun').removeClass('is-invalid')
                        //     $('.error-tahun').html('')
                        // }
                        // if (error.responseJSON.errors.total) {
                        //     $('#total').addClass('is-invalid')
                        //     $('#total').trigger('focus')
                        //     $('.error-total').html(error.responseJSON.errors.total)
                        // } else {
                        //     $('#total').removeClass('is-invalid')
                        //     $('.error-total').html('')
                        // }
                        // if (error.responseJSON.errors.jumlah_rusak) {
                        //     $('#jumlah-rusak').addClass('is-invalid')
                        //     $('#jumlah-rusak').trigger('focus')
                        //     $('.error-jumlah-rusak').html(error.responseJSON.errors.jumlah_rusak)
                        // } else {
                        //     $('#jumlah-rusak').removeClass('is-invalid')
                        //     $('.error-jumlah-rusak').html('')
                        // }
                    }
                }
            }
        });
    });

    $('body').on('click', '.btn-edit', function () {
        let id = $(this).data('id')
        $.ajax({
            type: "get",
            url: "/barang/edit/" + id,
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
            url: "/barang/update",
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
                if (error.status == 422) {
                    if (error.responseJSON.errors) {
                        if (error.responseJSON.errors.nama) {
                            $('#nama').addClass('is-invalid')
                            $('#nama').trigger('focus')
                            $('.error-nama').html(error.responseJSON.errors.nama)
                        } else {
                            $('#nama').removeClass('is-invalid')
                            $('.error-nama').html('')
                        }
                        if (error.responseJSON.errors.kode) {
                            $('#kode').addClass('is-invalid')
                            $('#kode').trigger('focus')
                            $('.error-kode').html(error.responseJSON.errors.kode)
                        } else {
                            $('#kode').removeClass('is-invalid')
                            $('.error-kode').html('')
                        }
                        if (error.responseJSON.errors.merek) {
                            $('#merek').addClass('is-invalid')
                            $('#merek').trigger('focus')
                            $('.error-merek').html(error.responseJSON.errors.merek)
                        } else {
                            $('#merek').removeClass('is-invalid')
                            $('.error-merek').html('')
                        }
                        if (error.responseJSON.errors.spesifikasi) {
                            $('#spesifikasi').addClass('is-invalid')
                            $('#spesifikasi').trigger('focus')
                            $('.error-spesifikasi').html(error.responseJSON.errors.spesifikasi)
                        } else {
                            $('#spesifikasi').removeClass('is-invalid')
                            $('.error-spesifikasi').html('')
                        }
                        // if (error.responseJSON.errors.tahun) {
                        //     $('#tahun').addClass('is-invalid')
                        //     $('#tahun').trigger('focus')
                        //     $('.error-tahun').html(error.responseJSON.errors.tahun)
                        // } else {
                        //     $('#tahun').removeClass('is-invalid')
                        //     $('.error-tahun').html('')
                        // }
                        // if (error.responseJSON.errors.total) {
                        //     $('#total').addClass('is-invalid')
                        //     $('#total').trigger('focus')
                        //     $('.error-total').html(error.responseJSON.errors.total)
                        // } else {
                        //     $('#total').removeClass('is-invalid')
                        //     $('.error-total').html('')
                        // }
                        // if (error.responseJSON.errors.jumlah_rusak) {
                        //     $('#jumlah-rusak').addClass('is-invalid')
                        //     $('#jumlah-rusak').trigger('focus')
                        //     $('.error-jumlah-rusak').html(error.responseJSON.errors.jumlah_rusak)
                        // } else {
                        //     $('#jumlah-rusak').removeClass('is-invalid')
                        //     $('.error-jumlah-rusak').html('')
                        // }
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
                    url: "/barang/delete/" + id,
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
                    url: "/barang/print/",
                    dataType: "json",
                    success: function (response) {
                        document.title= 'Laporan - ' + new Date().toJSON().slice(0,10).replace(/-/g,'/')
                        $(response.data).find("div.printableArea").printArea(options);
                    }
                });
            }
        })
    });
});