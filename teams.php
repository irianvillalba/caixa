<?php

include 'consulta.php';

$consulta = new Consulta();
$post = json_decode(file_get_contents('php://input'));
$mensagem = "<p><b>Sistema/Módulo:</b> {$post->sistema} <b>Ambiente:</b> {$post->ambiente}</p>";

switch ($post->pergunta) {
  case 'sistema':
    $sistema = $consulta->sistema($post->sistema, $post->ambiente);      
    foreach($sistema as $sis) {
      $mensagem .= "<li>{$sis['sistema']}</li>";
    }
  break;
  case 'modulo':
    $sistema = $consulta->modulo($post->sistema, $post->ambiente);
    foreach($sistema as $sis) {
      $servidores = json_decode($sis['servidores_json']);
      $mensagem .= "<li>{$sis['sistema']} | {$servidores[0]->nome} | {$servidores[0]->ip} | {$sis['status']}</li>";
    }
  break;
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://caixa.webhook.office.com/webhookb2/00596809-802b-4505-997a-9ecca3e20771@ab9bba98-684a-43fb-add8-9c2bebede229/IncomingWebhook/8db4a7ffc05f43a19faabbac1488e0b3/9b0fde04-ec4e-483e-b86e-160674f579b0',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_SSL_VERIFYHOST => 0,
  CURLOPT_SSL_VERIFYPEER => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>"{'text': '{$mensagem}'}",
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  )
));

$response = curl_exec($curl);

curl_close($curl);
