<?php
 //echo "hello settings";
	//global $chk;
	global $chk_url, $chk_conn, $chk_username, $chk_password;
	global $chk_tab01,$chk_tab02,$chk_tab03;
	global $chk_prod_order_01, $chk_prod_order_02,
           $chk_hide_sel01, $chk_hide_sel02;
	global $chk_images_url, $chk_images_path, $chk_rows_per_page, $chk_dd_select_name, $chk_registers_per_page,
           $chk_first_result, $chk_cli, $chk_barcode, $chk_min_enc, $chk_product_type_filter,
		   $chk_print_img_filter, $chk_msg_indisponivel_filter, $chk_preco_alt_filter, $chk_artigos_stock_rup_filter,
		   $chk_artigos_stock_rup_filter;

	if (isset($_POST['siga_store_settings_submit'])) {
		settings_opt_SS();
		prod_order_opt_SS();
		settings_tabs();
		extra_opt_SS();
	}
	function settings_tabs(){
		//!"#
		$sss_filtro1 = $_POST['sss_filtro1'];
		$sss_valorFiltro1 = $_POST['sss_valorFiltro1'];
		$sss_filtro2 = $_POST['sss_filtro2'];
		$sss_valorFiltro2 = $_POST['sss_valorFiltro2'];
		$sss_filtro3 = $_POST['sss_filtro3'];
		$sss_valorFiltro3 = $_POST['sss_valorFiltro3'];
		
		$sss_nometab1 = $_POST['sss_nometab1'];
		$sss_nometab2 = $_POST['sss_nometab2'];
		$sss_nometab3 = $_POST['sss_nometab3'];

		$sss_pathtab1 = $_POST['sss_pathtab1'];
		$sss_pathtab2 = $_POST['sss_pathtab2'];
		$sss_pathtab3 = $_POST['sss_pathtab3'];

		$sss_background1 = $_POST['sss_background1'];
		$sss_opacity1 = $_POST['sss_opacity1'];
		$sss_color1 = $_POST['sss_color1'];

		$sss_background2 = $_POST['sss_background2'];
		$sss_opacity2 = $_POST['sss_opacity2'];
		$sss_color2 = $_POST['sss_color2'];

		$sss_background3 = $_POST['sss_background3'];
		$sss_opacity3 = $_POST['sss_opacity3'];
		$sss_color3 = $_POST['sss_color3'];

		global $chk_tab01,$chk_tab02,$chk_tab03,$chk_valorTab01,$chk_valorTab02,$chk_valorTab03,
		$chk_nometab01,$chk_nometab02,$chk_nometab03,$chk_pathtab1,$chk_pathtab2,$chk_pathtab3,
		$chk_background1,$chk_background2,$chk_background3,$chk_opacity1,$chk_opacity2,$chk_opacity3,$chk_color1,$chk_color2,$chk_color3;

		if(get_option('sss_filtro1') !=trim($sss_filtro1)){
			$chk_tab01 = update_option('sss_filtro1',trim($sss_filtro1));
		}
		if(get_option('sss_filtro2') !=trim($sss_filtro2)){
			$chk_tab02 = update_option('sss_filtro2',trim($sss_filtro2));
		}
		if(get_option('sss_filtro3') !=trim($sss_filtro3)){
			$chk_tab03 = update_option('sss_filtro3',trim($sss_filtro3));
		}

		if(get_option('sss_valorFiltro1') !=trim($sss_valorFiltro1)){
			$chk_valorTab01 = update_option('sss_valorFiltro1',trim($sss_valorFiltro1));
		}
		if(get_option('sss_valorFiltro2') !=trim($sss_valorFiltro2)){
			$chk_valorTab02 = update_option('sss_valorFiltro2',trim($sss_valorFiltro2));
		}
		if(get_option('sss_valorFiltro3') !=trim($sss_valorFiltro3)){
			$chk_valorTab03 = update_option('sss_valorFiltro3',trim($sss_valorFiltro3));
		}

		if(get_option('sss_nometab1') !=trim($sss_nometab1)){
			$chk_nometab01 = update_option('sss_nometab2',trim($sss_nometab1));
		}
		if(get_option('sss_nometab2') !=trim($sss_nometab2)){
			$chk_nometab02 = update_option('sss_nometab2',trim($sss_nometab2));
		}
		if(get_option('sss_nometab3') !=trim($sss_nometab3)){
			$chk_nometab03 = update_option('sss_nometab3',trim($sss_nometab3));
		}
		
		if(get_option('sss_pathtab1') !=trim($sss_pathtab1)){
			$chk_pathtab1 = update_option('sss_pathtab1',trim($sss_pathtab1));
		}
		if(get_option('sss_pathtab2') !=trim($sss_pathtab2)){
			$chk_pathtab2 = update_option('sss_pathtab2',trim($sss_pathtab2));
		}
		if(get_option('sss_pathtab3') !=trim($sss_pathtab3)){
			$chk_pathtab3 = update_option('sss_pathtab3',trim($sss_pathtab3));
		}

		if(get_option('sss_background1') !=trim($sss_background1)){
			$chk_background1 = update_option('sss_background1',trim($sss_background1));
		}
		if(get_option('sss_background2') !=trim($sss_background2)){
			$chk_background2 = update_option('sss_background2',trim($sss_background2));
		}
		if(get_option('sss_background3') !=trim($sss_background3)){
			$chk_background3 = update_option('sss_background3',trim($sss_background3));
		}


		if(get_option('sss_opacity1') !=trim($sss_opacity1)){
			$chk_opacity1 = update_option('sss_opacity1',trim($sss_opacity1));
		}
		if(get_option('sss_opacity2') !=trim($sss_opacity2)){
			$chk_opacity2 = update_option('sss_opacity2',trim($sss_opacity2));
		}
		if(get_option('sss_opacity3') !=trim($sss_opacity3)){
			$chk_opacity3 = update_option('sss_opacity3',trim($sss_opacity3));
		}

		if(get_option('sss_color1') !=trim($sss_color1)){
			$chk_color1 = update_option('sss_color1',trim($sss_color1));
		}
		if(get_option('sss_color2') !=trim($sss_color2)){
			$chk_color2 = update_option('sss_color2',trim($sss_color2));
		}
		if(get_option('sss_color3') !=trim($sss_color3)){
			$chk_color3 = update_option('sss_color3',trim($sss_color3));
		}

		
	}
	function settings_opt_SS(){
		$sss_url_txt = $_POST['sss_url_name'];
		$sss_conn_txt = $_POST['sss_conn_name'];
		$sss_username_txt = $_POST['sss_username_name'];
		$sss_password_txt = $_POST['sss_password_name'];
		//global $chk;
		global $chk_url, $chk_conn, $chk_username, $chk_password;
		if(get_option('sss_url') !=trim($sss_url_txt)){
			$chk_url = update_option('sss_url',trim($sss_url_txt));
		}
		if(get_option('sss_conn') !=trim($sss_conn_txt)){
			$chk_conn = update_option('sss_conn',trim($sss_conn_txt));
		}
		if(get_option('sss_username') !=trim($sss_username_txt)){
			$chk_username = update_option('sss_username',trim($sss_username_txt));
		}
		if(get_option('sss_password') !=trim($sss_password_txt)){
			$chk_password = update_option('sss_password',trim($sss_password_txt));
		}
	}
	function prod_order_opt_SS(){
		$sss_select_prod_order01 = $_POST['sss_prod_select_01_name'];
		$sss_select_prod_order02 = $_POST['sss_prod_select_02_name'];
		$sss_select_prod_order03 = $_POST['sss_prod_select_03_name'];

        $sss_hide_sel01 = $_POST['sss_hide_sel01'];
        $sss_hide_sel02 = $_POST['sss_hide_sel02'];
		$sss_hide_sel03 = $_POST['sss_hide_sel03'];
		
		global $chk_prod_order_01, $chk_prod_order_02, $chk_prod_order_03,
               $chk_hide_sel01, $chk_hide_sel02, $chk_hide_sel03;

		if(get_option('sss_prod_order_01') !=trim($sss_select_prod_order01)){
			$chk_prod_order_01 = update_option('sss_prod_order_01',trim($sss_select_prod_order01));
		}
		if(get_option('sss_prod_order_02') !=trim($sss_select_prod_order02)){
			$chk_prod_order_02 = update_option('sss_prod_order_02',trim($sss_select_prod_order02));
		}
		if(get_option('sss_prod_order_03') !=trim($sss_select_prod_order03)){
			$chk_prod_order_03 = update_option('sss_prod_order_03',trim($sss_select_prod_order03));
		}


        if(get_option('sss_hide_sel01') !=trim(sss_hide_sel01)){
            $chk_hide_sel01 = update_option('sss_hide_sel01',trim($sss_hide_sel01));
        }
        if(get_option('sss_hide_sel02') !=trim(sss_hide_sel02)){
            $chk_hide_sel02 = update_option('sss_hide_sel02',trim($sss_hide_sel02));
        }
		if(get_option('sss_hide_sel03') !=trim(sss_hide_sel03)){
            $chk_hide_sel03 = update_option('sss_hide_sel03',trim($sss_hide_sel03));
        }
		
	}
	function extra_opt_SS(){
		$sss_images_url = $_POST['sss_images_url'];
		$sss_images_path = $_POST['sss_images_path'];
		$sss_rows_per_page = $_POST['sss_rows_per_page'];

		$sss_dd_select_name = $_POST['sss_dd_select_name'];

		//$sss_registers_per_page = $_POST['sss_registers_per_page'];
		//$sss_first_result = $_POST['sss_first_result'];

		$sss_cli = $_POST['sss_cli'];

		$sss_barcode = $_POST['sss_barcode'];

		$sss_min_enc = $_POST['sss_min_enc'];

        $sss_product_type_filter=$_POST['sss_product_type_filter'];

		$sss_processamento=$_POST['sss_processamento'];

		$sss_print_img_filter=$_POST['sss_print_img'];

		$sss_msg_indisponivel_filter=$_POST['sss_msg_indisponivel'];
		$sss_artigos_stock_rup_filter=$_POST['sss_artigos_stock_rup'];
		$sss_preco_alt_filter=$_POST['sss_preco_alt'];
		$sss_stock_arm_filter=$_POST['sss_stock_arm'];
		
		global $chk_images_url, $chk_images_path, $chk_rows_per_page, $chk_dd_select_name, $chk_registers_per_page ,
               $chk_first_result, $chk_cli, $chk_barcode, $chk_min_enc,$chk_product_type_filter, $chk_sss_processamento,$chk_print_img_filter,
			   $chk_msg_indisponivel_filter, $chk_artigos_stock_rup_filter, $chk_preco_alt_filter, $chk_stock_arm_filter;

		if(get_option('sss_images_url') !=trim($sss_images_url)){
			$chk_images_url = update_option('sss_images_url',trim($sss_images_url));
		}
		if(get_option('sss_images_path') !=trim($sss_images_path)){
			$chk_images_path = update_option('sss_images_path',trim($sss_images_path));
		}
		if(get_option('sss_rows_per_page') !=trim($sss_rows_per_page)){
			$chk_rows_per_page = update_option('sss_rows_per_page',trim($sss_rows_per_page));
		}
		if(get_option('sss_dd_select_name') !=trim($sss_dd_select_name)){
			$chk_dd_select_name = update_option('sss_dd_select_name',trim($sss_dd_select_name));
		}
		if(get_option('sss_cli') !=trim($sss_cli)){
			$chk_cli = update_option('sss_cli',trim($sss_cli));
		}
		if(get_option('sss_barcode') !=trim($sss_barcode)){
			$chk_barcode = update_option('sss_barcode',trim($sss_barcode));
		}

		if(get_option('sss_min_enc') !=trim($sss_min_enc)){
			$chk_min_enc = update_option('sss_min_enc',trim($sss_min_enc));
		}
        if(get_option('sss_product_type_filter') !=trim($sss_product_type_filter)){
            $chk_product_type_filter = update_option('sss_product_type_filter',trim($sss_product_type_filter));
        }

		if(get_option('sss_processamento') !=trim($sss_processamento)){
            $chk_sss_processamento = update_option('sss_processamento',trim($sss_processamento));
        }
		

		if(get_option('sss_print_img') !=trim($sss_print_img_filter)){
            $chk_print_img_filter = update_option('sss_print_img',trim($sss_print_img_filter));
        }

		if(get_option('sss_msg_indisponivel') !=trim($sss_msg_indisponivel_filter)){
            $chk_msg_indisponivel_filter = update_option('sss_msg_indisponivel',trim($sss_msg_indisponivel_filter));
        }

		if(get_option('sss_preco_alt') !=trim($sss_preco_alt_filter)){
            $chk_preco_alt_filter = update_option('sss_preco_alt',trim($sss_preco_alt_filter));
        }
		if(get_option('sss_artigos_stock_rup') !=trim($sss_artigos_stock_rup_filter)){
            $chk_artigos_stock_rup_filter = update_option('sss_artigos_stock_rup',trim($sss_artigos_stock_rup_filter));
        }

		if(get_option('sss_stock_arm') !=trim($sss_stock_arm_filter)){
            $chk_stock_arm_filter = update_option('sss_stock_arm',trim($sss_stock_arm_filter));
        }
	}
