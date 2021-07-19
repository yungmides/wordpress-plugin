<?php
/**
 * Plugin Name: ESGI Weather
 * Description: Un plugin de météo par le groupe 7.
 * Author: Jédidia, Marine, Alexandre TROUVE, Locman, Mehdi
 *
 */

//Inspiré par: https://github.com/DevinVinson/WordPress-Plugin-Boilerplate


//require_once plugin_dir_path(__FILE__).'esgi-esgi-weather-api-test.php';

function weather_activation(){
    require_once plugin_dir_path(__FILE__) . 'includes/class-esgi-weather-activator.php';
    ESGI_Weather_Activator::activate();
}
function weather_deactivation() {
    require_once plugin_dir_path(__FILE__) . 'includes/class-esgi-weather-deactivator.php';
    ESGI_Weather_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'weather_activation');
register_deactivation_hook(__FILE__, 'weather_deactivation');

require plugin_dir_path(__FILE__) . 'includes/class-esgi-weather.php';

function run_weather() {
    $plugin = new ESGI_Weather();
    $plugin->run();
}

run_weather();