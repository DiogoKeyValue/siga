 <script>
    var sigaStoreSession = localStorage.getItem('siga_store_session') || null,
        sigaStoreUsername = localStorage.getItem('siga_store_username') || null,
        sigaStorePassword = localStorage.getItem('siga_store_password') || null,
        sigaStoreEntidades = JSON.parse(localStorage.getItem('siga_store_entidades')) || [],
        homeSelect = localStorage.getItem('home_select') || null,
        sigaTotal = localStorage.getItem('total') || null,
        req_url = '<?php echo get_option('sss_url'); ?>' || null,
        req_conn = '<?php echo get_option('sss_conn'); ?>' || null,
        req_username = '<?php echo get_option('sss_username'); ?>' || null,
        req_password = '<?php echo get_option('sss_password'); ?>' || null,
        service_path = null,
        combo01 = '<?php echo get_option('sss_prod_order_01'); ?>' || null,
        combo02 = '<?php echo get_option('sss_prod_order_02'); ?>' || null,
        combo03 = '<?php echo get_option('sss_prod_order_03'); ?>' || null,
        combo04 = 'SUB-GRUPO' || null,
        ocultar01 = ('<?php echo get_option('sss_hide_sel01'); ?>'!=='' ? '<?php echo get_option('sss_hide_sel01'); ?>' : ''),
        ocultar02 = ('<?php echo get_option('sss_hide_sel02'); ?>'!=='' ? '<?php echo get_option('sss_hide_sel02'); ?>' : ''),
        ocultar03 = ('<?php echo get_option('sss_hide_sel03'); ?>'!=='' ? '<?php echo get_option('sss_hide_sel03'); ?>' : ''),
        imagePrint = '<?php echo get_option('sss_print_img'); ?>' || null
        msgIndisponivel = '<?php echo get_option('sss_msg_indisponivel'); ?>' || null
        msgArtigoStockRup = '<?php echo get_option('sss_artigos_stock_rup'); ?>' || null
        msgPrecoAlt = '<?php echo get_option('sss_preco_alt'); ?>' || null
        validaStocks = '<?php echo get_option('sss_processamento'); ?>' || null
       

        nrRegistosPag = '<?php echo get_option('sss_rows_per_page'); ?>' || 1,
        //firstResult = '< ?php echo get_option('sss_first_result'); ?>',
        filtroColuna1NotNull = '<?php echo get_option('sss_filtro1'); ?>' || null,
        filtroColuna2NotNull = '<?php echo get_option('sss_filtro2'); ?>' || null,
        filtroColuna3NotNull = '<?php echo get_option('sss_filtro3'); ?>' || null,
        sigaStoreVendedor = '<?php echo get_option('sss_cli'); ?>' || null,
        sigaStoreTipoCBarras = '<?php echo get_option('sss_barcode'); ?>' || null,
        //sigaStoreTipoCBarrasId = '<?php echo get_option('sss_barcode_id'); ?>' || null,
        sigaStoreOption2Required = !('<?php echo get_option('sss_product_type_filter') ?>' === 'false'),
        //sigaStockArm = '<?php echo $string = (get_option('sss_stock_arm'))?>' || null; //armazem
        

        <?php
        function StringToNumber($xy){
                if(is_numeric($xy)){
                    $number = $xy + 0;
                }else { 
                    $number = null;
                } return $number;
        }
        ?>

        sigaStockArm = '<?php echo StringToNumber((get_option('sss_stock_arm'))) ?>' || null; //armazem
        //console.log(sigaStoreOption2Required);
</script>

