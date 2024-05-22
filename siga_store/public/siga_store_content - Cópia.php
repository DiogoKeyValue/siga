<script type="text/javascript">

    var ONE_HOUR = 60*60 * 1000;

    function idleTime(){
        var loginTime = sessionStorage.getItem("session_time");
        var currentTime = Number(new Date());
      
        if(loginTime !== null){
            if(Math.abs(currentTime-loginTime)>ONE_HOUR){
                localStorage.clear();
                sessionStorage.clear();
                location.reload();
            }
        }
    }

    var timeout_ajax = 80000;
    var timeout_delay= 500;

    jQuery(document).ready(function () {

        $('.header-image a').on('click', function(e) { e.preventDefault(); })

        if (sigaStoreEntidades === null || sigaStoreEntidades === "") {
            $('#catalog_page').hide();
            $('#cart_page').hide();
            $('#orders_page').hide();
        } else {
            if (homeSelect == null) {
                //no cookie
                $('#catalog_page').hide();
                $('#cart_page').hide();
                $('#orders_page').hide();
            } else {
                //have cookie
                $('#catalog_page').show();
                $('#cart_page').show();
                $('#orders_page').show();
            }

            var data_ent = '';

            if (sigaStoreEntidades!=null && sigaStoreEntidades.length > 1) {

                var html_code = '';

                html_code += '<option value=""><?php printf(__('select_client_ent_msg', 'siga-store')); ?></option>';

                $.each(sigaStoreEntidades, function (key, value) {
                    var selected = '';
                    if (value.seqEntidade == homeSelect) {
                        selected = 'selected="selected"';  
                    }

                    html_code += '<option value="' + value.seqEntidade + '" '+selected+'>' + value.nome + ' - ' + value.morada + '</option>';
                });

                $("#sel_ent").html(html_code);
                $("#sel_ent").show();
                $("#ent_lbl").hide();

            } else if (sigaStoreEntidades!=null && sigaStoreEntidades.length === 1) {

                $("#sel_ent").hide();
                $("#ent_lbl").show();
                $("#ent_lbl").html(sigaStoreEntidades[0]['nome'] + ' - ' + sigaStoreEntidades[0]['morada']);
                $('#catalog_page').show();
                $('#cart_page').show();
                $('#orders_page').show();
            }
            else {
                $("#sel_ent").hide();
                $("#ent_lbl").show();
                $("#ent_lbl").html("<?php printf(__('user_no_client_msg', 'siga-store')); ?>");
                $('#catalog_page').hide();
                $('#cart_page').hide();
                $('#orders_page').hide();
            }
        }

        updateCartBadge();
        check_btns_display('<?php echo get_option('sss_dd_select_name');?>', 'none');

        //set display button active
        $("div.btn-group button.btn").click(function () {
            $("div.btn-group").find(".active").removeClass("active");
            $(this).addClass("active");
        });

        //display buttons catalog
        $(document).on('click', '#products_cart_Change_to_List', function () {
            check_btns_display('list', 'cart');
        });

        $(document).on('click', '#products_cart_Change_to_Grid', function () {
            check_btns_display('grid', 'cart');
        });

        //display buttons cart
        $(document).on('click', '#products_catalog_Change_to_List', function () {
            check_btns_display('list', 'catalog');
        });

        $(document).on('click', '#products_catalog_Change_to_Grid', function () {
            check_btns_display('grid', 'catalog');
        });

        $('#products_catalog').html('');
        $('.pagination').html('');

        /*
        Selectbox de Categorias
        */

        $(document).on('change', '#sel1', function () {

            currentPage = 1;
            numberPages = 1;
            $('.pagination').html('');


            $('#sel2').html('');
            populate_combo02('sel2');

            $('#mySearchCod').val('');
            $('#mySearchDesig').val('');
            $('#mySearchCodBarras').val('');

            if(sigaStoreOption2Required === false) {
                ajax_call_to_table("c1");
            } else {
                setTimeout(function () {
                    stopLoader();
                }, timeout_delay)
            }
            
            check_btns_display('<?php echo get_option('sss_dd_select_name');?>', 'none');
        });

        $(document).on('change', '#sel2', function () {

            if ($(this).val() !== '') {

                currentPage = 1;
                numberPages = 1;
                $('.pagination').html('');
                $('#sel3').html('');
                populate_combo03('sel3');
                var request_call = "c12";
                if ($('#sel1 option:selected').val() == '') {
                    request_call = "c1";
                }

                $('#mySearchCod').val('');
                $('#mySearchDesig').val('');
                $('#mySearchCodBarras').val('');

                ajax_call_to_table(request_call);

                setTimeout(function () {
                    stopLoader();
                }, timeout_delay)

                check_btns_display('<?php echo get_option('sss_dd_select_name');?>', 'none');
            }

        });

        $(document).on('change', '#sel3', function () {

            if ($(this).val() !== '') {

                currentPage = 1;
                numberPages = 1;
                $('.pagination').html('');
                $('#sel4').html('');

                var request_call = "c123";
                if ($('#sel1 option:selected').val() == '') {
                    request_call = "c1";
                }

                $('#mySearchCod').val('');
                $('#mySearchDesig').val('');
                $('#mySearchCodBarras').val('');

                ajax_call_to_table(request_call);

                setTimeout(function () {
                    stopLoader();
                }, timeout_delay)

                check_btns_display('<?php echo get_option('sss_dd_select_name');?>', 'none');
            }

        });

        //--


        //reset search
        $('#reset_btn').click(function (event) {
            $('#sel1').val($(this).find('option:first').val());
            $('#sel2').empty();
            $('#products_catalog').html('');
            
            currentPage = 1;
            numberPages = 1;
            $('.pagination').html('');

            $('#mySearchCod').val('');
            $('#mySearchDesig').val('');
            $('#mySearchCodBarras').val('');

            check_btns_display('<?php echo get_option('sss_dd_select_name');?>', 'none');
        });

        //pesquisa artigos
        $('#search_btn').click(function (event) {
            event.preventDefault();

            currentPage = 1;
            numberPages = 1;

            $('#sel1 option:selected').prop('selected', false);
            $('#sel2').html('');

            var request_call = 's012';
            if ($('#mySearchCod').val() !== '' || $('#mySearchDesig').val() !== '' || $('#mySearchCodBarras').val() !== '') {

                $('#products_catalog').html('');
                $('.pagination').html('');

                ajax_call_to_table(request_call);

                check_btns_display('<?php echo get_option('sss_dd_select_name');?>', 'none');
            }else{
                toastr.warning("<?php printf(__('fill_search_msg', 'siga-store')); ?>");
            }
        });

        //encs_dates_interval actions
        $("#startdate").datepicker({
            autoclose: true,
            format: 'dd/m/yyyy',
            todayHighlight: true,
            updateViewDate: true
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#enddate').datepicker('setStartDate', minDate);
        });

        $("#enddate").datepicker({
            autoclose: true,
            format: 'dd/m/yyyy',
            todayHighlight: true,
            updateViewDate: true
        }).on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#startdate').datepicker('setEndDate', maxDate);
        });

        var date = new Date();
        var today = date.getUTCDate() + '/' + (date.getUTCMonth() + 1) + '/' + date.getFullYear();

        setTimeout(function () {
            $('#startdate').datepicker('update', today);
            $('#enddate').datepicker('update', today);
        }, 1000);

        $('#btn_get_encs').click(function () {

            var startdate_val = $("#startdate").data('datepicker').getFormattedDate('yyyymmdd');
            var enddate_val = $("#enddate").data('datepicker').getFormattedDate('yyyymmdd');

            $('#myTableOrders').hide();
            $("#myorders_list").empty();

            if ((startdate_val.length > 0 && startdate_val != null) && (enddate_val.length > 0 && enddate_val != null)) {
                if (homeSelect === null || homeSelect === "") {
                    toastr.warning("<?php printf(__('select_client_ent_msg', 'siga-store')); ?>");
                } else {
                    var html_code = '';
                    service_path = '/seam/resource/rest/jsSigaEncomendasService/getListaEncomendadosEntreDatas/';

                    $.ajax({
                        type: "GET",
                        url: req_url + service_path + req_conn + ':' + req_username + ':' + req_password + '/' + sigaStoreUsername + '/' + btoa(sigaStorePassword) + '/' + homeSelect + '?daDataEnc=' + startdate_val + '&ateDataEnc=' + enddate_val,
                        dataType: 'json',
                        headers: {
                            "Authorization": "Basic " + btoa(sigaStoreUsername + ":" + sigaStorePassword)
                        },
                        timeout: timeout_ajax,
                        beforeSend: function () {
                            startLoader();
                        },
                        success: function (data) {

                            $.each(data['encomendasListaClienteBeanRESTful']['encomendasClienteBeanRestFulLista'], function (key, value) {

                                if(value.nrEncomenda !== undefined) {

                                    	console.log(value.nrEncomenda)

                                    var nr_enc = value.nrEncomenda.split("|")[1];
                                    var enc_date = new Date(value.DEnc);
                                    var enc_desc = value.suaEncomenda;

                                    html_code += '<tr class="order_row">';
                                    html_code += '<td class="text-center"><span class="enc_data">' + get_date(enc_date) + '</span></td>';
                                    html_code += '<td class="text-center"><input class="enc_nr" type="hidden" value="' + nr_enc + '"/><span class="enc_cod">' + value.seqEncInt + '</span></td>';
                                    html_code += '<td class="text-center"><input class="enc_descricao" type="hidden" value="' + enc_desc + '"/><span class="enc_Desc">' + value.suaEncomenda + '</span></td>';
                                    html_code += '<td class="text-center"><span class="enc_status">' + value.desigSitEnc + '</span></td>';
                                    html_code += '<td class="text-center"><button type="button" class="btn btn-success show_enc" data-encnr="'+nr_enc+'"><?php printf(__('order_btn_lbl', 'siga-store')); ?></button></td>';
                                    html_code += '</tr>';
                                }
                            });

                            var id = "myorders_list";
                            if (html_code != null || html_code != '') {
                                $('#myTableOrders').show();
                            }

                            //no results
                            if (html_code == '') {
                                html_code = '<script>toastr.info("<?php printf(__('no_results_lbl', 'siga-store')); ?>");<\/script>';
                            }
                            $('#' + id).html(html_code);

                            setTimeout(function () {
                                stopLoader();
                            }, timeout_delay)
                        },
                        error: function(jqXHR,error, errorThrown) {
                            stopLoader();
                            if(jqXHR.status&&jqXHR.status==400){
                                toastr.error(jqXHR.responseText);
                            }else{
                                console.log("Something went wrong");
                            }
                        }
                    });
                }
            } else {
                toastr.warning("<?php printf(__('fill_two_dates_lbl', 'siga-store')); ?>");
            }
        });

        //clear cookies leaving doc to another page
        $("#logout").click(function () {
            localStorage.removeItem("siga_store_session");
            localStorage.removeItem("siga_store_username");
            localStorage.removeItem("siga_store_password");
            localStorage.removeItem("siga_store_entidades");
            localStorage.removeItem("home_select");

            $("#welcome_title").html("");
            $("span.badge-default").html("0");
            $("#products_cart").empty();

            location.reload();
        });

        function get_date(date) {
            var year = date.getFullYear();
            var month = date.getMonth() + 1;
            var day = date.getDate();

            if (day < 10) {
                day = '0' + day;
            }
            if (month < 10) {
                month = '0' + month;
            }

            return year + '-' + month + '-' + day;
        }

        function populate_combo01(id) {
            var combo2_v = '<?php echo get_option('sss_prod_order_02'); ?>';

            if (combo2_v.length === 0) {
                $('#sel2').hide();
            }

            if (homeSelect === null || homeSelect === "") {

                toastr.warning("<?php printf(__('select_client_ent_msg', 'siga-store')); ?>");
            } else {

                var html_code = '';
                service_path = '/seam/resource/rest/jsStoreRestFulService/obterDadosCombo1/';

                $.ajax({
                    type: "GET",
                    url: req_url + service_path + req_conn + ':' + req_username + ':' + req_password + '/' + combo01 + '?',
                    dataType: 'json',
                    headers: {
                        "Authorization": "Basic " + btoa(sigaStoreUsername + ":" + sigaStorePassword)
                    },
                    timeout: timeout_ajax,
                    beforeSend: function () {
                        startLoader();
                    },
                    success: function (data) {
                        html_code += '<option value=""><?php printf(__('select_option_msg', 'siga-store')); ?></option>';
                        $.each(data['jsStoreQueryCombosBeanRESTful']['listaCombo1'], function (key, value) {
                            var arr01 = [];
                            if (ocultar01.length>0) {
                                arr01 = ocultar01.split(',');
                            }

                            if (id === 'sel1' && arr01.includes(value.codigo) === false) {
                                html_code += '<option value="' + value.codigo + '">' + value.designacao + '</option>';
                            }
                        });
                        $('#' + id).html(html_code);

                        setTimeout(function () {
                            stopLoader();
                        }, timeout_delay)
                    },
                    error: function(jqXHR,error, errorThrown) {
                        stopLoader();
                        if(jqXHR.status&&jqXHR.status==400){
                            toastr.error(jqXHR.responseText);
                        }else{
                            console.log("Something went wrong");
                        }
                    }
                });

            }
        }

        function populate_combo02(id) {
            var combo01_val = $('#sel1 option:selected').val();

            if (homeSelect === null || homeSelect === "") {
                toastr.warning("<?php printf(__('select_client_ent_msg', 'siga-store')); ?>");
            } else {

                var html_code = '';
                service_path = '/seam/resource/rest/jsStoreRestFulService/obterDadosCombo2/';

                $.ajax({
                    type: "POST",
                    url: req_url + service_path + req_conn + ':' + req_username + ':' + req_password + '/?pesquisarArtigos=false',
                    contentType: "application/json",
                    headers: {
                        "Authorization": "Basic " + btoa(sigaStoreUsername + ":" + sigaStorePassword)
                    },
                    timeout: timeout_ajax,
                    data: JSON.stringify({
                        'jsStoreQueryArtigoBeanRESTful': {
                            'seqEntidade': homeSelect,
                            'combo1': combo01,
                            'comboValor1': combo01_val,
                            'combo2': combo02
                        }
                    }),
                    beforeSend: function () {
                        startLoader();
                    },
                    success: function (data1) {

                        html_code += '<option value=""><?php printf(__('select_option_msg', 'siga-store')); ?></option>';

                        $.each(data1['jsStoreQueryCombosBeanRESTful']['listaCombo2'], function (key, value) {
                            var arr02 = [];
                            if (ocultar02.length>0) {
                                arr02 = ocultar02.split(',');
                            }
                            if (id === 'sel2' && arr02.includes(value.codigo) === false) {
                                var elem_value = value.codigo;
                                if ( value.codigo === '' ) {
                                    elem_value = 'NI';
                                }
                                html_code += '<option value="' + elem_value + '">' + value.designacao + '</option>';
                            }
                        });

                        $('#' + id).html(html_code);
                    },
                    error: function(jqXHR,error, errorThrown) {
                        if(jqXHR.status&&jqXHR.status==400){
                            toastr.error(jqXHR.responseText);
                        }else{
                            console.log("Something went wrong");
                        }
                    }
                });
            }
        }

        function populate_combo03(id) {
            var combo01_val = $('#sel1 option:selected').val();
            var combo02_val = $('#sel2 option:selected').val();

            if (homeSelect === null || homeSelect === "") {
                toastr.warning("<?php printf(__('select_client_ent_msg', 'siga-store')); ?>");
            } else {

                var html_code = '';
                service_path = '/seam/resource/rest/jsStoreRestFulService/obterDadosCombo3/';

                $.ajax({
                    type: "POST",
                    url: req_url + service_path + req_conn + ':' + req_username + ':' + req_password + '/',
                    contentType: "application/json",
                    headers: {
                        "Authorization": "Basic " + btoa(sigaStoreUsername + ":" + sigaStorePassword)
                    },
                    timeout: timeout_ajax,
                    data: JSON.stringify({
                        'jsStoreQueryArtigoBeanRESTful': {
                            'seqEntidade': homeSelect,
                            'combo1': combo01,
                            'comboValor1': combo01_val,
                            'combo2': combo02,
                            'comboValor2': combo02_val,
                            'combo3': combo03
                        }
                    }),
                    beforeSend: function () {
                        startLoader();
                    },
                    success: function (data1) {
                        html_code += '<option value=""><?php printf(__('select_option_msg', 'siga-store')); ?></option>';

                        $.each(data1['jsStoreQueryCombosBeanRESTful']['listaCombo3'], function (key, value) {
                             
                            var arr03 = [];
                            if (ocultar03.length>0) {
                                arr03 = ocultar03.split(',');
                            }
                            
                            if (id === 'sel3' && arr03.includes(value.codigo) === false ) { 
                                var elem_value = value.codigo;
                                if ( value.codigo === '' ) {
                                    elem_value = 'NI';
                                }
                                html_code += '<option value="' + elem_value + '">' + value.designacao + '</option>';
                            }
                        });

                        $('#' + id).html(html_code);
                    },
                    error: function(jqXHR,error, errorThrown) {
                        if(jqXHR.status&&jqXHR.status==400){
                            toastr.error(jqXHR.responseText);
                        }else{
                            console.log("Something went wrong");
                        }
                    }
                });
            }
        }

        function check_settings_display() {
            var display_status = '<?php echo get_option('sss_dd_select_name');?>';
            var display_class = '';

            if (display_status == 'list') {
                display_class = 'list-group-item';
            } else if (display_status == 'grid') {
                display_class = 'grid-group-item';
            }

            return display_class;
        }

        function check_btns_display(btn_current_status, tab_menu) {

            if (btn_current_status == 'list' || btn_current_status == '') {
                $("div.btn-group").find(".active").removeClass("active");
                if (tab_menu == 'catalog' || tab_menu == 'none') {
                    $("#products_catalog_Change_to_List").addClass("active");
                    $('#products_catalog .item').removeClass('grid-group-item');
                    $('#products_catalog .item').addClass('list-group-item');
                }

                if (tab_menu == 'cart' || tab_menu == 'none') {
                    $("#products_cart_Change_to_List").addClass("active");
                    $('#products_cart .item').removeClass('grid-group-item');
                    $('#products_cart .item').addClass('list-group-item');
                }

            } else if (btn_current_status == 'grid') {
                $("div.btn-group").find(".active").removeClass("active");

                if (tab_menu == 'catalog' || tab_menu == 'none') {
                    $("#products_catalog_Change_to_Grid").addClass("active");
                    $('#products_catalog .item').removeClass('list-group-item');
                    $('#products_catalog .item').addClass('grid-group-item');
                }
                if (tab_menu == 'cart' || tab_menu == 'none') {
                    $("#products_cart_Change_to_Grid").addClass("active");
                    $('#products_cart .item').removeClass('list-group-item');
                    $('#products_cart .item').addClass('grid-group-item');
                }
            }
        }

        function loadMoreProducts() {
            var request_call = "s0";
            if ($('#mySearchCod').val() !== '' || $('#mySearchDesig').val() !== '' || $('#mySearchCodBarras').val() !== '') {
                if ($('#sel1 option:selected').val() !== '' && $('#sel2 option:selected').val() !== ''){
                    request_call = 's012';
                }else if ($('#sel1 option:selected').val() !== '') {
                    //pesquisa com combo1 value
                    request_call = 's01';
                }else if ($('#sel1 option:selected').val() === '') {
                    request_call = 's0';
                }
            }else{
                if ($('#sel1 option:selected').val() !== '' && $('#sel2 option:selected').val() !== '') {
                    //pesquisa com combo1 value
                    request_call = 'c12';
                }else if ($('#sel1 option:selected').val() !== '') {
                    request_call = 'c1';
                }
            }
            ajax_call_to_table(request_call);
        }

        var currentPage = 1;
        var numberPages = 1;

        function makePagination() {

            $('.pagination').html('<div style="padding: 0;float: left;margin-right: 5px;">'+
                '<div class="btn-group" role="group" aria-label="...">'+
                    '<button type="button" class="btn btn-primary pagination-first"><span aria-hidden="true">&larr;</span> <?php printf(__('pagination_first', 'siga-store')); ?></button>'+
                    '<button type="button" class="btn btn-info pagination-less"><span aria-hidden="true">&lt;</span></button>'+
                '</div>'+
            '</div>'+
            '<div style="padding: 0;float: left; margin: 0 5px;">'+
                '<div  style="padding: 0;float: left; margin-right: 5px; min-width: 60px;">'+
                    '<select name="" id="" class="form-control pagination-select"></select>'+
                '</div>'+
                '<div style="padding: 0;float: left; margin-right: 5px; line-height: 35px; font-weight: 800;" class="pagination-registos"> <?php printf(__('pagination_number_legend', 'siga-store')); ?> '+numberPages+'</div>'+
            '</div>'+
            '<div style="padding: 0;float: left;margin-left: 5px;">'+
                '<div class="btn-group" role="group" aria-label="...">'+
                    '<button type="button" class="btn btn-info pagination-more"><span aria-hidden="true">&gt;</span></button>'+
                    '<button type="button" class="btn btn-primary pagination-last"><?php printf(__('pagination_last', 'siga-store')); ?> <span aria-hidden="true">&rarr;</span></button>'+
                '</div>'+
            '</div>');

            var listPages = '';
            for (var i = 1; i <= numberPages; i++) {
                listPages = listPages + '<option value="'+i+'">' + i + '</option>';
            }

            $('.pagination-select').html(listPages);
            $('.pagination-select option[value="'+currentPage+'"]').attr('selected', 'selected');

            if (currentPage === 1) {
                $('.pagination-less').prop('disabled', true);
                $('.pagination-first').prop('disabled', true);
            } else {
                $('.pagination-less').prop('disabled', false);
                $('.pagination-first').prop('disabled', false);
            }

            if (currentPage === numberPages) {
                $('.pagination-more').prop('disabled', true);
                $('.pagination-last').prop('disabled', true);
            } else {
                $('.pagination-more').prop('disabled', false);
                $('.pagination-last').prop('disabled', false);
            }
        }

        /*
            Paginação de Artigos
        */

        $(document).on('change', '.pagination-select', function () {
            startLoader();
            currentPage = $(this).val();

            loadMoreProducts();
        });

        $(document).on('click', '.pagination-less', function () {
            startLoader();
            if (currentPage > 1) {
                currentPage--;
            }
    
            loadMoreProducts();
        });

        $(document).on('click', '.pagination-more', function () {
            startLoader();
            if (currentPage < numberPages) {
                currentPage++;
            }

            loadMoreProducts();
        });

        $(document).on('click', '.pagination-first', function () {
            startLoader();
            currentPage = 0;

            loadMoreProducts();
        });

        $(document).on('click', '.pagination-last', function () {
            startLoader();
            currentPage = numberPages;

            loadMoreProducts();
        });

        //--

        /*
            Pesquisa de Artigos
        */

        var catalogProducts = null;
        function ajax_call_to_table(request_call) {

            catalogProducts = null;

            $('#products_catalog').html('');
            $('.pagination').html('');

            <?php
            $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
            $fileDir = $actual_link . get_option('sss_images_path');
            ?>

            if (homeSelect === null || homeSelect === "") {
                toastr.warning("<?php printf(__('select_client_ent_msg', 'siga-store')); ?>");
            } else {

                service_path = '/seam/resource/rest/jsStoreRestFulService/obterArtigosPorCombos/';

                var combo01_val = $('#sel1 option:selected').val();
                var combo02_val = $('#sel2 option:selected').val();
                var combo03_val = $('#sel3 option:selected').val();
                
                /*$armazemint = (int)$sigaStockArm;
                echo $armazemint*/

               
              /* var x=0;
                    sigaStockArm == "99" ? x=99 : console.log("erro na conversão")
                    sigaStockArm = x;
                    console.log(sigaStockArm)
                    console.log(typeof sigaStockArm)
*/
                //sigaStockArm == 99 ? console.log('sim') : console.log('nao');

                //console.log(typeof sigaStockArm)
                //console.log(sigaStockArm)


               var confirmaStockArm = sigaStockArm === null? false: true;
               //console.log(confirmaStockArm)


                var cod_art = $('#mySearchCod').val();
                var desig_art = $('#mySearchDesig').val();
                var cod_barras = $('#mySearchCodBarras').val();

                var pager = currentPage;
                if (pager < 1) {
                    pager = 1;
                }
                if (pager > numberPages){
                    pager = numberPages;
                }

                var jsonValue = {
                    jsStoreQueryArtigoBeanRESTful: {
                        seqEntidade: homeSelect,
                        nrRegistosPag: nrRegistosPag,
                        firstResult: (pager-1) * nrRegistosPag,
                        obterSoDisponiveis: confirmaStockArm,
                        codArmazem : sigaStockArm
                    }
                };

                if (sigaStoreOption2Required === false && request_call == 'c1') {
                    //combo1-no search
                    jsonValue.jsStoreQueryArtigoBeanRESTful.combo1 = combo01;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.comboValor1 = combo01_val;
                } else if (request_call == 'c12') {
                    //combo1+combo2-no search
                    jsonValue.jsStoreQueryArtigoBeanRESTful.combo1 = combo01;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.comboValor1 = combo01_val;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.combo2 = combo02;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.comboValor2 = combo02_val;
                } else if (request_call == 'c123') {
                    //combo1+combo2-no search
                    jsonValue.jsStoreQueryArtigoBeanRESTful.combo1 = combo01;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.comboValor1 = combo01_val;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.combo2 = combo02;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.comboValor2 = combo02_val;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.combo3 = combo03;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.comboValor3 = combo03_val;
                } else if (request_call == 's0') {
                    //search with no combos
                    jsonValue.jsStoreQueryArtigoBeanRESTful.codArtigo = cod_art;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.designArtigo = desig_art;
                } else if (request_call == 's01') {
                    //search with combo1
                    jsonValue.jsStoreQueryArtigoBeanRESTful.combo1 = combo01;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.comboValor1 = combo01_val;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.codArtigo = cod_art;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.designArtigo = desig_art;

                } else if (request_call == 's012') {
                    //search with combo1+combo2
                    jsonValue.jsStoreQueryArtigoBeanRESTful.combo1 = combo01;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.comboValor1 = combo01_val;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.combo2 = combo02;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.comboValor2 = combo02_val;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.codArtigo = cod_art;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.designArtigo = desig_art;
                }

                if((request_call == 's0' || request_call == 's01' || request_call == 's012') && cod_barras != '' && sigaStoreTipoCBarras !== null){

                    //search with barcode type
                    jsonValue.jsStoreQueryArtigoBeanRESTful.codBarras = cod_barras;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.tipoCBarras = sigaStoreTipoCBarras;
                }

                if (combo02_val === 'NI'){
                    jsonValue.jsStoreQueryArtigoBeanRESTful.comboValor2 = '';
                }

                if(ocultar01 !== '' || ocultar01 !== null){
                    jsonValue.jsStoreQueryArtigoBeanRESTful.combo1 = combo01;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.listaCombo1Exclusao=ocultar01;
                }
                if(ocultar02 !== '' || ocultar02 !== null){
                    jsonValue.jsStoreQueryArtigoBeanRESTful.listaCombo2Exclusao=ocultar02;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.combo2 = combo02;
                }

                if(ocultar03 !== '' || ocultar03 !== null){
                    jsonValue.jsStoreQueryArtigoBeanRESTful.listaCombo3Exclusao=ocultar03;
                    jsonValue.jsStoreQueryArtigoBeanRESTful.combo3 = combo03;
                }

                // Obter historico
                jsonValue.jsStoreQueryArtigoBeanRESTful.obterHistorico = $('input[name=historicoOp]:checked').val()

                var list_html = '';
                $.ajax({
                    type: "POST",
                    url: req_url + service_path + req_conn + ':' + req_username + ':' + req_password,
                    contentType: "application/json",
                    headers: {
                        "Authorization": "Basic " + btoa(sigaStoreUsername + ":" + sigaStorePassword)
                    },
                    timeout: timeout_ajax,
                    data: JSON.stringify(jsonValue),
                    beforeSend: function () {
                        startLoader();
                    },
                    success: function (data) {
                      
                        var json_obj = data;

                        if (json_obj['jsStoreDadosArtigosBeanRESTful']['nrTotalRegistos'] === 0 || json_obj['jsStoreDadosArtigosBeanRESTful']['nrTotalRegistos'] === undefined ){
                            toastr.info('<?php printf(__('no_results_lbl', 'siga-store')); ?>');
                            $("#products_catalog").html('');
                        } else {
                            numberPages = Math.ceil( json_obj['jsStoreDadosArtigosBeanRESTful']['nrTotalRegistos'] / nrRegistosPag);
                            makePagination();
                        }

                        catalogProducts = json_obj['jsStoreDadosArtigosBeanRESTful']['jsArtigosBeanRestFuls'];
                        $.each(json_obj['jsStoreDadosArtigosBeanRESTful']['jsArtigosBeanRestFuls'], function (key, value) {

                            var imgThumb = '';
                            var imgBig = '';
                            var html_imagem = '';
                            var listaRefImg = new Array();
                            var descImgRef = ""

                    
                            var isHistorico = '';
                            if (value.historico === true) {
                                isHistorico = '<div class="product-historico" style="position: absolute;margin-top: 5px;"><span><i class="fa fa-heart" data-toggle="tooltip" title="<?php printf(__('product_already_buyed', 'siga-store')); ?>"></i></span></div>';
                            }

                            if(value.listaImagensWeb == null){
                                if (value.imagemMedia != null) {
                                    imgThumb = '<?php echo $fileDir;?>' + value.imagemMedia;
                                } else {
                                    imgThumb = '<?php echo plugin_dir_url(__FILE__);?>default_MEDIA.jpg';
                                }

                                if (value.imagemGrande != null) {
                                    imgBig = '<?php echo $fileDir;?>' + value.imagemGrande;
                                } else {
                                    imgBig = '<?php echo plugin_dir_url(__FILE__);?>default_BIG.jpg';
                                }

                                html_imagem = '<input type="hidden" name="path_pic" value="' + imgBig + '" class="ct_img_big" >' +
                                                 isHistorico +
                                            '<div class="img_container">'+
                                                '<img class="group list-group-image img-thumbnail thumb_pic_box_cat ct_img" src="' + imgThumb + '" alt="" data-product-id="' + value.CArtigo + '" />'+
                                            '</div>';
                            } else{
                                var listaImagens = value.listaImagensWeb;

                                html_img_big='';
                                html_img_thumb='';

                                $.each(listaImagens, function(key, imagem){
                                    if (imagem.imagemMedia != null) {
                                        imgThumb = '<?php echo $fileDir;?>' + imagem.imagemMedia;
                                    } else {
                                        imgThumb = '<?php echo plugin_dir_url(__FILE__);?>default_MEDIA.jpg';
                                    }

                                    if (imagem.imagemGrande != null) {
                                        imgBig = '<?php echo $fileDir;?>' + imagem.imagemGrande;
                                    } else {
                                        imgBig = '<?php echo plugin_dir_url(__FILE__);?>default_BIG.jpg';
                                    }

                                    if(key===0){
                                        descImgRef = imagem.designacaoImagem;
                                        html_img_big += '<input type="hidden" name="path_pic" value="' + imgBig + '" class="ct_img_big" data-key="' + key + '">'
                                        html_img_thumb += '<img class="group list-group-image img-thumbnail thumb_pic_box_cat ct_img slideImg" descImgRef="' + (imagem.designacaoImagem != null ? imagem.designacaoImagem : '' ) + '" src="' + imgThumb + '" data-key="' + key +'" alt="" data-product-id="' + value.CArtigo + '" />'
                                    } else{
                                        html_img_big += '<input type="hidden" name="path_pic" value="' + imgBig + '" class="ct_img_big" data-key="' + key + '">'
                                        html_img_thumb += '<img class="group list-group-image img-thumbnail thumb_pic_box_cat ct_img slideImg scrollHide" descImgRef="' + (imagem.designacaoImagem != null ? imagem.designacaoImagem :'' )  + '" src="' + imgThumb + '" data-key="' + key +'" alt="" data-product-id="' + value.CArtigo + '" />'
                                    }
                                
                                    if(imagem.designacaoImagem != null && imagem.designacaoImagem != ""){
                                        if(listaRefImg.length == 0){
                                            listaRefImg.push(imagem.designacaoImagem)
                                        } else{
                                            let existe = false;
                                            listaRefImg.forEach((ref, index) => {
                                                if(!existe){
                                                    if(imagem.designacaoImagem == ref){
                                                        existe = true;
                                                    }
                                                }
                                            })
                                            if(!existe){
                                                listaRefImg.push(imagem.designacaoImagem)
                                            }
                                        }

                                    }
                                    
                                });


                                html_imagem = html_img_big +
                                                 isHistorico +
                                        
                                            '<div style="text-align:center; font-weight: bold" class="imageRef" artid="' + value.CArtigo+ '">' + (descImgRef == null? '': descImgRef) + '</div>'+
                            
                                            '<div class="imageScrollerContent">'+
                                                '<div class="imageScrollerItem">'+
                                                    '<button id="buttonPrev" artid="'+value.CArtigo+'" type="button">&larr;</button>'+
                                                '</div>'+
                                                '<div class="imageScrollerItem artigoImg" artid="' + value.CArtigo + '">'+
                                                html_img_thumb+
                                                '</div>'+
                                                '<div class="imageScrollerItem">'+
                                                    '<button id="buttonNext" artid="'+value.CArtigo+'" type="button" >&rarr;</button>'+
                                                '</div>'+
                                            '</div>';
                            }
                            
                            var price_cat = '';
                            var desconto = '';
                            var price_cat_liq = '';

                            var hide_price_status = '';
                            if (value.precoDefault.preco != undefined) {
                                price_cat = value.precoDefault.preco;
                                desconto = value.precoDefault.percDesconto;
                                price_cat_liq = value.precoDefault.precoComDesconto;

                            } else {
                                price_cat = "0.00";
                                hide_price_status = 'disabled';
                            }

                            var display_class = check_settings_display();

                            var price_desc = '';
                            var price_value = price_cat_liq;
                            var price_label = '';

                            var coin_lbl='';
                            if(price_value!=''){coin_lbl='€';}

                            if (desconto != null && price_cat_liq != null) {
                                price_desc = '<span class="ct_price ct_price_sem_desconto" data-value="' + price_cat + '" style="line-height: 0px;font-size: 28px;padding-top: 15px;float: left;">'+ coin_lbl + price_cat + '</span>'+
                                             '<span class="label label-danger ct_desconto" data-value="' + desconto + '" style="padding: 8px;float:left;margin-right: 5px;">' + desconto + '%</span>';
                                price_label = 'ct_preco_liq';
                            } else {
                                price_value = price_cat;
                                price_label = 'ct_price';
                            }

                            var price_html = '<div class="row" >' +
                                '<div class="col-md-12" style="padding-top: 10px; padding-bottom: 10px; min-height: 47px;">' +
                                    price_desc + '<span data-value="' + price_value + '" class="price_s price-unit-' + value.CArtigo + ' ' + price_label + '" style="font-weight: 800;line-height: 0px;font-size: 28px;padding-top: 15px;float: left;">' + coin_lbl + price_value + '</span>' +
                                '</div>' +
                                '<div class="col-md-12" style="visibility: hidden; padding-bottom: 5px;padding-top: 5px;font-weight: 800;min-height: 40px;">' +
                                	'<span class="price_s result-value-' + value.CArtigo + '" ></span>' +
                                '</div>' +
                            '</div>';

                            var productButton = '<button type="button" class="btn btn-primary btn-block btn-sm add-click ' + hide_price_status + '" data-product-id="' + value.CArtigo + '"><?php printf(__('add_cart_lbl', 'siga-store')); ?></button>';
                            var productQuantity = qtd_caixa;
                            var addedProductBackground = '';
                            var productCart = searchCartItemById(value.CArtigo);
                            var selectLote = null;
                            var selectRefImg =null;


                            if ( productCart !== null ) { // product in cart
                                addedProductBackground = 'style="background-color: #ddd;"';
                                productQuantity = productCart.qtd;
                                //productButton = '<button type="button" class="btn btn-info btn-block btn-sm update-click" data-product-id="' + value.CArtigo + '"><?php printf(__('update_product', 'siga-store')); ?></button>';
                            }


                            if(value.listaStkLotes != null){
                                selectLote = '<select id="lotesSel-' + value.CArtigo +'">'
                                $.each(value.listaStkLotes, function (key, valor) {
                                    selectLote += '<option id="lote-' + key +'-' + value.CArtigo + '" value="' + valor.CLoteInt + '%' + valor.CLote +'">' + valor.CLote+'</option>';
                                });
                                selectLote +='</select>';
                            } 

                            else if(listaRefImg.length != 0){
                                selectRefImg = '<select id="refSel-' + value.CArtigo +'">'
                                $.each(listaRefImg, function (key, valor) {
                                    selectRefImg += '<option id="refImg-' + key +'-' + value.CArtigo + '" value="' + valor +'">' + valor +'</option>';
                                });
                                selectRefImg +='</select>';
                            }
                            
                            var qtd_caixa= value.quantidadePorCaixa;
                            var desi_comer = (value.desigComer === null ? value.desigCArtigo : value.desigComer);
                            var desi_tec= value.designacaoTecnica;

                            

                            list_html = list_html +'<div class="item col-xs-12 col-sm-6 col-md-6 col-lg-4 row_number ' + display_class + '">' +
                            '<div class="thumbnail product-item-' + value.CArtigo + '" '+addedProductBackground+'>'+
                                html_imagem +
                                '<div class="caption">'+
                                    '<h3 class="group inner list-group-item-heading" style="margin-bottom: 0;">'+
                                        '<span class="ct_id"><b>Código: </b>' + value.CArtigo + '</span><br/>'+
                                        '<span class="cBarras"><b>EAN: </b>' + value.CBarras + '</span>' + 
                                        (value.CExterno != null? ' / <span class="cExterno">' + value.CExterno + '</span>':'') +  
                                        '<br>' +
                                        '<span class="qtd_caixa"><b>Quantidade por caixa: </b>' + qtd_caixa +'</span>' + 
                                        '<br>' +
                                       /*'<span>Observações: </span>' +
                                        '<input type="text1" id="teste"  >' +*/
                                    '</h3>'+

                                    '<div class="designacoes"> '+
                                        '<span class="desi_comer"><b>Designação comercial </b>' + desi_comer + '</span>' +
                                        '<span class="desi_tec"><b>Designação Técnica </b>' + desi_tec + '</span>' +
                                    '</div>'+
                                        '<p><span class="ct_name">' + value.desigCArtigo + '</span>'+
                                    '</p>' + price_html + 
                                    '<input type="hidden" name="uni_med" class="ct_uni" value="' + value.cUniMed + '">'+
                                    '<div class="row">'+
                                        '<div class="col-md-4 col-xs-12 col-sm-4">' +
                                            '<input type="number" class="form-control math_cell cell_val_input upVal ct_qtd" value="'+ qtd_caixa +'" placeholder="'+qtd_caixa+'" data-product-id="' + value.CArtigo + '" min="'+qtd_caixa+'" maxlength="11" id="qtd_' + value.CArtigo + '" ' + hide_price_status + 'step='+qtd_caixa+' >'+
                                        '</div>' +
                                        '<div class="col-md-8 col-xs-12 col-sm-8">' +
                                        (selectLote != null? selectLote : ' ') +
                                        (selectRefImg != null? selectRefImg : ' ')+
                                        '</div>' +
                                    '</div>'+
                                    '<br/><div class="row">'+
                                        '<div class="col-md-12 col-xs-12 col-sm-12 product-cart-' + value.CArtigo + '">' +
                                            productButton +
                                        '</div>' +
                                    '</div>'+
                                '</div>'+
                            '</div></div>';
                        });

                        $("#products_catalog").html(list_html);
                        $('[data-toggle="tooltip"]').tooltip();

                        setTimeout(function() {
                            stopLoader();
                        }, timeout_delay)
                    },
                    error: function(jqXHR,error, errorThrown) {
                        stopLoader();
                        if(jqXHR.status&&jqXHR.status==400){
                            toastr.error(jqXHR.responseText);
                        }else{
                            console.log("Something went wrong");
                        }
                    }
                });

            }
        }

        //show modal
        $(document).on('click', '.thumb_pic_box_cat', function (event) {

            var productId = $(this).data('product-id');
            
            var refImgDescricao = $(this)[0].getAttribute("descImgRef");
            var refImgKey = parseInt($(this)[0].getAttribute("data-key"));


            

            var objProduct = null;
            $.each(catalogProducts, function (key, value) {
                if (productId == value.CArtigo) {
                    objProduct = {
                        codArtigo: value.CArtigo,
                        price: value.precoDefault.preco,
                        desigArtigo: value.desigCArtigo,
                        imagemMedia: value.imagemMedia,
                        imagemGrande: value.imagemGrande,
                        imagemThumb: value.imagemThumb,
                        uni_med: value.cUniMed,
                        percDesc: value.precoDefault.percDesconto,
                        preco_liq: value.precoDefault.precoComDesconto,
                        codBarras: null,
                        valor: null,
                        listaImagens: value.listaImagensWeb,
                        qtd_caixa: value.quantidadePorCaixa,
                        desi_comer: (value.desigComer === null? value.desigCArtigo: value.desigComer),
                        desi_tec: value.designacaoTecnica
                        
                        
                        //obs :value.observ
                    };
                }
            });

            if(objProduct.listaImagens != null && refImgKey != 0){
                $.each(objProduct.listaImagens, function(key, img){
                
                    if(img.designacaoImagem == refImgDescricao){
                        if(img.imagemMedia.includes("MEDIA"+refImgKey)){
                            objProduct.imagemMedia = img.imagemMedia;
                            objProduct.imagemGrande = img.imagemGrande;
                            objProduct.imagemThumb= img.imagemThumb;
                        }
                    }
                });
            }

            if (objProduct !== null) {

                // adicionar cod barras ao objecto
                $.ajax({
                    type: "GET",
                    url: req_url + '/seam/resource/rest/jsArtigosRestFulService/getRelArtTipoCbarrasBYCArtigo/' + req_conn + ':' + req_username + ':' + req_password + '/' + sigaStoreUsername + '/' + btoa(sigaStorePassword) + '/' + productId + '/' + sigaStoreTipoCBarras,
                    headers: {
                        "Authorization": "Basic " + btoa(sigaStoreUsername + ":" + sigaStorePassword)
                    },
                    timeout: timeout_ajax
                }).done(function (data) {

                    $('#myModal_cat').find('#desi_comer').html(objProduct.desi_comer);
                    $('#myModal_cat').find('#desi_tec').html(objProduct.desi_tec);
                    $('#myModal_cat').find('#qtd_caixa').html(objProduct.qtd_caixa);
                    $('#myModal_cat').find('#myModalLabelProd').html(objProduct.codArtigo + " - " + objProduct.desigArtigo);
                    $('#myModal_cat').find('img').attr('src', '<?php echo $fileDir;?>' + objProduct.imagemGrande);

                    var price_cat = '';
                    var desconto = '';
                    var price_cat_liq = '';

                    if (objProduct.price != undefined) {
                        price_cat = objProduct.price;
                        desconto = objProduct.percDesc;
                        price_cat_liq = objProduct.preco_liq;

                    } else {
                        price_cat = "0.00";
                    }

                    var price_desc = '';
                    var price_value = price_cat_liq;
                    var price_label = '';

                    
                    /*var designacao_comercial='';
                            if(value.desigComer!==undefined){
                                designacao_comercial='Designação Comercial=[' + value.desigComer + ']';
                            }

                            var designaca_tecnica='';
                            if(value.designacaoTecnica!==undefined){
                                designacao_comercial='Designação Técnica=['+ value.designacaoTenica + ']';
                            }
                    */


                    var coin_lbl='';
                    if(price_value!=''){coin_lbl='€';}

                    if (desconto != null && price_cat_liq != null) {
                        price_desc = '<div class="col-md-5 text-right ct_price ct_price_sem_desconto" data-value="' + price_cat + '" style="font-size: 28px; padding: 0;">'+ coin_lbl + price_cat + '</div>'+
                            '<div class="col-md-3 text-center" style="padding-top: 10px; display: inline-grid;"><span class="label label-danger ct_desconto" data-value="' + desconto + '" style="padding: 8px;">' + desconto + '%</span></div>';
                        price_label = 'ct_preco_liq';
                    } else {
                        price_value = price_cat;
                        price_label = 'ct_price';
                    }


                    var price_html = '<div class="col-md-12 text-center" style="padding-top: 10px; padding-bottom: 10px; min-height: 47px;"><div class="col-md-4"></div><div class="col-md-4">' +
                        price_desc + '<div data-value="' + price_value + '" class="col-md-4 text-left price-unit-' + objProduct.codArtigo + ' ' + price_label + '" style="font-weight: 800;font-size: 28px; padding: 0;">' + coin_lbl + price_value + '</div>' +
                        '</div>' +
                        '<div class="col-md-12" style="visibility: hidden; padding-bottom: 5px;padding-top: 5px;font-weight: 800;min-height: 40px;">' +
                        '<span class="price_s result-value-' + objProduct.codArtigo + '" ></span>' +
                        '</div></div><div class="col-md-4"></div>';

                    $('#myModal_cat .modal-dialog .modal-content .modal-footer').html('<div class="col-md-12 text-center qtd_caixa"><b>Quantidade por Caixa = </b>' + objProduct.qtd_caixa + '</div>' 
                    + ((objProduct.desi_comer === null || objProduct.desi_comer === 'null') ? ' ': '<div class="col-md-12 text-center desi_comer"><b>Designação Comercial: </b>' + objProduct.desi_comer ) 
                    + '</div>' + (objProduct.desi_tec  == null? ''  :'<div class="col-md-12 text-center desi_tec"><b>Designação Técnica: </b>' + objProduct.desi_tec )+ '</div>' + price_html);
                    $('#myModal_cat').modal('show');
                    console.log(objProduct.desi_comer, objProduct.desi_tec)

                }).fail(function (jqXHR, textStatus) {

                    if (jqXHR.status == 200) {

                        $('#myModal_cat').find('#desi_comer').html(objProduct.desi_comer);
                        $('#myModal_cat').find('#desi_tec').html(objProduct.desi_tec);
                        $('#myModal_cat').find('#qtd_caixa').html(objProduct.qtd_caixa);
                        $('#myModal_cat').find('#myModalLabelProd').html(objProduct.codArtigo + " - " + objProduct.desigArtigo);
                        $('#myModal_cat').find('img').attr('src', '<?php echo $fileDir;?>' + objProduct.imagemGrande);

                        var price_cat = '';
                        var desconto = '';
                        var price_cat_liq = '';

                        if (objProduct.price != undefined) {
                            price_cat = objProduct.price;
                            desconto = objProduct.percDesc;
                            price_cat_liq = objProduct.preco_liq;

                        } else {
                            price_cat = "0.00";
                        }

                        var price_desc = '';
                        var price_value = price_cat_liq;
                        var price_label = '';

                        var coin_lbl='';
                        if(price_value!=''){coin_lbl='€';}

                        if (desconto != null && price_cat_liq != null) {
                            price_desc = '<span class="ct_price ct_price_sem_desconto" data-value="' + price_cat + '" style="line-height: 0px;font-size: 28px;padding-top: 15px;float: left;">'+ coin_lbl + price_cat + '</span>'+
                                '<span class="label label-danger ct_desconto" data-value="' + desconto + '" style="padding: 8px;float:left;margin-right: 5px;">' + desconto + '%</span>';
                            price_label = 'ct_preco_liq';
                        } else {
                            price_value = price_cat;
                            price_label = 'ct_price';
                        }

                        var price_html = '<div class="col-md-12" style="padding-top: 10px; padding-bottom: 10px; min-height: 47px;">' +
                            price_desc + '<span data-value="' + price_value + '" class="price-unit-' + objProduct.codArtigo + ' ' + price_label + '" style="font-weight: 800;line-height: 0px;font-size: 28px;padding-top: 15px;float: left;">' + coin_lbl + price_value + '</span>' +
                            '</div>' +
                            '<div class="col-md-12" style="visibility: hidden; padding-bottom: 5px;padding-top: 5px;font-weight: 800;min-height: 40px;">' +
                            '<span class="price_s result-value-' + objProduct.codArtigo + '" ></span>' +
                            '</div>';
                        $('#myModal_cat .modal-dialog .modal-content .modal-footer').html('<div class="col-md-12">Quantidade por Caixa = ' + objProduct.qtd_caixa + '</div>' + price_html);
                        $('#myModal_cat').modal('show');
                    }
                });
            }



        });

        $(document).on('click', '.thumb_pic_box_enc', function (event) {
            var row_prod_cod = $(this).parents('.item').find("div").find(".ct_id").text();
            var row_prod_name = $(this).parents('.item').find("div").find(".ct_name").text();
            

            $('#myModal_enc').find('#myModalLabelProd').html(row_prod_cod + " - " + row_prod_name);
            var src = $(this).parents('.item').find("div").find(".ct_img_big").val();
            $('#myModal_enc').find('img').attr('src', src);

            
            var row_qtd_caixa = $(this).parents('.item').find("span.qtd_caixa").text();
            $('#myModal_enc').find('#qtd_caixa').html(row_qtd_caixa);
            
            var row_desi_comer = $(this).parents('.item').find("div").find("span.desi_comer").text();
            $('#myModal_enc').find('#desi_comer').html(row_desi_comer);
            
            var row_desi_tec = $(this).parents('.item').find("span.desi_tec").text();
            $('#myModal_enc').find('#desi_tec').html(row_desi_tec);

            console.log($(this).parents('.item').find("span.desi_tec").text())
           console.log($(this).parents('.item').find("span.desi_comer").text())


            var row_prod_price_desc = $(this).parents('.item').find("div").find(".ct_price_sem_desconto").data('value');
            var modal_w='width:12%';
            if(row_prod_price_desc!==undefined){modal_w='width:20%'}
            $('#myModal_enc .modal-dialog .modal-content .modal-footer').html('<div class="container" style="'+modal_w+'">  '+


            //var row_prod_desi_comer = $(this).parents('.item').find("div").div(".ct_img_big").val();
            /*+ ((value.desi_comer === null || value.desi_comer === 'null') ? ' ': '<div class="col-md-12 text-center"><b>Designação Comercial: </b>' + value.desi_comer ) 
            + '</div>' + (value.desi_tec  == null? ''  :'<div class="col-md-12 text-center"><b>Designação Técnica: </b>' + value.desi_tec )+ '</div>' );+*/
                 
            
            $(this).parents('.item').find(".col-md-12").html()+'</div>');
            $('#myModal_enc').modal('show');
        });

        //prevent zero and negative
        $(document).on('keypress', '#products_catalog input, #products_cart input', function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
        });

        $(document).on('click', '.show_enc', function () {
            var encomendaNumber = $(this).data('encnr');

            getArtsFromEnc(encomendaNumber);

            $('#myModal_Orders').find('#myModalLabelOrder').html('<i class="text-muted fa fa-shopping-cart"></i> <?php printf(__('order_art_title_lbl', 'siga-store')); ?> ' + encomendaNumber);
            $('#myModal_Orders').find('#list_enc_art').empty();
            $('#myModal_Orders').modal('show');
        });

        function getArtsFromEnc(enc_id) {

            $.ajax({
                type: "GET",
                url: req_url + '/seam/resource/rest/jsSigaEncomendasService/getListaArtigosEncomendadosByCab/' + req_conn + ':' + req_username + ':' + req_password + '/' + sigaStoreUsername + '/' + btoa(sigaStorePassword) + '/' + enc_id,
                dataType: 'json',
                headers: {
                    "Authorization": "Basic " + btoa(sigaStoreUsername + ":" + sigaStorePassword)
                },
                timeout: timeout_ajax,
                beforeSend: function () {
                    startLoader();
                },
                success: function (response) {
                    var html_code = '';

                    response.encomendasListaArtigosBeanRestFul.encomendasArtigoBeanRestFulLista.forEach(function(value) {

                        if(value.codArtigo !== undefined ) {

                            html_code += '<tr>';
                            html_code += '<td width="3%"><span class="enc_art_cod">' + value.codArtigo + '</span></td>';
                            html_code += '<td width="5%"><span class="enc_art_qtd">' + value.cBarras + '</span></td>';
                            html_code += '<td width="15%"><span class="enc_art_desig">' + value.desigArtigo + (value.CLoteInt != null? (' - ' + value.CLote) : '') + '</span></td>';
                            html_code += '<td width="3%"><span class="enc_art_qtd">' + value.qtd + '</span></td>';
                            html_code += '<td width="3%"><span class="enc_art_uni">' + value.unidMedida + '</span></td>';
                            html_code += '<td width="3%" class="text-right"><span class="coin_price">€</span><span class="enc_art_price">' + value.preco + '</span></td>';

                            var percentagemDesconto = '-';
                            if (value.percDesc !== undefined && value.percDesc !== null) {
                                percentagemDesconto = value.percDesc;
                            }

                            html_code += '<td width="3%" class="text-right"><span class="coin_price">' + percentagemDesconto + '</td>';
                            html_code += '<td width="3%" class="text-right"><span class="coin_price">€</span><span class="enc_art_price">' + numeral(value.valorIliquido).format('0,0.00') + '</span></td>';
                            html_code += '<td width="3%" class="text-right"><span class="coin_price">€</span><span class="enc_art_price">' + numeral(value.valorLiquido).format('0,0.00') + '</span></td>';
                            

                            html_code += '</tr>';
                        }
                    });

                    var tableEnc = '';
                    tableEnc += '<thead>';
                        tableEnc += '<th width="3%"><strong><?php printf(__('cod_prod_msg', 'siga-store')); ?></strong></th>';
                        tableEnc += '<th width="5%" class=""><strong><?php printf(__('EAN', 'siga-store')); ?></strong></th>';
                        tableEnc += '<th width="15%"><strong><?php printf(__('desig_prod_msg', 'siga-store')); ?></strong></th>';
                        tableEnc += '<th width="3%"><strong><?php printf(__('order_art_qtd_lbl', 'siga-store')); ?></strong></th>';
                        tableEnc += '<th width="3%"><strong><?php printf(__('order_art_uni_lbl', 'siga-store')); ?></strong></th>';
                        tableEnc += '<th width="3%" class="text-right"><strong><?php printf(__('order_art_prc_lbl', 'siga-store')); ?></strong></th>';
                        tableEnc += '<th width="3%" class="text-right"><strong><?php printf(__('perc_desconto', 'siga-store')); ?></strong></th>';
                        tableEnc += '<th width="3%" class="text-right"><strong><?php printf(__('iliquido', 'siga-store')); ?></strong></th>';
                        tableEnc += '<th width="3%" class="text-right"><strong><?php printf(__('liquido', 'siga-store')); ?></strong></th>';
                        

                    tableEnc += '</thead>';

                    tableEnc += '<tbody>';
                        tableEnc += html_code;
                    tableEnc += '</tbody>';

                    if (html_code === '') {
                        toastr.info("<?php printf(__('no_results_lbl', 'siga-store'));?>");
                    }

                    $('#myEncArts').html(tableEnc);
                    var client_name = $('#sel_ent option:selected').text();
                    <?php
                        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
                    ?>
                    var imageFat = '<img src="<?php echo $actual_link ?>/' + imagePrint + 
                        '" srcset="<?php echo $actual_link ?>/' + imagePrint + ' 200w, ' + 
                        '<?php echo $actual_link ?>/' + imagePrint + ' 150w"' +
                        '" sizes="(max-width: 709px) 85vw, (max-width: 909px) 81vw, (max-width: 1362px) 88vw, 1200px" '+
                        ' width="200" height="200" alt="Loja Tentação do Lar">';
                      
                    $('#imgEnc').html(imageFat);
                    
                    $('#clientEncName').html(client_name);
                    $('#clientEncModal').html(client_name);

                    $('#clientEnc').html(enc_id);
                    $('#encId').html(enc_id);

                    $('#totalMyEncArts').html(response.encomendasListaArtigosBeanRestFul.valorLiqTotalEnc);

                    stopLoader();
                },
                error: function(jqXHR,error, errorThrown) {
                    stopLoader();
                    console.log("Something went wrong");
                }
            });
        }

        //button add to cart no catalogo
        $(document).on('click', '.add-click', function () {

            var productId = $(this).data('product-id'),
                productQty = parseInt($('.ct_qtd[data-product-id="'+productId+'"]').val());
            var loteCart = $('#lotesSel-'+productId+'').val();
            var refimagem = $('#refSel-'+productId+'').val();

            if(loteCart != null)
                loteCart = loteCart.split("%");

            var objProduct = null;
            $.each(catalogProducts, function (key, value) {
                if (productId == value.CArtigo) {
                    objProduct = {
                        codArtigo: value.CArtigo,
                        qtd: productQty,
                        price: value.precoDefault.preco,
                        desigArtigo: value.desigCArtigo,
                        imagemMedia: value.imagemMedia,
                        imagemGrande: value.imagemGrande,
                        imagemThumb: value.imagemThumb,
                        uni_med: value.cUniMed,
                        percDesc: value.precoDefault.percDesconto,
                        preco_liq: value.precoDefault.precoComDesconto,
                        codBarras: value.CBarras,                        
                        CLote: null,
                        CLoteInt: null,
                        refimagens: null,
                        qtd_caixa: value.quantidadePorCaixa,
                        obs :value.observ,
                        qtd_caixa: value.quantidadePorCaixa,
                        desi_comer: (value.desigComer === null? value.desigCArtigo: value.desigComer),
                        desi_tec: value.designacaoTecnica
                    };

                    if(loteCart != null){
                        
                        objProduct.CLoteInt =loteCart[0];
                        objProduct.CLote = loteCart[1];
                    }

                    if(refimagem != null){
                        objProduct.refimagens = refimagem;

                        $.each(value.listaImagensWeb, function(key, img){
                            if(img.designacaoImagem == refimagem){
                                objProduct.imagemMedia= img.imagemMedia;
                                objProduct.imagemGrande = img.imagemGrande;
                                objProduct.imagemThumb = img.imagemThumb;
                            }
                        })
                    }
                }

            });

            if (productQty > 0) {
                // adicionar cod barras ao objecto
                $.ajax({
                    type: "GET",
                    url: req_url + '/seam/resource/rest/jsArtigosRestFulService/getRelArtTipoCbarrasBYCArtigo/' + req_conn + ':' + req_username + ':' + req_password + '/' + sigaStoreUsername + '/' + btoa(sigaStorePassword) + '/' + productId + '/' + sigaStoreTipoCBarras,
                    headers: {
                        "Authorization": "Basic " + btoa(sigaStoreUsername + ":" + sigaStorePassword)
                    },
                    timeout: timeout_ajax
                }).done(function (data) {
                    addProductToCart(objProduct, productId);
                    $('.product-item-' + productId).css("background-color", "#DDD");
                    //colocar imagem de carrinho

                }).fail(function (jqXHR, textStatus) {

                    if (jqXHR.status == 200) {
                        addProductToCart(objProduct, productId);
                    }

                });

            } else {
                toastr.info("<?php printf(__('cannot_add_product_with_quantity_zero', 'siga-store')); ?>");
            }
        });

        //button update product to cart catalogo
        $("#sel_ent").change(function () {

            currentPage = 1;
            numberPages = 1;

            localStorage.setItem('home_select', $(this).val());

            if (localStorage.getItem('store_shop_cart') !== null) {
                localStorage.removeItem('store_shop_cart');
                $("span.badge-default").html("0");
                $('#products_catalog').html('');
                $('.pagination').html('');
            }

            if (homeSelect == null || homeSelect == "") {
                $('#alert_warn').html('<strong><?php printf(__('select_client_ent_msg', 'siga-store')); ?></strong>');
                $('#catalog_page').hide();
                $('#cart_page').hide();
                $('#orders_page').hide();
                $('.nav-tabs a[href="#home"]').tab('show');
            } else {
                $('#alert_warn').html('');
                $('#catalog_page').css('display', 'block');
                $('#cart_page').css('display', 'block');
                $('#orders_page').css('display', 'block');
                populate_combo01('sel1');
                $('#products_catalog').html('');
                $('.pagination').html('');
            }
            
            location.reload();
        });

        function searchCartItemById(codArtigo, cLote, refimagens) {

            var cookie_cart = getCookieCart(),
                productCartObject = null;

            if (cookie_cart.length > 0) {
              
                $.each(cookie_cart, function (key, value) {
                    if(refimagens == null || refimagens ==""){
                        if(codArtigo == value.codArtigo && cLote == ""){
                            productCartObject = value;
                        } else if (codArtigo == value.codArtigo && cLote == value.CLote) {
                            productCartObject = value;
                        }
                    }else if(codArtigo == value.codArtigo && refimagens == value.refimagens){
                        productCartObject = value;
                    }

                });
            }

            return productCartObject;
        }

        //update cart
        function updateCart(obj) {
            var cookie_cart = getCookieCart(),
                newCheckoutCart = [];
            if (cookie_cart.length > 0) {
                $.each(cookie_cart, function (key, value) {

                    var valueqtd = parseInt(value.qtd);
                    var objqtd = parseInt(obj.qtd);

                    if(value != null){
                        if (obj.codArtigo == value.codArtigo) {
                            if(value.refimagens == null){
                                
                                if(value.CLote != null && obj.CLote != null){
                                    if(value.CLote == obj.CLote && value.CLoteInt == obj.CLoteInt){
                                        valueqtd = objqtd;
                                    } 
                                } else if(value.CLote == null && value.CLoteInt == null){
                                    valueqtd = objqtd;
                                }
                            }else if (obj.refimagens == value.refimagens){
                                valueqtd = objqtd;
                            }

                        }
                    }
                    value.qtd = valueqtd;

                    newCheckoutCart.push(value);
                });
            }

            localStorage.setItem('store_shop_cart', JSON.stringify(newCheckoutCart));

            updateCartBadge();
        }

        /*
            Adicionar Produtos no carrinho
        */
        function addProductToCart(product, productId){
            var cookie_cart = getCookieCart();

            if (searchCartItemById(productId, product.CLote, product.refimagens) === null) {
                cookie_cart.push(product);
                localStorage.setItem('store_shop_cart', JSON.stringify(cookie_cart));

                toastr.success("<?php printf(__('product_added_successfully', 'siga-store')); ?>");

                updateCartBadge();

            } else {
                $.each(cookie_cart, function(key, value){
                    
                    if(value.codArtigo === product.codArtigo){

                        if(product.refimagens == null){
                            if(product.CLoteInt != null && value.CLoteInt != null && product.CLoteInt === value.CLoteInt){
                                value.qtd += product.qtd;
                                localStorage.setItem('store_shop_cart', JSON.stringify(cookie_cart));
                                toastr.success("<?php printf(__('product_added_successfully', 'siga-store')); ?>");
                            } else if(product.CLoteInt === null){
                                value.qtd += product.qtd;
                                localStorage.setItem('store_shop_cart', JSON.stringify(cookie_cart));
                                toastr.success("<?php printf(__('product_added_successfully', 'siga-store')); ?>");
                            }
                        }else if (product.refimagens == value.refimagens){
                            value.qtd += product.qtd;
                            localStorage.setItem('store_shop_cart', JSON.stringify(cookie_cart));
                            toastr.success("<?php printf(__('product_added_successfully', 'siga-store')); ?>");
                           /* if(product.CLoteInt != null && value.CLoteInt != null && product.CLoteInt === value.CLoteInt){
                                value.qtd += product.qtd;
                                localStorage.setItem('store_shop_cart', JSON.stringify(cookie_cart));
                                toastr.success("<?php printf(__('product_added_successfully', 'siga-store')); ?>");
                            } else if(product.CLoteInt === null){
                                value.qtd += product.qtd;
                                localStorage.setItem('store_shop_cart', JSON.stringify(cookie_cart));
                                toastr.success("<?php printf(__('product_added_successfully', 'siga-store')); ?>");
                            }*/
                        }
                    }
                })
               
            }

        }

    

        //return cart size
        function getCartSize() {
            var productCart = getCookieCart();
            return productCart.length;
        }

        function getCookieCart() {
            return JSON.parse(localStorage.getItem('store_shop_cart')) || [];
        }

        //Includes is not defined for IE
        if (!Array.prototype.includes) {
            Array.prototype.includes = function(search, start) {
                'use strict';
                if (typeof start !== 'number') {
                    start = 0;
                }

                if (start + search.length > this.length) {
                    return false;
                } else {
                    return this.indexOf(search, start) !== -1;
                }
            };
        }

        //updates cart badge value
        function updateCartBadge() {
            $("span.badge-default").html(getCartSize());
        }

        function checkout_btn_status() {
            var cart_size = getCartSize();

            var min_enc_val = min_enc_val =parseInt('<?php echo get_option('sss_min_enc');?>') || 0;

            if (cart_size != undefined || cart_size > 0) {
                $("#btn_check_cart").removeClass("disabled");
                $("#btn_check_cart").removeAttr("disabled");
                $("#alert_min_enc").hide();
            } else {
                $("#btn_check_cart").addClass("disabled");
                $("#btn_check_cart").attr('disabled', true); ;
                $("#alert_min_enc").text("<?php printf(__('min_enc_msg01', 'siga-store')); ?>" + min_enc_val + "<?php printf(__('min_enc_msg02', 'siga-store')); ?>");
                $("#alert_min_enc").css('display', 'block');
            }
        }

        var productIdToRemove = null;
        var productCLoteToRemove = null;
        var productCLoteIntToRemove = null;
        var refimagensToRemove = null;

        // remover product na tab carrinho
        $(document).on('click', '.remove-click', function () {

            $('#cleanItemModal').modal('show');
            var producto = $(this).data('product-id');
            productCLoteToRemove = $(this).data('product-lote');
            productCLoteIntToRemove =$(this).data('product-loteint')
            productIdToRemove =producto;
            refimagensToRemove =$(this).data('product-refimg')
        });

        
        $(document).on('click', '.remove-click-item', function () {
            $('#cleanItemModal').modal('hide');
            var objProduct = null;

            var cookie_cart = getCookieCart();
            if (cookie_cart.length > 0) {
                $.each(cookie_cart, function (key, value) {
                    if(value != null) {
                        if (productIdToRemove == value.codArtigo) {    
                            if(value.refimagens == null) {               
                                if(productCLoteToRemove == value.CLote && productCLoteIntToRemove == value.CLoteInt ) {
                                    objProduct = value;
                                }
                                else if(productCLoteToRemove == "" && productCLoteIntToRemove == "") {
                                    objProduct = value;
                                }
                             }else if(value.refimagens == refimagensToRemove){
                                objProduct = value;
                             }
                        }
                    }
                });
            }

            removeFromCart(objProduct);

            populateFrontendEncomendaArtigos();

            checkout_btn_status();
        });


        //remove object from cart
        function removeFromCart(obj) {

            var productsCart = getCookieCart();
            var newCheckout = [];


            if (productsCart.length > 0) {
                $.each(productsCart, function (key, value) {
                    if (obj.codArtigo != value.codArtigo) {
                            newCheckout.push(value);
                    } else{
                        if(value.refimagens == null){
                                if(obj.CLote != null && value.CLote != null){
                                    if(obj.CLote != value.CLote && obj.CLoteInt != value.CLoteInt){
                                        newCheckout.push(value); 
                                    }
                                }
                        }else if(obj.refimagens != value.refimagens ){
                            newCheckout.push(value); 
                        }
                    }
                })
            }

            // update checkout cart to localStorage
            localStorage.setItem('store_shop_cart', JSON.stringify(newCheckout));
            toastr.success("<?php printf(__('product_removed_successfully', 'siga-store')); ?>");

            updateCartBadge();
        }

        $(document).on('click', '.Clearclick', function () {

            var cookie_cart = getCookieCart();
            if (cookie_cart.length > 0) {
                $('#cleanCartModal').modal('show');
            }
        });

        $(document).on('click', '.remove-cart', function () {

            $('#cleanCartModal').modal('hide');

            if (localStorage.getItem('store_shop_cart') !== null) {

                localStorage.removeItem('store_shop_cart');
                $("span.badge-default").html("0");
                $("#products_cart").empty();
                $('#observacoes').val('');
                $('#total_value').html('€0');


                checkout_btn_status();
            }
        });

        $(document).on('click', '.print-this', function () {
            var domClone = document.getElementById("printContent").cloneNode(true);

            var $printSection = document.getElementById("printSection");

            if (!$printSection) {
                var $printSection = document.createElement("div");
                $printSection.id = "printSection";
                document.body.appendChild($printSection);
            }

            $printSection.innerHTML = "";
            $printSection.appendChild(domClone);
            window.print();

        });

        $(document).on('change', '.upVal', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            if ($('#cart_page').hasClass('active')) {

                var up_value = parseFloat($(this).val());
                
                if ($.isNumeric(up_value)) {
                    if ($(this).val().length > 11) {
                        toastr.warning("<?php printf(__('valid_input_length_msg', 'siga-store')); ?>");
                        $(this).val(1);
                    }

                    var productId = $(this).data('product-id'),
                        productQty = $(this).val(),
                        productCLote= $(this).data('product-clote'),
                        productCLoteInt= $(this).data('product-cloteint'),
                        refimagens=$(this).data('product-refimg')
                       
                        objProduct = searchCartItemById(productId, productCLote,refimagens);
                        
                    if (objProduct !== null) {

                        objProduct.qtd = productQty;

                        if (productQty == 0) {
                            removeFromCart(objProduct);
                            $(this).closest(".item").remove();
                        } else {
                            updateCart(objProduct);
                        }
                        populateFrontendEncomendaArtigos();
                    }
                }

               // $('#btn_check_cart').hide();
              //  $('#btn_refresh_check_cart').show();
            }



        });

        $(document).on('click', '#btn_refresh_check_cart', function (e) {
            populateFrontendEncomendaArtigos();
        });

        $(document).on('click', '.nav-tabs a[href="#cat"]', function () {

            currentPage = 1;
            numberPages = 1;

            $('#sel1').val($(this).find('option:first').val());
            $('#sel2').empty();
            $('#products_catalog').html('');
            $('.pagination').html('');
            $('#mySearchCod').val('');
            $('#mySearchDesig').val('');
            $('#mySearchCodBarras').val('');
           
            var msgArtStockRup = "<p>" + msgArtigoStockRup + "</p>";
            $('#msg_producto_stock').html(msgArtStockRup);
            var msgPrecoAlteracao = "<p>" + msgPrecoAlt + "</p>";
            $('#msg_preco_alt').html(msgPrecoAlteracao);

            check_btns_display('<?php echo get_option('sss_dd_select_name');?>', 'none');

            if (homeSelect == null) {
                $('#alert_warn').html('<strong><?php printf(__('select_client_ent_msg', 'siga-store')); ?></strong>');
            } else {
                $('#alert_warn').html('');
                populate_combo01('sel1');
            }
        });

        function populateFrontendEncomendaArtigos () {

            $("#products_cart").empty();

            var checkoutItems = getCookieCart();

            if (checkoutItems.length > 0) {

                var display_class = check_settings_display();
                var precoTotal = 0;
                $.each(checkoutItems, function(key,value){
                    $.ajax({
                        type: "GET",
                        url: req_url + '/seam/resource/rest/jsSigaEncomendasService/saberPrecoArtigoByCodArtigo/' + req_conn + ':' + req_username + ':' + req_password + '/' + sigaStoreUsername + '/' + btoa(sigaStorePassword) +
                         '/LOnline/'+ value.codArtigo +'/?seqEntidade='+ homeSelect,
                        contentType: "application/json",
                        headers: {
                            "Authorization": "Basic " + btoa(sigaStoreUsername + ":" + sigaStorePassword)
                        },
                        timeout: timeout_ajax,
                        //beforeSend: function () {
                          //  startLoader();
                        //},
                        success: function (response) {
                            if(response != null){
                                if(response.encomendasPrecoArtigoBeanRestFul.preco != value.price){
                                    value.price = response.encomendasPrecoArtigoBeanRestFul.preco
                                }
                                if(response.encomendasPrecoArtigoBeanRestFul.percDesconto != value.percDesc){
                                    value.percDesc = response.encomendasPrecoArtigoBeanRestFul.percDesconto
                                }
                                if(response.encomendasPrecoArtigoBeanRestFul.precoComDesconto != value.preco_liq){
                                    value.preco_liq = response.encomendasPrecoArtigoBeanRestFul.precoComDesconto
                                }
                                localStorage.setItem('store_shop_cart', JSON.stringify(checkoutItems));
                            }
                        }  
                    });
                    
                    var imgBig = '<?php echo plugin_dir_url(__FILE__);?>default_BIG.jpg',
                        imgThumb = '<?php echo plugin_dir_url(__FILE__);?>default_MEDIA.jpg';  

                    if (value.imagemMedia !== null) {
                        imgThumb = '<?php echo $fileDir;?>' + value.imagemMedia;
                    }

                    if (value.imagemGrande !== null) {
                        imgBig = '<?php echo $fileDir;?>' + value.imagemGrande;
                    }

                    var price_label = 'ct_price',
                        price_desc = '';
                        precoTotalArtigo = (value.preco_liq * value.qtd).toFixed(2); 
                        precoTotal += (value.preco_liq * value.qtd);

                    if (value.percDesc !== undefined && value.percDesc !== null) {
                        price_desc = '<span class="ct_price ct_price_sem_desconto" style="line-height: 0px;font-size: 28px;padding-top: 15px;float: left;"">€ ' + value.price + '</span>' +
                                    '<span class="label label-danger ct_desconto" style="padding: 8px;float:left;margin-right: 5px;">' + value.percDesc + ' %</span>';
                        price_label = 'ct_preco_liq';
                    }


                    $("#products_cart").append('' +
                        '<div class="item col-xs-12 col-sm-6 col-md-6 col-lg-4 row_number ' + display_class + '">'+
                            '<div class="thumbnail">'+
                                '<div style="text-align:center; font-weight: bold" class="imageRef" artid="' + value.refimagens+ '">' +  (value.refimagens == null? '': value.refimagens)  + '</div>'+

                                '<input type="hidden" name="path_pic" value="' + imgBig + '" class="ct_img_big" >'+
                                '<div class="img_container">'+
                                    '<img class="group list-group-image img-thumbnail thumb_pic_box_enc ct_img" src="' + imgThumb + '" alt="" />'+
                                '</div>'+
                                '<div class="caption">'+
                                    '<h4 class="group inner list-group-item-heading" style="margin-bottom: 15px;">'+
                                        '<span class="ct_id"><b>Código: </b>' + value.codArtigo + '</span><br/>'+
                                        '<span class="cBarras"><b>EAN: </b>' + value.codBarras + '</span><br/>' + 
                                        '<span class="qtd_caixa"><b>Quantidade por caixa: </b>' + value.qtd_caixa +'</span>' + 
                                        '</h4>'+
                                    
                                    '<p class="group inner list-group-item-text">'+
                                        '<span class="ct_name">' + value.desigArtigo + '</span>'+
                                    '</p>'+
                                    /*'<span>Observações: </span>' +
                                        '<textarea id="rt" rows="1" cols="10">' +
                                        '</textarea>'+
                                    */
                                    '<div class="designacoes"> '+
                                        '<span class="desi_comer"><b>Designação comercial </b>' + value.desi_comer + '</span>' +
                                        '<span class="desi_tec"><b>Designação Técnica </b>' + value.desi_tec + '</span>' +
                                    '</div>'+
                                    '<div class="row">' +
                                        '<div class="col-md-12" style="padding-top: 10px; padding-bottom: 10px; min-height: 47px;">' +
                                            price_desc + '<span class="price_s price-unit-' + value.codArtigo + ' ' + price_label + '" style="font-weight: 800;line-height: 0px;font-size: 28px;padding-top: 15px;float: left;">€' + value.preco_liq + '</span>' +
                                        '</div>' +
                                        '<div class="col-md-12" style="padding-bottom: 5px;padding-top: 5px;font-weight: 800;min-height: 40px;">' +
                                            '<span>€ ' + precoTotalArtigo + '</span>' +
                                        '</div>' +
                                    '</div>' +
                                    '<div class="row">'+
                                        '<div class="col-md-4 col-xs-12 col-sm-4">' +
                                            '<input type="number" class="form-control math_cell cell_val_input upVal ct_qtd" data-product-id="' + value.codArtigo + '" data-product-clote="' + (value.CLote != null? value.CLote : '') + 
                                            '" data-product-cloteint="' + (value.CLoteInt != null? value.CLoteInt : '') + '" value="' + value.qtd + '" placeholder="'+ value.qtd_caixa +'" min="'+ value.qtd_caixa +'" maxlength="11"' + 
                                            'data-product-refimg="' + (value.refimagens != null ? value.refimagens : '') +'" ' + 'step='+value.qtd_caixa + '>' + 
                                        '</div>'+
                                        '<div class="col-md-8 col-xs-12 col-sm-8">' +
                                            (value.CLote == null? '' : '<span class="ct_lote">' + value.CLote + '</span>')+
                                        '</div>'+
                                    '</div>'+
                                    '<br/><div class="row">'+
                                    '<div class="col-md-12 col-xs-12 col-sm-12">'+
                                            '<button type="button" class="btn btn-danger btn-sm btn-block remove-click" data-product-id="' + value.codArtigo +'" data-product-lote="' + (value.CLote != null ? (value.CLote) : '' ) +
                                             '" data-product-loteint="' + (value.CLoteInt != null ? value.CLoteInt : '') +'" data-product-refimg="' + (value.refimagens != null ? value.refimagens : '') +'">' +
                                                '<span class="glyphicon glyphicon-remove"></span><?php printf(__('remove_cart_lbl', 'siga-store')); ?>'+
                                            '</button>' +
                                        '</div>'+
                                    '</div>'+
                                '</div>' +
                            '</div>' +
                        '</div>');
                });

                $('#total_value').html('€ ' + precoTotal.toFixed(2));

                $('#btn_check_cart').show();
                $('#btn_refresh_check_cart').hide();
                setTimeout(function () { stopLoader() }, 500);

            }
              
            else {
                $('#total_value').html('€0');
            }
        }

        $('.nav-tabs a[href="#enc"]').click(function () {
            checkout_btn_status();

            populateFrontendEncomendaArtigos();

            check_btns_display('<?php echo get_option('sss_dd_select_name');?>', 'none');
        });

        $('.nav-tabs a[href="#my_orders"]').click(function () {
            $("#startdate").find('input').val('');
            $("#enddate").find('input').val('');
            $('#myTableOrders').hide();
            $("#myorders_list").empty();
        });

        //events - bottom buttons from enc
        $("#btn_check_cart").click(function () {
            var cartProducts = getCookieCart();
            //console.log(cartProducts)
                var objPost = [];

                $.each(cartProducts, function (key, value) {
                    var obj = {};

                    obj.codArtigo = value.codArtigo;
                    obj.qtd = value.qtd;
                    obj.preco = value.price;
                    obj.unidMedida = value.uni_med;
                    obj.percDesc = value.percDesc;
                    obj.precoComDesconto = value.preco_liq;

                    if (value.codBarras !== null) {
                        obj.cTipoCBarras = sigaStoreTipoCBarras;
                        obj.cBarras = value.codBarras;
                    }
                    if(value.CLote != null){
                        obj.CLote = value.CLote;
                        obj.CLoteInt = value.CLoteInt;
                    }

                    if(value.refimagens != null){
                        obj.observ = value.refimagens
                        obj.imgArtigoSelecionada = value.refimagens
                    }

                    objPost.push(obj);
                });

                var jsonToPost = {
                    encomendasClienteBeanRESTful: {
                        seqEntidade: homeSelect,
                        checkStatusRESTful: null,
                        nrEncomenda: null,
                        suaEncomenda: "Web-" + sigaStoreUsername + "-" + Date.now(),
                        observacoes: $('#observacoes').val(),
                        encomendasArtigoBeanRestFuls: objPost
                    }
                };

                //console.log(jsonToPost)

                if (sigaStoreVendedor != null) {
                    jsonToPost.encomendasClienteBeanRESTful.codigoVendedor = sigaStoreVendedor;
                }

                $.ajax({
                    url: req_url + '/seam/resource/rest/jsSigaEncomendasService/realizarEncomendaInJson/' + req_conn + ':' + req_username + ':' + req_password + '/' + sigaStoreUsername + '/' + btoa(sigaStorePassword) + '/wp_e',
                    type: "POST",
                    data: JSON.stringify(jsonToPost),
                    contentType: "application/json",
                    timeout: timeout_ajax,
                    beforeSend: function () {
                        startLoader();
                    },
                    headers: {
                        "Authorization": "Basic " + btoa(sigaStoreUsername + ":" + sigaStorePassword)
                    },
                    success: function(response) {

                        console.log("1")

                        if (response.encomendasClienteBeanRESTful.checkStatusRESTful.includes('9-0') === true) {
                            toastr.error("<?php printf(__('error_order_msg', 'siga-store')); ?> " + response.encomendasClienteBeanRESTful.checkStatusRESTful);

                            setTimeout(function () {
                                stopLoader();
                            }, timeout_delay)
                        } else {
                            toastr.success("<?php printf(__('order_ok_msg', 'siga-store')); ?>");
                            console.log("1")
                            localStorage.removeItem('store_shop_cart');
                            console.log("2")
                            $("span.badge-default").html("0");
                            console.log("3")
                            $("#products_cart").empty();
                            console.log("4")
                            $('#observacoes').val('');
                            console.log("5")
                            $('.nav-tabs a[href="#home"]').tab('show');
                            console.log("6")


                            setTimeout(function () {
                                console.log("7")
                                stopLoader();
                                console.log("8")
                            }, timeout_delay)

                            console.log("9")
                            var enc_id = response.encomendasClienteBeanRESTful.nrEncomenda.split('|');
                            console.log("A")
                            getArtsFromEnc(enc_id[1]);
                            console.log("B")
                            $('#myModal_Orders').find('#myModalLabelOrder').html('<i class="text-muted fa fa-shopping-cart"></i> <?php printf(__('order_art_title_lbl', 'siga-store')); ?> ' + enc_id[1]);
                            console.log("C")
                            $('#myModal_Orders').find('#list_enc_art').empty();
                            console.log("D")
                            $('#myModal_Orders').modal('show');
                            console.log("")

                        }
                    },
                    error: function (response) {
                        toastr.error("<?php printf(__('error_order_msg', 'siga-store')); ?> " + textStatus + " " + errorThrown);

                        setTimeout(function () {
                            stopLoader();
                        }, timeout_delay)
                    }
                });
            //}
        });

        $(".siga-btn").click(function () {
            currentPage = 1;
            numberPages = 1;

            $('.nav-tabs a[href="#cat"]').tab('show');
            $('#sel1').val($(this).find('option:first').val());
            $('#sel2').empty();
            $('#products_catalog').html('');
            $('.pagination').html('');
            $('#mySearchCod').val('');
            $('#mySearchDesig').val('');

            check_btns_display('<?php echo get_option('sss_dd_select_name');?>', 'none');
        });

        //change pass
        $("#pass-btn").click(function(e) {
            e.preventDefault();
            if($("#current-pass").val().length ==0 || $("#new-pass").val().length ==0 || $("#confirm-new-pass").val().length ==0){
                toastr.warning('<?php printf(__('empty_new_pass_msg', 'siga-store'));?>');
            }else if( $("#new-pass").val() !== $("#confirm-new-pass").val()){
                toastr.warning('<?php printf(__('new_pass_not_confirmed_msg', 'siga-store'));?>');
            }else{
                service_path="/seam/resource/rest/sigaCoreService/mudarPalavraChaveUtilizadorInJson/";

                var novaPass=$('#confirm-new-pass').val();

                $.ajax({
                    type: "POST",
                    url: req_url + service_path + req_conn + ':' + req_username + ':' + req_password + '/wp_e',
                    contentType: "application/json",
                    headers: {
                        "Authorization": "Basic " + btoa(sigaStoreUsername + ":" + sigaStorePassword)
                    },
                    timeout: timeout_ajax,
                    data: JSON.stringify({
                        'jsDadosUtilizadorBeanRESTFul': {
                            'username': sigaStoreUsername,
                            'passwordOld': btoa(sigaStorePassword),
                            'passwordNew': btoa(novaPass)
                        }
                    }),
                    beforeSend: function () {
                        startLoader();
                    },
                    success: function (data1) {
                        stopLoader();
                        if(data1.jsBaseBeanRESTful.checkStatusRestFul=="0-Ok"){
                            localStorage.setItem('siga_store_password',novaPass);
                            toastr.success('<?php printf(__('new_pass_sucess_msg', 'siga-store'));?>');
                            $('#change-pass-modal').modal('hide');
                            location.reload();
                        }

                    },
                    error: function(jqXHR,error, errorThrown) {
                        stopLoader();
                        if(jqXHR.status&&jqXHR.status==400){
                            toastr.error(jqXHR.responseText);
                        }else{
                            console.log("Something went wrong");
                        }
                    }
                });
            }

        });

        $('#change-pass-modal').on('hidden.bs.modal', function(){
            $(this).find('form')[0].reset();
        });


        $(document).on('click','#buttonNext', function(key){
            let artigoID = key.target.getAttribute("artid");


            $.each($('.artigoImg'), function (key, value) {
                if(value.getAttribute("artid") == artigoID){
                    let imgActual = null;
                    let imgNext = null;
                    $.each($(value.children), function (key1, imgObj) {
                        if(!(imgObj.className).includes("scrollHide")){
                            imgActual = imgObj;
                            
                            if(key1 == value.children.length-1){
                                imgNext = 0
                            } else{
                                imgNext = key1+1;
                            }
                        } 
                    })
                    if(imgNext != null){
                        $.each($(value.children), function (key2, imgObj) {
                            if(imgObj.getAttribute("data-key") == imgNext){
                                imgNext = imgObj;
                            } 
                        })
                    }
                    if(imgActual != null && imgNext != null){
                        imgActual.classList.add("scrollHide");
                        imgNext.classList.remove("scrollHide");
                    }

                    $.each( $('.imageRef'), function (key, ref) {
                        if(ref.getAttribute("artid") == artigoID){
                            ref.innerHTML = imgNext.getAttribute("descImgRef");
                        }
                    });
                }
                  


            })
        


        });

        $(document).on('click','#buttonPrev',  function(key){

            let artigoID = key.target.getAttribute("artid");

            $.each($('.artigoImg'), function (key, value) {

                if(value.getAttribute("artid") == artigoID){
                    let imgActual = null;
                    let imgPrev = null;
                    $.each($(value.children), function (key1, imgObj) {
                        if(!(imgObj.className).includes("scrollHide")){
                            imgActual = imgObj;
                            
                            if(key1 == 0){
                                imgPrev = value.children.length-1
                            } else{
                                imgPrev = key1-1;
                            }
                        } 
                    })
                    if(imgPrev != null){
                        $.each($(value.children), function (key2, imgObj) {
                            if(imgObj.getAttribute("data-key") == imgPrev){
                                imgPrev = imgObj;
                            } 
                        })
                    }
                    if(imgActual != null && imgPrev != null){
                        imgActual.classList.add("scrollHide");
                        imgPrev.classList.remove("scrollHide");
                    }

                    $.each( $('.imageRef'), function (key, ref) {
                        if(ref.getAttribute("artid") == artigoID){
                            ref.innerHTML = imgPrev.getAttribute("descImgRef");
                        }
                    });
                }
            })
            
           
        })
    })

