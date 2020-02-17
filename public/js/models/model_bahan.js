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
            id: this.id,
            no: `${this.no}.`,
            tanggal_masuk: General.convertToMomentFormat(this.tanggal_masuk),
            kodejb: this.kodejb,
            yard: this.yard,
            harga: General.rupiahFormat(this.harga.toString(), ""),
            value: General.rupiahFormat(this.value.toString(), ""),
            status: this.status_potong
        }
    }
}