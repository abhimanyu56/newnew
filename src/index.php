<?php 


namespace Abhimanyusingh\Abhimanyu;

class Index
{

    private $BASE_URL;

    function __construct() {
        include("utils.php");
        $this->BASE_URL = $BASE_URL;
        $this->POST_BASE_URL = $POST_BASE_URL;
        $this->HASH = new Hash();

    }

    /**
     * @Method: Returns ticket data for all markets.
     */
    public function getTicketData()
    {
        return $this->sendRequest($this->BASE_URL . "/ticker/v1.0/liveData");
    }

    /**
     * @Method: Returns data for all currency.
     */
    public function getAllCurrency()
    {
        return $this->sendRequest($this->BASE_URL . "/ticker/v1.0/allCurrencies");
    }

    /**
     * @Method: Returns data for single market.
     */
    public function geSingleMarketTicketData($param = null)
    {
        $symbol = $param ? $param : "USDT-BTC";
        return $this->sendRequest($this->BASE_URL . "/ticker/v1.0/liveData?symbol=$symbol");
    }

    /**
     * @Method: Returns Order Book for single market.
     */
    public function geSingleMarketOrderBook($param = null)
    {
        $symbol = $param ? $param : "INR-BTC";
        return $this->sendRequest($this->BASE_URL . "/ticker/v1.0/liveOrderBook?symbol=$symbol");
    }

    /**
     * @Method: Returns Last Trades For single Market.
     */
    public function geSingleMarketLastTrades($param = null)
    {
        $symbol = $param ? $param : "USDT-BTC";
        return $this->sendRequest($this->BASE_URL . "/ticker/v1.0/liveOrderBook?symbol=$symbol");
    }



    // POST CALLS

     /**
     * @Method: Returns Last Trades For single Market.
     */
    public function getWallet( $apiKey, $secretKey, $payload = {})
    {
        $nonce = time();
        $headers = {};
        $headers["buc-nonce"] = $nonce;
        $headers["buc-apikey"] = $apiKey;
        $headers["buc-signature"] = sortObjectAndHash(
        $payload,
        $secretKey,
        $nonce
        );

        return $this->sendPostRequest($this->POST_BASE_URL . "/api/wallet/v1.0/walletPortfolio", $headers, $payload);

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

    private function sendPostRequest($url, $headers, $postfields)
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
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postfields,
            CURLOPT_HTTPHEADER => $headers,
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
