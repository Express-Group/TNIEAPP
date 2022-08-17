<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
require_once('amp-library/vendor/autoload.php');
use Lullabot\AMP\AMP;
use Lullabot\AMP\Validate\Scope;
class Amp_library{
	
	public $amp;
	public function __construct(){
		$CI = &get_instance();
		$this->amp = new AMP();
	}
	
	public function loadcontent($content){
		return $this->amp->loadHtml($content);
	}
	
	public function ampHTML(){
		return $this->amp->convertToAmpHtml();
	}
}
?> 