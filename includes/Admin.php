<?php

namespace ElegantThemes;

class Admin {
    /**
     * Operates all the admin functionalities
     */
    public function __construct() {
        add_action( "wp_ajax_elegant-theme", [$this, "eg_ajax_handler"] );
        add_action( "wp_ajax_nopriv_elegant-theme", [$this, "eg_ajax_handler"] );
        add_action( "admin_post_elegant-theme", [$this, "eg_ajax_handler"] );
        add_action( "admin_post_nopriv_elegant-theme", [$this, "eg_ajax_handler"] );

        add_action( 'show_user_profile', [$this, 'eg_additional_profile_fields'] );
        add_action( 'edit_user_profile', [$this, 'eg_additional_profile_fields'] );
    }

    /**
     * Handles the ajax request sent from cr,
     *
     * @return void
     */
    public function eg_ajax_handler() {

        $name   = $_POST['name'] ? sanitize_text_field( $_POST['name'] ) : "";
        $email  = $_POST['email'] ? sanitize_text_field( $_POST['email'] ) : "";
        $crm_id = $_POST['id'] ? sanitize_text_field( $_POST['id'] ) : "";

        if ( empty( $name ) || empty( $email ) || empty( $crm_id ) ) {
            wp_send_json_error( "Name, email or id is missing" );
        }

        $user = get_user_by( "email", $email );

        if ( $user ) {
            wp_send_json_error( "User Already Exists" );
        }

        $createUserId = wp_create_user( $name, md5( $name ), $email );

        add_user_meta( $createUserId, "crm_id", $crm_id );

        wp_send_json_success( "User created successfully. Username: $name, Email: $email, Pass: $name", 200 );
        exit;
    }

    /**
     * Button on user profile where it links directly to the crm
     *
     * @param Oject $user
     * @return void
     */ 
    public function eg_additional_profile_fields($user) {
        $crm_id = get_user_meta($user->id,"crm_id",true);

        if( is_admin() ){ 
            echo '<a target="blank" href="http://127.0.0.1:8000/user/' . $crm_id . '" class="button button-primary">Go to CRM</a>';
        }
    }

}