?>
<style type="text/css"> 
.ss_settings_input{
	width: 350px;
}
.ss_settings_inputtabs{
	width: 300px;
}
.ss_settings_submit{
	padding-top: 10px!important; 
	padding-bottom: 10px!important;
}
</style>
<script type="text/javascript">
	(function($){
		$(document).ready(function(){

			$( "#dd_select" ).ready(function() {
				populate_dropdown_display("#dd_select");
			});
			//alert("ok");
			$( "#prod_select_01" ).change(function() {
			  	update_select("#prod_select_02");
			});
			$( "#prod_select_01" ).ready(function() {
			  	populate_dropdown("#prod_select_01",0,0);
			  	//$("#prod_select_01 option[value="+$("#prod_select_02").find('option:selected').val()+"]").remove();
			});
			$( "#prod_select_02" ).change(function() {
			  	update_select("#prod_select_01");
			});
			$( "#prod_select_02" ).ready(function() {
			  	//update_select_1();
			  	populate_dropdown("#prod_select_02",0,0);
			  	$("#prod_select_02 option[value="+$("#prod_select_01").find('option:selected').val()+"]").remove();
			  	$("#prod_select_01 option[value="+$("#prod_select_02").find('option:selected').val()+"]").remove();
			});
			$( "#prod_select_03" ).change(function() {
			  	update_select("#prod_select_01");
				update_select("#prod_select_02");
			});
			$( "#prod_select_03" ).ready(function() {
			  	populate_dropdown("#prod_select_03",0,0);
				$("#prod_select_03 option[value="+$("#prod_select_01").find('option:selected').val()+"]").remove();
				$("#prod_select_03 option[value="+$("#prod_select_02").find('option:selected').val()+"]").remove();
			  	$("#prod_select_02 option[value="+$("#prod_select_01").find('option:selected').val()+"]").remove();
			  	$("#prod_select_01 option[value="+$("#prod_select_02").find('option:selected').val()+"]").remove();
			});


			function populate_dropdown_display(obj_name){
				var values = ["","list", "grid"];
				var value_selected = '';
				var option = '';

				for (var i=0;i<values.length;i++){
					//populate options
						//set var
						if(obj_name=="#dd_select"){
							value_selected="<?php echo get_option('sss_dd_select_name'); ?>";
						}
						//add select option selected
						if(value_selected!=null){
							if(value_selected==values[i]){
								option += '<option value="'+ values[i] + '"selected>' + values[i] + '</option>';
							}else{
								option += '<option value="'+ values[i] + '">' + values[i] + '</option>';
							}
						}else{
							if(i==0){
								option += '<option value="'+ values[i] + '"selected>' + values[i] + '</option>';
							}else{
								option += '<option value="'+ values[i] + '">' + values[i] + '</option>';
							}
						}
				}
				
				$(obj_name).append(option);

			}


			function update_select(obj_to_update){
				var option_1_selected = $("#prod_select_01").find('option:selected').val();
			    //alert("option_1_selected: "+option_1_selected);
				var option_2_selected=$("#prod_select_02").find('option:selected').val();
				var option_3_selected=$("#prod_select_03").find('option:selected').val();
				//alert("update_select");
				//alert("option_2_selected: "+option_2_selected);

				if(option_1_selected==option_2_selected){
					//$(obj_to_update).find('option:selected').remove();
					$(obj_to_update).children().remove();
					if(obj_to_update=="#prod_select_01"){
						populate_dropdown(obj_to_update,
									$("#prod_select_02").find('option:selected').text(),
									$("#prod_select_02").find('option:selected').val());
						//$("#prod_select_02 option[value="+$("#prod_select_01").find('option:selected').val()+"]").remove();
					}
					else if(obj_to_update=="#prod_select_02"){
						populate_dropdown(obj_to_update,
									$("#prod_select_01").find('option:selected').text(),
									$("#prod_select_01").find('option:selected').val());
						//$("#prod_select_01 option[value="+$("#prod_select_02").find('option:selected').val()+"]").remove();
					}
					else if(obj_to_update=="#prod_select_03"){
						populate_dropdown(obj_to_update,
									$("#prod_select_01").find('option:selected').text(),
									$("#prod_select_01").find('option:selected').val());
						populate_dropdown(obj_to_update,
									$("#prod_select_02").find('option:selected').text(),
									$("#prod_select_02").find('option:selected').val());
						//$("#prod_select_01 option[value="+$("#prod_select_02").find('option:selected').val()+"]").remove();
					}
				}
			}
			function populate_dropdown(obj_name,obj_text,obj_val){
				var text = ["", "FAMILIA", "CLASSE", "GRUPO", "SUB_GRUPO"];
				//cFamilia, cClasseArt, cGruposArt, cSubGrupos
				var numbers = ["", "FAMILIA", "CLASSE", "GRUPO", "SUB_GRUPO"];
				var option = '';

				var value_selected = '';

				for (var i=0;i<numbers.length;i++){
					//populate options
					if(obj_text==0 && obj_val==0){
						//set var
						if(obj_name=="#prod_select_01"){
							value_selected="<?php echo get_option('sss_prod_order_01'); ?>";
						}else if(obj_name=="#prod_select_02"){
							value_selected="<?php echo get_option('sss_prod_order_02'); ?>";
						} else if(obj_name=="#prod_select_03"){
							value_selected="<?php echo get_option('sss_prod_order_03'); ?>";
						}
						
						//add select option selected
						if(value_selected!=null){
							if(value_selected==numbers[i]){
							option += '<option value="'+ numbers[i] + '"selected>' + text[i] + '</option>';
							}else{
								option += '<option value="'+ numbers[i] + '">' + text[i] + '</option>';
							}
						}else{
							if(i==0){
							option += '<option value="'+ numbers[i] + '"selected>' + text[i] + '</option>';
							}else{
								option += '<option value="'+ numbers[i] + '">' + text[i] + '</option>';
							}
						}
						
					}else if(obj_text!=text[i] && obj_val!= numbers[i]){
						option += '<option value="'+ numbers[i] + '">' + text[i] + '</option>';
					}
				}
				$(obj_name).append(option);
				//$('#prod_select_02').append(option);
			}

		});
	})(jQuery);
