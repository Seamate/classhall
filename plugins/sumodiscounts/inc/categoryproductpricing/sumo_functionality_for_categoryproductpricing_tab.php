<?php

class CategoryProductPricingFunctionalities {

    public static function sp_alter_product_price_as_per_category_product_type( $price , $product ) {

        $user_id    = get_current_user_id() ;
        $product_id = sumo_sd_get_product_id( $product ) ;

        $price = SUMO_Functionality_for_Category_Discount::apply_discount( $price , $product , $product_id ) ;
        return $price ;


//        return max( $price , 0 ) ;
    }

}
