<?php 
namespace App\Modules\Export\Controllers;

use App\Modules\Export\Models\ExportModel;
use App\Core\BaseController;

class PdfAction extends BaseController
{
    private $exportModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->exportModel = new ExportModel();
    }

    public function index()
    {
        return redirect()->to(base_url()); 
    }

    function exportBlue(){
        // no registrasi kendaraan 
        $id = $this->request->uri->getSegment('4');

        // get one data order by date desc, the same data is too much
        $blue = $this->db->query("select a.id, a.date, a.nama_pemilik, a.alamat_pemilik, a.no_srut, a.tgl_srut, a.no_registrasi_kendaraan, a.no_rangka, a.no_mesin, a.jenis_kendaraan, a.merk, a.tipe, a.tahun_rakit, a.bahan_bakar, a.isi_silinder, a.daya_motor, a.berat_kosong, a.panjang_kendaraan, a.lebar_kendaraan, a.tinggi_kendaraan, a.julur_depan, a.julur_belakang, a.jbb, a.jbkb, a.jbi, a.jbki, a.daya_angkut_orang, a.daya_angkut_kg, a.kelas_jalan, a.keterangan_hasil_uji, a.masa_berlaku, a.petugas_penguji, a.nrp_petugas_penguji, a.kepala_dinas, a.pangkat_kepala_dinas, a.nip_kepala_dinas, a.unit_pelaksana_teknis, a.direktur, a.pangkat_direktur, a.nip_direktur, a.link_pdf,a.is_deleted, a.created_at, a.created_by, a.updated_at, a.updated_by 
                                    from m_blue a
                                        where a.is_deleted = 0
                                        and a.no_registrasi_kendaraan=" . "'" . $id . "'" . "
                                    UNION ALL
                                    select b.id, b.date, b.nama_pemilik, b.alamat_pemilik, b.no_srut, b.tgl_srut, b.no_registrasi_kendaraan, b.no_rangka, b.no_mesin, b.jenis_kendaraan, b.merk, b.tipe, b.tahun_rakit, b.bahan_bakar, b.isi_silinder, b.daya_motor, b.berat_kosong, b.panjang_kendaraan, b.lebar_kendaraan, b.tinggi_kendaraan, b.julur_depan, b.julur_belakang, b.jbb, b.jbkb, b.jbi, b.jbki, b.daya_angkut_orang, b.daya_angkut_kg, b.kelas_jalan, b.keterangan_hasil_uji, b.masa_berlaku, b.petugas_penguji, b.nrp_petugas_penguji, b.kepala_dinas, b.pangkat_kepala_dinas, b.nip_kepala_dinas, b.unit_pelaksana_teknis, b.direktur, b.pangkat_direktur, b.nip_direktur, b.link_pdf, b.is_deleted, b.created_at, b.created_by, b.updated_at, b.updated_by 
                                    from m_bluerfid b
                                        where b.is_deleted = 0
                                        and b.no_registrasi_kendaraan=" . "'" . $id . "'" . " order by date desc limit 1". "
                                    ")->getRow();

        $this->export($id, $blue, '\blueexport_pdf', 'no_registrasi_kendaraan');
	}

	function exportSpionam(){
        // noken 
        $id = $this->request->uri->getSegment('4');

        // get one data order by id desc, the same data is too much
        $spionam = $this->db->query("  select id,perusahaan_id,jenis_pelayanan,kode_kendaraan,noken,no_uji,tgl_exp_uji,no_kps,tgl_exp_kps,no_srut,CONCAT( LEFT( no_rangka, LENGTH( no_rangka ) -3 ) ,  'xxx' ) as no_rangka,CONCAT( LEFT( no_mesin, LENGTH( no_mesin ) -3 ) ,  'xxx' ) as no_mesin,merek,tahun,seat,barang,kode_trayek,nama_trayek,rute,etl_date,link_pdf
                        from m_spionam 
                        where noken='".$id."' order by id desc limit 1")
                        ->getRow();

        $this->export($id, $spionam, '\spionamexport_pdf', 'noken');
	}

    function exportEtilang(){
        // noken 
        $id = $this->request->uri->getSegment('4');

        // get one data order by tanggal penindakan desc, the same data is too much
        $etilang = $this->db->query("SELECT * 
                                    from m_etilang 
                                    where no_polisi= " . "'" . $id . "'" . " order by tanggal_penindakan desc")
                                    ->getRow();

        $this->export($id, $etilang, '\etilangexport_pdf', 'no_polisi');
	}

    function exportJtoMaster(){
        // noken 
        $id = $this->request->uri->getSegment('4');

        // get one data order by etl_date desc, the same data is too much
        $jtoPenindakan = $this->db->query("SELECT * 
                                            from m_jto 
                                            where id= " . "'" . $id . "'" . " order by etl_date desc")
                                    ->getRow();

        $this->export($id, $jtoPenindakan, '\jtomasterexport_pdf', 'id');
	}

    function exportJtoPenindakan(){
        // no kend 
        $id = $this->request->uri->getSegment('4');

        // get one data order by tanggal penindakan desc, the same data is too much // not implementasi
        $jtoPenindakan = $this->db->query("SELECT a.id, a.nama_jembatan, max(b.tanggal) as tanggal, a.toleransi, b.no_kend, b.pelanggaran, b.link_pdf
                                    from m_jto a
                                    left join s_jto_penindakan b
                                    on a.id = b.idjt
                                    where b.no_kend= " . "'" . $id . "'" . "
                                    group by a.id")
                                    ->getRow();

        $this->export($id, $jtoPenindakan, '\jtopenindakanexport_pdf', 'no_kend');
	}

    private function export($id, $result, $file, $idName){
        // mpf
		$mpdf = new \Mpdf\Mpdf(['format' => 'A5']);
		$mpdf->curlAllowUnsafeSslRequests = true;

        // layout html view
        $data['result'] = $result ? $result : null;
		$html = view('App\Modules\Export\Views' . $file , $data);

		$mpdf->AddPage('L','', '', '', '',
        20, // margin_left
        20, // margin right
        5, // margin top
      	10, // margin bottom
        90, // margin header
        10); // margin footer

        // template background pdf
        $pagecount = $mpdf->SetSourceFile('assets/template.pdf');
        $tplIdx = $mpdf->ImportPage($pagecount);

        $mpdf->useTemplate($tplIdx);

		$mpdf->WriteHTML($html);

        // set header, so that the data return pdf, no binary text
        $this->response->setHeader("Content-Type", "application/pdf");

        // output name pdf
        $name = $result ? $result->$idName : 'none';
		$mpdf->Output('SKD - '.$id.' - '. $name .'.pdf','I');
	}

    private function exportRamp($id, $result, $file, $idName){
        // mpf
		$mpdf = new \Mpdf\Mpdf(['format' => 'A5']);
		$mpdf->curlAllowUnsafeSslRequests = true;

        // layout html view
        $data['result'] = $result ? $result : null;
		$html = view('App\Modules\Export\Views' . $file , $data);

        $mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch', 'setAutoBottomMargin' => 'stretch']);

        $mpdf->SetHTMLHeader('
        <div style="text-align: center;"><img src="' . base_url() . '/assets/img/hubdat.png" style="display: block; padding-bottom: 10px; width: 30%;"></div>
        <div style="text-align: center; font-size: 18px; font-weight: bold; letter-spacing: 3px;">FORMULIR INSPEKSI KESELAMATAN <br> PEMERIKSAAN KENDARAAN UMUM</div>
        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
        ');
        $mpdf->SetHTMLFooter('
          <div style="text-align: center;"><img src="' . base_url() . '/assets/img/logo.png" style="display: block; width: 20%;"></div>
         ');
        $mpdf->SetWatermarkImage(base_url().'/assets/img/dishubdat.png');
        $mpdf->watermarkImageAlpha = 0.05;
        $mpdf->showWatermarkImage = true;
        $mpdf->WriteHTML($html);
        $this->response->setHeader('Content-Type', 'application/pdf');
        $name = $result ? $result->$idName : 'none';
        $mpdf->Output('SKD - '.$id.' - '. $name .'.pdf','I');
	}

    function exportRampcheck(){
        
        $id = $this->request->uri->getSegment('4');

        $rampcheckRs = $this->db->query("SELECT a.id, a.rampcheck_no, a.rampcheck_sticker_no,a.rampcheck_date, f.jenis_lokasi_name, coalesce(h.terminal_name, a.rampcheck_nama_lokasi) AS terminal_name, a.rampcheck_pengemudi, a.rampcheck_umur_pengemudi, a.rampcheck_po_name, a.rampcheck_noken, a.rampcheck_stuk,g.jenis_angkutan_name AS jenis_angkutan_name, a.rampcheck_trayek AS trayek_name,
        CAST(CONCAT('[', IF(b.rampcheck_id IS NULL, '', GROUP_CONCAT(DISTINCT JSON_OBJECT('rampcheck_adm_ku', b.rampcheck_adm_ku, 'rampcheck_adm_kpr', b.rampcheck_adm_kpr, 'rampcheck_adm_kpc', b.rampcheck_adm_kpc, 'rampcheck_adm_sim', b.rampcheck_adm_sim))),']')AS json) AS administrasi,
        CAST(CONCAT('[', IF(b.rampcheck_id IS NULL, '', GROUP_CONCAT(DISTINCT JSON_OBJECT('rampcheck_utu_lukd', d.rampcheck_utu_lukd, 'rampcheck_utu_lukj', d.rampcheck_utu_lukj, 'rampcheck_utu_lpad', d.rampcheck_utu_lpad, 'rampcheck_utu_lpaj', d.rampcheck_utu_lpaj, 'rampcheck_utu_lm', d.rampcheck_utu_lm, 'rampcheck_utu_lr', d.rampcheck_utu_lr, 'rampcheck_utu_kru', d.rampcheck_utu_kru, 'rampcheck_utu_krp', d.rampcheck_utu_krp, 'rampcheck_utu_kbd', d.rampcheck_utu_kbd, 'rampcheck_utu_kbb', d.rampcheck_utu_kbb, 'rampcheck_utu_skp', d.rampcheck_utu_skp, 'rampcheck_utu_pk', d.rampcheck_utu_pk, 'rampcheck_utu_pkw', d.rampcheck_utu_pkw, 'rampcheck_utu_pd', d.rampcheck_utu_pd, 'rampcheck_utu_jd', d.rampcheck_utu_jd, 'rampcheck_utu_apk', d.rampcheck_utu_apk, 'rampcheck_utu_apar', d.rampcheck_utu_apar))),']')AS json) AS unsur_utama,
        CAST(CONCAT('[', IF(b.rampcheck_id IS NULL, '', GROUP_CONCAT(DISTINCT JSON_OBJECT('rampcheck_utp_sp_dpn', c.rampcheck_utp_sp_dpn, 'rampcheck_utp_sp_blk', c.rampcheck_utp_sp_blk, 'rampcheck_utp_bk_kcd', c.rampcheck_utp_bk_kcd, 'rampcheck_utp_bk_pu', c.rampcheck_utp_bk_pu, 'rampcheck_utp_bk_kru', c.rampcheck_utp_bk_kru, 'rampcheck_utp_bk_krp', c.rampcheck_utp_bk_krp, 'rampcheck_utp_bk_ldt', c.rampcheck_utp_bk_ldt, 'rampcheck_utp_ktd_jtd', c.rampcheck_utp_ktd_jtd, 'rampcheck_utp_pk_bc', c.rampcheck_utp_pk_bc, 'rampcheck_utp_pk_sp', c.rampcheck_utp_pk_sp, 'rampcheck_utp_pk_dkr', c.rampcheck_utp_pk_dkr, 'rampcheck_utp_pk_pbr', c.rampcheck_utp_pk_pbr, 'rampcheck_utp_pk_ls', c.rampcheck_utp_pk_ls, 'rampcheck_utp_pk_pgr', c.rampcheck_utp_pk_pgr, 'rampcheck_utp_pk_skp', c.rampcheck_utp_pk_skp, 'rampcheck_utp_pk_ptk', c.rampcheck_utp_pk_ptk))),']')AS json) AS unsur_penunjang,
        CAST(CONCAT('[', IF(b.rampcheck_id IS NULL, '', GROUP_CONCAT(DISTINCT JSON_OBJECT('rampcheck_kesimpulan_status', e.rampcheck_kesimpulan_status, 'rampcheck_kesimpulan_catatan', e.rampcheck_kesimpulan_catatan, 'rampcheck_kesimpulan_ttd_pengemudi', e.rampcheck_kesimpulan_ttd_pengemudi, 'rampcheck_kesimpulan_nama_penguji', e.rampcheck_kesimpulan_nama_penguji, 'rampcheck_kesimpulan_no_penguji', e.rampcheck_kesimpulan_no_penguji, 'rampcheck_kesimpulan_ttd_penguji', e.rampcheck_kesimpulan_ttd_penguji, 'rampcheck_kesimpulan_nama_penyidik', e.rampcheck_kesimpulan_nama_penyidik, 'rampcheck_kesimpulan_no_penyidik', e.rampcheck_kesimpulan_no_penyidik, 'rampcheck_kesimpulan_ttd_penyidik', e.rampcheck_kesimpulan_ttd_penyidik, 'nama_pengemudi', a.rampcheck_pengemudi))),']')AS json) AS unsur_kesimpulan,json_arrayagg((json_object('lampiran',CONCAT('https://mitradarat.dephub.go.id/',i.document_filename)))) as foto_pendukung

        FROM t_rampcheck a
        JOIN t_rampcheck_adm b ON b.rampcheck_id = a.id
        JOIN t_rampcheck_utp c ON c.rampcheck_id = a.id
        JOIN t_rampcheck_utu d ON d.rampcheck_id = a.id
        JOIN t_rampcheck_kesimpulan e ON e.rampcheck_id = a.id
        JOIN m_jenis_lokasi f ON f.id = a.rampcheck_jenis_lokasi_id
        JOIN m_jenis_angkutan g ON g.id = a.rampcheck_jenis_angkutan_id
        LEFT JOIN m_terminal h ON h.id = a.rampcheck_nama_lokasi
        LEFT JOIN m_document_rampcheck i ON a.id=i.rampcheck_id
        WHERE a.is_deleted = 0 AND sha1(sha1(a.rampcheck_no))=" . "'" . $id . "'" . " group by a.id")
        ->getRow();

        $this->exportRamp($id, $rampcheckRs, '\rampcheckexport_pdf', 'rampcheck_no');
    }


    function eTicket(){
        // noken 
        $id = $this->request->uri->getSegment('4');

        // get one data order by tanggal penindakan desc, the same data is too much
        $datares = $this->db->query("SELECT a.`billing_code`,b.billing_user_id,
        json_arrayagg((json_object(
        'data_qr',sha1(sha1(a.transaction_number)),
        'data_nik',a.transaction_nik,
        'data_nama',a.transaction_booking_name,
        'billing_code',a.billing_code,
        'rute',d.route_name,
        'armada_code',e.armada_code,
        'terminal_name',f.terminal_name,
        'jadwal_date_depart',DATE_FORMAT(c.jadwal_date_depart,'%d %b %Y'),
        'jadwal_time_depart',DATE_FORMAT(c.jadwal_time_depart,'%H:%i')))) as data_penumpang
         from t_transaction_mudik a
         LEFT JOIN t_billing_mudik b on a.billing_id=b.id
         LEFT JOIN t_jadwal_mudik c on b.billing_jadwal_id=c.id
         LEFT JOIN m_route d on c.`jadwal_route_id`=d.id
         LEFT JOIN m_armada_mudik e on c.`jadwal_armada_id`=e.id
         LEFT JOIN m_terminal f on d.`terminal_from_id`=f.id
        where sha1(sha1(a.billing_code))=" . "'" . $id . "'" . " and a.is_verified != 2")->getRow();

        $this->exportTicket($id, $datares, '\eTicket_pdf', 'billing_code');
	}

    function eTicketMotis(){
        // noken 
        $id = $this->request->uri->getSegment('4');

        // get one data order by tanggal penindakan desc, the same data is too much
        $datares = $this->db->query("SELECT a.id as billing_id,a.motis_code,sha1(sha1(a.motis_code)) as data_qr,b.no_kendaraan,b.nik_pendaftar_kendaraan,e.armada_name,e.armada_code,d.route_name,f.terminal_name,DATE_FORMAT(c.jadwal_date_depart,'%d %b %Y') as date_depart ,b.nama_pemilik_kendaraan as user_mobile_name ,
        DATE_FORMAT(c.jadwal_time_depart,'%H:%i') as time_depart
        from t_billing_motis_mudik a
        LEFT JOIN `t_motis_manifest_mudik` b on a.motis_code=b.motis_billing_code
         LEFT JOIN t_jadwal_motis_mudik c on a.motis_jadwal_id=c.id
         LEFT JOIN m_route d on c.`jadwal_route_id`=d.id
         LEFT JOIN m_armada_motis_mudik e on a.motis_armada_id=e.id
         LEFT JOIN m_terminal f on d.`terminal_from_id`=f.id
         LEFT JOIN m_user_mobile g on a.motis_user_id=g.id
        where sha1(sha1(a.motis_code))=" . "'" . $id . "'" . "  and a.motis_status_verif != 2 group by a.id")->getRow();

        $this->exportTicket($id, $datares, '\eTicketMotis_pdf', 'motis_code');
	}

    private function exportTicket($id, $result, $file, $idName){
        $this->response->setHeader('Content-Type', 'application/pdf');
        // mpf
		$mpdf = new \Mpdf\Mpdf(['format' => 'A5']);
		$mpdf->curlAllowUnsafeSslRequests = true;

        // layout html view
        $data['result'] = $result ? $result : null;
		$html = view('App\Modules\Export\Views' . $file , $data);

        $mpdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch', 'setAutoBottomMargin' => 'stretch', 'format' => [100, 210]]);

        $mpdf->AddPage(
            'L',
            '',
            '',
            '',
            '',
            8, // margin_left
            10, // margin right
            30, // margin top
            5, // margin bottom
            90, // margin header
            10
        ); // margin footer

        $pagecount = $mpdf->SetSourceFile('assets/verifikasi.pdf');
        $tplIdx = $mpdf->ImportPage($pagecount);
        

        $mpdf->useTemplate($tplIdx);
        $mpdf->WriteHTML($html);
        $name = $result ? $result->$idName : 'none';
        $mpdf->Output('SKD - '.$id.' - '. $name .'.pdf','I');



	}




}
