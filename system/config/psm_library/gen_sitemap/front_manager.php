<?php class frontManager extends Controller { private $setting_name ='paladinSiteMapGenerator';private $dir_module ='psm_library/gen_sitemap/';function __construct(){ global $registry;parent::__construct($registry);} static private $Instance =NULL;static public function getInstance() { if(self::$Instance==NULL){ $class=__CLASS__;self::$Instance=new $class;} return self::$Instance;} public function isPaladin(){ $this->load->model('setting/setting');$setting=$this->model_setting_setting->getSetting('superseobox');if($setting){ return true;}else{ return false;} } public function getSetting($param=false){ $this->load->model('setting/setting');$setting=$this->model_setting_setting->getSetting($this->setting_name);if(!$setting){return false;} $respond;if($param){ $respond=$setting[$param];}else{ $respond=$setting;} return $respond;} } ?>
