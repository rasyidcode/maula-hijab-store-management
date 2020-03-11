$(function() {
    const $loadingWarna = $("#warna_loading")
    const $loadingBahan = $("#bahan_loading")

    let start = 0;
    let start2 = 0;

    let length = 5;
    let length2 = 5;

    let currentCounter = []
    let currentCounter2 = []

    const pagination = $('#list_warna').parent().next().find('.pagination')
    const pagination2 = $('#list_bahan').parent().next().find('.pagination')

    loadListWarna()
    loadListBahan()

    pagination.find('li').first().find('a').click(function(e) {
        e.preventDefault()

        if (!$(this).hasClass('disabled') && start > 0) {
            start -= 5
            $loadingWarna.show()
            axios.get(`/api/v1/warna/all/paginate?start=${start}&length=${length}`, { headers: General.getHeaders() })
                .then(function(res){
                    const tbody = $("#list_warna").find('tbody')
                    tbody.html('')

                    if (start == 0) {
                        pagination.find('li').first().addClass('disabled')
                        pagination.find('li').last().removeClass('disabled')
                    } else {
                        pagination.find('li').last().removeClass('disabled')
                    }

                    const firstIndex = currentCounter[0] - 5
                    currentCounter = []

                    res.data.data.forEach(function(warna, index) {
                        currentCounter.push(firstIndex + index)    
                        tbody.append($(`<tr>
                                            <td style="display:none;">${warna.id}</td>
                                            <td>${currentCounter[index]}.</td>
                                            <td>${warna.name}</td>
                                            <td class="text-center">
                                                <i style="color: ${warna.hex_code};" class="fas fa-square"></i>
                                            </td>
                                        </tr>`))
                    })

                    setTimeout(function() {
                        $loadingWarna.hide()
                    }, 500)
                })
                .catch(function(err) {
                    console.log(err)
                })
        }
    })
    pagination.find('li').last().find('a').click(function(e) {
        e.preventDefault()

        if (!$(this).hasClass('disabled')) {
            pagination.find('li').first().removeClass('disabled')

            start += 5
            $loadingWarna.show()
            axios.get(`/api/v1/warna/all/paginate?start=${start}&length=${length}`, { headers: General.getHeaders() })
                .then(function(res){
                    const tbody = $("#list_warna").find('tbody')
                    tbody.html('')
                    
                    const next = start + 5
                    if (res.data.data.length <= 5 && next >= res.data.total_records) {
                        pagination.find('li').last().addClass('disabled')
                    } else {
                        pagination.find('li').last().removeClass('disabled')
                    }

                    const lastCounter = currentCounter[currentCounter.length - 1]
                    currentCounter = []

                    res.data.data.forEach(function(warna, index) {
                        currentCounter.push(lastCounter + (index + 1))
                        tbody.append($(`<tr>
                                            <td style="display:none;">${warna.id}</td>
                                            <td>${currentCounter[index]}.</td>
                                            <td>${warna.name}</td>
                                            <td class="text-center">
                                                <i style="color: ${warna.hex_code};" class="fas fa-square"></i>
                                            </td>
                                        </tr>`))
                    })
                    setTimeout(function() {
                        $loadingWarna.hide()
                    }, 500)
                })
                .catch(function(err) {
                    console.log(err)
                })
        }
    })

    pagination2.find('li').first().find('a').click(function(e) {
        e.preventDefault()

        if (!$(this).hasClass('disabled') && start2 > 0) {
            start2 -= 5
            $loadingBahan.show()
            axios.get(`/api/v1/bahan/all/paginate?start=${start2}&length=${length2}`, { headers: General.getHeaders() })
                .then(function(res){
                    const tbody = $("#list_bahan").find('tbody')
                    tbody.html('')

                    if (start == 0) {
                        pagination2.find('li').first().addClass('disabled')
                        pagination2.find('li').last().removeClass('disabled')
                    } else {
                        pagination2.find('li').last().removeClass('disabled')
                    }

                    const firstIndex = currentCounter2[0] - 5
                    currentCounter2 = []

                    res.data.data.forEach(function(bahan, index) {
                        currentCounter2.push(firstIndex + index)    
                        tbody.append($(`<tr>
                                            <td style="display:none;">${bahan.id}</td>
                                            <td>${currentCounter2[index]}.</td>
                                            <td>${bahan.nama}</td>
                                            <td class="text-center">${bahan.deskripsi}</td>
                                        </tr>`))
                    })

                    setTimeout(function() {
                        $loadingBahan.hide()
                    }, 500)
                })
                .catch(function(err) {
                    console.log(err)
                })
        }
    })
    pagination2.find('li').last().find('a').click(function(e) {
        e.preventDefault()

        if (!$(this).hasClass('disabled')) {
            pagination2.find('li').first().removeClass('disabled')

            start2 += 5
            $loadingBahan.show()
            axios.get(`/api/v1/bahan/all/paginate?start=${start2}&length=${length2}`, { headers: General.getHeaders() })
                .then(function(res){
                    const tbody = $("#list_bahan").find('tbody')
                    tbody.html('')
                    
                    const next = start2 + 5
                    if (res.data.data.length <= 5 && next >= res.data.total_records) {
                        pagination2.find('li').last().addClass('disabled')
                    } else {
                        pagination2.find('li').last().removeClass('disabled')
                    }

                    const lastCounter = currentCounter2[currentCounter2.length - 1]
                    currentCounter2 = []

                    res.data.data.forEach(function(bahan, index) {
                        currentCounter2.push(lastCounter + (index + 1))
                        tbody.append($(`<tr>
                                            <td style="display:none;">${bahan.id}</td>
                                            <td>${currentCounter2[index]}.</td>
                                            <td>${bahan.nama}</td>
                                            <td>${bahan.deskripsi}</td>
                                        </tr>`))
                    })
                    setTimeout(function() {
                        $loadingBahan.hide()
                    }, 500)
                })
                .catch(function(err) {
                    console.log(err)
                })
        }
    })

    $("#button_create_warna").click(function(e) {
        $("#modal_create_warna").modal('toggle')
    })

    $("#button_create_bahan").click(function(e) {
        $("#modal_create_bahan").modal('toggle')
    })

    $("#form_create_warna").submit(function(e) {
        e.preventDefault()
        const formData = new FormData()
        formData.append('name', $(this).find('#name').val())
        formData.append('hex_code', $(this).find('#hex_code').val())

        if (formData.get('hex_code') == undefined || formData.get('hex_code') == '') {
            formData.delete('hex_code')
        }
        
        axios.post('/api/v1/warna', formData, { headers: General.getHeaders() })
            .then(function(res) {
                General.resetElementsField([
                    { selector: '#name', type: 'text' },
                    { selector: '#hex_code', type: 'text' },
                ])
                General.showToast('success', res.data.message)
                $("#modal_create_warna").modal('toggle')
                location.reload()
            })
            .catch(function(err) {
                General.showToast('error', err.response.data.errors.name[0])
            })
    })

    $("#form_create_bahan").submit(function(e) {
        e.preventDefault()
        const formData = new FormData()
        formData.append('nama', $(this).find('#nama_bahan').val())
        formData.append('deskripsi', $(this).find('#deskripsi').val())

        if (formData.get('deskripsi') == undefined || formData.get('deskripsi') == '') {
            formData.delete('deskripsi')
        }
        
        axios.post('/api/v1/bahan', formData, { headers: General.getHeaders() })
            .then(function(res) {
                General.resetElementsField([
                    { selector: '#nama_bahan', type: 'text' },
                    { selector: '#deskripsi', type: 'textarea' },
                ])
                General.showToast('success', res.data.message)
                $("#modal_create_bahan").modal('toggle')
                location.reload()
            })
            .catch(function(err) {
                General.showToast('error', err.response.data.errors.name[0])
            })
    })

    $("#form_edit_warna").submit(function(e) {
        e.preventDefault()
        
        const formData = new FormData()
        formData.append('name', $(this).find('#name2').val())
        formData.append('hex_code', $(this).find('#hex_code2').val())

        if (formData.get('hex_code') == undefined || formData.get('hex_code') == '') {
            formData.delete('hex_code')
        }

        const id = $("#id_warna_edit").val()
        axios.post(`/api/v1/warna/${id}/edit`, formData, { headers: General.getHeaders() })
            .then(function(res) {
                General.showToast('success', res.data.message)
                setTimeout(function() {
                    location.reload()
                }, 3000)
            })
            .catch(function(err) {
                console.log(err)
            })
    })

    $("#form_edit_bahan").submit(function(e) {
        e.preventDefault()
        
        const formData = new FormData()
        formData.append('nama', $(this).find('#nama_bahan2').val())
        formData.append('deskripsi', $(this).find('#deskripsi2').val())

        if (formData.get('deskripsi') == undefined || formData.get('deskripsi') == '') {
            formData.delete('deskripsi')
        }

        const id = $("#id_bahan_edit").val()
        axios.post(`/api/v1/bahan/${id}/edit`, formData, { headers: General.getHeaders() })
            .then(function(res) {
                General.showToast('success', res.data.message)
                setTimeout(function() {
                    General.resetElementsField([
                        { selector: '#nama_bahan2', type: 'text' },
                        { selector: '#deskripsi2', type: 'textarea' },
                    ])
                    location.reload()
                }, 3000)
            })
            .catch(function(err) {
                console.log(err)
            })
    })

    let timer = 0;
    let delay = 200;
    let prevent = false

    $("#list_warna tbody").delegate("tr", "click", function(){
        const row = $(this)
        timer = setTimeout(function() {
            if (!prevent) {
                edit(row)
            }
            prevent = false
        }, delay)
    });
    $("#list_warna tbody").delegate("tr", "dblclick", function(){
        const row = $(this)
        clearTimeout(timer)
        prevent = true
        remove(row)
    });

    $("#list_bahan tbody").delegate("tr", "click", function(){
        const row = $(this)
        timer = setTimeout(function() {
            if (!prevent) {
                edit2(row)
            }
            prevent = false
        }, delay)
    });
    $("#list_bahan tbody").delegate("tr", "dblclick", function(){
        const row = $(this)
        clearTimeout(timer)
        prevent = true
        remove2(row)
    });

    async function loadListWarna() {
        $loadingWarna.show()

        try {
            const url = `/api/v1/warna/all/paginate?start=${start}&length=${length}`
            const res = await axios.get(url, { headers: General.getHeaders() })
            const { data } = res

            const tbody = $("#list_warna").find('tbody')

            const next = start + 5
            if (res.data.data.length <= 5 && next >= res.data.total_records) {
                pagination.find('li').last().addClass('disabled')
            } else {
                pagination.find('li').last().removeClass('disabled')
            }

            data.data.forEach(function(warna, index) {
                currentCounter.push(index + 1)
                tbody.append($(warnaRow(index, warna, currentCounter)))
            })

            pagination.find('li').first().addClass('disabled')

            setTimeout(function() {
                $loadingWarna.hide()
            }, 500)
        } catch(err) {
            console.log(err)
        }
    }

    async function loadListBahan() {
        $loadingBahan.show()
        try {
            const url = `/api/v1/bahan/all/paginate?start=${start2}&length=${length2}`
            const res = await axios.get(url, { headers: General.getHeaders() })
            const { data } = res

            const tbody = $("#list_bahan").find('tbody')

            const next = start2 + 5
            if (res.data.data.length <= 5 && next >= res.data.total_records) {
                pagination2.find('li').last().addClass('disabled')
            } else {
                pagination2.find('li').last().removeClass('disabled')
            }

            data.data.forEach(function(bahan, index) {
                currentCounter2.push(index + 1)
                tbody.append($(bahanRow(index, bahan, currentCounter2)))
            })

            pagination2.find('li').first().addClass('disabled')

            setTimeout(function() {
                $loadingBahan.hide()
            }, 500)
        } catch(err) {
            console.log(err)
        }
    }

    function warnaRow(i, wrn, cc) {
        return `<tr>
                    <td style="display:none;">${wrn.id}</td>
                    <td>${cc[i]}.</td>
                    <td>${wrn.name}</td>
                    <td class="text-center">
                        <i style="color: ${wrn.hex_code};" class="fas fa-square"></i>
                    </td>
                </tr>`
    }

    function bahanRow(i, bhn, cc) {
        return `<tr>
                    <td style="display:none;">${bhn.id}</td>
                    <td>${cc[i]}.</td>
                    <td>${bhn.nama}</td>
                    <td>${bhn.deskripsi == null ? '' : bhn.deskripsi}</td>
                </tr>`
    }

    function edit(row) {
        const id = row.find("td:eq(0)").text().trim()
        axios.get(`/api/v1/warna/${id}`, { headers: General.getHeaders() })
            .then(function(res) {
                $("#id_warna_edit").val(res.data.data.id)
                $("#name2").val(res.data.data.name)
                $("#hex_code2").val(res.data.data.hex_code)
                $("#modal_edit_warna").modal('toggle')
            })
            .catch(function(err) {
                console.log(err)
            })
    }

    function remove(row) {
        let result = confirm("Anda yakin ingin dihapus?")
        if (result) {
            const id = row.find("td:eq(0)").text().trim()
            
            axios.post(`/api/v1/warna/${id}/remove`, {}, { headers: General.getHeaders() })
                .then(function(res) {
                    General.showToast("success", res.data.message)
                    location.reload()
                })
                .catch(function(err) {
                    General.showToast("error", err.response.statusText)
                })
        }
    }

    function edit2(row) {
        const id = row.find("td:eq(0)").text().trim()
        axios.get(`/api/v1/bahan/${id}`, { headers: General.getHeaders() })
            .then(function(res) {
                console.log(res)
                $("#id_bahan_edit").val(res.data.data.id)
                $("#nama_bahan2").val(res.data.data.nama)
                $("#deskripsi2").val(res.data.data.deskripsi)
                $("#modal_edit_bahan").modal('toggle')
            })
            .catch(function(err) {
                console.log(err)
            })
    }

    function remove2(row) {
        let result = confirm("Anda yakin ingin dihapus?")
        if (result) {
            const id = row.find("td:eq(0)").text().trim()
            
            axios.post(`/api/v1/bahan/${id}/remove`, {}, { headers: General.getHeaders() })
                .then(function(res) {
                    General.showToast("success", res.data.message)
                    location.reload()
                })
                .catch(function(err) {
                    General.showToast("error", err.response.statusText)
                })
        }
    }
})