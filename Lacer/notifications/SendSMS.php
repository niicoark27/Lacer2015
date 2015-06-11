<?php 





/**
 * Created by PhpStorm.
 * User: kwabenaboadu
 * Date: 4/27/15
 * Time: 4:14 PM
 */
$rec = array("233241048040","233249431562");
$msg = "This+is+a+trail";




    const SMS_BASE_URL = 'http://mvp.vasintel.com:8080/mcore-in';
    const SMS_FROM = 'Vasoft Court Application';
    const ORIGINATOR = 'J4U';

     function sendTextMessage(array $recipients, $message)
    {
        sendUsingCurl($recipients, $message);
    }

     function sendUsingGuzzle(array $recipients, $message) {
        $api_username = "admin@vassoft.com";
        $api_password = "kd832ls23mlksd";

        try {
            $auth_basic = preg_replace('#\=$#', '', base64_encode($api_username . ':' . $api_password));
            $client = new Client([
                'base_url' => SMS_BASE_URL,
                'defaults' => [
                    'auth' => [$api_username, $api_password]
//                    'headers' => ['Authorization' => 'Basic ' . $auth_basic]
                ]
            ]);

            $response = $client->get(null, [
                'query' => [
                    'mobile_number' => implode(',', $recipients),
                    'originator' => urlencode(SMS_FROM),
                    'text' => urlencode($message),
                    'request_delivery' => TRUE
                ]
            ]);
            var_dump($response);
        } catch (RequestException $e) {
            var_dump($e);
            Log::info($e->getRequest());
            Log::info($e->getRequest()->getHeaders());
            if ($e->hasResponse()) {
                Log::info($e->getResponse());
            }
        }
    }

     function sendUsingCurl(array $recipients, $message) {
       $api_username = "admin@vassoft.com";
        $api_password = "kd832ls23mlksd";

        $credentials = $api_username . ':' . $api_password;

        $mobile_numbers = implode(',', $recipients);

        $url = SMS_BASE_URL . '?mobile_number=' . urlencode($mobile_numbers);
        $url .= '&originator='.urlencode(ORIGINATOR).'&text=' . urlencode($message);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST | CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, $credentials);

        $data = curl_exec($ch);

        if (curl_errno($ch)) {
            print "Error: " . curl_error($ch);
        } else {
            // Show me the result
            var_dump($data);
            curl_close($ch);
        }

    }
	


	sendTextMessage($rec,$msg);