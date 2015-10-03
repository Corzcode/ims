<?php
class Template
{
	protected $var = array();
	/**
	 * 
	 * @return self
	 */
	public static function getInstance () {
		static $obj = null;
		return isset($obj) ? $obj : ($obj = new Template());
	}
	public function __construct () {}
	public function assign ($key, $value) {
		$this->var[$key] = $value;
	}
	public function display ($tpl) {
		extract($this->var, EXTR_OVERWRITE);
		include TPL_PATH . '/' . $tpl;
	}
}