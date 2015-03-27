<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/vvasiloud/wp-loltracker
 * @since      1.0.0
 *
 * @package    LoL_Tracker
 * @subpackage LoL_Tracker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    LoL_Tracker
 * @subpackage LoL_Tracker/admin
 * @author     Vasilis Vasiloudis <vvasiloudis@gmail.com>
 */
class LoL_Tracker_Admin
{
    
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $lol_tracker    The ID of this plugin.
     */
    private $lol_tracker;
    
    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;
	
	 /**
     * The settings of this plugin.
     *
     * @since    1.0.0
     * @access   public
     * @var      array    $settings    The settings of this plugin.
     */
	public $settings = array();
    
    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $lol_tracker       The name of this plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($lol_tracker, $version)
    {
        
        $this->lol_tracker = $lol_tracker;
        $this->version     = $version;
    }
    
    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles()
    {
        
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in LoL_Tracker_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The LoL_Tracker_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        
        wp_enqueue_style($this->lol_tracker, plugin_dir_url(__FILE__) . 'css/lol-tracker-admin.css', array(), $this->version, 'all');
        
    }
    
    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts()
    {
        
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in LoL_Tracker_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The LoL_Tracker_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        
        wp_enqueue_script($this->lol_tracker, plugin_dir_url(__FILE__) . 'js/lol-tracker-admin.js', array(
            'jquery'
        ), $this->version, false);
        
    }
    
}


	

	add_action( 'admin_menu', 'lol_tracker_add_admin_menu' );
	add_action( 'admin_init', 'lol_tracker_settings_init' );

    /**
     * Admin menu addition.
     *
     * @since    1.0.0
     */
	function lol_tracker_add_admin_menu(  ) { 
		
		add_menu_page( 'LoL Tracker', 'LoL Tracker', 'manage_options', 'lol_tracker', 'lol_tracker_options_page',plugins_url('loltracker/admin/images/icon.ico') );

	}

    /**
     * Settings initialization.
     *
     * @since    1.0.0
     */
	function lol_tracker_settings_init(  ) { 

		register_setting( 'settingsPage', 'lol_tracker_settings' );

		add_settings_section(
			'lol_tracker_settingsPage_section', 
			__( 'Settings', 'lol-tracker' ), 
			'lol_tracker_settings_section_callback', 
			'settingsPage'
		);

		add_settings_field( 
			'lol_tracker_riot_api_key', 
			__( 'Riot API Key*', 'lol-tracker' ), 
			'lol_tracker_riot_api_key_render', 
			'settingsPage', 
			'lol_tracker_settingsPage_section' 
		);

		add_settings_field( 
			'lol_tracker_region_name', 
			__( 'Region*', 'lol-tracker' ), 
			'lol_tracker_region_name_render', 
			'settingsPage', 
			'lol_tracker_settingsPage_section' 
		);


	}

    /**
     * Settings Riot Api Key Render.
     *
     * @since    1.0.0
     */
	function lol_tracker_riot_api_key_render(  ) { 

		$options = get_option( 'lol_tracker_settings' );
		?>
			<input type='text' name='lol_tracker_settings[lol_tracker_riot_api_key]' value='<?php echo $options['lol_tracker_riot_api_key']; ?>'>
		<?php

	}


    /**
     * Settings Region Name Render.
     *
     * @since    1.0.0
     */
	function lol_tracker_region_name_render(  ) { 

		$options = get_option( 'lol_tracker_settings' );
		?>
		<select name='lol_tracker_settings[lol_tracker_region_name]'>
			<option value="global" <?php selected( $options['lol_tracker_region_name'], 'global' ); ?> >Global</option>
			<option value="br" <?php selected( $options['lol_tracker_region_name'], 'br' ); ?> >BR</option>
			<option value="eune" <?php selected( $options['lol_tracker_region_name'], 'eune' ); ?> >EUNE</option>
			<option value="euw" <?php selected( $options['lol_tracker_region_name'], 'euw' ); ?> >EUW</option>
			<option value="kr" <?php selected( $options['lol_tracker_region_name'], 'kr' ); ?> >KR</option>
			<option value="lan" <?php selected( $options['lol_tracker_region_name'], 'lan' ); ?> >LAN</option>
			<option value="las" <?php selected( $options['lol_tracker_region_name'], 'las' ); ?> >LAS</option>
			<option value="na" <?php selected( $options['lol_tracker_region_name'], 'na' ); ?> >NA</option>
			<option value="oce" <?php selected( $options['lol_tracker_region_name'], 'oce' ); ?> >OCE</option>
			<option value="tr" <?php selected( $options['lol_tracker_region_name'], 'tr' ); ?> >TR</option>
			<option value="ru" <?php selected( $options['lol_tracker_region_name'], 'ru' ); ?> >RU</option>
			<option value="pbe" <?php selected( $options['lol_tracker_region_name'], 'pbe' ); ?> >PBE</option>
		</select>
		

	<?php

	}


    /**
     * Settings section callback.
     *
     * @since    1.0.0
     */
	function lol_tracker_settings_section_callback(  ) { 

		echo __( 'Please fill the required fields', 'lol-tracker' );

	}


    /**
     * Settings form Render.
     *
     * @since    1.0.0
     */
	function lol_tracker_options_page(  ) { 

		?>
		<form action='options.php' method='post'>
			
			<h2>LoL Tracker</h2>
			
			<?php
			settings_fields( 'settingsPage' );
			do_settings_sections( 'settingsPage' );
			submit_button();
			?>
			
		</form>
		<?php

	}

	?>
