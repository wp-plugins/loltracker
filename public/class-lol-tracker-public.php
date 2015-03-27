<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/vvasiloud/wp-loltracker
 * @since      1.0.0
 *
 * @package    LoL_Tracker
 * @subpackage LoL_Tracker/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    LoL_Tracker
 * @subpackage LoL_Tracker/public
 * @author     Vasilis Vasiloudis <vvasiloudis@gmail.com>
 */
class LoL_Tracker_Public {

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
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $lol_tracker       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $lol_tracker, $version ) {

		$this->lol_tracker = $lol_tracker;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->lol_tracker, plugin_dir_url( __FILE__ ) . 'css/lol-tracker-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the scripts for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->lol_tracker, plugin_dir_url( __FILE__ ) . 'js/lol-tracker-public.js', array( 'jquery' ), $this->version, false );
		add_action( 'wp_enqueue_scripts', 'jsVariables' );
		$this->jsVariables();

	}
	
	public function jsVariables() {
		echo '<script>var preloaderUrl ="'. plugins_url( 'images/preloader.gif' , __FILE__ ). '"</script>';
	
	}

}
