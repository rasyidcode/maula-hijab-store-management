$(function() {
    let currentRoute = window.location.pathname
    let routes = currentRoute.split("/")
    if (!routes.includes("tambah") && !routes.includes("edit")) {
        handleListBahanPage()
        /* modal detail bahan */
        $("#modal_bahan_detail").on("show.bs.modal", function(e) {
            const link = e.relatedTarget.dataset
            const url = `/bahan/${link.id}`
            const headers = [
                {
                    key: "Content-Type",
                    value: "application/json"
                }
            ]
            General.sendRequest(null, url, "GET", headers,
                function onsuccess(xhttp) {
                    const response = JSON.parse(xhttp.responseText)
                    const model_bahan = new ModelBahan(
                        response.data.id,
                        response.data.nama_bahan,
                        General.rupiahFormat(response.data.harga_bahan.toString(), ""),
                        response.data.created_at
                    )
                    const list = document.getElementById("list-detail")
                    Object.keys(model_bahan).forEach(function (key) {
                        if (list.children.length <= 2) {
                            if (key !== "id") {
                                const li = document.createElement("li")
                                const b = document.createElement("b")
                                const a = document.createElement("a")
                                const br = document.createElement("br")
                                li.classList.add("list-group-item")
                                li.setAttribute("id", `#${key}`)
                                b.innerHTML = key
                                a.classList.add("float-left")
                                a.innerHTML = model_bahan[key]
                                li.appendChild(b)
                                li.appendChild(br)
                                li.appendChild(a)
                                list.appendChild(li)   
                            }
                        } else {
                            if (key !== "id") {
                                const li = document.getElementById(`#${key}`)
                                li.children[2].innerHTML = model_bahan[key]
                            }
                        }
                        
                    })
                },
                function onerror(xhttp) {
                    console.log(JSON.parse(xhttp.responseText))   
                }
            )
        })
    } else if (routes.includes("tambah")) {
        handleCreateBahanPage()
    } else if (routes.includes("edit")) {
        handleEditBahanPage(routes[3])
    }

    $('#harga_bahan').keyup(function () {
        $(this).val(General.rupiahFormat($(this).val(), 'Rp. '))
    })

    function clearField() {
        document.getElementById("nama_bahan").value = ""
        document.getElementById("harga_bahan").value = ""
    }

    function handleListBahanPage() {
        const headers = [
            { key: "Content-Type", value: "application/json" }
        ]

        General.sendRequest(null, "/bahan", "GET", headers,
            function onsuccess(xhttp) {
                const data_bahan = JSON.parse(xhttp.responseText)
                const all_bahan = []
                data_bahan.data.forEach(function(bahan) {
                    const model_bahan = new ModelBahan(
                        bahan.id,
                        bahan.nama_bahan,
                        bahan.harga_bahan,
                        bahan.created_at,
                        bahan.updated_at
                    )
                    all_bahan.push(model_bahan.getUIData())
                })
                const options = {
                    data: all_bahan,
                    table_id: "data_bahan",
                    actions: [
                        {
                            type: "modal",
                            action: "#modal_bahan_detail",
                            is_pass_id: true
                        },
                        {
                            type: "link",
                            action: "/persediaan/bahan",
                            is_pass_id: false
                        },
                        {
                            type: "action",
                            action: "/bahan",
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

    function handleCreateBahanPage() {
        $("#form_create_bahan").on("submit", function(e) {
            e.preventDefault()

            const nama_bahan_el = document.getElementById("nama_bahan")
            const harga_bahan_el = document.getElementById("harga_bahan")

            if (nama_bahan_el.value === "" || harga_bahan_el === "") {
                const error_preparation = [
                    { element: nama_bahan_el, message: "Nama bahan tidak boleh kosong" },
                    { element: harga_bahan_el, message: "Harga bahan tidak boleh kosong" }
                ]
                General.handleEmptyField(error_preparation)
            } else {
                General.removeInvalidFeedback(nama_bahan_el)
                General.removeInvalidFeedback(harga_bahan_el)

                const new_data = {
                    nama_bahan: nama_bahan_el.value,
                    harga_bahan: General.removeRupiah(harga_bahan_el.value)
                }
                const route = "/bahan"
                const headers = [
                    { key: "Content-Type", value: "application/json" }
                ]

                General.sendRequest(new_data, route, "POST", headers,
                    function onsuccess(xhttp) {
                        const response = JSON.parse(xhttp.responseText)
                        General.showToast("success", response.message)
                        clearField()
                        setTimeout(function() {
                            window.location.href = window.location.origin + "/persediaan/bahan"
                        }, 3000)
                    },
                    function onerror(xhttp) {
                        const response = JSON.parse(xhttp.responseText)
                        General.showToast("error", response.message)
                        General.handleErrorInput(response.errors,
                            ["nama_barang", "harga_barang"])
                    } 
                )
            }
        })
    }

    function handleEditBahanPage(id) {
        General.sendRequest(null, `/bahan/${id}`, "GET", [{key: "Content-Type", value: "application/json"}],
            function onsuccess(xhttp) {
                const model_bahan = JSON.parse(xhttp.responseText).data
                document.getElementById("nama_bahan").value = model_bahan.nama_bahan
                document.getElementById("harga_bahan").value = General.rupiahFormat(model_bahan.harga_bahan.toString(), "")

                $("#form_edit_bahan").on("submit", function(e) {
                    e.preventDefault()

                    const nama_bahan_el = document.getElementById("nama_bahan")
                    const harga_bahan_el = document.getElementById("harga_bahan")

                    if (nama_bahan_el.value === "" || harga_bahan_el.value === "") {
                        const error_preparation = [
                            { element: nama_bahan_el, message: "Nama bahan tidak boleh kosong" },
                            { element: harga_bahan_el, message: "Harga bahan tidak boleh kosong" }
                        ]
                        General.handleEmptyField(error_preparation)
                    } else {
                        General.removeInvalidFeedback(nama_bahan_el)
                        General.removeInvalidFeedback(harga_bahan_el)

                        model_bahan.nama_bahan = nama_bahan_el.value
                        model_bahan.harga_bahan = General.removeRupiah(harga_bahan_el.value)

                        const route = `/bahan/${id}/edit`
                        const headers = [
                            {
                                key: "Content-Type",
                                value: "application/json"
                            }
                        ]

                        General.sendRequest(model_bahan, route, "POST", headers,
                            function onsuccess(xhttp) {
                                const response = JSON.parse(xhttp.responseText)
                                General.showToast("success", response.message)
                                setTimeout(function () {
                                    window.location.href = window.location.origin + `/persediaan/bahan/${response.data.id}/edit`
                                }, 3000)
                            },
                            function onerror(xhttp) {
                                const response  = JSON.parse(xhttp.responseText)
                                General.showToast("error", response.message)
                                General.handleErrorInput(response.errors,
                                    ["nama_bahan", "harga_bahan"])
                            })
                    }
                })
            },
            function onerror(xhttp) {
                // console.log(JSON.parse(xhttp.responseText))
                window.location.href = window.location.origin + "/error"
            }
        )
    }
})