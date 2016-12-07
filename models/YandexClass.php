<?
class kassa{
	public $org_mode=1;//1-http,2-email
	public $test_mode=0;//1-тестируем,0-боевой

	public $shopid='112505';
	public $password='vk392kfdRE9v';

	public $scid_demo='531022';
	public $scid_combat='42608';

	//start MAIN
	public function scid(){
		if ($this->test_mode){
			return $this->scid_demo;
		}else{
			return $this->scid_combat;
		}
	}
	//end
	
	public function getFormUrl(){
		if (!$this->org_mode){
			return $this->individualGetFormUrl();
		}else{
			return $this->orgGetFormUrl();
		}
	}
	public function individualGetFormUrl(){
		if ($this->test_mode){
			return 'https://demomoney.yandex.ru/quickpay/confirm.xml';
		}else{
			return 'https://money.yandex.ru/quickpay/confirm.xml';
		}
	}
	public function orgGetFormUrl(){
		if ($this->test_mode){
            return 'https://demomoney.yandex.ru/eshop.xml';
        } else {
            return 'https://money.yandex.ru/eshop.xml';
        }
	}
	
	public function createFormHtml($a){
		if ($this->org_mode){
			$html='<form method="POST" action="'.$this->getFormUrl().'" name="paymentform">';
				//обязательные поля
				$html.='<input type="hidden" name="shopid" value="'.$this->shopid.'">
				<input type="hidden" name="scid" value="'.$this->scid().'">
				<input type="hidden" name="sum" value="'.$a['sum'].'" data-type="number">';
				
				//Идентификатор плательщика в ИС Контрагента. В качестве идентификатора может использоваться номер договора плательщика, логин плательщика и т. п. Возможна повторная оплата по одному и тому же идентификатору плательщика
				$html.='<input type="hidden" name="customerNumber" value="'.$a['customer'].'" >';
				
				//не обязательные поля
				$html.='<input type="hidden" name="orderNumber" value="'.$a['order'].'">';
				//$html.='<input type="hidden" name="paymentType" value="'.$this->pay_method.'" />';
				$html.='<input type="hidden" name="shopSuccessURL" value="'.$a['successurl'].'" >';
				$html.='<input type="hidden" name="shopFailURL" value="'.$a['failurl'].'" >';
				
				//Адрес электронной почты плательщика. Если он передан, то соответствующее поле на странице подтверждения платежа будет предзаполнен
				$html.='<input name="cps_email" value="'.$a['email'].'" type="hidden"/>';
				
				//PC - Оплата из кошелька в Яндекс.Деньгах.
				//AC - Оплата с произвольной банковской карты.
				//MC - Платеж со счета мобильного телефона.
				//GP - Оплата наличными через кассы и терминалы.
				//WM - Оплата из кошелька в системе WebMoney.
				//SB - Оплата через Сбербанк: оплата по SMS или Сбербанк Онлайн.
				//MP - Оплата через мобильный терминал (mPOS).
				//AB - Оплата через Альфа-Клик.
				//МА - Оплата через MasterPass.
				//PB - Оплата через Промсвязьбанк.
				$html.='<input name="paymentType" value="AC" type="hidden"/>';
				
				//собственный
				$html.='<input name="email_main" value="'.$a['email'].'" type="hidden"/>';
				
				//$html.='<button type=submi>Оплатить</button>';
			$html.='</form>';
		}else{
			/*
			$html='<form method="POST" action="'.$this->getFormUrl().'"  id="paymentform" name = "paymentform">
			   <input type="hidden" name="receiver" value="'.$this->account.'">
			   <input type="hidden" name="formcomment" value="Order '.$this->orderId.'">
			   <input type="hidden" name="short-dest" value="Order '.$this->orderId.'">
			   <input type="hidden" name="writable-targets" value="'.$this->writable_targets.'">
			   <input type="hidden" name="comment-needed" value="'.$this->comment_needed.'">
			   <input type="hidden" name="label" value="'.$this->orderId.'">
			   <input type="hidden" name="quickpay-form" value="'.$this->quickpay_form.'">
			   <input type="hidden" name="payment-type" value="'.$this->pay_method.'">
			   <input type="hidden" name="targets" value="Заказ '.$this->orderId.'">
			   <input type="hidden" name="sum" value="'.$this->orderTotal.'" data-type="number" >
			   <input type="hidden" name="comment" value="'.$this->comment.'" >
			   <input type="hidden" name="need-fio" value="'.$this->need_fio.'">
			   <input type="hidden" name="need-email" value="'.$this->need_email.'" >
			   <input type="hidden" name="need-phone" value="'.$this->need_phone.'">
			   <input type="hidden" name="need-address" value="'.$this->need_address.'">
			</form>';
			*/
		}
		return $html;
	}
	
