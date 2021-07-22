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

class esgi_widget extends WP_Widget
{
    // Set up the widget name and description.
    public function __construct()
    {
        $widget_options = array('classname' => 'esgi_widget', 'description' => 'Un plugin de météo par le groupe 7.');
        // parent::__construct('esgi_widget', 'ESGI Widget', $widget_options);
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
        $days = $instance['days'];
        $showSunrise = $instance['showSunrise'];
        $showWind = $instance['showWind'];
        $showCurrent = $instance['showCurrent'];

        echo '<div class="esgi_widget weather_widget_wrap"
                 data-text-color="' . $textColor . '"
                 data-background="' . $backgroundColor . '"
                 data-width="' . $widgetWidth . '"
                 data-days="' . $days . '"
                 data-sunrise="' . $showSunrise . '"
                 data-wind="' . $showWind . '"
                 data-current="' . $showCurrent . '"
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

        if (isset($instance['days'])) {
            $days = $instance['days'];
        } else {
            $days = 3;
        }


        if (isset($instance['showSunrise'])) {
            $showSunrise = $instance['showSunrise'];
        } else {
            $showSunrise = "";
        }

        if (isset($instance['showWind'])) {
            $showWind = $instance['showWind'];
        } else {
            $showWind = "";
        }

        $showCurrent = !empty($instance['showCurrent']) ? $instance['showCurrent'] : 'on';

        ?>
        <div class="tiempo_form">
            <div class="form-section">
                <h3>Location</h3>
                <div class="form-line">
                    <label class="text-label" for="<?php echo $this->get_field_id('city'); ?>">City:</label>
                    <input type="text" id="<?php echo $this->get_field_id('city'); ?>"
                           name="<?php echo $this->get_field_name('city'); ?>"
                           value="<?php echo esc_attr($city); ?>"/>
                </div>
                <div class="form-line">
                    <label class="text-label" for="<?php echo $this->get_field_id('country'); ?>">Country:</label>
                    <input type="text" id="<?php echo $this->get_field_id('country'); ?>"
                           name="<?php echo $this->get_field_name('country'); ?>"
                           value="<?php echo esc_attr($country); ?>"/>
                </div>
            </div>

            <div class="form-section">
                <h3>Weather Data</h3>
                <div class="form-line">
                    <input type="checkbox"
                        <?php if ($showCurrent == 'on') {
                            echo 'checked';
                        }; ?>
                           id="<?php echo $this->get_field_id('showCurrent'); ?>"
                           name="<?php echo $this->get_field_name('showCurrent'); ?>"/>
                    <label for="<?php echo $this->get_field_id('showCurrent'); ?>">Show: Current weather</label>
                </div>
                <div class="form-line">
                    <input type="checkbox"
                        <?php if ($showWind == 'on') {
                            echo 'checked';
                        }; ?>
                           id="<?php echo $this->get_field_id('showWind'); ?>"
                           name="<?php echo $this->get_field_name('showWind'); ?>"/>
                    <label for="<?php echo $this->get_field_id('showWind'); ?>">Show: Chance for rain, Wind and
                        Humidity</label>
                </div>
                <div class="form-line">
                    <input type="checkbox"
                        <?php if ($showSunrise == 'on') {
                            echo 'checked';
                        }; ?>
                           id="<?php echo $this->get_field_id('showSunrise'); ?>"
                           name="<?php echo $this->get_field_name('showSunrise'); ?>"/>
                    <label for="<?php echo $this->get_field_id('showSunrise'); ?>">Show: Sunrise and sunset time</label>
                </div>
            </div>
            <div class="form-section">
                <h3>Daily Forecast</h3>
                <div class="form-line">
                    <select name="<?php echo $this->get_field_name('days'); ?>">
                        <option value="0" <?php if ($days == 0) {
                            echo 'selected';
                        } ?>>No Daily Forecast
                        </option>
                        <option value="2" <?php if ($days == 2) {
                            echo 'selected';
                        } ?>>2 Days
                        <option value="3" <?php if ($days == 3) {
                            echo 'selected';
                        } ?>>3 Days
                        </option>
                        <option value="4" <?php if ($days == 4) {
                            echo 'selected';
                        } ?>>4 Days
                        </option>
                        <option value="5" <?php if ($days == 5) {
                            echo 'selected';
                        } ?>>5 Days
                        </option>
                        <option value="6" <?php if ($days == 6) {
                            echo 'selected';
                        } ?>>6 Days
                        </option>
                    </select>
                </div>
            </div>


            <div class="form-section">
                <h3>Look & Feel</h3>

                <div class="form-line">
                    <label for="<?php echo $this->get_field_id('backgroundColor'); ?>">Background Color
                        (optional):</label>
                    <input type="color" id="<?php echo $this->get_field_id('backgroundColor'); ?>"
                           name="<?php echo $this->get_field_name('backgroundColor'); ?>"
                           value="<?php echo esc_attr($backgroundColor); ?>"/>
                </div>
                <div class="form-line">
                    <label for="<?php echo $this->get_field_id('textColor'); ?>">Text Color (optional):</label>
                    <input type="color" id="<?php echo $this->get_field_id('textColor'); ?>"
                           name="<?php echo $this->get_field_name('textColor'); ?>"
                           value="<?php echo esc_attr($textColor); ?>"/>
                </div>
                <div>
                    <div class="widget-width-line"><label for="<?php echo $this->get_field_id('widgetWidth'); ?>">Widget Stretch (width):</label>
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
                               value="tight"/> Tight as possible
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
        $instance['showSunrise'] = sanitize_text_field($new_instance['showSunrise']);
        $instance['showWind'] = sanitize_text_field($new_instance['showWind']);
        $instance['showCurrent'] = sanitize_text_field($new_instance['showCurrent']);
        $instance['days'] = sanitize_text_field(strip_tags($new_instance['days']));
        if ($new_instance['showSunrise'] != "on") {
            $instance['showSunrise'] = "false";
        }
        if ($new_instance['showWind'] != "on") {
            $instance['showWind'] = "false";
        }
        if ($new_instance['showCurrent'] != "on") {
            $instance['showCurrent'] = "false";
        }
        return $instance;
    }
}

// Register the widget.
function jpen_register_esgi_widget()
{
    register_widget('esgi_widget');
}

add_action('widgets_init', 'jpen_register_esgi_widget');

run_weather();