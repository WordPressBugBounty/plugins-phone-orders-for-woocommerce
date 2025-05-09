<?php

if ( ! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class WC_Phone_Orders_Help_Page extends WC_Phone_Orders_Admin_Abstract_Page
{
    public $title;
    public $priority = 60;
    protected $tab_name = 'help';

    public function __construct()
    {
        parent::__construct();
        $this->title = __('Help', 'phone-orders-for-woocommerce');
    }

    private function tab_help_question_response($question, $answer)
    {
        return array(
            'question' => $question,
            'answer'   => $answer,
        );
    }

    public function render()
    {
        $this->tab_data = array(
            'title' => __('Short FAQ', 'phone-orders-for-woocommerce'),
            'note' => __(
                          'Need help? Submit ticket to',
                          'phone-orders-for-woocommerce'
                      ) . ' <a href="https://algolplus.freshdesk.com" target=_blank>' . __(
                          'helpdesk system',
                          'phone-orders-for-woocommerce'
                      ) . '</a>.',
            'questions' => array(
                $this->tab_help_question_response(
                    __('How to set default country/state for new customers?', 'phone-orders-for-woocommerce'),
                    sprintf(
                    // translators: Message about the purchase of the pro version
                    __('You should buy <a href=%s target=_blank>Pro version</a>.', 'phone-orders-for-woocommerce'),
                        'https://algolplus.com/plugins/downloads/phone-orders-woocommerce-pro/?currency=USD'
                    )
                ),
                $this->tab_help_question_response(
                    __(
                        'I can\'t add new customer, I see popup with message “Please enter an account password”',
                        'phone-orders-for-woocommerce'
                    ),
                    __(
                        'Please, visit >Woocommerce>Settings, select tab “Accounts & Privacy” and mark checkbox “When creating an account, automatically generate an account password”.',
                        'phone-orders-for-woocommerce'
                    )
                ),
                $this->tab_help_question_response(
                    __('I don\'t see Free Shipping [Phone Orders] in popup', 'phone-orders-for-woocommerce'),
                    __(
                        'Please, visit >WooCommerce>Settings>Shipping and add shipping method for necessary zones.',
                        'phone-orders-for-woocommerce'
                    )
                ),
                $this->tab_help_question_response(
                    __('How to pay order?', 'phone-orders-for-woocommerce'),
                    sprintf(
                        // translators: Message about the purchase of the pro version
                        __(
                            '<a href=%1$s target=_blank>Pro version</a> allows you to pay as customer, via checkout page. You can pay directly from admin area too – use <a href=%2$s target=_blank>this free plugin</a>. They support Stripe and Authorize.Net.',
                            'phone-orders-for-woocommerce'
                        ),
                        'https://algolplus.com/plugins/downloads/phone-orders-woocommerce-pro/?currency=USD',
                        'https://wordpress.org/plugins/woo-mp/'
                    )
                ),
                $this->tab_help_question_response(
                // translators: A message stating button "Create Order" does nothing
                __('Button "Create Order" does nothing', 'phone-orders-for-woocommerce'),
                    sprintf(
                        // translators: A message conflict with another plugin
                        __(
                            'Probably, there is a conflict with another plugin. <a href=%s target=_blank>Please, check javascript errors at first</a>.',
                            'phone-orders-for-woocommerce'
                        ),
                        'https://wordpress.org/support/article/using-your-browser-to-diagnose-javascript-errors/#step-3-diagnosis'
                    )
                ),
                $this->tab_help_question_response(
                    // translators: Headings of information that may be in the documentation
                    __('Compatibility/Code samples/Pro version', 'phone-orders-for-woocommerce'),
                    sprintf(
                        // translators: A message documentation topics
                        __(
                            'Please, review these topics in <a href=%s target=_blank>our documentation</a>.',
                            'phone-orders-for-woocommerce'
                        ),
                        'https://docs.algolplus.com/category/algol_phone_order/'
                    )
                ),
            ),
        );
        ?>
        <tab-help v-bind="<?php
        echo esc_attr(json_encode($this->tab_data)) ?>"></tab-help>
        <?php
    }
}
