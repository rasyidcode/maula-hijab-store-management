class ModelWos {
    constructor(
        id,
        kode_barang,
        id_bahan,
        yard,
        pcs,
        tanggal_ambil,
        tanggal_kembali,
        jumlah_kembali,
        status_bayar,
        no_ktp_penjahit,
        created_at,
        updated_at,
        barang,
        penjahit,
        bahan
    ) {
        this.id = id
        this.kode_barang = kode_barang
        this.id_bahan = id_bahan
        this.yard = yard
        this.pcs = pcs
        this.tanggal_ambil = tanggal_ambil
        this.tanggal_kembali = tanggal_kembali
        this.jumlah_kembali = jumlah_kembali
        this.status_bayar = status_bayar
        this.no_ktp_penjahit = no_ktp_penjahit
        this.created_at = created_at
        this.updated_at = updated_at
        this.barang = barang
        this.penjahit = penjahit
        this.bahan = bahan
    }

    setNumbering(no) {
        this.no = no
    }

    getUIData() {
        const demand = this.yard / this.pcs
        return {
            id: this.id,
            created_at: this.created_at,
            nama_penjahit: this.penjahit == null ? '-' : this.penjahit.nama_lengkap,
            kode_barang: this.kode_barang,
            yard: this.yard,
            pcs: this.pcs,
            demand: demand,
            tanggal_ambil: this.tanggal_ambil == null ? '-' : General.convertToMomentFormat(this.tanggal_ambil),
            tanggal_kembali: this.tanggal_kembali == null ? '-' : General.convertToMomentFormat(this.tanggal_kembali),
            jumlah_kembali: `${this.jumlah_kembali} <i class="text-success">(sisa ${this.pcs - this.jumlah_kembali})</i>`,
            status: this._checkStatus()
        }
    }

    _checkStatus() {
        let status

        if (this.tanggal_ambil == null) {
            status = StatusWos.BELUM_DIAMBIL
            return status
        } else {
            if (this.tanggal_kembali == null) {
                if (this.jumlah_kembali > 0 && this.jumlah_kembali < this.pcs) {
                    status = StatusWos.DIKEMBALIKAN_SETENGAH
                    return status
                } else {
                    status = StatusWos.SUDAH_DIAMBIL
                    return status
                }
            } else {
                status = StatusWos.COMPLETED
                return status
            }
        }
    }
}