</script>
<div class="wrap">
	<div id="icon-options-general" class="icon32"> <br/>
	</div>
	<!--h2>Siga Store Settings options</h2-->
	<?php if(isset($_POST['siga_store_settings_submit']) && ($chk_url || $chk_conn || $chk_username || $chk_password ||
            $chk_prod_order_01 || $chk_prod_order_02 || $chk_images_url || $chk_images_path || $chk_rows_per_page || $chk_dd_select_name ||
             $chk_cli || $chk_barcode || $chk_min_enc || $chk_product_type_filter || $chk_sss_processamento || $chk_hide_sel01 || $chk_hide_sel02 || $chk_tab01 || $chk_tab02 || $chk_tab03 || 
			 $chk_valorTab01 || $chk_valorTab02 || $chk_valorTab03 ||$chk_background1 || $chk_background2 || $chk_background3 || $chk_opacity1 || $chk_opacity2 || $chk_opacity3 || $chk_color1 || 
			 $chk_color2 || $chk_color3)): //echo "inicio - validar"; ?>
	<div id="message" class="updated below-h2">
		<p><?php printf(__( 'settings_update_ok_lbl', 'siga-store' )); ?></p>
	</div>
	<?php endif; //echo "fim - validar"; ?>
	<div class="metabox-holder">
		<div class="postbox" style="padding-left: 10px">
			<h3><strong><?php printf(__( 'warn_content_save_lbl', 'siga-store' )); ?></strong></h3>
			<form method="post" action="">
				<table class="form-table">
					<tr>
						<th scope="row"><h3><?php printf(__( 'settings_title_01_lbl', 'siga-store' )); ?></h3></th>
						<td>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php printf(__( 'settings_url_01_lbl', 'siga-store' )); ?></th>
						<td>
							<input type="text" name="sss_url_name" value="<?php echo get_option('sss_url'); ?>" class="ss_settings_input">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php printf(__( 'settings_conn_01_lbl', 'siga-store' )); ?></th>
						<td>
							<input type="text" name="sss_conn_name" value="<?php echo get_option('sss_conn'); ?>" class="ss_settings_input">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php printf(__( 'settings_username_01_lbl', 'siga-store' )); ?></th>
						<td>
							<input type="text" name="sss_username_name" value="<?php echo get_option('sss_username'); ?>" class="ss_settings_input">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php printf(__( 'settings_password_01_lbl', 'siga-store' )); ?></th>
						<td>
							<input type="password" name="sss_password_name" value="<?php echo get_option('sss_password'); ?>" class="ss_settings_input">
						</td>
					</tr>

					<tr>
						<th scope="row"><h3><?php printf(__( 'settings_title_02_lbl', 'siga-store' )); ?></h3></th>
						<td>
						</td>
					</tr>
					<tr>
						<th scope="row">#1</th>
						<td>
							<select id="prod_select_01" name="sss_prod_select_01_name">
							</select>
                            &nbsp;<?php printf(__('hide_lbl', 'siga-store')); ?>&nbsp;
                            <input type="text" name="sss_hide_sel01" value="<?php echo get_option('sss_hide_sel01'); ?>" placeholder="<?php printf(__('combo_hide_value_place', 'siga-store')); ?>" class="ss_settings_input">
						</td>
					</tr>
					<tr>
						<th scope="row">#2</th>
						<td>
							<select id="prod_select_02" name="sss_prod_select_02_name">
							</select>
                            &nbsp;<?php printf(__('hide_lbl', 'siga-store')); ?>&nbsp;
                            <input type="text" name="sss_hide_sel02" value="<?php echo get_option('sss_hide_sel02'); ?>" placeholder="<?php printf(__('combo_hide_value_place', 'siga-store')); ?>" class="ss_settings_input">
						</td>
					</tr>

					<tr>
						<th scope="row">#3</th>
						<td>
							<select id="prod_select_03" name="sss_prod_select_03_name">
							</select>
                            &nbsp;<?php printf(__('hide_lbl', 'siga-store')); ?>&nbsp;
                            <input type="text" name="sss_hide_sel03" value="<?php echo get_option('sss_hide_sel03'); ?>" placeholder="<?php printf(__('combo_hide_value_place', 'siga-store')); ?>" class="ss_settings_input">
						</td>
					</tr>

					<!-- campos dos tabs !"# -->
					<tr>
						<th scope="row"><h3><?php printf(__( 'Tabs (Extras)', 'siga-store' )); ?></h3></th>
						<td>
						</td>
					</tr>

					<tr>
					<th scope="row"><?php printf(__('Tab 1', 'siga-store')); ?></th>
                        <td>
							<input type="text" name="sss_nometab1" value="<?php echo get_option('sss_nometab1'); ?>" class="ss_settings_input" placeholder="Nome do Tab" maxlength="20">
							<input type="text" name="sss_filtro1" value="<?php echo get_option('sss_filtro1'); ?>" class="ss_settings_input" placeholder="Filtro do Tab">
							<input type="text" name="sss_pathtab1" value="<?php echo get_option('sss_pathtab1'); ?>" class="ss_settings_input" placeholder="Path da Imagem para o tab">
                        </td>
						<td>
							<input type="text" name="sss_background1" value="<?php echo get_option('sss_background1'); ?>" class="ss_settings_input" placeholder="Cor Hexadecimal do Tab" maxlength="20">
							<input type="text" name="sss_opacity1" value="<?php echo get_option('sss_opacity1'); ?>" class="ss_settings_input" placeholder="Opacidade do Tab">
							<input type="text" name="sss_color1" value="<?php echo get_option('sss_color1'); ?>" class="ss_settings_input" placeholder="Cor Hexadecimal da letra">
						</td>
						<td>
							<input type="text" name="sss_valorFiltro1" value="<?php echo get_option('sss_valorFiltro1'); ?>" placeholder="Marca do Tab">
						</td>
                    </tr>
					<tr>
                        <th scope="row"><?php printf(__('Tab 2', 'siga-store')); ?></th>
                        <td>
							<input type="text" name="sss_nometab2" value="<?php echo get_option('sss_nometab2'); ?>" class="ss_settings_input" placeholder="Nome do Tab" maxlength="20">
							<input type="text" name="sss_filtro2" value="<?php echo get_option('sss_filtro2'); ?>" class="ss_settings_input" placeholder="Filtro do Tab">
							<input type="text" name="sss_pathtab2" value="<?php echo get_option('sss_pathtab2'); ?>" class="ss_settings_input" placeholder="Path da Imagem para o tab">
                        </td>
					
						<td>
							<input type="text" name="sss_background2" value="<?php echo get_option('sss_background2'); ?>" class="ss_settings_input" placeholder="Cor Hexadecimal do Tab" maxlength="20">
							<input type="text" name="sss_opacity2" value="<?php echo get_option('sss_opacity2'); ?>" class="ss_settings_input" placeholder="Opacidade do Tab">
							<input type="text" name="sss_color2" value="<?php echo get_option('sss_color2'); ?>" class="ss_settings_input" placeholder="Cor Hexadecimal da letra">
						</td>
						<td>
							<input type="text" name="sss_valorFiltro2" value="<?php echo get_option('sss_valorFiltro2'); ?>" placeholder="Marca do Tab">
						</td>
					</tr>
					<tr>
                        <th scope="row"><?php printf(__('Tab 3', 'siga-store')); ?></th>
                        <td>
							<input type="text" name="sss_nometab3" value="<?php echo get_option('sss_nometab3'); ?>" class="ss_settings_input" placeholder="Nome do Tab" maxlength="20"> 
							<input type="text" name="sss_filtro3" value="<?php echo get_option('sss_filtro3'); ?>" class="ss_settings_input"  placeholder="Filtro do Tab">
							<input type="text" name="sss_pathtab3" value="<?php echo get_option('sss_pathtab3'); ?>" class="ss_settings_input" placeholder="Path da Imagem para o tab"> 
                        </td>
						<td>
							<input type="text" name="sss_background3" value="<?php echo get_option('sss_background3'); ?>" class="ss_settings_input" placeholder="Cor Hexadecimal do Tab" maxlength="20">
							<input type="text" name="sss_opacity3" value="<?php echo get_option('sss_opacity3'); ?>" class="ss_settings_input" placeholder="Opacidade do Tab">
							<input type="text" name="sss_color3" value="<?php echo get_option('sss_color3'); ?>" class="ss_settings_input" placeholder="Cor Hexadecimal da letra">
						</td>
						<td >
							<input type="text" name="sss_valorFiltro3" value="<?php echo get_option('sss_valorFiltro3'); ?>" placeholder="Marca do Tab">
						</td>
					</tr>
					
					<!-- fim campos dos tabs -->

					<tr>
						<th scope="row"><h3><?php printf(__( 'settings_title_03_lbl', 'siga-store' )); ?></h3></th>
						<td>
						</td>
					</tr>
					<!--tr>
						<th scope="row">< ?php printf(__( 'settings_img_url_03_lbl', 'siga-store' )); ?></th>
						<td>
							<input type="text" name="sss_images_url" value="< ?php echo get_option('sss_images_url'); ?>" class="ss_settings_input">
						</td>
					</tr-->

					<tr>
						<th scope="row"><?php printf(__( 'cli_lbl', 'siga-store' )); ?></th>
						<td>
							<input type="text" name="sss_cli" value="<?php echo get_option('sss_cli'); ?>" class="ss_settings_input">
						</td>
					</tr>

					<tr>
						<th scope="row"><?php printf(__( 'settings_dir_img_03_lbl', 'siga-store' )); ?></th>
						<td>
							<input type="text" name="sss_images_path" value="<?php echo get_option('sss_images_path'); ?>" class="ss_settings_input">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php printf(__( 'settings_rows_page_03_lbl', 'siga-store' )); ?></th>
						<td>
							<input type="number" name="sss_rows_per_page" value="<?php echo get_option('sss_rows_per_page'); ?>" class="ss_settings_input">
						</td>
					</tr>
					<tr>
						<th scope="row"><?php printf(__( 'data_display_lbl', 'siga-store' )); ?></th>
						<td>
							<select id="dd_select" name="sss_dd_select_name">
							</select>
						</td>
					</tr>
					<!--tr>
						<th scope="row">< ?php printf(__( 'registers_per_page_lbl', 'siga-store' )); ?></th>
						<td>
							<input type="number" name="sss_registers_per_page" value="< ?php echo get_option('sss_registers_per_page'); ?>" class="ss_settings_input">
						</td>
					</tr>
					<tr>
						<th scope="row">< ?php printf(__( 'first_result_lbl', 'siga-store' )); ?></th>
						<td>
							<input type="number" name="sss_first_result" value="< ?php echo get_option('sss_first_result'); ?>" class="ss_settings_input">
						</td>
					</tr-->

					<tr>
						<th scope="row"><?php printf(__('barcode_type_lbl', 'siga-store')); ?></th>
						<td>
							<input type="text" name="sss_barcode" value="<?php echo get_option('sss_barcode'); ?>" class="ss_settings_input">
						</td>
					</tr>

				

					<tr>
						<th scope="row"><?php printf(__('min_enc_value_lbl', 'siga-store')); ?></th>
						<td>
							<input type="number" name="sss_min_enc" value="<?php echo get_option('sss_min_enc'); ?>" class="ss_settings_input">
						</td>
					</tr>

                    <tr>
                        <th scope="row"><?php printf(__('combo2_req_lbl', 'siga-store')); ?></th>
                        <td>
                            <input type="radio" name="sss_product_type_filter" value="true" <?php if (get_option('sss_product_type_filter') == 'true') { echo 'checked'; }; ?>> <?php printf(__('yes_option_lbl', 'siga-store')); ?>
                            <input type="radio" name="sss_product_type_filter" value="false" <?php if (get_option('sss_product_type_filter') == 'false') { echo 'checked'; }; ?>  style="margin-left: 15px;"> <?php printf(__('no_option_lbl', 'siga-store')); ?>
                        </td>
                    </tr>

					<tr>
                        <th scope="row"><?php printf(__('Validação Lotes na Encomenda', 'siga-store')); ?></th>
                        <td>
                            <input type="radio" name="sss_processamento" value="true" <?php if (get_option('sss_processamento') == 'true') { echo 'checked'; }; ?>> <?php printf(__('yes_option_lbl', 'siga-store')); ?>
                            <input type="radio" name="sss_processamento" value="false" <?php if (get_option('sss_processamento') == 'false') { echo 'checked'; }; ?>  style="margin-left: 15px;"> <?php printf(__('no_option_lbl', 'siga-store')); ?>
                        </td>
                    </tr>

					<tr>
                        <th scope="row"><?php printf(__('Imagem Fatura/Recibo', 'siga-store')); ?></th>
                        <td>
							<input type="text" name="sss_print_img" value="<?php echo get_option('sss_print_img'); ?>" class="ss_settings_input">
                        </td>
                    </tr>

					<tr>
                        <th scope="row"><?php printf(__('Mensagem Produto Indisponível', 'siga-store')); ?></th>
                        <td>
							<input type="text" name="sss_msg_indisponivel" value="<?php echo get_option('sss_msg_indisponivel'); ?>" class="ss_settings_input">
                        </td>
                    </tr>

					<tr>
                        <th scope="row"><?php printf(__('Mensagem Artigos Stock', 'siga-store')); ?></th>
                        <td>
							<input type="text" name="sss_artigos_stock_rup" value="<?php echo get_option('sss_artigos_stock_rup'); ?>" class="ss_settings_input">
                        </td>
                    </tr>

					<tr>
                        <th scope="row"><?php printf(__('Mensagem Alteração de Preços', 'siga-store')); ?></th>
                        <td>
							<input type="text" name="sss_preco_alt" value="<?php echo get_option('sss_preco_alt'); ?>" class="ss_settings_input">
                        </td>
                    </tr>

					

					<tr>
                        <th scope="row"><?php printf(__('Armazém', 'siga-store')); ?></th>
                        <td>
							<input type="text" name="sss_stock_arm" value="<?php echo get_option('sss_stock_arm'); ?>" class="ss_settings_input">
                        </td>
                    </tr>

					<tr>
						<th scope="row">&nbsp;</th>
						<td class="ss_settings_submit"><input type="submit" name="siga_store_settings_submit" value="<?php printf(__( 'settings_save_changes_lbl', 'siga-store' )); ?>" class="button-primary"></td>
					</tr>

				
					
				</table>
			</form>
		</div>
	</div>
</div>