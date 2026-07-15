<?php

// Common Function to add setting for Rule
function sumo_common_function_to_add_settings_for_rule( $array ) {
// Discounts Rule Options
    $i              = 0 ;
    ?>
    <script type="text/javascript">
        jQuery( function() {
            jQuery( '#accordion' ).accordion( {
                header : "> div > h3" ,
                collapsible : true ,
                heightStyle : "content"
            } ).sortable( {
                axis : "y" ,
                handle : "h3" ,
                update : function( event , ui ) {

                    var data = jQuery( this ).sortable( "toArray" ) ;
                    // POST to server using $.post or $.ajax
                    console.log( data ) ;
                    jQuery.ajax( {
                        data : ( {
                            action : '<?php echo $array[ 'actionforsorting' ] ; ?>' ,
                            data : data ,
                        } ) ,
                        type : 'POST' ,
                        url : "<?php echo admin_url( 'admin-ajax.php' ) ; ?>" ,
                        success : function( response ) {
                            console.log( response ) ;
                        } ,
                    } ) ;
                } ,
                stop : function( event , ui ) {
                    // IE doesn't register the blur when sorting
                    // so trigger focusout handlers to remove .ui-state-focus
                    ui.item.children( "h3" ).triggerHandler( "focusout" ) ;

                    // Refresh accordion to handle new order
                    jQuery( this ).accordion( "refresh" ) ;
                }
            } ) ;

            jQuery( 'p.form-field span.dashicons-info' ).tipTip() ;
        } ) ;
    </script>
    <script type="text/javascript">
        jQuery( function() {

            jQuery( 'table' ).sortable( {
                axis : "y" ,
                items : "tbody" ,
                update : function( event , ui ) {

                    var data = jQuery( this ).sortable( "toArray" ) ;
                    // POST to server using $.post or $.ajax
                    console.log( data ) ;
                    jQuery.ajax( {
                        data : ( {
                            action : '<?php echo $array[ 'actionforsorting' ] ; ?>' ,
                            data : data ,
                        } ) ,
                        type : 'POST' ,
                        url : "<?php echo admin_url( 'admin-ajax.php' ) ; ?>" ,
                        success : function( response ) {
                            console.log( response ) ;
                        } ,
                    } ) ;
                }
            } ) ;
        } ) ;</script>
    <style type="text/css">

        p.form-field span.dashicons-info {
            color:lightsteelblue;
            cursor:help;
        }

        tbody#here >tr {
            border: 1px solid #ccc;
        }


        .postbox h3 {
            font-size: 14px;
            line-height: 1.4;
            margin: 0;
            padding: 8px 12px;
        }
        .form-field label {
            display:table-row;
            font-weight:  bold;
            font-size:14px;

        }

        .form-field input[type="text"]{
            max-width:350px;


        }
        .form-field input[type="number"]{
            max-width:350px;
        }

    </style>

    <style type="text/css">
        .sumo_discounts_wrapper{
            width:90%;
            padding:10px;
            background:#bbb;
            // min-height:600px;
            padding-bottom:50px;


        }
    </style>
    <style type="text/css">
        tbody.newrow {
            background:#fff;
            margin-bottom:10px;
            display: flex;
        }
        table>tbody.newrow:hover {
            background:#dedec6;
        }
    </style>
    <div class="sumo_discounts_wrapper">
        <div id="accordion">
            <?php
            $get_saved_data = $array[ 'get_saved_data' ] ;
            if( is_array( $get_saved_data ) && ! empty( $get_saved_data ) ) {
                foreach( $get_saved_data as $key => $value ) {
                    $tab_name  = isset( $value[ 'sumo_dynamic_rule_name' ] ) ? $value[ 'sumo_dynamic_rule_name' ] : '' ;
                    $rule_name = $tab_name != '' ? $tab_name : "(untitled)" ;
                    ?>
                    <div class="group" id="<?php echo $key ; ?>">
                        <h3><?php echo $rule_name ; ?>   <span class="remove button" title="<?php echo __( 'Remove this Rule' , 'sumodiscounts' ) ?>" style="position:absolute;right:13px;top:3px;">X</span></h3>
                        <div>
                            <?php echo display_data_after_saved( $key , $array[ 'pricing_type' ] , $array[ 'nameforinputfield' ] ) ; ?>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="add button-primary" style="float:right; margin:10px;"><?php _e( 'Add Rule' , 'sumodiscounts' ) ; ?></div>
    </div>
    <script>
        jQuery( document ).ready( function() {
            var countrewards_dynamic_rule ;
            jQuery( ".add" ).click( function() {

                jQuery( '.sumo_discounts_wrapper' ).block() ;
                countrewards_dynamic_rule = Math.round( new Date().getTime() + ( Math.random() * 100 ) ) ;
                jQuery.ajax( {
                    data : ( {
                        action : '<?php echo $array[ 'actionforaddrule' ] ; ?>' ,
                        uniq_id : countrewards_dynamic_rule
                    } ) ,
                    type : 'POST' ,
                    url : "<?php echo admin_url( 'admin-ajax.php' ) ; ?>" ,
                    success : function( response ) {
                        // console.log(response);
                        jQuery( '#accordion' ).append( '<div class="group" id=' + countrewards_dynamic_rule + '><h3><?php echo __( '(Untitled)' , 'sumodiscounts' ) ?><span class="remove button" title="<?php echo __( 'Remove this Rule' , 'sumodiscounts' ) ?>" style="position:absolute;right:13px;top:3px;">X</span></h3><div>' + response + '</div></div>' ) ;
                        jQuery( 'body' ).trigger( 'wc-enhanced-select-init' ) ;
                        jQuery( '#accordion' ).accordion( "refresh" ) ;
                        jQuery( '.sp_date' ).datepicker( {
                            dateFormat : "dd-mm-yy"
                        } ) ;
                        jQuery( '.sp__date' ).datepicker( {
                            dateFormat : "yy-mm-dd" ,
                            maxDate : new Date()

                        } ) ;
                        jQuery( '.sumo_discounts_wrapper' ).unblock() ;
                        jQuery( 'p.form-field span.dashicons-info' ).tipTip() ;
                    }

                } ) ;
                jQuery( document ).on( 'click' , '.<?php echo $array[ 'classforaddlocalrule' ] ; ?>' + countrewards_dynamic_rule , function() {
                    jQuery.ajax( {
                        data : ( {
                            action : '<?php echo $array[ 'actionforaddrule' ] ; ?>' ,
                            rule_type : '<?php echo $array[ 'pricing_type' ] ; ?>' ,
                            uniq_id : countrewards_dynamic_rule ,
                        } ) ,
                        type : 'POST' ,
                        url : "<?php echo admin_url( 'admin-ajax.php' ) ; ?>" ,
                        success : function( response ) {
                            jQuery( '.sumo_pricing_rule_for_<?php echo $array[ 'pricing_type' ] ?>' + countrewards_dynamic_rule ).append( response ) ;
                        }

                    } ) ;
                } ) ;
                return false ;

            } ) ;

            jQuery( document ).on( 'click' , '.remove' , function() {
                jQuery( this ).parent().parent().remove() ;
            } ) ;

            jQuery( document ).on( 'click' , '.delete_row' , function() {

                jQuery( this ).parent().remove() ;
            } ) ;

            // Add New Row for adding min max quantity
            console.log( countrewards_dynamic_rule ) ;

        } ) ;
    </script>
    <?php
    wp_enqueue_script( 'date_picker_initialize' ) ;
}

// Get the function html to the quantity rule

function local_rule_function( $array ) {
    $get_list_of_array = generate_dynamic_rule_pricing_fields( $array[ 'rule_type' ] ) ;
    $nameforinputfield = $array[ 'nameforinputfield' ] ;
    ob_start() ;
    foreach( $get_list_of_array as $key => $new_fields ) {
        ?>
        <p class="form-field" style="display: flex;">
            <label>
                <?php echo $new_fields[ 'label' ][ 0 ] ; ?>
            </label>
            <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 0 ] ; ?>"></span>
            <?php if( $array[ 'rule_type' ] == 'specialoffer' ) { ?>
                <input type="number" min="1" step="1" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $array[ 'unique_id' ] ; ?>][<?php echo $array[ 'nameforfields' ] ; ?>][<?php echo $array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 0 ] ; ?>]" value=""/>
            <?php } else { ?>
                <input type="text" required="required" class="sumo_number_input" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $array[ 'unique_id' ] ; ?>][<?php echo $array[ 'nameforfields' ] ; ?>][<?php echo $array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 0 ] ; ?>]" value=""/>
            <?php } ?>
            <label>
                <?php echo $new_fields[ 'label' ][ 1 ] ; ?>
            </label>
            <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 1 ] ; ?>"></span>
            <?php if( $array[ 'rule_type' ] == 'specialoffer' ) { ?>
                <input type="number"  min="1" step="1" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $array[ 'unique_id' ] ; ?>][<?php echo $array[ 'nameforfields' ] ; ?>][<?php echo $array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 1 ] ; ?>]" value=""/>
            <?php } else { ?>
                <input type="text"  required="required" class="sumo_number_input" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $array[ 'unique_id' ] ; ?>][<?php echo $array[ 'nameforfields' ] ; ?>][<?php echo $array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 1 ] ; ?>]" value=""/>
            <?php } ?>
            <label>
                <?php echo $new_fields[ 'label' ][ 2 ] ; ?>
            </label>
            <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 2 ] ; ?>"></span>
            <select name="<?php echo $nameforinputfield ; ?>[<?php echo $array[ 'unique_id' ] ; ?>][<?php echo $array[ 'nameforfields' ] ; ?>][<?php echo $array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 2 ] ; ?>]">
                <option value="1"><?php _e( '% Discount' , 'sumodiscounts' ) ; ?></option>
                <option value="2"><?php _e( 'Fixed Discount' , 'sumodiscounts' ) ; ?></option>
                <option value="3"><?php _e( 'Fixed Price' , 'sumodiscounts' ) ; ?></option>
            </select>

            <label>
                <?php echo $new_fields[ 'label' ][ 3 ] ; ?>
            </label>
            <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 3 ] ; ?>"></span>
            <input type="number" min=".01" step="any" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $array[ 'unique_id' ] ; ?>][<?php echo $array[ 'nameforfields' ] ; ?>][<?php echo $array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 3 ] ; ?>]" value=""/>
            <?php if( $array[ 'rule_type' ] == 'specialoffer' ) { ?>
                <input type="checkbox" name="<?php echo $nameforinputfield ; ?>[<?php echo $array[ 'unique_id' ] ; ?>][<?php echo $array[ 'nameforfields' ] ; ?>][<?php echo $array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 4 ] ; ?>]" value="yes"/>
                <label>
                    <?php echo $new_fields[ 'label' ][ 4 ] ; ?>
                </label>
                <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 4 ] ; ?>"></span>
            <?php } if( $array[ 'rule_type' ] == 'quantity_pricing' ) { ?>
                <input type="checkbox" name="<?php echo $nameforinputfield ; ?>[<?php echo $array[ 'unique_id' ] ; ?>][<?php echo $array[ 'nameforfields' ] ; ?>][<?php echo $array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 4 ] ; ?>]" value="yes"/>
                <label>
                    <b><?php _e( $new_fields[ 'label' ][ 4 ] , 'sumodiscounts' ) ; ?></b><br><br>
                </label>
            <?php } ?>
            <span class="delete_row button-secondary"><?php _e( 'Delete Row' , 'sumodiscounts' ) ; ?></span>
        </p>
        <script type="text/javascript">
            jQuery( '.sumo_number_input' ).on( "keyup keypress change" , function( e ) {
                var res = this.value.charAt( 0 ) ;
                if( res !== '*' ) {
                    this.value = this.value.replace( /[^0-9\.]/g , '' ) ;
        <?php if( $array[ 'rule_type' ] == 'quantity_pricing' ) { ?>
                        this.value = this.value.replace( '.' , '' ) ;
                        if( this.value < 1 ) {
                            this.value = '' ;
                        }
        <?php } else { ?>
                        if( this.value < 0.01 ) {
                            this.value = '' ;
                        }
        <?php } ?>
                } else {
                    this.value = this.value.replace( /[^*\.]/g , '' ) ;
                }
            } ) ;
        </script>
        <?php
    }
}

