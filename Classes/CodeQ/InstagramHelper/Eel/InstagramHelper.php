<?php
namespace CodeQ\InstagramHelper\Eel;

use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Annotations as Flow;


/* Eel helper as a wrapper around Twitter API
*/
class InstagramHelper implements ProtectedContextAwareInterface {

    protected $settings;

    /* Inject the settings
    *
    * @param array $settings
    * @return void
*/
    public function injectSettings(array $settings) {
        $this->settings = $settings;
    }

    public function getInstagramFeed( $requestType,  $get_param) {
        $access_token = $this->settings['accessToken'];
        $response = $this->getRecentImages($requestType, $get_param, $access_token);

        return json_decode($response)->data;
    }

    function getRecentImages($requestType, $get_params, $access_token){

        $url = "https://api.instagram.com/v1/$requestType/?access_token=$access_token&$get_params";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }


    public function allowsCallOfMethod($methodName) {
        return true;
    }
}
