<?php

class language {
		
	public static $langs   = array(
		'pl' => 'Polish',
		'en' => 'English',
	);
   
	function __construct() {
		$this->Default   = DEFAULT_LANG;
		$this->User      = DEFAULT_LANG;
		
		$this->GetLangFromBrowser();
	}
		
	static function getAllowedLangs($OnlyKey = true) {
		return $OnlyKey ? array_keys(self::$langs) : self::$langs;      
	}
   
   
    public function setUser($LANG) {
		if(!empty($LANG) && in_array($LANG, self::getAllowedLangs())) {
			$this->User = $LANG;     
		}
	}
		
	public function includeLang($File) {
		global $LNG;
		if($this->Default != $this->User) {
			require(ROOT_PATH . "language/".$this->User."/".$File.'.php');
		} else {
			require(ROOT_PATH . 'language/en/'.$File.'.php');
		}
	}
		
	private function GetLangFromBrowser() {
        if(isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], self::getAllowedLangs())) {
			$this->setUser($_COOKIE['lang']);
		}
	}
		
	public function SetLang($LANG) {
		if(!empty($LANG) && in_array($LANG, self::getAllowedLangs())) {
			setcookie("lang", $LANG , 2147483647);
		}
	}

}

?>