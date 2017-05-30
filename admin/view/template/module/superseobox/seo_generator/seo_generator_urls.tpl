<div class="label label-warning control-group" style="float: right; margin-bottom: -35px; background-color: #EFEFEF;border: 2px solid #fff;" data-toggle="tooltip" data-original-title="<p style='text-align:left;'>1. If this function is On - will be used standard Opencart controller for management seo urls: catalog/controller/common/seo_url.php</br>2. If this function is Off - will be used special controller from Paladin: system/config/ssb_library/catalog/controller/common/ssb_seo_url.php</br>Preferable will be activate this function (ON) - this will be garantee, that all your additional modules, which have the own route type (blogs, article and news modules) will be have seo urls.</p>" data-placement="bottom">	<label class="control-label" style="display: inline-block;"><i class="icon-info-sign"></i> Using the own Opencart seo-url controller &nbsp;</label>	<div class="controls" style="display: inline-block;">		<input type="hidden" name="data[entity][urls][CPBI_urls][controller]" value="">		<input data-action="save" data-scope=".closest('.controls').find('input')" type="checkbox" value="true" <?php if($data['entity']['urls']['CPBI_urls']['controller']) echo 'checked="checked"'; ?> name="data[entity][urls][CPBI_urls][controller]" class="on_off noAlert">	</div></div><!-- header start -->		<?php		$entity_category_name = 'urls';		include 'template/header.tpl';	?><!-- header end -->	<!-- CPBI_urls START--><?php 	$key = 'CPBI_urls';	$val = $data['entity']['urls']['CPBI_urls']; ?>	<tr>	<td class="TDKT-td">		<fieldset class="main_settings">			<div class="control-group" style="float: right;">				<div class="controls btn-group" style="margin-left:0px;">					<a data-action="prepareGenerate" data-entity="urls-<?php echo  $key;?>" data-scope=".closest('tbody').find('input')" class="btn btn-success ajax_action" type="button"><?php echo $text_common_generate . ' ' . ${'text_category_name_'.$entity_category_name} . ' ' . $text_common_for_all_pages; ?>!</a>					<a data-action="prepareClearGenerate" data-data="emty" data-entity="urls-<?php echo  $key;?>" class="btn btn-danger ajax_action" type="button"><?php echo  $text_common_clear_all;?></a>				</div>			</div>			<div class="control-group" style=" margin-bottom: 2px;clear: both;">				<label style="width: 330px!important;" class="control-label" for="">					<?php echo  $text_common_in_national_language;?>				</label>				<div class="controls">					<?php $national_lang = isset($data['entity']['urls'][$key]['national_lang'])? $data['entity']['urls'][$key]['national_lang']:false; ?>									<input type="hidden" name="data[entity][urls][<?php echo  $key;?>][national_lang]" value="">					<input data-action="save" data-scope=".closest('.controls').find('input')" type="checkbox" value="true" <?php if($national_lang) echo 'checked="checked"'; ?> name="data[entity][urls][<?php echo  $key;?>][national_lang]" class="on_off noAlert">				</div>			</div>							<div class="control-group">				<label style="width: 330px!important;" class="control-label" for="">					<?php echo  $text_common_url_extention;?>				</label>				<div class="controls">					<input style="width: 101px;" type="text" name="data[entity][urls][<?php echo  $key;?>][ext]" class="span1 url_ext" value="<?php echo $val['ext']; ?>">				</div>			</div>		</fieldset>	</td>	<td class="info_text">		<dl>			<dt>			<?php echo  $text_common_in_national_language;?>:</dt>			<dd class="info-area">				<?php echo  $text_common_in_national_language_info;?></br>			</dd>		</dl>	</td></tr><tr>	<td class="TDKT-td">	<?php 		$possible_pattern = array(			'product' 	=> array('pn', 'pm', 'pu','cn', 'bn', 'ps', 'sn'),			'category' 	=> array('cn', 'cp', 'tp', 'sn'),			'brand'		=> array('bn', 'tp', 'sn'),			'info'		=> array('in', 'sn')		);			foreach ($val['data'] as $entity_name => $entity_val) { ?><!-- ********** -->	<fieldset>	<div class="control-group one_control_group" style=" margin-bottom: 33px;">		<div class="pattern_line_label_hide">			<button type="button" class="close close-popup">x</button>			<H4><?php echo  $text_common_click_for_insert;?></H4>			<div class="btn-group pattern_line_label">				<?php foreach ($possible_pattern[$entity_name] as $parameter) {				/* set additional value before insert START*/				$addValDefault = '';				if(isset($patterns_setting[$parameter]['additional'])){					$additional_default = isset($patterns_setting[$parameter]['additional'][$key]) ? $patterns_setting[$parameter]['additional'][$key] : $patterns_setting[$parameter]['additional']['default'];										$add_metaData = isset($patterns_setting[$parameter]['add_metaData'][$key]) ? $patterns_setting[$parameter]['add_metaData'][$key] : $patterns_setting[$parameter]['add_metaData']['default'];										$addValDefault = str_replace('"','\'',json_encode(array('name' => $add_metaData, 'value' => $additional_default)));				}				/* set additional value before insert END*/								$settingInfo_status = false;				if(isset($patterns[$parameter]['settingInfo'])){					$settingInfo_text = isset($patterns[$parameter]['settingInfo'][$key]) ? $patterns[$parameter]['settingInfo'][$key] : $patterns[$parameter]['settingInfo']['all'];					if($settingInfo_text != ''){						$settingInfo_status = true;					}				}				?>					<a data-paramName="<?php echo $patterns[$parameter]['name']; ?>" data-addValPattern="<?php if($settingInfo_status){echo $settingInfo_text;} ?>" data-addValue ="<?php echo $addValDefault; ?>" data-toggle="tooltip" title="<?php echo $patterns[$parameter]['name']; if($settingInfo_status) { ?> </br>Possible additional setting: <?php echo $settingInfo_text;} ?>" class="seo_button_pattern btn btn-small"> !<?php echo $parameter; ?> </a>			<?php } ?>			</div>		</div>			<!--<?php if(count($languages)){ ?>		<a class="btn">Copy template for all languages</a>		<?php } ?>!-->		<div class="tabbable"> 			<ul class="nav nav-tabs">				<?php $i_seo_url_lang_nav1 = 1; foreach ($languages as $l_code => $language){ if(!$language['status'])continue; ?>					<li <?php if($i_seo_url_lang_nav1 ==1) echo  "class=\"active\"";?>>						<?php if(isset($entity_val['pattern'])) { ?>							<a href="#TDKT_<?php echo $entity_category_name.'-'.$key.'-'.$entity_name;?>_<?php echo $l_code;?>" data-toggle="tab">								<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />							</a>						<?php } ?>					</li>				<?php $i_seo_url_lang_nav1++; } ?>			</ul>					<div class="tab-content one_entity" style="overflow: hidden;">			<?php 				$i_seo_url_lang_nav2 = 1; 				foreach ($languages as $l_code => $language){ 				if(!$language['status'])continue; 			?>				<div class="tab-pane <?php if($i_seo_url_lang_nav2 ==1) echo  "active";?>" id="TDKT_<?php echo $entity_category_name.'-'.$key.'-'.$entity_name;?>_<?php echo $l_code;?>">					<!-- edit area -->					<div class="controls">						<div style="" class="input-prepend input-append">							<span class="add-on item_name"> <?php echo ${'text_entity_name_'.$entity_name} ?></span>							<span class="add-on status <?php if($entity_val['status'] ==1){echo "status-on";}else{echo "status-off";}?>" data-toggle="tooltip" title="<?php if($entity_val['status'] ==1){echo $text_status_on;}else{echo $text_status_off;}?>" data-placement="bottom"></span>														<!-- set data for categories templates -->							<?php if($entity_name == 'product'){ ?>								<?php 								$additional_data = 'additionData[function]=setCategoryTemplateData&additionData[data][0]='. $entity_category_name .'&additionData[data][1]='. $entity_name;								$categor_templ_url = $oc_data->url->link('module/superseobox/ajax', 'token=' . $oc_data->session->data['token'] . '&metaData[action]=getModal&data[m_name]=seo_generator/modal/category_template&'.$additional_data, 'SSL');								?>								<a data-jsbeforeaction="$('body,html').stop(true,true).animate({'scrollTop':0},'slow');" href="<?php echo $categor_templ_url; ?>" class="btn" type="button" data-toggle="modal"><span style="margin-top: 4px;" class="icon-filter"></span></a>							<?php } ?>							<!-- set data for categories templates -->														<input data-toggle="popover" data-placement="top" data-content="<p>/<p><p>/<p>" data-original-title="Parameters for template" type="text" name="data[entity][<?php echo $entity_category_name; ?>][<?php echo  $key;?>][data][<?php echo  $entity_name;?>][data][<?php echo $l_code; ?>]" class="seo_input_pattern <?php if($entity_name == 'product') echo "shortstyle"; ?>" value="<?php echo $entity_val['data'][$l_code]; ?>">														<div class="btn-group">								<a data-action="prepareGenerate" data-entity="<?php echo $entity_category_name; ?>-<?php echo  $key;?>-<?php echo  $entity_name;?>" data-scope=".closest('.one_entity').find('input').add('.main_settings input.url_ext')" class="btn btn-success ajax_action" type="button"><?php echo $text_common_generate; ?>!</a>								<a class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>								<ul class="dropdown-menu">									<li>										<?php 										$additional_data = 'additionData[function]=setReplacingData&additionData[data][0]='. $entity_category_name .'&additionData[data][1]='. $key .'&additionData[data][2]='. $entity_name;										$exclusion_url = $oc_data->url->link('module/superseobox/ajax', 'token=' . $oc_data->session->data['token'] . '&metaData[action]=getModal&data[m_name]=seo_generator/modal/replacing_url&'.$additional_data, 'SSL');										?>										<a data-jsbeforeaction="$('body,html').stop(true,true).animate({'scrollTop':0},'slow');" href="<?php echo $exclusion_url; ?>" class="btn-nonstyle" data-toggle="modal"><?php echo $text_common_replacing; ?></a>									</li>									<li class="divider"></li>									<li>										<a data-action="prepareClearGenerate" data-data="emty" data-entity="<?php echo $entity_category_name; ?>-<?php echo  $key;?>-<?php echo  $entity_name;?>" class="bg_red btn-nonstyle ajax_action" type="button"><?php echo $text_common_clear; ?></a>									</li>								</ul>							</div>						</div>					</div>					<!-- edit area -->				</div>			<?php $i_seo_url_lang_nav2++; } ?>			</div>		</div>	</div></fieldset><!-- ********** -->		<?php } ?>	</td>	<td class="info_text">		<dl>			<dt>			<?php echo $text_common_urls_info; ?>:			</dt>			<dd class="info-area">				<?php echo ${'text_entity_gener_desc_'.$key}; ?> <p class="colorFC580B">(<?php echo $text_common_click_caret; ?>)</p> 			</dd>		</dl>	</td></tr><!-- CPBI_urls END-->		<!-- STAN_urls START-->	<?php 	$key = 'STAN_urls';	$val = $data['entity']['urls']['STAN_urls']; ?><tr>	<td style="padding-top: 30px;">		<fieldset>		<div class="control-group TDKT-td" id="TDKT_urls-STAN_urls">			<div class="controls" style="margin-left: 160px;">				<div class="input-prepend input-append">					<span style="text-align:left; width: 157px;" class="add-on"><?php echo ${'text_entity_name_'.$key} .' '. $text_category_name_urls; ?></span>					<span class="add-on status <?php if($val['status'] ==1){echo "status-on";}else{echo "status-off";}?>" data-toggle="tooltip" title="<?php if($val['status'] ==1){echo $text_status_on;}else{echo $text_status_off;}?>" data-placement="bottom"></span>					<input style="width: 120px;" type="text" name="data[entity][urls][<?php echo  $key;?>][ext]" class="span1" value="<?php echo $val['ext']; ?>">															<div class="btn-group">						<a data-action="prepareGenerate" data-entity="urls-<?php echo  $key;?>" data-scope=".closest('fieldset').find('input')" class="btn btn-success ajax_action" type="button"><?php echo $text_common_generate; ?>!</a>						<a class="btn dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>						<ul class="dropdown-menu">							<li>								<a data-action="prepareClearGenerate" data-data="emty" data-entity="urls-<?php echo  $key;?>" class="bg_red btn-nonstyle ajax_action" type="button"><?php echo $text_common_clear; ?></a>							</li>						</ul>					</div>				</div>			</div>		</div>		</fieldset>	</td>	<td class="info_text">		<dl>			<dt>			<?php echo ${'text_entity_name_'.$key} .' '. $text_category_name_urls; ?>:</dt>			<dd class="info-area">				<?php echo ${'text_entity_gener_desc_'.$key}; ?> 			</dd>		</dl>	</td></tr><!-- STAN_urls END-->				<tr>			<td>				<fieldset>				<div class="control-group">				<label class="control-label" for="CPM_urls"><?php echo $text_common_add_edit_delete_urls; ?></label>					<div class="controls">						<a style="width:165px;" href="#modal-URLTable" role="button" class="btn btn-warning" data-toggle="modal"><?php echo $text_common_open_table; ?></a>					</div>				</div>				</fieldset>			</td>			<td class="info_text">				<dl>					<dt><?php echo $text_common_add_edit_delete_urls; ?>:</dt>					<dd class="info-area">						<?php echo $text_common_add_edit_delete_urls_info; ?>					</dd>				</dl>			</td>		</tr>			</tbody></table><p class="warning">	<?php echo $text_common_alert_exclamation_mark; ?><br></p></form>	<!-- Modal ADD/DELET REFRESH IN grider owNumber (537 line) --><div id="modal-URLTable" class="width_80 modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">  <div class="modal-header">    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>    <h3><?php echo $text_common_edit_standard_url; ?></h3>  </div>  <div class="modal-body">    <table class="table table-hover grider">		<tbody>			<tr class="top_table">				<th> <?php echo $text_common_edit_original_url; ?> </th>				<th> <?php echo $text_common_seo_url; ?> </th>				<th> <?php echo $text_common_action; ?> </th>			</tr>					<?php $i=0; foreach ($data['entity']['urls']['STAN_urls']['data'] as $page_url) { ?>			<tr>			<td>				<input type="text" data-gride-pattern="data[entity][urls][STAN_urls][data][%i1][0]" name="data[entity][urls][STAN_urls][data][<?php echo $i; ?>][0]" class="modal-URLTable-orig_url span2" value="<?php echo $page_url[0]; ?>">			</td>			<td>				<!-- multilanguage for standard urls !-->				<?php foreach ($languages as $l_code => $language){ if(!$language['status'])continue; ?>				<div class="input-prepend">				<span class="add-on">					<img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" />				</span>				<input type="text" data-gride-pattern="data[entity][urls][STAN_urls][data][%i1][1][<?php echo $l_code; ?>]" name="data[entity][urls][STAN_urls][data][<?php echo $i; ?>][1][<?php echo $l_code; ?>]" class="modal-URLTable-seo_url" value="<?php echo $page_url[1][$l_code]; ?>">				</div>				<?php } ?>					<!-- multilanguage for standard urls !-->			</td>			</tr>			<?php $i++;} ?>		</tbody>	</table>  </div>  <div class="modal-footer">    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>	<a data-afteraction="afterAction" data-action="save" data-scope=".parents('#modal-URLTable').find('input')" class="btn ajax_action" data-dismiss="modal" type="button"><?php echo $text_common_save; ?></a>  </div></div><div class="warning"><?php echo $text_common_mode_only_empty_info; ?></div><!-- multilanguage for standard urls !--><style>	#modal-URLTable .modal-URLTable-seo_url{width: 130px;}</style><!-- multilanguage for standard urls !-->