$(function() {
    let datatable = $("#list_pemesanan").DataTable({
        initComplete: function(settings, json) {
            // something
        },
        pageLength: 100,
        ajax: {
            url: '/api/v1/penjualan/pemesanan',
            type: 'GET',
            headers: General.getHeaders()
        },
        columns: [
            { data: "id", visible: false },
            { data: "metode_pemesanan" },
            { data: "no_pemesanan" },
            { data: "no_resi" },
            { data: "shipping_provider" },
            { 
                data: "total_pembayaran",
                render: function(data, type, row, meta) {
                    return General.rupiahFormat(data, '')
                }
            },
            { data: "alamat_pengiriman" },
            { data: "no_hp" },
            {
                data: "produk",
                render: function(data, type, row, meta) {
                    let orderedProduk = "";

                    data.forEach(function(produk) {
                        orderedProduk += `${produk.no_referensi_sku}, `
                    })

                    return orderedProduk;
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
    })

    $("#button_create_pemesanan").click(function(e) {
        alert('Saat ini belum bisa manual')
    })
    $("#button_export_data").click(function(e) {
        $("#modal_export_data").modal('toggle')
    })
    $("#form_export_data").submit(function(e) {
        e.preventDefault();
        const file = document.querySelector('#file_data').files[0]
        
        const formData = new FormData()
        formData.append("data_file", file)

        axios.post('/api/v1/penjualan/upload', formData, 
            { 
                headers: {
                        'Authorization': `${General.getCreds().token_type} ${General.getCreds().access_token}`,
                        'Content-Type': 'multipart/form-data'
                    }
                }
            )
            .then(function(res) {
                General.showToast('success', 'Berhasil di export!', 5000)
                $("#modal_export_data").modal('toggle')
                datatable.ajax.reload()
            })
            .catch(function(err) {
                General.showToast('error', err.response.data.message)
            })
    })
})