$(function() {
    const helpers = {}
    const callbacks = {
        formCreateWos: function(e) {
            e.preventDefault()
            const newWos = {
                kode_barang: $("#kode_barang").find(":selected").val(),
                id_transaksi_kain: $("#yard_kain").find(":selected").val(),
                pcs: $("#pcs").val()
            }
    
            if (parseInt(newWos.kode_barang) == 0) {
                General.showToast('error', 'Kode barang tidak boleh kosong!')
                return
            }
    
            if (parseInt(newWos.id_transaksi_kain) == 0) {
                General.showToast('error', 'Yard tidak boleh kosong!')
                return
            }
    
            axios.post('/api/v1/wos', newWos, { headers: General.getHeaders() })
                .then(function(res) {
                    General.resetElementsField([
                        { selector: '#kode_barang', type: 'select' },
                        { selector: '#yard_kain', type: 'select' },
                        { selector: '#pcs', type: 'text' }
                    ])
                    $("#modal_create_wos").modal('toggle')
                    General.showToast('success', res.data.message)
                    datatable.ajax.reload()
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        formEditWos: function(e) {
            e.preventDefault()

            const editedWos = {
                kode_barang: $("#kode_barang2").val(),
                id_transaksi_kain: $("#yard_id2").val(),
                pcs: $("#pcs2").val()
            }
            console.log(editedWos)
            const idWos = $("#id_wos_edit").val()
            axios.post(`/api/v1/wos/${idWos}/edit`, editedWos, { headers: General.getHeaders() })
                .then(function(res) {
                    General.resetElementsField([
                        { selector: '#kode_barang2', type: 'text' },
                        { selector: '#yard_kain2', type: 'text' },
                        { selector: '#id_wos_edit', type: 'text' },
                        { selector: '#yard_id2', type: 'text' },
                        { selector: '#pcs2', type: 'text' }
                    ])
                    $("#modal_edit_wos").modal('toggle')
                    General.showToast('success', res.data.message)
                    datatable.ajax.reload()
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        formTakeWos: function(e) {
            e.preventDefault()
    
            const id = $("#id_wos_taked").val()
            const takedWos = {
                tanggal_ambil: General.convertToDatetimeSql($("#tanggal_ambil").val()),
                no_ktp_penjahit: $("#no_ktp").find(":selected").val()
            }
    
            if (parseInt(takedWos.no_ktp_penjahit) === 0) {
                General.showToast("error", "Penjahit tidak boleh kosong!")
                return
            }
    
            axios.post(`/api/v1/wos/${id}/take`, takedWos, { headers: General.getHeaders() })
                .then(function(res) {
                    General.resetElementsField([
                        { selector: "#no_ktp", type: "select" },
                        { selector: "#tanggal_ambil", type: "datetimepicker" }
                    ])
                    $("#modal_take_wos").modal('toggle')
                    General.showToast("success", res.data.message)
                    datatable.ajax.reload()
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        formReturnWos: function(e) {
            e.preventDefault()
    
            const id = $("#id_wos_returned").val()
            const returnedWos = {
                tanggal_kembali: General.convertToDatetimeSql($("#tanggal_kembali").val()),
                jumlah_kembali: $("#jumlah_kembali").val()
            }
    
            axios.post(`/api/v1/wos/${id}/return`, returnedWos, { headers: General.getHeaders() })
                .then(function(res) {
                    General.resetElementsField([
                        { selector: "#tanggal_kembali", type: "datetimepicker" },
                        { selector: "#jumlah_kembali", type: "text" }
                    ])
                    $("#modal_return_wos").modal('toggle')
                    General.showToast("success", res.data.message)
                    datatable.ajax.reload()
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        modalCreateWosOpen: function (e) {
            General.resetSelect2('#kode_barang')
            axios.get('/api/v1/barang', { headers: General.getHeaders() })
                .then(function(res) {
                    const dataBarang = res.data.data
                    dataBarang.forEach(function(barang) {
                        const option = new Option(barang.kode, barang.kode, false, false)
                        $("#kode_barang").append(option).trigger('change')
                    })
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        modalCreateWosClosed: function (e) {
            $('#kode_barang').html('')
            $('#yard_kain').html('')
    
            $('#yard_kain').parent().hide()
        },
        modalEditWosOpen: function(e) {
            General.resetSelect2('#kode_barang2')
            axios.get('/api/v1/barang', { headers: General.getHeaders() })
                .then(function(res) {
                    const dataBarang = res.data.data
                    dataBarang.forEach(function(barang) {
                        const option = new Option(barang.kode, barang.kode, false, false)
                        $("#kode_barang2").append(option).trigger('change')
                    })
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        modalEditWosClosed: function(e) {
            $('#kode_barang2').html('')
            $('#yard_kain2').html('')
    
            $('#yard_kain2').parent().hide()
        },
        modalTakeWosOpen: function(e) {
            General.resetSelect2('#no_ktp')
            axios.get('/api/v1/penjahit', { headers: General.getHeaders() })
                .then(function(res) {
                    const dataPenjahit = res.data.data
                    dataPenjahit.forEach(function(penjahit) {
                        const option = new Option(penjahit.nama_lengkap, penjahit.no_ktp, false, false)
                        $("#no_ktp").append(option).trigger("change")
                    })
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        modalTakeWosClosed: function(e) {
            $('#no_ktp').html('')
        },
        buttonCreateWos: function() {
            axios.get(`/api/v1/transaksi_kain/check/ready`, { headers: General.getHeaders() })
                .then(function(res) {
                    const status = res.data.data
                    if (status.is_ready == true) {
                        $('#modal_create_wos').modal({backdrop: 'static', keyboard: false})
                    } else {
                        General.showToast('error', 'Kain tidak ada yang ready!', 5000);
                    }
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        selectKodeBarang: function(e) {
            const selectedKodeBarang = e.params.data.id
            if (selectedKodeBarang != 0) {
                General.resetSelect2('#yard_kain')
                axios.get(`/api/v1/barang/${selectedKodeBarang}/transaksi_kain/yard`, { headers: General.getHeaders() })
                    .then(function(res) {
                        $('#yard_kain').parent().show()
                        const listYard = res.data.data
                        listYard.forEach(function(kain) {
                            const option = new Option(`${kain.yard}`, `${kain.id}`, false, false)
                            $('#yard_kain').append(option).trigger('change')
                        })
                    })
                    .catch(function(err) {
                        console.log(err)
                    }) 
            } else {
                $('#yard_kain').parent().hide()
            }
        },
        selectKodeBarang2: function(e) { // currently this function not being used.
            const selectedKodeBarang = e.params.data.id
            if (selectedKodeBarang != 0) {
                General.resetSelect2('#yard_kain2')
                axios.get(`/api/v1/barang/${selectedKodeBarang}/transaksi_kain/yard`, { headers: General.getHeaders() })
                    .then(function(res) {
                        $('#yard_kain2').parent().show()
                        const listYard = res.data.data
                        listYard.forEach(function(kain) {
                            const option = new Option(`${kain.yard}`, `${kain.id}`, false, false)
                            $('#yard_kain2').append(option).trigger('change')
                        })
                    })
                    .catch(function(err) {
                        console.log(err)
                    }) 
            } else {
                $('#yard_kain2').parent().hide()
            }
        },
        datatableButtonDetail: function(e) {
            const tr = $(this).closest('tr')
            const row = datatable.row(tr)
            
            tr.nextAll("tr.odd, tr.even").each(function(index) {
                const nextRow = $(this)
                const dtNextRow = datatable.row(nextRow)
                if (dtNextRow.child.isShown()) {
                    dtNextRow.child.hide()
                    nextRow.find('button.detail').removeClass('btn-danger').addClass('btn-primary')
                }
            })

            tr.prevAll("tr.odd, tr.even").each(function(index) {
                const prevRow = $(this)
                const dtPrevRow = datatable.row(prevRow)
                if (dtPrevRow.child.isShown()) {
                    dtPrevRow.child.hide()
                    prevRow.find('button.detail').removeClass('btn-danger').addClass('btn-primary')
                }
            })

            if (row.child.isShown()) {
                row.child.hide()
                tr.find('button.detail').removeClass('btn-danger').addClass('btn-primary')
            } else {
                const id = datatable.row($(this).parent().parent()).data().id
                const url =`/api/v1/wos/${id}/detail`

                axios.get(url, { headers: General.getHeaders() })
                    .then(function(res) {
                        const data = res.data.data
                        row.child(renderDetail(data)).show()
                        tr.find('button.detail').removeClass('btn-primary').addClass('btn-danger')

                        $("#button_edit_wos").on("click", function(e) {
                            $("#yard_kain2").parent().show()
                            const id = $(this).data("idWos")
                            
                            axios.get(`/api/v1/wos/${id}`, { headers: General.getHeaders() })
                                .then(function(res) {
                                    const dataWos = res.data.data

                                    $("#id_wos_edit").val(dataWos.id)
                                    $("#kode_barang2").val(dataWos.kode_barang)
                                    $("#yard_kain2").val(dataWos.yard)
                                    $("#yard_id2").val(dataWos.id_transaksi_kain)
                                    $("#pcs2").val(dataWos.pcs)
                                    $("#modal_edit_wos").modal('toggle')
                                })
                                .catch(function(err) {
                                    console.log(err)
                                })
                        })
                    
                        $("#button_remove_wos").on("click", function(e) {
                            let result = confirm('Anda yakin ingin dihapus?')
                            if (result) {
                                const id = $(this).data("idWos")
                                axios.post(`/api/v1/wos/${id}/remove`, { headers: General.getHeaders() })
                                    .then(function(res) {
                                        General.showToast('success', res.data.message)
                                        datatable.ajax.reload()
                                    })
                                    .catch(function(err) {
                                        console.log(err)
                                        General.showToast('error', err.mesasge)
                                    })
                            }
                        })
                    })
                    .catch(function(err) {
                        console.log('Error : ', err.response)
                    })
            }
        },
        datatableButtonTake: function(e) {
            const tanggalAmbil = datatable.row($(this).parent().parent()).data().tanggal_ambil

            if (tanggalAmbil != null) {
                General.showToast("error", "Barang sudah diambil!")
            } else {
                const id = datatable.row($(this).parent().parent()).data().id

                $("#id_wos_taked").val(id)
                $("#modal_take_wos").modal('toggle')
            }
        },
        datatableButtonReturn: function(e) {
            const id = datatable.row($(this).parent().parent()).data().id

            axios.get(`/api/v1/wos/${id}`, { headers: General.getHeaders() })
                .then(function(res) {
                    const tanggal_ambil = res.data.data.tanggal_ambil
                    if (tanggal_ambil !== null) {
                        $("#id_wos_returned").val(id)
                        $("#modal_return_wos").modal('toggle')
                    } else {
                        General.showToast("error", "Pastikan jahitan sudah diambil terlebih dahulu", 5000)
                        return
                    }
                })
                .catch(function(err) {
                    console.log(err)
                })
        }
    }
    const columns = [
        { data: "id", visible: false },
        {
            data: "created_at",
            visible: false,
            searchable: false,
            orderable: false
        },
        {
            data: "nama_lengkap",
            defaultContent: '<i class="text-gray">Belum ada</i>'
        },
        {
            data: "kode_barang"
        },
        {
            data: "yard"
        },
        {
            data: "pcs"
        },
        {
            data: "demand"
        },
        {
            data: "tanggal_ambil",
            defaultContent: '<i class="text-gray">Belum diambil</i>',
            render: function(data, type, row, meta) {
                return data != null ? General.convertToMomentFormat(data) : null
            }
        },
        {
            data: "tanggal_kembali",
            defaultContent: '<i class="text-gray">Belum dikembalikan</i>',
            render: function(data, type, row, meta) {
                return data != null ? General.convertToMomentFormat(data) : null
            }
        },
        {
            data: function(row, type, val, meta) {
                return `${row.jumlah_kembali} <i class="text-success">(sisa ${row.pcs - row.jumlah_kembali})</i>`
            }
        },
        {
            searchable: false,
            orderable: false,
            data: function(row, type, val, meta) {
                if (row.tanggal_ambil == null) {
                    status = StatusWos.BELUM_DIAMBIL
                    return status
                } else {
                    if (row.tanggal_kembali == null) {
                        if (row.jumlah_kembali > 0 && row.jumlah_kembali < row.pcs) {
                            status = StatusWos.DIKEMBALIKAN_SETENGAH
                            return status
                        } else {
                            status = StatusWos.SUDAH_DIAMBIL
                            return status
                        }
                    } else {
                        status = StatusWos.COMPLETED
                        return status
                    }
                }
            }, // belum diambil -> primary, sudah diambil -> warning, sudah dikembalikan sebagian -> merah, sudah dikembalikan semua -> hijau
            render: function(data, type, row, meta) {
                return '<span class="badge '+ (data == StatusWos.BELUM_DIAMBIL ? 'badge-primary' : data == StatusWos.SUDAH_DIAMBIL ? 'badge-warning' : data == StatusWos.DIKEMBALIKAN_SETENGAH ? 'badge-danger' : data == StatusWos.COMPLETED ? 'badge-success' : 'badge-test') +'">'+ (data == StatusWos.BELUM_DIAMBIL ? 'Belum diambil' : data == StatusWos.SUDAH_DIAMBIL ? 'Sudah diambil' : data == StatusWos.DIKEMBALIKAN_SETENGAH ? 'Dikembalikan Setengah' : data == StatusWos.COMPLETED ? 'Completed' : 'Unknown') +'</span>'
            }
        },
        {
            data: null,
            className: 'text-center',
            defaultContent: `
                <button type="button" class="btn btn-primary btn-sm mr-2 mb-2 detail">
                    <i class="fas fa-eye"></i></button>
                <button type="button" class="btn btn-warning btn-sm mr-2 mb-2">
                    <i class="fas fa-hand-rock"></i>
                </button>
                <button type="button" class="btn btn-success btn-sm mr-2 mb-2">
                    <i class="fas fa-hand-paper"></i></button>`
        }
    ]
    const config = {
        processing: true,
        serverSide: true,
        pageLength: 100,
        initComplete: function(settings, json) {
            handleButtonsClick()
        },
        ajax: {
            url: '/api/v1/wos/get/datatable',
            type: 'GET',
            headers: General.getHeaders()
        },
        columns: columns
    }
    const datatable = $("#list_wos").DataTable(config)

    $('#button_create_wos').on('click', callbacks.buttonCreateWos)

    $("#modal_create_wos").on("show.bs.modal", callbacks.modalCreateWosOpen)
    $('#modal_create_wos').on('hidden.bs.modal', callbacks.modalCreateWosClosed)
    $("#modal_edit_wos").on("show.bs.modal", callbacks.modalEditWosOpen)
    $('#modal_edit_wos').on('hidden.bs.modal', callbacks.modalEditWosClosed)
    $("#modal_take_wos").on("show.bs.modal", callbacks.modalTakeWosOpen)

    $("#form_create_wos").on('submit', callbacks.formCreateWos)
    $("#form_edit_wos").on("submit", callbacks.formEditWos)
    $("#form_take_wos").on('submit', callbacks.formTakeWos)
    $("#form_return_wos").on('submit', callbacks.formReturnWos)

    $('#kode_barang').on('select2:select', callbacks.selectKodeBarang)
    // $('#kode_barang2').on('select2:select', callbacks.selectKodeBarang2) (belum dipake)

    function handleButtonsClick() {
        $("#list_wos tbody").on("click", "tr button.btn.detail", callbacks.datatableButtonDetail)
        $("#list_wos tbody").on("click", "tr button.btn-warning", callbacks.datatableButtonTake)
        $("#list_wos tbody").on("click", "tr button.btn-success", callbacks.datatableButtonReturn)
    }

    function renderDetail(wos) {
        return `<div class="row">
            <div class="col-md-12">
                <h4>Detail Wos</h4>
                <hr />
                <dl class="row">
                    <dt class="col-sm-4">Kode Barang</dt>
                        <dd class="col-sm-8">${wos.kode_barang}</dd>
                    <dt class="col-sm-4">Kode Kain</dt>
                        <dd class="col-sm-8">${wos.barang.kode_kain}</dd>
                    <dt class="col-sm-4">Yard</dt>
                        <dd class="col-sm-8">${wos.yard}</dd>
                    <dt class="col-sm-4">Pcs</dt>
                        <dd class="col-sm-8">${wos.pcs}</dd>
                    <dt class="col-sm-4">Tanggal Ambil</dt>
                        <dd class="col-sm-8">${wos.tanggal_ambil ? wos.tanggal_ambil : 'belum diambil'}</dd>
                    <dt class="col-sm-4">Tanggal Kembali</dt>
                        <dd class="col-sm-8">${wos.tanggal_kembali ? wos.tanggal_kembali : 'belum dikembalikan'}</dd>
                    <dt class="col-sm-4">Status Jahit</dt>
                        <dd class="col-sm-8">${wos.status_jahit == 0 ? 'belum' : 'sudah'}</dd>
                    <dt class="col-sm-4">Status Bayar</dt>
                        <dd class="col-sm-8">${wos.status_bayar == 0 ? 'belum' : 'sudah'}</dd>
                    <dt class="col-sm-4">Nama Penjahit</dt>
                        <dd class="col-sm-8">${wos.penjahit != null ? wos.penjahit.nama_lengkap : 'belum ada'}</dd>
                    <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">${wos.created_at}</dd>
                    <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">${wos.updated_at}</dd>
                </dl>
            </div>
            <div class="col-md-12">
                <button data-id-wos="${wos.id}" id="button_edit_wos" type="button" class="btn btn-info btn-sm mr-2 mb-2">
                    <i class="fas fa-pencil-alt mr-2"></i>Edit
                </button>
                <button data-id-wos="${wos.id}" id="button_remove_wos" type="button" class="btn btn-danger btn-sm mb-2">
                    <i class="fas fa-trash mr-2"></i>Remove
                </button>
            </div>
        </div>`
    }
})

// const checkBahanURL = `/api/bahan/${newWos.id_bahan}/check/status_potong`
// axios.get(checkBahanURL)
//     .then(function(res) {
//         const bahan = res.data.data
//         if (bahan.status_potong == false) {
            
//         } else {
//             General.showToast('error', 'Bahan sudah dipotong, silahkan pilih yang lain')
//             return
//         }
//     })
//     .catch(function(err) {
//         console.log(err)
//     })

/* load barang */
// General.resetSelect2('#kode_barang')
// axios.get('/api/v1/barang')
//     .then(function(res) {
//         const dataBarang = res.data.data
//         dataBarang.forEach(function(barang) {
//             const option = new Option(barang.kode, barang.kode, false, false)
//             $("#kode_barang").append(option).trigger('change')
//         })
//     })
//     .catch(function(err) {
//         console.log(err)
//     })

/* load nama_bahan */
// General.resetSelect2('#nama_bahan')
// axios.get('/api/jenis/bahan/get/nama')
//     .then(function(res) {
//         const listNamaBahan = res.data.data
//         listNamaBahan.forEach(function(bahan) {
//             const option = new Option(`${bahan.nama}`, `${bahan.nama}`, false, false)
//             $("#nama_bahan").append(option).trigger('change')
//         })
//     })
//     .catch(function(err) {
//         console.log(err)
//     })

// $('#nama_bahan').on('select2:select', function(e) {
//     const selectedNamaBahan = e.params.data.id
//     if (selectedNamaBahan != 0) {
//         General.resetSelect2('#warna_bahan')
//         axios.get(`/api/jenis/bahan/get/warna?nama=${selectedNamaBahan}`)
//             .then(function(res) {
//                 $('#warna_bahan').parent().show()
//                 const listWarnaBahan = res.data.data
//                 listWarnaBahan.forEach(function(bahan) {
//                     const option = new Option(`${bahan.warna}`, `${bahan.warna}`, false, false)
//                     $('#warna_bahan').append(option).trigger('change')
//                 })
//             })
//             .catch(function(err) {
//                 console.log(err)
//             })   
//     } else {
//         $('#warna_bahan').parent().hide()
//         $('#yard_bahan').parent().hide()
//     }
// })

// $('#warna_bahan').on('select2:select', function(e) {
//     const selectedNamaBahan = $('#nama_bahan').find(':selected').val()
//     const selectedWarnaBahan = e.params.data.id
    
//     if (selectedNamaBahan != 0 && selectedWarnaBahan != 0) {
//         General.resetSelect2('#yard_bahan')
//         const url = `/api/bahan/get/yard?nama=${selectedNamaBahan}&warna=${selectedWarnaBahan}`
//         axios.get(url)
//             .then(function(res) {
//                 $('#yard_bahan').parent().show()
//                 const listYard = res.data.data
//                 listYard.forEach(function(bahan) {
//                     const option = new Option(`${bahan.yard}`, `${bahan.id}`, false, false)
//                     $('#yard_bahan').append(option).trigger('change')
//                 })
//             })
//             .catch(function(err) {
//                 console.log(err)
//             })
//     } else {
//         $('#yard_bahan').parent().hide()
//     }
// })