<div class="row">
    <div class="col-md-12">

        <div class="new-content-form row">

            <div class="new-content-form-is-not-logged-in col-md-4" style="display: none;">

                <div id="alert_auth" class="alert alert-warning" style="display:none;">
                    <strong><?php printf(__( 'erro_auth_lbl', 'siga-store' ))?></strong>
                </div>

                <form class="form-signin">
                    <h2 class="form-signin-heading"><?php printf(__( 'login_lbl', 'siga-store' )); ?></h2>

                    <label for="inputEmailUser" style="margin: 10px 0;"><?php printf(__( 'username_lbl', 'siga-store' )); ?></label>
                    <input type="text" id="inputEmailUser" class="form-control" required="" autofocus="">

                    <label for="inputPasswordUser" style="margin: 10px 0;"><?php printf(__( 'password_lbl', 'siga-store' )); ?></label>
                    <input type="password" id="inputPasswordUser" class="form-control" required="">

                    <button class="btn btn-lg btn-primary btn-block" style="margin-top: 10px;" type="submit"><?php printf(__('sign_in_lbl', 'siga-store')); ?></button>
                </form>
            </div>

            <div class="new-content-form-is-logged-in col-md-12" style="display: none;">
                <h4 id="welcome_title"><strong><?php printf(__( 'welcome_lbl', 'siga-store' )); ?></strong></h4>

                <?php include_once('siga_store_content.php'); ?>
            </div>
        </div>

        <script>
            function startLoader() {
                $('.checkout-overlay').addClass('is-active');
            }

            function stopLoader() {
                $('.checkout-overlay').removeClass('is-active');
            }

            if (sigaStoreSession === null) {

                $('.new-content-form-is-logged-in').hide();
                $('.new-content-form-is-not-logged-in').show();

                $( ".form-signin" ).submit(function( event ) {
                    event.preventDefault();

                    $("#alert_auth").hide();

                    var user_password = $(this).find('#inputPasswordUser').val(),
                        username = $(this).find('#inputEmailUser').val();

                    service_path= '/seam/resource/rest/sigaAutenticarRESTful/getUserAutenticadoInJson/';

                    $.ajax({
                        type: "GET",
                        url: req_url+service_path+req_conn+':'+req_username+':'+req_password+'/'+username+'/'+btoa(user_password)+'/?entidades=true',
                        dataType: 'json',
                        async: false,
                        headers: {
                            "Authorization": "Basic " + btoa(username + ":" + user_password)
                        },
                        timeout: 60000,
                        beforeSend: function() {
                            startLoader();
                        },
                        success: function (data){

                            var result = data;

                            localStorage.setItem('siga_store_session', result['jsBaseBeanRESTful']['systemDate']);
                            localStorage.setItem('siga_store_username', result['jsBaseBeanRESTful']['usersBeanRestful']['username']);
                            localStorage.setItem('siga_store_password', user_password);
                            if(result['jsBaseBeanRESTful']['usersBeanRestful']['jsEntidadesBeanRestfuls']!=null){
                                localStorage.setItem('siga_store_entidades', JSON.stringify(result['jsBaseBeanRESTful']['usersBeanRestful']['jsEntidadesBeanRestfuls']));
                                localStorage.setItem('home_select', result['jsBaseBeanRESTful']['usersBeanRestful']['jsEntidadesBeanRestfuls'][0]['seqEntidade']);
                            }

                            localStorage.setItem('total', 0);

                            //var numberOfMillisecondsSinceEpoch = Number(new Date());
                            //sessionStorage.setItem("session_time", numberOfMillisecondsSinceEpoch);

                            stopLoader();

                            location.reload();
                        },
                        error: function (data) {
                            $("#alert_auth").show();
                            stopLoader();
                        }
                    });
                });
            } else {
                /*if(sessionStorage.getItem("session_time")===null){
                    localStorage.clear();
                    sessionStorage.clear();
                    location.reload();
                }*/

                $("#welcome_title").html("<strong><?php printf(__( 'welcome_lbl', 'siga-store' )); ?> "+sigaStoreUsername+"</strong>");
                $('.new-content-form-is-logged-in').show();
                $('.new-content-form-is-not-logged-in').hide();
            }
        </script>

        <div class="checkout-overlay">
            <div class="checkout-overlay-loading">
                <h5>Loading</h5>
                <div class="lds-ripple"><div></div><div></div></div>
            </div>
        </div>
    </div>
</div>