function array_to_field_conversion( $new_array ) {
    $get_list_of_array = generate_dynamic_rule_pricing_fields( $new_array[ 'rule_type' ] ) ;
    $nameforinputfield = $new_array[ 'nameforinputfield' ] ;
    ob_start() ;
    foreach( $get_list_of_array as $key => $new_fields ) {
        switch( $new_fields[ 'type' ] ) {
            case 'text':
                ?>
                <p class="form-field">
                    <b><?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><input name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>]" type="<?php echo $new_fields[ 'type' ] ?>" value="" placeholder="<?php echo $new_fields[ 'placeholder' ] ; ?>"/><br><br>
                </p>
                <?php
                break ;
            case 'number':
                ?>
                <p class="form-field">
                    <b><?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><input class="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>]" type="<?php echo $new_fields[ 'type' ] ?>" value="" step="any" min="0.01" placeholder="<?php echo $new_fields[ 'placeholder' ] ; ?>"/><br><br>
                </p>
                <?php
                break ;
            case 'title':
                ?>
                <br>
                <p class="form-field">
                    <b><?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?></b>
                </p>
                <br>
                <?php
                break ;
            case "select":
                ?>
                <p class="form-field">
                    <b><?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select  class="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?>" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>]">
                        <?php foreach( $new_fields[ 'options' ] as $key => $options ) {
                            ?>
                            <option value="<?php echo $key ; ?>"><?php echo $options ; ?></option>
                            <?php
                        }
                        ?>
                    </select><br><br>
                </p>
                <?php
                break ;
            case "checkbox":
                ?>
                <p class="form-field">
                    <b><?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><input type="checkbox" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>]" value="yes"/><br><br>
                </p>
                <?php
                break ;
            case "datepicker":
                ?>
                <p class="form-field" style="display:flex;">
                    <?php
                    $label_one = $new_fields[ 'label' ][ 0 ] ;
                    $label_two = $new_fields[ 'label' ][ 1 ] ;

                    $name_one = $new_fields[ 'name' ][ 0 ] ;
                    $name_two = $new_fields[ 'name' ][ 1 ] ;

                    $tooltip_one = $new_fields[ 'tooltip' ][ 0 ] ;
                    $tooltip_two = $new_fields[ 'tooltip' ][ 1 ] ;
                    ?>
                    <b><?php _e( $label_one , 'sumodiscounts' ) ; ?></b><span class="dashicons dashicons-info" title="<?php echo $tooltip_one ; ?>"></span><input type="text" placeholder="dd-mm-yy" class="sp_date" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $name_one ; ?>]" id="from_<?php echo $new_array[ 'unique_id' ] ; ?>" style="width:200px;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <b><?php _e( $label_two , 'sumodiscounts' ) ; ?></b><span class="dashicons dashicons-info" title="<?php echo $tooltip_two ; ?>"></span><input type="text" placeholder="dd-mm-yy" class="sp_date" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $name_two ; ?>]" id="to_<?php echo $new_array[ 'unique_id' ] ; ?>" style="width:200px;"/>
                </p>
                <?php
                break ;
            case "sumo_uph_datepicker":
                ?>
                <p class="form-field" style="display:flex;">
                    <?php
                    $label_one   = $new_fields[ 'label' ][ 0 ] ;
                    $label_two   = $new_fields[ 'label' ][ 1 ] ;

                    $name_one = $new_fields[ 'name' ][ 0 ] ;
                    $name_two = $new_fields[ 'name' ][ 1 ] ;

                    $tooltip_one  = $new_fields[ 'tooltip' ][ 0 ] ;
                    $tooltip_two  = $new_fields[ 'tooltip' ][ 1 ] ;
                    ?>
                    <b><?php _e( $label_one , 'sumodiscounts' ) ; ?></b><span class="dashicons dashicons-info" title="<?php echo $tooltip_one ; ?>"></span><input type="text" placeholder="yy-mm-dd" class="sp__date" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $name_one ; ?>]" id="sumo_uph_from_datepicker<?php echo $new_array[ 'unique_id' ] ; ?>" style="width:200px;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <b><?php _e( $label_two , 'sumodiscounts' ) ; ?></b><span class="dashicons dashicons-info" title="<?php echo $tooltip_two ; ?>"></span><input type="text" placeholder="yy-mm-dd" class="sp__date" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $name_two ; ?>]" id="sumo_uph_to_datepicker<?php echo $new_array[ 'unique_id' ] ; ?>" style="width:200px;"/>
                </p>
                <?php
                break ;
            case "weekdays":
                $label_name   = $new_fields[ 'label' ] ;
                $option_name  = $new_fields[ 'name' ] ;
                $title_name   = $new_fields[ 'week_days_title' ] ;
                $week_tooltip = $new_fields[ 'tooltip' ] ;
                ?>
                <p class="form-field">
                    <label><?php _e( "$title_name " , 'sumodiscounts' ) ; ?><span class="dashicons dashicons-info" title="<?php echo $week_tooltip ; ?>"></span></label>

                    <?php
                    foreach( $option_name as $key => $eachname ) {
                        ?>
                        <input type="checkbox" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $eachname ; ?>]" value="1" checked="checked"/> <?php echo $new_fields[ 'label' ][ $key ] ; ?><br>
                        <?php
                    }
                    ?>
                </p>
                <?php
                break ;
            case "multiselectincuser":
                global $woocommerce ;
                ?>
                <p class="form-field">
                    <label>
                        <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
                    </label>
                    <?php if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" style="width:343px;" multiple="multiple" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>">
                        </select>
                    <?php } else { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
                        <?php
                        $name = $nameforinputfield . '[' . $new_array[ 'unique_id' ] . '][' . $new_fields[ 'name' ] . ']' ;
                        $id   = $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ;
                        sumo_customer_search( $name , $id ) ;
                    }
                    ?>
                </p>
                <?php
                echo sumo_pricing_common_ajax_function_to_select_user( $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ) ;
                break ;

            case "multiselectexcuser":
                global $woocommerce ;
                ?>
                <p class="form-field">
                    <b>
                        <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
                    </b>
                    <?php if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" style="width:343px;" multiple="multiple" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>">
                        </select>
                    <?php } else { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
                        <?php
                        $name = $nameforinputfield . '[' . $new_array[ 'unique_id' ] . '][' . $new_fields[ 'name' ] . ']' ;
                        $id   = $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ;
                        sumo_customer_search( $name , $id ) ;
                    }
                    ?>
                </p>
                <?php
                echo sumo_pricing_common_ajax_function_to_select_user( $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ) ;
                break ;

            case "multiselect":
                global $woocommmerce ;
                ?>
                <p class="form-field">
                    <b>
                        <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
                    </b>
                    <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" id="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?>" multiple="multiple">
                        <?php
                        if( is_array( $new_fields[ 'options' ] ) ) {
                            if( ! empty( $new_fields[ 'options' ] ) ) {
                                foreach( $new_fields[ 'options' ] as $key => $options ) {
                                    ?>
                                    <option value="<?php echo $key ; ?>" <?php
                                    if( isset( $get_data[ $new_fields[ 'name' ] ] ) ) {
                                        foreach( $get_data[ $new_fields[ 'name' ] ] as $value ) {
                                            echo selected( $key , $value ) ;
                                        }
                                    }
                                    ?>><?php echo $options ; ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                    </select>
                </p>
                <?php
                if( ( float ) $woocommerce->version > ( float ) ('2.2.0') ) {
                    echo sumo_pricing_common_select_function( '#' . $new_fields[ 'id' ] . $new_array[ 'unique_id' ] , __( 'Select User Role' , 'sumodiscounts' ) ) ;
                } else {
                    echo sumo_pricing_common_chosen_function( '#' . $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ) ;
                }
                break ;

            case "multiselect1":
                global $woocommmerce ;
                ?>
                <p class="form-field">
                    <b>
                        <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
                    </b>
                    <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" id="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?>" multiple="multiple">
                        <?php
                        foreach( $new_fields[ 'options' ] as $key => $options ) {
                            ?>
                            <option value="<?php echo $key ; ?>" <?php
                            if( isset( $get_data[ $new_fields[ 'name' ] ] ) ) {
                                foreach( $get_data[ $new_fields[ 'name' ] ] as $value ) {
                                    echo selected( $key , $value ) ;
                                }
                            }
                            ?>><?php echo $options ; ?></option>
                                    <?php
                                }
                                ?>
                    </select>
                </p>
                <?php
                if( ( float ) $woocommerce->version > ( float ) ('2.2.0') ) {
                    echo sumo_pricing_common_select_function( '#' . $new_fields[ 'class' ] . $new_array[ 'unique_id' ] , __( 'Select User Role' , 'sumodiscounts' ) ) ;
                } else {
                    echo sumo_pricing_common_chosen_function( '#' . $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ) ;
                }
                break ;
            case "multiselectincproduct":
                global $woocommerce ;
                ?>
                <p class="form-field">
                    <label>
                        <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
                    </label>
                    <?php if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" style="width:343px;" multiple="multiple" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>">
                        </select>
                    <?php } else { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
                        <?php
                        $add_array = ( float ) WC()->version < ( float ) '3.0.0' ? '' : '[]' ;
                        $name      = $nameforinputfield . '[' . $new_array[ 'unique_id' ] . '][' . $new_fields[ 'name' ] . ']' . $add_array ;
                        $id        = $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ;
                        sumo_product_search( $name , $id ) ;
                        ?>
                    <?php } ?>
                </p>
                <?php
                echo sumo_pricing_common_ajax_function_to_select_product( $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ) ;
                break ;
            case "multiselectfreeproduct_soat":
                global $woocommerce ;
                ?>
                <p class="form-field">
                    <label>
                        <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
                    </label>
                    <?php if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>]" style="width:343px;" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>">                                                                
                        </select>
                    <?php } else { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
                        <?php
                        $name = $nameforinputfield . '[' . $new_array[ 'unique_id' ] . '][' . $new_fields[ 'name' ] . ']' ;
                        $id   = $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ;
                        sumo_product_search( $name , $id , false ) ;
                    }
                    ?>
                </p>
                <?php
                echo sumo_pricing_common_ajax_function_to_select_product( $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ) ;
                break ;
            case "multiselectincproduct_soat":
                global $woocommerce ;
                ?>
                <p class="form-field">
                    <label>
                        <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
                    </label>
                    <?php if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" style="width:343px;" multiple="multiple" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>">
                        </select>
                    <?php } else { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
                        <?php
                        $add_array = ( float ) WC()->version < ( float ) '3.0.0' ? '' : '[]' ;
                        $name      = $nameforinputfield . '[' . $new_array[ 'unique_id' ] . '][' . $new_fields[ 'name' ] . ']' . $add_array ;
                        $id        = $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ;
                        sumo_product_search( $name , $id ) ;
                    }
                    ?>
                </p>
                <?php
                echo sumo_pricing_common_ajax_function_to_select_product( $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ) ;
                break ;

            case "multiselectexcproduct":
                global $woocommerce ;
                ?>
                <p class="form-field">
                    <b>
                        <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
                    </b>
                    <?php if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" style="width:343px;" multiple="multiple" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>">
                        </select>
                    <?php } else { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
                        <?php
                        $add_array = ( float ) WC()->version < ( float ) '3.0.0' ? '' : '[]' ;
                        $name      = $nameforinputfield . '[' . $new_array[ 'unique_id' ] . '][' . $new_fields[ 'name' ] . ']' . $add_array ;
                        $id        = $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ;
                        sumo_product_search( $name , $id ) ;
                    }
                    ?>
                </p>
                <?php
                echo sumo_pricing_common_ajax_function_to_select_product( $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ) ;
                break ;

            case "multiselectexcproduct_soat":
                global $woocommerce ;
                ?>
                <p class="form-field">
                    <b>
                        <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
                    </b>
                    <?php if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" style="width:343px;" multiple="multiple" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>">
                        </select>
                    <?php } else { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
                        <?php
                        $add_array = ( float ) WC()->version < ( float ) '3.0.0' ? '' : '[]' ;
                        $name      = $nameforinputfield . '[' . $new_array[ 'unique_id' ] . '][' . $new_fields[ 'name' ] . ']' . $add_array ;
                        $id        = $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ;
                        sumo_product_search( $name , $id ) ;
                    }
                    ?>
                </p>
                <?php
                echo sumo_pricing_common_ajax_function_to_select_product( $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ) ;
                break ;
            case "multiselectincproductapplyon":
                global $woocommerce ;
                ?>
                <p class="form-field">
                    <b>
                        <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
                    </b>
                    <?php if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>]" style="width:343px;" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>">
                        </select>
                    <?php } else { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
                        <?php
                        $add_array = ( float ) WC()->version < ( float ) '3.0.0' ? '' : '[]' ;
                        $name      = $nameforinputfield . '[' . $new_array[ 'unique_id' ] . '][' . $new_fields[ 'name' ] . ']' . $add_array ;
                        $id        = $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ;
                        sumo_product_search( $name , $id ) ;
                    }
                    ?>
                </p>
                <?php
                echo sumo_pricing_common_ajax_function_to_select_product( $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ) ;
                break ;

            case "multiselectexcproductapplyon":
                global $woocommerce ;
                ?>
                <p class="form-field">
                    <b>
                        <?php echo $new_fields[ 'label' ] ; ?>
                    </b>
                    <?php if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" style="width:343px;" multiple="multiple" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>">
                        </select>
                    <?php } else { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
                        <?php
                        $add_array = ( float ) WC()->version < ( float ) '3.0.0' ? '' : '[]' ;
                        $name      = $nameforinputfield . '[' . $new_array[ 'unique_id' ] . '][' . $new_fields[ 'name' ] . ']' . $add_array ;
                        $id        = $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ;
                        sumo_product_search( $name , $id ) ;
                    }
                    ?>
                </p>
                <?php
                echo sumo_pricing_common_ajax_function_to_select_product( $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ) ;
                break ;
            case "multiselectinccategory":
                global $woocommmerce ;
                ?>
                <p class="form-field">
                    <b>
                        <?php echo $new_fields[ 'label' ] ; ?>
                    </b>
                    <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select style="width: 350px" class="<?php echo $new_fields[ 'class' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>" multiple="multiple">
                        <?php
                        if( is_array( $new_fields[ 'options' ] ) ) {
                            if( ! empty( $new_fields[ 'options' ] ) ) {
                                foreach( $new_fields[ 'options' ] as $key => $options ) {
                                    ?>
                                    <option value="<?php echo $key ; ?>" <?php
                                    if( isset( $get_data[ $new_fields[ 'name' ] ] ) ) {
                                        foreach( $get_data[ $new_fields[ 'name' ] ] as $value ) {
                                            echo selected( $key , $value ) ;
                                        }
                                    }
                                    ?>><?php echo $options ; ?></option>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                    </select>
                </p>
                <?php
                if( ( float ) $woocommerce->version > ( float ) ('2.2.0') ) {
                    echo sumo_pricing_common_select_function( '#' . $new_fields[ 'id' ] . $new_array[ 'unique_id' ] , __( 'Select Category' , 'sumodiscounts' ) ) ;
                } else {
                    echo sumo_pricing_common_chosen_function( '#' . $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ) ;
                }
                break ;

            case "multiselectexccategory":
                global $woocommmerce ;
                ?>
                <p class="form-field">
                    <b>
                        <?php echo $new_fields[ 'label' ] ; ?>
                    </b>
                    <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select style="width: 350px" class="<?php echo $new_fields[ 'class' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>" multiple="multiple">
                        <?php
                        foreach( $new_fields[ 'options' ] as $key => $options ) {
                            ?>
                            <option value="<?php echo $key ; ?>" <?php
                            if( isset( $get_data[ $new_fields[ 'name' ] ] ) ) {
                                foreach( $get_data[ $new_fields[ 'name' ] ] as $value ) {
                                    echo selected( $key , $value ) ;
                                }
                            }
                            ?>><?php echo $options ; ?></option>
                                    <?php
                                }
                                ?>
                    </select>
                </p>
                <?php
                if( ( float ) $woocommerce->version > ( float ) ('2.2.0') ) {
                    echo sumo_pricing_common_select_function( '#' . $new_fields[ 'id' ] . $new_array[ 'unique_id' ] , __( 'Select Category' , 'sumodiscounts' ) ) ;
                } else {
                    echo sumo_pricing_common_chosen_function( '#' . $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ) ;
                }
                break ;
            case "multiselectinctag":
                global $woocommmerce ;
                ?>
                <p class="form-field">
                    <b>
                        <?php echo $new_fields[ 'label' ] ; ?>
                    </b>
                    <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select style="width: 350px" class="<?php echo $new_fields[ 'class' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>" multiple="multiple">
                        <?php
                        foreach( $new_fields[ 'options' ] as $key => $options ) {
                            ?>
                            <option value="<?php echo $key ; ?>" <?php
                            if( isset( $get_data[ $new_fields[ 'name' ] ] ) ) {
                                foreach( $get_data[ $new_fields[ 'name' ] ] as $value ) {
                                    echo selected( $key , $value ) ;
                                }
                            }
                            ?>><?php echo $options ; ?></option>
                                    <?php
                                }
                                ?>
                    </select>
                </p>
                <?php
                if( ( float ) $woocommerce->version > ( float ) ('2.2.0') ) {
                    echo sumo_pricing_common_select_function( '#' . $new_fields[ 'id' ] . $new_array[ 'unique_id' ] , __( 'Select Tag' , 'sumodiscounts' ) ) ;
                } else {
                    echo sumo_pricing_common_chosen_function( '#' . $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ) ;
                }
                break ;
            case "multiselectexctag":
                global $woocommmerce ;
                ?>
                <p class="form-field">
                    <b>
                        <?php echo $new_fields[ 'label' ] ; ?>
                    </b>
                    <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select style="width: 350px" class="<?php echo $new_fields[ 'class' ] ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>" multiple="multiple">
                        <?php
                        foreach( $new_fields[ 'options' ] as $key => $options ) {
                            ?>
                            <option value="<?php echo $key ; ?>" <?php
                            if( isset( $get_data[ $new_fields[ 'name' ] ] ) ) {
                                foreach( $get_data[ $new_fields[ 'name' ] ] as $value ) {
                                    echo selected( $key , $value ) ;
                                }
                            }
                            ?>><?php echo $options ; ?></option>
                                    <?php
                                }
                                ?>
                    </select>
                </p>
                <?php
                if( ( float ) $woocommerce->version > ( float ) ('2.2.0') ) {
                    echo sumo_pricing_common_select_function( '#' . $new_fields[ 'id' ] . $new_array[ 'unique_id' ] , __( 'Select Tag' , 'sumodiscounts' ) ) ;
                } else {
                    echo sumo_pricing_common_chosen_function( '#' . $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ) ;
                }
                break ;

            case "multiselectincmemberplans" :
                if( class_exists( 'SUMOMemberships' ) && sumo_get_membership_levels() ) {
                    global $woocommerce ;
                    ?>
                    <p class="form-field">
                        <b>
                            <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
                        </b>
                        <?php
                        if( ( float ) WC()->version < ( float ) '3.0.0' ) {
                            ?>
                            <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
                            <input type="text" class="<?php echo $new_fields[ 'class' ] . $new_array[ 'unique_id' ] ; ?> sumomembership_plans_select" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_fields[ 'name' ] ; ?>]" style="width:343px;" id="<?php echo $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ; ?>"/>

                        <?php } else { ?>
                            <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
                            <?php
                            $add_array = ( float ) WC()->version < ( float ) '3.0.0' ? '' : '[]' ;
                            $name      = $nameforinputfield . '[' . $new_array[ 'unique_id' ] . '][' . $new_fields[ 'name' ] . ']' . $add_array ;
                            $id        = $new_fields[ 'id' ] . $new_array[ 'unique_id' ] ;
                            ?>
                            <select name="<?php echo $name ?>" class="sumomembership_plans_select" multiple="multiple" id="<?php echo $id ?>" style="width:320px;"></select>
                            <?php
                        }
                        echo sumo_pricing_common_ajax_function_to_select_member_plans() ;
                        ?>
                    </p>
                    <?php
                }
                break ;
            case "quantity_pricing":
                $label_name  = $new_fields[ 'label' ] ;
                $option_name = $new_fields[ 'name' ] ;
                ?>
                <div class="sumo_quantity_rule_<?php echo $new_array[ 'unique_id' ] ; ?>">
                    <p class="form-field" style="display: flex;">
                        <label>
                            <?php echo $new_fields[ 'label' ][ 0 ] ; ?>
                        </label>

                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 0 ] ; ?>"></span><input type="text" class="sumo_number_input" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_array[ 'nameforfields' ] ; ?>][<?php echo $new_array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 0 ] ; ?>]" value=""/>

                        <label>
                            <?php echo $new_fields[ 'label' ][ 1 ] ; ?>
                        </label>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 1 ] ; ?>"></span><input type="text" class="sumo_number_input" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_array[ 'nameforfields' ] ; ?>][<?php echo $new_array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 1 ] ; ?>]" value=""/>

                        <label>
                            <?php echo $new_fields[ 'label' ][ 2 ] ; ?>
                        </label>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 2 ] ; ?>"></span><select name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_array[ 'nameforfields' ] ; ?>][<?php echo $new_array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 2 ] ; ?>]">
                            <option value="1"><?php _e( '% Discount' , 'sumodiscounts' ) ; ?></option>
                            <option value="2"><?php _e( 'Fixed Discount' , 'sumodiscounts' ) ; ?></option>
                            <option value="3"><?php _e( 'Fixed Price' , 'sumodiscounts' ) ; ?></option>
                        </select>

                        <label>
                            <?php echo $new_fields[ 'label' ][ 3 ] ; ?>
                        </label>

                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 3 ] ; ?>"></span><input type="number" min=".01" step="any" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_array[ 'nameforfields' ] ; ?>][<?php echo $new_array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 3 ] ; ?>]" value=""/>
                        <input type="checkbox" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_array[ 'nameforfields' ] ; ?>][<?php echo $new_array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 4 ] ; ?>]" value="yes"/>
                        <label>
                            <b><?php _e( $new_fields[ 'label' ][ 4 ] , 'sumodiscounts' ) ; ?></b><br><br>
                        </label>
                        <span class="dashicons dashicons-info" title="<?php echo isset( $new_fields[ 'tooltip' ][ 5 ] ) ? $new_fields[ 'tooltip' ][ 5 ] : '' ; ?>"></span>
                        <span class="delete_row button-secondary"><?php _e( 'Delete Row' , 'sumodiscounts' ) ; ?></span>
                    </p>

                </div>
                <span class="add_new_row_for_quantity<?php echo $new_array[ 'unique_id' ] ; ?> button-primary"><?php echo __( 'Add New Row' , 'sumodiscounts' ) ?></span>
                <script type="text/javascript">
                    jQuery( function() {
                        jQuery( document ).on( 'click' , '.add_new_row_for_quantity<?php echo $new_array[ 'unique_id' ] ; ?>' , function() {
                            jQuery.ajax( {
                                data : ( {
                                    action : 'sumo_pricing_uniqid_for_qty' ,
                                    rule_type : 'quantity' ,
                                    uniq_id : '<?php echo $new_array[ 'unique_id' ] ; ?>' ,
                                } ) ,
                                type : 'POST' ,
                                url : "<?php echo admin_url( 'admin-ajax.php' ) ; ?>" ,
                                success : function( response ) {
                                    console.log( response ) ;
                                    jQuery( '.sumo_quantity_rule_<?php echo $new_array[ 'unique_id' ] ; ?>' ).append( response ) ;
                                }

                            } ) ;
                        } ) ;
                    } ) ;
                </script>
                <?php
                break ;
            case "offer_pricing":
                $label_name  = $new_fields[ 'label' ] ;
                $option_name = $new_fields[ 'name' ] ;
                ?>
                <div class="sumo_offer_rule_<?php echo $new_array[ 'unique_id' ] ; ?>">
                    <p class="form-field" style="display: flex;">
                        <label>
                            <?php echo $new_fields[ 'label' ][ 0 ] ; ?>
                        </label>
                        <input type="number" min="1" step="1" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_array[ 'nameforfields' ] ; ?>][<?php echo $new_array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 0 ] ; ?>]" value=""/>

                        <label>
                            <?php echo $new_fields[ 'label' ][ 1 ] ; ?>
                        </label>
                        <input type="number" min="1" step="1" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_array[ 'nameforfields' ] ; ?>][<?php echo $new_array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 1 ] ; ?>]" value=""/>

                        <label>
                            <?php echo $new_fields[ 'label' ][ 2 ] ; ?>
                        </label>
                        <select name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_array[ 'nameforfields' ] ; ?>][<?php echo $new_array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 2 ] ; ?>]">
                            <option value="1"><?php _e( '% Discount' , 'sumodiscounts' ) ; ?></option>
                            <option value="2"><?php _e( 'Fixed Discount' , 'sumodiscounts' ) ; ?></option>
                            <option value="3"><?php _e( 'Fixed Price' , 'sumodiscounts' ) ; ?></option>
                        </select>

                        <label>
                            <?php echo $new_fields[ 'label' ][ 3 ] ; ?>
                        </label>

                        <input type="number" min=".01" step="any" required="required"  style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_array[ 'nameforfields' ] ; ?>][<?php echo $new_array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 3 ] ; ?>]" value=""/>

                        <input type="checkbox" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_array[ 'nameforfields' ] ; ?>][<?php echo $new_array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 4 ] ; ?>]" value="yes"/>
                        <label>
                            <?php echo $new_fields[ 'label' ][ 4 ] ; ?>
                        </label>
                        <span class="delete_row button-secondary"><?php _e( 'Delete Row' , 'sumodiscounts' ) ; ?></span>
                    </p>

                </div>
                <span class="add_new_row_for_offer<?php echo $new_array[ 'unique_id' ] ; ?> button-primary"><?php echo __( 'Add New Row' , 'sumodiscounts' ) ?></span>
                <script type="text/javascript">
                    jQuery( function() {
                        jQuery( document ).on( 'click' , '.add_new_row_for_offer<?php echo $new_array[ 'unique_id' ] ; ?>' , function() {
                            jQuery.ajax( {
                                data : ( {
                                    action : 'sumo_pricing_uniqid_for_offer' ,
                                    rule_type : 'specialoffer' ,
                                    uniq_id : '<?php echo $new_array[ 'unique_id' ] ; ?>' ,
                                } ) ,
                                type : 'POST' ,
                                url : "<?php echo admin_url( 'admin-ajax.php' ) ; ?>" ,
                                success : function( response ) {
                                    console.log( response ) ;
                                    jQuery( '.sumo_offer_rule_<?php echo $new_array[ 'unique_id' ] ; ?>' ).append( response ) ;
                                }

                            } ) ;
                        } ) ;
                    } ) ;
                </script>
                <?php
                break ;
            case "cart_total_pricing":
                $label_name  = $new_fields[ 'label' ] ;
                $option_name = $new_fields[ 'name' ] ;
                ?>
                <div class="sumo_cart_total_rule_<?php echo $new_array[ 'unique_id' ] ; ?>">
                    <p class="form-field" style="display: flex;">
                        <label>
                            <?php echo $new_fields[ 'label' ][ 0 ] ; ?>
                        </label>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 0 ] ; ?>"></span><input type="text" class="sumo_number_input" required="required"  style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_array[ 'nameforfields' ] ; ?>][<?php echo $new_array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 0 ] ; ?>]" value=""/>

                        <label>
                            <?php echo $new_fields[ 'label' ][ 1 ] ; ?>
                        </label>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 1 ] ; ?>"></span><input type="text" class="sumo_number_input" required="required"  style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_array[ 'nameforfields' ] ; ?>][<?php echo $new_array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 1 ] ; ?>]" value=""/>

                        <label>
                            <?php echo $new_fields[ 'label' ][ 2 ] ; ?>
                        </label>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 2 ] ; ?>"></span><select name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_array[ 'nameforfields' ] ; ?>][<?php echo $new_array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 2 ] ; ?>]">
                            <option value="1"><?php _e( '% Discount' , 'sumodiscounts' ) ; ?></option>
                            <option value="2"><?php _e( 'Fixed Discount' , 'sumodiscounts' ) ; ?></option>
                        </select>

                        <label>
                            <?php echo $new_fields[ 'label' ][ 3 ] ; ?>
                        </label>

                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 3 ] ; ?>"></span><input type="number" step="any" required="required" min=".01" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $new_array[ 'unique_id' ] ; ?>][<?php echo $new_array[ 'nameforfields' ] ; ?>][<?php echo $new_array[ 'phpunique_id' ] ; ?>][<?php echo $new_fields[ 'name' ][ 3 ] ; ?>]" value=""/>

                        <span class="delete_row button-secondary"><?php _e( 'Delete Row' , 'sumodiscounts' ) ; ?></span>
                    </p>

                </div>
                <span class="add_new_row_for_cart_total<?php echo $new_array[ 'unique_id' ] ; ?> button-primary"><?php echo __( 'Add New Row' , 'sumodiscounts' ) ?></span>
                <script type="text/javascript">
                    jQuery( function() {
                        jQuery( document ).on( 'click' , '.add_new_row_for_cart_total<?php echo $new_array[ 'unique_id' ] ; ?>' , function() {
                            jQuery.ajax( {
                                data : ( {
                                    action : 'sumo_pricing_uniqid_for_cart' ,
                                    rule_type : 'cart_total' ,
                                    uniq_id : '<?php echo $new_array[ 'unique_id' ] ; ?>' ,
                                } ) ,
                                type : 'POST' ,
                                url : "<?php echo admin_url( 'admin-ajax.php' ) ; ?>" ,
                                success : function( response ) {
                                    console.log( response ) ;
                                    jQuery( '.sumo_cart_total_rule_<?php echo $new_array[ 'unique_id' ] ; ?>' ).append( response ) ;
                                }

                            } ) ;
                        } ) ;
                    } ) ;
                </script>
                <?php
                break ;
        }
    }
    SUMOQuantityPricing::show_or_hide( $new_array[ 'unique_id' ] ) ;
    SUMOOfferPricing::show_or_hide( $new_array[ 'unique_id' ] ) ;
    SUMOCartPricing::show_or_hide( $new_array[ 'unique_id' ] ) ;
    SUMOCategoryProductPricing::show_or_hide( $new_array[ 'unique_id' ] ) ;
    $get_data = ob_get_clean() ;
    return $get_data ;
}

