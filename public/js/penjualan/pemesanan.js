$(function() {
    let datatable = $("#list_pemesanan").DataTable({
        initComplete: function(settings, json) {
            
        },
        pageLength: 100,
        ajax: '/api/v1/penjualan/pemesanan',
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
})