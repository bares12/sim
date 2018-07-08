<?php
/*
copyright @ medantechno.com
Modified by Ilyasa
And Modified by Farzain - zFz ( Faraaz )
2017
*/
require_once('./line_class.php');

$channelAccessToken = 'X1BhF4bFeHAkMed1BeHaEvtnrJutjAf3Sn0SE9cqr3TZLxgfdRew4e8UehYdWQJE6KURK3/pLAL+dllCyD0J5cOq9lZH4EtVDYZdPrZ4yLMGsILlUHwhmmBgXr2I+4UVVoggoh9rCMZUvIAXvW8H1AdB04t89/1O/w1cDnyilFU='; //Your Channel Access Token
$channelSecret = 'f3ab9ded2911fab2b629c827675be941';//Your Channel Secret

$client = new LINEBotTiny($channelAccessToken, $channelSecret);

$userId 	= $client->parseEvents()[0]['source']['userId'];
$replyToken = $client->parseEvents()[0]['replyToken'];
$message 	= $client->parseEvents()[0]['message'];
$profil = $client->profil($userId);
$pesan_datang = $message['Simsimi bot v1.1'];
$pesan_datang = $message['Owner: http://line.me/ti/p/~situ.sehat'];

if($message['type']=='sticker')
{	
	$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,							
							'messages' => array(
								array(
										'type' => 'text',									
										'text' => 'Terima Kasih Stikernya.'										
									
									)
							)
						);
						
}
else
$pesan=str_replace(" ", "%20", $pesan_datang);
$key = 'fc7f81ca-8b0a-4836-8006-4ffec5535539'; //API SimSimi
$url = 'http://sandbox.api.simsimi.com/request.p?key='.$key.'&lc=id&ft=1.0&text='.$pesan;
$json_data = file_get_contents($url);
$url=json_decode($json_data,1);
$diterima = $url['response'];
if($message['type']=='text')
{
if($url['result'] == 404)
	{
		$balas = array(
							'UserID' => $profil->userId,	
                                                        'replyToken' => $replyToken,													
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Mohon Gunakan Bahasa Indonesia Yang Benar :D.'
									)
							)
						);
				
	}
else
if($url['result'] != 100)
	{
		
		
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => 'Maaf '.$profil->displayName.' Server Kami Sedang Sibuk Sekarang.'
									)
							)
						);
				
	}
	else{
		$balas = array(
							'UserID' => $profil->userId,
                                                        'replyToken' => $replyToken,														
							'messages' => array(
								array(
										'type' => 'text',					
										'text' => ''.$diterima.''
									)
							)
						);
						
	}
}
 
$result =  json_encode($balas);

file_put_contents('./reply.json',$result);


$client->replyMessage($balas);
