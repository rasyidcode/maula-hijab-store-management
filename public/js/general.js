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
        let numberString = number.replace(/[^,\d]/g, '').toString()
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

    static createTd(value) {
        let td = document.createElement("td")
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
                button.setAttribute("data-kode", options.kode)
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
}