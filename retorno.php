
                     <?php
date_default_timezone_set('America/Sao_Paulo');
        header("access-control-allow-origin: https://sandbox.pagseguro.uol.com.br");
ini_set('default_charset','utf8');


	
$servernamei = "";
$usernamei = "";
$passwordi = "";
$dbnamei = "";


$conn = new mysqli($servernamei, $usernamei, $passwordi,$dbnamei);
mysqli_set_charset($conn,"utf8");

if ($conn->connect_error) {
die("FALHA NA CONEXAO: " . $conn->connect_error);
}
echo "CONEXAO OK";


         if (count($_POST)>0) {

                   $email = "";
                   $token = "";
                   $notificationCode = $_POST['notificationCode'];
                   $url = "https://ws.pagseguro.uol.com.br/v2/transactions/notifications/"
				   .$notificationCode."?email=".$email."&token=".$token;

                   $curl = curl_init($url);
                   curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
                   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                   $response = curl_exec($curl);
                   $http = curl_getinfo($curl);


                   if($response == 'Unauthorized'){
                            print_r($response);
                            exit;
                   }
                   curl_close($curl);
                   $response= simplexml_load_string($response);

                   if(count($response -> error) > 0){
                            print_r($response);
                            exit;
                   }



                   $file = fopen("LogPagSeguro.$today.txt", "ab");
                   $hour = date("H:i:s T");
                   fwrite($file,"Hora da consulta: $hour \r \n");

                   fwrite($file, "Código da transação:".$response->code." \r \n");
			 		$codigops = $response->code;
                   fwrite($file, "Status da transação:".$response->status." \r \n");
			 		$statusps = $response->status;
			  		fwrite($file, "Nome:".$response->sender->name." \r \n");
			 		$nomeps= $response->sender->name;
			 		fwrite($file, "Email:".$response->sender->email." \r \n");
			 		$emailps= $response->sender->email;
			 		fwrite($file, "DDD:".$response->sender->phone->areaCode." \r \n");
			 		$dddps= $response->sender->phone->areaCode;
					fwrite($file, "Telefone:".$response->sender->phone->number." \r \n");
			 		$telps= $response->sender->phone->number;
			 		$foneps = "($dddps) ";
			 		$foneps .= "$telps";

			 		fwrite($file, "Descrição:".$response->items->item->description." \r \n");
			 		$descricao= $response->items->item->description;

			 		fwrite($file, "CPF:".$response->sender->documents->document->value." \r \n");
			 		$cpfpessoal= $response->sender->documents->document->value;

			  fwrite($file, "Valor:".$response->grossAmount." \r \n");
			 		$valorpago= $response->grossAmount;

			 fwrite($file, "REF:".$response->reference." \r \n");
			 $refps= $response->reference;

			 		$hoje = date('Y-m-d h:i:s a');
			 
		

			  fwrite($file, "Codigo:".$response->paymentMethod->code." \r \n");




                fwrite($file, "MEIO DE PAGAMENTO:".$resultadom." \r \n");



			

                    $search = $conn->query("SELECT * FROM inscricao WHERE idpagseguro='$codigops'");
	
			         if($search->num_rows>0) {
		

 					$search = $conn->query("UPDATE inscricao SET statuspagseguro='$statusps', datainscricaoh='$hoje', metodo='$resultadom' WHERE idpagseguro='$codigops'");
				 }

			



		 }



?>
