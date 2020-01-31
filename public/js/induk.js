$(function () {
    let currentRoute = window.location.pathname
    let routes = currentRoute.split("/")
    if (!routes.includes("tambah") && !routes.includes("edit")) {
        /* TODO 2 : refresh data induk */
        /* TODO 3 : handle pagination */
        /* TODO 4 : handle pagination status */
        handleListIndukPage()
        $("#modal_induk_detail").on("show.bs.modal", function(e) {
            const link = e.relatedTarget.dataset
            const url = `/induk/${link.id}`
            const headers = [
                {
                    key: "Content-Type",
                    value: "application/json"
                }
            ]
            General.sendRequest(null, url, "GET", headers,
                function onsuccess(xhttp) {
                    const response = JSON.parse(xhttp.responseText)
                    const model_induk = new ModelInduk(
                        response.data.kode,
                        response.data.nama_produk,
                        response.data.harga_jahit,
                        response.data.hpp,
                        response.data.created_at
                    )
                    model_induk.setUpdatedAt(response.data.updated_at)
                    model_induk.setTotalBarang(response.data.total_barang == null ? "" : "")

                    const list = document.getElementById("list-detail")
                    Object.keys(model_induk).forEach(function (key) {
                        if (list.children.length <= 7) {
                            const li = document.createElement("li")
                            const b = document.createElement("b")
                            const a = document.createElement("a")
                            const br = document.createElement("br")
                            li.classList.add("list-group-item")
                            li.setAttribute("id", `#${key}`)
                            b.innerHTML = key
                            a.classList.add("float-left")
                            a.innerHTML = model_induk[key]
                            li.appendChild(b)
                            li.appendChild(br)
                            li.appendChild(a)
                            list.appendChild(li)
                        } else {
                            const li = document.getElementById(`#${key}`)
                            li.children[2].innerHTML = model_induk[key]
                        }
                    })
                },
                function onerror(xhttp) {
                    console.log(JSON.parse(xhttp.responseText))   
                }
            )
        })
    } else if (routes.includes("tambah")) {
        handleCreateIndukPage()
    } else if (routes.includes("edit")) {
        handleEditIndukPage(routes[3])
    }

    /* start multi page */
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
    /* end multi page */

    /* start page handler */
    function handleListIndukPage() {
        const headers = [
            {
                key: "Content-Type",
                value: "application/json"
            }
        ]

        General.sendRequest(null, "/induk", "GET", headers,
            function onsuccess(xhttpd) {
                const dataInduk = JSON.parse(xhttpd.responseText)
                const allInduk = []
                dataInduk.data.forEach(function(induk) {
                    const model_induk = new ModelInduk(
                        induk.kode,
                        induk.nama_produk,
                        induk.harga_jahit,
                        induk.hpp,
                        induk.created_at
                    )
                    allInduk.push(model_induk.getUIData())
                })
                const options = { 
                    data: allInduk,
                    table_id: "data_induk",
                    actions: [
                        {
                            type: "modal",
                            action: "#modal_induk_detail",
                            is_pass_id: true
                        },
                        {
                            type: "link",
                            action: "/persediaan/induk",
                            is_pass_id: false
                        },
                        {
                            type: "action",
                            action: "/induk",
                            is_pass_id: false
                        }
                    ]
                }
                General.makeListData(options)
            },
            function onsuccess(xhttpd) {
                console.log(xhttpd.responseText)
                console.log(xhttpd.status)
            }
        )
    }

    function handleCreateIndukPage() {
        $("#form_create_induk").on("submit", function(e) {
            e.preventDefault()
    
            const kode = document.getElementById("kode")
            const nama_produk = document.getElementById("nama_produk")
            const harga_jahit = document.getElementById("harga_jahit")
            const hpp = document.getElementById("hpp")

            if (kode.value === "" || nama_produk.value === "" || harga_jahit.value === "" || hpp.value === "") {
                const error_preparation = [
                    { element: kode, message: "Kode tidak boleh kosong" },
                    { element: nama_produk, message: "Nama produk tidak boleh kosong" },
                    { element: harga_jahit, message: "Harga jahit tidak boleh kosong" },
                    { element: hpp, message: "Hpp tidak boleh kosong" },
                ]
                General.handleEmptyField(error_preparation)
            } else {
                General.removeInvalidFeedback(kode)
                General.removeInvalidFeedback(nama_produk)
                General.removeInvalidFeedback(harga_jahit)
                General.removeInvalidFeedback(hpp)

                const new_data = {
                    kode: kode.value,
                    nama_produk: nama_produk.value,
                    harga_jahit: General.removeRupiah(harga_jahit.value),
                    hpp: General.removeRupiah(hpp.value)
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
                        General.showToast("success", response.message)
                        clearField()
                    },
                    function onerror(xhttp) {
                        const response = JSON.parse(xhttp.responseText)
                        General.showToast("error", response.message)
                        General.handleErrorInput(response.errors,
                            ["kode", "nama_produk", "harga_jahit", "hpp"]
                        )
                    }
                )
            }
        })
    }

    function handleEditIndukPage(kode) {
        General.sendRequest(
            null,
            `/induk/${kode}`,
            "GET",
            [{key: "Content-Type", value: "application/json"}],
            function onsuccess(xhttp) {
                const induk = JSON.parse(xhttp.responseText).data
                document.getElementById("kode").value = induk.kode,
                document.getElementById("nama_produk").value = induk.nama_produk
                document.getElementById("harga_jahit").value = General.rupiahFormat(induk.harga_jahit.toString(), "")
                document.getElementById("hpp").value = General.rupiahFormat(induk.hpp.toString(), "")

                $("#form_edit_induk").on("submit", function(e) {
                    e.preventDefault()
            
                    const kode_el = document.getElementById("kode")
                    const nama_produk_el = document.getElementById("nama_produk")
                    const harga_jahit_el = document.getElementById("harga_jahit")
                    const hpp_el = document.getElementById("hpp")
            
                    if (kode.value === "" || nama_produk.value === "" || harga_jahit.value === "" || hpp.value === "") {
                        const error_preparation = [
                            { element: kode_el, message: "Kode tidak boleh kosong" },
                            { element: nama_produk_el, message: "Nama produk tidak boleh kosong" },
                            { element: harga_jahit_el, message: "Harga jahit tidak boleh kosong" },
                            { element: hpp_el, message: "Hpp tidak boleh kosong" },
                        ]
                        General.handleEmptyField(error_preparation)
                    } else {
                        General.removeInvalidFeedback(kode_el)
                        General.removeInvalidFeedback(nama_produk_el)
                        General.removeInvalidFeedback(harga_jahit_el)
                        General.removeInvalidFeedback(hpp_el)

                        induk.kode = kode_el.value
                        induk.nama_produk = nama_produk_el.value
                        induk.harga_jahit = General.removeRupiah(harga_jahit_el.value)
                        induk.hpp = General.removeRupiah(hpp_el.value)

                        const route = `/induk/${kode}/edit`
                        const headers = [
                            {
                                key: "Content-Type",
                                value: "application/json"
                            }
                        ]
            
                        General.sendRequest(induk, route, "POST", headers,
                            function onsuccess(xhttp) {
                                const response = JSON.parse(xhttp.responseText)
                                General.showToast("success", response.message)
                                setTimeout(function() {
                                    window.location.href = window.location.origin + `/persediaan/induk/${response.data.kode}/edit`
                                }, 3000)
                            },
                            function onerror(xhttp) {
                                const response = JSON.parse(xhttp.responseText)
                                General.showToast("error", response.message)
                                General.handleErrorInput(response.errors,
                                    ["kode", "nama_produk", "harga_jahit", "hpp"]
                                )
                            }
                        )
                    }
                })
            },
            function onerror(xhttp) {
                // console.log(JSON.parse(xhttp.responseText))
                window.location.href = window.location.origin + "/error"
            }
        )
    }
    /* end page handler */
})