</script>

<div class="form-group">
    <select class="form-control" id="sel_ent"></select>
    <span id="ent_lbl"></span>
</div>


<ul class="nav nav-tabs">
    <li id="home_page" class="active">
        <a data-toggle="tab" href="#home">
            <span class="glyphicon glyphicon-home"></span>
            <span class="text_tab"><?php printf(__('home_tab_lbl', 'siga-store')); ?></span>
        </a>
    </li>
    <li id="catalog_page"><a data-toggle="tab" href="#cat">
            <span class="glyphicon glyphicon-book"></span>
            <span class="text_tab"><?php printf(__('catalogo_lbl', 'siga-store')); ?></span>
        </a>
    </li>
    <li id="cart_page">
        <a data-toggle="tab" href="#enc">
            <span class="glyphicon glyphicon-shopping-cart"></span>
            <span class="text_tab"><?php printf(__('encomenda_lbl', 'siga-store')); ?></span>
            <span class="badge badge-default">0</span>
        </a>
    </li>
    <li id="orders_page">
        <a data-toggle="tab" href="#my_orders">
            <span class="glyphicon glyphicon-list-alt"></span>
            <span class="text_tab"><?php printf(__('my_orders_tab_lbl', 'siga-store')); ?></span>
        </a>
    </li>
    <li class="pull-right">
        <a type="button" id="logout" name="logout" class="btn btn-primary btn-sm"><?php printf(__( 'sign_out_lbl', 'siga-store' )); ?></a>
    </li>
    <li class="pull-right">
        <a type="button" id="change-pass-btn" name="change-pass-btn" class="btn btn-info btn-sm" data-toggle="modal" data-target="#change-pass-modal"><?php printf(__( 'change_pass_lbl', 'siga-store' )); ?></a>
    </li>
