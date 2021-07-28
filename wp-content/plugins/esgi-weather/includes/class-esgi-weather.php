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
                'weather_page'
            );
        }

        function weather_page() {
            ?>
            <h1>ESGI Weather Settings</h1>
            <form action="options.php" method="post">
                <?php
                settings_fields('esgi_weather_options');
                do_settings_sections('esgi_weather_wp_plugin');
                ?>
                <?php submit_button(); ?>
            </form>

            <?php
        }

        function esgi_weather_register_settings() {
            register_setting('esgi_weather_options', 'esgi_weather_options', 'esgi_weather_options_validate');

            add_settings_section('api_settings', 'API Settings', 'esgi_weather_section_text', 'esgi_weather_wp_plugin');

            add_settings_field( 'esgi_weather_setting_city', 'City', 'esgi_weather_setting_city', 'esgi_weather_wp_plugin', 'api_settings' );
            add_settings_field( 'esgi_weather_setting_api_key', 'API Key', 'esgi_weather_setting_api_key', 'esgi_weather_wp_plugin', 'api_settings' );

            // Ajouter de la clé API ? Mais risque de sécurité
        }

        function esgi_weather_section_text() {
            echo '<p>Here you can insert cities for the Weather plugin</p>';
        }

        function esgi_options_validate($input) {
            $newinput['city'] = trim($input['city']);
            $newinput['city'] = ucwords($newinput['city']);
            return $newinput;
        }

        function esgi_weather_setting_city() {
            $options = get_option('esgi_weather_options');
            echo "<input id='esgi_weather_setting_city' name='esgi_weather_options[city]' type='text' value='" . esc_attr( $options['city'] ) . "' />";
        }
        function esgi_weather_setting_api_key() {
            $options = get_option('esgi_weather_options');
            echo "<input id='esgi_weather_setting_api_key' name='esgi_weather_options[api_key]' type='text' value='" . esc_attr( $options['api_key'] ) . "' />";
        }

        add_action('admin_menu', 'wpdocs_register_my_custom_menu_page' );
        add_action('admin_init', 'esgi_weather_register_settings');
    }
    


}