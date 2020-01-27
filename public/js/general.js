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
        let step_one = value.replace("Rp. ", "");
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
            separator = left ? '.' : '';
            rupiah += separator + thousands.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
}