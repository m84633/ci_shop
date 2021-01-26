<?php
	class Ecpay {
		public function load(){
			require_once APPPATH.'third_party/AioSDK/sdk/ECPay.Payment.Integration.php';
			$obj = new ECPay_AllInOne();
			return $obj;
		}
	}