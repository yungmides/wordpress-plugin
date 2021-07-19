<?php
class ESGI_Weather_Activator {
    /**
     * @global wpdb $wpdb WordPress database abstraction object.
     */
    public static function activate() {
        global $wpdb;
        $wpdb->query("CREATE TABLE IF NOT EXISTS {$wpdb->prefix} weather_cities (id INT AUTO_INCREMENT PRIMARY KEY, city VARCHAR(255) NOT NULL);");

    }

}