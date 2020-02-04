$(function() {
    const routeList = window.location.origin + "/api/jenis/bahan"
    const routeCreate = window.location.origin + "/api/jenis/bahan"
    let datatable = null
    /* list jenis_bahan */
    axios.get(routeList)
        .then(function(res) {
            const allJenisBahan = []
            res.data.data.forEach(function(jenisb) {
                const modelJenisBahan = new JenisBahan(
                    jenisb.kode,
                    jenisb.nama,
                    jenisb.warna,
                    jenisb.created_at,
                    jenisb.updated_at
                )
                allJenisBahan.push(modelJenisBahan.getUIData())
            })
            const options = {
                data: allJenisBahan,
                columns: [
                    { data: "kode" },
                    { data: "nama" },
                    { data: "warna" },
                    { data: "created_at" },
                    {
                        data: null,
                        className: 'text-center',
                        defaultContent: '<button type="button" class="btn btn-primary btn-sm mr-2"><i class="fas fa-eye"></i></button><button type="button" class="btn btn-info btn-sm mr-2"><i class="fas fa-pencil-alt"></i></button><button type="button" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>'
                    }
                ]
            }

            datatable = $("#list_jenis_bahan").DataTable(options);
        })
        .catch(function(err) {
            console.log(err)
        })
        .then(function() {
            $("#list_jenis_bahan tbody tr").on("click", "button.btn-primary", function () {
                const kode = datatable.row($(this).parent().parent()).data().kode
                const url = window.location.origin + `/api/jenis/bahan/${kode}/completed`

                axios.get(url)
                    .then(function(res) {
                        
                        $("#dt_kode").html(res.data.data.kode)
                        $("#dt_nama").html(res.data.data.nama)
                        $("#dt_warna").html(res.data.data.warna)
                        $("#dt_created_at").html(General.convertToReadableFormat(res.data.data.created_at))
                        $("#dt_updated_at").html(General.convertToReadableFormat(res.data.data.updated_at))
                        $("#dt_used_count").html(res.data.data.bahan.length > 0 ? `Digunakan oleh <a href="#">${res.data.data.bahan.length} bahan</a>` : "Belum ada bahan yang pakai.")
                        $("#modal_show_jenis_bahan").modal('toggle')
                    })
                    .catch(function(err) {
                        console.log(err)
                    })
            });

            $("#list_jenis_bahan tbody tr").on("click", "button.btn-info", function() {
                const kode = datatable.row($(this).parent().parent()).data().kode
                const url = window.location.origin + `/api/jenis/bahan/${kode}`

                axios.get(url)
                    .then(function(res) {
                        $("#kode2").val(res.data.data.kode)
                        $("#nama2").val(res.data.data.nama)
                        $("#warna2").val(res.data.data.warna)
                        $("#modal_edit_jenis_bahan").modal('toggle')
                    })
                    .catch(function(err) {
                        console.log(err)
                    })
            })

            $("#list_jenis_bahan tbody tr").on("click", "button.btn-danger", function() {
                let result = confirm("Anda yakin ingin dihapus?")
                if (result) {
                    const kode = datatable.row($(this).parent().parent()).data().kode
                    const url = window.location.origin + `/api/jenis/bahan/${kode}/delete`
                    
                    axios.post(url)
                        .then(function(res) {
                            General.showToast("success", res.data.message)
                            setTimeout(function() {
                                location.reload()
                            }, 3000)
                        })
                        .catch(function(err) {
                            console.log(err)
                            General.showToast("error", err.message)
                        })
                }
            })
        })
    /* handle form tambah jenis_bahan */
    $("#form_create_jenis_bahan").submit(function(e) {
        e.preventDefault()

        const kode = General.spaceRemover($("#nama").val()) + "-" + General.spaceRemover($("#warna").val())
        const newJenisBahan = new JenisBahan(
            kode,
            $("#nama").val(),
            $("#warna").val(),
            null,
            null
        )
        axios.post(routeCreate, newJenisBahan)
            .then(function(res) {
                $("#modal_create_jenis_bahan").modal('toggle')
                General.showToast("success", res.data.message)
                setTimeout(function() {
                    location.reload()
                }, 3000)
            })
            .catch(function(err) {
                console.log(err)
            })
    })

    /* handle form edit jenis_bahan */
    $("#form_edit_jenis_bahan").submit(function(e) {
        e.preventDefault()

        const kode = General.spaceRemover($("#nama2").val()) + "-" + General.spaceRemover($("#warna2").val())
        const editedJenisBahan = new JenisBahan(
            kode,
            $("#nama2").val(),
            $("#warna2").val(),
            null,
            null
        )
        const prevKode = $("#kode2").val()
        const routeEdit = window.location.origin + `/api/jenis/bahan/${prevKode}/edit`

        axios.post(routeEdit, editedJenisBahan)
            .then(function(res) {
                $("#modal_edit_jenis_bahan").modal('toggle')
                General.showToast("success", res.data.message)
                setTimeout(function() {
                    location.reload()
                }, 3000)
            })
            .catch(function(err) {
                console.log(err)
            })
    })
})