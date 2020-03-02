$(function() {    
    const helpers = {
        listKodeInduk: function(elementId) {
            axios.get('/api/v1/induk/get/kode')
                .then(function(res) {
                    const dataInduk = res.data.data
                    dataInduk.forEach(function(induk) {
                        const option = new Option(induk.kode, induk.kode, false, false)
                        $(elementId).append(option).trigger('change')
                    })
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        listNamaKain: function(elementId) {
            axios.get('/api/v1/kain/get/nama')
                .then(function(res) {
                    const dataNama = res.data.data
                    dataNama.forEach(function(nama) {
                        const option = new Option(nama.nama, nama.nama, false, false)
                        $(elementId).append(option).trigger('change')
                    })
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        listWarnaKain: function(elementId, namaKain) {
            axios.get(`/api/v1/kain/get/warna?nama=${namaKain}`)
                .then(function(res) {
                    const dataNama = res.data.data
                    dataNama.forEach(function(nama) {
                        const option = new Option(nama.nama, nama.nama, false, false)
                        $(elementId).append(option).trigger('change')
                    })
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        dataTableInitComplete: function(settings, json) {
            /* handle tombol show */
            $('#list_barang tbody').on('click', 'tr button.btn.detail', callbacks.buttonDetailBarang)
            /* handle tombol edit */
            $('#list_barang tbody').on('click', 'tr button.btn-info', callbacks.buttonEditBarang)
            /* handle tombol hapus */
            $('#list_barang tbody').on('click', 'tr button.btn-danger', callbacks.buttonRemoveBarang)
        },
        renderDetail: function (barang) {
            return `<div class="row">
                <div class="col-md-12">
                    <h4>Detail Kain</h4>
                    <hr />
                    <dl class="row">
                        <dt class="col-sm-4">Kode</dt>
                            <dd class="col-sm-8">${barang.kode}</dd>
                        <dt class="col-sm-4">Kode Induk</dt>
                            <dd class="col-sm-8">${barang.kode_induk}</dd>
                        <dt class="col-sm-4">Kode Kain</dt>
                            <dd class="col-sm-8">${barang.kode_kain}</dd>
                        <dt class="col-sm-4">Stok Ready</dt>
                            <dd class="col-sm-8">${barang.stok_ready}</dd>
                        <dt class="col-sm-4">Stok On Progress</dt>
                            <dd class="col-sm-8">${barang.stok_on_progress}</dd>
                        <dt class="col-sm-4">Treshold</dt>
                            <dd class="col-sm-8">${barang.treshold}</dd>
                        <dt class="col-sm-4">Status Produksi</dt>
                            <dd class="col-sm-8"><span class="badge ${barang.status_produksi === 'true' ? 'badge-success' : 'badge-danger'}">${barang.value === 'true' ? 'Aman' : 'Urgent'}</dd>
                        <dt class="col-sm-4">Jumlah Wos</dt>
                            <dd class="col-sm-8">${barang.jumlah_wos}</dd>
                        <dt class="col-sm-4">Created At</dt>
                            <dd class="col-sm-8">${barang.created_at}</dd>
                        <dt class="col-sm-4">Updated At</dt>
                            <dd class="col-sm-8">${barang.updated_at}</dd>
                    </dl>
                </div>
            </div>`
        }
    }
    const callbacks = {
        /* handle modal create barang opened */
        modalCreateOpen: function(e) {
            General.resetSelect2('#kode_induk')
            General.resetSelect2('#nama_kain')
            General.resetSelect2('#warna_kain')
    
            helpers.listKodeInduk('#kode_induk')
            helpers.listNamaKain('#nama_kain')
            helpers.listWarnaKain('#warna_kain', $('#nama_kain').find(':selected').val())   
        },
        /* handle modal edit barang opened */
        modalEditOpen: function(e) {
            General.resetSelect2('#kode_induk2')
            General.resetSelect2('#nama_kain2')
            General.resetSelect2('#warna_kain2')
    
            helpers.listKodeInduk('#kode_induk2')
            helpers.listNamaKain('#nama_kain2')
            helpers.listWarnaKain('#warna_kain2', $('#nama_kain2').find(':selected').val())
        },
        /* handle modal create barang closed */
        modalCreateClosed: function(e) {
            $('#kode_induk').html('')
            $('#nama_kain').html('')
            $('#warna_kain').html('')
            $('#stok_ready').val('')
            $('#treshold').val('')

            $('#warna_kain').parent().parent().hide()
        },
        /* handle modal edit barang closed */
        modalEditClosed: function(e) {
            $('#kode_induk2').html('')
            $('#nama_kain2').html('')
            $('#warna_kain2').html('')
            $('#stok_ready2').val('')
            $('#treshold2').val('')

            $('#warna_kain2').parent().parent().hide()
        },
        /* handle select event nama_kain */
        selectNamaKain: function(e) {
            const selectedNamaKain = e.params.data.id
            if (selectedNamaKain != '0') {
                General.resetSelect2('#warna_kain')
                axios.get(`/api/v1/kain/get/warna?nama=${selectedNamaKain}`)
                    .then(function(res) {
                        $('#warna_kain')
                            .parent()
                            .parent()
                            .show()
                        const listWarnaKain = res.data.data
                        listWarnaKain.forEach(function(bahan) {
                            const option = new Option(`${bahan.warna}`, `${bahan.warna}`, false, false)
                            $('#warna_kain').append(option).trigger('change')
                        })
                    })
                    .catch(function(err) {
                        console.log(err)
                    })
            } else {
                General.resetSelect2('#warna_kain')
                $('#warna_kain')
                    .parent()
                    .parent()
                    .hide()
            }
        },
        /* handle select event nama_kain */
        selectNamaKain2: function(e) {
            const selectedNamaKain = e.params.data.id
            if (selectedNamaKain != '0') {
                General.resetSelect2('#warna_kain2')
                axios.get(`/api/v1/kain/get/warna?nama=${selectedNamaKain}`)
                    .then(function(res) {
                        $('#warna_kain2')
                            .parent()
                            .parent()
                            .show()
                        const listWarnaKain = res.data.data
                        listWarnaKain.forEach(function(bahan) {
                            const option = new Option(`${bahan.warna}`, `${bahan.warna}`, false, false)
                            $('#warna_kain2').append(option).trigger('change')
                        })
                    })
                    .catch(function(err) {
                        console.log(err)
                    })
            } else {
                General.resetSelect2('#warna_kain2')
                $('#warna_kain2')
                    .parent()
                    .parent()
                    .hide()
            }
        },
        /* form create new barang */
        formCreateBarang: function(e) {
            e.preventDefault()
            const nama = $('#nama_kain').find(':selected').val()
            const warna = $('#warna_kain').find(':selected').val()
            const kode = General.spaceRemover($('#kode_induk').find(':selected').val()) + '-' + warna
            const newBarang = {
                kode: kode,
                kode_induk: $('#kode_induk').find(':selected').val(),
                kode_kain: $('#nama_kain').find(':selected').val() + '-' + $('#warna_kain').find(':selected').val(),
                stok_ready: parseInt($('#stok_ready').val()),
                treshold: parseInt($('#treshold').val())
            }

            if (parseInt(newBarang.kode_induk) === 0) {
                General.showToast('error', 'Kode induk tidak boleh kosong!')
                return
            }
    
            if (parseInt(nama) === 0) {
                General.showToast('error', 'Nama kain tidak boleh kosong!')
                return
            }
    
            if (parseInt(warna) === 0) {
                General.showToast('error', 'Warna kain tidak boleh kosong!')
                return
            }
            
            axios.post('/api/v1/barang', newBarang)
                .then(function(res) {
                    General.resetElementsField([
                        { selector: '#kode', type: 'text' },
                        { selector: '#kode_induk', type: 'select' },
                        { selector: '#nama_kain', type: 'select' },
                        { selector: '#warna_kain', type: 'select' },
                        { selector: '#stok_ready', type: 'text' },
                        { selector: '#treshold', type: 'text' }
                    ])
                    $('#modal_create_barang').modal('toggle')
                    General.showToast('success', res.data.message)
                    datatable.ajax.reload()
                })
                .catch(function(err) {
                    console.log(err.response.data)
                })
        },
        /* form edit barang */
        formEditBarang: function(e) {
            e.preventDefault()
            const nama = $('#nama_kain2').find(':selected').val()
            const warna = $('#warna_kain2').find(':selected').val()
            const kode = General.spaceRemover($('#kode_induk2').find(':selected').val()) + '-' + warna
            const editedBarang = {
                kode: kode,
                kode_induk: $('#kode_induk2').find(':selected').val(),
                kode_kain: $('#nama_kain2').find(':selected').val() + '-' + $('#warna_kain2').find(':selected').val(),
                stok_ready: parseInt($('#stok_ready2').val()),
                treshold: parseInt($('#treshold2').val())
            }

            if (parseInt(editedBarang.kode_induk) === 0) {
                General.showToast('error', 'Kode induk tidak boleh kosong!')
                return
            }
    
            if (parseInt(nama) === 0) {
                General.showToast('error', 'Nama kain tidak boleh kosong!')
                return
            }
    
            if (parseInt(warna) === 0) {
                General.showToast('error', 'Warna kain tidak boleh kosong!')
                return
            }

            const kodes = $('#kodes').val()
            axios.post(`/api/v1/barang/${kodes}/edit`, editedBarang)
                .then(function(res) {
                    General.resetElementsField([
                        { selector: '#kodes', type: 'text' },
                        { selector: '#kode_induk2', type: 'select' },
                        { selector: '#nama_kain2', type: 'select' },
                        { selector: '#warna_kain2', type: 'select' },
                        { selector: '#stok_ready2', type: 'text' },
                        { selector: '#treshold2', type: 'text' }
                    ])
                    $('#modal_edit_barang').modal('toggle')
                    General.showToast('success', res.data.message)
                    datatable.ajax.reload()
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        /* button detail barang */
        buttonDetailBarang: function(e) {       
            const tr = $(this).closest('tr')
            const row = datatable.row(tr)

            if (row.child.isShown()) {
                row.child.hide()
                tr.find('button.detail').removeClass('btn-warning').addClass('btn-primary')
            } else {
                const kode = datatable.row($(this).parent().parent()).data().kode
                const url = `/api/v1/barang/${kode}/detail`

                axios.get(url)
                    .then(function(res) {
                        const data = res.data.data
                        row.child(helpers.renderDetail(data)).show()
                        tr.find('button.detail').removeClass('btn-primary').addClass('btn-warning')
                    })
                    .catch(function(err) {
                        console.log('Error : ', error.response.data)
                    })
            }
        },
        /* button edit barang */
        buttonEditBarang: function(e) {
            $('#warna_kain2').parent().parent().show()

            const kode = datatable.row($(this).parent().parent()).data().kode
            axios.get(`/api/v1/barang/${kode}`)
                .then(function(res) {
                    const barang = res.data.data
                    const nama = barang.kode_kain.split('-')[0]
                    const warna = barang.kode_kain.split('-')[1]

                    $('#kodes').val(barang.kode)
                    setTimeout(function() {
                        $('#kode_induk2').val(`${barang.kode_induk}`).trigger('change')
                        $('#nama_kain2').val(nama).trigger('change')
                        $('#warna_kain2').val(warna).trigger('change')
                    }, 250)
                    $('#stok_ready2').val(barang.stok_ready)
                    $('#treshold2').val(barang.treshold)

                    $('#modal_edit_barang').modal('toggle')

                    General.resetSelect2('#warna_kain2')
                    axios.get(`/api/v1/kain/get/warna?nama=${nama}`)
                        .then(function(res) {
                            $('#warna_kain2')
                                .parent()
                                .parent()
                                .show()
                            const listWarnaKain = res.data.data
                            listWarnaKain.forEach(function(bahan) {
                                const option = new Option(`${bahan.warna}`, `${bahan.warna}`, false, false)
                                $('#warna_kain2').append(option).trigger('change')
                            })
                        })
                        .catch(function(err) {
                            console.log(err)
                        })
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        /* button hapus barang */
        buttonRemoveBarang: function(e) {
            let result = confirm('Anda yakin ingin dihapus?')
            if (result) {
                const kode = datatable.row($(this).parent().parent()).data().kode
                axios.post(`/api/v1/barang/${kode}/remove`)
                    .then(function(res) {
                        General.showToast('success', res.data.message)
                        datatable.ajax.reload()
                    })
                    .catch(function(err) {
                        console.log(err)
                        General.showToast('error', err.mesasge)
                    })
            }
        }
    }

    const dataTableColumns = [
        { data: 'kode' },
        { data: 'kode_kain' },
        { data: 'kode_induk' },
        { data: 'stok_ready' },
        {
            data: 'stok_on_progress',
            orderable: false,
            searchable: false
        },
        { data: 'treshold' },
        { 
            data: 'status_produksi',
            orderable: false,
            searchable: false,
            render: function(data, type, row, meta) {
                return '<span class="badge '+ (data === 'true' ? 'badge-success' : 'badge-danger') +'">'+ (data === 'true' ? 'Aman' : 'Urgent') +'</span>'
            }
        },
        {
            orderable: false,
            searchable: false,
            data: 'created_at',
            render: function(data, type, row, meta) {
                return General.convertToMomentFormat(data)
            }
        }, // cari tentang kostum sorter
        {
            data: null,
            orderable: false,
            searchable: false,
            className: 'text-center',
            defaultContent: '<button type="button" class="btn btn-primary btn-sm mr-2 detail"><i class="fas fa-eye"></i></button><button type="button" class="btn btn-info btn-sm mr-2"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>'
        }
    ]

    const dataTableConfig = {
        processing: true,
        serverSide: true,
        initComplete: helpers.dataTableInitComplete,
        ajax: '/api/v1/barang/with/on_progress',
        columns: dataTableColumns
    }

    const datatable = $('#list_barang').DataTable(dataTableConfig)

    $('#form_create_barang').on('submit', callbacks.formCreateBarang)
    $('#form_edit_barang').on('submit', callbacks.formEditBarang)
    $('#nama_kain').on('select2:select', callbacks.selectNamaKain)
    $('#nama_kain2').on('select2:select', callbacks.selectNamaKain2)
    $('#modal_create_barang').on('show.bs.modal', callbacks.modalCreateOpen)
    $('#modal_create_barang').on('hidden.bs.modal', callbacks.modalCreateClosed)
    $('#modal_edit_barang').on('show.bs.modal', callbacks.modalEditOpen)
    $('#modal_edit_barang').on('hidden.bs.modal', callbacks.modalEditClosed)
})

/* @reminder: it was inside handleButtonsClick() in button_detail click event */
// axios.get(`/api/barang/${kode}`)
//     .then(function(res) {
//         moment.locale('id')
//         $('#dt_kode').html(res.data.data.kode)
//         $('#dt_kode_induk').html(res.data.data.kode_induk)
//         $('#dt_warna').html(res.data.data.warna)
//         $('#dt_stok_ready').html(res.data.data.stok_ready)
//         $('#dt_treshold').html(res.data.data.treshold)
//         $('#dt_created_at').html(General.convertToMomentFormat(res.data.data.created_at))
//         $('#dt_updated_at').html(General.convertToMomentFormat(res.data.data.updated_at))
//         $('#modal_show_barang').modal('toggle')
//     })
//     .catch(function(err) {
//         console.log(err)
//     })

// @reminder: it was old datatable 'ajax' part
// ajax: async function(data, callback, settings) {
//     const res = await axios.get('/api/barang/with/on_progress')
//     const allBarang = []
//     res.data.data.forEach(function(barang, index) {
//         const modelBarang = new ModelBarang(
//             barang.kode,
//             barang.kode_induk,
//             barang.warna,
//             barang.stok_ready,
//             barang.stok_on_progress,
//             barang.treshold,
//             barang.created_at,
//             barang.updated_at
//         )
//         modelBarang.setNumbering(index + 1)
//         data = modelBarang.getUIData()
//         allBarang.push(data)
//     })
//     callback({ data: allBarang })
// },