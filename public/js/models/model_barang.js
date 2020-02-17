// TODO: tambah stok onprogress
class ModelBarang {
    constructor(
        kode,
        kode_induk,
        warna,
        stok_ready,
        stok_on_progress,
        treshold,
        created_at,
        updated_at,
    ) {
        this.kode = kode
        this.kode_induk = kode_induk
        this.warna = warna
        this.stok_ready = stok_ready
        this.stok_on_progress = stok_on_progress
        this.treshold = treshold
        this.created_at = created_at
        this.updated_at = updated_at
    }

    setNumbering(no) {
        this.no = no
    }

    getUIData() {
        return {
            no: `${this.no}.`,
            kode: this.kode,
            kode_induk: this.kode_induk,
            warna: this.warna,
            stok_ready: this.stok_ready,
            stok_on_progress: this.stok_on_progress,
            treshold: this.treshold,
            created_at: General.convertToMomentFormat(this.created_at)
        }
    }

    // async getStokOnProgress(kode_barang) {
    //     const url = `/api/wos/${kode_barang}/on_progress/`
    //     const res = await axios.get(url)
    //     const onprogress = parseInt(res.data.data.total_pcs) - parseInt(res.data.data.total_jumlah_kembali)
    //     return onprogress
    // }
}