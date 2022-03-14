<?php 

$BASE_URL = 'https://api.buyucoin.com';
$POST_BASE_URL = 'https://buyucoinapidev.bucndev.com';


class Hash
  {
    public function sortObjectAndHash($object, $secret, $nonce) {

      $object['nonce'] = $nonce;
      $obj = sortObject($object);
      $checksum = generateChecksum(json_encode($obj,$secret));
      return $chcksum;
    }
    
    private function generateChecksum($str, $secret) {
        $one = crypt(hash_hmac("sha256", $secret));
        $data = base64_encode($one);
        return $data;
    }
    
    private function sortObject($object) {
      $sortedObj = {};
      $keys = get_object_vars($object);
      $keys = usort($keys, 'compare_weights');
    
      foreach ($keys as $key) {
        if (is_object($key) && !is_array($key)) {
          $sortedObj[$key] = sortObject($object[$key]);
        } else {
          $sortedObj[$key] = $object[$key];
        }
      }
      return $sortedObj;
    }
    
    
    private function compare_weights($a, $b) { 
      if($a == $b) {
          return 0.0;
      } 
      return ($a->weight < $b->weight) ? -1.0 : 1.0;
    } 





  }