function generate_dynamic_rule_pricing_fields( $ruletype ) {
    $categorylist        = array() ;
    $categoryname        = array() ;
    $categoryid          = array() ;
    $userroleslug        = array() ;
    $userrolename        = array() ;
    $newcombineduserrole = array() ;
    global $wp_roles ;
    foreach( $wp_roles->roles as $values => $key ) {
        $userroleslug[] = $values ;
        $userrolename[] = $key[ 'name' ] ;
    }

    $newcombineduserrole = array_combine( ( array ) $userroleslug , ( array ) $userrolename ) ;

    $listcategories = get_terms( 'product_cat' ) ;
    if( is_array( $listcategories ) && ! empty( $listcategories ) ) {
        foreach( $listcategories as $category ) {
            $categoryname[] = $category->name ;
            $categoryid[]   = $category->term_id ;
        }
    }
    if( is_array( $categoryid ) && ! empty( $categoryid ) && is_array( $categoryname ) && ! empty( $categoryname ) ) {
        $categorylist = array_combine( ( array ) $categoryid , ( array ) $categoryname ) ;
    }
    $product_tags = array() ;
    $all_tags     = get_categories( array( 'hide_empty' => 0 , 'taxonomy' => 'product_tag' ) ) ;
    foreach( $all_tags as $each_tag ) {
        $product_tags[ $each_tag->term_id ] = $each_tag->name ;
    }
    $pricing_commonfield              = array(
        array(
            'name'    => 'sumo_enable_the_rule' ,
            'id'      => 'sumo_enable_the_rule' ,
            'class'   => 'sumo_enable_the_rule' ,
            'type'    => 'checkbox' ,
            'label'   => __( 'Enable this Rule' , 'sumodiscounts' ) ,
            'default' => 'yes' ,
            'tooltip' => __( 'Enable this checkbox, if you want to consider this rule for providing Discounts' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'    => 'sumo_apply_this_rule_for_sale' ,
            'id'      => 'sumo_apply_this_rule_for_sale' ,
            'class'   => 'sumo_apply_this_rule_for_sale' ,
            'type'    => 'checkbox' ,
            'label'   => __( 'Apply this Rule for Product with Sale Price' , 'sumodiscounts' ) ,
            'default' => 'yes' ,
            'tooltip' => __( 'When enabled, Products with Sale Price will also be considered for providing discounts' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_dynamic_rule_name' ,
            'id'          => 'sumo_dynamic_rule_name' ,
            'class'       => 'sumo_dynamic_rule_name' ,
            'type'        => 'text' ,
            'label'       => __( 'Rule Name' , 'sumodiscounts' ) ,
            'default'     => __( 'Rule Description' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Enter Name of this Rule' , 'sumodiscounts' ) ,
            'tooltip'     => __( 'Enter a Name which can denote the purpose of creating this rule <br> Example: Discounts for Logged In Users' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'    => 'sumo_dynamic_rule_priority' ,
            'id'      => 'sumo_dynamic_rule_priority' ,
            'class'   => 'sumo_dynamic_rule_priority' ,
            'type'    => 'select' ,
            'label'   => __( 'Row Priority' , 'sumodiscounts' ) ,
            'options' => array(
                '1' => __( 'First Matched Rule' , 'sumodiscounts' ) ,
                '2' => __( 'Last Matched Rule' , 'sumodiscounts' ) ,
                '3' => __( 'Minimum Discount' , 'sumodiscounts' ) ,
                '4' => __( 'Maximum Discount' , 'sumodiscounts' ) ,
            ) ,
            'tooltip' => __( 'Row priority will be used to decide what discount is applicable for the users when the user\'s Current quantity matches with more than one row in a Rule ' , 'sumodiscounts' ) ,
        ) ,
            ) ;
    $pricing_fields_for_qty_selection = array(
        array(
            'name'    => 'sumo_dynamic_rule_based_on_pricing' ,
            'id'      => 'sumo_dynamic_rule_based_on_pricing' ,
            'class'   => 'sumo_dynamic_rule_based_on_pricing' ,
            'type'    => 'select' ,
            'label'   => __( 'Quantity Calculation is based on' , 'sumodiscounts' ) ,
            'options' => array(
                '1' => __( 'Quantity from Product Level' , 'sumodiscounts' ) ,
                '2' => __( 'Quantity from Variant Level' , 'sumodiscounts' ) ,
                '3' => __( 'Entire Cart Quantity' , 'sumodiscounts' ) ,
                '4' => __( 'Quantity from Each Category' , 'sumodiscounts' ) ,
            ) ,
            'tooltip' => __( 'Based on the options provided, the discounts will be calculated' , 'sumodiscounts' ) ,
        ) ,
            ) ;


    $options                 = array(
        '1' => __( 'All Users' , 'sumodiscounts' ) ,
        '2' => __( 'Include User(s)' , 'sumodiscounts' ) ,
        '3' => __( 'Exclude User(s)' , 'sumodiscounts' ) ,
//                '4' => __('All User Roles','sumodiscounts'),
        '5' => __( 'Include User Role(s)' , 'sumodiscounts' ) ,
        '6' => __( 'Exclude User Role(s)' , 'sumodiscounts' ) ,
        '7' => __( 'SUMO Member(s)' , 'sumodiscounts' )
            ) ;
    $membership_plan_options = array(
        'name'        => 'sumo_pricing_apply_to_include_memberplans' ,
        'id'          => 'sumo_pricing_apply_to_include_memberplans' ,
        'class'       => 'sumo_pricing_apply_to_include_memberplans' ,
        'type'        => 'multiselectincmemberplans' ,
        'label'       => __( 'Include Membership plans' , 'sumodiscounts' ) ,
        'placeholder' => __( 'Select Membership plans' , 'sumodiscounts' ) ,
        'tooltip'     => __( 'Rule is valid only for the Members had selected membership plans. If the \'Include Membership plans\' is left empty then the rule is valid for all Member(s).' , 'sumodiscounts' ) ,
            ) ;

    $pricing_fields_user_filter = array(
        array(
            'name'    => 'sumo_pricing_apply_for_user_type' ,
            'id'      => 'sumo_pricing_apply_for_user_type' ,
            'class'   => 'sumo_pricing_apply_for_user_type' ,
            'type'    => 'select' ,
            'label'   => __( 'User Filter' , 'sumodiscounts' ) ,
            'options' => array(
                '1' => __( 'All Users' , 'sumodiscounts' ) ,
                '2' => __( 'Logged In Users' , 'sumodiscounts' ) ,
                '3' => __( 'Guest' , 'sumodiscounts' ) ,
            ) ,
            'tooltip' => __( 'By Default, discounts will be provided for All Users.If you want to restrict the discounts only to Logged in Users/Guest that can be done using the options' , 'sumodiscounts' )
        ) ,
        array(
            'name'    => 'sumo_pricing_apply_to_user' ,
            'id'      => 'sumo_pricing_apply_to_user' ,
            'class'   => 'sumo_pricing_apply_to_user' ,
            'type'    => 'select' ,
            'label'   => __( 'Applicable for' , 'sumodiscounts' ) ,
            'options' => $options ,
            'tooltip' => __( 'By Default, discounts will be provided for All Users.If you want to restrict the discounts only to specific users then, that can be done using the options provided' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_include_users' ,
            'id'          => 'sumo_pricing_apply_to_include_users' ,
            'class'       => 'sumo_pricing_apply_to_include_users' ,
            'type'        => 'multiselectincuser' ,
            'label'       => __( 'Include User(s)' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select User(s)' , 'sumodiscounts' ) ,
            'tooltip'     => __( 'Rule is valid only for the selected users. If the \'Include User(s)\' is left empty then the rule is not valid for any of the users.' , 'sumodiscounts' )
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_exclude_users' ,
            'id'          => 'sumo_pricing_apply_to_exclude_users' ,
            'class'       => 'sumo_pricing_apply_to_exclude_users' ,
            'type'        => 'multiselectexcuser' ,
            'label'       => __( 'Exclude User(s)' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select User(s)' , 'sumodiscounts' ) ,
            'tooltip'     => __( 'Rule is valid only for all users except for those users who are excluded. If the \'Exclude User(s)\' is left empty then the rule is not valid for any of the Users.' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_include_users_role' ,
            'class'       => 'sumo_pricing_apply_to_include_users_role' ,
            'id'          => 'sumo_pricing_apply_to_include_users_role' ,
            'type'        => 'multiselect' ,
            'label'       => __( 'Include User Role(s)' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select User Role(s)' , 'sumodiscounts' ) ,
            'options'     => $newcombineduserrole ,
            'tooltip'     => __( 'Rule is valid only for the users of the selected user role(s). If the \'Include User Role(s)\' is left empty then the rule is not valid for any of the users.' , 'sumodiscounts' )
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_exclude_users_role' ,
            'id'          => 'sumo_pricing_apply_to_exclude_users_role' ,
            'class'       => 'sumo_pricing_apply_to_exclude_users_role' ,
            'type'        => 'multiselect1' ,
            'label'       => __( 'Exclude User Role(s)' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select User Role(s)' , 'sumodiscounts' ) ,
            'options'     => $newcombineduserrole ,
            'tooltip'     => __( 'Rule is valid only for all users of the selected user role(s) except for those users who belong to the user role(s) which are excluded. If the \'Exclude User Role(s)\' is left empty then the rule is not valid for any of the users.' , 'sumodiscounts' ) ,
        ) ,
        $membership_plan_options ,
            ) ;

    if( check_if_free_shipping_enabled() ) {
        $allowfreeshipping = array(
            'name'    => 'sumo_enable_free_shipping' ,
            'id'      => 'sumo_enable_free_shipping' ,
            'class'   => 'sumo_enable_free_shipping' ,
            'type'    => 'checkbox' ,
            'label'   => __( 'Allow Free Shipping' , 'sumodiscounts' ) ,
            'default' => 'no' ,
            'tooltip' => __( 'When enabled, Free Shipping will be allowed when it match the rule' , 'sumodiscounts' ) ,
                ) ;
    } else {
        $allowfreeshipping = array() ;
    }
    $pricing_fields_from_datepicker = array(
        array(
            'name'    => array(
                'sumo_pricing_from_datepicker' , 'sumo_pricing_to_datepicker' ,
            ) ,
            'id'      => array(
                'sumo_pricing_from_datepicker' , 'sumo_pricing_to_datepicker' ,
            ) ,
            'class'   => array(
                'sumo_pricing_from_datepicker' , 'sumo_pricing_to_datepicker' ,
            ) ,
            'type'    => 'datepicker' ,
            'label'   => array(
                __( 'Rule Valid from' , 'sumodiscounts' ) . '&nbsp;' , __( 'Rule Valid Till' , 'sumodiscounts' ) . '&nbsp;'
            ) ,
            'tooltip' => array(
                __( 'The Date from which the Discounts are valid' , 'sumodiscounts' ) , __( 'The Date till which the Discounts are valid' , 'sumodiscounts' ) ,
            ) ,
        ) ,
        array(
            'name'            => array(
                'sumo_pricing_rule_week_monday' ,
                'sumo_pricing_rule_week_tuesday' ,
                'sumo_pricing_rule_week_wednesday' ,
                'sumo_pricing_rule_week_thursday' ,
                'sumo_pricing_rule_week_friday' ,
                'sumo_pricing_rule_week_saturday' ,
                'sumo_pricing_rule_week_sunday' ,
            ) ,
            'id'              => array(
                'sumo_pricing_rule_week_monday' ,
                'sumo_pricing_rule_week_tuesday' ,
                'sumo_pricing_rule_week_wednesday' ,
                'sumo_pricing_rule_week_thursday' ,
                'sumo_pricing_rule_week_friday' ,
                'sumo_pricing_rule_week_saturday' ,
                'sumo_pricing_rule_week_sunday' ,
            ) ,
            'class'           => array(
                'sumo_pricing_rule_week_monday' ,
                'sumo_pricing_rule_week_tuesday' ,
                'sumo_pricing_rule_week_wednesday' ,
                'sumo_pricing_rule_week_thursday' ,
                'sumo_pricing_rule_week_friday' ,
                'sumo_pricing_rule_week_saturday' ,
                'sumo_pricing_rule_week_sunday' ,
            ) ,
            'type'            => 'weekdays' ,
            'week_days_title' => __( 'Rule is valid on the following days' , 'sumodiscounts' ) ,
            'label'           => array(
                __( 'Monday' , 'sumodiscounts' ) , __( 'Tuesday' , 'sumodiscounts' ) , __( 'Wednesday' , 'sumodiscounts' ) , __( 'Thursday' , 'sumodiscounts' ) , __( 'Friday' , 'sumodiscounts' ) , __( 'Saturday' , 'sumodiscounts' ) , __( 'Sunday' , 'sumodiscounts' )
            ) ,
            'tooltip'         => __( 'If you want to provide discounts only on certain days of a Week then select only those days.' , 'sumodiscounts' ) ,
        ) ,
        $allowfreeshipping ,
            ) ;

    $pricing_fields_for_productfilter = array(
        array(
            'name'    => 'sumo_pricing_apply_to_products' ,
            'id'      => 'sumo_pricing_apply_to_products' ,
            'class'   => 'sumo_pricing_apply_to_products' ,
            'type'    => 'select' ,
            'label'   => __( 'Applicable for' , 'sumodiscounts' ) ,
            'options' => array(
                '1' => __( 'All Products' , 'sumodiscounts' ) ,
                '2' => __( 'Include Products' , 'sumodiscounts' ) ,
                '3' => __( 'Exclude Products' , 'sumodiscounts' ) ,
                '4' => __( 'All Categories' , 'sumodiscounts' ) ,
                '5' => __( 'Include Categories' , 'sumodiscounts' ) ,
                '6' => __( 'Exclude Categories' , 'sumodiscounts' ) ,
                '7' => __( 'All Tags' , 'sumodiscounts' ) ,
                '8' => __( 'Include Tags' , 'sumodiscounts' ) ,
                '9' => __( 'Exclude Tags' , 'sumodiscounts' ) ,
            ) ,
            'tooltip' => __( 'By Default, discounts will be provided for All Products.If you want to restrict the discounts only to specific products/categories then, that can be done using the options provided' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_include_products' ,
            'id'          => 'sumo_pricing_apply_to_include_products' ,
            'class'       => 'sumo_pricing_apply_to_include_products' ,
            'type'        => 'multiselectincproduct' ,
            'label'       => __( 'Include Products' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Products' , 'sumodiscounts' ) ,
            'tooltip'     => __( 'Rule is applicable only the selected Products' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_exclude_products' ,
            'id'          => 'sumo_pricing_apply_to_exclude_products' ,
            'class'       => 'sumo_pricing_apply_to_exclude_products' ,
            'type'        => 'multiselectexcproduct' ,
            'label'       => __( 'Exclude Products' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Products' , 'sumodiscounts' ) ,
            'tooltip'     => __( 'Rule is applicable for all products except for those products which are excluded' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_include_category' ,
            'id'          => 'sumo_pricing_apply_to_include_category' ,
            'class'       => 'sumo_pricing_apply_to_include_category' ,
            'type'        => 'multiselectinccategory' ,
            'label'       => __( 'Include Categories' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Categories' , 'sumodiscounts' ) ,
            'options'     => $categorylist ,
            'tooltip'     => __( 'Rule is applicable for all products of the  selected categories' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_exclude_category' ,
            'id'          => 'sumo_pricing_apply_to_exclude_category' ,
            'class'       => 'sumo_pricing_apply_to_exclude_category' ,
            'type'        => 'multiselectexccategory' ,
            'label'       => __( 'Exclude Categories' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Categories' , 'sumodiscounts' ) ,
            'options'     => $categorylist ,
            'tooltip'     => __( 'Rule is applicable for all products except for those products which belongs to the Excluded categories' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_include_tag' ,
            'id'          => 'sumo_pricing_apply_to_include_tag' ,
            'class'       => 'sumo_pricing_apply_to_include_tag' ,
            'type'        => 'multiselectinctag' ,
            'label'       => __( 'Include Tags' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Tags' , 'sumodiscounts' ) ,
            'options'     => $product_tags ,
            'tooltip'     => __( 'Rule is applicable for all products of the  selected tags' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_exclude_tag' ,
            'id'          => 'sumo_pricing_apply_to_exclude_tag' ,
            'class'       => 'sumo_pricing_apply_to_exclude_tag' ,
            'type'        => 'multiselectexctag' ,
            'label'       => __( 'Exclude Tags' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Tags' , 'sumodiscounts' ) ,
            'options'     => $product_tags ,
            'tooltip'     => __( 'Rule is applicable for all products except for those products which belongs to the Excluded tags' , 'sumodiscounts' ) ,
        ) ,
            ) ;

    $condition_for_include = array(
        array(
            'name'    => 'sumo_pricing_inc_condition' ,
            'id'      => 'sumo_pricing_inc_condition' ,
            'class'   => 'sumo_pricing_inc_condition' ,
            'type'    => 'select' ,
            'label'   => __( 'Applicable when' , 'sumodiscounts' ) ,
            'options' => array(
                '1' => __( 'Any one of the selected is available in cart' , 'sumodiscounts' ) ,
                '2' => __( 'All of the selected are available in cart' , 'sumodiscounts' ) ,
                '3' => __( 'only selected are available in cart' , 'sumodiscounts' )
            ) ,
        )
            ) ;

    $pricing_fields_for_qty = array(
        array(
            'name'    => array(
                'sumo_pricing_rule_min_quantity' ,
                'sumo_pricing_rule_max_quantity' ,
                'sumo_pricing_rule_discount_type' ,
                'sumo_pricing_rule_discount_value' ,
                'sumo_pricing_rule_repeat_discount' ,
            ) ,
            'id'      => array(
                'sumo_pricing_rule_min_quantity' ,
                'sumo_pricing_rule_max_quantity' ,
                'sumo_pricing_rule_discount_type' ,
                'sumo_pricing_rule_discount_value' ,
                'sumo_pricing_rule_repeat_discount' ,
            ) ,
            'class'   => array(
                'sumo_pricing_rule_min_quantity' ,
                'sumo_pricing_rule_max_quantity' ,
                'sumo_pricing_rule_discount_type' ,
                'sumo_pricing_rule_discount_value' ,
                'sumo_pricing_rule_repeat_discount' ,
            ) ,
            'type'    => 'quantity_pricing' ,
            'label'   => array(
                __( 'Min Quantity' , 'sumodiscounts' ) . ' &nbsp;' , '&nbsp;' . __( 'Max Quantity' , 'sumodiscounts' ) , ' &nbsp; ' . __( 'Discount Type' , 'sumodiscounts' ) , ' &nbsp;' . __( 'Value' , 'sumodiscounts' ) , ' &nbsp;' . __( 'Repeat' , 'sumodiscounts' ) ,
            ) ,
            'tooltip' => array(
                __( 'The minimum quantity which the user needs to purchase in order to get a Discount' , 'sumodiscounts' ) , __( 'The maximum quantity which the user should not exceed in order to get a Discount' , 'sumodiscounts' ) , __( 'The type of discount which is to be applied can be chosen' , 'sumodiscounts' ) , __( 'Enter Value for discount' , 'sumodiscounts' ) ,
            ) ,
        ) ,
            ) ;

    $applicable_to = array(
        array(
            'name'    => 'sumo_special_offer_applicable_to_' ,
            'id'      => 'sumo_special_offer_applicable_to_' ,
            'class'   => 'sumo_special_offer_applicable_to_' ,
            'type'    => 'select' ,
            'label'   => __( 'Applicable To' , 'sumodiscounts' ) ,
            'options' => array(
                ''  => __( 'Same Products' , 'sumodiscounts' ) ,
                '1' => __( 'Include Products' , 'sumodiscounts' ) ,
                '2' => __( 'Exclude Products' , 'sumodiscounts' ) ,
                '4' => __( 'Include Categories' , 'sumodiscounts' ) ,
                '5' => __( 'Exclude Categories' , 'sumodiscounts' ) ,
                '6' => __( 'Include Tags' , 'sumodiscounts' ) ,
                '7' => __( 'Exclude Tags' , 'sumodiscounts' ) ,
                '8' => __( 'Automatic free product' , 'sumodiscounts' ) ,
            ) ,
            'tooltip' => __( 'By Default, discounts will be provided for Same Products.If you want to restrict the discounts only to specific products/categories then, that can be done using the options provided' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'    => 'sumo_special_offer_buy_quantity' ,
            'id'      => 'sumo_special_offer_buy_quantity' ,
            'class'   => 'sumo_special_offer_buy_quantity' ,
            'type'    => 'number' ,
            'label'   => __( 'When Quantity greater than or equal to' , 'sumodiscounts' ) ,
            'tooltip' => '' ,
        ) ,
        array(
            'name'        => 'sumo_special_offer_apply_to_free_products' ,
            'id'          => 'sumo_special_offer_apply_to_free_products' ,
            'class'       => 'sumo_special_offer_apply_to_free_products' ,
            'type'        => 'multiselectfreeproduct_soat' ,
            'label'       => __( 'Free Product' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Product' , 'sumodiscounts' ) ,
            'tooltip'     => __( 'Discount is applicable only the selected Product' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_special_offer_apply_to_include_products' ,
            'id'          => 'sumo_special_offer_apply_to_include_products' ,
            'class'       => 'sumo_special_offer_apply_to_include_products' ,
            'type'        => 'multiselectincproduct_soat' ,
            'label'       => __( 'Include Products' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Products' , 'sumodiscounts' ) ,
            'tooltip'     => __( 'Discount is applicable only the selected Products' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_special_offer_apply_to_exclude_products' ,
            'id'          => 'sumo_special_offer_apply_to_exclude_products' ,
            'class'       => 'sumo_special_offer_apply_to_exclude_products' ,
            'type'        => 'multiselectexcproduct_soat' ,
            'label'       => __( 'Exclude Products' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Products' , 'sumodiscounts' ) ,
            'tooltip'     => __( 'Discount is applicable for all products except for those products which are excluded' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_special_offer_apply_to_include_category' ,
            'id'          => 'sumo_special_offer_apply_to_include_category' ,
            'class'       => 'sumo_special_offer_apply_to_include_category' ,
            'type'        => 'multiselectinccategory' ,
            'label'       => __( 'Include Categories' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Categories' , 'sumodiscounts' ) ,
            'options'     => $categorylist ,
            'tooltip'     => __( 'Discount is applicable for all products of the  selected categories' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_special_offer_apply_to_exclude_category' ,
            'id'          => 'sumo_special_offer_apply_to_exclude_category' ,
            'class'       => 'sumo_special_offer_apply_to_exclude_category' ,
            'type'        => 'multiselectexccategory' ,
            'label'       => __( 'Exclude Categories' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Categories' , 'sumodiscounts' ) ,
            'options'     => $categorylist ,
            'tooltip'     => __( 'Discount is applicable for all products except for those products which belongs to the Excluded categories' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_special_offer_apply_to_include_tag' ,
            'id'          => 'sumo_special_offer_apply_to_include_tag' ,
            'class'       => 'sumo_special_offer_apply_to_include_tag' ,
            'type'        => 'multiselectinctag' ,
            'label'       => __( 'Include Tags' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Tags' , 'sumodiscounts' ) ,
            'options'     => $product_tags ,
            'tooltip'     => __( 'Discount is applicable for all products of the  selected tags' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_special_offer_apply_to_exclude_tag' ,
            'id'          => 'sumo_special_offer_apply_to_exclude_tag' ,
            'class'       => 'sumo_special_offer_apply_to_exclude_tag' ,
            'type'        => 'multiselectexctag' ,
            'label'       => __( 'Exclude Tags' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Tags' , 'sumodiscounts' ) ,
            'options'     => $product_tags ,
            'tooltip'     => __( 'Discount is applicable for all products except for those products which belongs to the Excluded tags' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'    => 'sumo_special_offer_applicable_on_' ,
            'id'      => 'sumo_special_offer_applicable_on_' ,
            'class'   => 'sumo_special_offer_applicable_on_' ,
            'type'    => 'select' ,
            'label'   => __( 'Apply Discount on' , 'sumodiscounts' ) ,
            'options' => array(
                '1' => __( 'Product With Highest Price' , 'sumodiscounts' ) ,
                '2' => __( 'Product With Lowest Price' , 'sumodiscounts' ) ,
            ) ,
            'tooltip' => __( 'When discount is set to be applied on selected products and more than one of the selected product is in cart, based on the option selected the discount will be applied to Product With Highest/Lowest Price.' , 'sumodiscounts' ) ,
        )
            ) ;

    $pricing_fields_for_offer = array(
        array(
            'name'  => array(
                'sumo_pricing_rule_buy_offer' ,
                'sumo_pricing_rule_free_offer' ,
                'sumo_pricing_rule_discount_type_for_offer' ,
                'sumo_pricing_rule_discount_value_for_offer' ,
                'sumo_pricing_repeat_rule' ,
            ) ,
            'id'    => array(
                'sumo_pricing_rule_buy_offer' ,
                'sumo_pricing_rule_free_offer' ,
                'sumo_pricing_rule_discount_type_for_offer' ,
                'sumo_pricing_rule_discount_value_for_offer' ,
                'sumo_pricing_repeat_rule' ,
            ) ,
            'class' => array(
                'sumo_pricing_rule_buy_offer' ,
                'sumo_pricing_rule_free_offer' ,
                'sumo_pricing_rule_discount_type_for_offer' ,
                'sumo_pricing_rule_discount_value_for_offer' ,
                'sumo_pricing_repeat_rule' ,
            ) ,
            'type'  => 'offer_pricing' ,
            'label' => array(
                __( 'Buy' , 'sumodiscounts' ) , __( 'Get' , 'sumodiscounts' ) , __( 'Discount Type' , 'sumodiscounts' ) , __( 'Value' , 'sumodiscounts' ) , __( 'Repeat Row' , 'sumodiscounts' )
            ) ,
        ) ,
            ) ;

    $cartcriteria                        = array(
        array(
            'name'    => 'sumo_pricing_criteria' ,
            'type'    => 'select' ,
            'label'   => __( 'Criteria ' , 'sumodiscounts' ) ,
            'id'      => 'sumo_pricing_criteria' ,
            'class'   => 'sumo_pricing_criteria' ,
            'options' => array(
                '1' => __( 'Any Product(s) is in Cart' , 'sumodiscounts' ) ,
                '2' => __( 'Any one of the Selected Product(s) is in Cart' , 'sumodiscounts' ) ,
                '3' => __( 'Any one of the Selected Product(s) is not in Cart' , 'sumodiscounts' ) ,
                '6' => __( 'Any Products have Categories in Cart' , 'sumodiscounts' ) ,
                '4' => __( 'Any one of the Product(s) of a Selected Category is in Cart' , 'sumodiscounts' ) ,
                '5' => __( 'Any one of the Product(s) of a Selected Category is not in Cart' , 'sumodiscounts' ) ,
                '7' => __( 'Any Products have Tags in Cart' , 'sumodiscounts' ) ,
                '8' => __( 'Any one of the Product(s) of a Selected Tag is in Cart' , 'sumodiscounts' ) ,
                '9' => __( 'Any one of the Product(s) of a Selected Tag is not in Cart' , 'sumodiscounts' ) ,
            ) ,
            'tooltip' => __( 'Cart Discount will be applied based on option selected' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_include_products_for_cart' ,
            'id'          => 'sumo_pricing_apply_to_include_products_for_cart' ,
            'class'       => 'sumo_pricing_apply_to_include_products_for_cart' ,
            'type'        => 'multiselectincproduct' ,
            'label'       => __( 'Include Products' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Products' , 'sumodiscounts' ) ,
            'tooltip'     => __( 'Discount will be applied when any one of the selected products is in cart' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_exclude_products_for_cart' ,
            'id'          => 'sumo_pricing_apply_to_exclude_products_for_cart' ,
            'class'       => 'sumo_pricing_apply_to_exclude_products_for_cart' ,
            'type'        => 'multiselectexcproduct' ,
            'label'       => __( 'Exclude Products' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Products' , 'sumodiscounts' ) ,
            'tooltip'     => __( 'Discount will be applied when any one of the selected products is not in cart' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_include_category_for_cart' ,
            'id'          => 'sumo_pricing_apply_to_include_category_for_cart' ,
            'class'       => 'sumo_pricing_apply_to_include_category_for_cart' ,
            'type'        => 'multiselectinccategory' ,
            'label'       => __( 'Include Categories' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Categories' , 'sumodiscounts' ) ,
            'options'     => $categorylist ,
            'tooltip'     => __( 'Discount will be applied when any one of the Products of the selected category is in cart' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_exclude_category_for_cart' ,
            'id'          => 'sumo_pricing_apply_to_exclude_category_for_cart' ,
            'class'       => 'sumo_pricing_apply_to_exclude_category_for_cart' ,
            'type'        => 'multiselectexccategory' ,
            'label'       => __( 'Exclude Categories' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Categories' , 'sumodiscounts' ) ,
            'options'     => $categorylist ,
            'tooltip'     => __( 'Discount will be applied when any one of the Products of the selected category is not in cart' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_include_tag_for_cart' ,
            'id'          => 'sumo_pricing_apply_to_include_tag_for_cart' ,
            'class'       => 'sumo_pricing_apply_to_include_tag_for_cart' ,
            'type'        => 'multiselectinctag' ,
            'label'       => __( 'Include Tags' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Tags' , 'sumodiscounts' ) ,
            'options'     => $product_tags ,
            'tooltip'     => __( 'Discount will be applied when any one of the Products of the selected tag is in cart' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_pricing_apply_to_exclude_tag_for_cart' ,
            'id'          => 'sumo_pricing_apply_to_exclude_tag_for_cart' ,
            'class'       => 'sumo_pricing_apply_to_exclude_tag_for_cart' ,
            'type'        => 'multiselectexctag' ,
            'label'       => __( 'Exclude Tags' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Select Tags' , 'sumodiscounts' ) ,
            'options'     => $product_tags ,
            'tooltip'     => __( 'Discount will be applied when any one of the Products of the selected tag is not in cart' , 'sumodiscounts' ) ,
        ) ,
            ) ;
    $user_purchase_history               = array(
        array(
            'name'    => 'sumo_user_purchase_history' ,
            'type'    => 'select' ,
            'label'   => __( 'User Purchase History' , 'sumodiscounts' ) ,
            'id'      => 'sumo_user_purchase_history' ,
            'class'   => 'sumo_user_purchase_history' ,
            'options' => array(
                ''  => __( 'None' , 'sumodiscounts' ) ,
                '1' => __( 'Minimum Number of Successful Orders' , 'sumodiscounts' ) ,
                '2' => __( 'Minimum Amount spent on Site' , 'sumodiscounts' )
            ) ,
            'tooltip' => __( 'Restrict Discounts to user based on their number of purchases or total amount spent in site' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'    => 'sumo_u_p_history_time' ,
            'type'    => 'select' ,
            'label'   => __( 'User Purchase History Time' , 'sumodiscounts' ) ,
            'id'      => 'sumo_u_p_history_time' ,
            'class'   => 'sumo_u_p_history_time' ,
            'options' => array(
                ''  => __( 'From Beginning' , 'sumodiscounts' ) ,
                '1' => __( 'Specific Period' , 'sumodiscounts' )
            ) ,
            'tooltip' => __( 'Restrict Discounts to user based on their number of purchases or total amount spent in site' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'    => array(
                'sumo_uph_from_datepicker' , 'sumo_uph_to_datepicker' ,
            ) ,
            'id'      => array(
                'sumo_uph_from_datepicker' , 'sumo_uph_to_datepicker' ,
            ) ,
            'class'   => array(
                'sumo_uph_from_datepicker' , 'sumo_uph_to_datepicker' ,
            ) ,
            'type'    => 'sumo_uph_datepicker' ,
            'label'   => array(
                __( 'From' , 'sumodiscounts' ) . ' &nbsp;' , __( 'Till' , 'sumodiscounts' ) . ' &nbsp;'
            ) ,
            'tooltip' => array(
                __( "The Date from which the User's Purchase History recorded" , "sumodiscounts" ) , __( "The Date till which the User's Purchase History recorded" , "sumodiscounts" ) ,
            ) ,
        ) ,
        array(
            'name'        => 'sumo_no_of_orders_placed' ,
            'type'        => 'number' ,
            'label'       => __( 'Number of orders Placed' , 'sumodiscounts' ) ,
            'id'          => 'sumo_no_of_orders_placed' ,
            'placeholder' => '' ,
            'class'       => 'sumo_no_of_orders_placed' ,
            'tooltip'     => __( 'Rule is applicable for users who has placed more than the number of orders specified.<br>Note: Successful orders refers to orders which are in Processing / Completed Status' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_total_amount_spent_in_site' ,
            'type'        => 'number' ,
            'label'       => __( 'Total Amount Spent ' , 'sumodiscounts' ) . get_woocommerce_currency_symbol() ,
            'id'          => 'sumo_total_amount_spent_in_site' ,
            'placeholder' => '' ,
            'class'       => 'sumo_total_amount_spent_in_site' ,
            'tooltip'     => __( 'Rule is applicable for users who has purchased more than the amount specified in the rule.' , 'sumodiscounts' ) ,
        )
            ) ;
    $pricing_fields_for_carttotalpricing = array(
        array(
            'name'    => array(
                'sumo_pricing_rule_min_total' ,
                'sumo_pricing_rule_max_total' ,
                'sumo_pricing_rule_discount_type' ,
                'sumo_pricing_rule_discount_value' ,
            ) ,
            'id'      => array(
                'sumo_pricing_rule_min_total' ,
                'sumo_pricing_rule_max_total' ,
                'sumo_pricing_rule_discount_type' ,
                'sumo_pricing_rule_discount_value' ,
            ) ,
            'class'   => array(
                'sumo_pricing_rule_min_total' ,
                'sumo_pricing_rule_max_total' ,
                'sumo_pricing_rule_discount_type' ,
                'sumo_pricing_rule_discount_value' ,
            ) ,
            'type'    => 'cart_total_pricing' ,
            'label'   => array(
                __( 'Min Cart Total' , 'sumodiscounts' ) , __( 'Max Cart Total' , 'sumodiscounts' ) , __( 'Discount Type' , 'sumodiscounts' ) , __( 'Value' , 'sumodiscounts' ) ,
            ) ,
            'tooltip' => array(
                __( 'The minimum cart total which the user needs in order to get a Discount' , 'sumodiscounts' ) , __( 'The maximum cart total which the user should not exceed in order to get a Discount' , 'sumodiscounts' ) , __( 'The type of discount which is to be applied can be chosen' , 'sumodiscounts' ) , __( 'Enter Value for discount' , 'sumodiscounts' ) ,
            ) ,
        ) ,
            ) ;
    $pricing_cat_pro_field               = array(
        array(
            'name'    => 'sumo_enable_the_rule' ,
            'id'      => 'sumo_enable_the_rule' ,
            'class'   => 'sumo_enable_the_rule' ,
            'type'    => 'checkbox' ,
            'label'   => __( 'Enable this Rule' , 'sumodiscounts' ) ,
            'default' => 'yes' ,
            'tooltip' => __( 'Enable this checkbox, if you want to consider this rule for providing Discounts' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'    => 'sumo_apply_this_rule_for_sale' ,
            'id'      => 'sumo_apply_this_rule_for_sale' ,
            'class'   => 'sumo_apply_this_rule_for_sale' ,
            'type'    => 'checkbox' ,
            'label'   => __( 'Apply this Rule for Product with Sale Price' , 'sumodiscounts' ) ,
            'default' => 'yes' ,
            'tooltip' => __( 'When enabled, Products with Sale Price will also be considered for providing discounts' , 'sumodiscounts' ) ,
        ) ,
        array(
            'name'        => 'sumo_dynamic_rule_name' ,
            'id'          => 'sumo_dynamic_rule_name' ,
            'class'       => 'sumo_dynamic_rule_name' ,
            'type'        => 'text' ,
            'label'       => __( 'Rule Name' , 'sumodiscounts' ) ,
            'default'     => __( 'Rule Description' , 'sumodiscounts' ) ,
            'placeholder' => __( 'Enter Name of this Rule' , 'sumodiscounts' ) ,
            'tooltip'     => __( 'Enter a Name which can denote the purpose of creating this rule <br> Example: Discounts for Logged In Users' , 'sumodiscounts' ) ,
        ) ,
            ) ;

    $pricing_cat_pro_field1 = array(
        array(
            'name'    => array(
                'sumo_pricing_from_datepicker' , 'sumo_pricing_to_datepicker' ,
            ) ,
            'id'      => array(
                'sumo_pricing_from_datepicker' , 'sumo_pricing_to_datepicker' ,
            ) ,
            'class'   => array(
                'sumo_pricing_from_datepicker' , 'sumo_pricing_to_datepicker' ,
            ) ,
            'type'    => 'datepicker' ,
            'label'   => array(
                __( 'Rule Valid from' , 'sumodiscounts' ) . '&nbsp;' , __( 'Rule Valid Till' , 'sumodiscounts' ) . '&nbsp;'
            ) ,
            'tooltip' => array(
                __( 'The Date from which the Discounts are valid' , 'sumodiscounts' ) , __( 'The Date till which the Discounts are valid' , 'sumodiscounts' ) ,
            ) ,
        ) ,
        array(
            'name'            => array(
                'sumo_pricing_rule_week_monday' ,
                'sumo_pricing_rule_week_tuesday' ,
                'sumo_pricing_rule_week_wednesday' ,
                'sumo_pricing_rule_week_thursday' ,
                'sumo_pricing_rule_week_friday' ,
                'sumo_pricing_rule_week_saturday' ,
                'sumo_pricing_rule_week_sunday' ,
            ) ,
            'id'              => array(
                'sumo_pricing_rule_week_monday' ,
                'sumo_pricing_rule_week_tuesday' ,
                'sumo_pricing_rule_week_wednesday' ,
                'sumo_pricing_rule_week_thursday' ,
                'sumo_pricing_rule_week_friday' ,
                'sumo_pricing_rule_week_saturday' ,
                'sumo_pricing_rule_week_sunday' ,
            ) ,
            'class'           => array(
                'sumo_pricing_rule_week_monday' ,
                'sumo_pricing_rule_week_tuesday' ,
                'sumo_pricing_rule_week_wednesday' ,
                'sumo_pricing_rule_week_thursday' ,
                'sumo_pricing_rule_week_friday' ,
                'sumo_pricing_rule_week_saturday' ,
                'sumo_pricing_rule_week_sunday' ,
            ) ,
            'type'            => 'weekdays' ,
            'week_days_title' => __( 'Rule is valid on the following days ' , 'sumodiscounts' ) ,
            'label'           => array(
                __( 'Monday' , 'sumodiscounts' ) , __( 'Tuesday' , 'sumodiscounts' ) , __( 'Wednesday' , 'sumodiscounts' ) , __( 'Thursday' , 'sumodiscounts' ) , __( 'Friday' , 'sumodiscounts' ) , __( 'Saturday' , 'sumodiscounts' ) , __( 'Sunday' , 'sumodiscounts' )
            ) ,
            'tooltip'         => __( 'If you want to provide discounts only on certain days of a Week then select only those days.' , 'sumodiscounts' ) ,
        ) ,
        $allowfreeshipping ,
        array(
            'name'    => 'sumo_pricing_type' ,
            'type'    => 'select' ,
            'label'   => __( 'Discount Type ' , 'sumodiscounts' ) ,
            'id'      => 'sumo_pricing_type' ,
            'class'   => 'sumo_pricing_type' ,
            'options' => array(
                '1' => __( '% Discount' , 'sumodiscounts' ) ,
                '2' => __( 'Fixed Discount' , 'sumodiscounts' ) ,
                '3' => __( 'Fixed Price' , 'sumodiscounts' )
            ) ,
            'tooltip' => __( 'The type of discount which is to be applied can be chosen' , 'sumodiscounts' )
        ) ,
        array(
            'name'        => 'sumo_discount_value' ,
            'type'        => 'number' ,
            'label'       => __( 'Value' , 'sumodiscounts' ) ,
            'id'          => 'sumo_discount_value' ,
            'placeholder' => '' ,
            'class'       => 'sumo_discount_value' ,
            'tooltip'     => __( 'Enter Value for discount' , 'sumodiscounts' )
        ) ,
            ) ;
    if( $ruletype == 'quantity' ) {
        $pricing_fields = array_merge( $pricing_commonfield , $pricing_fields_for_qty_selection , $pricing_fields_user_filter , $user_purchase_history , $pricing_fields_for_productfilter , $condition_for_include , $pricing_fields_from_datepicker , $pricing_fields_for_qty ) ;
    } elseif( $ruletype == 'offer' ) {
        $pricing_fields = array_merge( $pricing_commonfield , $pricing_fields_user_filter , $user_purchase_history , $pricing_fields_for_productfilter , $condition_for_include , $pricing_fields_from_datepicker , $applicable_to , $pricing_fields_for_offer ) ;
    } elseif( $ruletype == 'quantity_pricing' ) {
        $pricing_fields = $pricing_fields_for_qty ;
    } elseif( $ruletype == 'cart_total_pricing' ) {
        $pricing_fields = array_merge( $pricing_commonfield , $pricing_fields_user_filter , $user_purchase_history , $cartcriteria , $condition_for_include , $pricing_fields_from_datepicker , $pricing_fields_for_carttotalpricing ) ;
    } elseif( $ruletype == 'cart_total' ) {
        $pricing_fields = $pricing_fields_for_carttotalpricing ;
    } elseif( $ruletype == 'specialoffer' ) {
        $pricing_fields = $pricing_fields_for_offer ;
    } elseif( $ruletype == 'cat_pro_pricing' ) {
        $pricing_fields = array_merge( $pricing_cat_pro_field , $pricing_fields_user_filter , $pricing_fields_for_productfilter , $user_purchase_history , $pricing_cat_pro_field1 ) ;
    }
    return $pricing_fields ;
}

/*
 * Common Function For Choosen.
 */

function sumo_pricing_common_chosen_function( $id ) {
    ob_start() ;
    ?>
    <script type="text/javascript">
        jQuery( document ).ready( function() {
            jQuery( '<?php echo $id ; ?>' ).chosen() ;
        } ) ;
    </script>
    <?php
    $getcontent = ob_get_clean() ;
    return $getcontent ;
}

/*
 * Common Function For select.
 */

function sumo_pricing_common_select_function( $id , $placeholder ) {
    ob_start() ;
    ?>
    <script type="text/javascript">
        jQuery( document ).ready( function() {
            jQuery( '<?php echo $id ; ?>' ).select2( { placeholder : "<?php echo $placeholder ; ?>" } ) ;
        } ) ;
    </script>
    <?php
    $getcontent = ob_get_clean() ;
    return $getcontent ;
}

/*
 * Common ajax function to select user.
 */

function sumo_pricing_common_ajax_function_to_select_user( $ajaxid ) {
    global $woocommerce ;
    ob_start() ;
    ?>
    <script type="text/javascript">
    <?php if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
            jQuery( function() {
                jQuery( 'select.<?php echo $ajaxid ; ?>' ).ajaxChosen( {
                    method : 'GET' ,
                    url : '<?php echo admin_url( 'admin-ajax.php' ) ; ?>' ,
                    dataType : 'json' ,
                    afterTypeDelay : 100 ,
                    data : {
                        action : 'woocommerce_json_search_customers' ,
                        security : '<?php echo wp_create_nonce( "search-customers" ) ; ?>'
                    }
                } , function( data ) {
                    var terms = { } ;

                    jQuery.each( data , function( i , val ) {
                        terms[i] = val ;
                    } ) ;
                    return terms ;
                } ) ;
            } ) ;
    <?php } ?>
    </script>
    <?php
    $getcontent = ob_get_clean() ;
    return $getcontent ;
}

/*
 * Common Ajax Function to select products
 */

function sumo_pricing_common_ajax_function_to_select_product( $ajaxid ) {
    global $woocommerce ;
    ob_start() ;
    ?>
    <script type="text/javascript">
    <?php if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
            jQuery( function() {
                jQuery( "select.<?php echo $ajaxid ; ?>" ).ajaxChosen( {
                    method : 'GET' ,
                    url : '<?php echo admin_url( 'admin-ajax.php' ) ; ?>' ,
                    dataType : 'json' ,
                    afterTypeDelay : 100 ,
                    data : {
                        action : 'woocommerce_json_search_products_and_variations' ,
                        security : '<?php echo wp_create_nonce( "search-products" ) ; ?>'
                    }
                } , function( data ) {
                    var terms = { } ;

                    jQuery.each( data , function( i , val ) {
                        terms[i] = val ;
                    } ) ;
                    return terms ;
                } ) ;
            } ) ;
    <?php } ?>
    </script>
    <?php
    $getcontent = ob_get_clean() ;
    return $getcontent ;
}

function display_data_after_saved( $uniqid , $ruletype , $nameforinputfield ) {
    if( $ruletype == 'quantity' ) {
        $get_list_of_array = generate_dynamic_rule_pricing_fields( $ruletype ) ;
        $get_data          = get_option( 'sumo_pricing_rule_fields_for_qty' ) ;
        $get_data          = array_sort_by_key( $get_data , ( array ) get_option( 'sumo_dynamic_pricing_drag_position_for_qty' ) ) ;
        $get_data          = $get_data[ $uniqid ] ;
    } elseif( $ruletype == 'cart_total_pricing' ) {
        $get_list_of_array = generate_dynamic_rule_pricing_fields( $ruletype ) ;
        $get_data          = get_option( 'sumo_pricing_rule_fields_for_cart' ) ;
        $get_data          = array_sort_by_key( $get_data , ( array ) get_option( 'sumo_dynamic_pricing_drag_position_for_cart' ) ) ;
        $get_data          = $get_data[ $uniqid ] ;
    } elseif( $ruletype == 'offer' ) {
        $get_list_of_array = generate_dynamic_rule_pricing_fields( $ruletype ) ;
        $get_data          = get_option( 'sumo_pricing_rule_fields_for_offer' ) ;
        $get_data          = array_sort_by_key( $get_data , ( array ) get_option( 'sumo_dynamic_pricing_drag_position_for_offer' ) ) ;
        $get_data          = $get_data[ $uniqid ] ;
    } elseif( $ruletype == 'cat_pro_pricing' ) {
        $get_list_of_array = generate_dynamic_rule_pricing_fields( $ruletype ) ;
        $get_data          = get_option( 'sumo_pricing_rule_fields_for_cat_pro' ) ;
        $get_data          = array_sort_by_key( $get_data , ( array ) get_option( 'sumo_dynamic_pricing_drag_position_for_cat_pro' ) ) ;
        $get_data          = $get_data[ $uniqid ] ;
    }
    ob_start() ;
    foreach( $get_list_of_array as $key => $new_fields ) {
        switch( $new_fields[ 'type' ] ) {
            case 'title':
                ?>
                <br>
                <p class="form-field">
                    <b><?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?></b>
                </p>
                <br>
                <?php
                break ;
            case 'text':
                ?>
                <p class="form-field">
                    <b><?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><input name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][<?php echo $new_fields[ 'name' ] ; ?>]" type="<?php echo $new_fields[ 'type' ] ?>" value="<?php echo $get_data[ $new_fields[ 'name' ] ] ; ?>" placeholder="<?php echo $new_fields[ 'placeholder' ] ; ?>"/><br><br>
                </p>
                <?php
                break ;
            case 'number':
                ?>
                <p class="form-field">
                    <b><?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;<span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><input class="<?php echo $new_fields[ 'id' ] . $uniqid ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][<?php echo $new_fields[ 'name' ] ; ?>]" type="<?php echo $new_fields[ 'type' ] ?>" value="<?php echo $get_data[ $new_fields[ 'name' ] ] ; ?>" step="any" min="0.01"/><br><br>
                </p>
                <?php
                break ;
            case "select":
                $select_value = isset( $get_data[ $new_fields[ 'name' ] ] ) ? $get_data[ $new_fields[ 'name' ] ] : '' ;
                ?>
                <p class="form-field">
                    <b><?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select  class="<?php echo $new_fields[ 'class' ] . $uniqid ; ?>" id="<?php echo $new_fields[ 'id' ] . $uniqid ; ?>" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][<?php echo $new_fields[ 'name' ] ; ?>]">
                        <?php foreach( $new_fields[ 'options' ] as $key => $options ) {
                            ?>
                            <option value="<?php echo $key ; ?>" <?php echo selected( $key , $select_value ) ; ?>><?php echo $options ; ?></option>
                            <?php
                        }
                        ?>
                    </select><br><br>
                </p>
                <?php
                break ;
            case "checkbox":
                $option_name = $new_fields[ 'name' ] ;
                ?>
                <p class="form-field">
                    <b><?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><input type="checkbox" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][<?php echo $new_fields[ 'name' ] ; ?>]" value="yes"<?php
                    if( isset( $get_data[ $option_name ] ) ) {
                        checked( 'yes' , $get_data[ $option_name ] ) ;
                    }
                    ?>/>
                    <br><br>
                </p>
                <?php
                break ;
            case "datepicker":
                ?>
                <p class="form-field" style="display:flex;">
                    <?php
                    $label_one = $new_fields[ 'label' ][ 0 ] ;
                    $label_two = $new_fields[ 'label' ][ 1 ] ;

                    $name_one  = $new_fields[ 'name' ][ 0 ] ;
                    $name_two  = $new_fields[ 'name' ][ 1 ] ;
                    ?>
                    <b><?php _e( $label_one , 'sumodiscounts' ) ; ?></b><span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 0 ] ; ?>"></span><input type="text" placeholder="dd-mm-yy" class="sp_date" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][<?php echo $name_one ; ?>]"  value="<?php echo isset( $get_data[ $name_one ] ) ? $get_data[ $name_one ] : '' ; ?>" id="from_<?php echo $uniqid ; ?>" style="width:200px;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <b><?php _e( $label_two , 'sumodiscounts' ) ; ?></b><span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 1 ] ; ?>"></span><input type="text" placeholder="dd-mm-yy" class="sp_date" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][<?php echo $name_two ; ?>]" value="<?php echo isset( $get_data[ $name_two ] ) ? $get_data[ $name_two ] : '' ; ?>" id="to_<?php echo $uniqid ; ?>" style="width:200px;"/>
                </p>
                <?php
                break ;
            case "sumo_uph_datepicker":
                ?>
                <p class="form-field" style="display:flex;">
                    <?php
                    $label_one = $new_fields[ 'label' ][ 0 ] ;
                    $label_two = $new_fields[ 'label' ][ 1 ] ;

                    $name_one    = $new_fields[ 'name' ][ 0 ] ;
                    $name_two    = $new_fields[ 'name' ][ 1 ] ;
                    ?>
                    <b><?php _e( $label_one , 'sumodiscounts' ) ; ?></b><span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 0 ] ; ?>"></span><input type="text" placeholder="yy-mm-dd" class="sp__date" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][<?php echo $name_one ; ?>]"  value="<?php echo isset( $get_data[ $name_one ] ) ? $get_data[ $name_one ] : '' ; ?>" id="sumo_uph_from_datepicker<?php echo $uniqid ; ?>" style="width:200px;"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                    <b><?php _e( $label_two , 'sumodiscounts' ) ; ?></b><span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 1 ] ; ?>"></span><input type="text" placeholder="yy-mm-dd" class="sp__date" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][<?php echo $name_two ; ?>]" value="<?php echo isset( $get_data[ $name_two ] ) ? $get_data[ $name_two ] : '' ; ?>" id="sumo_uph_to_datepicker<?php echo $uniqid ; ?>" style="width:200px;"/>
                </p>
                <?php
                break ;
            case "weekdays":
                $label_name  = $new_fields[ 'label' ] ;
                $option_name = $new_fields[ 'name' ] ;
                $title_name  = $new_fields[ 'week_days_title' ] ;
                ?>
                <p class="form-field">
                    <label><?php _e( "$title_name" , 'sumodiscounts' ) ; ?><span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span></label>
                    <?php
                    foreach( $option_name as $key => $eachname ) {
                        ?>
                        <input type="checkbox" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][<?php echo $eachname ; ?>]" value="1"<?php
                        if( isset( $get_data[ $eachname ] ) ) {
                            checked( '1' , $get_data[ $eachname ] ) ;
                        }
                        ?>/> <?php echo $new_fields[ 'label' ][ $key ] ; ?><br>
                               <?php
                           }
                           ?>
                </p>
                <?php
                break ;
            case "multiselectincuser":
                $classname   = isset( $new_fields[ 'class' ] ) ? $new_fields[ 'class' ] : '' ;
                $includeuser = isset( $get_data[ 'sumo_pricing_apply_to_include_users' ] ) ? $get_data[ 'sumo_pricing_apply_to_include_users' ] : '' ;
                $label       = '' ;
                $id          = '' ;
                sumo_function_to_select_users( $id , $label , $classname , $uniqid , $nameforinputfield , $new_fields , $includeuser ) ;
                break ;

            case "multiselectexcuser":
                $classname   = isset( $new_fields[ 'class' ] ) ? $new_fields[ 'class' ] : '' ;
                $excludeuser = isset( $get_data[ 'sumo_pricing_apply_to_exclude_users' ] ) ? $get_data[ 'sumo_pricing_apply_to_exclude_users' ] : '' ;
                $label       = '' ;
                $id          = '' ;
                sumo_function_to_select_users( $id , $label , $classname , $uniqid , $nameforinputfield , $new_fields , $excludeuser ) ;
                break ;

            case "multiselect":
                $classname = isset( $new_fields[ 'class' ] ) ? $new_fields[ 'class' ] : '' ;
                sumo_function_to_select_userrole( $classname , $uniqid , $nameforinputfield , $new_fields , $get_data ) ;
                break ;

            case "multiselect1":
                $classname = isset( $new_fields[ 'class' ] ) ? $new_fields[ 'class' ] : '' ;
                sumo_function_to_select_userrole( $classname , $uniqid , $nameforinputfield , $new_fields , $get_data ) ;
                break ;
            case "multiselectincproduct":
                $classname = isset( $new_fields[ 'class' ] ) ? $new_fields[ 'class' ] : '' ;
                if( $ruletype == 'cart_total_pricing' ) {
                    $includeproduct = isset( $get_data[ 'sumo_pricing_apply_to_include_products_for_cart' ] ) ? $get_data[ 'sumo_pricing_apply_to_include_products_for_cart' ] : '' ;
                } elseif( $ruletype == 'quantity' || $ruletype == 'offer' || $ruletype == 'cat_pro_pricing' ) {
                    $includeproduct = isset( $get_data[ 'sumo_pricing_apply_to_include_products' ] ) ? $get_data[ 'sumo_pricing_apply_to_include_products' ] : '' ;
                }
                $label     = '' ;
                $id        = '' ;
                sumo_function_to_select_product( $id , $label , $classname , $uniqid , $nameforinputfield , $new_fields , $includeproduct ) ;
                break ;
            case "multiselectfreeproduct_soat":
                $classname = isset( $new_fields[ 'class' ] ) ? $new_fields[ 'class' ] : '' ;
                if( $ruletype == 'offer' ) {
                    $freeproduct = isset( $get_data[ 'sumo_special_offer_apply_to_free_products' ] ) ? $get_data[ 'sumo_special_offer_apply_to_free_products' ] : '' ;
                }
                $label     = '' ;
                $id        = '' ;
                sumo_function_to_select_product( $id , $label , $classname , $uniqid , $nameforinputfield , $new_fields , $freeproduct , false ) ;
                break ;
            case "multiselectincproduct_soat":
                $classname = isset( $new_fields[ 'class' ] ) ? $new_fields[ 'class' ] : '' ;
                if( $ruletype == 'offer' ) {
                    $includeproduct = isset( $get_data[ 'sumo_special_offer_apply_to_include_products' ] ) ? $get_data[ 'sumo_special_offer_apply_to_include_products' ] : '' ;
                }
                $label = '' ;
                $id    = '' ;
                sumo_function_to_select_product( $id , $label , $classname , $uniqid , $nameforinputfield , $new_fields , $includeproduct ) ;
                break ;

            case "multiselectexcproduct_soat":
                $classname = isset( $new_fields[ 'class' ] ) ? $new_fields[ 'class' ] : '' ;
                if( $ruletype == 'offer' ) {
                    $includeproduct = isset( $get_data[ 'sumo_special_offer_apply_to_exclude_products' ] ) ? $get_data[ 'sumo_special_offer_apply_to_exclude_products' ] : '' ;
                }
                $label = '' ;
                $id    = '' ;
                sumo_function_to_select_product( $id , $label , $classname , $uniqid , $nameforinputfield , $new_fields , $includeproduct ) ;
                break ;

            case "multiselectexcproduct":
                $classname = isset( $new_fields[ 'class' ] ) ? $new_fields[ 'class' ] : '' ;
                if( $ruletype == 'cart_total_pricing' ) {
                    $excludeproduct = isset( $get_data[ 'sumo_pricing_apply_to_exclude_products_for_cart' ] ) ? $get_data[ 'sumo_pricing_apply_to_exclude_products_for_cart' ] : '' ;
                } elseif( $ruletype == 'quantity' || $ruletype == 'offer' || $ruletype == 'cat_pro_pricing' ) {
                    $excludeproduct = isset( $get_data[ 'sumo_pricing_apply_to_exclude_products' ] ) ? $get_data[ 'sumo_pricing_apply_to_exclude_products' ] : '' ;
                }
                $label = '' ;
                $id    = '' ;
                sumo_function_to_select_product( $id , $label , $classname , $uniqid , $nameforinputfield , $new_fields , $excludeproduct ) ;
                break ;

            case "multiselectincproductapplyon":
                global $woocommerce ;
                $fieldclassname  = isset( $new_fields[ 'class' ] ) ? $new_fields[ 'class' ] : '' ;
                $fieldid         = $new_fields[ 'id' ] . $uniqid ;
                $add_array       = ( float ) WC()->version < ( float ) '3.0.0' ? '' : '[]' ;
                $fieldname       = $nameforinputfield . "[" . $uniqid . "][" . $new_fields[ 'name' ] . "]" . $add_array ;
                $selectedproduct = isset( $get_data[ 'sumo_pricing_apply_on_include_products' ] ) ? $get_data[ 'sumo_pricing_apply_on_include_products' ] : '' ;
                ?>
                <p class="form-field">
                    <b>
                        <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
                    </b>
                    <?php if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $fieldclassname ; ?>" name="<?php echo $fieldname ; ?>" style="max-width:350px;" id="<?php echo $fieldid ; ?>">
                            <?php
                            if( $selectedproduct != "" ) {
                                if( ! empty( $selectedproduct ) ) {
                                    $list_of_produts = ( array ) $selectedproduct ;
                                    foreach( $list_of_produts as $rs_free_id ) {
                                        $product = sumo_sd_get_product( $rs_free_id ) ;
                                        if( $product ) {
                                            echo '<option value="' . $rs_free_id . '" ' ;
                                            selected( 1 , 1 ) ;
                                            echo '>' . ' #' . $rs_free_id . ' &ndash; ' . get_the_title( $rs_free_id ) ;
                                        }
                                    }
                                }
                            } else {
                                ?>
                                <option value=""></option>
                                <?php
                            }
                            ?>
                        </select>
                    <?php } else { ?>
                        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
                        <?php if( WC()->version < ( float ) '3.0.0' ) { ?>
                            <input type="hidden" class="wc-product-search" style="max-width:350px;" name="<?php echo $fieldname ; ?>" id="<?php echo $fieldid ; ?>" data-placeholder="<?php _e( 'Search Products' , 'sumodiscounts' ) ; ?>"  data-allow_clear="true" data-selected="<?php
                            $json_ids = array() ;
                            if( $selectedproduct !== NULL ) {
                                if( ! is_array( $selectedproduct ) ) {
                                    $product_ids = explode( ',' , $selectedproduct ) ;
                                } else {
                                    $product_ids = $selectedproduct ;
                                }
                                foreach( $product_ids as $product_id ) {
                                    if( isset( $product_id ) ) {
                                        $product = sumo_sd_get_product( $product_id ) ;
                                        if( is_object( $product ) ) {
                                            $json_ids[ $product_id ] = wp_kses_post( $product->get_formatted_name() ) ;
                                        }
                                    }
                                } echo esc_attr( json_encode( $json_ids ) ) ;
                            }
                            ?>" value="<?php
                                   if( $selectedproduct != "" ) {
                                       echo implode( ',' , array_keys( $json_ids ) ) ;
                                   } else {
                                       echo '' ;
                                   }
                                   ?>" />
                               <?php } else {
                                   ?>
                            <select class="wc-product-search" style="width:350px" style="max-width:350px;" multiple="multiple" name="<?php echo $fieldname ; ?>" id="<?php echo $fieldid ; ?>" data-placeholder="<?php _e( 'Search Products' , 'sumodiscounts' ) ; ?>"  data-allow_clear="true">
                                <?php
                                if( ! is_array( $selectedproduct ) ) {
                                    $selectedproduct = explode( ',' , $selectedproduct ) ;
                                }
                                foreach( $selectedproduct as $each_product ) {
                                    $product_obj = sumo_sd_get_product( $each_product ) ;
                                    if( $product_obj ) {
                                        echo '<option value="' . $each_product . '"' . selected( 1 , 1 ) . '>' . wp_kses_post( $product_obj->get_formatted_name() ) . '</option>' ;
                                    }
                                }
                                ?>
                            </select>
                            <?php
                        }
                    }
                    ?>
                </p>
                <?php
                echo sumo_pricing_common_ajax_function_to_select_product( $fieldclassname ) ;
                break ;
            case "multiselectinccategory":
                $classname = isset( $new_fields[ 'class' ] ) ? $new_fields[ 'class' ] : '' ;
                sumo_function_to_select_category( $classname , $uniqid , $nameforinputfield , $new_fields , $get_data ) ;
                break ;

            case "multiselectexccategory":
                $classname = isset( $new_fields[ 'class' ] ) ? $new_fields[ 'class' ] : '' ;
                sumo_function_to_select_category( $classname , $uniqid , $nameforinputfield , $new_fields , $get_data ) ;
                break ;
            case "multiselectinctag":
                $classname = isset( $new_fields[ 'class' ] ) ? $new_fields[ 'class' ] : '' ;
                sumo_function_to_select_tag( $classname , $uniqid , $nameforinputfield , $new_fields , $get_data ) ;
                break ;
            case "multiselectexctag":
                $classname = isset( $new_fields[ 'class' ] ) ? $new_fields[ 'class' ] : '' ;
                sumo_function_to_select_tag( $classname , $uniqid , $nameforinputfield , $new_fields , $get_data ) ;
                break ;
            case "multiselectincmemberplans" :
                if( class_exists( 'SUMOMemberships' ) && sumo_get_membership_levels() ) {
                    global $woocommerce ;
                    ?>
                    <p class="form-field">
                        <b>
                            <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
                        </b>
                        <?php
                        if( ( float ) WC()->version < ( float ) '3.0.0' ) {
                            ?>
                            <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
                            <input type="text" class="<?php echo $new_fields[ 'class' ] . $uniqid ; ?> sumomembership_plans_select" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][<?php echo $new_fields[ 'name' ] ; ?>]" style="width:343px;" id="<?php echo $new_fields[ 'id' ] . $uniqid ; ?>"/>

                        <?php } else { ?>
                            <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
                            <?php
                            $add_array = ( float ) WC()->version < ( float ) '3.0.0' ? '' : '[]' ;
                            $name      = $nameforinputfield . '[' . $uniqid . '][' . $new_fields[ 'name' ] . ']' . $add_array ;
                            $plan_ids  = isset( $get_data[ 'sumo_pricing_apply_to_include_memberplans' ] ) ? $get_data[ 'sumo_pricing_apply_to_include_memberplans' ] : array() ;
                            ?>
                            <select name="<?php echo $name ?>" class="sumomembership_plans_select" multiple="multiple" id="<?php echo $new_fields[ 'id' ] . $uniqid ?>" style="width:320px;">
                                <?php
                                foreach( $plan_ids as $plan_id ) {
                                    echo '<option value="' . $plan_id . '"' . selected( 1 , 1 ) . '>' . get_the_title( $plan_id ) . '</option>' ;
                                }
                                ?>
                            </select>
                            <?php
                        }
                        echo sumo_pricing_common_ajax_function_to_select_member_plans() ;
                        ?>
                    </p>
                    <?php
                }
                break ;

            case "quantity_pricing":
                $label_name    = $new_fields[ 'label' ] ;
                $option_name   = $new_fields[ 'name' ] ;
                $quantity_rule = isset( $get_data[ 'sumo_quantity_rule' ] ) ? $get_data[ 'sumo_quantity_rule' ] : array() ;
                ?>
                <div class="sumo_quantity_rule_<?php echo $uniqid ; ?>">
                    <?php
                    if( is_array( $quantity_rule ) && ! empty( $quantity_rule ) ) {
                        foreach( $quantity_rule as $key => $value ) {
                            $get_datas = $quantity_rule[ $key ] ;
                            ?>
                            <p class="form-field" style="display: flex;">
                                <label>
                                    <?php _e( $new_fields[ 'label' ][ 0 ] , 'sumodiscounts' ) ; ?>
                                </label>

                                <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 0 ] ; ?>"></span><input type="text" class="sumo_number_input" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][sumo_quantity_rule][<?php echo $key ; ?>][<?php echo $new_fields[ 'name' ][ 0 ] ; ?>]" value="<?php echo $get_datas[ $new_fields[ 'name' ][ 0 ] ] ; ?>"/>

                                <label>
                                    <?php _e( $new_fields[ 'label' ][ 1 ] , 'sumodiscounts' ) ; ?>
                                </label>
                                <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 1 ] ; ?>"></span><input type="text" class="sumo_number_input" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][sumo_quantity_rule][<?php echo $key ; ?>][<?php echo $new_fields[ 'name' ][ 1 ] ; ?>]" value="<?php echo $get_datas[ $new_fields[ 'name' ][ 1 ] ] ; ?>"/>

                                <label>
                                    <?php _e( $new_fields[ 'label' ][ 2 ] , 'sumodiscounts' ) ; ?>
                                </label>
                                <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 2 ] ; ?>"></span><select name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][sumo_quantity_rule][<?php echo $key ; ?>][<?php echo $new_fields[ 'name' ][ 2 ] ; ?>]">
                                    <option value="1" <?php echo selected( "1" , $get_datas[ $new_fields[ 'name' ][ 2 ] ] ) ; ?>><?php _e( '% Discount' , 'sumodiscounts' ) ; ?></option>
                                    <option value="2" <?php echo selected( "2" , $get_datas[ $new_fields[ 'name' ][ 2 ] ] ) ; ?>><?php _e( 'Fixed Discount' , 'sumodiscounts' ) ; ?></option>
                                    <option value="3" <?php echo selected( "3" , $get_datas[ $new_fields[ 'name' ][ 2 ] ] ) ; ?>><?php _e( 'Fixed Price' , 'sumodiscounts' ) ; ?></option>
                                </select>

                                <label>
                                    <?php _e( $new_fields[ 'label' ][ 3 ] , 'sumodiscounts' ) ; ?>
                                </label>

                                <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 3 ] ; ?>"></span>
                                <input type="number" min=".01" step="any" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][sumo_quantity_rule][<?php echo $key ; ?>][<?php echo $new_fields[ 'name' ][ 3 ] ; ?>]" value="<?php echo $get_datas[ $new_fields[ 'name' ][ 3 ] ] ; ?>"/>


                                <input type="checkbox" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][sumo_quantity_rule][<?php echo $key ; ?>][<?php echo $new_fields[ 'name' ][ 4 ] ; ?>]" value="yes"<?php
                                if( isset( $get_datas[ 'sumo_pricing_rule_repeat_discount' ] ) ) {
                                    checked( 'yes' , $get_datas[ 'sumo_pricing_rule_repeat_discount' ] ) ;
                                }
                                ?>/>
                                <label>
                                    <b><?php _e( $new_fields[ 'label' ][ 4 ] , 'sumodiscounts' ) ; ?></b><br><br>
                                </label>
                                <span class="delete_row button-secondary"><?php _e( 'Delete Row' , 'sumodiscounts' ) ; ?></span>
                            </p>
                            <?php
                        }
                    }
                    ?>
                </div>
                <span class="add_new_row_for_quantity<?php echo $uniqid ; ?> button-primary"><?php echo __( 'Add New Row' , 'sumodiscounts' ) ?></span>
                <script type="text/javascript">
                    jQuery( function() {
                        jQuery( document ).on( 'click' , '.add_new_row_for_quantity<?php echo $uniqid ; ?>' , function() {
                            jQuery.ajax( {
                                data : ( {
                                    action : 'sumo_pricing_uniqid_for_qty' ,
                                    rule_type : 'quantity' ,
                                    uniq_id : '<?php echo $uniqid ; ?>' ,
                                } ) ,
                                type : 'POST' ,
                                url : "<?php echo admin_url( 'admin-ajax.php' ) ; ?>" ,
                                success : function( response ) {
                                    console.log( response ) ;
                                    jQuery( '.sumo_quantity_rule_<?php echo $uniqid ; ?>' ).append( response ) ;
                                }

                            } ) ;
                        } ) ;
                    } ) ;
                </script>
                <?php
                break ;
            case "offer_pricing":
                $label_name    = $new_fields[ 'label' ] ;
                $option_name   = $new_fields[ 'name' ] ;
                $quantity_rule = isset( $get_data[ 'sumo_offer_rule' ] ) ? $get_data[ 'sumo_offer_rule' ] : array() ;
                ?>
                <div class="sumo_offer_rule_<?php echo $uniqid ; ?>">
                    <?php
                    if( is_array( $quantity_rule ) && ! empty( $quantity_rule ) ) {
                        foreach( $quantity_rule as $key => $value ) {
                            $get_datas = $quantity_rule[ $key ] ;
                            ?>
                            <p class="form-field" style="display: flex;">
                                <label>
                                    <?php _e( $new_fields[ 'label' ][ 0 ] , 'sumodiscounts' ) ; ?>
                                </label>
                                <input type="number" min="1" step="1" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][sumo_offer_rule][<?php echo $key ; ?>][<?php echo $new_fields[ 'name' ][ 0 ] ; ?>]" value="<?php echo $get_datas[ $new_fields[ 'name' ][ 0 ] ] ; ?>"/>

                                <label>
                                    <?php _e( $new_fields[ 'label' ][ 1 ] , 'sumodiscounts' ) ; ?>
                                </label>
                                <input type="number" min="1" step="1" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][sumo_offer_rule][<?php echo $key ; ?>][<?php echo $new_fields[ 'name' ][ 1 ] ; ?>]" value="<?php echo $get_datas[ $new_fields[ 'name' ][ 1 ] ] ; ?>"/>

                                <label>
                                    <?php _e( $new_fields[ 'label' ][ 2 ] , 'sumodiscounts' ) ; ?>
                                </label>
                                <select name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][sumo_offer_rule][<?php echo $key ; ?>][<?php echo $new_fields[ 'name' ][ 2 ] ; ?>]">
                                    <option value="1" <?php echo selected( "1" , $get_datas[ $new_fields[ 'name' ][ 2 ] ] ) ; ?>><?php _e( '% Discount' , 'sumodiscounts' ) ; ?></option>
                                    <option value="2" <?php echo selected( "2" , $get_datas[ $new_fields[ 'name' ][ 2 ] ] ) ; ?>><?php _e( 'Fixed Discount' , 'sumodiscounts' ) ; ?></option>
                                    <option value="3" <?php echo selected( "3" , $get_datas[ $new_fields[ 'name' ][ 2 ] ] ) ; ?>><?php _e( 'Fixed Price' , 'sumodiscounts' ) ; ?></option>
                                </select>

                                <label>
                                    <?php _e( $new_fields[ 'label' ][ 3 ] , 'sumodiscounts' ) ; ?>
                                </label>

                                <input type="number" min=".01" step="any" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][sumo_offer_rule][<?php echo $key ; ?>][<?php echo $new_fields[ 'name' ][ 3 ] ; ?>]" value="<?php echo $get_datas[ $new_fields[ 'name' ][ 3 ] ] ; ?>"/>

                                <input type="checkbox" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][sumo_offer_rule][<?php echo $key ; ?>][<?php echo $new_fields[ 'name' ][ 4 ] ; ?>]" value="yes"<?php
                                if( isset( $get_datas[ $new_fields[ 'name' ][ 4 ] ] ) ) {
                                    checked( 'yes' , $get_datas[ $new_fields[ 'name' ][ 4 ] ] ) ;
                                }
                                ?>/>
                                <label>
                                    <?php _e( $new_fields[ 'label' ][ 4 ] , 'sumodiscounts' ) ; ?>
                                </label>
                                <span class="delete_row button-secondary"><?php _e( 'Delete Row' , 'sumodiscounts' ) ; ?></span>
                            </p>
                            <?php
                        }
                    }
                    ?>
                </div>
                <span class="add_new_row_for_offer<?php echo $uniqid ; ?> button-primary"><?php echo __( 'Add New Row' , 'sumodiscounts' ) ?></span>
                <script type="text/javascript">
                    jQuery( function() {
                        jQuery( document ).on( 'click' , '.add_new_row_for_offer<?php echo $uniqid ; ?>' , function() {
                            jQuery.ajax( {
                                data : ( {
                                    action : 'sumo_pricing_uniqid_for_offer' ,
                                    rule_type : 'specialoffer' ,
                                    uniq_id : '<?php echo $uniqid ; ?>' ,
                                } ) ,
                                type : 'POST' ,
                                url : "<?php echo admin_url( 'admin-ajax.php' ) ; ?>" ,
                                success : function( response ) {
                                    console.log( response ) ;
                                    jQuery( '.sumo_offer_rule_<?php echo $uniqid ; ?>' ).append( response ) ;
                                }

                            } ) ;
                        } ) ;
                    } ) ;
                </script>
                <?php
                break ;
            case "cart_total_pricing":
                $label_name      = $new_fields[ 'label' ] ;
                $option_name     = $new_fields[ 'name' ] ;
                $cart_total_rule = isset( $get_data[ 'sumo_cart_total_rule' ] ) ? $get_data[ 'sumo_cart_total_rule' ] : array() ;
                ?>
                <div class="sumo_cart_total_rule_<?php echo $uniqid ; ?>">
                    <?php
                    if( is_array( $cart_total_rule ) && ! empty( $cart_total_rule ) ) {
                        foreach( $cart_total_rule as $key => $value ) {
                            $get_datas = $cart_total_rule[ $key ] ;
                            ?>
                            <p class="form-field" style="display: flex;">
                                <label>
                                    <?php _e( $new_fields[ 'label' ][ 0 ] , 'sumodiscounts' ) ; ?>
                                </label>
                                <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 0 ] ; ?>"></span><input type="text" class="sumo_number_input" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][sumo_cart_total_rule][<?php echo $key ; ?>][<?php echo $new_fields[ 'name' ][ 0 ] ; ?>]" value="<?php echo $get_datas[ $new_fields[ 'name' ][ 0 ] ] ; ?>"/>

                                <label>
                                    <?php _e( $new_fields[ 'label' ][ 1 ] , 'sumodiscounts' ) ; ?>
                                </label>
                                <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 1 ] ; ?>"></span><input type="text" class="sumo_number_input" required="required" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][sumo_cart_total_rule][<?php echo $key ; ?>][<?php echo $new_fields[ 'name' ][ 1 ] ; ?>]" value="<?php echo $get_datas[ $new_fields[ 'name' ][ 1 ] ] ; ?>"/>

                                <label>
                                    <?php _e( $new_fields[ 'label' ][ 2 ] , 'sumodiscounts' ) ; ?>
                                </label>
                                <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 2 ] ; ?>"></span><select name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][sumo_cart_total_rule][<?php echo $key ; ?>][<?php echo $new_fields[ 'name' ][ 2 ] ; ?>]">
                                    <option value="1" <?php echo selected( "1" , $get_datas[ $new_fields[ 'name' ][ 2 ] ] ) ; ?>>% Discount</option>
                                    <option value="2" <?php echo selected( "2" , $get_datas[ $new_fields[ 'name' ][ 2 ] ] ) ; ?>>Fixed Discount</option>
                                </select>

                                <label>
                                    <?php _e( $new_fields[ 'label' ][ 3 ] , 'sumodiscounts' ) ; ?>
                                </label>

                                <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ][ 3 ] ; ?>"></span><input type="number" step="any" required="required" min=".01" style="width:100px" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][sumo_cart_total_rule][<?php echo $key ; ?>][<?php echo $new_fields[ 'name' ][ 3 ] ; ?>]" value="<?php echo $get_datas[ $new_fields[ 'name' ][ 3 ] ] ; ?>"/>

                                <span class="delete_row button-secondary"><?php _e( 'Delete Row' , 'sumodiscounts' ) ; ?></span>
                            </p>
                            <?php
                        }
                    }
                    ?>
                </div>
                <span class="add_new_row_for_cart_total<?php echo $uniqid ; ?> button-primary"><?php echo __( 'Add New Row' , 'sumodiscounts' ) ?></span>
                <script type="text/javascript">
                    jQuery( function() {
                        jQuery( document ).on( 'click' , '.add_new_row_for_cart_total<?php echo $uniqid ; ?>' , function() {
                            jQuery.ajax( {
                                data : ( {
                                    action : 'sumo_pricing_uniqid_for_cart' ,
                                    rule_type : 'cart_total' ,
                                    uniq_id : '<?php echo $uniqid ; ?>' ,
                                } ) ,
                                type : 'POST' ,
                                url : "<?php echo admin_url( 'admin-ajax.php' ) ; ?>" ,
                                success : function( response ) {
                                    console.log( response ) ;
                                    jQuery( '.sumo_cart_total_rule_<?php echo $uniqid ; ?>' ).append( response ) ;
                                }

                            } ) ;
                        } ) ;
                    } ) ;
                </script>
                <?php
                break ;
        }
    }
    SUMOQuantityPricing::show_or_hide( $uniqid ) ;
    SUMOOfferPricing::show_or_hide( $uniqid ) ;
    SUMOCartPricing::show_or_hide( $uniqid ) ;
    SUMOCategoryProductPricing::show_or_hide( $uniqid ) ;
    $get_data = ob_get_clean() ;
    return $get_data ;
}

// Sort the Array Function
function array_sort_by_key( $array1 , $array2 ) {
    $array3 = array() ;
    foreach( $array2 as $key ) {
        if( isset( $array1[ $key ] ) ) {
            $array3[ $key ] = $array1[ $key ] ;
            unset( $array1[ $key ] ) ;
        }
    }
    return $array3 + $array1 ;
}

function log_to_find_error( $msg ) {
    $bt     = debug_backtrace() ;
    $caller = array_shift( $bt ) ;
    return $caller ;
}

function clear_session_values() {
    if( ! is_admin() ) {
        global $woocommerce ;
        $cart_contents = $woocommerce->cart->cart_contents ;
        if( empty( $cart_contents ) ) {
            WC()->session->__unset( 'cart_discount' ) ;
            WC()->session->__unset( 'cart_discount_value' ) ;
            WC()->session->__unset( 'applied_cart_discount_rule_id' ) ;
            WC()->session->__unset( 'applied_srp_discount_rule_id' ) ;
            WC()->session->__unset( 'applied_catpro_discount_rule_id' ) ;
            WC()->session->__unset( 'check_if_fee_exist' ) ;
        }
    }
}

add_action( 'wp_head' , 'clear_session_values' ) ;

function sumo_function_for_product_and_category_filter( $productid , $newarray , $bool = false ) {

    if( isset( $newarray[ 'product_type' ] ) && $newarray[ 'product_type' ] != "1" && $newarray[ 'product_type' ] != "2" && $newarray[ 'product_type' ] != "3" ) {

        $category_product = sumo_sd_get_product( $productid ) ;
        $cat_productid    = $productid ;

        if( $category_product->is_type( 'variation' ) )
            $cat_productid = sumo_sd_get_product_level_id( $category_product ) ;
    }

    switch( $newarray[ 'product_type' ] ) {

        case '1':

            return true ;
            break ;

        case '2':

            if( category_discount_include_products( $productid , $newarray , $bool = false ) )
                return true ;

            break ;

        case '3':

            if( category_discount_exclude_products( $productid , $newarray , $bool = false ) )
                return true ;

            break ;

        case '4':

            if( category_discount_all_categories( $cat_productid , $newarray , $bool = false ) )
                return true ;

            break ;

        case '5':

            if( category_discount_include_categories( $cat_productid , $newarray , $bool = false ) )
                return true ;

            break ;

        case '6':

            if( category_discount_exclude_categories( $cat_productid , $newarray , $bool = false ) )
                return true ;

            break ;

        case '7':

            if( category_discount_all_tags( $cat_productid , $newarray , $bool = false ) )
                return true ;

            break ;

        case '8':

            if( category_discount_include_tags( $cat_productid , $newarray , $bool = false ) )
                return true ;

            break ;


        case '9':

            if( category_discount_exclude_tags( $cat_productid , $newarray , $bool = false ) )
                return true ;

            break ;
    }

    return false ;
}

function category_discount_include_products( $productid , $newarray , $bool = false ) {

    $include_product_in_rule = $newarray[ 'included_products' ] ;

    if( $include_product_in_rule != '' ) {

        if( is_array( $include_product_in_rule ) ) {

            $incproductrule = $include_product_in_rule ;
        } else {

            $incproductrule = explode( ',' , $include_product_in_rule ) ;
        }

        if( isset( $newarray[ 'inc_condition' ] ) && $newarray[ 'inc_condition' ] == '2' && $bool ) {

            if( isset( $newarray[ 'products_in_cart' ][ 'product_ids' ] ) ) {

                $array_sect        = array_intersect( sumo_dynamic_pricing_translated_array( $incproductrule ) , $newarray[ 'products_in_cart' ][ 'product_ids' ] ) ;
                $en_incproductrule = sumo_dynamic_pricing_translated_array( $incproductrule ) ;
                return ($array_sect == $en_incproductrule) ;
            }
        } else if( isset( $newarray[ 'inc_condition' ] ) && $newarray[ 'inc_condition' ] == '3' && $bool ) {

            if( isset( $newarray[ 'products_in_cart' ][ 'product_ids' ] ) ) {

                $array_sect        = array_intersect( sumo_dynamic_pricing_translated_array( $incproductrule ) , $newarray[ 'products_in_cart' ][ 'product_ids' ] ) ;
                $en_incproductrule = sumo_dynamic_pricing_translated_array( $incproductrule ) ;
                return ($array_sect == $en_incproductrule && $array_sect == $newarray[ 'products_in_cart' ][ 'product_ids' ]) ;
            }
        } else {

            if( in_array( $productid , sumo_dynamic_pricing_translated_array( $incproductrule ) ) ) {

                return true ;
            }
        }
    }

    return false ;
}

function category_discount_exclude_products( $productid , $newarray , $bool = false ) {

    $exclude_product_in_rule = $newarray[ 'excluded_products' ] ;

    if( $exclude_product_in_rule != '' ) {

        if( is_array( $exclude_product_in_rule ) ) {

            $excproductrule = $exclude_product_in_rule ;
        } else {

            $excproductrule = explode( ',' , $exclude_product_in_rule ) ;
        }
        if( in_array( $productid , sumo_dynamic_pricing_translated_array( $excproductrule ) ) ) {

            return false ;
        } else {

            return true ;
        }
    } else {

        return false ;
    }
}

function category_discount_all_categories( $cat_productid , $newarray , $bool = false ) {

    $categoryid = get_custom_taxonomies( $newarray , $cat_productid , 'product_cat' ) ;

    $product_cat = sumo_dynamic_pricing_translated_array( $categoryid ) ;

    if( is_array( $product_cat ) && ! empty( $product_cat ) ) {

        return true ;
    }

    return false ;
}

function category_discount_include_categories( $cat_productid , $newarray , $bool = false ) {

    $categoryid = get_custom_taxonomies( $newarray , $cat_productid , 'product_cat' ) ;

    $inc_cat_in_rule = $newarray[ 'included_category' ] ;

    if( $inc_cat_in_rule != '' && ! empty( $categoryid ) ) {
        if( is_array( $inc_cat_in_rule ) ) {
            $inccatinrule = $inc_cat_in_rule ;
        } else {
            $inccatinrule = explode( ',' , $inc_cat_in_rule ) ;
        }
        if( isset( $newarray[ 'inc_condition' ] ) && $newarray[ 'inc_condition' ] == '2' && $bool ) {
            if( isset( $newarray[ 'products_in_cart' ][ 'category_ids' ] ) ) {
                $array_sect      = array_intersect( sumo_dynamic_pricing_translated_array( $inccatinrule ) , $newarray[ 'products_in_cart' ][ 'category_ids' ] ) ;
                $en_inccatinrule = sumo_dynamic_pricing_translated_array( $inccatinrule ) ;
                return ($array_sect == $en_inccatinrule) ;
            }
        } else if( isset( $newarray[ 'inc_condition' ] ) && $newarray[ 'inc_condition' ] == '3' && $bool ) {
            if( isset( $newarray[ 'products_in_cart' ][ 'category_ids' ] ) ) {
                $array_sect      = array_intersect( sumo_dynamic_pricing_translated_array( $inccatinrule ) , $newarray[ 'products_in_cart' ][ 'category_ids' ] ) ;
                $en_inccatinrule = sumo_dynamic_pricing_translated_array( $inccatinrule ) ;
                return ($array_sect == $en_inccatinrule && $array_sect == $newarray[ 'products_in_cart' ][ 'category_ids' ]) ;
            }
        } else {
            if( array_intersect( $categoryid , sumo_dynamic_pricing_translated_array( $inccatinrule ) ) ) {
                return true ;
            }
        }
    }

    return false ;
}

function category_discount_exclude_categories( $cat_productid , $newarray , $bool = false ) {

    $categoryid = get_custom_taxonomies( $newarray , $cat_productid , 'product_cat' ) ;

    $exc_cat_in_rule = $newarray[ 'excluded_category' ] ;

    if( $exc_cat_in_rule != '' && ! empty( $categoryid ) ) {
        if( is_array( $exc_cat_in_rule ) ) {
            $exccatinrule = $exc_cat_in_rule ;
        } else {
            $exccatinrule = explode( ',' , $exc_cat_in_rule ) ;
        }
        if( array_intersect( $categoryid , sumo_dynamic_pricing_translated_array( $exccatinrule ) ) ) {
            return false ;
        } else {
            return true ;
        }
    } else {
        return false ;
    }
}

function category_discount_all_tags( $cat_productid , $newarray , $bool = false ) {

    $tag_id = get_custom_taxonomies( $newarray , $cat_productid , 'product_tag' ) ;

    $product_tag = sumo_dynamic_pricing_translated_array( $tag_id ) ;

    if( is_array( $product_tag ) && ! empty( $product_tag ) ) {
        return true ;
    } else {
        return false ;
    }
}

function category_discount_include_tags( $cat_productid , $newarray , $bool = false ) {

    $tag_id          = get_custom_taxonomies( $newarray , $cat_productid , 'product_tag' ) ;
    $inc_tag_in_rule = $newarray[ 'included_tag' ] ;

    if( $inc_tag_in_rule != '' && ! empty( $tag_id ) ) {
        if( is_array( $inc_tag_in_rule ) ) {
            $inctaginrule = $inc_tag_in_rule ;
        } else {
            $inctaginrule = explode( ',' , $inc_tag_in_rule ) ;
        }
        if( isset( $newarray[ 'inc_condition' ] ) && $newarray[ 'inc_condition' ] == '2' && $bool ) {
            if( isset( $newarray[ 'products_in_cart' ][ 'tag_ids' ] ) ) {
                $array_sect      = array_intersect( sumo_dynamic_pricing_translated_array( $inctaginrule ) , $newarray[ 'products_in_cart' ][ 'tag_ids' ] ) ;
                $en_inctaginrule = sumo_dynamic_pricing_translated_array( $inctaginrule ) ;
                return ($array_sect == $en_inctaginrule) ;
            }
        } else if( isset( $newarray[ 'inc_condition' ] ) && $newarray[ 'inc_condition' ] == '3' && $bool ) {
            if( isset( $newarray[ 'products_in_cart' ][ 'tag_ids' ] ) ) {
                $array_sect      = array_intersect( sumo_dynamic_pricing_translated_array( $inctaginrule ) , $newarray[ 'products_in_cart' ][ 'tag_ids' ] ) ;
                $en_inctaginrule = sumo_dynamic_pricing_translated_array( $inctaginrule ) ;
                return ($array_sect == $en_inctaginrule && $array_sect == $newarray[ 'products_in_cart' ][ 'tag_ids' ]) ;
            }
        } else {
            if( array_intersect( $tag_id , sumo_dynamic_pricing_translated_array( $inctaginrule ) ) ) {
                return true ;
            }
        }
    }

    return false ;
}

function category_discount_exclude_tags( $cat_productid , $newarray , $bool = false ) {

    $tag_id          = get_custom_taxonomies( $newarray , $cat_productid , 'product_tag' ) ;
    $exc_tag_in_rule = $newarray[ 'excluded_tag' ] ;

    if( $exc_tag_in_rule != '' && ! empty( $tag_id ) ) {
        if( is_array( $exc_tag_in_rule ) ) {
            $exctaginrule = $exc_tag_in_rule ;
        } else {
            $exctaginrule = explode( ',' , $exc_tag_in_rule ) ;
        }
        if( array_intersect( $tag_id , sumo_dynamic_pricing_translated_array( $exctaginrule ) ) ) {
            return false ;
        } else {
            return true ;
        }
    } else {
        return false ;
    }
}

function get_custom_taxonomies( $newarray , $cat_productid , $taxonomy_name ) {

    $category = get_the_terms( $cat_productid , $taxonomy_name ) ;

    $categoryids = array() ;

    if( is_array( $category ) && ! empty( $category ) ) {

        foreach( $category as $categorys ) {

            $categoryids[] = sumo_dynamic_pricing_taxonomy_id_from_other_lang( $categorys->term_id ) ;
        }
    }
    return $categoryids ;
}

function sumo_function_for_check_special_offer_to_product_and_category_filter( $productid , $newarray , $mycategory ) {
    $categoryid       = array() ;
    $tag_id           = array() ;
    $category_product = sumo_sd_get_product( $productid ) ;
    if( $category_product->is_type( 'variation' ) ) {
        $cat_productid = sumo_sd_get_product_level_id( $category_product ) ;
    } else {
        $cat_productid = $productid ;
    }
    $category = get_the_terms( $cat_productid , 'product_cat' ) ;
    if( is_array( $category ) ) {
        if( ! empty( $category ) ) {
            foreach( $category as $categorys ) {
                $categoryid[] = sumo_dynamic_pricing_taxonomy_id_from_other_lang( $categorys->term_id ) ;
            }
        }
    }
    $tag = get_the_terms( $cat_productid , 'product_tag' ) ;
    if( is_array( $tag ) ) {
        if( ! empty( $tag ) ) {
            foreach( $tag as $each_tag ) {
                $tag_id[] = sumo_dynamic_pricing_taxonomy_id_from_other_lang( $each_tag->term_id ) ;
            }
        }
    }
    if( $newarray[ 'product_type' ] == '0' ) {
        return true ;
    } elseif( $newarray[ 'product_type' ] == '1' ) {
        $include_product_in_rule = $newarray[ 'included_products' ] ;
        if( $include_product_in_rule != '' ) {
            if( is_array( $include_product_in_rule ) ) {
                $incproductrule = $include_product_in_rule ;
            } else {
                $incproductrule = explode( ',' , $include_product_in_rule ) ;
            }
            if( in_array( $productid , sumo_dynamic_pricing_translated_array( $incproductrule ) ) ) {
                return true ;
            } else {
                return false ;
            }
        } else {
            return false ;
        }
    } elseif( $newarray[ 'product_type' ] == '2' ) {
        $exclude_product_in_rule = $newarray[ 'excluded_products' ] ;
        if( $exclude_product_in_rule != '' ) {
            if( is_array( $exclude_product_in_rule ) ) {
                $excproductrule = $exclude_product_in_rule ;
            } else {
                $excproductrule = explode( ',' , $exclude_product_in_rule ) ;
            }
            if( in_array( $productid , sumo_dynamic_pricing_translated_array( $excproductrule ) ) ) {
                return false ;
            } else {
                return true ;
            }
        } else {
            return false ;
        }
    } elseif( $newarray[ 'product_type' ] == '3' ) {
        $product_cat  = get_the_terms( $cat_productid , 'product_cat' ) ;
        $product_cat1 = array() ;
        if( is_array( $product_cat ) && ! empty( $product_cat ) ) {
            foreach( $product_cat as $each_category ) {
                $product_cat1[] = sumo_dynamic_pricing_taxonomy_id_from_other_lang( $each_category->term_id ) ;
            }
        }
        if( is_array( $product_cat ) && ! empty( $product_cat ) ) {
            if( is_array( $mycategory ) && ! empty( $mycategory ) ) {
                $narray = array_intersect( $mycategory , sumo_dynamic_pricing_translated_array( $product_cat1 ) ) ;
                if( ! empty( $narray ) ) {
                    return true ;
                }
            }
        } else {
            return false ;
        }
    } elseif( $newarray[ 'product_type' ] == '4' ) {
        $inc_cat_in_rule = $newarray[ 'included_category' ] ;
        if( $inc_cat_in_rule != '' ) {
            if( is_array( $inc_cat_in_rule ) ) {
                $inccatinrule = $inc_cat_in_rule ;
            } else {
                $inccatinrule = explode( ',' , $inc_cat_in_rule ) ;
            }
            if( array_intersect( $categoryid , sumo_dynamic_pricing_translated_array( $inccatinrule ) ) ) {
                return true ;
            } else {
                return false ;
            }
        } else {
            return false ;
        }
    } elseif( $newarray[ 'product_type' ] == '5' ) {
        $exc_cat_in_rule = $newarray[ 'excluded_category' ] ;
        if( $exc_cat_in_rule != '' ) {
            if( is_array( $exc_cat_in_rule ) ) {
                $exccatinrule = $exc_cat_in_rule ;
            } else {
                $exccatinrule = explode( ',' , $exc_cat_in_rule ) ;
            }
            if( array_intersect( $categoryid , sumo_dynamic_pricing_translated_array( $exccatinrule ) ) ) {
                return false ;
            } else {
                return true ;
            }
        } else {
            return false ;
        }
    } elseif( $newarray[ 'product_type' ] == '6' ) {
        $inc_tag_in_rule = $newarray[ 'included_tag' ] ;
        if( $inc_tag_in_rule != '' ) {
            if( is_array( $inc_tag_in_rule ) ) {
                $inctaginrule = $inc_tag_in_rule ;
            } else {
                $inctaginrule = explode( ',' , $inc_tag_in_rule ) ;
            }
            if( array_intersect( $tag_id , sumo_dynamic_pricing_translated_array( $inctaginrule ) ) ) {
                return true ;
            } else {
                return false ;
            }
        } else {
            return false ;
        }
    } elseif( $newarray[ 'product_type' ] == '7' ) {
        $exc_tag_in_rule = $newarray[ 'excluded_tag' ] ;
        if( $exc_tag_in_rule != '' ) {
            if( is_array( $exc_tag_in_rule ) ) {
                $exctaginrule = $exc_tag_in_rule ;
            } else {
                $exctaginrule = explode( ',' , $exc_tag_in_rule ) ;
            }
            if( array_intersect( $tag_id , sumo_dynamic_pricing_translated_array( $exctaginrule ) ) ) {
                return false ;
            } else {
                return true ;
            }
        } else {
            return false ;
        }
    }
}

function sumo_function_for_user_and_userrole_filter( $userid , $uniq_id , $newarray , $rule ) {
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
}

function sumo_function_for_date_filter( $fromdate , $todate ) {
    $currentdate = strtotime( date_i18n( 'd-m-Y' ) ) ;
    if( $fromdate && $todate ) {
        if( ($currentdate >= $fromdate) && ($currentdate <= $todate) ) {
            return true ;
        } else {
            return false ;
        }
    } elseif( $todate ) {
        if( $currentdate <= $todate ) {
            return true ;
        } else {
            return false ;
        }
    } elseif( $fromdate ) {
        if( $currentdate >= $fromdate ) {
            return true ;
        } else {
            return false ;
        }
    } else {
        return true ;
    }
}

function sumo_function_for_day_filter( $tabname ) {
    $currentday  = date( 'l' ) ;
    $currentdays = strtolower( $currentday ) ;

    $array = array(
        'monday'    => get_option( 'sp_restrict_pricing_on_monday_at_' . $tabname ) ,
        'tuesday'   => get_option( 'sp_restrict_pricing_on_tuesday_at_' . $tabname ) ,
        'wednesday' => get_option( 'sp_restrict_pricing_on_wednesday_at_' . $tabname ) ,
        'thursday'  => get_option( 'sp_restrict_pricing_on_thursday_at_' . $tabname ) ,
        'friday'    => get_option( 'sp_restrict_pricing_on_friday_at_' . $tabname ) ,
        'saturday'  => get_option( 'sp_restrict_pricing_on_saturday_at_' . $tabname ) ,
        'sunday'    => get_option( 'sp_restrict_pricing_on_sunday_at_' . $tabname ) ,
            ) ;
    foreach( $array as $key => $value ) {
        if( $value == 'yes' ) {
            $weedays[] = $key ;
        } else {
            $weedays[] = '' ;
        }
    }
    if( ! in_array( $currentdays , $weedays ) ) {
        return false ;
    } else {
        return true ;
    }
}

function sumo_function_to_select_users( $id , $label , $classname , $uniqid , $name , $new_fields , $get_data ) {
    global $woocommerce ;
    $fieldname      = $name . "[" . $uniqid . "][" . $new_fields[ 'name' ] . "]" ;
    $fieldlabel     = $new_fields[ 'label' ] ;
    $fieldid        = $new_fields[ 'id' ] . $uniqid ;
    $fieldclassname = $classname . $uniqid ;
    ?>
    <p class="form-field">
        <b>
            <?php _e( $fieldlabel ) ; ?>
        </b>
        <?php if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
            <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $fieldclassname ; ?>" name="<?php echo $fieldname ; ?>[]" style="width:343px;" multiple="multiple" id="<?php echo $fieldid ; ?>" >
                <?php
                $json_ids = array() ;
                $getuser  = $get_data ;
                if( $getuser != "" ) {
                    $listofuser = $getuser ;
                    if( ! is_array( $listofuser ) ) {
                        $userids = array_filter( array_map( 'absint' , explode( ',' , $listofuser ) ) ) ;
                    } else {
                        $userids = $listofuser ;
                    }

                    foreach( $userids as $userid ) {
                        $user = get_user_by( 'id' , $userid ) ;
                        if( $user ) {
                            ?>
                            <option value="<?php echo $userid ; ?>" selected="selected"><?php echo esc_html( $user->display_name ) . ' (#' . absint( $user->ID ) . ' &ndash; ' . esc_html( $user->user_email ) . ')' ; ?></option>
                            <?php
                        }
                    }
                }
                ?>
            </select>
        <?php } else { ?>
            <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
            <?php if( ( float ) WC()->version < ( float ) '3.0.0' ) { ?>
                <input type="hidden" class="wc-customer-search" style="max-width:350px;" name="<?php echo $fieldname ; ?>" id="<?php echo $fieldid ; ?>" data-multiple="true" data-placeholder="<?php _e( 'Search Users' , 'sumodiscounts' ) ; ?>" data-selected="<?php
                $json_ids    = array() ;
                $get_user_id = $get_data ;
                if( ! is_array( $get_user_id ) && ( ! empty( $get_user_id )) ) {
                    $explode_users = array_filter( explode( ',' , $get_user_id ) ) ;
                    foreach( $explode_users as $eachuser ) {
                        $user = get_user_by( 'id' , $eachuser ) ;
                        if( $user ) {
                            $json_ids[ $user->ID ] = esc_html( $user->display_name ) . '(#' . absint( $user->ID ) . ' &ndash; ' . esc_html( $user->user_email ) . ')' ;
                        }
                    }
                    echo esc_attr( json_encode( $json_ids ) ) ;
                }
                ?>" value="<?php echo implode( ',' , array_keys( $json_ids ) ) ; ?>" data-allow_clear="true" />
                   <?php } else {
                       ?>
                <select class="wc-customer-search" data-minimum_input_length="3" style="width:350px;" name="<?php echo $fieldname ; ?>[]" id="<?php echo $fieldid ; ?>" multiple="true" data-placeholder="<?php _e( 'Search Users' , 'sumodiscounts' ) ; ?>" >
                    <?php
                    $json_ids = array() ;
                    if( ! is_array( $get_data ) ) {
                        $get_user_id = explode( ',' , $get_data ) ;
                    } else {
                        $get_user_id = $get_data ;
                    }
                    $explode_users = array_filter( $get_user_id ) ;
                    foreach( $explode_users as $eachuser ) {
                        $user = get_user_by( 'id' , $eachuser ) ;
                        if( $user ) {
                            $user_string = esc_html( $user->display_name ) . '(#' . absint( $user->ID ) . ' &ndash; ' . esc_html( $user->user_email ) . ')' ;
                            echo '<option value="' . $eachuser . '"' . selected( 1 , 1 ) . '>' . $user_string . '</option>' ;
                        }
                    }
                    ?>
                </select>
                <?php
            }
        }
        ?>
    </p>
    <?php
    echo sumo_pricing_common_ajax_function_to_select_user( $fieldclassname ) ;
}

function sumo_function_to_select_userrole( $classname , $uniqid , $nameforinputfield , $new_fields , $get_data ) {
    global $woocommerce ;
    ?>
    <p class="form-field">
        <b>
            <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
        </b>
        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $classname . $uniqid ; ?>" style="max-width:350px;" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" id="<?php echo $new_fields[ 'id' ] . $uniqid ; ?>" multiple="multiple">
            <?php
            if( is_array( $new_fields[ 'options' ] ) ) {
                if( ! empty( $new_fields[ 'options' ] ) ) {
                    foreach( $new_fields[ 'options' ] as $key => $options ) {
                        ?>
                        <option value="<?php echo $key ; ?>" <?php
                        if( isset( $get_data[ $new_fields[ 'name' ] ] ) ) {
                            foreach( $get_data[ $new_fields[ 'name' ] ] as $value ) {
                                echo selected( $key , $value ) ;
                            }
                        }
                        ?>><?php echo $options ; ?></option>
                                <?php
                            }
                        }
                    }
                    ?>
        </select>
    </p>
    <?php
    if( ( float ) $woocommerce->version > ( float ) ('2.2.0') ) {
        $id = isset( $new_fields[ 'id' ] ) ? $new_fields[ 'id' ] : '' ;
        echo sumo_pricing_common_select_function( '#' . $id . $uniqid , 'Select User Role' ) ;
    } else {
        echo sumo_pricing_common_chosen_function( '#' . $id . $uniqid ) ;
    }
}

function sumo_function_to_select_product( $id , $label , $classname , $uniqid , $nameforinputfield , $new_fields , $get_data , $multiple = true ) {
    global $woocommerce ;
    $add_array      = ( float ) WC()->version < ( float ) '3.0.0' ? '' : '[]' ;
    $fieldname      = $nameforinputfield . "[" . $uniqid . "][" . $new_fields[ 'name' ] . "]" . $add_array ;
    $fieldlabel     = $new_fields[ 'label' ] ;
    $fieldid        = $new_fields[ 'id' ] . $uniqid ;
    $fieldclassname = $classname . $uniqid ;
    $is_multiple    = $multiple ? 'multiple="multiple"' : '' ;
    $data_multiple  = $multiple ? 'data-multiple="multiple"' : '' ;
    ?>
    <p class="form-field">
        <b>
            <?php _e( $fieldlabel , 'sumodiscounts' ) ; ?>
        </b>
        <?php if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) { ?>
            <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select class="<?php echo $fieldclassname ; ?>" name="<?php echo $fieldname ; ?>" style="width:343px;" <?php echo $is_multiple ?> id="<?php echo $fieldid ; ?>">
                <?php
                if( $get_data != "" ) {
                    if( ! empty( $get_data ) ) {
                        $list_of_produts = ( array ) $get_data ;
                        foreach( $list_of_produts as $rs_free_id ) {
                            $product = sumo_sd_get_product( $rs_free_id ) ;
                            if( $product ) {
                                echo '<option value="' . $rs_free_id . '" ' ;
                                selected( 1 , 1 ) ;
                                echo '>' . ' #' . $rs_free_id . ' &ndash; ' . get_the_title( $rs_free_id ) ;
                            }
                        }
                    }
                } else {
                    ?>
                    <option value=""></option>
                    <?php
                }
                ?>
            </select>
        <?php } else { ?>
            <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span>
            <?php if( ( float ) WC()->version < ( float ) '3.0.0' ) { ?>
                <input type="hidden" class="wc-product-search" style="max-width:350px;" name="<?php echo $fieldname ; ?>" id="<?php echo $fieldid ; ?>" <?php echo $data_multiple ?> data-placeholder="<?php _e( 'Search Products' , 'sumodiscounts' ) ; ?>"  data-allow_clear="true" data-selected="<?php
                $json_ids = array() ;
                if( $get_data != "" ) {
                    $list_of_produts = $get_data ;
                    if( ! is_array( $list_of_produts ) ) {
                        $product_ids = array_filter( array_map( 'absint' , explode( ',' , $get_data ) ) ) ;
                    } else {
                        $product_ids = $list_of_produts ;
                    }
                    if( $product_ids !== NULL ) {
                        foreach( $product_ids as $product_id ) {
                            if( isset( $product_id ) ) {
                                $product = sumo_sd_get_product( $product_id ) ;
                                if( is_object( $product ) ) {
                                    $json_ids[ $product_id ] = wp_kses_post( $product->get_formatted_name() ) ;
                                }
                            }
                        } echo esc_attr( json_encode( $json_ids ) ) ;
                    }
                }
                ?>" value="<?php echo implode( ',' , array_keys( $json_ids ) ) ; ?>" />
                   <?php } else {
                       ?>
                <select class="wc-product-search" style="width:350px" style="max-width:350px;" name="<?php echo $fieldname ; ?>" id="<?php echo $fieldid ; ?>" data-placeholder="<?php _e( 'Search Products' , 'sumodiscounts' ) ; ?>" <?php echo $is_multiple ?>  data-allow_clear="true">
                    <?php
                    if( $get_data != "" ) {
                        if( ! empty( $get_data ) ) {
                            if( ! is_array( $get_data ) ) {
                                $list_of_produts = explode( ',' , $get_data ) ;
                            } else {
                                $list_of_produts = $get_data ;
                            }
                            foreach( $list_of_produts as $each_product ) {
                                $product_obj = sumo_sd_get_product( $each_product ) ;
                                if( $product_obj ) {
                                    echo '<option value="' . $each_product . '" ' . selected( 1 , 1 ) . '>' . wp_kses_post( $product_obj->get_formatted_name() ) . '</option>' ;
                                }
                            }
                        }
                    }
                    ?>
                </select>
                <?php
            }
        }
        ?>
    </p>
    <?php
    echo sumo_pricing_common_ajax_function_to_select_product( $fieldclassname ) ;
}

function sumo_function_to_select_category( $classname , $uniqid , $nameforinputfield , $new_fields , $get_data ) {
    global $woocommerce ;
    ?>
    <p class="form-field">
        <b>
            <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
        </b>
        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select style="width: 350px" class="<?php echo $classname ; ?>" style="max-width:350px;" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" id="<?php echo $new_fields[ 'id' ] . $uniqid ; ?>" multiple="multiple">
            <?php
            if( is_array( $new_fields[ 'options' ] ) ) {
                if( ! empty( $new_fields[ 'options' ] ) ) {
                    foreach( $new_fields[ 'options' ] as $key => $options ) {
                        ?>
                        <option value="<?php echo $key ; ?>" <?php
                        if( isset( $get_data[ $new_fields[ 'name' ] ] ) ) {
                            foreach( $get_data[ $new_fields[ 'name' ] ] as $value ) {
                                echo selected( $key , $value ) ;
                            }
                        }
                        ?>><?php echo $options ; ?></option>
                                <?php
                            }
                        }
                    }
                    ?>
        </select>
    </p>
    <?php
    if( ( float ) $woocommerce->version > ( float ) ('2.2.0') ) {
        echo sumo_pricing_common_select_function( '#' . $new_fields[ 'id' ] . $uniqid , __( 'Select Category' , 'sumodiscounts' ) ) ;
    } else {
        echo sumo_pricing_common_chosen_function( '#' . $new_fields[ 'id' ] . $uniqid ) ;
    }
}

function sumo_function_to_select_tag( $classname , $uniqid , $nameforinputfield , $new_fields , $get_data ) {

    global $woocommerce ;
    ?>
    <p class="form-field">
        <b>
            <?php _e( $new_fields[ 'label' ] , 'sumodiscounts' ) ; ?>
        </b>
        <span class="dashicons dashicons-info" title="<?php echo $new_fields[ 'tooltip' ] ; ?>"></span><select style="width: 350px" class="<?php echo $classname ; ?>" style="max-width:350px;" name="<?php echo $nameforinputfield ; ?>[<?php echo $uniqid ; ?>][<?php echo $new_fields[ 'name' ] ; ?>][]" id="<?php echo $new_fields[ 'id' ] . $uniqid ; ?>" multiple="multiple">
            <?php
            if( is_array( $new_fields[ 'options' ] ) ) {
                if( ! empty( $new_fields[ 'options' ] ) ) {
                    foreach( $new_fields[ 'options' ] as $key => $options ) {
                        ?>
                        <option value="<?php echo $key ; ?>" <?php
                        if( isset( $get_data[ $new_fields[ 'name' ] ] ) ) {
                            foreach( $get_data[ $new_fields[ 'name' ] ] as $value ) {
                                echo selected( $key , $value ) ;
                            }
                        }
                        ?>><?php echo $options ; ?></option>
                                <?php
                            }
                        }
                    }
                    ?>
        </select>
    </p>
    <?php
    if( ( float ) $woocommerce->version > ( float ) ('2.2.0') ) {
        echo sumo_pricing_common_select_function( '#' . $new_fields[ 'id' ] . $uniqid , __( 'Select Tag' , 'sumodiscounts' ) ) ;
    } else {
        echo sumo_pricing_common_chosen_function( '#' . $new_fields[ 'id' ] . $uniqid ) ;
    }
}

function sumo_function_to_select_users_for_tab( $id , $label , $classname , $name , $get_data ) {
    global $woocommerce ;
    $fieldname      = $name ;
    $fieldlabel     = $label ;
    $fieldid        = $id ;
    $fieldclassname = $classname ;
    if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) {
        ?>
        <tr valign="top">
            <th class="titledesc" scope="row">
                <label for="<?php echo $fieldname ; ?>"><?php _e( $fieldlabel , 'sumodiscounts' ) ; ?></label>
            </th>
            <td>
                <select class="<?php echo $fieldclassname ; ?>" name="<?php echo $fieldname ; ?>[]" style="width:343px;" multiple="multiple" id="<?php echo $fieldid ; ?>" >
                    <?php
                    $json_ids = array() ;
                    $getuser  = $get_data ;
                    if( $getuser != "" ) {
                        $listofuser = $getuser ;
                        if( ! is_array( $listofuser ) ) {
                            $userids = array_filter( array_map( 'absint' , explode( ',' , $listofuser ) ) ) ;
                        } else {
                            $userids = $listofuser ;
                        }

                        foreach( $userids as $userid ) {
                            $user = get_user_by( 'id' , $userid ) ;
                            if( $user ) {
                                ?>
                                <option value="<?php echo $userid ; ?>" selected="selected"><?php echo esc_html( $user->display_name ) . ' (#' . absint( $user->ID ) . ' &ndash; ' . esc_html( $user->user_email ) . ')' ; ?></option>
                                <?php
                            }
                        }
                    }
                    ?>
                </select>
            </td>
        </tr>
    <?php } else { ?>
        <tr valign="top">
            <th class="titledesc" scope="row">
                <label for="<?php echo $fieldname ; ?>"><?php _e( $fieldlabel ) ; ?></label>
            </th>
            <td>
                <?php if( ( float ) WC()->version < ( float ) '3.0.0' ) { ?>
                    <input type="hidden" class="wc-customer-search" name="<?php echo $fieldname ; ?>[]" id="<?php echo $fieldid ; ?>" data-multiple="true" data-placeholder="<?php _e( 'Search Users' , 'sumodiscounts' ) ; ?>" data-selected="<?php
                    $json_ids    = array() ;
                    $get_user_id = $get_data ;
                    if( ! is_array( $get_user_id ) && ( ! empty( $get_user_id )) ) {
                        $explode_users = array_filter( explode( ',' , $get_user_id ) ) ;
                        foreach( $explode_users as $eachuser ) {
                            $user = get_user_by( 'id' , $eachuser ) ;
                            if( $user ) {
                                $json_ids[ $user->ID ] = esc_html( $user->display_name ) . '(#' . absint( $user->ID ) . ' &ndash; ' . esc_html( $user->user_email ) . ')' ;
                            }
                        }
                        echo esc_attr( json_encode( $json_ids ) ) ;
                    }
                    ?>" value="<?php echo implode( ',' , array_keys( $json_ids ) ) ; ?>" data-allow_clear="true" />
                       <?php } else {
                           ?>
                    <select class="wc-customer-search" data-minimum_input_length="3" style="width:350px" name="<?php echo $fieldname ; ?>[]" id="<?php echo $fieldid ; ?>" multiple="true" data-placeholder="<?php _e( 'Search Users' , 'sumodiscounts' ) ; ?>">
                        <?php
                        $json_ids = array() ;
                        if( ! is_array( $get_data ) ) {
                            $get_user_id = explode( ',' , $get_data ) ;
                        } else {
                            $get_user_id = $get_data ;
                        }
                        $explode_users = array_filter( $get_user_id ) ;
                        foreach( $explode_users as $eachuser ) {
                            $user = get_user_by( 'id' , $eachuser ) ;
                            if( $user ) {
                                $user_string = esc_html( $user->display_name ) . '(#' . absint( $user->ID ) . ' &ndash; ' . esc_html( $user->user_email ) . ')' ;
                                echo '<option value="' . $eachuser . '" ' . selected( 1 , 1 ) . '>' . $user_string . '</option>' ;
                            }
                        }
                        ?>
                    </select>
                <?php }
                ?>
            </td>
        </tr>
    <?php } ?>

    <?php
    echo sumo_pricing_common_ajax_function_to_select_user( $fieldclassname ) ;
}

function sumo_function_to_select_product_for_tab( $id , $label , $classname , $nameforinputfield , $get_data ) {
    global $woocommerce ;
    $add_array      = ( float ) WC()->version < ( float ) '3.0.0' ? '' : '[]' ;
    $fieldname      = $nameforinputfield . $add_array ;
    $fieldlabel     = $label ;
    $fieldid        = $id ;
    $fieldclassname = $classname ;
    if( ( float ) $woocommerce->version <= ( float ) ('2.2.0') ) {
        ?>
        <tr valign="top">
            <th class="titledesc" scope="row">
                <label for="<?php echo $fieldname ; ?>"><?php _e( $fieldlabel , 'sumodiscounts' ) ; ?></label>
            </th>
            <td>
                <select class="<?php echo $fieldclassname ; ?>" name="<?php echo $fieldname ; ?>[]" style="width:343px;" multiple="multiple" id="<?php echo $fieldid ; ?>">
                    <?php
                    if( $get_data != "" ) {
                        if( ! empty( $get_data ) ) {
                            $list_of_produts = ( array ) $get_data ;
                            foreach( $list_of_produts as $rs_free_id ) {
                                $product = sumo_sd_get_product( $rs_free_id ) ;
                                if( $product ) {
                                    echo '<option value="' . $rs_free_id . '" ' ;
                                    selected( 1 , 1 ) ;
                                    echo '>' . ' #' . $rs_free_id . ' &ndash; ' . get_the_title( $rs_free_id ) ;
                                }
                            }
                        }
                    } else {
                        ?>
                        <option value=""></option>
                        <?php
                    }
                    ?>
                </select>
            </td>
        </tr>
    <?php } else { ?>
        <tr valign="top">
            <th class="titledesc" scope="row">
                <label for="<?php echo $fieldname ; ?>"><?php _e( $fieldlabel , 'sumodiscounts' ) ; ?></label>
            </th>
            <td>
                <?php if( ( float ) WC()->version < ( float ) '3.0.0' ) { ?>
                    <input type="hidden" class="wc-product-search" name="<?php echo $fieldname ; ?>" id="<?php echo $fieldid ; ?>" data-multiple="true" data-placeholder="<?php _e( 'Search Products' , 'sumodiscounts' ) ; ?>"  data-allow_clear="true" data-selected="<?php
                    $json_ids = array() ;
                    if( $get_data != "" ) {
                        $list_of_produts = $get_data ;
                        if( ! is_array( $list_of_produts ) ) {
                            $product_ids = array_filter( array_map( 'absint' , explode( ',' , $get_data ) ) ) ;
                        } else {
                            $product_ids = $list_of_produts ;
                        }
                        if( $product_ids !== NULL ) {
                            foreach( $product_ids as $product_id ) {
                                if( isset( $product_id ) ) {
                                    $product = sumo_sd_get_product( $product_id ) ;
                                    if( is_object( $product ) ) {
                                        $json_ids[ $product_id ] = wp_kses_post( $product->get_formatted_name() ) ;
                                    }
                                }
                            } echo esc_attr( json_encode( $json_ids ) ) ;
                        }
                    }
                    ?>" value="<?php echo implode( ',' , array_keys( $json_ids ) ) ; ?>" />
                       <?php } else {
                           ?>
                    <select class="wc-product-search" style="width:350px" style="max-width:350px;" name="<?php echo $fieldname ; ?>" id="<?php echo $fieldid ; ?>" multiple="multiple" data-placeholder="<?php _e( 'Search Products' , 'sumodiscounts' ) ; ?>"  data-allow_clear="true">
                        <?php
                        if( $get_data != "" ) {
                            if( ! empty( $get_data ) ) {
                                if( ! is_array( $get_data ) ) {
                                    $list_of_produts = explode( ',' , $get_data ) ;
                                } else {
                                    $list_of_produts = $get_data ;
                                }
                                foreach( $list_of_produts as $each_product ) {
                                    $product_obj = sumo_sd_get_product( $each_product ) ;
                                    if( $product_obj ) {
                                        echo '<option value="' . $each_product . '" ' . selected( 1 , 1 ) . '>' . wp_kses_post( $product_obj->get_formatted_name() ) . '</option>' ;
                                    }
                                }
                            }
                        }
                        ?>
                    </select>
                <?php }
                ?>
            </td>
        </tr>
    <?php } ?>
    </p>
    <?php
    echo sumo_pricing_common_ajax_function_to_select_product( $fieldclassname ) ;
}

function sumo_get_no_of_orders_placed( $user_id , $purchase_period , $from_date , $to_date ) {
    global $wpdb ;
    $query      = "" ;
    $from_date1 = $from_date !== "" ? date_i18n( "Y-m-d" , strtotime( $from_date ) ) : "" ;
    $to_date1   = $to_date !== "" ? date_i18n( "Y-m-d" , strtotime( $to_date ) ) : date_i18n( 'Y-m-d' ) ;
    if( $purchase_period != '' ) {
        $from_query = $from_date1 != "" ? "AND posts.post_date >= '" . $from_date1 . "00:00:01'" : "" ;
        $query      = $from_query . "AND posts.post_date <= '" . $to_date1 . "23:59:59' " ;
    }
    $count = $wpdb->get_var( "SELECT COUNT(*)
                FROM $wpdb->posts as posts

                LEFT JOIN {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id

                WHERE   meta.meta_key       = '_customer_user'
                AND     posts.post_type     IN ('" . implode( "','" , wc_get_order_types( 'order-count' ) ) . "')
                AND     posts.post_status IN ( 'wc-completed', 'wc-processing' )" . $query . "
                AND     meta_value          = $user_id
            " ) ;
    return ( int ) $count ;
}

function check_for_user_purchase_history( $rule , $userpurchasehistype , $nooforderrequire , $minamtspent , $userid ) {
    if( get_userdata( $userid ) ) {
        if( $userpurchasehistype == '' ) {
            return true ;
        } elseif( $userpurchasehistype == '1' ) {
            $no_of_orders_placed = sumo_get_no_of_orders_placed( $userid , $rule[ 'sumo_u_p_history_time' ] , $rule[ 'sumo_uph_from_datepicker' ] , $rule[ 'sumo_uph_to_datepicker' ] ) ;
            if( $no_of_orders_placed >= ( int ) $nooforderrequire ) {
                return true ;
            } else {
                return false ;
            }
        } elseif( $userpurchasehistype == '2' ) {
            $amount_spented = ( float ) sumo_get_customer_total_spent( $userid , $rule[ 'sumo_u_p_history_time' ] , $rule[ 'sumo_uph_from_datepicker' ] , $rule[ 'sumo_uph_to_datepicker' ] ) ;
            if( $amount_spented >= ( float ) $minamtspent ) {
                return true ;
            }
        }
    } else {
        return true ;
    }
}

function sumo_get_customer_total_spent( $user_id , $purchase_period , $from_date , $to_date ) {
    $spent      = '' ;
    global $wpdb ;
    $query      = "" ;
    $fromdate   = $from_date != "" ? $from_date : '' ;
    $todate     = $to_date != "" ? $to_date : date_i18n( 'Y-m-d' ) ;
    $from_query = $from_date != "" ? "AND posts.post_date >= '" . $fromdate . "00:00:01' " : "" ;
    if( $purchase_period != '' ) {
        $query = $from_query . "AND posts.post_date <= '" . $todate . "23:59:59' " ;
    }
    $spent = $wpdb->get_var( "SELECT SUM(meta2.meta_value)
			FROM $wpdb->posts as posts

			LEFT JOIN {$wpdb->postmeta} AS meta ON posts.ID = meta.post_id
			LEFT JOIN {$wpdb->postmeta} AS meta2 ON posts.ID = meta2.post_id

			WHERE   meta.meta_key       = '_customer_user'
			AND     meta.meta_value     = $user_id
			AND     posts.post_type     IN ('" . implode( "','" , wc_get_order_types( 'reports' ) ) . "')
			AND     posts.post_status   IN ( 'wc-completed', 'wc-processing' )" . $query . "
			AND     meta2.meta_key      = '_order_total'
		" ) ;



    return $spent ;
}

function sumo_wc_price( $price ) {
    if( function_exists( 'wc_price' ) ) {
        return wc_price( $price ) ;
    } else {
        if( function_exists( 'woocommerce_price' ) ) {
            return woocommerce_price( $price ) ;
        }
    }
}

function sumo_product_search( $name , $id , $multiple = true ) {
    $data_multiple = $multiple ? 'data-multiple="true"' : '' ;
    $is_mulitple   = $multiple ? 'multiple="true"' : '' ;
    if( ( float ) WC()->version < ( float ) '3.0.0' ) {
        ?>
        <input type="hidden" class="wc-product-search" name="<?php echo $name ?>" id="<?php echo $id ?>" <?php echo $data_multiple ?> data-placeholder="<?php _e( 'Search Products' , 'sumodiscounts' ) ; ?>"  value="" data-allow_clear="true" />
        <?php
    } else {
        ?>
        <select style="width:350px" class="wc-product-search" name="<?php echo $name ?>" id="<?php echo $id ?>" <?php echo $is_mulitple ; ?> data-placeholder="<?php _e( 'Search Products' , 'sumodiscounts' ) ; ?>"  value="" data-allow_clear="true" ></select>
        <?php
    }
}

function sumo_customer_search( $name , $id ) {
    if( ( float ) WC()->version < ( float ) '3.0.0' ) {
        ?>
        <input type="hidden" class="wc-customer-search" name="<?php echo $name ?>" id="<?php echo $id ?>" data-multiple="true" data-placeholder="<?php _e( 'Search Users' , 'sumodiscounts' ) ; ?>"  value="" data-allow_clear="true" />
        <?php
    } else {
        ?>
        <select style="width:350px" class="wc-customer-search" data-minimum_input_length="3" name="<?php echo $name ?>[]" id="<?php echo $id ?>" multiple="true" data-placeholder="<?php _e( 'Search Users' , 'sumodiscounts' ) ; ?>"  value="" data-allow_clear="true" ></select>
        <?php
    }
}

function sumo_deprecated_hooks( $hook_name ) {
    if( ( float ) WC()->version >= ( float ) '3.0.0' ) {
        $deprecated_hooks = array(
            'woocommerce_structured_data_order'         => 'woocommerce_email_order_schema_markup' ,
            'woocommerce_add_to_cart_fragments'         => 'add_to_cart_fragments' ,
            'woocommerce_add_to_cart_redirect'          => 'add_to_cart_redirect' ,
            'woocommerce_product_get_width'             => 'woocommerce_product_width' ,
            'woocommerce_product_get_height'            => 'woocommerce_product_height' ,
            'woocommerce_product_get_length'            => 'woocommerce_product_length' ,
            'woocommerce_product_get_weight'            => 'woocommerce_product_weight' ,
            'woocommerce_product_get_sku'               => 'woocommerce_get_sku' ,
            'woocommerce_product_get_price'             => 'woocommerce_get_price' ,
            'woocommerce_product_get_regular_price'     => 'woocommerce_get_regular_price' ,
            'woocommerce_product_get_sale_price'        => 'woocommerce_get_sale_price' ,
            'woocommerce_product_get_tax_class'         => 'woocommerce_product_tax_class' ,
            'woocommerce_product_get_stock_quantity'    => 'woocommerce_get_stock_quantity' ,
            'woocommerce_product_get_attributes'        => 'woocommerce_get_product_attributes' ,
            'woocommerce_product_get_gallery_image_ids' => 'woocommerce_product_gallery_attachment_ids' ,
            'woocommerce_product_get_review_count'      => 'woocommerce_product_review_count' ,
            'woocommerce_product_get_downloads'         => 'woocommerce_product_files' ,
            'woocommerce_order_get_currency'            => 'woocommerce_get_currency' ,
            'woocommerce_order_get_discount_total'      => 'woocommerce_order_amount_discount_total' ,
            'woocommerce_order_get_discount_tax'        => 'woocommerce_order_amount_discount_tax' ,
            'woocommerce_order_get_shipping_total'      => 'woocommerce_order_amount_shipping_total' ,
            'woocommerce_order_get_shipping_tax'        => 'woocommerce_order_amount_shipping_tax' ,
            'woocommerce_order_get_cart_tax'            => 'woocommerce_order_amount_cart_tax' ,
            'woocommerce_order_get_total'               => 'woocommerce_order_amount_total' ,
            'woocommerce_order_get_total_tax'           => 'woocommerce_order_amount_total_tax' ,
            'woocommerce_order_get_total_discount'      => 'woocommerce_order_amount_total_discount' ,
            'woocommerce_order_get_subtotal'            => 'woocommerce_order_amount_subtotal' ,
            'woocommerce_order_get_tax_totals'          => 'woocommerce_order_tax_totals' ,
            'woocommerce_get_order_refund_get_amount'   => 'woocommerce_refund_amount' ,
            'woocommerce_get_order_refund_get_reason'   => 'woocommerce_refund_reason' ,
            'default_checkout_billing_country'          => 'default_checkout_country' ,
            'default_checkout_billing_state'            => 'default_checkout_state' ,
            'default_checkout_billing_postcode'         => 'default_checkout_postcode' ,
                ) ;
        $key              = array_search( $hook_name , $deprecated_hooks ) ;
    } else {
        $key = $hook_name ;
    }
    return $key ;
}

function sumo_sd_get_product_id( $product ) {
    if(!is_object($product)){
        return;
    }
    
    if( ( float ) WC()->version >= '3.0.0' ) {
        $product_id = $product->get_id() ;
    } else {
        $product_id = $product->variation_id ? $product->variation_id : $product->id ;
    }
    
    return $product_id ;
}

function sumo_sd_get_product_level_id( $product ) {
    if( ( float ) WC()->version >= '3.0.0' ) {
        $product_id = $product->is_type( 'variation' ) ? $product->get_parent_id() : $product->get_id() ;
    } else {
        $product_id = $product->id ;
    }
    return $product_id ;
}

function sumo_sd_get_product( $product_id ) {
    if( function_exists( 'wc_get_product' ) ) {
        $product_object = wc_get_product( $product_id ) ;
    } else {
        $product_object = get_product( $product_id ) ;
    }
    return $product_object ;
}

function sumo_sd_get_variation_object( $product_id , $parent_object ) {
    if( ( float ) WC()->version >= ( float ) '3.0.0' ) {
        $product_object = wc_get_product( $product_id ) ;
    } else {
        $product_object = $parent_object->get_child( $product_id ) ;
    }
    return $product_object ;
}

function sumo_sd_get_price_including_tax( $product , $qty , $price ) {
    if( ( float ) WC()->version < ( float ) '3.0.0' ) {
        $price = $product->get_price_including_tax( $qty , $price ) ;
    } else {
        $price = wc_get_price_including_tax( $product , array( 'qty' => $qty , 'price' => $price ) ) ;
    }
    return $price ;
}

function sumo_sd_get_price_excluding_tax( $product , $qty , $price ) {
    if( ( float ) WC()->version < ( float ) '3.0.0' ) {
        $price = $product->get_price_excluding_tax( $qty , $price ) ;
    } else {
        $price = wc_get_price_excluding_tax( $product , array( 'qty' => $qty , 'price' => $price ) ) ;
    }
    return $price ;
}

function sumo_dynamic_pricing_product_id_from_other_lang( $product_id ) {
    global $sitepress ;
    $id_from_other_lang = '' ;
    if( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) && is_object( $sitepress ) ) {
        $trid         = $sitepress->get_element_trid( $product_id ) ;
        $translations = $sitepress->get_element_translations( $trid ) ;
        foreach( $translations as $translation ) {
            if( $translation->language_code == ICL_LANGUAGE_CODE ) {
                $id_from_other_lang = $translation->element_id ;
            }
        }
        $product_id = $id_from_other_lang ? $id_from_other_lang : $product_id ;
    }
    return $product_id ;
}

function sumo_dynamic_pricing_taxonomy_id_from_other_lang( $taxonomy_id ) {
    global $sitepress ;
    $id_from_other_lang = '' ;
    if( is_plugin_active( 'sitepress-multilingual-cms/sitepress.php' ) && is_object( $sitepress ) ) {
        $taxonomy_lang = icl_object_id( $taxonomy_id , 'category' , true , ICL_LANGUAGE_CODE ) ; //7
        $taxonomy      = get_term_by( 'term_taxonomy_id' , $taxonomy_lang , 'category' ) ;
        $taxonomy_id   = $taxonomy->term_id ;
    }
    return $taxonomy_id ;
}

function sumo_dynamic_pricing_translated_array( $array ) {

    $translated_array = array() ;
    if( ! empty( $array ) ) {
        foreach( $array as $id ) {
            $int_id = ( int ) $id ;
            if( term_exists( $int_id ) ) {
                $translated_array[] = sumo_dynamic_pricing_taxonomy_id_from_other_lang( $int_id ) ;
            } else {
                $translated_array[] = sumo_dynamic_pricing_product_id_from_other_lang( $int_id ) ;
            }
        }
    }
    return $translated_array ;
}

function sumo_dynamic_pricing_cart_quantities() {
    $quantities     = WC()->cart->get_cart_item_quantities() ;
    $sdp_quantities = array() ;
    foreach( $quantities as $product_id => $quantity ) {
        $sdp_quantities[ sumo_dynamic_pricing_product_id_from_other_lang( $product_id ) ] = $quantity ;
    }
    return $sdp_quantities ;
}

function sumo_dynamic_pricing_cart_contents() {
    $items               = WC()->cart->get_cart() ;
    $product_ids_in_cart = array() ;
    $categories_in_cart  = array() ;
    $tags_in_cart        = array() ;
    foreach( $items as $item => $values ) {
        $pro_id   = $values[ 'variation_id' ] ? $values[ 'variation_id' ] : $values[ 'product_id' ] ;
        $category = get_the_terms( $values[ 'product_id' ] , 'product_cat' ) ;
        if( is_array( $category ) ) {
            if( ! empty( $category ) ) {
                foreach( $category as $categorys ) {
                    $categories_in_cart[] = sumo_dynamic_pricing_taxonomy_id_from_other_lang( $categorys->term_id ) ;
                }
            }
        }
        $tag = get_the_terms( $values[ 'product_id' ] , 'product_tag' ) ;
        if( is_array( $tag ) ) {
            if( ! empty( $tag ) ) {
                foreach( $tag as $each_tag ) {
                    $tags_in_cart[] = sumo_dynamic_pricing_taxonomy_id_from_other_lang( $each_tag->term_id ) ;
                }
            }
        }
        $product_ids_in_cart[] = $pro_id ;
    }
    return array( 'product_ids' => $product_ids_in_cart , 'category_ids' => $categories_in_cart , 'tag_ids' => $tags_in_cart ) ;
}

function sumo_pricing_common_ajax_function_to_select_member_plans() {
    ?>
    <script type="text/javascript">
        jQuery( document ).ready( function() {
    <?php if( ( float ) WC()->version < ( float ) '3.0.0' ) { ?>
                jQuery( ".sumomembership_plans_select" ).select2( {
                    placeholder : "Enter atleast 3 characters" ,
                    allowClear : true ,
                    enable : false ,
                    readonly : false ,
                    initSelection : function( data , callback ) {
                        var newjson = '<?php echo json_encode( $json_ids ) ; ?>' ;
                        newjson = JSON.parse( newjson )
                        var data_show = [ ] ;
                        jQuery.each( newjson , function( index , item ) {

                            data_show.push( { id : index , text : item } ) ;

                        } ) ;
                        callback( data_show ) ;
                    } ,
                    multiple : false ,
                    minimumInputLength : 3 ,
                    tags : [ ] ,
                    ajax : {
                        url : '<?php echo admin_url( 'admin-ajax.php' ) ; ?>' ,
                        dataType : 'json' ,
                        type : "GET" ,
                        quietMillis : 250 ,
                        data : function( term ) {
                            return {
                                term : term ,
                                action : "sumo_search_membership_plans" ,
                            } ;
                        } ,
                        results : function( data ) {
                            var terms = [ ] ;
                            if( data ) {
                                jQuery.each( data , function( id , text ) {
                                    terms.push( {
                                        id : id ,
                                        text : text
                                    } ) ;
                                } ) ;
                            }
                            return { results : terms } ;
                        } ,
                    } ,
                } ).select2( 'val' , '1' ) ;
    <?php } else {
        ?>
                jQuery( ".sumomembership_plans_select" ).select2( {
                    placeholder : "Enter atleast 3 characters" ,
                    allowClear : true ,
                    //                                    enable: false,
                    //                                    maximumSelectionSize: 1,
                    //                                    readonly: false,
                    //                                    multiple: false,
                    minimumInputLength : 3 ,
                    //                                    tags: [],
                    escapeMarkup : function( m ) {
                        return m ;
                    } ,
                    ajax : {
                        url : '<?php echo admin_url( 'admin-ajax.php' ) ; ?>' ,
                        dataType : 'json' ,
                        quietMillis : 250 ,
                        data : function( params ) {
                            return {
                                term : params.term ,
                                action : 'sumo_search_membership_plans'
                            } ;
                        } ,
                        processResults : function( data ) {
                            var terms = [ ] ;
                            if( data ) {
                                jQuery.each( data , function( id , text ) {
                                    terms.push( {
                                        id : id ,
                                        text : text
                                    } ) ;
                                } ) ;
                            }
                            return {
                                results : terms
                            } ;
                        } ,
                        cache : true
                    }
                } ) ;
    <?php }
    ?>
        } ) ;
    </script>
    <?php
}

function check_if_free_shipping_enabled() {
    global $woocommerce ;
    $shipping_methods = $woocommerce->shipping->load_shipping_methods() ;
    if( ! isset( $shipping_methods[ 'free_shipping' ] ) )
        return false ;

    if( $shipping_methods[ 'free_shipping' ]->enabled == "yes" )
        return true ;

    return false ;
}
