class ModelBahan {
    constructor(id, nama_bahan, harga_bahan, created_at, updated_at) {
        this.id = id
        this.nama_bahan = nama_bahan
        this.harga_bahan = harga_bahan
        this.created_at = created_at
        this.updated_at = updated_at
    }

    getUIData() {
        return {
            id: this.id,
            nama_bahan: this.nama_bahan,
            harga_bahan: {
                value: this.harga_bahan,
                type: IntType.MONEY
            },
            created_at: this.created_at
        }
    }
}