</ul>

<div class="tab-content">
    <div id="home" class="tab-pane fade in active">
        <p></p>
    </div>

    <div id="cat" class="tab-pane fade">

        <p id="alert_warn"></p>

        <div class="search-panel mt10">
            <div class="row">
                <div class="col-md-3">
                    <input type="text" id="mySearchCod" class="form-control" placeholder="<?php printf(__('cod_prod_msg', 'siga-store')); ?>">
                </div>
                <div class="col-md-3">
                    <input type="text" id="mySearchDesig" class="form-control" placeholder="<?php printf(__('desig_prod_msg', 'siga-store')); ?>">
                </div>
                <div class="col-md-4">
                    <input type="text" id="mySearchCodBarras" class="form-control" placeholder="<?php printf(__('barcode_prod_msg', 'siga-store')); ?>">
                </div>
                <div class="col-md-2">
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                        <div class="btn-group" role="group">
                            <button id="search_btn" type="button" class="btn btn-info"><i class="fa fa-search"></i></button>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="reset_btn" type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="category_selector">
            <div class="row form-group mt10">
                <div class="col-md-8">
                    <fieldset id="historicoSel">
                        <label for="historicoSel">Obter apenas artigos comprados anteriormente: </label>
                        <input type="radio" value="true" id="historicoOp1" name="historicoOp">
                        <label for="historicoOp1">Sim</label>
                        <input type="radio" value="false" id="historicoOp2" name="historicoOp" checked="true">
                        <label for="historicoOp2">Não</label>
                    </fieldset>
                </div>
            </div>
            <div class="row form-group mt10">
                <div class="col-md-3">
                    <!--label-- for="sel1">< ?php echo get_option('sss_prod_order_01'); ?></label-->
                    <select class="form-control" id="sel1" name="sel1"></select>
                </div>
                <div class="col-md-3">
                    <!--label-- for="sel2">< ?php echo get_option('sss_prod_order_02'); ?></--label-->
                    <select class="form-control" id="sel2" name="sel2"></select>
                </div>
                <div class="col-md-3">
                    <!--label-- for="sel3">< ?php echo get_option('sss_prod_order_02'); ?></--label-->
                    <select class="form-control" id="sel3" name="sel3"></select>
                </div>
