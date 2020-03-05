$(function() {
    let datatable = $("#list_transaksi_kain").DataTable({
        pageLength: 100,
        "processing": true,
        "serverSide": true,
        initComplete: function(settings, json) {
            handleButtonsClick()
        },
        ajax: {
            url: '/api/v1/transaksi_kain',
            type: 'GET',
            headers: General.getHeaders()
        },
        columns: [
            { data: 'id', visible: false },
            { 
                data: "tanggal_masuk",
                searchable: false,
                orderable: false,
                render: function(data, type, row, meta) {
                    return General.convertToMomentFormat(data)
                }
            },
            { data: "kode_kain" },
            { data: "yard" },
            { 
                data: "harga",
                searchable: false,
                orderable: false,
                render: function(data, type, row, meta) {
                    return General.rupiahFormat(data, '')
                }
            },
            { 
                data: "value",
                searchable: false,
                orderable: false,
                render: function(data, type, row, meta) {
                    return General.rupiahFormat(data, '')
                }
            },
            { 
                searchable: false,
                orderable: false,
                data: "status_potong",
                render: function(data, type, row, meta) {
                    return '<span class="badge '+ (data === 1 ? 'badge-success' : 'badge-danger') +'">'+ (data === 1 ? 'Sudah dipotong' : 'Belum dipotong') +'</span>'
                }
            },
            {
                searchable: false,
                orderable: false,
                data: null,
                className: 'text-center',
                defaultContent: '<button type="button" class="btn btn-primary btn-sm mr-2 detail"><i class="fas fa-eye"></i></button><button type="button" class="btn btn-info btn-sm mr-2"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>'
            }
        ]
    })

    $('#kode_kain').select2({
        theme: 'bootstrap4'
    })
    $('#kode_kain2').select2({
        theme: 'bootstrap4'
    })

    /* handle form tambah bahan */
    $("#form_create_bahan").submit(function(e) {
        e.preventDefault()
        const newTransaksiKain = {
            kode_kain: $("#kode_kain").find(":selected").val(),
            yard: parseInt($("#yard").val()),
            harga: General.removeRupiah($("#harga").val()),
            tanggal_masuk: General.convertToDatetimeSql($("#tanggal_masuk").val())
        }

        if (parseInt(newTransaksiKain.kode_jenis_bahan) === 0) {
            General.showToast("error", "Kode kain tidak boleh kosong!")
            return
        }
        
        axios.post('/api/v1/transaksi_kain', newTransaksiKain, {
            headers: General.getHeaders()
        })
            .then(function(res) {
                General.resetElementsField([
                    { selector: '#kode_kain', type: 'select' },
                    { selector: '#yard', type: 'text' },
                    { selector: '#harga', type: 'text' },
                    { selector: '#tanggal_masuk_picker', type: 'datetimepicker' }
                ])
                $("#modal_create_transaksi_kain").modal('toggle')
                General.showToast("success", res.data.message)
                datatable.ajax.reload()
            })
            .catch(function(err) {
                console.log(err)
            })
    })
    /* handle modal tambah transaksi_kain opened */
    $("#modal_create_transaksi_kain").on("show.bs.modal", function(e) {
        /* TODO: load jenis bahan menggunakan filter Nama atau Warna kemudian tampilkan  */
        General.resetSelect2('#kode_kain')
        General.resetDatePicker('#tanggal_masuk_picker')

        const route = "/api/v1/kain/get/kode"
        axios.get(route, {
            headers: General.getHeaders()
        })
            .then(function(response) {
                const dataKain = response.data.data
                dataKain.forEach(function(kain) {
                    const option = new Option(kain.kode, kain.kode, false, false)
                    $("#kode_kain").append(option).trigger('change')
                })
            })
            .catch(function(err) {
                console.log(err)
            })
    })
    /* handle modal tambah transaksi_kain closed */
    $('#modal_create_transaksi_kain').on('hidden.bs.modal', function(e) {
        $('#kode_kain').html('')
        $('#yard').val('')
        $('#harga').val('')
        $('#tanggal_masuk').val('')
    })
    /* handle form edit transaksi_kain */
    $("#form_edit_transaksi_kain").submit(function(e) {
        e.preventDefault()
        const editedTransaksiKain = {
            kode_kain: $("#kode_kain2").find(":selected").val(),
            yard: parseInt($("#yard2").val()),
            harga: General.removeRupiah($("#harga2").val()),
            tanggal_masuk: General.convertToDatetimeSql($("#tanggal_masuk2").val())
        }

        if (parseInt(editedTransaksiKain.kode_kain) === 0) {
            General.showToast("error", "Kode jenis bahan tidak boleh kosong!")
            return
        }

        const id = $('#id2').val()
        const route = `/api/v1/transaksi_kain/${id}/edit`
        
        axios.post(route, editedTransaksiKain, {
            headers: General.getHeaders()
        })
            .then(function(res) {
                General.resetElementsField([
                    { selector: '#kode_kain2', type: 'select' },
                    { selector: '#yard2', type: 'text' },
                    { selector: '#harga2', type: 'text' },
                    { selector: '#tanggal_masuk_picker2', type: 'datetimepicker' }
                ])
                $("#modal_edit_transaksi_kain").modal('toggle')
                General.showToast("success", res.data.message)
                datatable.ajax.reload()
            })
            .catch(function(err) {
                console.log(err)
            })
    })
    /* handle modal edit transaksi_kain */
    $("#modal_edit_transaksi_kain").on("show.bs.modal", function(e) {
        /* TODO: load jenis bahan menggunakan filter Nama atau Warna kemudian tampilkan  */
        // General.resetSelect2('#kode_kain2')
        // General.resetDatePicker('#tanggal_masuk_picker2')

        // const url = "/api/v1/kain/get/kode"
        // axios.get(url, {
        //     headers: General.getHeaders()
        // })
        //     .then(function(response) {
        //         const dataKain = response.data.data
        //         dataKain.forEach(function(kain) {
        //             const option = new Option(kain.kode, kain.kode, false, false)
        //             $("#kode_kain2").append(option).trigger('change')
        //         })
        //     })
        //     .catch(function(err) {
        //         console.log(err)
        //     })
    })
    /* handle modal tambah transaksi_kain closed */
    $('#modal_edit_transaksi_kain').on('hidden.bs.modal', function(e) {
        $('#kode_kain2').html('')
        $('#yard2').html('')
        $('#harga2').html('')
        $('#tanggal_masuk2').val('')
    })
    /* handle row buttonclick */
    function handleButtonsClick() {
        /* handle tombol show */
        $('#list_transaksi_kain tbody').on('click', 'tr button.btn.detail', function (e) {
            const tr = $(this).closest('tr')
            const row = datatable.row(tr)

            if (row.child.isShown()) {
                row.child.hide()
                tr.find('button.detail').removeClass('btn-warning').addClass('btn-primary')
            } else {
                const id = datatable.row($(this).parent().parent()).data().id
                const url = `/api/v1/transaksi_kain/${id}/detail`

                axios.get(url, {
                    headers: General.getHeaders()
                })
                    .then(function(res) {
                        const data = res.data.data
                        row.child(renderDetail(data)).show()
                        tr.find('button.detail').removeClass('btn-primary').addClass('btn-warning')
                    })
                    .catch(function(err) {
                        console.log('Error : ', error.response.data)
                    })
            }
        })
        /* handle tombol edit */
        $('#list_transaksi_kain tbody').on('click', 'tr button.btn-info', function(e) {
            const id = datatable.row($(this).parent().parent()).data().id

            General.resetSelect2('#kode_kain2')
            General.resetDatePicker('#tanggal_masuk_picker2')

            axios.get("/api/v1/kain/get/kode", {
                headers: General.getHeaders()
            })
                .then(function(response) {
                    const dataKain = response.data.data
                    dataKain.forEach(function(kain) {
                        const option = new Option(kain.kode, kain.kode, false, false)
                        $("#kode_kain2").append(option).trigger('change')
                    })

                    axios.get(`/api/v1/transaksi_kain/${id}/detail`, {
                        headers: General.getHeaders()
                    })
                        .then(function(response) {
                            $('#id2').val(response.data.data.id)
                            setTimeout(function() {
                                $("#kode_kain2").val(`${response.data.data.kode_kain}`).trigger('change')
                            }, 250)
                            $("#yard2").val(response.data.data.yard)
                            $("#harga2").val(General.rupiahFormat(response.data.data.harga, ''))
                            $("#tanggal_masuk_picker2").find('input').val(moment(new Date(response.data.data.tanggal_masuk)).format('DD/MM/YYYY HH.mm'))
                            $("#modal_edit_transaksi_kain").modal('toggle')
        
                        })
                        .catch(function(err) {
                            console.log(err)
                        })
                })
                .catch(function(err) {
                    console.log(err)
                })
        })
        /* handle tombol hapus */
        $('#list_transaksi_kain tbody').on('click', 'tr button.btn-danger', function(e) {
            let result = confirm('Anda yakin ingin dihapus?')
            if (result) {
                const id = datatable.row($(this).parent().parent()).data().id
                const url = window.location.origin + `/api/v1/transaksi_kain/${id}/remove`
                
                axios.post(url, null, {
                    headers: General.getHeaders()
                })
                    .then(function(res) {
                        General.showToast('success', res.data.message)
                        datatable.ajax.reload()
                    })
                    .catch(function(err) {
                        console.log(err)
                        General.showToast('error', err.message)
                    })
            }
        })
    }

    function renderDetail(transaksiKain) {
        return `<div class="row">
            <div class="col-md-12">
                <h4>Detail Kain</h4>
                <hr />
                <dl class="row">
                    <dt class="col-sm-4">Tanggal Masuk</dt>
                        <dd class="col-sm-8">${transaksiKain.tanggal_masuk}</dd>
                    <dt class="col-sm-4">Kode Kain</dt>
                        <dd class="col-sm-8">${transaksiKain.kode_kain}</dd>
                    <dt class="col-sm-4">Yard</dt>
                        <dd class="col-sm-8">${transaksiKain.yard}</dd>
                    <dt class="col-sm-4">Harga</dt>
                        <dd class="col-sm-8">${General.rupiahFormat(transaksiKain.harga, '')}</dd>
                    <dt class="col-sm-4">Value</dt>
                        <dd class="col-sm-8">${General.rupiahFormat(transaksiKain.value, '')}</dd>
                    <dt class="col-sm-4">Status Potong</dt>
                        <dd class="col-sm-8"><span class="badge ${transaksiKain.value === true ? 'badge-success' : 'badge-danger'}">${transaksiKain.value === true ? 'Sudah dipotong' : 'Belum dipotong'}</span></dd>
                    <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">${transaksiKain.created_at}</dd>
                    <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">${transaksiKain.updated_at}</dd>
                </dl>
            </div>
        </div>`
    }
})