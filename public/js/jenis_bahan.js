$(function() {
    const routeList = window.location.origin + "/api/jenis/bahan"
    const routeCreate = window.location.origin + "/api/jenis/bahan"
    let datatable = null
    /* list jenis_bahan */
    axios.get(routeList)
        .then(function(res) {
            const options = {
                data: res.data.data,
                columns: [
                    { data: "kode" },
                    { data: "nama" },
                    { data: "warna" },
                    { data: "created_at" },
                    {
                        data: null,
                        className: 'text-center',
                        defaultContent: '<button type="button" class="btn btn-primary btn-sm mr-2"><i class="fas fa-eye"></i></button><a class="btn btn-info btn-sm mr-2" href="#"><i class="fas fa-pencil-alt"></i></a><a class="btn btn-danger btn-sm" href="#"><i class="fas fa-trash"></i></a>'
                    }
                ]
            }

            datatable = $("#list_jenis_bahan").DataTable(options);
        })
        .catch(function(err) {
            console.log(err)
        })
        .then(function() {
            $("#list_jenis_bahan tbody").on("click", "tr", function () {
                const kode = datatable.row( this ).data().kode
                const url = window.location.origin + `/api/jenis/bahan/${kode}`

                axios.get(url)
                    .then(function(res) {
                        $("#dt_kode").html(res.data.data.kode)
                        $("#dt_nama").html(res.data.data.nama)
                        $("#dt_warna").html(res.data.data.warna)
                        $("#dt_created_at").html(res.data.data.created_at)
                        $("#dt_updated_at").html(res.data.data.updated_at)
                        $("#dt_used_count").html('Digunakan oleh <a href="#">87 bahan</a>')
                        $("#modal_show_jenis_bahan").modal('toggle')
                    })
                    .catch(function(err) {
                        console.log(err)
                    })
            });
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
})