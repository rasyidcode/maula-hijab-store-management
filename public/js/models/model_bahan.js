class ModelBahan {

    constructor(id, kodejb, harga, yard, tanggal_masuk, value, status_potong, created_at, updated_at) {
        this.id = id,
        this.kodejb = kodejb
        this.harga = harga
        this.yard = yard
        this.tanggal_masuk = tanggal_masuk
        this.value = value
        this.status_potong = status_potong == 1 ? true : false,
        this.created_at = created_at
        this.updated_at = updated_at
    }

    setNumbering(no) {
        this.no = no
    }

    getUIData() {
        return {
            no: `${this.no}.`,
            tanggal_masuk: General.convertToReadableFormat(this.tanggal_masuk),
            kodejb: this.kodejb,
            harga: General.rupiahFormat(this.harga.toString(), ""),
            yard: this.yard,
            value: General.rupiahFormat(this.value.toString(), ""),
            status: this.status_potong
        }
    }
}