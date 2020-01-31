class ModelBarang {
    constructor(
        kode,
        kode_induk,
        warna,
        stok,
        treshold,
        id_bahan,
        created_at,
        updated_at,
        induk,
        bahan
    ) {
        this.kode = kode
        this.kode_induk = kode_induk
        this.warna = warna
        this.stok = stok
        this.treshold = treshold
        this.id_bahan = id_bahan
        this.created_at = created_at
        this.updated_at = updated_at
        this.induk = induk
        this.bahan = bahan
    }

    getMoneyField() {
        return {
            value: this.induk.hpp * this.stok,
            type: IntType.MONEY
        }
    }

    getUIData() {
        return {
            kode: this.kode,
            nama_produk: this.induk.nama_produk,
            warna: this.warna,
            bahan: this.bahan.nama_bahan,
            stok: {
                value: this.stok,
                type: IntType.STANDARD,
                has_style: false
            },
            treshold: {
                value: this.treshold,
                type: IntType.STANDARD,
                has_style: true
            },
            total_modal: {
                value: this.induk.hpp * this.stok,
                type: IntType.MONEY,
                has_style: false
            }
        }
    }
}