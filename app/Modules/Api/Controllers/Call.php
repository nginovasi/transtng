<?php namespace App\Modules\Api\Controllers;

use App\Modules\Api\Models\ApiModel;
use App\Core\BaseController;

class Call extends BaseController
{
    private $apiModel;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->apiModel = new ApiModel();
    }

    public function index()
	{
		return redirect()->to(base_url()); 
	}

    public function voip()
    {   
        $sender = $this->request->getPost('sender');
        $room = $this->request->getPost('room');
        $handler = $this->request->getPost('handler');

        $petugas = json_decode($this->request->getPost('petugas'), true);
        $results = [];

        $curl = curl_init();

        foreach ($petugas as $pt) {
            $results[$pt['id']] = $pt['type'] == 'iOS' ? $this->ios($curl, $sender, $room, $pt['token'], $handler) : $this->android($curl, $sender, $room, $pt['token']);
        }

        curl_close($curl);

        return json_encode($results);
    }

    private function android($curl, $sender, $room, $token) {
        
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://fcm.googleapis.com/fcm/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                "to": "'.$token.'",
                "data": {
                    "incoming_video_call": "1",
                    "incoming_name": "'.$sender.'",
                    "room": "'.$room.'",
                    "url": "https://devel2.nginovasi.id/"
                }
            }',
            CURLOPT_HTTPHEADER => array(
                'Authorization: key=AAAAzdnMDpk:APA91bHGqr46b8DXtkEnV1D_quks7zEImJwlSkDBXpt1NjMmgZgnc0K987tBlX3b8HgAppbCwkZ0RSK2HLEUVJMMcw5PozRy-rFCwuV8pwsrQg-XfCi6OlFxVt27Jr3aHB-23teNYRgl',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        return $response;
    }

    private function ios($curl, $sender, $room, $token, $handler = nil) {
        if (defined("CURL_VERSION_HTTP2") && (curl_version()["features"] & CURL_VERSION_HTTP2) !== 0) {
            $body ['aps'] = array (
                "alert" => array (
                    "status" => 1,
                    "title" => "Mitra Darat",
                    "body" => "VOIP service",
                    "data" => array (
                        "UUID" => "ABCDE-FGHIJ-KLMNO",
                        "sender" => $sender,
                        "room" => $room,
                        "url" => "https://devel2.nginovasi.id/",
                        "handler" => $handler
                    ),
                )
            );

            $curlconfig = array(
                CURLOPT_URL => "https://api.development.push.apple.com/3/device/". $token,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => json_encode($body),
                CURLOPT_SSLCERT => APPPATH . "../cert_call/voip_apns.pem",
                CURLOPT_SSLCERTPASSWD => "mitradarat",
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_2_0,
                CURLOPT_VERBOSE => true
            );

            curl_setopt_array($curl, $curlconfig);

            $res = curl_exec($curl);

            if ($res === FALSE) {
                return('Curl failed: ' . curl_error($curl));
            }else{
                return $res;
            }
        }else{
            return "No HTTP/2 support on client.";
        }
    }

    function multi_thread_curl($tokenArray, $optionArray, $nThreads) {

        //Group your urls into groups/threads.
        $curlArray = array_chunk($tokenArray, $nThreads, $preserve_keys = true);
    
        //Iterate through each batch of urls.
        $ch = 'ch_';
        foreach($curlArray as $threads) {      
            //Create your cURL resources.
            foreach($threads as $thread=> $token) {
                ${$ch . $thread} = curl_init();
                curl_setopt_array(${$ch . $thread}, $optionArray); //Set your main curl options.
                curl_setopt(${$ch . $thread}, CURLOPT_URL, "https://api.development.push.apple.com/3/device/" . $token); //Set url.
            }

            //Create the multiple cURL handler.
            $mh = curl_multi_init();

            //Add the handles.
            foreach($threads as $thread=>$value) {
                curl_multi_add_handle($mh, ${$ch . $thread});
            }

            $active = null;
            //execute the handles.

            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);


            while ($active && $mrc == CURLM_OK) {
                if (curl_multi_select($mh) != -1) {
                    do {
                        $mrc = curl_multi_exec($mh, $active);
                    } while ($mrc == CURLM_CALL_MULTI_PERFORM);
                }
            }

            //Get your data and close the handles.
            foreach($threads as $thread => $value) {
                $results[$thread] = curl_multi_getcontent(${$ch . $thread});
                curl_multi_remove_handle($mh, ${$ch . $thread});
            }

            //Close the multi handle exec.
            curl_multi_close($mh);
        }
        
        return $results;
    } 
}