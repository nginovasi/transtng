<?php namespace App\Modules\Main\Controllers;

use App\Core\BaseController;
use App\Modules\Main\Models\MainModel;

class Main extends BaseController
{
    private $mainModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->mainModel = new MainModel();
    }

    public function index()
    {

        return view('App\Modules\Main\Views\layout');
    }

    public function test()
    {
        return view('App\Modules\Main\Views\test');
    }

    // public function rampcheck_recode(){
    //     $this->mainModel->rampcheck_recode();
    // }

    public function terminallatlng(){
        $rs = $this->db->query("select id,terminal_name,terminal_lat,terminal_lng,terminal_city_name from m_terminal where terminal_lat is null");
        foreach($rs->getResult() as $item){
            echo $item->terminal_name." ".$item->terminal_city_name;
            #$this->searchbyaddrname($item->terminal_name,$item->id);
            echo "<br/>";
        }
    }

    public function searchbyaddrname($addr,$id){
        //$url = "https://nominatim.openstreetmap.org/search.php?q='.rawurlencode($addr).',%20indonesia&polygon_geojson=0&format=jsonv2";
        $response = shell_exec('/usr/bin/lynx -dump "https://nominatim.openstreetmap.org/search.php?q='.rawurlencode($addr).',%20indonesia&polygon_geojson=0&format=jsonv2"');

        $response_obj = json_decode($response);
        if(isset($response_obj[0])){
            echo "<br/>";
            $sql = "update m_terminal set terminal_lat='".$response_obj[0]->lat.",".$response_obj[0]->lon."' where id='".$id."' ";
            echo $sql;
            $this->db->query($sql);
            echo "<br/>";
        }else{
            echo "<br/>Not found<br/>";
        }
        // $curl = curl_init();

        // curl_setopt_array($curl, array(
        //   CURLOPT_URL => $url,
        //   CURLOPT_RETURNTRANSFER => true,
        //   CURLOPT_ENCODING => '',
        //   CURLOPT_MAXREDIRS => 10,
        //   CURLOPT_TIMEOUT => 0,
        //   CURLOPT_FOLLOWLOCATION => true,
        //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //   CURLOPT_CUSTOMREQUEST => 'GET',
        // ));

        // $response = curl_exec($curl);

        // curl_close($curl);
        // echo $response;
    }

    public function getDataApi()
    {
        $response = $this->mainModel->getDataTraffic();

        echo $response[0]->log_result;
    }

    public function getDataDashboard()
    {
        $data['terminalCount'] = $this->mainModel->getTerminalCount();
        $data['rampcheckCount'] = $this->mainModel->getRampcheckCount();
        $data['trayekCount'] = $this->mainModel->getTrayekCount();
        echo json_encode($data);
    }

    public function APIGetLiveTrack()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://dashboard.angkutankspn.com/api/get_live_tracking',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic aHViZGF0X2tzcG46aHViZGF0MjAyMWtzcG4=',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function APIGetEasyGo()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://vtsapi.easygo-gps.co.id/api/Report/lastposition',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
              "list_nopol": [],
              "list_no_aset": [],
              "status_vehicle": 0,
              "geo_code": [],
              "page": 0,
              "encrypted": 0
            }',
            CURLOPT_HTTPHEADER => array(
                'accept: application/json',
                'token: CD25107B152E4509854F543651D225B7',
                'Content-Type: application/json',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function getTerminal()
    {
        $response = $this->mainModel->getDataTerminal();

        echo json_encode($response);
    }

    public function getCctv()
    {
        $response = $this->mainModel->getDataCctv();

        echo json_encode($response);
    }

    public function getJto()
    {
        $response = $this->mainModel->getDataJto();

        echo json_encode($response);
    }

    public function APIGetTrafficLight()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://x1.kemenhub.id/api/atms?query=%22SELECT%20*%20FROM%20trafficlight%22',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic YWRtaW5hdG1zMjphZG1pbmF0bXMyMDIx',
                'Cookie: PHPSESSID=gsr7p1hu37v1f44kpq07ua41pq; PHPSESSID=0tnd5k0oc19qv5dccr7rog0mfg',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function APIGetSimpang()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://x1.kemenhub.id/api/atms?query=%22SELECT%20*%20FROM%20simpang%22',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic YWRtaW5hdG1zMjphZG1pbmF0bXMyMDIx',
                'Cookie: PHPSESSID=gsr7p1hu37v1f44kpq07ua41pq; PHPSESSID=3p64kg3r40rq4pr0jfai6v9vj9',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function APIGetANPR()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://x1.kemenhub.id/api/atms?query=%22SELECT%20*%20FROM%20anpr%22',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic YWRtaW5hdG1zMjphZG1pbmF0bXMyMDIx',
                'Cookie: PHPSESSID=gsr7p1hu37v1f44kpq07ua41pq; PHPSESSID=nshnbnpue6acrnt8ui90geqmka',
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

    public function getRuteMudik()
    {
        $data = $this->mainModel->getRuteMudik();
        echo json_encode($data);
    }
    
    public function getPoskoMudik()
    {
        $data = $this->mainModel->getPoskoMudik();
        echo json_encode($data);
    }

    public function getPetugasLapangan()
    {
        $data = $this->mainModel->getPetugasLapangan();
        echo json_encode($data);
    }

    public function getRampcheckHistory()
    {
        $data = $this->mainModel->getRampcheckHistory();
        echo json_encode($data);
    }

    public function getCountRampcheckToday()
    {
        $data = $this->mainModel->getCountRampcheckToday();
        echo json_encode($data);
    }

    public function getCountRampcheckPerStatus()
    {
        $data = $this->mainModel->getCountRampcheckPerStatus();
        echo json_encode($data);
    }

    public function getCountRampcheckPerInstansi()
    {
        $data = $this->mainModel->getCountRampcheckPerInstansi();
        echo json_encode($data);
    }

    public function getTopTenRampcheckLocationPerBptd()
    {
        $data = $this->mainModel->getTopTenRampcheckLocationPerBptd();
        echo json_encode($data);
    }

    public function getTopFiveUserRampcheckPerBptd()
    {
        $data = $this->mainModel->getTopFiveUserRampcheckPerBptd();
        echo json_encode($data);
    }

    public function getCountRampcheckPerJenisAngkutan()
    {
        $data = $this->mainModel->getCountRampcheckPerJenisAngkutan();
        echo json_encode($data);
    }

    // count armada bis mudik by eo
    public function getCountArmadaBisByEO()
    {
        $data = $this->mainModel->getCountArmadaBisByEO();
        echo json_encode($data);
    }

    // count jadwal mudik by eo
    public function getCountJadwalMudikByEO()
    {
        $data = $this->mainModel->getCountJadwalMudikByEO();
        echo json_encode($data);
    }

    // count armada truck mudik by eo
    public function getCountArmadaTruckByEO()
    {
        $data = $this->mainModel->getCountArmadaTruckByEO();
        echo json_encode($data);
    }

    // count jadwal motis by eo
    public function getCountJadwalMotisByEO()
    {
        $data = $this->mainModel->getCountJadwalMotisByEO();
        echo json_encode($data);
    }

    // count percentage armada bis mudik by eo
    public function getCountPercentageArmadaBisByEO()
    {
        $data = $this->mainModel->getCountPercentageArmadaBisByEO();
        echo json_encode($data);
    }

    // count percentage armada truck mudik by eo
    public function getCountPercentageArmadaTruckByEO()
    {
        $data = $this->mainModel->getCountPercentageArmadaTruckByEO();
        echo json_encode($data);
    }

    // count all pemudik by eo
    public function getCountAllPemudikByEO()
    {
        $data = $this->mainModel->getCountAllPemudikByEO();
        echo json_encode($data);
    }

    // count all motis by eo
    public function getCountAllMotisByEO()
    {
        $data = $this->mainModel->getCountAllMotisByEO();
        echo json_encode($data);
    }

    public function getCountRampcheckTodayStat()
    {
        $data = $this->mainModel->getCountRampcheckTodayStat();
        echo json_encode($data);
    }

    public function getCountRampcheckPerBptd()
    {
        $data = $this->mainModel->getCountRampcheckPerBptd();
        echo json_encode($data);
    }
    public function getLastFiveRampcheck()
    {
        $data = $this->mainModel->getLastFiveRampcheck();
        echo json_encode($data);
    }

    public function getListJadwalMudikPercentage() 
    {
        $data = $this->mainModel->getListJadwalMudikPercentage();
        echo json_encode($data);
    }

    public function getListJadwalMudikPercentageAvail() 
    {
        $data = $this->mainModel->getListJadwalMudikPercentageAvail();
        echo json_encode($data);
    }

    public function getListJadwalMotisPercentage() 
    {
        $data = $this->mainModel->getListJadwalMotisPercentage();
        echo json_encode($data);
    }

    public function getMudikInfo()
    {
        $data = $this->mainModel->getMudikInfo();
        echo json_encode($data);
    }

    public function getCountAllVerifByEO()
    {
        $data = $this->mainModel->getCountAllVerifByEO();
        echo json_encode($data);
    }

    public function getCountArmadaRampcheck()
    {
        $data = $this->mainModel->getCountArmadaRampcheck();
        echo json_encode($data);
    }

    public function getCountArmadaRampcheckToday()
    {
        $data = $this->mainModel->getCountArmadaRampcheckToday();
        echo json_encode($data);
    }
}
