$(function() {
    let dataInduk = null
    let dataInduk2 = null
    const datatable = $('#list_barang').DataTable({
        initComplete: function(settings, json) {
            handleButtonsClick()
        },
        ajax: async function(data, callback, settings) {
            const res = await axios.get('/api/barang/with/on_progress')
            const allBarang = []
            res.data.data.forEach(function(barang, index) {
                const modelBarang = new ModelBarang(
                    barang.kode,
                    barang.kode_induk,
                    barang.warna,
                    barang.stok_ready,
                    barang.stok_on_progress,
                    barang.treshold,
                    barang.created_at,
                    barang.updated_at
                )
                modelBarang.setNumbering(index + 1)
                data = modelBarang.getUIData()
                allBarang.push(data)
            })
            callback({ data: allBarang })
        },
        columns: [
            { data: 'no' },
            { data: 'kode' },
            { data: 'kode_induk' },
            { data: 'warna' },
            { data: 'stok_ready' },
            { data: 'stok_on_progress' },
            { data: 'treshold' },
            { data: 'created_at' }, // cari tentang kostum sorter
            {
                data: null,
                className: 'text-center',
                defaultContent: '<button type="button" class="btn btn-primary btn-sm mr-2"><i class="fas fa-eye"></i></button><button type="button" class="btn btn-info btn-sm mr-2"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>'
            }
        ]
    })
    /* handle form tambah barang */
    $('#form_create_barang').on('submit', function(e) {
        e.preventDefault()
        const kode = General.spaceRemover($('#kode_induk').find(':selected').val()) + '-' + General.spaceRemover($('#warna').val())
        const newBarang = {
            kode: kode,
            kode_induk: $('#kode_induk').find(':selected').val(),
            warna: $('#warna').val(),
            stok_ready: parseInt($('#stok_ready').val()),
            treshold: parseInt($('#treshold').val())
        }
        if (parseInt(newBarang.kode_induk) === 0) {
            General.showToast('error', 'Kode induk tidak boleh kosong!')
            return
        }
        
        axios.post('/api/barang', newBarang)
            .then(function(res) {
                General.resetElementsField([
                    { selector: '#kode', type: 'text' },
                    { selector: '#kode_induk', type: 'select' },
                    { selector: '#warna', type: 'text' },
                    { selector: '#stok_ready', type: 'text' },
                    { selector: '#treshold', type: 'text' }
                ])
                $('#modal_create_barang').modal('toggle')
                General.showToast('success', res.data.message)
                datatable.ajax.reload()
            })
            .catch(function(err) {
                console.log(err)
            })
    })
    /* handle form edit barang */
    $('#form_edit_barang').on('submit', function(e) {
        e.preventDefault()
        const kode = General.spaceRemover($('#kode_induk2').find(':selected').val()) + '-' + General.spaceRemover($('#warna2').val())
        const editedBarang = {
            kode: kode,
            kode_induk: $('#kode_induk2').find(':selected').val(),
            warna: $('#warna2').val(),
            stok_ready: parseInt($('#stok_ready2').val()),
            treshold: parseInt($('#treshold2').val())
        }
        if (parseInt(editedBarang.kode_induk) === 0) {
            General.showToast('error', 'Kode induk tidak boleh kosong!')
            return
        }
        const kodes = $('#kodes2').val()
        axios.post(`/api/barang/${kodes}/edit`, editedBarang)
            .then(function(res) {
                General.resetElementsField([
                    { selector: '#kode2', type: 'text' },
                    { selector: '#kode_induk2', type: 'select' },
                    { selector: '#warna2', type: 'text' },
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
    })
    /* handle select2 data induk tambah */
    $('#modal_create_barang').on('show.bs.modal', function(e) {
        if (dataInduk === null) {
            /* TODO: bikin api yang hanya meload list kode_induk saja */
            const route = '/api/induk'
            axios.get(route)
                .then(function(res) {
                    dataInduk = res.data.data
                    dataInduk.forEach(function(induk) {
                        const option = new Option(induk.kode, induk.kode, false, false)
                        $('#kode_induk').append(option).trigger('change')
                    })
                })
                .catch(function(err) {
                    console.log(err)
                })
        }
    })
    /* handle select2 data induk edit */
    $('#modal_edit_barang').on('show.bs.modal', function(e) {
        if (dataInduk2 === null) {
            axios.get('/api/induk')
                .then(function(res) {
                    dataInduk2 = res.data.data
                    dataInduk2.forEach(function(induk) {
                        const option = new Option(induk.kode, induk.kode, false, false)
                        $('#kode_induk2').append(option).trigger('change')
                    })
                })
                .catch(function(err) {
                    console.log(err)
                })
        }
    })

    function handleButtonsClick() {
        /* handle tombol show */
        $('#list_barang tbody').on('click', 'tr button.btn-primary', function(e) {
            const kode = datatable.row($(this).parent().parent()).data().kode
            
            axios.get(`/api/barang/${kode}`)
                .then(function(res) {
                    moment.locale('id')
                    $('#dt_kode').html(res.data.data.kode)
                    $('#dt_kode_induk').html(res.data.data.kode_induk)
                    $('#dt_warna').html(res.data.data.warna)
                    $('#dt_stok_ready').html(res.data.data.stok_ready)
                    $('#dt_treshold').html(res.data.data.treshold)
                    $('#dt_created_at').html(General.convertToMomentFormat(res.data.data.created_at))
                    $('#dt_updated_at').html(General.convertToMomentFormat(res.data.data.updated_at))
                    $('#modal_show_barang').modal('toggle')
                })
                .catch(function(err) {
                    console.log(err)
                })
        })
        /* handle tombol edit */
        $('#list_barang tbody').on('click', 'tr button.btn-info', function(e) {
            const kode = datatable.row($(this).parent().parent()).data().kode
            axios.get(`/api/barang/${kode}`)
                .then(function(res) {
                    $('#kodes2').val(res.data.data.kode)
                    setTimeout(function() {
                        $('#kode_induk2').val(`${res.data.data.kode_induk}`).trigger('change')
                    }, 250)
                    $('#warna2').val(res.data.data.warna)
                    $('#stok_ready2').val(res.data.data.stok_ready)
                    $('#treshold2').val(res.data.data.treshold)
                    $('#modal_edit_barang').modal('toggle')
                })
                .catch(function(err) {
                    console.log(err)
                })
        })
        /* handle tombol hapus */
        $('#list_barang tbody').on('click', 'tr button.btn-danger', function(e) {
            let result = confirm('Anda yakin ingin dihapus?')
            if (result) {
                const kode = datatable.row($(this).parent().parent()).data().kode
                axios.post(`/api/barang/${kode}/delete`)
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
    }
})