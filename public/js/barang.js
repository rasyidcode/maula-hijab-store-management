$(function() {
    let currentRoute = window.location.pathname
    let routes = currentRoute.split("/")
    if (!routes.includes("tambah") && !routes.includes("edit")) {
        handleListBarangPage()
    } else if (routes.includes("tambah")) {
        handleCreateBarangPage()
    } else if (routes.includes("edit")) {
        handleEditBarangPage(routes[3])
    }

    function clearField() {
        document.getElementById("kode").value = ""
        document.getElementById("select_induk_list").value = ""
        document.getElementById("warna").value = ""
        document.getElementById("stok").value = ""
        document.getElementById("treshold").value = ""
        document.getElementById("select_bahan_list").value = ""
    }

    function handleListBarangPage() {
        const headers = [
            { key: "Content-Type", value: "application/json" }
        ]

        General.sendRequest(null, "/barang/completed", "GET", headers,
            function onsuccess(xhttp) {
                const data_barang = JSON.parse(xhttp.responseText)
                const all_barang = []
                data_barang.data.forEach(function(barang) {
                    const model_barang = new ModelBarang(
                        barang.kode,
                        barang.kode_induk,
                        barang.warna,
                        barang.stok,
                        barang.treshold,
                        barang.id_bahan,
                        barang.created_at,
                        barang.updated_at,
                        barang.induk,
                        barang.bahan
                    )
                    all_barang.push(model_barang.getUIData())
                })
                const options = {
                    data: all_barang,
                    table_id: "data_barang",
                    actions: [
                        {
                            type: "modal",
                            action: "#modal_barang_detail",
                            is_pass_id: true
                        },
                        {
                            type: "link",
                            action: "/persediaan/barang",
                            is_pass_id: false
                        },
                        {
                            type: "action",
                            action: "/barang",
                            is_pass_id: false
                        }
                    ]
                }
                General.makeListData(options)
            },
            function onerror(xhttp) {
                console.log(JSON.parse(xhttp.responseText))
            })
    }

    function handleCreateBarangPage() {
        const headers = [
            { key: "Content-Type", value: "application/json" }
        ]
        /* get all induk */
        General.sendRequest(null, "/induk", "GET", headers, 
            function onsuccess(xhttp) {
                const resp_induk = JSON.parse(xhttp.responseText)
                resp_induk.data.forEach(function (induk) {
                    const model_induk = new ModelInduk(
                        induk.kode,
                        induk.nama_produk,
                        induk.harga_jahit,
                        induk.hpp,
                        induk.created_at,
                        induk.updated_at
                    )
                    const option = document.createElement("option")
                    option.setAttribute("value", model_induk.kode)
                    option.innerHTML = model_induk.nama_produk
                    document.getElementById("select_induk_list").appendChild(option)
                })
            },
            function onerror(xhttp) {
                const resp_err_induk = JSON.parse(xhttp.responseText)
                console.log(resp_err_induk)
            }
        )
        /* get all bahan */
        General.sendRequest(null, "/bahan", "GET", headers, 
            function onsuccess(xhttp) {
                const resp_bahan = JSON.parse(xhttp.responseText)
                resp_bahan.data.forEach(function(bahan) {
                    const model_bahan = new ModelBahan(
                        bahan.id,
                        bahan.nama_bahan,
                        bahan.harga_bahan,
                        bahan.created_at,
                        bahan.updated_at
                    )
                    const option = document.createElement("option")
                    option.setAttribute("value", model_bahan.id)
                    option.innerHTML = model_bahan.nama_bahan
                    document.getElementById("select_bahan_list").appendChild(option)
                })
            },
            function onerror(xhttp) {
                const resp_err_bahan = JSON.parse(xhttp.responseText)
                console.log(resp_err_bahan)
            }
        )
        /* handle onsubmit */
        $("#form_create_barang").on("submit", function(e) {
            e.preventDefault()
            
            const kode_el = document.getElementById("kode")
            const kode_induk_el = document.getElementById("select_induk_list")
            const warna_el = document.getElementById("warna")
            const stok_el = document.getElementById("stok")
            const treshold_el = document.getElementById("treshold")
            const bahan_id_el = document.getElementById("select_bahan_list")

            if (kode_el.value === "" || 
                kode_induk_el.options[kode_induk_el.selectedIndex].value === "" || 
                warna_el.value === "" || stok_el.value === "" || treshold_el.value === "" || 
                bahan_id_el.options[bahan_id_el.selectedIndex].value === "") {
                    const error_preparation = [
                        { element: kode_el, message: "Kode tidak boleh kosong" },
                        { element: kode_induk_el, message: "Pilih salah satu induk produk" },
                        { element: warna_el, message: "Warna tidak boleh kosong" },
                        { element: stok_el, message: "Stok tidak boleh kosong" },
                        { element: treshold_el, message: "Treshold tidak boleh kosong" },
                        { element: bahan_id_el, message: "Pilih salah satu bahan" }
                    ]
                    General.handleEmptyField(error_preparation)
            } else {
                General.removeInvalidFeedback(kode_el)
                General.removeInvalidFeedback(kode_induk_el)
                General.removeInvalidFeedback(warna_el)
                General.removeInvalidFeedback(stok_el)
                General.removeInvalidFeedback(treshold_el)
                General.removeInvalidFeedback(bahan_id_el)

                const new_barang = new ModelBarang(
                    kode_el.value,
                    kode_induk_el.options[kode_induk_el.selectedIndex].value,
                    warna_el.value,
                    stok_el.value,
                    treshold_el.value,
                    bahan_id_el.options[bahan_id_el.selectedIndex].value,
                    null,
                    null,
                    null,
                    null
                )
                
                General.sendRequest(new_barang, "/barang", "POST", headers,
                    function onsuccess(xhttp) {
                        const response = JSON.parse(xhttp.responseText)
                        General.showToast("success", response.message)
                        clearField()
                        setTimeout(function() {
                            window.location.href = window.location.origin + "/persediaan/barang"
                        }, 3000)
                    },
                    function onerror(xhttp) {
                        const response = JSON.parse(xhttp.responseText)
                        console.log(response)
                        General.showToast("error", response.message)
                        General.handleErrorInput(response.errors,
                            ["kode", "kode_induk", "warna", "stok", "treshold", "bahan"])
                    }
                )
            }
        })
    }

    function handleEditBarangPage(kode_barang) {
        const headers = [
            { key: "Content-Type", value: "application/json" }
        ]
        General.sendRequest(null, `/barang/${kode_barang}/completed`, "GET", headers,
            function onsuccess(xhttp) {
                const resp_barang_completed = JSON.parse(xhttp.responseText).data
                const model_barang_det = new ModelBarang(
                    resp_barang_completed.kode,
                    resp_barang_completed.kode_induk,
                    resp_barang_completed.warna,
                    resp_barang_completed.stok,
                    resp_barang_completed.treshold,
                    resp_barang_completed.id_bahan,
                    resp_barang_completed.created_at,
                    resp_barang_completed.updated_at,
                    resp_barang_completed.induk,
                    resp_barang_completed.bahan
                )
                document.querySelector("#kode").value = model_barang_det.kode
                document.querySelector("#warna").value = model_barang_det.warna
                document.querySelector("#stok").value = model_barang_det.stok
                document.querySelector("#treshold").value = model_barang_det.treshold

                 /* get all induk */
                General.sendRequest(null, "/induk", "GET", headers, 
                    function onsuccess(xhttp) {
                        const resp_induk = JSON.parse(xhttp.responseText)
                        resp_induk.data.forEach(function (induk) {
                            const model_induk = new ModelInduk(
                                induk.kode,
                                induk.nama_produk,
                                induk.harga_jahit,
                                induk.hpp,
                                induk.created_at,
                                induk.updated_at
                            )
                            const option = document.createElement("option")
                            option.setAttribute("value", model_induk.kode)
                            option.innerHTML = model_induk.nama_produk
                            document.getElementById("select_induk_list").appendChild(option)
                        })

                        document.querySelector("#select_induk_list").querySelector(`option[value=${model_barang_det.kode_induk}]`).setAttribute("selected", "true")
                    },
                    function onerror(xhttp) {
                        const resp_err_induk = JSON.parse(xhttp.responseText)
                        console.log(resp_err_induk)
                    }
                )
                /* get all bahan */
                General.sendRequest(null, "/bahan", "GET", headers, 
                    function onsuccess(xhttp) {
                        const resp_bahan = JSON.parse(xhttp.responseText)
                        resp_bahan.data.forEach(function(bahan) {
                            const model_bahan = new ModelBahan(
                                bahan.id,
                                bahan.nama_bahan,
                                bahan.harga_bahan,
                                bahan.created_at,
                                bahan.updated_at
                            )
                            const option = document.createElement("option")
                            option.setAttribute("value", model_bahan.id)
                            option.innerHTML = model_bahan.nama_bahan
                            document.getElementById("select_bahan_list").appendChild(option)
                        })
                        document.querySelector("#select_bahan_list").querySelector(`option[value="${model_barang_det.id_bahan}"]`).setAttribute("selected", "true")
                    },
                    function onerror(xhttp) {
                        const resp_err_bahan = JSON.parse(xhttp.responseText)
                        console.log(resp_err_bahan)
                    }
                )
            },
            function onerror(xhttp) {
                const res_barang_error = JSON.parse(xhttp.responseText)
                console.log(res_barang_error)
            }
        )
        /* handle onsubmit */
        $("#form_edit_barang").on("submit", function(e) {
            e.preventDefault()
            
            const kode_el = document.getElementById("kode")
            const kode_induk_el = document.getElementById("select_induk_list")
            const warna_el = document.getElementById("warna")
            const stok_el = document.getElementById("stok")
            const treshold_el = document.getElementById("treshold")
            const bahan_id_el = document.getElementById("select_bahan_list")

            if (kode_el.value === "" || 
                kode_induk_el.options[kode_induk_el.selectedIndex].value === "" || 
                warna_el.value === "" || stok_el.value === "" || treshold_el.value === "" || 
                bahan_id_el.options[bahan_id_el.selectedIndex].value === "") {
                    const error_preparation = [
                        { element: kode_el, message: "Kode tidak boleh kosong" },
                        { element: kode_induk_el, message: "Pilih salah satu induk produk" },
                        { element: warna_el, message: "Warna tidak boleh kosong" },
                        { element: stok_el, message: "Stok tidak boleh kosong" },
                        { element: treshold_el, message: "Treshold tidak boleh kosong" },
                        { element: bahan_id_el, message: "Pilih salah satu bahan" }
                    ]
                    General.handleEmptyField(error_preparation)
            } else {
                General.removeInvalidFeedback(kode_el)
                General.removeInvalidFeedback(kode_induk_el)
                General.removeInvalidFeedback(warna_el)
                General.removeInvalidFeedback(stok_el)
                General.removeInvalidFeedback(treshold_el)
                General.removeInvalidFeedback(bahan_id_el)

                const new_barang = new ModelBarang(
                    kode_el.value,
                    kode_induk_el.options[kode_induk_el.selectedIndex].value,
                    warna_el.value,
                    stok_el.value,
                    treshold_el.value,
                    bahan_id_el.options[bahan_id_el.selectedIndex].value,
                    null,
                    null,
                    null,
                    null
                )
                
                General.sendRequest(new_barang, `/barang/${kode_barang}/edit`, "POST", headers,
                    function onsuccess(xhttp) {
                        const response = JSON.parse(xhttp.responseText)
                        General.showToast("success", response.message)
                        // clearField()
                        setTimeout(function() {
                            window.location.href = window.location.origin + "/persediaan/barang"
                        }, 3000)
                    },
                    function onerror(xhttp) {
                        const response = JSON.parse(xhttp.responseText)
                        console.log(response)
                        General.showToast("error", response.message)
                        General.handleErrorInput(response.errors,
                            ["kode", "kode_induk", "warna", "stok", "treshold", "bahan"])
                    }
                )
            }
        })
    }
})