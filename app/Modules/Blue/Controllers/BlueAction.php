<?php namespace App\Modules\Blue\Controllers;

use App\Modules\Auth\Models\AuthModel;

use App\Modules\Blue\Models\BlueModel;
use App\Core\BaseController;
use App\Core\BaseModel;

class BlueAction extends BaseController
{
    private $blueModel;
    private $authModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->blueModel = new BlueModel();
        $this->authModel = new AuthModel();
    }

    public function index()
    {
        return redirect()->to(base_url()); 
    }

    function blue_load()
    {
        parent::_authLoad(function(){
            $masa_berlaku_start = $_POST["filter"][0] ? $_POST["filter"][0] : null;
            $masa_berlaku_end = $_POST["filter"][1] ? $_POST["filter"][1] : null;

            if($masa_berlaku_start != null && $masa_berlaku_end != null) {
                $query = "select * from ((select a.id, a.date, a.nama_pemilik, a.alamat_pemilik, a.no_srut, a.no_registrasi_kendaraan, a.jenis_kendaraan
                            from m_blue a 
                        where a.is_deleted = 0 and a.date BETWEEN " . "'" . $masa_berlaku_start . "'" . " and " . "'" . $masa_berlaku_end . "'" . " limit 5000)
                            UNION ALL
                        (select b.id, b.date, b.nama_pemilik, b.alamat_pemilik, b.no_srut, b.no_registrasi_kendaraan, b.jenis_kendaraan
                            from m_bluerfid b
                        where b.is_deleted = 0 and b.date BETWEEN " . "'" . $masa_berlaku_start . "'" . " and " . "'" . $masa_berlaku_end . "' limit 5000 )
                        ) a";                 
            } else {
                $query = "select * from ((select a.id, a.date, a.nama_pemilik, a.alamat_pemilik, a.no_srut, a.no_registrasi_kendaraan, a.jenis_kendaraan
                            from m_blue a 
                        where a.is_deleted = 0 limit 5000)
                            UNION ALL
                            (select b.id, b.date, b.nama_pemilik, b.alamat_pemilik, b.no_srut, b.no_registrasi_kendaraan, b.jenis_kendaraan
                            from m_bluerfid b
                        where b.is_deleted = 0 limit 5000)
                        ) a";
            }
            
            $where = ["a.no_registrasi_kendaraan"];
        
            parent::_loadDatatableBlue($query, $where, $this->request->getPost());

            // get api blue list
            // return $this->APIBluelist_load();
        });
    }

    // access api hubdat blue load
    private function APIBluelist_load() {
        $dataToken = parent::_initTokenHubdat();
        $bearerToken = 'Bearer ' . $dataToken["access_token"];

        // filter
        $start = $_POST["start"];
        $length = $_POST["length"];
        $masa_berlaku_start = $_POST["filter"][0] ? "&masa_berlaku_start=" . $_POST["filter"][0] . "T00:00:00" : null;
        $masa_berlaku_end = $_POST["filter"][1] ? "&masa_berlaku_end=" . $_POST["filter"][1] . "T00:00:00" : null;

        $response =  $this->APIListBlue('blue', $bearerToken, $start, $length, [$masa_berlaku_start, $masa_berlaku_end]);

        $data = json_decode($response, true);

        $baseModel = new BaseModel();

        // log
        $log_param = json_encode((object)array(
            'skip' => $start,
            'limit' => $length,
            'sort' => 'ASC',
            'masa_berlaku_start' => $masa_berlaku_start,
            'masa_berlaku_end' => $masa_berlaku_end
        ));

        $this->APIBlueLog($baseModel, $bearerToken, $log_param, $response);

        // blue dummy
        // $this->db->truncate('m_blue');
        // $this->APIBlueListDummy($baseModel, $bearerToken, 'blue', 'm_blue');

        echo json_encode(array("data" => $data["data"], "recordsTotal" => $data["total"], "recordsFiltered" => $data["limit"]));
    }

    function blue_blueLite()
    {
        parent::_authDetail(function(){
            // fetch date blue lite no union
            // parent::_editOnlyBlueLite('m_blue', $this->request->getPost());

            // fetch data blue lite union
            $res_data = ['date(date)', 'nama_pemilik', 'alamat_pemilik', 'no_srut', 'tgl_srut(date)', 'no_registrasi_kendaraan', 'no_rangka', 'no_mesin', 'jenis_kendaraan', 'merk', 'tipe', 'tahun_rakit', 'bahan_bakar', 'isi_silinder', 'daya_motor', 'berat_kosong', 'panjang_kendaraan', 'lebar_kendaraan', 'tinggi_kendaraan', 'julur_depan', 'julur_belakang', 'jbb', 'jbkb', 'jbi', 'jbki', 'daya_angkut_orang', 'daya_angkut_kg', 'kelas_jalan', 'keterangan_hasil_uji', 'petugas_penguji', 'nrp_petugas_penguji', 'kepala_dinas', 'pangkat_kepala_dinas', 'nip_kepala_dinas', 'unit_pelaksana_teknis', 'direktur', 'pangkat_direktur', 'nip_direktur'];

            parent::_editModalCustomBlue('m_blue', $this->request->getPost(), $res_data, '', 
            ['select a.date, a.nama_pemilik, a.alamat_pemilik, a.no_srut, a.tgl_srut, a.no_registrasi_kendaraan, a.no_rangka, a.no_mesin, a.jenis_kendaraan, a.merk, a.tipe, a.tahun_rakit, a.bahan_bakar, a.isi_silinder, a.daya_motor, a.berat_kosong, a.panjang_kendaraan, a.lebar_kendaraan, a.tinggi_kendaraan, a.julur_depan, a.julur_belakang, a.jbb, a.jbkb, a.jbi, a.jbki, a.daya_angkut_orang, a.daya_angkut_kg, a.kelas_jalan, a.keterangan_hasil_uji, a.masa_berlaku, a.petugas_penguji, a.nrp_petugas_penguji, a.kepala_dinas, a.pangkat_kepala_dinas, a.nip_kepala_dinas, a.unit_pelaksana_teknis, a.direktur, a.pangkat_direktur, a.nip_direktur, a.is_deleted, a.created_at, a.created_by, a.updated_at, a.updated_by 
                from m_blue a 
                where a.is_deleted = 0',
            'select b.date, b.nama_pemilik, b.alamat_pemilik, b.no_srut, b.tgl_srut, b.no_registrasi_kendaraan, b.no_rangka, b.no_mesin, b.jenis_kendaraan, b.merk, b.tipe, b.tahun_rakit, b.bahan_bakar, b.isi_silinder, b.daya_motor, b.berat_kosong, b.panjang_kendaraan, b.lebar_kendaraan, b.tinggi_kendaraan, b.julur_depan, b.julur_belakang, b.jbb, b.jbkb, b.jbi, b.jbki, b.daya_angkut_orang, b.daya_angkut_kg, b.kelas_jalan, b.keterangan_hasil_uji, b.masa_berlaku, b.petugas_penguji, b.nrp_petugas_penguji, b.kepala_dinas, b.pangkat_kepala_dinas, b.nip_kepala_dinas, b.unit_pelaksana_teknis, b.direktur, b.pangkat_direktur, b.nip_direktur, b.is_deleted, b.created_at, b.created_by, b.updated_at, b.updated_by
                from m_bluerfid b 
                where b.is_deleted = 0
            '], 'lite');

            //  fetch api blue lite
            // $this->APIBluelist_blueLite();
        });
    }

    // access api hubdat blue lite
    private function APIBluelist_blueLite() {
        $dataToken = parent::_initTokenHubdat();
            $bearerToken = 'Bearer ' . $dataToken["access_token"];

            $id = $_POST["id"];

            $response =  $this->APIDetailBlue('blue-lite', $bearerToken, $id);

            $detail = json_decode($response, true);

            $data = "<table class='table table-striped table-hover'>
                    <tbody>
                        " . $this->APIDetailBlueTRTAG('Nama Pemilik', $detail["nama_pemilik"]) . "
                        " . $this->APIDetailBlueTRTAG('Alamat Pemilik', $detail["alamat_pemilik"]) . "
                        " . $this->APIDetailBlueTRTAG('No Registrasi Kendaraan', $detail["no_registrasi_kendaraan"]) . "
                        " . $this->APIDetailBlueTRTAG('No Rangka', $detail["no_rangka"]) . "
                        " . $this->APIDetailBlueTRTAG('No Mesin', $detail["no_mesin"]) . "
                        " . $this->APIDetailBlueTRTAG('Jenis Kendaraan', $detail["jenis_kendaraan"]) . "
                        " . $this->APIDetailBlueTRTAG('Merk', $detail["merk"]) . "
                        " . $this->APIDetailBlueTRTAG('Tipe', $detail["tipe"]) . "
                        " . $this->APIDetailBlueTRTAG('Tahun Rakit', $detail["tahun_rakit"]) . "
                        " . $this->APIDetailBlueTRTAG('Bahan Bakar', $detail["bahan_bakar"]) . "
                        " . $this->APIDetailBlueTRTAG('Isi Silinder', $detail["isi_silinder"]) . "
                        " . $this->APIDetailBlueTRTAG('Daya Motor', $detail["daya_motor"]) . "
                        " . $this->APIDetailBlueTRTAG('Ukuran Ban', $detail["ukuran_ban"]) . "
                        " . $this->APIDetailBlueTRTAG('Sumbu', $detail["sumbu"]) . "
                        " . $this->APIDetailBlueTRTAG('Berat Kosong', $detail["berat_kosong"]) . "
                        " . $this->APIDetailBlueTRTAG('Panjang Kendaraan', $detail["panjang_kendaraan"]) . "
                        " . $this->APIDetailBlueTRTAG('Lebar Kendaraan', $detail["lebar_kendaraan"]) . "
                        " . $this->APIDetailBlueTRTAG('Tinggi Kendaraan', $detail["tinggi_kendaraan"]) . "
                        " . $this->APIDetailBlueTRTAG('Julur Depan', $detail["julur_depan"]) . "
                        " . $this->APIDetailBlueTRTAG('Julur Belakang', $detail["julur_belakang"]) . "
                        " . $this->APIDetailBlueTRTAG('Jarak Sumbu 1 2', $detail["jarak_sumbu_1_2"]) . "
                        " . $this->APIDetailBlueTRTAG('Jarak Sumbu 2 3', $detail["jarak_sumbu_2_3"]) . "
                        " . $this->APIDetailBlueTRTAG('Jarak Sumbu 3 4', $detail["jarak_sumbu_3_4"]) . "
                        " . $this->APIDetailBlueTRTAG('Dimensi Bak Tangki', $detail["dimensi_bak_tangki"]) . "
                        " . $this->APIDetailBlueTRTAG('JBB', $detail["jbb"]) . "
                        " . $this->APIDetailBlueTRTAG('JBKB', $detail["jbkb"]) . "
                        " . $this->APIDetailBlueTRTAG('JBI', $detail["jbi"]) . "
                        " . $this->APIDetailBlueTRTAG('JBKI', $detail["jbki"]) . "
                        " . $this->APIDetailBlueTRTAG('Daya Angkut Orang', $detail["daya_angkut_orang"]) . "
                        " . $this->APIDetailBlueTRTAG('Daya Angkut KG', $detail["daya_angkut_kg"]) . "
                        " . $this->APIDetailBlueTRTAG('Kelas Jalan', $detail["kelas_jalan"]) . "
                        " . $this->APIDetailBlueTRTAG('Keterangan hasil Uji Coba', $detail["keterangan_hasil_uji"]) . "
                        " . $this->APIDetailBlueTRTAG('Petugas Penguji', $detail["petugas_penguji"]) . "
                        " . $this->APIDetailBlueTRTAG('NRP Petugas Penguji', $detail["nrp_petugas_penguji"]) . "
                        " . $this->APIDetailBlueTRTAG('Kepala Dinas', $detail["kepala_dinas"]) . "
                        " . $this->APIDetailBlueTRTAG('Pangkat Kepala Dinas', $detail["pangkat_kepala_dinas"]) . "

                        " . $this->APIDetailBlueTRTAG('NIP Kepala Dinas', $detail["nip_kepala_dinas"]) . "
                        " . $this->APIDetailBlueTRTAG('Unit Pelaksana Teknis', $detail["unit_pelaksana_teknis"]) . "
                        " . $this->APIDetailBlueTRTAG('Direktur', $detail["direktur"]) . "
                        " . $this->APIDetailBlueTRTAG('Perangkat Direktur', $detail["pangkat_direktur"]) . "
                        " . $this->APIDetailBlueTRTAG('NIP Direktur', $detail["nip_direktur"]) . "
                        " . $this->APIDetailBlueTRTAG('No Uji Kendaraan', $detail["no_uji_kendaraan"]) . "
                    </tbody>
                </table>";

            $baseModel = new BaseModel();

            // log
            $log_param = json_encode((object)array(
                'no_registrasi_kendaraan' => $id
            ));

            $this->APIBlueLog($baseModel, $bearerToken, $log_param, $response);

            echo json_encode(array("success" => true, "data" => $data, "atr" => ["modal" => "modal_blue", "modal_body" => "modal_body_blue"]));
    }

    function blue_blueTestPeriod()
    {
        parent::_authDetail(function(){
            // fetch date blue test period no union
            // parent::_editOnlyBlueTestPeriod('m_blue', $this->request->getPost());

            // fetch data blue test period union
            $res_data = ['no_registrasi_kendaraan', 'date(date)'];

            parent::_editModalCustomBlue('m_blue', $this->request->getPost(), $res_data, '', 
            ['select a.date, a.nama_pemilik, a.alamat_pemilik, a.no_srut, a.tgl_srut, a.no_registrasi_kendaraan, a.no_rangka, a.no_mesin, a.jenis_kendaraan, a.merk, a.tipe, a.tahun_rakit, a.bahan_bakar, a.isi_silinder, a.daya_motor, a.berat_kosong, a.panjang_kendaraan, a.lebar_kendaraan, a.tinggi_kendaraan, a.julur_depan, a.julur_belakang, a.jbb, a.jbkb, a.jbi, a.jbki, a.daya_angkut_orang, a.daya_angkut_kg, a.kelas_jalan, a.keterangan_hasil_uji, a.masa_berlaku, a.petugas_penguji, a.nrp_petugas_penguji, a.kepala_dinas, a.pangkat_kepala_dinas, a.nip_kepala_dinas, a.unit_pelaksana_teknis, a.direktur, a.pangkat_direktur, a.nip_direktur, a.is_deleted, a.created_at, a.created_by, a.updated_at, a.updated_by 
                from m_blue a 
                where a.is_deleted = 0',
            'select b.date, b.nama_pemilik, b.alamat_pemilik, b.no_srut, b.tgl_srut, b.no_registrasi_kendaraan, b.no_rangka, b.no_mesin, b.jenis_kendaraan, b.merk, b.tipe, b.tahun_rakit, b.bahan_bakar, b.isi_silinder, b.daya_motor, b.berat_kosong, b.panjang_kendaraan, b.lebar_kendaraan, b.tinggi_kendaraan, b.julur_depan, b.julur_belakang, b.jbb, b.jbkb, b.jbi, b.jbki, b.daya_angkut_orang, b.daya_angkut_kg, b.kelas_jalan, b.keterangan_hasil_uji, b.masa_berlaku, b.petugas_penguji, b.nrp_petugas_penguji, b.kepala_dinas, b.pangkat_kepala_dinas, b.nip_kepala_dinas, b.unit_pelaksana_teknis, b.direktur, b.pangkat_direktur, b.nip_direktur, b.is_deleted, b.created_at, b.created_by, b.updated_at, b.updated_by
                from m_bluerfid b 
                where b.is_deleted = 0
            '], 'test-period', 'test-period');

            //  fetch api blue test period
            // $this->APIBluelist_blueTestPeriod();
        });
    }

    // access api hubdat blue test period
    private function APIBluelist_blueTestPeriod() {
        $dataToken = parent::_initTokenHubdat();
            $bearerToken = 'Bearer ' . $dataToken["access_token"];

            $id = $_POST["id"];

            $response =  $this->APIDetailBlue('blue-test-period', $bearerToken, $id);

            $detail = json_decode($response, true);

            $statusUjiBerkala = $detail["status_uji_berkala"] ? "true" : "false";

            $data = "<table class='table table-striped table-hover'>
                    <tbody>
                        " . $this->APIDetailBlueTRTAG('Status Uji Berkala', $detail["no_registrasi_kendaraan"]) . "
                        " . $this->APIDetailBlueTRTAG('No Registrasi Kendaraan', $statusUjiBerkala) . "
                        " . $this->APIDetailBlueTRTAG('Tempat Uji Terakhir', $detail["tempat_uji_terakhir"]) . "
                        " . $this->APIDetailBlueTRTAG('Hasil Uji Terakhir', $detail["hasil_uji_terakhir"]) . "
                        " . $this->APIDetailBlueTRTAG('Date', date("Y-m-d", strtotime($detail["date"] ))) . "
                    </tbody>
                </table>";

            $baseModel = new BaseModel();

            // log
            $log_param = json_encode((object)array(
                'no_registrasi_kendaraan' => $id
            ));

            $this->APIBlueLog($baseModel, $bearerToken, $log_param, $response);

            echo json_encode(array("success" => true, "data" => $data, "atr" => ["modal" => "modal_blue", "modal_body" => "modal_body_blue"]));
    }

    function blue_blueLast()
    {
        parent::_authDetail(function(){
            // fetch data blue test period union
            $res_data = ['no_registrasi_kendaraan', 'date(date)'];

            parent::_editModalCustomBlue('m_blue', $this->request->getPost(), $res_data, '', 
            ['select a.date, a.nama_pemilik, a.alamat_pemilik, a.no_srut, a.tgl_srut, a.no_registrasi_kendaraan, a.no_rangka, a.no_mesin, a.jenis_kendaraan, a.merk, a.tipe, a.tahun_rakit, a.bahan_bakar, a.isi_silinder, a.daya_motor, a.berat_kosong, a.panjang_kendaraan, a.lebar_kendaraan, a.tinggi_kendaraan, a.julur_depan, a.julur_belakang, a.jbb, a.jbkb, a.jbi, a.jbki, a.daya_angkut_orang, a.daya_angkut_kg, a.kelas_jalan, a.keterangan_hasil_uji, a.masa_berlaku, a.petugas_penguji, a.nrp_petugas_penguji, a.kepala_dinas, a.pangkat_kepala_dinas, a.nip_kepala_dinas, a.unit_pelaksana_teknis, a.direktur, a.pangkat_direktur, a.nip_direktur, a.is_deleted, a.created_at, a.created_by, a.updated_at, a.updated_by 
                from m_blue a 
                where a.is_deleted = 0',
            'select b.date, b.nama_pemilik, b.alamat_pemilik, b.no_srut, b.tgl_srut, b.no_registrasi_kendaraan, b.no_rangka, b.no_mesin, b.jenis_kendaraan, b.merk, b.tipe, b.tahun_rakit, b.bahan_bakar, b.isi_silinder, b.daya_motor, b.berat_kosong, b.panjang_kendaraan, b.lebar_kendaraan, b.tinggi_kendaraan, b.julur_depan, b.julur_belakang, b.jbb, b.jbkb, b.jbi, b.jbki, b.daya_angkut_orang, b.daya_angkut_kg, b.kelas_jalan, b.keterangan_hasil_uji, b.masa_berlaku, b.petugas_penguji, b.nrp_petugas_penguji, b.kepala_dinas, b.pangkat_kepala_dinas, b.nip_kepala_dinas, b.unit_pelaksana_teknis, b.direktur, b.pangkat_direktur, b.nip_direktur, b.is_deleted, b.created_at, b.created_by, b.updated_at, b.updated_by
                from m_bluerfid b 
                where b.is_deleted = 0
            '], 'last');

            //  fetch api blue last
            // $this->APIBluelist_blueLast();
        });
    }

    // access api hubdat blue last
    private function APIBluelist_blueLast() {
        $dataToken = parent::_initTokenHubdat();
        $bearerToken = 'Bearer ' . $dataToken["access_token"];

        $id = $_POST["id"];

        $response =  $this->APIDetailBlue('blue-last', $bearerToken, $id);

        $detail = json_decode($response, true);

        $uji = json_decode($detail['uji'], JSON_UNESCAPED_SLASHES);

        $data = "<table class='table table-striped table-hover'>
                <tbody>
                    " . $this->APIDetailBlueTRTAG('No Registrasi Kendaraan', $detail["no_registrasi_kendaraan"]) . "
                    " . $this->APIDetailBlueTRTAG('Date', date("Y-m-d", strtotime($detail["date"] ))) . "
                ";

        foreach($uji as $key => $value) {
            $data .= "
                " . $this->APIDetailBlueTRTAG('Item Uji ' . ($key + 1), $value["item_uji"]) . "
                " . $this->APIDetailBlueTRTAG('Ambang Batas ' . ($key + 1), $value["ambang_batas"]) . "
                " . $this->APIDetailBlueTRTAG('Hasil Uji ' . ($key + 1), $value["hasiluji"]) . "
            ";
        }

        $data .= "
                </tbody>
            </table>";

        $baseModel = new BaseModel();

        // log
        $log_param = json_encode((object)array(
            'no_registrasi_kendaraan' => $id
        ));

        $this->APIBlueLog($baseModel, $bearerToken, $log_param, $response);

        echo json_encode(array("success" => true, "data" => $data, "atr" => ["modal" => "modal_blue", "modal_body" => "modal_body_blue"]));
    }

    // ignore blue rfid, blue >< blue rfid
    function bluerfidlist_load()
    {
        parent::_authLoad(function(){
            $dataToken = parent::_initTokenHubdat();
            $bearerToken = 'Bearer ' . $dataToken["access_token"];

            $start = $_POST["start"];
            $length = $_POST["length"];
            $search = $_POST["search"];
            $searching = "";
            if($search != "") {
                $searching = '&no_registrasi_kendaaraan=' . $search;
            }

            $response =  $this->APIListBlue('ekir-pengujian', $bearerToken, $start, $length, [], $searching);

            $data = json_decode($response, true);

            $baseModel = new BaseModel();

            // log
            $log_param = json_encode((object)array(
                'skip' => $start,
                'limit' => $length,
                'sort' => 'ASC',
                'search' => $searching
            ));

            $this->APIBlueLog($baseModel, $bearerToken, $log_param, $response);

            // blue dummy
            // $this->db->truncate('m_bluerfid');
            // $this->APIBlueListDummy($baseModel, $bearerToken, 'ekir-pengujian', 'm_bluerfid');

            echo json_encode(array("data" => $data["data"], "recordsTotal" => $data["total"], "recordsFiltered" => $data["limit"]));
        });
    }

    // ignore blue rfid, blue >< blue rfid
    function bluerfidlist_blueRfidLast()
    {
        parent::_authDetail(function(){
            $dataToken = parent::_initTokenHubdat();
            $bearerToken = 'Bearer ' . $dataToken["access_token"];

            $id = $_POST["id"];

            $response =  $this->APIDetailBlue('ekir-pengujian-last', $bearerToken, $id);

            $decode = json_decode($response, true);
            $detail = $decode["data"][0];

            $data = "<table class='table table-striped table-hover'>
                    <tbody>
                        " . $this->APIDetailBlueTRTAG('RFID', $detail["rfid"]) . "
                        " . $this->APIDetailBlueTRTAG('VCODE', $detail["vcode"]) . "
                        " . $this->APIDetailBlueTRTAG('Date', $detail["date"]) . "
                        " . $this->APIDetailBlueTRTAG('Nama Pemilik', $detail["nama_pemilik"]) . "
                        " . $this->APIDetailBlueTRTAG('Alamat Pemilik', $detail["alamat_pemilik"]) . "
                        " . $this->APIDetailBlueTRTAG('No Srut', $detail["no_srut"]) . "
                        " . $this->APIDetailBlueTRTAG('Tgl Srut', $detail["tgl_srut"]) . "
                        " . $this->APIDetailBlueTRTAG('Tgl Persochip', $detail["tgl_persochip"]) . "
                        " . $this->APIDetailBlueTRTAG('Tgl Persovisual', $detail["tgl_persovisual"]) . "
                        " . $this->APIDetailBlueTRTAG('Tgl Cetak Sertifikat', $detail["tgl_cetak_sertifikat"]) . "
                        " . $this->APIDetailBlueTRTAG('No Registrasi Kendaraan', $detail["no_registrasi_kendaraan"]) . "
                        " . $this->APIDetailBlueTRTAG('No Rangka', $detail["no_rangka"]) . "
                        " . $this->APIDetailBlueTRTAG('No Mesin', $detail["no_mesin"]) . "
                        " . $this->APIDetailBlueTRTAG('Jenis Kendaraan', $detail["jenis_kendaraan"]) . "
                        " . $this->APIDetailBlueTRTAG('Merk', $detail["merk"]) . "
                        " . $this->APIDetailBlueTRTAG('Tipe', $detail["tipe"]) . "
                        " . $this->APIDetailBlueTRTAG('Tahun Rakit', $detail["tahun_rakit"]) . "
                        " . $this->APIDetailBlueTRTAG('Bahan Bakar', $detail["bahan_bakar"]) . "
                        " . $this->APIDetailBlueTRTAG('Isi Silinder', $detail["isi_silinder"]) . "
                        " . $this->APIDetailBlueTRTAG('Daya Motor', $detail["daya_motor"]) . "
                        " . $this->APIDetailBlueTRTAG('Berat Kosong', $detail["berat_kosong"]) . "
                        " . $this->APIDetailBlueTRTAG('Panjang Kendaraan', $detail["panjang_kendaraan"]) . "
                        " . $this->APIDetailBlueTRTAG('Lebar Kendaraan', $detail["lebar_kendaraan"]) . "
                        " . $this->APIDetailBlueTRTAG('Tinggi Kendaraan', $detail["tinggi_kendaraan"]) . "
                        " . $this->APIDetailBlueTRTAG('Julur Depan', $detail["julur_depan"]) . "
                        " . $this->APIDetailBlueTRTAG('Julur Belakang', $detail["julur_belakang"]) . "
                        " . $this->APIDetailBlueTRTAG('JBB', $detail["jbb"]) . "
                        " . $this->APIDetailBlueTRTAG('JBKB', $detail["jbkb"]) . "
                        " . $this->APIDetailBlueTRTAG('JBI', $detail["jbi"]) . "
                        " . $this->APIDetailBlueTRTAG('JBKI', $detail["jbki"]) . "
                        " . $this->APIDetailBlueTRTAG('Daya Angkut Orang', $detail["daya_angkut_orang"]) . "
                        " . $this->APIDetailBlueTRTAG('Daya Angkut KG', $detail["daya_angkut_kg"]) . "
                        " . $this->APIDetailBlueTRTAG('Kelas Jalan', $detail["kelas_jalan"]) . "
                        " . $this->APIDetailBlueTRTAG('Keterangan hasil Uji Coba', $detail["keterangan_hasil_uji"]) . "
                        " . $this->APIDetailBlueTRTAG('Masa Berlaku', $detail["masa_berlaku"]) . "
                        " . $this->APIDetailBlueTRTAG('Petugas Penguji', $detail["petugas_penguji"]) . "
                        " . $this->APIDetailBlueTRTAG('NRP Petugas Penguji', $detail["nrp_petugas_penguji"]) . "
                        " . $this->APIDetailBlueTRTAG('Kepala Dinas', $detail["kepala_dinas"]) . "
                        " . $this->APIDetailBlueTRTAG('Perangkat Kepala Dinas', $detail["pangkat_kepala_dinas"]) . "
                        " . $this->APIDetailBlueTRTAG('NIP Kepala Dinas', $detail["nip_kepala_dinas"]) . "
                        " . $this->APIDetailBlueTRTAG('Kode Pelaksana Teknis', $detail["kode_pelaksana_teknis"]) . "
                        " . $this->APIDetailBlueTRTAG('Unit Pelaksana Teknis', $detail["unit_pelaksana_teknis"]) . "
                        " . $this->APIDetailBlueTRTAG('Direktur', $detail["direktur"]) . "
                        " . $this->APIDetailBlueTRTAG('Pangkat Direktur', $detail["pangkat_direktur"]) . "
                        " . $this->APIDetailBlueTRTAG('NIP Direktur', $detail["nip_direktur"]) . "
                    </tbody>
                </table>";

            $baseModel = new BaseModel();

            // log
            $log_param = json_encode((object)array(
                'no_registrasi_kendaraan' => $id
            ));

            $this->APIBlueLog($baseModel, $bearerToken, $log_param, $response);

            echo json_encode(array("success" => true, "data" => $data, "atr" => ["modal" => "modal_blue", "modal_body" => "modal_body_blue"]));
        });
    }

    // access api hubdat blue list
    private function APIListBlue($service, $bearerToken, $start, $length, $filter = [], $search = "") {
        $url = "";
        if(!$filter) {
            $url = getenv('service.hubdat') . '/ehubdat/v1/' . $service . '?skip=' . $start . '&limit=' . $length . '&sort=ASC' . $search;
        } else {
            $url = getenv('service.hubdat') . '/ehubdat/v1/' . $service . '?skip=' . $start . '&limit=' . $length . '&sort=ASC' . $filter[0] . '' . $filter[1];
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
              'Authorization: ' . $bearerToken
            ),
          ));

          $response = curl_exec($curl);
          
          curl_close($curl);

          return $response;
    }

    // access api hubdat blue detail
    private function APIDetailBlue($service, $bearerToken, $id) {
        $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => getenv('service.hubdat') . '/ehubdat/v1/' . $service . '?no_registrasi_kendaraan=' . $id,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Authorization: ' . $bearerToken
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);

            return $response;
    }

    // blue log
    function APIBlueLog($baseModel, $bearerToken, $log_param, $response) {
        $log_api = [
            "log_method" => 'get',
            "log_url" => get_current_request_url(),
            "log_token" => $bearerToken,
            "log_header" => json_encode((object)array(
                'Authorization' => $bearerToken,
            )),
            "log_param" => $log_param,
            "log_result" => $response,
            "log_ip" => get_client_ip(),
            "log_user_agent" => get_client_user_agent()
        ];

        $baseModel->log_api($log_api, $response);
    }

    // blue dummy run
    function APIBlueListDummy($baseModel, $bearerToken, $service, $db) {
        // insert data api to database #100 data
        for($i = 0; $i <= 4; $i++) {
            $response =  $this->APIListBlue($service, $bearerToken, $i * 20, 20, []);

            $data = json_decode($response, true);

            foreach($data["data"] as $value) {
                $value["created_by"] = $this->session->id;
                $baseModel->base_insert($value, $db);
            }
        }
    }

    // access api hubdat get tr tag
    function APIDetailBlueTRTAG($label, $value) {
        return "<tr>
            <td>" . $label . "</td>
            <td> : </td>
            <td>" . $value . "</td>
        </tr>";
    }
    
}
