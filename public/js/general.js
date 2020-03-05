const IntType = Object.freeze({"MONEY": 0, "STANDARD": 1})
const StatusWos = Object.freeze({
    "BELUM_DIAMBIL": 0,
    "SUDAH_DIAMBIL": 1,
    "DIKEMBALIKAN_SETENGAH": 2,
    "COMPLETED": 3
})
class General {
    
    static sendRequest(data, route, method, headers, onsuccess = null, onerror = null) {
        const url = window.location.origin + "/api" + route
        const xhttp = new XMLHttpRequest()
        xhttp.open(method, url)
        if (headers.length > 0) {
            for (let i = 0; i < headers.length; i++) {
                xhttp.setRequestHeader(headers[i].key, headers[i].value)
            }
        }
        xhttp.onreadystatechange = function () {
            if (this.readyState === 4) {
                if (this.status === 200 || this.status === 201) {
                    onsuccess(this)
                } else {
                    onerror(this)
                }
            }
        }
        xhttp.send(JSON.stringify(data))
    }

    static removeRupiah(value) {
        let step_one = value.toString().replace("Rp. ", "");
        let step_two = step_one.split(".").join("")
        return parseInt(step_two)
    }

    static rupiahFormat(number, prefix) {
        let n = number.toString()
        let numberString = n.replace(/[^,\d]/g, '').toString()
        let split = numberString.split(',')
        let left = split[0].length % 3
        let rupiah = split[0].substr(0, left)
        let thousands = split[0].substr(left).match(/\d{3}/gi)

        if (thousands) {
            let separator = left ? '.' : '';
            rupiah += separator + thousands.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    static showToast(type, message, duration = 3000) {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: duration
        })  
        Toast.fire({
            type: type, // success, error, warning, info, question
            title: message
        })
    }

    static handleErrorInput(errors, ids) {
        Object.keys(errors).forEach(function(error) {
            ids.forEach(function(id) {
                if (error === id) {
                    console.log(error)
                    console.log(id)
                    let errorMessage = errors[error][0]
                    let input = document.getElementById(id)
                    let formGroup = input.closest(".form-group")
                    console.log(formGroup.children.length)
                    if (formGroup.children.length <= 2) {
                        let span_error = document.createElement("span")
                        span_error.classList.add("invalid-feedback")
                        span_error.innerHTML = errorMessage
                        formGroup.appendChild(span_error)
                        input.classList.add("is-invalid")
                    } else {
                        input.nextSibling.innerHTML = errorMessage
                    }
                }
            })
        })
    }

    static createInvalidFeedback(element, message) {
        let span_error = document.createElement("span")
        span_error.classList.add("invalid-feedback")
        span_error.innerHTML = message
        element.classList.add("is-invalid")
        element.closest(".form-group").appendChild(span_error)
    }

    static removeInvalidFeedback(element) {
        let formGroup = element.closest(".form-group")
        if (formGroup.children.length > 2) {
            formGroup.children[1].classList.remove("is-invalid")
            formGroup.removeChild(formGroup.lastElementChild)
        }
    }

    static handleEmptyField(el_msg) {
        el_msg.forEach((function (item) {
            console.log(item.element.value)
            if (item.element.value === "") {
                if (item.element.closest(".form-group").children.length <= 2) {
                    General.createInvalidFeedback(item.element, item.message)
                } else {
                    item.element.nextSibling.innerHTML = item.message
                }
            } else {
                General.removeInvalidFeedback(item.element)
            }
        }))
    }

    static createTd(value, style = null) {
        let td = document.createElement("td")
        if (style !== null) {
            td.classList.add(style)
        }
        td.innerHTML = value
        return td
    }

    static buttonStyleChooser(button, pos) {
        let icon = document.createElement("i")
        icon.classList.add("fas")
        button.classList.add("btn")
        if (pos=== 0) { 
            button.classList.add("btn-primary")
            button.classList.add("mr-1")
            icon.classList.add("fa-eye")
            button.appendChild(icon)
        } else if (pos === 1) {
            button.classList.add("btn-info")
            icon.classList.add("fa-pencil-alt")
            button.appendChild(icon)
        } else if (pos === 2) {
            button.classList.add("btn-danger")
            button.classList.add("ml-1")
            icon.classList.add("fa-trash")
            button.appendChild(icon)
        }
        button.classList.add("btn-sm")
        button.appendChild(icon)
        return button
    }

    static createActionButton(options) {
        let button = null
        switch(options.type) {
            case "link":
                button = General.buttonStyleChooser(document.createElement("a"), options.position)
                button.setAttribute("href", options.action)
                break
            case "modal":
                button = General.buttonStyleChooser(document.createElement("button"), options.position)
                button.setAttribute("type", "button")
                button.setAttribute("data-toggle", "modal")
                button.setAttribute("data-target", options.action)
                button.setAttribute("data-id", options.id)
                break
            case "action":
                button = General.buttonStyleChooser(document.createElement("button"), options.position)
                button.setAttribute("type", "button"),
                button.addEventListener("click", options.action)
                break
            default:
                break
        }

        return button
    }

    static actionChooser(type, action, id) {
        switch(type) {
            case "modal":
                return action
            case "link":
                return `${action}/${id}/edit`
            case "action":
                return function() {
                    const url = `${action}/${id}/hapus`
                    let result = confirm("Anda yakin ingin dihapus?")
                    if (result) {
                        General.sendRequest(null, url, "POST", [{key: "Content-Type", value: "application/json"}],
                            function onsuccess(xhttp) {
                                const response = JSON.parse(xhttp.responseText)
                                General.showToast("success", response.message)
                                setTimeout(function() {
                                    location.reload()
                                }, 3000)
                            },
                            function onerror(xhttp) {
                                const response = JSON.parse(xhttp.responseText)
                                General.showToast("error", response.message)
                            }
                        )
                    }
                }
            default:
                break
        }
    }

