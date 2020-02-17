$(function() {
    const routeListJenisBahan = "/api/jenis/bahan"
    const routeList = window.location.origin + "/api/bahan"
    const routeCreate = window.location.origin + "/api/bahan"
    let dataJenisBahan = null
    let dataJenisBahan2 = null
    let datatable = $("#list_bahan").DataTable({
        initComplete: function(settings, json) {
            handleButtonsClick()
        },
        ajax: function(data, callback, settings) {
            axios.get(routeList)
                .then(function(res) {
                    const allBahan = []
                    res.data.data.forEach(function(bahan, index) {
                        const modelBahan = new ModelBahan(
                            bahan.id,
                            bahan.kode_jenis_bahan,
                            bahan.harga,
                            bahan.yard,
                            bahan.tanggal_masuk,
                            bahan.value,
                            bahan.status_potong,
                            bahan.created_at,
                            bahan.updated_at
                        )
                        modelBahan.setNumbering(index + 1)
                        allBahan.push(modelBahan.getUIData())
                    })
                    const dataBahan = {
                        data: allBahan
                    }
                    callback(dataBahan)
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        columns: [
            { data: 'id', visible: false },
            { data: "no" },
            { data: "tanggal_masuk" },
            { data: "kodejb" },
            { data: "yard" },
            { data: "harga" },
            { data: "value" },
            { 
                data: "status",
                render: function(data, type, row, meta) {
                    return '<span class="badge '+ (data === true ? 'badge-success' : 'badge-danger') +'">'+ (data === true ? 'Sudah dipotong' : 'Belum dipotong') +'</span>'
                }
            },
            {
                data: null,
                className: 'text-center',
                defaultContent: '<button type="button" class="btn btn-primary btn-sm mr-2"><i class="fas fa-eye"></i></button><button type="button" class="btn btn-info btn-sm mr-2"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>'
            }
        ]
    })

    $('#kode_jenis_bahan').select2({
        theme: 'bootstrap4'
    })
    $('#kode_jenis_bahan2').select2({
        theme: 'bootstrap4'
    })

    /* handle form tambah bahan */
    $("#form_create_bahan").submit(function(e) {
        e.preventDefault()
        const newBahan = {
            kode_jenis_bahan: $("#kode_jenis_bahan").find(":selected").val(),
            yard: parseInt($("#yard").val()),
            harga: General.removeRupiah($("#harga").val()),
            tanggal_masuk: General.convertToDatetimeSql($("#tanggal_masuk").val())
        }
        if (parseInt(newBahan.kode_jenis_bahan) === 0) {
            General.showToast("error", "Kode jenis bahan tidak boleh kosong!")
            return
        }
        
        axios.post(routeCreate, newBahan)
            .then(function(res) {
                General.resetElementsField([
                    { selector: '#kode_jenis_bahan', type: 'select' },
                    { selector: '#yard', type: 'text' },
                    { selector: '#harga', type: 'text' },
                    { selector: '#tanggal_masuk_picker', type: 'datetimepicker' }
                ])
                $("#modal_create_bahan").modal('toggle')
                General.showToast("success", res.data.message)
                datatable.ajax.reload()
            })
            .catch(function(err) {
                console.log(err)
            })
    })
    /* handle modal tambah bahan */
    $("#modal_create_bahan").on("show.bs.modal", function(e) {
        /* TODO: load jenis bahan menggunakan filter Nama atau Warna kemudian tampilkan  */
        if (dataJenisBahan === null) {
            const route = "/api/jenis/bahan"
            axios.get(route)
                .then(function(response) {
                    dataJenisBahan = response.data.data
                    dataJenisBahan.forEach(function(jenisb) {
                        const option = $("<option>")
                        option.val(jenisb.kode)
                        option.html(jenisb.kode)
                        $("#kode_jenis_bahan").append(option)
                    })
                })
                .catch(function(err) {
                    console.log(err)
                })
        }
    })
    /* handle form edit bahan */
    $("#form_edit_bahan").submit(function(e) {
        e.preventDefault()
        const editedBahan = {
            kode_jenis_bahan: $("#kode_jenis_bahan2").find(":selected").val(),
            yard: parseInt($("#yard2").val()),
            harga: General.removeRupiah($("#harga2").val()),
            tanggal_masuk: General.convertToDatetimeSql($("#tanggal_masuk2").val())
        }
        if (parseInt(editedBahan.kode_jenis_bahan) === 0) {
            General.showToast("error", "Kode jenis bahan tidak boleh kosong!")
            return
        }
        const id = $('#id2').val()
        const route = `/api/bahan/${id}/edit`
        
        axios.post(route, editedBahan)
            .then(function(res) {
                General.resetElementsField([
                    { selector: '#kode_jenis_bahan2', type: 'select' },
                    { selector: '#yard2', type: 'text' },
                    { selector: '#harga2', type: 'text' },
                    { selector: '#tanggal_masuk_picker2', type: 'datetimepicker' }
                ])
                $("#modal_edit_bahan").modal('toggle')
                General.showToast("success", res.data.message)
                datatable.ajax.reload()
            })
            .catch(function(err) {
                console.log(err)
            })
    })
    /* handle modal edit bahan */
    $("#modal_edit_bahan").on("show.bs.modal", function(e) {
        /* TODO: load jenis bahan menggunakan filter Nama atau Warna kemudian tampilkan  */
        if (dataJenisBahan2 === null) {
            const route = "/api/jenis/bahan"
            axios.get(route)
                .then(function(response) {
                    dataJenisBahan2 = response.data.data
                    dataJenisBahan2.forEach(function(jenisb) {
                        const option = $("<option>")
                        option.val(jenisb.kode)
                        option.html(jenisb.kode)
                        $("#kode_jenis_bahan2").append(option)
                    })
                })
                .catch(function(err) {
                    console.log(err)
                })
        }
    })
    /* handle row buttonclick */
    function handleButtonsClick() {
        /* handle tombol show */
        $('#list_bahan tbody').on('click', 'tr button.btn-primary', function (e) {
            const id = datatable.row($(this).parent().parent()).data().id
            const url = window.location.origin + `/api/bahan/${id}`

            axios.get(url)
                .then(function(res) {
                    moment.locale('id')
                    $("#dt_tanggal_masuk").html(General.convertToMomentFormat(res.data.data.tanggal_masuk))
                    $("#dt_kode").html(res.data.data.kode_jenis_bahan)
                    $("#dt_yard").html(res.data.data.yard)
                    $("#dt_harga").html(General.rupiahFormat(res.data.data.harga, ''))
                    $("#dt_value").html(General.rupiahFormat(res.data.data.value, ''))
                    $("#dt_status_potong").html(res.data.data.status_potong === 1 ? 'Sudah dipotong' : 'Belum dipotong')
                    $("#dt_created_at").html(General.convertToMomentFormat(res.data.data.created_at))
                    $("#dt_updated_at").html(General.convertToMomentFormat(res.data.data.updated_at))
                    $("#modal_show_bahan").modal('toggle')
                })
                .catch(function(err) {
                    console.log(err)
                })
        })
        /* handle tombol edit */
        $('#list_bahan tbody').on('click', 'tr button.btn-info', function(e) {
            const id = datatable.row($(this).parent().parent()).data().id
            const url = window.location.origin + `/api/bahan/${id}`

            axios.get(url)
                .then(function(response) {
                    $('#id2').val(response.data.data.id)
                    setTimeout(function() {
                        $("#kode_jenis_bahan2").val(`${response.data.data.kode_jenis_bahan}`).trigger('change')
                    }, 250)
                    $("#yard2").val(response.data.data.yard)
                    $("#harga2").val(General.rupiahFormat(response.data.data.harga, ''))
                    $("#tanggal_masuk_picker2").find('input').val(moment(new Date(response.data.data.tanggal_masuk)).format('DD/MM/YYYY HH.mm'))
                    $("#modal_edit_bahan").modal('toggle')

                })
                .catch(function(err) {
                    console.log(err)
                })
        })
        /* handle tombol hapus */
        $('#list_bahan tbody').on('click', 'tr button.btn-danger', function(e) {
            let result = confirm('Anda yakin ingin dihapus?')
            if (result) {
                const id = datatable.row($(this).parent().parent()).data().id
                const url = window.location.origin + `/api/bahan/${id}/delete`
                
                axios.post(url)
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
})