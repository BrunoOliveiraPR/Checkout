<?php require_once('config.php');
    require_once('utils.php');?>

<html>
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, height=device-height, initial-scale=1, maximum-scale=1, user-scalable=no">

	
	<link rel="stylesheet" type="text/css" href="//bootswatch.com/3/flatly/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="//bootswatch.com/3/flatly/bootstrap.css">
</head>
	

	
<?php 
    
    $senderHash = htmlspecialchars($_POST["sh"]);

    $itemAmount = number_format($_POST["amount"], 2, '.', '');
    $valordocurso_b = number_format($_POST["valordocurso_b"], 2, '.', '');
    $shippingCoast = number_format($_POST["shippingCoast"], 2, '.', '');
    $installmentValue = number_format($_POST["installmentValue"], 2, '.', '');
    $installmentsQty = $_POST["installments"];
	
	
    $nomedocurso = $_POST["nomedocurso"];
	
    $id_controle = $_POST["id_controle"];
	
    $nomedoaluno = $_POST["nomedoaluno"];
	
    $cpfdoaluno = $_POST["cpfdoaluno"];
	
    $ddd = $_POST["ddd"];
	
    $teldoaluno = $_POST["teldoaluno"];
	
    $emaildoaluno = $_POST["emaildoaluno"];
	
    $senha = $_POST["senha"];
	
    $enderecodocurso = $_POST["enderecodocurso"];
	
    $cidadedocurso = $_POST["cidadedocurso"];

    $datadocurso = $_POST["datadocurso"];
	
	$professordocurso = $_POST["professordocurso"];
	

    $params = array(
        'email'                     => $PAGSEGURO_EMAIL,  
        'token'                     => $PAGSEGURO_TOKEN,
        'senderHash'                => $senderHash,
        'receiverEmail'             => $PAGSEGURO_EMAIL,
        'paymentMode'               => 'default', 
        'paymentMethod'             => 'BOLETO', 
        'currency'                  => 'BRL',
        'itemId1'                   => '0001',
        'itemDescription1'          => $nomedocurso,  
        'itemAmount1'               => $valordocurso,  
        'itemQuantity1'             => 1,
        'reference'                 => '00000001',
        'senderName'                => $nomedoaluno,
        'senderCPF'                 => $cpfdoaluno,
        'senderAreaCode'            => $ddd,
        'senderPhone'               => $teldoaluno,
        'senderEmail'               => $emaildoaluno,

        'shippingCost'              => '0.00',
        'maxInstallmentNoInterest'      => 2,
        'noInterestInstallmentQuantity' => 2,
        'installmentQuantity'       => '1',
        'installmentValue'          => $valordocurso,
		'shippingAddressRequired'	=> 'FALSE',
      
    );

    $header = array('Content-Type' => 'application/json; charset=UTF-8;');
    $response = curlExec($PAGSEGURO_API_URL."/transactions", $params, $header);
    $json = json_decode(json_encode(simplexml_load_string($response)));
	
	
	$linkdoboleto = $json->paymentLink;
	
	$condpag = $json->status;
if($condpag == '') {
echo '<div class="alert alert-danger" role="alert" style="margin-top: 50px">
  ERRO<br> 
  <strong>Não foi possível concluir a inscrição com esses dados.</strong> 
  <br> Tente refazer a inscrição revisando seus dados inseridos. <br> 
  Se o problema persistir, entre em contato com a Helix Cursos
</div>';
}
		
?>
	
	
	<style>
		
	img{
	max-width:100%;
	height:auto;
}
	
		
		/* Landing Page */
.container-full {
  margin: 0 auto;
  width: 100%;
  min-height:100%;
/*  color:#eee;*/
  overflow:hidden;
}
-----------------------------------------------*/
.loader {
	position: fixed;
	left: 0;
	top: 0;
	width: 100%;
	height: 100%;
	z-index: 99;
	background: url('https://6ed03b3e7ee716b29bc2dee79aafb8179ed53b19-www.googledrive.com/host/0B9VLbslO6g64UnFTUlQzWDVMdXM') 50% 50% no-repeat rgb(249,249,249);
}
.loader-container {
	width: 100%;
	height: 200px;
	position: absolute;
	top:0;
	bottom: 0;
	left: 0;
	right: 0;
	
	margin: auto;
	text-align: center;
}
	
		
		
	</style>

	
<body>

<div class='loader'>
  <div class='loader-container'>
    <h3><b>Salvando inscrição ...</b></h3>
    <div class='progress progress-striped success'>
      <div class='progress-bar progress-bar-success' id='bar' role='progressbar' style='width: 20%;'></div>
    </div>
  </div>
</div>

<div  class="container-full">
		<div class="container">
			<div class="row">
				<div>
				<div class="panel-body">
				<strong><p align="center" class="text-info"><img src="Untitled-1.png" width="900" height="200" alt=""/></p>
				</strong>
				</div>	
				</div>
			</div>
		</div>
	

	
		<div class="container">
			<div class="row">
	<div class="col-md-12">
	<div class="alert alert-dismissible alert-success">
  <h4>Inscrição finalizada!</h4>
  <p>Clique abaixo em visualizar para acessar seu boleto. Na área do aluno você poderá gerar a segunda via, acompanhar o status da inscrição e baixar o comprovante.</p>
