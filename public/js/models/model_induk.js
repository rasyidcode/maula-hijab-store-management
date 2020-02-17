class ModelInduk {
    constructor(kode, harga_jahit, harga_basic, hpp_shopee, hpp_lazada, dfs_shopee, dfs_lazada, created_at, updated_at) {
        this.kode = kode
        this.harga_jahit = harga_jahit
        this.harga_basic = harga_basic
        this.hpp_shopee = hpp_shopee
        this.hpp_lazada = hpp_lazada
        this.dfs_shopee = dfs_shopee
        this.dfs_lazada = dfs_lazada
        this.created_at = created_at
        this.updated_at = updated_at

        this._calculateDetail()
    }

    _calculateDetail() {
        // shopee
        this.min_fs_shopee = this._hitungMinFs(this.dfs_shopee)
        this.campaign_shopee = this._hitungCampaign(this.dfs_shopee)
        this.ecer_shopee = this._hitungEcer(this.campaign_shopee)
        // lazada
        this.min_fs_lazada = this._hitungMinFs(this.dfs_lazada)
        this.campaign_lazada = this._hitungCampaign(this.dfs_lazada)
        this.ecer_lazada = this._hitungEcer(this.campaign_lazada)
    }

    setNumbering(no) {
        this.no = no
    }

    getUIData() {
        return {
            no: `${this.no}.`,
            kode: this.kode,
            harga_jahit: General.rupiahFormat(this.harga_jahit, ''),
            harga_basic: General.rupiahFormat(this.harga_basic, ''),
            shopee: {
                hpp: General.rupiahFormat(this.hpp_shopee, ''),
                dfs: General.rupiahFormat(this.dfs_shopee, ''),
                min_fs: General.rupiahFormat(this.min_fs_shopee, ''),
                campaign: General.rupiahFormat(this.campaign_shopee, ''),
                ecer: General.rupiahFormat(this.ecer_shopee, ''),
            },
            lazada: {
                hpp: General.rupiahFormat(this.hpp_lazada, ''),
                dfs: General.rupiahFormat(this.dfs_lazada, ''),
                min_fs: General.rupiahFormat(this.min_fs_lazada, ''),
                campaign: General.rupiahFormat(this.campaign_lazada, ''),
                ecer: General.rupiahFormat(this.ecer_lazada, '')
            },
            created_at: General.convertToMomentFormat(this.created_at)
        }
    }

    _hitungMinFs(dfs) {
        return dfs * 0.97
    }
    _hitungCampaign(dfs) {
        return dfs / 0.85
    }
    _hitungEcer(campaign) {
        return campaign / 0.70
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