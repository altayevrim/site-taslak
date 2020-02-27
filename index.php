<?php
	require 'vendor/autoload.php';

	$f3 = \Base::instance();
	$f3->config('config/rimtay.ini');
	$f3->route('GET @default: /', function(){
		echo \Template::instance()->render('views/index.html');
	});

	$f3->route('POST @contact: /yollagelsin [ajax]', function($f3){
		$p = $f3->get('POST');
		// file_put_contents(time(),json_encode($p));

		if(count($f3->get('MAIL')) != 8){
			$f3->error(500, 'Mail ayarları düzgün yapılmamış. Bir sorun var.');
		}
		if(empty($p['name']) || empty($p['email']) || empty($p['phone']) || empty($p['message'])){
			$f3->error(400, 'Lütfen tüm formu doldurun.');
		}
		$name = strip_tags($p['name']);
		$email = strip_tags($p['email']);
		$message = strip_tags($p['message']);
		$phone = $p['phone'];
		$phoneClear = str_replace([' ', '(', ')', '+', '.'], NULL, $phone);
		if(ctype_digit($phoneClear) == false){
			$f3->error(400, 'Telefon numaranız geçerli değil.');
		}

		if(strlen($phoneClear) < 9){
			$f3->error(400, 'Telefon numaranız geçerli değil. Lütfen en az 9 hane olarak tuşlayın.');
		}
		
		if(strlen($phoneClear) > 13){
			$f3->error(400, 'Telefon numaranız geçerli değil. Lütfen en fazla 13 hane olarak tuşlayın.');
		}

		if(strlen($message) > 600){
			$f3->error(400, 'Mesajınız alanı maksimum 600 karakter olmalı.');
		}
		
		if(strlen($email) > 50){
			$f3->error(400, 'E-posta alanı maksimum 600 karakter olmalı.');
		}
		
		if(strlen($name) > 50){
			$f3->error(400, 'Ad & Soyad alanı maksimum 600 karakter olmalı.');
		}
		
		if(strlen($phone) > 20){
			$f3->error(400, 'Telefon alanı maksimum 600 karakter olmalı.');
		}

		$audit = new Audit();
		if($audit->email($email,true) == false){
			$f3->error(400, 'E-posta adresiniz hatalı veya geçersiz.');
		}
		$smtp = new SMTP($f3->get('MAIL.host'), $f3->get('MAIL.port'), $f3->get('MAIL.scheme'), $f3->get('MAIL.user'), $f3->get('MAIL.pass'));
		$smtp->set('Errors-to', $f3->get('MAIL.errorsTo'));
		$smtp->set('To', implode(", ",$f3->get('MAIL.to')));
		$smtp->set('Subject', $f3->get('MAIL.subject'));
		$smtp->set('Charset', 'utf-8');
		$smtp->set('Reply-to', '"'.$name.'" <'.$email.'>');
		$smtp->set('From', $f3->get('MAIL.user'));
		$mailBody = 'Ad & Soyad: '.$name. "\n";
		$mailBody .= 'E-Posta: '.$email. "\n";
		$mailBody .= 'Telefon: '.$phone. "\n";
		$mailBody .= 'IP: '. $f3->get('IP'). "\n";
		$mailBody .= 'Mesaj: '.$message. "\n\n\nOtomatik olarak gönderilmiştir.";
		if($smtp->send($mailBody)){
			echo 'OK';
		}else{
			$f3->error(500, 'Mail gönderilirken bir problemle karşılaşıldı. Lütfen daha sonra tekrar deneyin.');
		}
	});

	$f3->run();