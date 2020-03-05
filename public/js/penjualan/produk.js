$(function() {
    let datatable = $("#list_produk").DataTable({
        initComplete: function(settings, json) {
            
        },
        pageLength: 100,
        ajax: {
            url: '/api/v1/penjualan/produk',
            type: 'GET',
            headers: General.getHeaders()
        },
        columns: [
            { data: "id", visible: false },
            {
                data: "pemesanan",
                render: function(data, type, row, meta) {
                    return data.no_pemesanan
                }
            },
            { data: "sku_induk" },
            { data: "nama_produk" },
            { data: "no_referensi_sku" },
            { data: "warna" },
            {
                data: "harga_asli",
                render: function(data, type, row, meta) {
                    return General.rupiahFormat(data, '')
                }
            },
            { data: "jumlah_pesanan" },
            {
                data: "total_harga_produk",
                render: function(data, type, row, meta) {
                    return General.rupiahFormat(data, '')
                }
            },
            {
                data: "total_diskon",
                render: function(data, type, row, meta) {
                    return General.rupiahFormat(data, '')
                }
            }
        ]
    })
})