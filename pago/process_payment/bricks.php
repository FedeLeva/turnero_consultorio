<?php
   require_once '../vendor/autoload.php';
 
   MercadoPago\SDK::setAccessToken("TEST-5952401225197401-042414-2c01f5121619fe18a5dc28ecae3bd178-284444760");
  ;

  $data = json_decode(file_get_contents('php://input'), true);
  



   $payment = new MercadoPago\Payment();
   $payment->transaction_amount = (float)$data['transaction_amount'];
   $payment->token = $data['token'];
   $payment->description = 'Esta es la descripcion';
   $payment->installments = (int)$data['installments'];
   $payment->payment_method_id = $data['payment_method_id'];
   $payment->issuer_id = (int)$data['issuer_id'];
 
   $payer = new MercadoPago\Payer();
   $payer->email = $data['payer']['email'];
   $payer->identification = $data['payer']['identification'];
   $payment->payer = $payer;
 
   $payment->save();
 
   $response = array(
       'status' => $payment->status,
       'status_detail' => $payment->status_detail,
       'id' => $payment->id
   );
   echo json_encode($response);


?>