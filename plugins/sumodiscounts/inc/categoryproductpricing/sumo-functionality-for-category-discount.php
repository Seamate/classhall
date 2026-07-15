<?php

if( ! defined( 'ABSPATH' ) ) {
    exit ; // Exit if accessed directly.
}
if( ! class_exists( 'SUMO_Functionality_for_Category_Discount' ) ) {

    /**
     * SUMO_Functionality_for_Category_Discount.
     */
    class SUMO_Functionality_for_Category_Discount {

        /**
         * Matched Rules.
         */
        protected static $matched_rules ;

        /**
         * Matched Priority.
         */
        protected static $matched_priority = "" ;

        /**
         * Cache Value.
         */
        protected static $cached_data = array() ;

        /**
         * Discount Matching Rule.
         */
        public static function discount_matching_rules() {

            if( ! empty( self::$matched_rules ) )
                return self::$matched_rules ;

            self::$matched_rules = array() ;

            $category_rule_array = get_option( 'sumo_pricing_rule_fields_for_cat_pro' , true ) ;

            if( empty( $category_rule_array ) || ! is_array( $category_rule_array ) )
                return self::$matched_rules ;

            foreach( $category_rule_array as $unique_id => $values ) {

                /* Rule enabled or not */
                if( empty( $values[ 'sumo_enable_the_rule' ] ) )
                    continue ;

                $rule_from_date = ! empty( $values[ 'sumo_pricing_from_datepicker' ] ) ? strtotime( $values[ 'sumo_pricing_from_datepicker' ] ) : NULL ;

                $rule_to_date = ! empty( $values[ 'sumo_pricing_to_datepicker' ] ) ? strtotime( $values[ 'sumo_pricing_to_datepicker' ] ) : strtotime( date_i18n( 'd-m-Y' ) ) ;

                /* Rule Matches Days or Not */
                if( ! self::days_filter( $values ) )
                    continue ;


                /* Rule Matches Date or Not */
                if( ! sumo_function_for_date_filter( $rule_from_date , $rule_to_date ) )
                    continue ;


                /* Rule Matches User Filter and its Purchase History or Not */
                if( ! self::user_filter( $values , $unique_id ) )
                    continue ;

                /* Rule Matches Product Filter or Not */
                if( ! empty( $values[ 'sumo_pricing_apply_to_products' ] ) &&
                        $values[ 'sumo_pricing_apply_to_products' ] != '1' &&
                        $values[ 'sumo_pricing_apply_to_products' ] != '4' &&
                        $values[ 'sumo_pricing_apply_to_products' ] != '7' ) {

                    if( empty( $values[ 'sumo_pricing_apply_to_include_products' ] ) &&
                            empty( $values[ 'sumo_pricing_apply_to_exclude_products' ] ) &&
                            empty( $values[ 'sumo_pricing_apply_to_include_category' ] ) &&
                            empty( $values[ 'sumo_pricing_apply_to_exclude_category' ] ) &&
                            empty( $values[ 'sumo_pricing_apply_to_include_tag' ] ) &&
                            empty( $values[ 'sumo_pricing_apply_to_exclude_tag' ] ) ) {

                        continue ;
                    }
                }

                self::$matched_rules [ $unique_id ] = $values ;
            }
        }

        /**
         * Days Filter.
         */
        public static function days_filter( $values ) {

            $current_day = strtolower( date( 'l' ) ) ;

            $week_days = array( 'monday' , 'tuesday' , 'wednesday' , 'thursday' , 'friday' , 'saturday' , 'sunday' ) ;

            foreach( $week_days as $day ) {

                if( $current_day == $day )
                    if( isset( $values[ 'sumo_pricing_rule_week_' . $day ] ) )
                        return true ;
            }

            return false ;
        }

        /**
         * User Filter.
         */
        public static function user_filter( $values , $unique_id ) {

            $user_id = is_user_logged_in() ? get_current_user_id() : 0 ;

            $newarray_for_user_and_userrole_check = array(
                'check_type'         => $values[ 'sumo_pricing_apply_for_user_type' ] ,
                'included_users'     => isset( $values[ 'sumo_pricing_apply_to_include_users' ] ) ? $values[ 'sumo_pricing_apply_to_include_users' ] : '' ,
                'excluded_users'     => isset( $values[ 'sumo_pricing_apply_to_exclude_users' ] ) ? $values[ 'sumo_pricing_apply_to_exclude_users' ] : '' ,
                'included_userroles' => isset( $values[ 'sumo_pricing_apply_to_include_users_role' ] ) ? $values[ 'sumo_pricing_apply_to_include_users_role' ] : array() ,
                'excluded_userroles' => isset( $values[ 'sumo_pricing_apply_to_exclude_users_role' ] ) ? $values[ 'sumo_pricing_apply_to_exclude_users_role' ] : array() ,
                    ) ;

            $merge_array = array( 'include_membership_plans' => isset( $values[ 'sumo_pricing_apply_to_include_memberplans' ] ) ? $values[ 'sumo_pricing_apply_to_include_memberplans' ] : array() ) ;

            $check_user_or_member = class_exists( 'SUMOMemberships' ) && sumo_get_membership_levels() ? array_merge( $newarray_for_user_and_userrole_check , $merge_array ) : $newarray_for_user_and_userrole_check ;

            return self::check_user_filter_and_purchase_history( $user_id , $unique_id , $check_user_or_member , $values ) ;
        }

        /**
         * Check User Filter and Purchase History.
         */
        public static function check_user_filter_and_purchase_history( $userid , $uniq_id , $newarray , $rule ) {

            if( check_for_user_purchase_history( $rule , $rule[ 'sumo_user_purchase_history' ] , $rule[ 'sumo_no_of_orders_placed' ] , $rule[ 'sumo_total_amount_spent_in_site' ] , $userid ) ) {

                if( $newarray[ 'check_type' ] == '1' ) {

                    return true ;
                } elseif( $newarray[ 'check_type' ] == '2' ) {

                    if( get_userdata( $userid ) ) {

                        $userrole = get_userdata( $userid )->roles ;

                        if( $rule[ 'sumo_pricing_apply_to_user' ] == '1' ) {

                            return true ;
                        } elseif( $rule[ 'sumo_pricing_apply_to_user' ] == '2' ) {

                            $include_users = ! is_array( $newarray[ 'included_users' ] ) ? explode( ',' , $newarray[ 'included_users' ] ) : $newarray[ 'included_users' ] ;

                            if( in_array( $userid , $include_users ) ) {

                                return true ;
                            }
                        } elseif( $rule[ 'sumo_pricing_apply_to_user' ] == '3' ) {

                            $exclude_users = ! is_array( $newarray[ 'excluded_users' ] ) ? explode( ',' , $newarray[ 'excluded_users' ] ) : $newarray[ 'excluded_users' ] ;

                            if( ! in_array( $userid , $exclude_users ) ) {

                                return true ;
                            }
                        } elseif( $rule[ 'sumo_pricing_apply_to_user' ] == '5' ) {

                            $include_userroles = is_array( $newarray[ 'included_userroles' ] ) ? $newarray[ 'included_userroles' ] : array() ;
                            $array_check       = array_intersect( $userrole , $include_userroles ) ;

                            if( ! empty( $array_check ) ) {

                                return true ;
                            }
                        } elseif( $rule[ 'sumo_pricing_apply_to_user' ] == '6' ) {

                            $exclude_userroles = is_array( $newarray[ 'excluded_userroles' ] ) ? $newarray[ 'excluded_userroles' ] : array() ;
                            $array_check       = array_intersect( $userrole , $exclude_userroles ) ;

                            if( empty( $array_check ) ) {

                                return true ;
                            }
                        } elseif( $rule[ 'sumo_pricing_apply_to_user' ] == '7' ) {

                            if( class_exists( 'SUMOMemberships' ) && sumo_get_membership_levels() ) {

                                $plans       = is_array( $newarray[ 'include_membership_plans' ] ) ? $newarray[ 'include_membership_plans' ] : array() ;
                                $new_post_id = sumo_get_member_post_id( $userid ) ;

                                if( $new_post_id > 0 ) {

                                    if( ! empty( $plans ) ) {

                                        foreach( $plans as $plan_id ) {

                                            if( ! sumo_plan_is_already_had( $plan_id , $new_post_id ) ) {

                                                return true ;
                                            }
                                        }
                                    } else {

                                        return true ;
                                    }
                                }
                            }
                        }
                    }
                } else {

                    if( ! get_userdata( $userid ) ) {

                        return true ;
                    }
                }
            }

            return false ;
        }

        /**
         * Get Discount Value.
         */
        public static function get_discount_value( $values , $unique_id , $price ) {

              $price = ( float ) $price;
              $discount_price = ( float ) $values[ 'sumo_discount_value' ];
            
            $altered_price = "" ;

            if( $values[ 'sumo_pricing_type' ] == '1' )  {

                $altered_price = ($price - (($price * $discount_price) / 100)) ;
            } elseif( $values[ 'sumo_pricing_type' ] == '2' ) {

                $altered_price = $price - $discount_price ;
            } else {

                $altered_price = $discount_price ;
            }

            return $altered_price ;
        }

        /**
         * Get Priority Rule.
         */
        public static function get_priority_rule() {

            if( ! empty( self::$matched_priority ) )
                return self::$matched_priority ;

            return self::$matched_priority = get_option( 'sumo_cat_pro_pricing_priority_settings' , true ) ;
        }

        /**
         * Get Discount Price based on Priority.
         */
        public static function get_discount_price_based_on_priority( $price , $discount_values ) {

            if( empty( $discount_values ) )
                return $price ;

            if( self::get_priority_rule() == '1' ) {

                $price = reset( $discount_values ) ;
            } elseif( self::get_priority_rule() == '2' ) {

                $price = end( $discount_values ) ;
            } elseif( self::get_priority_rule() == '3' ) {

                $price = max( $discount_values ) ;
            } elseif( self::get_priority_rule() == '4' ) {

                $price = min( $discount_values ) ;
            }

            return $price ;
        }

        /**
         * Product Filter.
         */
        public static function product_filter( $product_id , $price , $product ) {

            $discount_values = array() ;

            $DataforFreeShipping = array() ;

            foreach( self::$matched_rules as $unique_id => $values ) {

                $product_and_category_check = array(
                    'product_type'      => $values[ 'sumo_pricing_apply_to_products' ] ,
                    'included_products' => isset( $values[ 'sumo_pricing_apply_to_include_products' ] ) ? $values[ 'sumo_pricing_apply_to_include_products' ] : '' ,
                    'excluded_products' => isset( $values[ 'sumo_pricing_apply_to_exclude_products' ] ) ? $values[ 'sumo_pricing_apply_to_exclude_products' ] : '' ,
                    'included_category' => isset( $values[ 'sumo_pricing_apply_to_include_category' ] ) ? $values[ 'sumo_pricing_apply_to_include_category' ] : array() ,
                    'excluded_category' => isset( $values[ 'sumo_pricing_apply_to_exclude_category' ] ) ? $values[ 'sumo_pricing_apply_to_exclude_category' ] : array() ,
                    'included_tag'      => isset( $values[ 'sumo_pricing_apply_to_include_tag' ] ) ? $values[ 'sumo_pricing_apply_to_include_tag' ] : array() ,
                    'excluded_tag'      => isset( $values[ 'sumo_pricing_apply_to_exclude_tag' ] ) ? $values[ 'sumo_pricing_apply_to_exclude_tag' ] : array()
                        ) ;

                if( ! self::apply_discount_for_sale_price_product( $values , $product ) )
                    continue ;

                if( ! sumo_function_for_product_and_category_filter( sumo_dynamic_pricing_product_id_from_other_lang( $product_id ) , $product_and_category_check ) )
                    continue ;

                $altered_price = self::get_discount_value( $values , $unique_id , $price ) ;

                $discount_values[] = $altered_price ;

                $DataforFreeShipping[ $altered_price ] = $unique_id ;
            }

            if( ! is_admin() && is_object(WC()->session)):
                WC()->session->set( 'applied_catpro_discount_rule_id' , $DataforFreeShipping ) ;
            endif ;

            return $discount_values ;
        }

        /**
         * Apply Discount for Sale Price Products.
         */
        public static function apply_discount_for_sale_price_product( $values , $product ) {

            if( $product->get_sale_price() > 0 && empty( $values[ 'sumo_apply_this_rule_for_sale' ] ) )
                return false ;

            return true ;
        }

        /**
         * Apply Discount.
         */
        public static function apply_discount( $price , $product , $product_id ) {

            $hash_value = self::get_hash( $price , $product_id ) ;

            /* Discount for Matched Hash Value */
            if( isset( self::$cached_data[ $product_id ][ 'hash' ] ) && self::$cached_data[ $product_id ][ 'hash' ] == $hash_value ) {

                return self::$cached_data[ $product_id ][ 'price' ] ;
            }

            self::discount_matching_rules() ;

            if( empty( self::$matched_rules ) )
                return $price ;

            $discount_values = self::product_filter( $product_id , $price , $product ) ;

            $discounted_price = self::get_discount_price_based_on_priority( $price , $discount_values ) ;

            /* Generating Hash Value for Discounted Price */
            $hash_value = self::get_hash( $discounted_price , $product_id ) ;

            $hash = array( 'price' => $discounted_price , 'hash' => $hash_value ) ;

            /* Data Cached to reduce Page Load Time */
            self::$cached_data[ $product_id ] = $hash ;

            return $discounted_price ;
        }

        /**
         * Get Hash Value.
         */
        public static function get_hash( $price , $product_id ) {

            $hash_data = array( $price , $product_id ) ;

            /* md5 - Message Digest Algorithm for cryptographic hash function */
            $hash_value = md5( json_encode( $hash_data ) ) ;

            return $hash_value ;
        }

    }

}