	public function checkSign($callbackParams){
		$string = $callbackParams['action'].';'.$callbackParams['orderSumAmount'].';'.$callbackParams['orderSumCurrencyPaycash'].';'.$callbackParams['orderSumBankPaycash'].';'.$callbackParams['shopId'].';'.$callbackParams['invoiceId'].';'.$callbackParams['customerNumber'].';'.$this->password;
		$md5 = strtoupper(md5($string));
		return ($callbackParams['md5']==$md5);
	}

	//возмо.но пригодится (используется в каких то cms)
	//header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	//header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
	//header("Cache-Control: no-store, no-cache, must-revalidate");
	//header("Cache-Control: post-check=0, pre-check=0", false);
	//header("Pragma: no-cache");

	public function sendAviso($callbackParams, $code){
		header("Content-type: text/xml; charset=utf-8");
		$xml = '<?xml version="1.0" encoding="UTF-8"?>
			<paymentAvisoResponse performedDatetime="'.date("c").'" code="'.$code.'" invoiceId="'.$callbackParams['invoiceId'].'" shopId="'.$this->shopid.'"/>';

		$this->debug($xml,$callbackParams);

		echo $xml;
	}

	public function sendCode($callbackParams, $code){
		header("Content-type: text/xml; charset=utf-8");
		$xml = '<?xml version="1.0" encoding="UTF-8"?>
			<checkOrderResponse performedDatetime="'.date("c").'" code="'.$code.'" invoiceId="'.$callbackParams['invoiceId'].'" shopId="'.$this->shopid.'"/>';

		$this->debug($xml,$callbackParams);

		echo $xml;
	}

	public function checkOrder($callbackParams, $sendCode=FALSE, $aviso=FALSE){ 
		if ($this->checkSign($callbackParams)){
			$code = 0;
		}else{
			$code = 1;
		}
		
		if ($sendCode){
			if ($aviso){
				$this->sendAviso($callbackParams, $code);
			}else{
				$this->sendCode($callbackParams, $code);
			}
			exit;
		}else{
			return $code;
		}
	}

	public function individualCheck($callbackParams){
		$string = $callbackParams['notification_type'].'&'.$callbackParams['operation_id'].'&'.$callbackParams['amount'].'&'.$callbackParams['currency'].'&'.$callbackParams['datetime'].'&'.$callbackParams['sender'].'&'.$callbackParams['codepro'].'&'.$this->password.'&'.$callbackParams['label'];
		$check = (sha1($string) == $callbackParams['sha1_hash']);
		if (!$check){
			header('HTTP/1.0 401 Unauthorized');
			return false;
		}
		return true;
	}

	/*
	public function ProcessResult(){
		$callbackParams = $_POST;
		$order_id = false;
		if ($this->org_mode){
			if ($callbackParams['action'] == 'checkOrder'){//Проверка заказа
				$code = $this->checkOrder($callbackParams);
				$this->sendCode($callbackParams, $code);
				$order_id = (int)$callbackParams["orderNumber"];
			}
			if ($callbackParams['action'] == 'paymentAviso'){//Уведомление о переводе
				$this->checkOrder($callbackParams, TRUE, TRUE);
			}
		}else{
			$check = $this->individualCheck($callbackParams);
			if (!$check){
			}else{
				$order_id = (int)$callbackParams["label"];
			}
		}
		
		return $order_id;
	}
	*/

	//start MAIN
	public function respond(){
		$callbackParams=$_REQUEST;
		
		//$text=print_r($callbackParams,TRUE);
		//mysql_query("INSERT INTO `mod_catalog_payment_debug` (`text`,`datetime`)
		//VALUES ('".Sql($text)."',NOW()) ");
		
		$order_id=FALSE;
		if ($this->org_mode){
			//Проверка заказа (деньги списаны)
			if ($callbackParams['action'] == 'checkOrder'){
				$this->checkOrder($callbackParams, TRUE, FALSE);
			}
			//Уведомление о переводе (деньги списаны и перечислены на наш счет),
			//лучше фиксировать оплату на этом этапе так как на этапе CheckOrder могут деньги вернутся обратно
			if ($callbackParams['action'] == 'paymentAviso'){
				$code=$this->checkOrder($callbackParams);

				if (!$code){//успешно
					if ($this->orderpay($callbackParams)){
						$order_id=$callbackParams["orderNumber"];
					}else{//не успешно
						$code=1;
					}
				}

				$this->sendAviso($callbackParams, $code);
			}
		}else{
			$check = $this->individualCheck($callbackParams);
			if (!$check){
			}else{
				$order_id = (int)$callbackParams["label"];
			}
		}
		return $order_id;
	}

