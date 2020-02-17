$(function() {
    /* handle list penjahit */
    let datatable = $("#list_penjahit").DataTable({
        initComplete: function(settings, json) {
            handleButtonsClick()
        },
        ajax: function(data, callback, settings) {
            axios.get('/api/penjahit')
                .then(function(res) {
                    const allPenjahit = []
                    res.data.data.forEach(function(penjahit, index) {
                        const modelPenjahit = new ModelPenjahit(
                            penjahit.no_ktp,
                            penjahit.nama_lengkap,
                            penjahit.no_hp,
                            penjahit.alamat,
                            penjahit.created_at,
                            penjahit.updated_at
                        )
                        modelPenjahit.setNumbering(index + 1)
                        allPenjahit.push(modelPenjahit.getUIData())
                    })
                    const dataPenjahit = {
                        data: allPenjahit
                    }
                    callback(dataPenjahit)
                })
        },
        columns: [
            { data: "no" },
            { data: "no_ktp" },
            { data: "nama_lengkap" },
            { data: "no_hp" },
            { data: "alamat" },
            { data: "created_at" },
            {
                data: null,
                className: 'text-center',
                defaultContent: '<button type="button" class="btn btn-primary btn-sm mr-2"><i class="fas fa-eye"></i></button><button type="button" class="btn btn-info btn-sm mr-2"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>'
            }
        ]
    })
    
    /* handle form create penjahit */
    $("#form_create_penjahit").submit(function(e) {
        e.preventDefault()
        const newPenjahit = {
            no_ktp: $("#no_ktp").val(),
            nama_lengkap: $("#nama_lengkap").val(),
            no_hp: $("#no_hp").val(),
            alamat: $("#alamat").val()
        }

        axios.post('/api/penjahit', newPenjahit)
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
    })

    function handleButtonsClick() {
        $("#list_penjahit tbody").on("click", "tr button.btn-primary", function(e) {
            const no_ktp = datatable.row($(this).parent().parent()).data().no_ktp
            
            axios.get(`/api/penjahit/${no_ktp}`)
                .then(function(res) {
                    moment.locale("id")
                    $("#dt_no_ktp").html(res.data.data.no_ktp)
                    $("#dt_nama_lengkap").html(res.data.data.nama_lengkap)
                    $("#dt_no_hp").html(res.data.data.no_hp)
                    $("#dt_alamat").html(res.data.data.alamat)
                    $("#dt_created_at").html(General.convertToMomentFormat(res.data.data.created_at))
                    $("#dt_updated_at").html(General.convertToMomentFormat(res.data.data.updated_at))
                    $("#modal_show_penjahit").modal('toggle')
                })
                .catch(function(err) {
                    console.log(err)
                })
        })
    }
})