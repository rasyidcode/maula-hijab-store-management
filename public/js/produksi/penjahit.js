$(function() {
    const helpers = {}
    const callbacks = {
        /* create penjahit */
        formCreatePenjahit: function(e) {
            e.preventDefault()
            const newPenjahit = {
                no_ktp: $("#no_ktp").val(),
                nama_lengkap: $("#nama_lengkap").val(),
                no_hp: $("#no_hp").val(),
                alamat: $("#alamat").val()
            }
    
            axios.post('/api/v1/penjahit', newPenjahit)
                .then(function(res) {
                    General.resetElementsField([
                        { selector: '#no_ktp', type: 'text' },
                        { selector: '#nama_lengkap', type: 'text' },
                        { selector: '#no_hp', type: 'text' },
                        { selector: '#alamat', type: 'text' }
                    ])
                    $("#modal_create_penjahit").modal('toggle')
                    General.showToast("success", res.data.message)
                    datatable.ajax.reload()
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        /* edit penjahit */
        formEditPenjahit: function(e) {
            e.preventDefault()
            
            const editedPenjahit = {
                no_ktp: $("#no_ktp2").val(),
                nama_lengkap: $("#nama_lengkap2").val(),
                no_hp: $("#no_hp2").val(),
                alamat: $("#alamat2").val()
            }

            const noKtpBeforeEdit = $("#before_edit_noktp").val()

            axios.post(`/api/v1/penjahit/${noKtpBeforeEdit}/edit`, editedPenjahit)
                .then(function(res) {
                    General.resetElementsField([
                        { selector: '#no_ktp2', type: 'text' },
                        { selector: '#nama_lengkap2', type: 'text' },
                        { selector: '#no_hp2', type: 'text' },
                        { selector: '#alamat2', type: 'text' }
                    ])
                    $('#modal_edit_penjahit').modal('toggle')
                    General.showToast("success", res.data.message)
                    datatable.ajax.reload()
                })
                .catch(function(err) {
                    console.log(err)
                })
        }
    }
    const datatableColumns = [
        { data: "no_ktp" },
        { data: "nama_lengkap" },
        { data: "no_hp" },
        { data: "alamat" },
        {
            searchable: false,
            orderable: false,
            data: "created_at",
            render: function(data, type, row, meta) {
                return General.convertToMomentFormat(data)
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
    const datatableConfig = {
        processing: true,
        serverSide: true,
        initComplete: function(settings, json) {
            handleButtonsClick()
        },
        ajax: '/api/v1/penjahit/get/datatable',
        columns: datatableColumns
    }


    let datatable = $("#list_penjahit").DataTable(datatableConfig)

    $("#form_create_penjahit").submit(callbacks.formCreatePenjahit)
    $("#form_edit_penjahit").submit(callbacks.formEditPenjahit)
    $("input[type='seach'].form-control").css("width", "300px");

    function handleButtonsClick() {
        $("#list_penjahit tbody").on("click", "tr button.btn.detail", function(e) {
            const tr = $(this).closest('tr')
            const row = datatable.row(tr)

            if (row.child.isShown()) {
                row.child.hide()
                tr.find('button.detail').removeClass('btn-warning').addClass('btn-primary')
            } else {
                const noKtp = datatable.row($(this).parent().parent()).data().no_ktp
                const url =`/api/v1/penjahit/${noKtp}`

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
        })

        $("#list_penjahit tbody").on("click", "tr button.btn-info", function(e) {
            const noKtp = datatable.row($(this).parent().parent()).data().no_ktp

            axios.get(`/api/v1/penjahit/${noKtp}`)
                .then(function(res) {
                    $("#before_edit_noktp").val(res.data.data.no_ktp)
                    $("#no_ktp2").val(res.data.data.no_ktp)
                    $("#nama_lengkap2").val(res.data.data.nama_lengkap)
                    $("#no_hp2").val(res.data.data.no_hp)
                    $("#alamat2").val(res.data.data.alamat)
                    $("#modal_edit_penjahit").modal('toggle')
                })
                .catch(function(err) {
                    console.log(err)
                })
        })

        $("#list_penjahit tbody").on("click", "tr button.btn-danger", function() {
            let result = confirm("Anda yakin ingin dihapus?")
            if (result) {
                const noKtp = datatable.row($(this).parent().parent()).data().no_ktp
                
                axios.post(`/api/v1/penjahit/${noKtp}/remove`)
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

    function renderDetail(penjahit) {
        return `<div class="row">
            <div class="col-md-12">
                <h4>Detail Penjahit</h4>
                <hr />
                <dl class="row">
                    <dt class="col-sm-4">No. KTP</dt>
                        <dd class="col-sm-8">${penjahit.no_ktp}</dd>
                    <dt class="col-sm-4">Nama Lengkap</dt>
                        <dd class="col-sm-8">${penjahit.nama_lengkap}</dd>
                    <dt class="col-sm-4">No. HP</dt>
                        <dd class="col-sm-8">${penjahit.no_hp}</dd>
                    <dt class="col-sm-4">Alamat</dt>
                        <dd class="col-sm-8">${penjahit.alamat}</dd>
                    <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">${penjahit.created_at}</dd>
                    <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">${penjahit.updated_at}</dd>
                </dl>
            </div>
        </div>`

        /**
         * next version
         * <dt class="col-sm-4">Total Jahitan</dt>
            <dd class="col-sm-8">${penjahit.total_wos}</dd>
        <dt class="col-sm-4">Jahitan Minggu Ini</dt>
            <dd class="col-sm-8">${penjahit.active_wos}</dd>
        <dt class="col-sm-4">Total Dibayar</dt>
            <dd class="col-sm-8">${penjahit.total_paid}</dd>
         */
    }
})