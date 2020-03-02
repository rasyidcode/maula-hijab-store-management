$(function() {
    let datatable = $("#list_kain").DataTable({
        "processing": true,
        "serverSide": true,
        initComplete: function(settings, json) {
            handleButtonsClick()
        },
        ajax: '/api/v1/kain',
        columns: [
            { data: "kode" },
            { data: "nama" },
            { data: "warna" },
            { 
                data: "created_at",
                render: function(data, type, row, meta) {
                    return General.convertToMomentFormat(data)
                }
            },
            {
                data: null,
                searchable: false,
                orderable: false,
                className: 'text-center',
                defaultContent: '<button type="button" class="btn btn-primary btn-sm mr-2 detail"><i class="fas fa-eye"></i></button><button type="button" class="btn btn-info btn-sm mr-2"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>'
            }
        ]
    })

    /* handle form tambah kain */
    $("#form_create_kain").submit(function(e) {
        e.preventDefault()

        const kode = General.spaceRemover($("#nama").val()) + "-" + General.spaceRemover($("#warna").val())
        const newKain = {
            kode: kode,
            nama: $("#nama").val(),
            warna: $("#warna").val(),
        }
        axios.post('/api/v1/kain', newKain)
            .then(function(res) {
                General.resetElementsField([
                    { selector: '#nama', type: 'text' },
                    { selector: '#warna', type: 'text' },
                ])
                $("#modal_create_kain").modal('toggle')
                General.showToast("success", res.data.message)
                datatable.ajax.reload()
            })
            .catch(function(error) {
                if (error.response.status == 422) {
                    General.showToast("error", error.response.data.errors.kode[0])
                } else {
                    General.showToast('error', 'Unknown error, call the dev.')
                }
            })
    })

    /* handle form edit jenis_bahan */
    $("#form_edit_kain").submit(function(e) {
        e.preventDefault()

        const kode = General.spaceRemover($("#nama2").val()) + "-" + General.spaceRemover($("#warna2").val())
        const editedKain = {
            kode: kode,
            nama: $("#nama2").val(),
            warna: $("#warna2").val(),
        }
        const prevKode = $("#kode2").val()

        axios.post(`/api/v1/kain/${prevKode}/edit`, editedKain)
            .then(function(res) {
                General.resetElementsField([
                    { selector: '#nama2', type: 'text' },
                    { selector: '#warna2', type: 'text' },
                ])
                $("#modal_edit_kain").modal('toggle')
                General.showToast("success", res.data.message)
                datatable.ajax.reload()
            })
            .catch(function(err) {
                General.showToast("error", err.message)
            })
    })

    function handleButtonsClick() {
        $("#list_kain tbody").on("click", "tr button.btn.detail", function () {
            const tr = $(this).closest('tr')
            const row = datatable.row(tr)

            if (row.child.isShown()) {
                row.child.hide()
                tr.find('button.detail').removeClass('btn-warning').addClass('btn-primary')
            } else {
                const kode = datatable.row($(this).parent().parent()).data().kode
                const url =`/api/v1/kain/${kode}/detail`

                axios.get(url)
                    .then(function(res) {
                        const data = res.data.data
                        row.child(renderDetail(data)).show()
                        tr.find('button.detail').removeClass('btn-primary').addClass('btn-warning')
                    })
                    .catch(function(err) {
                        console.log('Error : ', error.response.data)
                    })
            }

            // refaktor to show inline table data detail
            // axios.get(url)
            //     .then(function(res) {
                    
            //         $("#dt_kode").html(res.data.data.kode)
            //         $("#dt_nama").html(res.data.data.nama)
            //         $("#dt_warna").html(res.data.data.warna)
            //         $("#dt_created_at").html(General.convertToReadableFormat(res.data.data.created_at))
            //         $("#dt_updated_at").html(General.convertToReadableFormat(res.data.data.updated_at))
            //         $("#dt_used_count").html(res.data.data.bahan.length > 0 ? `Digunakan oleh <a href="#">${res.data.data.bahan.length} bahan</a>` : "Belum ada bahan yang pakai.")
            //         $("#modal_show_jenis_bahan").modal('toggle')
            //     })
            //     .catch(function(err) {
            //         console.log(err)
            //     })
        });

        $("#list_kain tbody").on("click", "tr button.btn-info", function() {
            const kode = datatable.row($(this).parent().parent()).data().kode

            axios.get(`/api/v1/kain/${kode}`)
                .then(function(res) {
                    $("#kode2").val(res.data.data.kode)
                    $("#nama2").val(res.data.data.nama)
                    $("#warna2").val(res.data.data.warna)
                    $("#modal_edit_kain").modal('toggle')
                })
                .catch(function(err) {
                    console.log(err)
                })
        })

        $("#list_kain tbody").on("click", "tr button.btn-danger", function() {
            let result = confirm("Anda yakin ingin dihapus?")
            if (result) {
                const kode = datatable.row($(this).parent().parent()).data().kode
                
                axios.post(`/api/v1/kain/${kode}/remove`)
                    .then(function(res) {
                        General.showToast("success", res.data.message)
                        datatable.ajax.reload()
                    })
                    .catch(function(err) {
                        console.log(err)
                        General.showToast("error", err.message)
                    })
            }
        })
    }

    function renderDetail(kain) {
        return `<div class="row">
            <div class="col-md-12">
                <h4>Detail Kain</h4>
                <hr />
                <dl class="row">
                    <dt class="col-sm-4">Kode</dt>
                        <dd class="col-sm-8">${kain.kode}</dd>
                    <dt class="col-sm-4">Nama Kain</dt>
                        <dd class="col-sm-8">${kain.nama}</dd>
                    <dt class="col-sm-4">Warna Kain</dt>
                        <dd class="col-sm-8">${kain.warna}</dd>
                    <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">${kain.created_at}</dd>
                    <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">${kain.updated_at}</dd>
                    <dt class="col-sm-4">Jumlah Barang</dt>
                        <dd class="col-sm-8">-</dd> <!-- TODO: menampilkan berapa jumlah barang yang menggunakan kode ini -->
                    <dt class="col-sm-4">Jumlah Transaksi Kain</dt>
                        <dd class="col-sm-8">-</dd> <!-- TODO: menampilkan berapa jumlah transaksi_kain yang menggunakan kode ini -->
                </dl>
            </div>
        </div>`
    }
})