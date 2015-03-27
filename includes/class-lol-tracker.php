<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://github.com/vvasiloud/wp-loltracker
 * @since      1.0.0
 *
 * @package    LoL_Tracker
 * @subpackage LoL_Tracker/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    LoL_Tracker
 * @subpackage LoL_Tracker/includes
 * @author     Vasilis Vasiloudis <vvasiloudis@gmail.com>
 */
class LoL_Tracker
{
    
    private $region_id;
    private $api_key;
    
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      LoL_Tracker_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;
    
    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $lol_tracker    The string used to uniquely identify this plugin.
     */
    protected $lol_tracker;
    
    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;
    
    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct()
    {
        
        $this->lol_tracker = 'lol-tracker';
        $this->version     = '1.0.0';
        
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        
		$options =  get_option( 'lol_tracker_settings' );
		$this->api_key  = $options['lol_tracker_riot_api_key'] ;
		$this->region_id = $options['lol_tracker_region_name'];
        
        
    }
    
    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - LoL_Tracker_Loader. Orchestrates the hooks of the plugin.
     * - LoL_Tracker_i18n. Defines internationalization functionality.
     * - LoL_Tracker_Admin. Defines all hooks for the admin area.
     * - LoL_Tracker_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies()
    {
        
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-lol-tracker-loader.php';
        
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'includes/class-lol-tracker-i18n.php';
        
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-lol-tracker-admin.php';
        
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path(dirname(__FILE__)) . 'public/class-lol-tracker-public.php';
        
        
        $this->loader = new LoL_Tracker_Loader();
        
    }
    
    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Plugin_Name_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale()
    {
        
        $plugin_i18n = new LoL_Tracker_i18n();
        $plugin_i18n->set_domain($this->get_plugin_name());
        
        $this->loader->add_action('plugins_loaded', $plugin_i18n, 'load_plugin_textdomain');
        
    }
    
    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks()
    {
        
        $plugin_admin = new LoL_Tracker_Admin($this->get_plugin_name(), $this->get_version());
        
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_styles');
        $this->loader->add_action('admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts');
        
    }
    
    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks()
    {
        
        $plugin_public = new LoL_Tracker_Public($this->get_plugin_name(), $this->get_version());
        
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_styles');
        $this->loader->add_action('wp_enqueue_scripts', $plugin_public, 'enqueue_scripts');
        
        add_action('wp_ajax_showFreeChampions', array(
            $this,
            'showFreeChampions'
        ));
        add_action('wp_ajax_nopriv_showFreeChampions', array(
            $this,
            'showFreeChampions'
        ));
        
    }
    
    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run()
    {
        $this->loader->run();
    }
    
    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name()
    {
        return $this->lol_tracker;
    }
    
    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    LoL_Tracker_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader()
    {
        return $this->loader;
    }
    
    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version()
    {
        return $this->version;
    }
    
    
    private function _requestFreeChampions()
    {
        $json_url = 'https://' . $this->region_id . '.api.pvp.net/api/lol/eune/v1.2/champion?freeToPlay=true&api_key=' . $this->api_key;
        $json     = file_get_contents($json_url);
        $dataObj  = json_decode($json);
        
        return $dataObj;
    }
    
    private function _requestChampionData($champion_id)
    {
        $json_url = 'https://' . $this->region_id . '.api.pvp.net/api/lol/static-data/eune/v1.2/champion/' . $champion_id . '?champData=image,info&api_key=' . $this->api_key;
        $json     = file_get_contents($json_url);
        $dataObj  = json_decode($json);
        
        return $dataObj;
    }
    
    public function showFreeChampions()
    {
        $freeChampions = $this->_requestFreeChampions();
        foreach ($freeChampions->champions as $obj) {
            $championId              = $obj->id;
            $freeWeekChampionsJson[] = $this->_requestChampionData($championId);
        }
        
        foreach ($freeWeekChampionsJson as $champion) {
            $sprite = $champion->image->sprite;
            $cord_x = $champion->image->x;
            $cord_y = $champion->image->y;
?>
			<div class ="fwc-img" style= "background-image: url('//ddragon.leagueoflegends.com/cdn/4.15.1/img/sprite/<?php
            echo $sprite; ?>'); background-position: -<?php echo $cord_x; ?>px -<?php echo $cord_y; ?>px; background-repeat: no-repeat;"></div>
		<?php
        }
        wp_die();
    }
    
}


	class lol_tracker_fwc_widget extends WP_Widget
	{
		
		function lol_tracker_fwc_widget()
		{
			parent::WP_Widget(false, $name = __('LoL Tracker - Free Week Champions', 'lol_tracker_fwc_widget'));
		}
		
		function form($instance)
		{
			if ($instance) {
				$title = esc_attr($instance['title']);
			} else {
				$title = '';
			}
	?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'lol_tracker_fwc_widget'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
			</p>
			<?php
		}
		
		function update($new_instance, $old_instance)
		{
			$instance          = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			
			return $instance;
		}
		
		function widget($args, $instance)
		{
			extract($args);
			$title    = apply_filters('widget_title', $instance['title']);
			echo $before_widget;
			echo '<div class="widget-text wp_widget_plugin_box">';
			
			if ($title) {
				echo $before_title . $title . $after_title;
			}
			
			echo '<div id="lol_tracker_widget_freechampions"></div>';
			echo '</div>';
			echo $after_widget;
		}
	}

	add_action('widgets_init', create_function('', 'return register_widget("lol_tracker_fwc_widget");'));
