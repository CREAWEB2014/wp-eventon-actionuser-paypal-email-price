<?php

/**
 *  Extending your Action User Addon of EVentON plugin in Wordpress
 *  This is add two new Field called Paypal Email and Selling price
 * 
 */


add_action('evoau_save_formfields',  'anileventon_paypal_save_values', 10, 3);

function anileventon_paypal_save_values($field, $fn, $created_event_id)
{
    if( $field == 'anilpaypalemail')
    {
        $customEventonPaypalEmail = 'anilpaypalemail';
        $eventonPaypalEmail = 'evcal_paypal_email';
        
        if( !empty($_POST[$customEventonPaypalEmail]) )
        {
            if ( ! add_post_meta( $created_event_id, $eventonPaypalEmail, $_POST[$customEventonPaypalEmail], true ) ) { 
               update_post_meta( $created_event_id, $eventonPaypalEmail, $_POST[$customEventonPaypalEmail] );
            }
            if ( ! add_post_meta( $created_event_id, $customEventonPaypalEmail, $_POST[$customEventonPaypalEmail], true ) ) { 
               update_post_meta( $created_event_id, $customEventonPaypalEmail, $_POST[$customEventonPaypalEmail] );
            }
        }
    }
    if( $field == 'anilpaypalemailprice')
    {
        $customEventonPaypalEmailPrice = 'anilpaypalemailprice';
        $eventonPaypalEmailPrice = 'evcal_paypal_item_price';
        
        if( !empty($_POST[$customEventonPaypalEmailPrice]) )
        {
            if ( ! add_post_meta( $created_event_id, $eventonPaypalEmailPrice, $_POST[$customEventonPaypalEmailPrice], true ) ) { 
               update_post_meta( $created_event_id, $eventonPaypalEmailPrice, $_POST[$customEventonPaypalEmailPrice] );
            }
            if ( ! add_post_meta( $created_event_id, $customEventonPaypalEmailPrice, $_POST[$customEventonPaypalEmailPrice], true ) ) { 
               update_post_meta( $created_event_id, $customEventonPaypalEmailPrice, $_POST[$customEventonPaypalEmailPrice] );
            }
        }
    }
}

add_filter('evoau_form_fields', 'anileventon_paypal_fields_to_form', 10, 1);
function anileventon_paypal_fields_to_form($array){
    $array['anilpaypalemail']=array('ExtPaypal Email', 'anilpaypalemail', 'anilpaypalemail','custom','');
    $array['anilpaypalemailprice']=array('ExtPaypal Selling Price', 'anilpaypalemailprice', 'anilpaypalemailprice','custom','');
    return $array;
}
// only for frontend
if(!is_admin()){
    // actionUser intergration
    add_action('evoau_frontform_anilpaypalemail',  'anileventon_paypal_fields', 10, 6);  
}
// Frontend showing fields and saving values  
function anileventon_paypal_fields($field, $event_id, $defaultVal, $EPMV, $opt2, $lang){
    
    $helper = new evo_helper();

    $customEventonPaypalEmail = 'anilpaypalemail';
    $eventonPaypalEmail = 'evcal_paypal_email';
    $PlaceholderPaypalEmail = 'Paypal Email';

    $customEventonPaypalEmailPrice = 'anilpaypalemailprice';
    $eventonPaypalEmailPrice = 'evcal_paypal_item_price';
    $PlaceholderPaypalEmailPrice = 'Selling Price($) eg. 23.99 (WITHOUT currency symbol)';

    $customEventonPaypalEmailVal = (!empty($_POST[$customEventonPaypalEmail]))? $_POST[$customEventonPaypalEmail]: null;
    $customEventonPaypalEmailPriceVal = (!empty($_POST[$customEventonPaypalEmailPrice]))? $_POST[$customEventonPaypalEmailPrice]: null;

    if( isset( $EPMV ) ){
        $customEventonPaypalEmailVal = !empty($EPMV[$eventonPaypalEmail])? $EPMV[$eventonPaypalEmail][0]:$customEventonPaypalEmailVal;
        $customEventonPaypalEmailPriceVal = !empty($EPMV[$eventonPaypalEmailPrice])? $EPMV[$eventonPaypalEmailPrice][0]:$customEventonPaypalEmailPriceVal;
    }

    $customEventonPaypalEmailVal = str_replace("'", '"', $customEventonPaypalEmailVal);
    $customEventonPaypalEmailPriceVal = str_replace("'", '"', $customEventonPaypalEmailPriceVal);

    echo '<div class="row anilpaypalemail">

    <p class="label"><label for="anilpaypalemail">'. $PlaceholderPaypalEmail .'</label></p>

    <p><input type="email" name="'. $customEventonPaypalEmail .'" value="'. $customEventonPaypalEmailVal .'" placeholder="'. $customEventonPaypalEmailVal .'" class="fullwidth" />

    </p></div>';

    echo '<div class="row anilpaypalemailprice">

    <p class="label"><label for="anilpaypalemailprice">'. $PlaceholderPaypalEmailPrice .'</label></p>

    <p><input type="text" name="'. $customEventonPaypalEmailPrice .'" value="'. $customEventonPaypalEmailPriceVal .'" placeholder="'. $customEventonPaypalEmailPriceVal .'" class="" />

    </p></div>';
}

