<?php

use WDRPro\App\Rules\BOGO;
use WDRPro\App\Rules\BuyXGetX;
use WDRPro\App\Rules\BuyXGetY;
use Wdr\App\Controllers\Configuration;

if ( ! defined('ABSPATH')) {
    exit;
} // Exit if accessed directly

class WC_Phone_Flycart_Pricing_Compatibility
{

    private $dont_apply_pricing_rules;

    public function __construct($apply_pricing_rules)
    {
        $this->dont_apply_pricing_rules = $apply_pricing_rules;

        if (self::isActive()) {
            $config = get_option(Configuration::DEFAULT_OPTION, []);
            if ($config['suppress_other_discount_plugins'] !== 0) {
                $config['suppress_other_discount_plugins'] = 0;
                Configuration::saveConfig(Configuration::DEFAULT_OPTION, $config);
            }

            if (class_exists(BOGO::class)) {
                BOGO::removeAppliedDiscount();
            }

            add_filter( 'wpo_skip_add_to_cart_item', function ( $skip, $item ) {
                if(isset($item["variation"]["wdr_free_product"]) && $item["variation"]["wdr_free_product"] == "Free" ) {
                    $skip = true;
                }
                return $skip;
            }, 10, 2 );

            add_filter('wpo_add_configured_products_skip_item', function ($skip, $item_data) {
                if(isset($item_data["variation"]["wdr_free_product"]) && $item_data["variation"]["wdr_free_product"] == "Free" ) {
                    $skip = true;
                }
                return $skip;
            }, 10, 2);


            add_filter('wpo_load_order_skip_item', function($skip, $order_item, $order){
                if( $order_item->get_meta("wdr_free_product") ) {
                    $skip = true;
                }
                return $skip;
            }, 10,3);

            add_filter("wpo_process_cart_data_prepare", function($cart_data){
                foreach($cart_data['items'] as $k=>$v){
                    if( isset($v['variation_data']['wdr_free_product']))
                        unset($cart_data['items'][$k]);

                    foreach($v["custom_meta_fields"] as $meta_field) {
                        if(isset($meta_field["meta_key"]) && $meta_field["meta_key"] == "wdr_free_product") {
                            unset($cart_data['items'][$k]);
                            break;
                        }
                    }
                }
                return $cart_data;
            });

            add_filter('wpo_update_cart_item', function($item){
                if( isset($item['wdr_free_product']) ) {
                    $item['is_readonly_price'] = true;
                    $item['is_readonly_qty'] = true;
                    $item['is_allow_delete'] = false;
                }
                return $item;
            });

            if (class_exists(BuyXGetY::class) && $this->dont_apply_pricing_rules) {
                remove_action('advanced_woo_discount_rules_discounts_of_each_rule', array(BuyXGetY::class, 'setBXGYDiscountValue'), 10, 9);
            }

            if (class_exists(BuyXGetX::class) && $this->dont_apply_pricing_rules) {
                remove_action('advanced_woo_discount_rules_discounts_of_each_rule', array(BuyXGetX::class, 'setBXGXDiscountValue'), 10, 9);
            }

        }
    }


    public static function isActive()
    {
        return defined('WDR_VERSION');
    }
}