<!--   Para uso futuro             
                <div class="col-md-3">
                    </!--label-- for="sel4">< ?php echo get_option('sss_prod_order_02'); ?></--label-/->
                    <select class="form-control" id="sel4" name="sel4"></select>
                </div>
-->
            </div>

        </div>

        <div class="mtb15">
            <div class="row">
                <div class="col-md-9">
                    <strong><?php printf(__('display_l_g_lbl', 'siga-store')); ?></strong>
                </div>
                <div class="col-md-3">
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                        <div class="btn-group" role="group">
                            <button id="products_catalog_Change_to_List" type="button" class="btn btn-info btn-sm">
                                <span class="glyphicon glyphicon-th-list"></span><?php printf(__('list_l_g_lbl', 'siga-store')); ?>
                            </button>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="products_catalog_Change_to_Grid" type="button" class="btn btn-info btn-sm">
                                <span class="glyphicon glyphicon-th"></span><?php printf(__('grid_l_g_lbl', 'siga-store')); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="products_catalog" class="list-group row"></div>

        <div id="products_list">
            <div class="table-responsive panel">
            </div>
        </div>

        <div class="pagination" style="margin: 0 auto;display: table;"></div>

        <!-- Modal cat -->
        <div class="modal" id="myModal_cat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                    class="text-danger fa fa-times"></i></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="text-muted fa fa-shopping-cart"></i> <span
                                    id="myModalLabelProd" class="modal_label_gen">#cod - Prod</span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center zoom">
                            <img src="<?php echo plugin_dir_url(__FILE__); ?>default_THUMB.jpg" alt="cat_pic"
                                 class="img-thumbnail pic_box">
                        </div>

                        <div class="clearfix"></div>
                    </div>

                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>
        <br/>
        <div id="msg_producto_stock">Teste</div>
        <div id="msg_preco_alt">Alteracao</div>
    </div>

    <div id="enc" class="tab-pane fade">

        <button type="button" class="btn btn-danger btn-sm Clearclick mb15 mt10">
            <span class="glyphicon glyphicon-trash"></span> <?php printf(__('empty_cart_lbl', 'siga-store')); ?>
        </button>

        <div class="mtb15">
            <div class="row">
                <div class="col-md-9">
                    <strong><?php printf(__('display_l_g_lbl', 'siga-store')); ?></strong>
                </div>
                <div class="col-md-3">
                    <div class="btn-group btn-group-justified" role="group" aria-label="...">
                        <div class="btn-group" role="group">
                            <button id="products_cart_Change_to_List" type="button" class="btn btn-info btn-sm">
                                <span class="glyphicon glyphicon-th-list"></span><?php printf(__('list_l_g_lbl', 'siga-store')); ?>
                            </button>
                        </div>
                        <div class="btn-group" role="group">
                            <button id="products_cart_Change_to_Grid" type="button" class="btn btn-info btn-sm">
                                <span class="glyphicon glyphicon-th"></span><?php printf(__('grid_l_g_lbl', 'siga-store')); ?>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="observacoes" style="margin-bottom: 30px;">
            <label for=""><?php printf(__('observacos', 'siga-store')); ?></label>
            <textarea name="" id="observacoes" cols="30" rows="3"></textarea>
        </div>

        <div id="products_cart" class="list-group"></div>

        <div id="products_cart_f">
            <table class="table">
                <tbody>
                    <tr>
                        <td colspan="5" style="padding: 10px;text-align: right;">
                            <h3 class="total_title" style="margin: 0 !important;">
                                <strong><?php printf(__('prod_total_lbl', 'siga-store')); ?></strong>
                                <strong id="total_value">€0.00</strong>
                            </h3>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="padding: 10px;text-align: center;">
                            <span id="alert_min_enc" class="min_value_s">min_val</span>
                        </td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" style="padding: 10px;text-align: right;">
                            <button id="btn_refresh_check_cart" type="button" class="btn btn-warning pull-right" style="display: none;">
                                <?php printf(__('refresh_checkout', 'siga-store')); ?>
                            </button>
                            <button id="btn_check_cart" type="button" class="btn btn-primary pull-right">
                                <?php printf(__('checkout_shop_lbl', 'siga-store')); ?>
                            </button>
                        </td>
                    </tr>
                </tfoot>
            </table>

        </div>

        <!-- Modal enc -->
        <div class="modal" id="myModal_enc" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                    class="text-danger fa fa-times"></i></button>
                        <h4 class="modal-title" id="myModalLabel"><i class="text-muted fa fa-shopping-cart"></i> <span
                                    id="myModalLabelProd" class="modal_label_gen">#cod - Prod</span></h4>
                    </div>
                    <div class="modal-body">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center zoom">
                            <img src="<?php echo plugin_dir_url(__FILE__); ?>default_THUMB.jpg" alt="enc_pic"
                                 class="img-thumbnail pic_box">
                                 
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div id="qtd_caixa"> </div>
                    <div id="desi_comer"> </div>
                    <div id="desi_tec"> </div>

                    <div class="modal-footer"></div>
                    
                </div>
            </div>
        </div>
    </div>

    <div id="my_orders" class="tab-pane fade">

        <div class="span5 mt10">
            <div id="encs_dates_interval" class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <?php printf(__('from_date_lbl', 'siga-store')); ?>

                        <div class='input-group date' id='startdate'>
                            <input type='text' class="form-control" placeholder="dd/mm/yyyy"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <?php printf(__('to_date_lbl', 'siga-store')); ?>

                        <div class='input-group date' id='enddate'>
                            <input type='text' class="form-control" placeholder="dd/mm/yyyy"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class='col-md-4 text-center'>
                    <button id="btn_get_encs" type="button" class="btn btn-block btn-primary" style="margin-top: 20px;"><?php printf(__('get_orders_lbl', 'siga-store')); ?> </button>
                </div>
            </div>

            <div class="">
                <table id="myTableOrders" class="table table-bordered table-condensed">
                    <thead>
                    <tr>
                        <th class="text-center"><?php printf(__('order_date_lbl', 'siga-store')); ?></th>
                        <th class="text-center"><?php printf(__('order_number_lbl', 'siga-store')); ?></th>
                        <th class="text-center"><?php printf("Descrição"); ?></th>
                        <th class="text-center"><?php printf(__('order_status_lbl', 'siga-store')); ?></th>
                        <th class="text-center"><?php printf(__('order_action_lbl', 'siga-store')); ?></th>
                    </tr>
                    </thead>
                    <tbody id="myorders_list"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--change pass form-->