</div>
</div>
</div>
</div>
	
	
		<div class="container">
			<div class="row">
				
				
	<div class="col-md-4">
	<div class="panel panel-success">
  <div class="panel-body text-center">
   Para acessar a intranet <a href="http://intranet.helixcursos.com.br" class="text-info"><strong>clique aqui</strong></a>
  </div>
</div>
</div>
					
	<div class="col-md-4">
	<div class="panel panel-success">
  <div class="panel-body">
    <strong>Usuário</strong>: <?php echo $cpfdoaluno; ?>
  </div>
</div>
</div>
					
	<div class="col-md-4">
	<div class="panel panel-success">
  <div class="panel-body">
    <strong>Senha</strong>: Enviada para <?php echo $emaildoaluno; ?> 
  </div>
</div>
</div>
		
				
				
</div>
</div>
	
	
	<div class="container">
  <div class="row justify-content-md-center">
	  
		<div class="col-md-4">
		<div class="panel panel-success">
		<div class="panel-heading">
		<h3 class="panel-title">Meio de pagamento</h3>
		</div>
		<div class="panel-body">
		Boleto: <span> 	</span> <a href="<?php echo $linkdoboleto ?>" class="text-info" download="PagSeguro" ><strong>Visualizar</strong></a>
		</div>
		</div>
	    </div>
	  
	  
		<div class="col-md-4">
		<div class="panel panel-success">
		<div class="panel-heading">
		<h3 class="panel-title">Status do pagamento</h3>
		</div>
		<div class="panel-body">
		
		<?php echo 
//    $saudacao
            ?>
	
		</div>
		</div>
	    </div>
	  
	  
	  
		<div class="col-md-4">
		<div class="panel panel-success">
		<div class="panel-heading">
		<h3 class="panel-title">Referência da inscrição</h3>
		</div>
		<div class="panel-body">
		<strong><?php echo $ref_id ?></strong>
		
		</div>
		</div>
	    </div>
	  
	  
	  
  </div>

</div>
	
	

<?php

$primeiroNome = explode(" ", $nomedoaluno);

$html .= '<p align="center"><img src="http://pagamento.helixcursos.com.br/logointra.png" width="231" height="121" alt=""/></p>';
$html .= '<strong><center>Olá '.current($primeiroNome). ', obrigado por inscrever-se na Helix Cursos! </center></strong><br><br>';
$html .= 'Após efetivação do pagamento, seu <strong>comprovante de inscrição</strong> poderá ser baixado na área do aluno <br><br>';
$html .= 'Seu usuário é: <strong>' .$cpfdoaluno.'</strong> <br> e sua senha é: <strong>' .$senhadoaluno. '</strong><br>' ;
$html .= 'Para acessar a àrea do aluno: <a href="http://intranet.helixcursos.com.br"> clique aqui </a>' ;
$html .= '<br><br>' ;
$html .= '<strong>Dados da inscrição</strong>:<br><br>' ;
$html .= '<strong>Referência</strong>: '.$ref_id. '<br>' ;
$html .= '<strong>Curso escolhido</strong>: '.$nomedocurso. '<br>' ;
$html .= '<strong>Cidade</strong>: '.$cidadedocurso. '<br>' ;
$html .= '<strong>Forma de pagamento</strong>: 	BOLETO <br>' ;
$html .= '<strong>Data da inscrição: </strong>'.$datainscricao. '<br>' ;

$emailsender = "contato@helixcursos.com.br";
   

                                   
//MANDAR EMAIL 
                                   
if(PHP_OS == "Linux") $quebra_linha = "\n"; //Se for Linux
elseif(PHP_OS == "WINNT") $quebra_linha = "\r\n"; // Se for Windows
else die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");
$nomeremetente     = "Helix Cursos";
$emailremetente    = "contato@helixcursos.com.br";
$emaildestinatario = $emaildoaluno_b . ','.'contato@helixcursos.com';
$assunto           = "Registro de inscrição - Helix Cursos";


$mensagemHTML =$html;


$headers = "MIME-Version: 1.1".$quebra_linha;
$headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;
$headers .= "From: ".$emailsender.$quebra_linha;
$headers .= "Return-Path: " . $emailsender . $quebra_linha;
$headers .= "Reply-To: ".$emailremetente.$quebra_linha;

mail($emaildestinatario, $assunto, $mensagemHTML, $headers, "-r". $emailsender);

	
	?>	
	
	
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
<script>
	var progress = setInterval(function () {
    var $bar = $("#bar");

    if ($bar.width() >= 1000) {
        clearInterval(progress);
    } else {
        $bar.width($bar.width() + 100);
    }
    $bar.text( "");
    if ($bar.width() / 10 == 100){
      $bar.text("Finalizando... ");
    }
}, 800);

$(window).load(function() {
  $("#bar").width(3000);
  $(".loader").fadeOut(2500);
});
	
	
	</script>
	<script type="text/javascript">
function disableF5(e) { if ((e.which || e.keyCode) == 116 || (e.which || e.keyCode) == 82) e.preventDefault(); };

$(document).ready(function(){
     $(document).on("keydown", disableF5);
});
</script>
	
	
	
</body>
</html>