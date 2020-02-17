class ModelPenjahit {
    constructor(no_ktp, nama_lengkap, no_hp, alamat, created_at, updated_at) {
        this.no_ktp = no_ktp
        this.nama_lengkap = nama_lengkap
        this.no_hp = no_hp
        this.alamat = alamat
        this.created_at = created_at
        this.updated_at = updated_at
    }

    setNumbering(no) {
        this.no = no
    }

    getUIData() {
        return {
            no: `${this.no}.`,
            no_ktp: this.no_ktp,
            nama_lengkap: this.nama_lengkap,
            no_hp: this.no_hp,
            alamat: this.alamat,
            created_at: this.created_at
        }
    }
}