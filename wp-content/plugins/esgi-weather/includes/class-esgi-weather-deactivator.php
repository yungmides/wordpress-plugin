<?php
class ESGI_Weather_Deactivator {
    /**
     * @global wpdb $wpdb WordPress database abstraction object.
     */
    public static function deactivate() {
        global $wpdb;
        $wpdb->query("DROP TABLE IF EXISTS ". $wpdb->prefix . "weather_cities;");


    }

}