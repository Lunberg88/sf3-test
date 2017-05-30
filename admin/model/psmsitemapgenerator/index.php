<?php class Modelpsmsitemapgeneratorindex extends Model { private $dataManager;private $psm_helper;private $total=0;private $gen_pack_number=0;private $dir_module='psm_library/gen_sitemap/';function __construct(){ global $registry;parent::__construct($registry);require_once DIR_CONFIG.$this->dir_module.'data_manager.php';$this->dataManager=dataManager::getInstance();require_once DIR_CONFIG.$this->dir_module.'psm_helper.php';$this->psm_helper=psm_helper::getInstance();} public function getCPBI_item($CPBI,$id_item){ $data_CPBI_item=$this->{'get_'.$CPBI}('',$id_item);return $data_CPBI_item;} public function getCPBI($CPBI,$categoryEntity='',$gen_pack_number=0){ $data_CPBI=array();$time_start=microtime(true);$this->gen_pack_number=$gen_pack_number;if($CPBI=='all'){ $entities=$this->dataManager->getSetting('entity');$CPBIs=array_keys($entities['sitemap']);$total=0;foreach($CPBIs as $CPBI_){ $data=$this->getCPBI($CPBI_,$categoryEntity,$gen_pack_number);$total+=$data['total'];$data_CPBI['data'][$CPBI_]=$data['data'];} $data_CPBI['total']=$total;$data_CPBI['name']='all';}else{ $gen_pack=$this->dataManager->getGenPack($gen_pack_number,$CPBI,$categoryEntity);if($CPBI=='related_prod' OR $CPBI=='images' OR $categoryEntity=='images' OR $categoryEntity=='reviews'){ $CPBI='product';} $data_CPBI=$this->{'get_'.$CPBI}($gen_pack);} return $data_CPBI;} private function get_product($gen_limit='',$item_id=''){ $languages=$this->psm_helper->getLanguages();$this->total=0;$respond=array();foreach ($languages as $l_code=> $l_data){ $respond_lang=$this->get_product_lang($l_data,$gen_limit,$item_id);$respond =array_replace_recursive ($respond,$respond_lang);} return array('data'=> $respond,'total'=> $this->total,'name'=> 'product');} private function get_product_lang($l_data,$gen_limit,$item_id){ $l_code=$l_data['code'];$l_id =$l_data['language_id'];if(isset($this->request->post['store_id'])){ $store_condition=" AND ps.store_id = ".(int)$this->request->post['store_id']."";}else{ $store_condition=" AND ps.store_id = 0";} $sql="SELECT p.product_id, p.sitemap_file, pd.name FROM ".DB_PREFIX."product_description pd    INNER JOIN ".DB_PREFIX."product p on pd.product_id = p.product_id     INNER JOIN ".DB_PREFIX."product_to_store ps on ps.product_id = p.product_id    WHERE p.status = 1 AND pd.language_id = ".$l_id.$store_condition;if($item_id !==''){ $sql.=" AND p.product_id =".$item_id.";";}else{ $sql.=" LIMIT ".(int)$gen_limit['start'].",".(int)$gen_limit['limit'].";";} $query=$this->db->query($sql);$products=array();foreach($query->rows as $product){ if(!isset($products [$product['product_id']][$l_code])){ $products [$product['product_id']][$l_code]=array( 'pn' => $product['name'],'seo_field' => array( 'name' => $product['name'],'sitemap_file'=> $product['sitemap_file'] ) );$this->total++;} } return $products;} private function get_category($gen_limit='',$item_id=''){ $languages=$this->psm_helper->getLanguages();$this->total=0;$respond=array();$this->totalProdFromCategory=array();foreach ($languages as $l_code=> $l_data){ $respond_lang=$this->get_category_lang($l_data,$gen_limit,$item_id);$respond =array_replace_recursive ($respond,$respond_lang);} return array('data'=> $respond,'total'=> $this->total,'name'=> 'category');} private function get_category_lang($l_data,$gen_limit,$item_id){ $l_code=$l_data['code'];$l_id =$l_data['language_id'];if(isset($this->request->post['store_id'])){ $store_condition=" AND cs.store_id = ".(int)$this->request->post['store_id']."";}else{ $store_condition=" AND cs.store_id = 0";} $sql="SELECT c.sitemap_file, cd.category_id, cd.name FROM ".DB_PREFIX."category c     LEFT JOIN ".DB_PREFIX."category_description cd on c.category_id = cd.category_id     INNER JOIN ".DB_PREFIX."category_to_store cs on cs.category_id = c.category_id    WHERE c.status = 1 AND cd.language_id = ".$l_id.$store_condition;if($item_id !==''){ $sql.=" AND c.category_id =".$item_id.";";}else{ $sql.=" LIMIT ".(int)$gen_limit['start'].",".(int)$gen_limit['limit'].";";} $query=$this->db->query($sql);$categories=array();foreach($query->rows as $category){ if(!isset($categories[$category['category_id']][$l_code])){ $categories [$category['category_id']][$l_code]=array( 'cn' => $category['name'],'seo_field' => array( 'name' => $category['name'],'sitemap_file'=> $category['sitemap_file'] ) );$this->total++;} } return $categories;} private function get_brand($gen_limit='',$item_id=''){ $this->total=0;$respond=$this->get_brand_lang($gen_limit,$item_id);return array('data'=> $respond,'total'=> $this->total,'name'=> 'brand');} private function get_brand_lang($gen_limit,$item_id){ $l_code=$this->psm_helper->getDefaultLanguage();$l_id =$this->psm_helper->getLang_Code_Id($l_code);if(isset($this->request->post['store_id'])){ $store_condition=" AND ms.store_id = ".(int)$this->request->post['store_id']."";}else{ $store_condition=" AND ms.store_id = 0";} $sql="SELECT m.sitemap_file, m.manufacturer_id, m.name FROM ".DB_PREFIX."manufacturer m     INNER JOIN ".DB_PREFIX."manufacturer_to_store ms on ms.manufacturer_id = m.manufacturer_id WHERE 1=1" .$store_condition;if($item_id !==''){ $sql.=" AND m.manufacturer_id =".$item_id.";";}else{ $sql.=" LIMIT ".(int)$gen_limit['start'].",".(int)$gen_limit['limit'].";";} $query=$this->db->query($sql);$brands=array();$totalProd=array();foreach($query->rows as $brand){ if(!isset($brands[$brand['manufacturer_id']][$l_code])){ $brands[$brand['manufacturer_id']][$l_code]=array( 'bn' => $brand['name'],'seo_field' => array( 'name' => $brand['name'],'sitemap_file'=> $brand['sitemap_file'] ) );$this->total++;} } return $brands;} private function get_info($gen_limit='',$item_id=''){ $languages=$this->psm_helper->getLanguages();$this->total=0;$respond=array();foreach ($languages as $l_code=> $l_data){ $respond_lang=$this->get_info_lang($l_data,$gen_limit,$item_id);$respond =array_replace_recursive ($respond,$respond_lang);} return array('data'=> $respond,'total'=> $this->total,'name'=>'information');} private function get_info_lang($l_data,$gen_limit,$item_id){ $l_code=$l_data['code'];$l_id =$l_data['language_id'];if(isset($this->request->post['store_id'])){ $store_condition=" AND its.store_id = ".(int)$this->request->post['store_id']."";}else{ $store_condition=" AND its.store_id = 0";} $sql="SELECT id.sitemap_file, id.information_id, id.title as name FROM ".DB_PREFIX."information_description id INNER JOIN ".DB_PREFIX."information_to_store its on its.information_id = id.information_id WHERE id.language_id = ".$l_id.$store_condition;if($item_id !==''){ $sql.=" AND id.information_id =".$item_id.";";}else{ $sql.=" LIMIT ".(int)$gen_limit['start'].",".(int)$gen_limit['limit'].";";} $query=$this->db->query($sql);$infos=array();foreach($query->rows as $info){ if(!isset($infos[$info['information_id']][$l_code])){ $infos[$info['information_id']][$l_code]=array( 'in' => $info['name'],'seo_field' => array( 'name' => $info['name'],'sitemap_file'=> $info['sitemap_file'] ) );$this->total++;} } return $infos;} private function get_standard($gen_limit='',$item_id=''){ return array('data'=> array(),'total'=> 42,'name'=> 'STAN_urls');} public function delCPBI_Cache($CPBI='all'){ if ($CPBI !='all'){ $this->cache->delete('ssb.CPBI.'.$CPBI);}else{ $CPBIs=$this->dataManager->getMatadata('CPBI',array('keys'=>true));foreach($CPBIs as $val){ $this->cache->delete('ssb.CPBI.'.$val);} } } private function getSentences($text,$count) { $text=strip_tags(html_entity_decode($text));$pos=0;$found=false;for ($x=0;$x<=$count;$x++) { $pos=strpos($text,'.',0);if($pos !==false){ $found=true;} } if($found){ if($pos===false) { return $text;}else{ return substr($text,0,$pos+1);} } } } if (!function_exists('array_replace_recursive')) { function array_replace_recursive($array,$array1) { $args=func_get_args();$array=$args[0];if (!is_array($array)) { return $array;} for ($i=1;$i < count($args);$i++) { if (is_array($args[$i])) { $array=recurse($array,$args[$i]);} } return $array;} function recurse($array,$array1) { foreach ($array1 as $key=> $value) { if (!isset($array[$key]) || (isset($array[$key]) && !is_array($array[$key]))) { $array[$key]=array();} if (is_array($value)) { $value=recurse($array[$key],$value);} $array[$key]=$value;} return $array;} } ?>
