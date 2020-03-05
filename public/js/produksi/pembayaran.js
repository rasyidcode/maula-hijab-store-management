$(function() {
    let datatable = $("#list_pembayaran").DataTable({
        // processing: true,
        // serverSide: true,
        initComplete: function(settings, json) {
            $("#list_pembayaran tbody").on("click", "tr button.btn-success", function(e) {
                let result = confirm('Bayar sekarang?')
                if (result) {
                    const id = datatable.row($(this).parent().parent()).data().id
                    axios.post(`/api/v1/wos/${id}/payment`, null, { headers: General.getHeaders() })
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
        },
        pageLength: 100,
        ajax: {
            url: '/api/v1/wos/payment/list',
            type: 'GET',
            headers: General.getHeaders()
        },
        columns: [
            { data: "id", visible: false },
            {
                data: "tanggal_bayar",
                defaultContent: '<i class="text-muted">belum</i>',
                render: function(data, type, row, meta) {
                    return General.convertToMomentFormat(data)
                }
            },
            { data: "nama_lengkap" },
            { data: "kode_barang" },
            { data: "kode_kain" },
            { data: "jumlah_kembali" },
            {
                data: "harga_jahit",
                render: function(data, type, row, meta) {
                    return General.rupiahFormat(data, '')
                }
            },
            {
                data: "total_pembayaran",
                render: function(data, type, row, meta) {
                    return General.rupiahFormat(data, '')
                }
            },
            {
                data: "status_bayar",
                render: function(data, type, row, meta) {
                    return '<span class="badge '+ (data === 1 ? 'badge-success' : 'badge-danger') +'">'+ (data === 1 ? 'Sudah dibayar' : 'Belum dibayar') +'</span>'
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                defaultContent: '<button type="button" class="btn btn-success btn-sm mr-2"><i class="fas fa-money-bill-alt mr-2"></i>Bayar</button>'
            }
        ]
    })
})