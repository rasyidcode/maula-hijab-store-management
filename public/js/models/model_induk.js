class ModelInduk {
    constructor(kode, nama_produk, harga_jahit, hpp, created_at, updated_at) {
        this.kode = kode
        this.nama_produk = nama_produk
        this.harga_jahit = harga_jahit
        this.hpp = hpp
        this.created_at = created_at,
        this.updated_at = updated_at
    }

    getUIData() {
        return {
            kode: this.kode,
            nama_produk: this.nama_produk,
            harga_jahit: {
                value: this.harga_jahit,
                type: IntType.MONEY
            },
            hpp: {
                value: this.hpp,
                type: IntType.MONEY
            },
            created_at: this.created_at
        }
    }

    setTotalBarang(total_barang) {
        this.total_barang = total_barang
    }

    getTotalBarang() {
        return this.total_barang
    }

    getMoneyField() {
        return {
            value: this.harga_jahit,
            type: IntType.MONEY
        }
    }

    getHpp() {
        return {
            value: this.hpp,
            type: IntType.MONEY
        }
    }
}