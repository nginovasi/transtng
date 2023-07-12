<?php namespace App\Modules\Api\Controllers\Settlement;

use App\Core\BaseController;
use App\Modules\Api\Models\ApiModel;

class Emoney extends BaseController
{
    private $publikModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiModel = new ApiModel();
    }

    public function test(){
        echo 'jan';
    }

    public function generate()
    {
        $inputDateTrx = $this->request->getUri()->getSegment(4);
        if($inputDateTrx != ''){
            $dateTrx = $inputDateTrx;
        } else {
            $dateTrx = date('Y-m-d');
        }

        $sttlData = $this->db->query("SELECT
                                        date_trx as folder,
                                        CONCAT('808108','_',mid,'_',CONCAT(date_format(date_trx,'%Y%m%d'),DATE_FORMAT(max(created_at),'%H%i%s')),'_',LPAD(shift,2,'0')) as file_name,
                                        CONCAT(LPAD(COUNT(*),7,'0'),LPAD(SUM(SUBSTRING(body, 29, 10)),12,'0')) AS header,
                                        COUNT(*) AS count_trx,
                                        SUM(SUBSTRING(body, 29, 10))/100 AS amount_trx,
                                        JSON_ARRAYAGG(body) as body,
                                        mid,
                                        tid,
                                        shift
                                    FROM sttl_brizzi WHERE date_trx = '$dateTrx' GROUP BY mid,tid,shift")->getResult();
        if(empty($sttlData)){
            $res['success'] = false;
            $res['status'] = 91;
            $res['message'] = "Data tidak ditemukan, contoh format tanggal 2023-07-09";
            $res['data'] = null;
        }else{
            $data = array();
            
            foreach($sttlData as $file){
                $parse['file_name'] = $file->file_name;
                $parse['header'] = $file->header;
                $parse['mid'] = $file->mid;
                $parse['tid'] = $file->tid;
                $parse['shift'] = $file->shift;
                $parse['body'] = array();

                if(!is_dir(FCPATH.'public/settlement/brizzi/'.$file->folder) )
                {
                    mkdir(FCPATH.'public/settlement/brizzi/'.$file->folder,0775,TRUE);
                }

                $file_dir = FCPATH.'public/settlement/brizzi/'.$file->folder.'/'.$file->file_name.'.bri';
                
                $sttl = $file->header;
                $arrBody = json_decode($file->body);
                foreach($arrBody as $body){
                    array_push($parse['body'],$body);
                    $sttl.="\r\n";
				    $sttl.=$body;
                }
                array_push($data,$parse);

                $sttl.="\r\n";
                $current = ((file_exists($file_dir))?file_get_contents($file_dir):'');
                $current .= $sttl;

                $this->db->query("UPDATE sttl_brizzi 
                                        SET filename = '$file->file_name',
                                        header = '$file->header',
                                        is_sttl = '1'
                                    WHERE date_trx = '$dateTrx'
                                    AND mid = '$file->mid'
                                    AND tid = '$file->tid'
                                    AND shift = '$file->shift'");

                file_put_contents($file_dir, $current);
            }

            $res['success'] = true;
            $res['status'] = 100;
            $res['message'] = "Sukses";
            $res['data'] = $data;
        }

        return $this->response->setJSON($res);
    }
   
}