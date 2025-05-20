<?php
/**
 * Class Turbo_Drive_Settings
 *
 * Manages the settings page for Turbo Drive in WordPress admin
 *
 * @package Turbo_Drive
 */

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

class Turbo_Drive_Settings
{
    /**
     * Instance of the class
     *
     * @var Turbo_Drive_Settings
     */
    private static $instance = null;

    /**
     * Option name in the database
     *
     * @var string
     */
    private $option_name = 'turbo_drive_options';

    /**
     * Default options
     *
     * @var array
     */
    private $default_options = array(
        'progress_bar_color' => '#29d',
    );

    /**
     * Constructor
     */
    private function __construct()
    {
        add_action('admin_menu', array( $this, 'add_settings_page' ));
        add_action('admin_init', array( $this, 'register_settings' ));
    }

    /**
     * Get the unique instance of the class
     *
     * @return Turbo_Drive_Settings
     */
    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Add settings page to admin menu
     */
    public function add_settings_page()
    {
        add_options_page(
            __('Turbo Drive Settings', 'turbo-drive'),
            __('Turbo Drive', 'turbo-drive'),
            'manage_options',
            'turbo-drive-settings',
            array( $this, 'render_settings_page' )
        );
    }

    /**
     * Register settings
     */
    public function register_settings()
    {
        register_setting(
            'turbo_drive_settings_group',
            $this->option_name,
            array( $this, 'sanitize_options' )
        );

        add_settings_section(
            'turbo_drive_general_section',
            __('General Settings', 'turbo-drive'),
            array( $this, 'render_general_section' ),
            'turbo-drive-settings'
        );

        add_settings_field(
            'progress_bar_color',
            __('Progress Bar Color', 'turbo-drive'),
            array( $this, 'render_progress_bar_color_field' ),
            'turbo-drive-settings',
            'turbo_drive_general_section'
        );
    }

    /**
     * Sanitize options before saving
     *
     * @param array $input Options to sanitize.
     * @return array Sanitized options.
     */
    public function sanitize_options($input)
    {
        $sanitized_input = array();

        // Sanitize progress bar color
        if (isset($input['progress_bar_color'])) {
            $sanitized_input['progress_bar_color'] = sanitize_hex_color($input['progress_bar_color']);
            if (empty($sanitized_input['progress_bar_color'])) {
                $sanitized_input['progress_bar_color'] = $this->default_options['progress_bar_color'];
            }
        }

        return $sanitized_input;
    }

    /**
     * Display general section description
     */
    public function render_general_section()
    {
        echo '<p>' . esc_html__('Configure Turbo Drive options for your site.', 'turbo-drive') . '</p>';
    }

    /**
     * Display progress bar color field
     */
    public function render_progress_bar_color_field()
    {
        $options = $this->get_options();
        $color = isset($options['progress_bar_color']) ? $options['progress_bar_color'] : $this->default_options['progress_bar_color'];

        echo '<input type="color" id="turbo_drive_progress_bar_color" name="' . esc_attr($this->option_name) . '[progress_bar_color]" value="' . esc_attr($color) . '">';
        echo '<p class="description">' . esc_html__('Choose the color of the progress bar that appears during page loads.', 'turbo-drive') . '</p>';
    }

    /**
     * Display settings page
     */
    public function render_settings_page()
    {
        if (! current_user_can('manage_options')) {
            return;
        }

        ?>
		<div class="wrap">
			<h1><?php echo esc_html(get_admin_page_title()); ?></h1>
			<form action="options.php" method="post">
				<?php
                settings_fields('turbo_drive_settings_group');
        do_settings_sections('turbo-drive-settings');
        submit_button();
        ?>
			</form>
		</div>
		<?php
    }

    /**
     * Get options with default values if necessary
     *
     * @return array
     */
    public function get_options()
    {
        $options = get_option($this->option_name, $this->default_options);
        return wp_parse_args($options, $this->default_options);
    }

    /**
     * Get value of a specific option
     *
     * @param string $key Option key.
     * @param mixed  $default Default value.
     * @return mixed
     */
    public function get_option($key, $default = null)
    {
        $options = $this->get_options();

        if (isset($options[$key])) {
            return $options[$key];
        }

        return $default !== null ? $default : $this->default_options[$key] ?? null;
    }
}
