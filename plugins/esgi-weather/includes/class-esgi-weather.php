<?php
class ESGI_Weather{

    public function __construct()
    {

    }

    public function run() {
        add_menu_page('Météo', 'Météo', "manage_options", 'weather' );
    }


}