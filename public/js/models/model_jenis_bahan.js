class JenisBahan {
    constructor(kode, nama, warna, created_at, updated_at) {
        this.kode = kode
        this.nama = nama
        this.warna = warna
        this.created_at = created_at
        this.updated_at = updated_at
    }

    getUIData() {
        return {
            kode: this.kode,
            nama: this.nama,
            warna: this.warna,
            created_at: General.convertToReadableFormat(this.created_at)
        }
    }
}