    static makeListData(options) {
        options.data.forEach(function(item, index) {
            let tr = document.createElement("tr")
            let keys = Object.keys(item)
            tr.appendChild(General.createTd(`${index + 1}.`))
            keys.forEach(function(key) {
                if (key !== "id") {
                    if (typeof item[key] === 'string' || item[key] instanceof String) {
                        tr.appendChild(General.createTd(item[key]))
                    } else {
                        if (item[key].type === IntType.MONEY) {
                            tr.appendChild(General.createTd(General.rupiahFormat(item[key].value.toString(), "")))
                        } else {
                            if (!item[key].has_style) {
                                tr.appendChild(General.createTd(item[key].value))   
                            } else {
                                // START ATTENTION : barang spesific code
                                if ((item[key].value + 20) <= item.stok.value) {
                                    tr.appendChild(General.createTd(item[key].value, "bg-red"))
                                } else {
                                    tr.appendChild(General.createTd(item[key].value, "bg-green"))
                                }
                                // END ATTENTION
                            }
                        }
                    }
                }
            })
            /* ATTENTION : not dynamic */
            let td_action = document.createElement("td")
            options.actions.forEach(function(act, index) {
                const button_options = {
                    position: index,
                    type: act.type,
                    action: General.actionChooser(
                        act.type,
                        act.action,
                        item[keys[0]]
                    )
                }
                if (act.is_pass_id) {
                    button_options.id = item[keys[0]]
                }
                let button = General.createActionButton(button_options)
                td_action.appendChild(button)
            })

            tr.appendChild(td_action)
            document.getElementById(options.table_id).children[1].appendChild(tr)
        })
    }

    static spaceRemover(text) {
        const texts = text.split(" ")
        let result = ""
        texts.forEach(function(item) {
            result += item
        })
        return result
    }

    static convertToReadableFormat(date) {
        const newDate = new Date(date)
        const day = General.getHari(newDate.getDay())
        const dayOfMonth = newDate.getDate()
        const month = General.getBulan(newDate.getMonth())
        const year = newDate.getFullYear()
        const hour = newDate.getHours()
        const minute = newDate.getMinutes()
        const ampm = hour > 12 ? "PM" : "AM"
        const hourText = this.countDigits(hour) <= 1 ? `0${hour}` : hour
        const minuteText = this.countDigits(hour) <= 1 ? `0${minute}` : minute

        return `${day}, ${dayOfMonth} ${month} ${year}, ${hourText}:${minuteText} ${ampm}`
    }

    static getHari(hari) {
        switch(hari) {
            case 0:
                return "Minggu"
            case 1:
                return "Senin"
            case 2:
                return "Selasa"
            case 3:
                return "Rabu"
            case 4:
                return "Kamis"
            case 5:
                return "Jumat"
            default:
                return "Sabtu"
        }
    }

    static getBulan(month) {
        switch(month) {
            case 0:
                return "Januari"
            case 1:
                return "Februari"
            case 2:
                return "Maret"
            case 3:
                return "April"
            case 4:
                return "Mei"
            case 5:
                return "Juni"
            case 6:
                return "Juli"
            case 7:
                return "Agustus"
            case 8:
                return "September"
            case 9:
                return "Oktober"
            case 10:
                return "November"
            default:
                return "Desember"
        }
    }

    static countDigits(n) {
        let count = 0
        if (n >= 1) ++count

        while (n / 10 >= 1) {
            n /= 10;
            ++count;
        }

        return count;
    }

    static convertToDatetimeSql(datetime) {
        const date = datetime.split('/')
        const hourmin = date[2].split(' ')
        const hourmin2 = hourmin[1].split('.')

        return `${hourmin[0]}-${date[1]}-${date[0]} ${hourmin2[0]}:${hourmin2[1]}:00`
    }

    static convertToMomentFormat(datetime) {
        moment.locale('id')
        // const date = datetime.split('-')[2].split(' ')[0]
        // const month = datetime.split('-')[1]
        // const year = datetime.split('-')[0]
        // const hour = datetime.split('-')[2].split(' ')[1].split(':')[0]
        // const minute = datetime.split('-')[2].split(' ')[1].split(':')[1]
        return moment(new Date(datetime)).format('LLLL')
    }

    static resetElementsField(elements) {
        elements.forEach(function(item) {
            if (item.type === 'text') {
                $(item.selector).val('')
            } else if (item.type === 'select') {
                const firstData = 0
                $(item.selector).val(firstData).trigger('change')
            } else if (item.type === 'datetimepicker') {
                moment.locale('id')
                $(item.selector).find('input').val(moment().format('DD/MM/YYYY HH.mm'))
            }
        })
    }

    static resetSelect2(selector) {
        $(selector).html('')
        $(selector).append(new Option('Pilih', '0', false, false)).trigger('change')
    }

    static resetDatePicker(datepicker) {
        moment.locale('id')
        $(datepicker).find('input').val(moment().format('DD/MM/YYYY HH.mm'))
    }

    static getCreds() {
        return JSON.parse(localStorage.getItem('creds'));
    }

    static getHeaders() {
        const creds = this.getCreds()
        return {
            'Authorization': `${creds.token_type} ${creds.access_token}`
        }
    }
}