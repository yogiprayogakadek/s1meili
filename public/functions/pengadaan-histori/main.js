function getData() {
    $.ajax({
        type: "get",
        url: "/pengadaan-histori/render",
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
                    url: "/pengadaan-histori/print/",
                    dataType: "json",
                    success: function (response) {
                        document.title= 'Laporan - ' + new Date().toJSON().slice(0,10).replace(/-/g,'/')
                        $(response.data).find("div.printableArea").printArea(options);
                    }
                });
            }
        })
    });

    $('body').on('click', '.btn-validasi', function() {
        let status = $(this).data('status')
        let id = $(this).data('id')
        $('#modalValidasi').modal('show')
        $('#modalValidasi').find('#id_pengadaan').val(id)
        $('#modalValidasi').find('#status_pengadaan').val(status)
        $('#modalValidasi').find('#keterangan_grup').prop('hidden', true)
    })

    $('body').on('change', '#status_pengadaan', function() {
        $('#modalValidasi').find('#keterangan').removeClass('is-invalid')
        $('.error-keterangan').html('')
        $('#modalValidasi').find('#status_pengadaan').removeClass('is-invalid')
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
            url: "/pengadaan-histori/validasi",
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
        let status = $('#status_pengadaan').val()
        let keterangan = $('#keterangan').val()
        let id = $('#id_pengadaan').val()
        let data = {
            status: status,
            keterangan: keterangan,
            id_pengadaan: id
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
            url: "/pengadaan-histori/detail-validasi/" + id,
            dataType: "json",
            success: function (response) {
                var keterangan = ''
                var note = 'Buat pengadaan barang baru atau hubungi yang bersangkutan'
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
});