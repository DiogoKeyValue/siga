<?php
/*
Plugin Name:  siga-store
Plugin URI:   https://developer.wordpress.org/plugins/the-basics/
Description:  Plugin loja do siga
Version:      1.0
Author:       Expandindústria, SA
Author URI:   https://www.expandindustria.pt/
Text Domain:  siga-store
*/

/**
 * @param $atts
 */
function siga_store_shortcode_show_html($atts){
    ?>
    <script type="text/javascript" src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.1/js/bootstrap-datepicker.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="<?php echo plugins_url('/', __FILE__);?>public/style.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.1/css/datepicker.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.1/css/datepicker3.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />

    <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

    <?php include('public/siga_store_login.php');
}

add_shortcode('siga_store_shortcode','siga_store_shortcode_show_html');

/**
 *
 */
function load_siga_store_textdomain() {
    $path   = basename( dirname( __FILE__ ) );
    $loaded = load_plugin_textdomain( 'siga-store', false, $path);
    if ( ! $loaded ) {
        print "File not found $path";
    }
}
add_action( 'plugins_loaded', 'load_siga_store_textdomain' );

function addMenuSS (){
    add_menu_page("Siga Store","Siga Store",'manage_options',"siga-store","plugMenuSS","dashicons-cart");
    add_submenu_page("siga-store",(__( 'settings_page_title_lbl', 'siga-store' )),(__( 'settings_page_title_lbl', 'siga-store' )),'manage_options','siga-store-settings',"subMenuSS01");
}
add_action("admin_menu","addMenuSS");

/**
 *
 */
function plugMenuSS(){
    $html='<div class="wrap" id="siga-store">';
    $html.='<h1>Siga Store</h1> 
		    <div class="notice inline notice-info">
		        <h3>Welcome to Siga Store</h3>
		        <p>If you have any questions, please contact <a href="http://www.expandindustria.pt/">Us</a>.</p>
		        <p>To activate this plugin please insert this shortcode: [siga_store_shortcode]</p>
		    </div>';
    $html.='</div>';
    echo $html;
}

function subMenuSS01(){
    echo "<h2>".(__( 'settings_page_title_lbl', 'siga-store' ))."</h2>";
    include_once('siga_store_settings.php');
}

?>