	//MAIN
	public function orderpay($callbackParams){
		global $M,$M_CONF;
		$r=FALSE;
		
		$order_id=$callbackParams["orderNumber"];
		$payment_id=$callbackParams['invoiceId'];
		$payment_type=$callbackParams['paymentType'];

		$query="SELECT * FROM `mod_catalog_zakaz` WHERE `id`='".Sql($order_id)."' LIMIT 1";
		$fet_zakaz=mysql_fetch_object(mysql_query($query));
		if (!empty($fet_zakaz->id)){
			$r=TRUE;
			if (!$fet_zakaz->payment_status){
				$email_zakaz=$fet_zakaz->email;
				if (empty($email_zakaz)){//не указан при оформлении
					$email_zakaz=$callbackParams['email_main'];//указан при оплате
				}
				
				$query="UPDATE `mod_catalog_zakaz` SET 
				`status_pay`='1',
				`datetime_pay`=NOW(),
				`payment_status`='1',
				`payment_datetime`=NOW(),
				`payment_id`='".Sql($payment_id)."',
				`payment_type`='".Sql($payment_type)."'
				WHERE `id`='".Sql($order_id)."'
				LIMIT 1";
				//$this->debug($query,array('xxx2'));
				$f=mysql_query($query);
				if ($f){
					$to1=EMAIL_SADM;
					$to2=$M_CONF['site']['email'];
					$to3=$M_CONF['catalog']['email'];
					if (!empty($to3)){
						$to_email=$to3;
					}else{
						if (!empty($to2)){
							$to_email=$to2;
						}else{
							$to_email=$to1;
						}
					}
					$from_exp=explode(",",$to_email);
					$from_email=$from_exp['0'];

					$orderUrl=URL2.CatalogClass::url(array(
						'order'=>$fet_zakaz->order,
					));

					//$admparthUrl=URL2.'/team/enter.php';
					$admparthUrl=URL2.'/modul/catalog/adm/?task=order';
					
					//нужно т.к. отправляться автоматом из UTF-8
					$name=iconv('utf-8','windows-1251',$fet_zakaz->name);

					$subject="Результат оплаты - ".PHOST2;
					$message="Здравствуйте, ".$name.".<br/><br/><br/>\n";
					$message.="<span style='font-size:18px;font-weight:bold;color:#007503;'><b>СПАСИБО!</b><br/> 
					Вы удачно совершили оплату заказа №".$fet_zakaz->id." в интернет-магазине ".URL2."</span><br/><br/><br/>\n";
					$message.="Персональная ссылка Вашего заказа:<br>\n
					<a href='".$orderUrl."' target='_blank'>".$orderUrl."</a>\n";
					$message.="<br/><br/><br/><br/>";
					if (!empty($fet_zakaz->email)){
						$this->sendmail($from_email,$email_zakaz,$subject,$message);
					}
					
					$subject="Оплачен заказ №".$fet_zakaz->id." - ".PHOST2;
					$message="<h2>В интернет-магазине оплачен заказ №".$fet_zakaz->id."</h2><br/><br/>
					Персональная ссылка заказа:<br>\n
					<a href='".$orderUrl."' target='_blank'>".$orderUrl."</a>
					<br/><br/><br/>
					Административная часть:<br/>
					<a href='".$admparthUrl."' target='_blank'>".$admparthUrl."</a>";
					$this->sendmail($from_email,$from_email,$subject,$message);
					$this->sendmail($from_email,EMAIL_SADM,$subject,$message);
				}else{
					$r=FALSE;
				}
			}
		}
		
		return $r;
	}
	
	public function sendmail($from,$to,$subject,$message){
		//$headers="From: ".$from."\n"; 
		$headers="From: ".PHOST2." <".$from.">\n";
		$headers.="Content-Type:text/html; charset=utf-8"; 

		$result=mail($to,$subject,$message,$headers);
		return $result;
	}
	
	public function debug($txt,$arr){
		$text=$txt."\n\n".print_r($arr,TRUE);
		mysql_query("INSERT INTO `mod_catalog_payment_debug` (`text`,`datetime`)
		VALUES ('".Sql($text)."',NOW())");
	}
	//end
}
?>