<div id="change-pass-modal" tabindex="-1" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog"  style="width: 345px!important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="text-danger fa fa-times"></i></button>
                <h3 class="text-center"><?php printf(__('change_pass_lbl', 'siga-store')); ?></h3>
            </div>
            <div class="modal-body">
                <div class="container" style="width: 100%;">
                    <div class="row">
                        <div class="col-md-12">
                            <form>
                                <div class="form-group">
                                    <label><?php printf(__('current_pass_lbl', 'siga-store')); ?>:</label>
                                    <input id="current-pass" type="password" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label><?php printf(__('new_pass_lbl', 'siga-store')); ?>:</label>
                                    <input id="new-pass" type="password" class="form-control"/>
                                </div>
                                <div class="form-group">
                                    <label><?php printf(__('confirm_new_pass_lbl', 'siga-store')); ?>:</label>
                                    <input id="confirm-new-pass" type="password" class="form-control"/>
                                </div>
                                <button type="submit" id="pass-btn" class="btn btn-primary btn-sm left-block"><?php printf(__('prod_action_lbl', 'siga-store')); ?></button>
                                <button type="reset" value="Reset" class="btn btn-warning btn-sm"><?php printf(__('remove_cart_lbl', 'siga-store')); ?></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>

<div id="myModal_Orders" tabindex="-1" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">

                <div class="modal-body-header" style="padding: 15px;">
                    <div id="clientEncModal" style="padding-bottom: 10px;"></div>
                    <div style="padding-bottom: 10px;"><?php printf(__('order_art_title_lbl', 'siga-store')); ?>: <span id="encId"></span></div>
                    <button class="btn btn-primary print-this" style="margin-bottom: 15px;"><?php printf(__('imprimir_label', 'siga-store')); ?></button>
                </div>

                <div class="panel panel-default list-group-panel" style="border: 0;" id="printContent">
                    <div class="panel-body" style="padding: 0;">
                        <div class="row">
                            <div class="col-md-6">
                                <div id="imgEnc">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div id="clientEncName"></div>
                                <div id="clientEncNa">
                                    <?php printf(__('encomenda_lbl', 'siga-store')); ?>: <span id="clientEnc"></span>
                                </div>
                            </div>
                        </div>
                        <table id="myEncArts" class="list_enc_art table" style="width: 100%;"></table>
                        <div class="text-right enc-total">
                            <?php printf(__('prod_total_lbl', 'siga-store')); ?>: &euro; <span id="totalMyEncArts"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="cleanCartModal" tabindex="-1" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width: 400px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h3><?php printf(__('remove_item_double_sure', 'siga-store')); ?></h3>

                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default btn-lg remove-cart"><?php printf(__('yes_option_lbl', 'siga-store')); ?></button>
                    <button type="button" class="btn btn-default btn-lg " data-dismiss="modal" aria-label="Close"><?php printf(__('no_option_lbl', 'siga-store')); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="cleanItemModal" tabindex="-1" class="modal fade" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width: 400px !important;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h3><?php printf(__('remove_item_sure', 'siga-store')); ?></h3>

                <div class="btn-group" role="group" aria-label="...">
                    <button type="button" class="btn btn-default btn-lg remove-click-item"><?php printf(__('yes_option_lbl', 'siga-store')); ?></button>
                    <button type="button" class="btn btn-default btn-lg" data-dismiss="modal" aria-label="Close"><?php printf(__('no_option_lbl', 'siga-store')); ?></button>
                </div>
            </div>
        </div>
    </div>
</div>