const IntType = Object.freeze({"MONEY": 0, "STANDARD": 1})

class ModelInduk {
    constructor(kode, nama_produk, harga_jahit, hpp, created_at) {
        this.kode = kode
        this.nama_produk = nama_produk
        this.harga_jahit = harga_jahit
        this.hpp = hpp
        this.created_at = created_at
    }

    setUpdatedAt(updated_at) {
        this.updated_at = updated_at
    }

    getUpdatedAt() {
        return this.updated_at
    }

    setTotalBarang(total_barang) {
        this.total_barang = total_barang
    }

    getTotalBarang() {
        return this.total_barang
    }

    getHargaJahit() {
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