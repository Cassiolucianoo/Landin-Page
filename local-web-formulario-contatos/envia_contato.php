<?php

session_start();

if(isset($_GET['converted'])){

}

//validação da google

if (isset($_POST['g-recaptcha-response'])) {
	$captcha_data = $_POST['g-recaptcha-response'];
}
// Se nenhum valor foi recebido, o usuario não realizou o captcha
if (!$captcha_data) {
	print "<script>alert('Por favor, confirme o captcha.');</script>";
	print "<script>history.back(-1)</script> ";
	exit;
}

 //recaptcha   da google aqui no lugar /** --------------------  */
$resposta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=/** --------------------  */&response=".$captcha_data."&remoteip=".$_SERVER['REMOTE_ADDR']);

                                                                                  
//error_reporting(0);
if (isset($_POST['button'])){

	                if($resposta.success){

		$mensagemConcatenada = "";

		/*** INICIO - DADOS A SEREM ALTERADOS DE ACORDO COM SUAS CONFIGURAÇÃOES DE E-MAIL ***/
		$enviaFormularioParaNome = 'nome aqui.... | nome.......';

		//$envia Formulari o ParaEmail = '';
		$enviaFormularioParaEmail = 'SEU@DOMINIO.COM.BR';



		$caixaPostalServidorNome = 'Nome  | Nome  ';
		$caixaPostalServidorEmail = 'SEU_SEGUNDO@DOMINIO.COM.BR';
		$caixaPostalServidorSenha = 'SENHA_AQUI';
		/*** FIM - DADOS A SEREM ALTERADOS DE ACORDO COM SUAS CONFIGURA��ES DE E-MAIL ***/


		/* abaixo as veriaveis principais, que devem conter em seu formulario*/
		$assunto = utf8_decode("Mensagem Recebida do Site [.........................]");


		//ANEXO
		$arquivo = isset($_FILES["arquivo"]) ? $_FILES["arquivo"] : FALSE;
		if(file_exists($arquivo["tmp_name"]) and !empty($arquivo)){
			echo $arquivo;
		}

		foreach (array_keys($_POST) as $input_name) {
			if (strpos($input_name, '_') > -1) {
				$mensagemConcatenada .= "<b>" . substr($input_name, strpos($input_name, '_') + 1, strlen($input_name) - 1) . ":</b> " . $_POST[$input_name] . "<br>";
			}

		}
		//ANEXO LOGO AQUI PRA FICAR NO CORPO DO E-MAIL 
		$mensagemConcatenada .= "<br><br><img src='https://SEUDOMINIO/logo-email.jpg' />";



		/*********************************** A PARTIR ALTERAR APENAS O HOST PARA O SEU DOMINIO ************************************/

		//require_once('PHPMailer-master/PHPMailerAutoload.php');
		require_once('PHPMailer/class.phpmailer.php');
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth  = true;
		//$mail->SMTPSecure = "ssl";
		$mail->Charset   = 'utf8_decode()';
		$mail->Host  = 'mail.gnosepro.com.br';  //AQUI ALTERA PARA O SEU DOMINIO
		$mail->Port  = '587';
		$mail->Username  = $caixaPostalServidorEmail;
		$mail->Password  = $caixaPostalServidorSenha;
		$mail->From  = $caixaPostalServidorEmail;
		$mail->FromName  = $caixaPostalServidorNome;
		$mail->IsHTML(true);
		$mail->Subject  = utf8_decode($assunto);

		
		$mail->Body  = utf8_decode($mensagemConcatenada);
		$mail->AddAddress($enviaFormularioParaEmail, $enviaFormularioParaNome);
		//$mail->AddCC($enviaFormularioParaEmailcopia,$enviaFormularioParaNomecopia);
		// Copia
		$mail->AddBCC($enviaFormularioParaEmailcopia, $enviaFormularioParaNomecopia); // COpia Oculta

		if(!$mail->Send()){
			print "<script>alert('Ocorreu um erro.');</script>";
		}
		else{

			?>

<!DOCTYPE html>
<html lang="en">

<head>

    <title>Obrigado! Sua mensagem foi enviada!</title>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  
</head>

<body>

    <header >

    </header>

    <section
        style="background: url('assets/img/intro-carousel/...............jpg'); background-size: cover; background-position: center; height: 100vh; display: flex; align-items: center; justify-content: center">
        <h1 style="font-family: 'Lato-Bold', sans-serif; color: white; text-transform: uppercase; text-align: center;">
            <span style="background: #41BF18; padding: 10px 20px; border-radius: 10px;">Obrigado!</span> <br><span
                style="text-transform: none; background: none; display: block; margin-top: 30px; font-size: 30px">Sua
                mensagem foi enviada e em breve entraremos em contato!</span></br></h1>
    </section>


    <!-- FOOTER -->
    <footer id="footer">

    </footer>
    <!-- #footer -->

</html>


<?php
		}
	}
}
else{
	echo "<script>alert('Recaptcha invalido.');</script>";
}
?>