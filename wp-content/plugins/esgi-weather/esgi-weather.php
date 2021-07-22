<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @since             1.0.0
 * @package           ESGI Weather
 *
 * @wordpress-plugin
 * Plugin Name:       ESGI Weather
 * Description:       Un plugin de météo par le groupe 7.
 * Version:           1.0.0
 * Author:            Jédidia, Marine, Alexandre TROUVE, Locman, Mehdi
 *
 */

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

class esgi_widget extends WP_Widget
{
    // Set up the widget name and description.
    public function __construct()
    {
        $widget_options = array('classname' => 'esgi_weather', 'description' => 'Un plugin de météo par le groupe 7.');
        parent::__construct('esgi_weather', 'ESGI Weather', $widget_options);
    }


    // Create the widget output.
    public function widget($args, $instance)
    {
        // Keep this line
        echo $args['before_widget'];

        $city = $instance['city'];
        $country = $instance['country'];
        $backgroundColor = $instance['backgroundColor'];
        $widgetWidth = $instance['widgetWidth'];
        $textColor = $instance['textColor'];

        echo '<div class="esgi_widget weather_widget_wrap"
                 data-text-color="' . $textColor . '"
                 data-background="' . $backgroundColor . '"
                 data-width="' . $widgetWidth . '"
                 data-city="' . $city . '"
                 data-country="' . $country . '">
    
                <div class="weather_widget_placeholder"></div>
            </div>';

        echo $args['after_widget'];
    }


    // Create the admin area widget settings form.
    public function form($instance)
    {
        // print_r($instance);
        $city = !empty($instance['city']) ? $instance['city'] : 'Paris';
        $country = !empty($instance['country']) ? $instance['country'] : 'France';
        $backgroundColor = !empty($instance['backgroundColor']) ? $instance['backgroundColor'] : '#becffb';
        $textColor = !empty($instance['textColor']) ? $instance['textColor'] : '#000000';

        if (isset($instance['widgetWidth'])) {
            $widgetWidth = $instance['widgetWidth'];
        } else {
            $widgetWidth = '100';
        }

        ?>
        <div class="esgi_weather_form">
            <div class="form-section">
                <h3>Localisation</h3>
                <div class="form-line">
                    <label class="text-label" for="<?php echo $this->get_field_id('city'); ?>">Ville :</label>
                    <input type="text" id="<?php echo $this->get_field_id('city'); ?>"
                           name="<?php echo $this->get_field_name('city'); ?>"
                           value="<?php echo esc_attr($city); ?>"/>
                </div>
                <div class="form-line">
                    <label class="text-label" for="<?php echo $this->get_field_id('country'); ?>">Pays :</label>
                    <input type="text" id="<?php echo $this->get_field_id('country'); ?>"
                           name="<?php echo $this->get_field_name('country'); ?>"
                           value="<?php echo esc_attr($country); ?>"/>
                </div>
            </div>

            <div class="form-section">
                <h3>Style</h3>

                <div class="form-line">
                    <label for="<?php echo $this->get_field_id('backgroundColor'); ?>">Couleur de fond (optionnel) :</label>
                    <input type="color" id="<?php echo $this->get_field_id('backgroundColor'); ?>"
                           name="<?php echo $this->get_field_name('backgroundColor'); ?>"
                           value="<?php echo esc_attr($backgroundColor); ?>"/>
                </div>
                <div class="form-line">
                    <label for="<?php echo $this->get_field_id('textColor'); ?>">Couleur du texte (optionnel) :</label>
                    <input type="color" id="<?php echo $this->get_field_id('textColor'); ?>"
                           name="<?php echo $this->get_field_name('textColor'); ?>"
                           value="<?php echo esc_attr($textColor); ?>"/>
                </div>
                <div>
                    <div class="widget-width-line"><label for="<?php echo $this->get_field_id('widgetWidth'); ?>">Taille du widget :</label>
                    </div>
                    <div class="form-line">
                        <input type="radio" id="<?php echo $this->get_field_id('widgetWidth'); ?>"
                            <?php if ($widgetWidth == '100') {
                                echo 'checked';
                            }; ?>
                               name="<?php echo $this->get_field_name('widgetWidth'); ?>"
                               value="100"/> 100%
                        <input type="radio" id="<?php echo $this->get_field_id('widgetWidth'); ?>"
                            <?php if ($widgetWidth == 'tight') {
                                echo 'checked';
                            }; ?>
                               name="<?php echo $this->get_field_name('widgetWidth'); ?>"
                               value="tight"/> Le plus petit possible
                    </div>
                </div>
            </div>
        </div>
        <?php
    }


    // Apply settings to the widget instance.
    public function update($new_instance, $old_instance)
    {
        // print_r($old_instance);
        $instance = $old_instance;
        if (!empty($new_instance['city'])) {
            $instance['city'] = sanitize_text_field(strip_tags($new_instance['city']));
        }

        if (!empty($new_instance['country'])) {
            $instance['country'] = sanitize_text_field(strip_tags($new_instance['country']));
        }
        $instance['backgroundColor'] = sanitize_hex_color(strip_tags($new_instance['backgroundColor']));
        $instance['textColor'] = sanitize_hex_color(strip_tags($new_instance['textColor']));
        $instance['widgetWidth'] = sanitize_text_field(strip_tags($new_instance['widgetWidth']));
        return $instance;
    }
}

// Register the widget.
function jpen_register_esgi_widget()
{
    register_widget('esgi_widget');
}

add_action('widgets_init', 'jpen_register_esgi_widget');
