<?php class gen_reviews extends Controller { private $ssb_data;private $gen_helper;private $ssb_helper;private $transliteration;private $seo_data=array();private $imgArr=array();private $def_data=array( 'entity_cat' => '','entity_name'=> '','CPBI' => 'all','id_entity' => '','testgenerator'=> false,'pack' => 0 );function __construct(){ global $registry;parent::__construct($registry);require_once DIR_CONFIG.'ssb_library/admin/generators/ssb_review.php';$this->ssb_review=ssb_review::getInstance();require_once DIR_CONFIG.'ssb_library/ssb_helper.php';$this->ssb_helper=ssb_helper::getInstance();require_once DIR_CONFIG.'ssb_library/ssb_data.php';$this->ssb_data=ssb_data::getInstance();require_once DIR_CONFIG.'ssb_library/admin/generators/gen_helper.php';$this->gen_helper=gen_helper::getInstance();} static private $Instance =NULL;static public function getInstance() { if(self::$Instance==NULL){ $class=__CLASS__;self::$Instance=new $class;} return self::$Instance;} public function generate($data){ $time_start=microtime(true);$this->def_data=array_merge($this->def_data,$data);extract($this->def_data);$res_count=0;$res_seo_data=array();$this->doGenerate($entity_cat,$entity_name,$id_entity,$testgenerator,$pack);$res_count=$this->g_count;$res_seo_data=$this->seo_data;$time_end=microtime(true);$time=$time_end-$time_start;return array('time'=> $time,'count'=> $res_count,'seo_data'=> $res_seo_data);} public function doGenerate($entity_cat,$CPBI,$id_entity='',$testgenerator,$pack){ $this->setVars_Common($entity_cat,$CPBI,$testgenerator,$pack);if($id_entity){ $CPBI_item=$this->ssb_data->getCPBI_item('product',$id_entity);$productData =$CPBI_item['data'][$id_entity];$this->genProcess_review($productData,$id_entity);if($this->status)$this->g_count++;}else{ $data_product=$this->ssb_data->getCPBI('product','reviews',$this->pack);$productsData =$data_product['data'];$pi_float =round($this->getPassIteration (count($productsData)),2);$pi_cell =floor($pi_float);$pi_fractional=$pi_float-$pi_cell;$i=0;foreach($productsData as $p_id=> $productData){ if($pi_cell !=0 AND $pi_cell==$i){ $pi_fractional+=$pi_float-$pi_cell;$i=0;continue;}elseif($pi_fractional >=1){ $pi_fractional=$pi_fractional-floor($pi_fractional);$pi_fractional+=$pi_float-$pi_cell;continue;} $this->genProcess_review($productData,$p_id);if($this->testgenerator){ if($this->g_count>20)break;} $pi_fractional+=$pi_float-$pi_cell;$i++;} if($this->testgenerator){ $this->endSeoData('product');} } } private function getPassIteration ($totalItem){ $per_prod=$this->setting['per_prod'];$divader=$totalItem-($totalItem*($per_prod/100));$divader=$divader ? $divader:1;$result=$totalItem / $divader;return $result;} private function setVars_Common($entity_cat,$CPBI,$testgenerator,$pack=0){ $setting =$this->ssb_data->getSetting();$this->setting =$setting['entity']['reviews']['product']['setting'];$this->seo_data =array();$this->g_count =0;$this->status =false;$this->pack =$pack;$this->entity_cat =$entity_cat;$this->CPBI =$CPBI;$this->testgenerator=$testgenerator;$this->defLanguage =$this->ssb_helper->getDefaultLanguage();$this->specialPatterns=$this->ssb_data->getPatterns('special');} private function genProcess_review($productData,$p_id){ $randomData=array( 'min' => $this->setting['rev_min'],'max' => $this->setting['rev_max'],'l_code_text'=> $this->setting['l_code_for_text'],'l_code_name'=> $this->setting['l_code_for_name'],);$templates=$this->ssb_review->getRandomNameText($randomData);$i=0;foreach($templates['text'] as $template){ $this->status=false;$productData_=isset($productData[$template['l_code']]) ? $productData[$template['l_code']]:$productData[$this->defLanguage];$templ_objs=$this->gen_helper->parseTemplate('tag','product',$template['text']);$text=$this->gen_helper->getSeoString( $templ_objs,$template['text'],$this->specialPatterns,$productData_,'product',$this->defLanguage,'tag');$name =$templates['name'][$i]['text'];$rating =rand($this->setting['rat_min'],$this->setting['rat_max']);$interval=rand(0,$this->setting['interval']);if(!$this->testgenerator){ $this->saveProcess($p_id,$name,$text,$rating,$interval);$this->g_count++;} if($this->testgenerator){ $rating_url=HTTP_CATALOG."catalog/view/theme/default/image/stars-".$rating.".png";$rating_img='<img src="' . $rating_url . '">';$html='<div class="review-list"><div class="author"><b>'.$name.'</b>  on  '.date("d M Y",time()-86400*$interval).'</div><div class="rating">'.$rating_img.'</div><div class="text">'.$text.'</div></div>';$meta_alias=$this->ssb_data->getMatadata('CPBI',array('val'=>'alias'));$name_=$meta_alias['product']['name'];$this->fillSeoData($productData_[$name_],$html);$this->g_count++;} $i++;} return;} private function saveProcess($p_id,$name,$text,$rating,$interval){ $this->status=true;$sql="INSERT INTO ".DB_PREFIX."review SET author = '" . $this->db->escape($name) . "', customer_id = '0', product_id = '" . (int)$p_id . "', text = '" . $this->db->escape($text) . "', rating = '" . (int)$rating . "', date_added = NOW()-INTERVAL ".$interval." DAY, status = 1, auto_gen = 1;";$this->db->query($sql);} private function fillSeoData($name,$html){ $this->seo_data[]="<tr>".$this->gen_helper->addTD($name).$this->gen_helper->addTD($html)."</tr>";} private function endSeoData($CPBI){ $language_text=$this->language->load('module/superseobox');$header='      <tr>       <th>'.$language_text['text_entity_name_'.$CPBI].' name</th>       <th>Reviews</th>      </tr>      ';array_unshift($this->seo_data,$header);$this->seo_data[]='<tr><th colspan="3">...etc.</th></tr>';$this->seo_data[]='<tr><style>#modal-testGenerate .modal-header .nav-pills{display:none;}</style></tr>';} } ?>
