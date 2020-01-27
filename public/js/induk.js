$(function () {
    $("#form_create_induk").on("submit", function(e) {
        e.preventDefault()

        const kode = document.getElementById("kode").value
        const nama_produk = document.getElementById("nama_produk").value
        const harga_jahit = document.getElementById("harga_jahit").value
        const hpp = document.getElementById("hpp").value

        if (kode === "" || nama_produk === "" || harga_jahit === "" || hpp === "") {
            console.log("field cannot be null!")
        } else {
            const new_data = {
                kode: kode,
                nama_produk: nama_produk,
                harga_jahit: General.removeRupiah(harga_jahit),
                hpp: General.removeRupiah(hpp)
            }
            const route = "/induk"
            const headers = [
                {
                    key: "Content-Type",
                    value: "application/json"
                }
            ]

            General.sendRequest(new_data, route, "POST", headers,
                function onsuccess(xhttp) {
                    const response = JSON.parse(xhttp.responseText)
                    const status = xhttp.status

                    console.log(response)
                    console.log(status)

                    clearField()
                },
                function onerror(xhttp) {
                    console.log(JSON.parse(xhttp.responseText))
                    console.log(xhttp.status)
                }
            )
        }
    })

    $("#form_edit_induk").on("submit", function(e) {
        e.preventDefault()

        const kode = document.getElementById("kode").value
        const nama_produk = document.getElementById("nama_produk").value
        const harga_jahit = document.getElementById("harga_jahit").value
        const hpp = document.getElementById("hpp").value

        if (kode === "" || nama_produk === "" || harga_jahit === "" || hpp === "") {
            console.log("field cannot be null!")
        } else {
            const new_data = {
                kode: kode,
                nama_produk: nama_produk,
                harga_jahit: General.removeRupiah(harga_jahit),
                hpp: General.removeRupiah(hpp)
            }
            const route = `/induk/${kode}/edit`
            const headers = [
                {
                    key: "Content-Type",
                    value: "application/json"
                }
            ]

            General.sendRequest(new_data, route, "POST", headers,
                function onsuccess(xhttp) {
                    const response = JSON.parse(xhttp.responseText)
                    const status = xhttp.status

                    console.log(response)
                    console.log(status)

                    clearField()
                },
                function onerror(xhttp) {
                    console.log(JSON.parse(xhttp.responseText))
                    console.log(xhttp.status)
                }
            )
        }
    })

    $('#harga_jahit').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
    $('#hpp').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })
    function clearField() {
        document.getElementById("kode").value = ""
        document.getElementById("nama_produk").value = ""
        document.getElementById("harga_jahit").value = ""
        document.getElementById("hpp").value = ""
    }
})