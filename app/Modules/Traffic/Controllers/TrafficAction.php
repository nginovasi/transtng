<?php namespace App\Modules\Traffic\Controllers;

use App\Core\BaseController;
use App\Modules\Traffic\Models\TrafficModel;

class TrafficAction extends BaseController
{
    private $rampcheckModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->rampcheckModel = new TrafficModel();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function trafficcount_APIGetTrafficCount()
    {
        $response = $this->rampcheckModel->getDataTraffic();

        echo $response[0]->log_result;

    }

    public function livetrack_APIGetLiveTrack()
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
}
