$(function() {
    let dataPenjahit = null

    /* handle list wos */
    let datatable = $("#list_wos").DataTable({
        pageLength: 100,
        initComplete: function(settings, json) {
            handleButtonsClick()
        },
        ajax: function(data, callback, settings) {
            axios.get('/api/wos/completed')
                .then(function(res) {
                    const allWos = []
                    res.data.data.forEach(function(wos, index) {
                        const modelWos = new ModelWos(
                            wos.id,
                            wos.kode_barang,
                            wos.id_bahan,
                            wos.yard,
                            wos.pcs,
                            wos.tanggal_ambil,
                            wos.tanggal_kembali,
                            wos.jumlah_kembali,
                            wos.status_bayar,
                            wos.no_ktp_penjahit,
                            wos.created_at,
                            wos.updated_at,
                            wos.barang,
                            wos.penjahit,
                            wos.bahan
                        )
                        allWos.push(modelWos.getUIData())
                    })
                    const dataWos = {
                        data: allWos
                    }
                    callback(dataWos)
                })
                .catch(function(err) {
                    console.log(err)
                })
        },
        columns: [
            { data: "id", visible: false },
            { data: "created_at", visible: false },
            { data: "nama_penjahit" },
            { data: "kode_barang" },
            { data: "yard" },
            { data: "pcs" },
            { data: "demand" },
            { data: "tanggal_ambil" },
            { data: "tanggal_kembali" },
            { data: "jumlah_kembali" },
            { 
                data: "status", // belum diambil -> primary, sudah diambil -> warning, sudah dikembalikan sebagian -> merah, sudah dikembalikan semua -> hijau
                render: function(data, type, row, meta) {
                    return '<span class="badge '+ (data === StatusWos.BELUM_DIAMBIL ? 'badge-primary' : data === StatusWos.SUDAH_DIAMBIL ? 'badge-warning' : data === StatusWos.DIKEMBALIKAN_SETENGAH ? 'badge-danger' : data === StatusWos.COMPLETED ? 'badge-success' : 'badge-test') +'">'+ (data === StatusWos.BELUM_DIAMBIL ? 'Belum diambil' : data === StatusWos.SUDAH_DIAMBIL ? 'Sudah diambil' : data === StatusWos.DIKEMBALIKAN_SETENGAH ? 'Dikembalikan Setengah' : data === StatusWos.COMPLETED ? 'Completed' : 'Unknown') +'</span>'
                }
            },
            {
                data: null,
                className: 'text-center',
                defaultContent: '<button type="button" class="btn btn-warning btn-sm mr-2 mb-2"><i class="fas fa-hand-rock"></i></button><button type="button" class="btn btn-success btn-sm mr-2 mb-2"><i class="fas fa-hand-paper"></i></button><button type="button" class="btn btn-primary btn-sm mr-2 mb-2"><i class="fas fa-eye"></i></button><button type="button" class="btn btn-info btn-sm mr-2 mb-2"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-danger btn-sm mb-2"><i class="fas fa-trash"></i></button>'
            }
        ],
        order: [[1, 'desc']]
    })

    /* handle button tambah wos */
    $('#btn_add_wos').on('click', function() {
        const checkBahanReadyURL = `/api/bahan/check/ready`
        axios.get(checkBahanReadyURL)
            .then(function(res) {
                const status = res.data.data
                if (status.is_ready == true) {
                    $('#modal_create_wos').modal({backdrop: 'static', keyboard: false})
                } else {
                    General.showToast('error', 'Bahan tidak ada yang ready!', 5000);
                }
            })
            .catch(function(err) {
                console.log(err)
            })
    })

    /* handle modal tambah wos */
    $("#modal_create_wos").on("show.bs.modal", handleModalShowCreateWos)
    $('#modal_create_wos').on('hidden.bs.modal', handleModalHideCreateWos)

    /* handle modal take wos */
    $("#modal_take_wos").on("show.bs.modal", function(e) {
        /* load penjahit */
        if (dataPenjahit === null) {
            axios.get('/api/penjahit')
                .then(function(res) {
                    dataPenjahit = res.data.data
                    dataPenjahit.forEach(function(penjahit) {
                        const option = new Option(penjahit.nama_lengkap, penjahit.no_ktp, false, false)
                        $("#no_ktp").append(option).trigger("change")
                    })
                })
                .catch(function(err) {
                    console.log(err)
                })
        }
    })

    /* handle form create wos */
    $("#form_create_wos").on('submit', function(e) {
        e.preventDefault()
        const newWos = {
            kode_barang: $("#kode_barang").find(":selected").val(),
            id_bahan: $("#yard_bahan").find(":selected").val(),
            pcs: $("#pcs").val()
        }

        if (parseInt(newWos.kode_barang) == 0) {
            General.showToast('error', 'Kode barang tidak boleh kosong!')
            return
        }

        if (parseInt(newWos.id_bahan) == 0) {
            General.showToast('error', 'Bahan tidak boleh kosong!')
            return
        }

        const checkBahanURL = `/api/bahan/${newWos.id_bahan}/check/status_potong`
        axios.get(checkBahanURL)
            .then(function(res) {
                const bahan = res.data.data
                if (bahan.status_potong == false) {
                    axios.post('/api/wos', newWos)
                        .then(function(res) {
                            General.resetElementsField([
                                { selector: '#kode_barang', type: 'select' },
                                { selector: '#nama_bahan', type: 'select' },
                                { selector: '#warna_bahan', type: 'select' },
                                { selector: '#yard_bahan', type: 'select' },
                                { selector: '#pcs', type: 'text' }
                            ])
                            $("#modal_create_wos").modal('toggle')
                            General.showToast('success', res.data.message)
                            datatable.ajax.reload()
                        })
                        .catch(function(err) {
                            console.log(err)
                        })
                } else {
                    General.showToast('error', 'Bahan sudah dipotong, silahkan pilih yang lain')
                    return
                }
            })
            .catch(function(err) {
                console.log(err)
            })
    })

    /* handle form take wos */
    $("#form_take_wos").on('submit', function(e) {
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

        axios.post(`/api/wos/${id}/take`, takedWos)
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
    })

    /* handle form setor wos */
    $("#form_return_wos").on('submit', function(e) {
        e.preventDefault()

        const id = $("#id_wos_returned").val()
        const returnedWos = {
            tanggal_kembali: General.convertToDatetimeSql($("#tanggal_kembali").val()),
            jumlah_kembali: $("#jumlah_kembali").val()
        }

        axios.post(`/api/wos/${id}/setor`, returnedWos)
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
    })

    function handleButtonsClick() {
        /* handle tombol ambil wos */
        $("#list_wos tbody").on("click", "tr button.btn-warning", function(e) {
            const id = datatable.row($(this).parent().parent()).data().id

            $("#id_wos_taked").val(id)
            $("#modal_take_wos").modal('toggle')
        })
        /* handle tombol kembalikan wos */
        $("#list_wos tbody").on("click", "tr button.btn-success", function(e) {
            const id = datatable.row($(this).parent().parent()).data().id

            axios.get(`/api/wos/${id}`)
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
        })
    }

    function handleModalShowCreateWos(e) {
        /* load barang */
        General.resetSelect2('#kode_barang')
        axios.get('/api/barang')
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

        /* load nama_bahan */
        General.resetSelect2('#nama_bahan')
        axios.get('/api/jenis/bahan/get/nama')
            .then(function(res) {
                const listNamaBahan = res.data.data
                listNamaBahan.forEach(function(bahan) {
                    const option = new Option(`${bahan.nama}`, `${bahan.nama}`, false, false)
                    $("#nama_bahan").append(option).trigger('change')
                })
            })
            .catch(function(err) {
                console.log(err)
            })
        
        $('#nama_bahan').on('select2:select', function(e) {
            const selectedNamaBahan = e.params.data.id
            if (selectedNamaBahan != 0) {
                General.resetSelect2('#warna_bahan')
                axios.get(`/api/jenis/bahan/get/warna?nama=${selectedNamaBahan}`)
                    .then(function(res) {
                        $('#warna_bahan').parent().show()
                        const listWarnaBahan = res.data.data
                        listWarnaBahan.forEach(function(bahan) {
                            const option = new Option(`${bahan.warna}`, `${bahan.warna}`, false, false)
                            $('#warna_bahan').append(option).trigger('change')
                        })
                    })
                    .catch(function(err) {
                        console.log(err)
                    })   
            } else {
                $('#warna_bahan').parent().hide()
                $('#yard_bahan').parent().hide()
            }
        })

        $('#warna_bahan').on('select2:select', function(e) {
            const selectedNamaBahan = $('#nama_bahan').find(':selected').val()
            const selectedWarnaBahan = e.params.data.id
            
            if (selectedNamaBahan != 0 && selectedWarnaBahan != 0) {
                General.resetSelect2('#yard_bahan')
                const url = `/api/bahan/get/yard?nama=${selectedNamaBahan}&warna=${selectedWarnaBahan}`
                axios.get(url)
                    .then(function(res) {
                        $('#yard_bahan').parent().show()
                        const listYard = res.data.data
                        listYard.forEach(function(bahan) {
                            const option = new Option(`${bahan.yard}`, `${bahan.id}`, false, false)
                            $('#yard_bahan').append(option).trigger('change')
                        })
                    })
                    .catch(function(err) {
                        console.log(err)
                    })
            } else {
                $('#yard_bahan').parent().hide()
            }
        })
    }

    function handleModalHideCreateWos(e) {
        $('#kode_barang').html('')
        $('#nama_bahan').html('')
        $('#warna_bahan').html('')
        $('#yard_bahan').html('')

        $('#warna_bahan').parent().hide()
        $('#yard_bahan').parent().hide()
    }
})