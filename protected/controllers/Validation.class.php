<?php
	Class Validation{
		private $sql_key_words = array(
									"select","delete","update","drop","alter","ALERT","alert",
									"SELECT","DELETE","UPDATE","DROP","<script>","<SCRIPT>"
									);

		public function cleanData($param){
			
			$param = preg_replace("@<script[^>]*>.+</script[^>]*>@i", "", $param);
			$param = preg_replace("@<style[^>]*>.+</style[^>]*>@i", "", $param);
			$param = strip_tags($param);
			$param=html_entity_decode($param);
			$param=str_replace('<SCRIPT>','',$param);
			$param=str_replace('</SCRIPT>','',$param);
			$param=str_replace('<script>','',$param);
			$param=str_replace('</script>','',$param);   
			$param=str_replace('alert','',$param);
			$param=str_replace('select','',$param);
			$param=str_replace('delete','',$param);
			$param=str_replace('update','',$param);
			$param=str_replace('drop','',$param);
			$param=str_replace('alter','',$param);
			$param=str_replace('SELECT','',$param);
			$param=str_replace('DELETE','',$param);
			$param=str_replace('UPDATE','',$param);
			$param=str_replace('DROP','',$param);
			$param=str_replace('ALERT','',$param);
			$param=str_replace('xss','',$param);
			$param=addslashes($param);
		
		return $param;
		}
  
		
		
	public function validateItem($var, $type){
   if(!empty($var) && !empty($type)){
    $filter = false;
    switch($type){
     case 'email':
      $var = substr($var, 0, 254);
      $filter = FILTER_VALIDATE_EMAIL;        
     break;
     case 'int':
      $filter = FILTER_VALIDATE_INT;
     break;
     case 'boolean':
      $filter = FILTER_VALIDATE_BOOLEAN;
     break;
     case 'ip':
      $filter = FILTER_VALIDATE_IP;
     break;
     case 'url':
      $filter = FILTER_VALIDATE_URL;
     break;
    }
    if($type == "alpha"){
     if(preg_match("/^[a-zA-Z'\- ]+$/",$var)){
      return true;
     }else{
      return false;
     } 
    }elseif($type == "password"){
     if (preg_match("/^.*(?=.{8,})(?=.*\d)(?=.*[a-z]).*$/", $var)) {
      return true;
     } else {
      return false;
     }
    }elseif($type == "alphanumeric"){
     if(preg_match("/^[a-zA-Z0-9'.,\- ]+$/",$var)){
      return true;
     }else{
      return false;
     } 
    }elseif($type == "phone"){
     if(preg_match("/(\+254|0)7\d{8}/",$var)){
      return true;
     }else{
      return false;
     } 
    }elseif($type == "day"){
     if(preg_match("/^\d{1,2}[\/\-]\d{1,2}[\/\-]\d{4}$/",$var)){
      return true;
     }else{
      return false;
     }
    }else{
     return ($filter === false) ? false : filter_var($var, $filter) !== false ? true : false; 
    } 
   }else{
    return false;
   }
  }
	 
	 public function extensionName($val){
			$string = substr($val, -4, strpos($val, '.'));
			$string=str_replace('.','',$string);
			return $string;
		}
		
		


	 
		public function checkIfEmail($email){
			return (bool)(preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix",$email));
		}
		
		public function checkIfAlpha($val)
    	{
        	$other_characters = array(".",",",":",";","'");
			$val = str_replace($other_characters,"",$val);
			$raw_name = explode(" ", $val);
			$error_count = 0;
			for($i=0;$i<=count($raw_name) - 1;$i++){
				if(!preg_match("/^([a-zA-Z])+$/i", $raw_name[$i])){
					$error_count += 1;
				}
			}
			if($error_count <= 0){
				return true;
			}else{
				return false;
			}
    	}
		

		public function checkifPassport($val)
		{
		$first=substr($val,0,1);
		$second=substr($val,1,1);
		$third=substr($val,2,1);
		$fouth=substr($val,3,1);
		if($first=="K" && $second=="E")
		{
		$others=substr($val,2,intval(strlen($val)-2));
		}else if($first=="A" || $first=="B" || $first=="D")
		{
		$others=substr($val,1,intval(strlen($val)-1));
		}
		if((($first=="A" || $first=="B" || $first=="D") || ($first=="K" && $second=="E")) && (preg_match("/^([0-9])+$/i", $others) && (strlen($others)==7) || strlen($others)==6))
		{
		return 1;
		}else{
		return 0;
		}
		}
		
		
		public function checkIfAlphaNumberic($val){
			return (bool)preg_match("/^([a-zA-Z0-9])+$/i", $val);
		}
		
	    public function checkAlphanumeric($val)
	    {
	        return (bool)preg_match("/^([a-zA-Z0-9])+$/i", $val);
	    }
		
		public function checkBase64($val){
			return (bool)!preg_match('/[^a-zA-Z0-9\/\+=]/', $val);
		}
		
		public function	checkPhoneNumber($number, $lengths = null)
		{
		  	$phone_number = str_replace("+","",$number);
			if(!empty($phone_number) && preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}[-. ]?[0-9]{4}$/', $phone_number)){
				return true;
			}else{
				return false;
			}
		}
		
		public function checkEmailDomain($email)
		{
		  return (bool)checkdnsrr(preg_replace('/^[^@]++@/', '', $email), 'MX');
		}
	}
	?>