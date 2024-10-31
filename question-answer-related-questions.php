<?php
/*
Plugin Name: Question Answer - Related Questions
Plugin URI: http://pickplugins.com
Description: Related questions list for Question Answer plugin.
Version: 1.0.0
Text Domain: question-answer-related-questions
Author: pickplugins
Author URI: http://pickplugins.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

if ( ! defined('ABSPATH')) exit;  // if direct access 


class QuestionAnswerRelatedQuestions{
	
	public function __construct(){
	
		$this->_define_constants();	
		$this->_loading_script();
		$this->_loading_functions();
		
		//register_activation_hook( __FILE__, array( $this, '_activation' ) );
		add_action( 'plugins_loaded', array( $this, 'load_textdomain' ));
		
	
	}
	
	public function _activation() {


	
	}
	
	public function load_textdomain() {
		
		load_plugin_textdomain( QARQ_TEXTDOMAIN, false, plugin_basename( dirname( __FILE__ ) ) . '/languages/' ); 
	}
	

	
	public function _loading_functions() {
		
		require_once( QARQ_PLUGIN_DIR . 'includes/functions.php');
	}
	

	
	public function _loading_script() {
	

		add_action( 'wp_enqueue_scripts', array( $this, '_front_scripts' ) );

	}

	
	public function _define_constants() {

		$this->define('QARQ_PLUGIN_URL', plugins_url('/', __FILE__)  );
		$this->define('QARQ_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
		$this->define('QARQ_TEXTDOMAIN', 'question-answer-related-questions' );
		$this->define('QARQ_PLUGIN_NAME', __('Question Answer - Related Questions', QARQ_TEXTDOMAIN) );
		$this->define('QARQ_PLUGIN_SUPPORT', 'http://www.pickplugins.com/questions/'  );
		
	}
	
	private function define( $name, $value ) {
		if( $name && $value )
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}
	
	

		
		
	public function _front_scripts(){

		wp_enqueue_style('qa-related-questions', QARQ_PLUGIN_URL.'assets/front/css/related-questions.css');	

	}

	
	
} new QuestionAnswerRelatedQuestions();