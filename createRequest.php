<?php

include('Seting.php');

class CreateRequest 
{
    public function session($ctype, $amount, $name, $surname, $email, $phone, $mobile)
    {
        $request = new stdClass();
        $new = new Seting();
        $request->auth = $new ->auth();
        $request->buyer = $new ->buyerSet();
        $request->payment = $new -> amountSet("90.36");
        $request->expiration = "2019-08-03T15:43:05-05:00";
        $request->returnUrl = "http://localhost/webcheckout/";
        $request->ipAddress = "192.162.12.34";
        $request->userAgent = "Mozilla/5.0 (Windows NT 6.3; Win64; x64)";

        $denco= json_encode($request);
        $url = 'https://test.placetopay.ec/redirection/api/session';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $denco);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'User-Agent: cUrl Testing'));
        $result = curl_exec($ch);
        return  $result;
    }

    public function getRequesInformation()
    {
        $request = new stdClass();
        $new = new Autentication();
        $request->auth = $new ->auth();

        $denco= json_encode($request);
        $url = 'https://test.placetopay.ec/redirection/api/session/'.'115861';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $denco);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'User-Agent: cUrl Testing'));
        $result = curl_exec($ch);
        return  $result;
    }
}

$new = new CreateRequest();
//Cambiar por el metodo que se desea invocar
$resultado = $new ->getRequesInformation();
$denco = json_encode($resultado);
echo $denco;

?>