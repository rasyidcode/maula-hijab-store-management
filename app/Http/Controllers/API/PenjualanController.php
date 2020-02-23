<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Models\PenjualanShopee;
use App\Models\PenjualanLazada;

use App\Http\Controllers\Helper\GeneralHelper as Helper;
use App\Http\Controllers\Helper\TempProduct;

class PenjualanController extends Controller {

    public function shopee() {
        $data = PenjualanShopee::all();
        return Helper::send_response(200, 'Berhasil', $data);
    }

    public function lazada() {
        $data = PenjualanLazada::all();
        return Helper::send_response(200, 'Berhasil', $data);
    }
    
    public function upload(Request $request) {
        $file = $request->file('data_file');
        $fileType = $this->getExtensions($file);
        
        if ($fileType == null) {
            return Helper::send_response(422, 'Extensi file tidak didukung!', null);
        }

        $reader = IOFactory::createReader($fileType);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file->getRealPath());

        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        switch($fileType) {
            case 'Xls':
                $this->handleShopee($sheetData);
                break;
            case 'Xlsx':
                $this->handleShopee($sheetData);
                break;
            case 'Csv':
                $this->handleLazada($sheetData);
                break;
        }

        return Helper::send_response(200, 'Data berhasil di upload', null);
    }

    public function test(Request $request) {
        $file = $request->file('shopee_sample')->getRealPath();
        // $file2 = $request->file('lazada_sample')->getRealPath();

        /* load xlsx */
        // $spreadsheet = IOFactory::load($file);

        /* load xls */
        // $reader = new Xls();
        // $reader->setReadDataOnly(true);
        // $spreadsheet = $reader->load($file);

        /* load csv */
        $reader = IOFactory::createReader('Xlsx');
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($file);

        $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);

        return $sheetData;
    }

    private function getOrderedProduct(string $products) : array {
        $results = preg_split('/\[*\d]\s/', $products);
        $orders = array();

        foreach($results as $item) {
            if ($item != '' && $item != 'Informasi Produk') {
                $trimmedData = array();
                $splitter = preg_split('/\;\s/', $item);
                // Log::debug($splitter);

                foreach($splitter as $index => $prop) {
                    $d = preg_split('/(.+:)/', $splitter[$index]);
                    // if (count($d) > 1) {
                    //     Log::debug(trim($d[1]));
                    // }
                    if (count($d) > 1) {
                        $propItem = trim($d[1]);
                        if (preg_match('/^Rp/', $propItem)) {
                            $propItem = $this->rpToInteger($propItem);
                        }
                        // Log::debug($propItem);
                        array_push($trimmedData, $propItem);
                    }
                }
                // Log::debug($trimmedData);
                array_push($orders, $trimmedData);
            }
        }

        return $orders;
    }

    private function getExtensions(\Illuminate\Http\UploadedFile $uploadedFile) : ?string {
        $extension = $uploadedFile->getClientOriginalExtension();

        switch($extension) {
            case 'xls':
                return 'Xls';
            case 'xlsx':
                return 'Xlsx';
            case 'csv':
                return 'Csv';
            default:
                return null;
        }
    }

    private function rpToInteger(string $text) : int {
        $step1 = str_replace('Rp', '', $text);
        $step2 = str_replace(',', '', $step1);
        $result = (int) $step2;
        return $result;
    }

    private function handleShopee($sheetData) {
        foreach($sheetData as $index => $data) {
            $orderedProducts = $this->getOrderedProduct($data['I']);
            foreach($orderedProducts as $product) {
                $penjualanShopeeData['no_resi'] = $data['A'];
                $penjualanShopeeData['no_pesanan'] = $data['B'];
                $penjualanShopeeData['status_pesanan'] = $data['D'];
                $penjualanShopeeData['status_retur'] = $data['E'];
                $penjualanShopeeData['username'] = $data['F'];
                $penjualanShopeeData['waktu_pesanan_dibuat'] = $data['G'] . ':00';
                $penjualanShopeeData['waktu_pesanan_dikirim'] = $data['H'] . ':00';
                $penjualanShopeeData['nama_produk'] = $product[0];
                $penjualanShopeeData['warna'] = $product[1];
                $penjualanShopeeData['harga'] = $product[2];
                $penjualanShopeeData['kuantitas'] = (int)$product[3];
                $penjualanShopeeData['referensi_sku'] = $product[4];
                $penjualanShopeeData['sku_induk'] = $product[5];
                $penjualanShopeeData['opsi_pengiriman'] = $data['J'];
                $penjualanShopeeData['nama_penerima'] = $data['K'];
                $penjualanShopeeData['nomor_hp'] = $data['L'];
                $penjualanShopeeData['alamat_pengiriman'] = $data['M'];
                $penjualanShopeeData['kabupaten'] = $data['N'];
                $penjualanShopeeData['provinsi'] = $data['O'];
                $penjualanShopeeData['kode_pos'] = $data['P'];

                PenjualanShopee::create($penjualanShopeeData);
            }
            // Log::debug($orderedProducts);
            // var_dump($orderedProducts);
            // $test = preg_split('/\[*\d]\s/', $data['I']);
            // if (count($test) > 1) {
            //     $test2 = preg_split('/\;\s/', $test[1]);
            //     $d = preg_split('/(.+:)/', $test2[0]);
            //     Log::debug($d[1]);
            // }
        }
    }

    private function handleLazada($sheetData) {
        foreach($sheetData as $data) {
            // Log::debug($data);
            if ($data['A'] != 'Order Item Id') {
                $penjualanLazadaData['order_item_id'] = $data['A'];
                $penjualanLazadaData['order_type'] = $data['B'];
                $penjualanLazadaData['order_flag'] = $data['C'];
                $penjualanLazadaData['seller_sku'] = $data['E'];
                $penjualanLazadaData['lazada_sku'] = $data['F'];
                $penjualanLazadaData['lazada_created_at'] = $data['G'];
                $penjualanLazadaData['lazada_updated_at'] = $data['H'];
                $penjualanLazadaData['is_invoice_required'] = $data['J'] == 'Yes' ? true : false;
                $penjualanLazadaData['customer_name'] = $data['K'];
                $penjualanLazadaData['customer_email'] = $data['L'];
                $penjualanLazadaData['shipping_address'] = "{$data['O']}, {$data['P']}, {$data['Q']}, {$data['R']}, {$data['S']}";
                $penjualanLazadaData['no_hp'] = $data['T'];
                $penjualanLazadaData['paid_price'] = $data['AL'];
                $penjualanLazadaData['unit_price'] = $data['AM'];
                $penjualanLazadaData['shipping_fee'] = $data['AN'];
                $penjualanLazadaData['product_name'] = $data['AP'];
                $color = preg_split('/.+:/', preg_split('/,/', $data['AQ'])[0]);
                $size = preg_split('/.+:/', preg_split('/,/', $data['AQ'])[1]);
                $penjualanLazadaData['color'] = trim($color[1]);
                $penjualanLazadaData['size'] = trim($size[1]);
                $penjualanLazadaData['shipping_provider'] = $data['AS'];
                $penjualanLazadaData['shipping_type'] = $data['AU'];
                $penjualanLazadaData['tracking_code'] = $data['AW'];
                $penjualanLazadaData['status'] = $data['BD'];
                $penjualanLazadaData['reason_return'] = $data['BF'];
                $penjualanLazadaData['refund_amount'] = $data['BK'];

                // Log::debug($penjualanLazadaData);
                PenjualanLazada::create($penjualanLazadaData);
            }
        }
    }
}
