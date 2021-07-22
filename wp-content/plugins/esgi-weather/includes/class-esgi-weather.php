<?php
class ESGI_Weather{

    public function __construct()
    {

    }

    public function run() {
        // add_menu_page('Météo', 'Météo', "manage_options", 'weather' );
        function wpdocs_register_my_custom_menu_page() {
            add_options_page( 
                __( 'ESGI Weather', 'textdomain' ),
                __( 'ESGI Weather', 'textdomain' ),
                'manage_options',
                'weather.php',
                'weather'
            );
        }
        add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );
    }
    


}