<?php 

namespace Abhimanyusingh\Abhimanyu;

class Index
{

    //$BASE_URL = 'https://api.buyucoin.com';


    public function getTicketData()
    {
        return $this->sendRequest("https://api.buyucoin.com/ticker/v1.0/liveData");
    }

    private function sendRequest($url)
    {
        try{
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
                'Content-Type: application/json'
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            return $response;
        } catch (customException $e) {
            return $e->errorMessage();
        }
    }
}




class customException extends \Exception {
    public function errorMessage() {
      //error message
      $errorMsg = 'Error on line '.$this->getLine().' in '.$this->getFile()
      .': <b>'.$this->getMessage().'</b> is not a valid E-Mail address';
      return $errorMsg;
    }
  }
