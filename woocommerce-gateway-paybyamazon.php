<?php
/*
Plugin Name: Pay By Amazon
Description: Pay by Amazon for payment methods.
Version: 1.0
Author: Zarrar aka Zony
*/
defined( 'ABSPATH' ) or die( 'Nope, not accessing this' );
define( 'MY_PLUGIN_PATH_FOR_AmazonPay', plugin_dir_path( __FILE__ ) );
define( 'Plugin_Unique_Id', 'woo_amazonpayid' );

 //scripts
add_action( 'wp_enqueue_scripts', 'script_loader');
function script_loader(){
    wp_enqueue_script(Plugin_Unique_Id.'js1', 'https://static-na.payments-amazon.com/OffAmazonPayments/us/sandbox/js/Widgets.js',false);
    wp_enqueue_script(Plugin_Unique_Id.'js', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js',false);
}

add_filter('woocommerce_payment_gateways', 'woocommerce_add_gateway_amazonpay_gateway' );
function woocommerce_add_gateway_amazonpay_gateway($methods) {
    $methods[] = 'WC_Gateway_amazonpay';
    return $methods;
}

add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ),'amazonpay_add_action_plugin');
function amazonpay_add_action_plugin($links) {
//removed
}

add_action('plugins_loaded', 'woocommerce_gateway_amazonpay');

function woocommerce_gateway_amazonpay() {
    if ( !class_exists( 'WC_Payment_Gateway' ) ) return;

    class WC_Gateway_amazonpay extends WC_Payment_Gateway {

        function __construct() {
            //code removed
        }

        public function init_form_fields(){

            $this->form_fields = array(
                'enabled' => array(
                    'title'         => __('Enable/Disable:', 'woo_amazonpay'),
                    'type'          => 'checkbox',
                    'label'         => __('Pay By Amazon', 'woo_amazonpay'),
                    'default'       => 'no',
                    'description'   => 'Show in the Payment List as a payment option'
                ),
                // Title as displayed on Frontend
                'title' => array(
                    'title'         => __('Title:', 'woo_amazonpay'),
                    'type'          => 'text',
                    'default'       => __('Amazon Pay', 'woo_amazonpay'),
                    'description'   => __('This controls the title which the user sees during checkout.', 'woo_amazonpay'),
                    'desc_tip'      => true
                ),

                //removed

                'MWS_Access_Key' => array(
                    'title'         => __('MWS Access Key:', 'woo_amazonpay'),
                    'type'          => 'text',
                    'description'   => __('Obtained from your Amazon account. You can get these keys by logging into Seller Central and viewing the MWS Access Key section under the Integration tab.', 'woo_amazonpay'),
                    'desc_tip'      => true
                ),
                'mws_secret_key' => array(
                    'title'         => __('MWS Secret Key:', 'woo_amazonpay'),
                    'type'          => 'text',
                    'description'   => __('Obtained from your Amazon account. You can get these keys by logging into Seller Central and viewing the MWS Access Key section under the Integration tab.', 'woo_amazonpay'),
                    'desc_tip'      => true
                ),
                'app_client_id' => array(
                    'title'         => __('App Client ID:', 'woo_amazonpay'),
                    'type'          => 'text',
                    'description'   => __(''),
                    'desc_tip'      => false
                ),
                'app_client_secret' => array(
                    'title'         => __('App Client Secret:', 'woo_amazonpay'),
                    'type'          => 'text',
                    'description'   => __(''),
                    'desc_tip'      => false
                ),
                'advanced_configuration' => array(
                'title'       => __( 'Advanced configurations', 'woo_amazonpay' ),
                'type'        => 'title',
                ),

                //removed
                'thankyou_message' => array(
                'title'       => __( 'Order Thank you page message', 'woo_amazonpay' ),
                'type'        => 'text',
                'description' => __( 'This controls the description which the user sees during checkout.', 'woo_amazonpay' ),
                'default'     => 'Pay with Gateway Name.',
                'desc_tip'    => true
              ),
            );

        }

        function receipt_page($order){
            echo '
            <p><strong>' . __('Thank you for your order.', 'woo_amazonpay').'</strong><br/>' . __('Please click below button to pay for your order', 'woo_amazonpay').'</p>';
            echo $this->generate_amazonpay_form($order);

        }

        public function generate_amazonpay_form($order_id){
            set_transient('tokenize',md5(uniqid(mt_rand(), true)),60*10);
            global $woocommerce;
            //code removed
        }

        function process_payment($order_id){
            global $woocommerce;
            $order = new WC_Order($order_id);

            if($order->get_status() != 'pending'){
                $order->update_status('pending');
            }
            //code removed
        }

        function check_amazonpay_response(){
            $data = $_GET;
            $settingopt = get_option("woocommerce_woo_amazonpay_settings");
            $returnURL         = add_query_arg( 'wc-api', 'WC_Gateway_amazonpay', get_site_url() . "/" );
            //code removed
            wp_redirect( $redirect_url );
            exit;

        }

    }

}




