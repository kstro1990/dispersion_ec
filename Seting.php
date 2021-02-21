<?php
session_start();
class Seting
{
  public function auth($logi="",$trank="")
  {
    try {
      $auth = new stdClass();
      $auth->login = $logi;
      $auth->nonce =  "hola"; //'abc123toma'; gmp_random
      $auth->seed = date('c');
      $auth->tranKey = base64_encode(hash('sha1', $auth->nonce . $auth->seed . $trank , true));
      // $auth->escrito = ($auth->nonce.$auth->seed."yOE5h0US32Wd3c7D");
      // $auth->solo=sha1($auth->nonce . $auth->seed . "yOE5h0US32Wd3c7D" ,false);
      // $auth->tranKey = base64_encode(sha1( $auth->escrito, true));
      $auth->nonce = base64_encode($auth->nonce);
      return $auth;
    } catch (\Exception $e) {
      return $e;
    }
  }

  public function tdcSet($tdc,$cvv,$expirationMonth,$expirationYear){
    $card = new stdClass();
    $card->number = $tdc;
    if (!$cvv == "") {
      $card->cvv = $cvv;
      $card->expirationMonth = $expirationMonth;
      $card->expirationYear = $expirationYear;
      $instrument = new stdClass();
      $instrument->card = $card;
      return $instrument;
    }else {
      $instrument = new stdClass();
      $instrument->card = $card;
      return $instrument;
    }
  }

  public function amountSet($total=0,$airlineValor=0,$merchantValor=0,$agreementAirline=11){
    $amount = new stdClass();
    $amount->currency = "USD";
    $amount->total = $total;
    $payment = new stdClass();
        // uniqid();
    $payment->reference = "airline_test_WC_".rand();
    $payment->description = 'descripcion de pago';
    $payment->amount = $amount;
    //IVA si es necesario
    // TODO: construir if para que sea dinamico
    $taxes = new stdClass();
    // $payment->taxes = $taxes->taxesSet();
    $amountAirline = [
        "currency" => "USD",
        "total" => $airlineValor,
    ];
    $amountMerchant = [
        "currency" => "USD",
        "total" => $merchantValor,
    ];
    if (!$airlineValor && !$merchantValor) {
      echo"estoy medio lleno ";
    }
    $dispersion = [
        [
            "agreement" => $agreementAirline,
            "agreementType" => "AIRLINE",
            "amount" => $amountAirline,            
        ],
        [
           "agreement" => null,
           "agreementType" => "MERCHANT",
           "amount" => $amountMerchant,   
        ]
    ];
    $payment->dispersion = $dispersion; 
    return $payment;
  }
  public function payerSet($data)
  {
    $payer = new stdClass();
    $payer->document="";
    $payer->documentType="";
    $payer->name="";
    $payer->surname="";
    $payer->email="";
    $payer->mobile="";
  }

  public function additionalSet($data){
    $additional = new stdClass();
    foreach ($data as $key => $value) {
      $additional->$key = $value;
    }
    return $additional;
  }
  public function creditGet(){
    $credit = new stdClass();
    $credit->code ="";
    $credit->type ="";
    $credit->groupCode ="";
    $credit->installment ="";
    return $credit;
  }
  public function baseSet(){
    $base = new stdClass();
    $base->userAgent = $_SERVER['HTTP_USER_AGENT'];
    $base->ipAddress="192.123.123.1";
    $base->locale="es_EC";
  }
  public function taxesSet($base=0){
    $Taxo = new stdClass();
    //IVA
    $Taxo->kind="valueAddedTax";
    $Taxo->amount="12";
    $Taxo->base="100";
    return $Taxo;
  }
  public function buyerSet(){
    $Buyer = new stdClass();
    $Buyer->name="Deion";
    $Buyer->surname="Ondricka";
    $Buyer->email="dnetix@yopmail.com";
    $Buyer->document="1040035000";
    $Buyer->documentType="CI";
    $Buyer->mobile= "3006108300";
    return $Buyer;
  }

}

$new = new Seting();

$request =[
  "auth" => $new->auth($_POST['login'],$_POST['trankey']),
  "locale" => "es_EC",
  "buyer" => $new->buyerSet(),
  "payment" =>  $new->amountSet($_POST['total'],$_POST['valorAirline'],$_POST['valorMerchant'],$_POST['airline']),
	"expiration" =>"2021-02-30T11:27:04-05:00",
	"ipAddress"  => "181.132.206.170",
	"returnUrl"  => "https://dnetix.co/p2p/client",
	"userAgent"  => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36"
];


$denco= json_encode($request);
//  echo $denco;
$url = 'https://test.placetopay.ec/redirection/api/session';
//Se inicia. el objeto CUrl
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $denco);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'User-Agent: cUrl Testing'));
$result = curl_exec($ch);
// header('Content-Type: application/json');
//  echo($result);

 
$resOBJ = json_decode($result);
// var_dump($resOBJ);
$urlProcess = $resOBJ->processUrl;
$requestID = $resOBJ->requestId;
$status = $resOBJ->status;
// $_SESSION[$requestID];

echo ($urlProcess);


 ?>
