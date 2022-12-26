<?php
/**
 * Plugin Name: MCQ Quiz
 * Plugin URI:  https://www.facebook.com/habib285
 * Description: MCQ Quiz Plugin is an online tool to make visual quiz
 * Version:     1.0.0
 * Author:      Habib Ullah
 * Author URI:  https://www.facebook.com/habib285
 * Donate link: https://www.facebook.com/habib285
 * License:     GPLv2+
 * Text Domain: mcq-quiz
 * Domain Path: languages/
 */


// don't call the file directly
defined( 'ABSPATH' ) || exit();

/**
 * Main McqQuiz Class
 *
 * @class McqQuiz
 */
final class McqQuiz {
    /**
     * @var string
     */
    protected $version = "1.0.0";

    /**
     * The single instance of the class.
     *
     * @since 1.0.0
     *
     * @var $this
     */
    protected static $instance = null;

    /**
     * @return Quiz|null
     * @since 1.0.0
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Cloning is forbidden.
     *
     * @since 1.0.0
     */
    public function __clone() {
        _doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'mcq-quiz' ), '1.0.0' );
    }

    /**
     * Universalizing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup() {
        _doing_it_wrong( __FUNCTION__, __( 'Universalizing instances of this class is forbidden.', 'mcq-quiz' ), '1.0.0' );
    }

    /**
     * McqQuiz constructor.
     */
    public function __construct() {
        $this->define_constants();
        $this->includes();
        $this->init_hooks();

    }
    /**
     * Define McqQuiz Constants.
     *
     * @return void
     * @since 1.0.0
     */
    private function define_constants() {
        define( 'MCQ_VERSION', $this->version );
        define( 'MCQ_FILE', __FILE__ );
        define( 'MCQ_PATH', dirname( MCQ_FILE ) );
        define( 'MCQ_INCLUDES', MCQ_PATH . '/includes' );
        define( 'MCQ_URL', plugins_url( '', MCQ_FILE ) );
        define( 'MCQ_VIEWS', MCQ_PATH . '/views' );
        define( 'MCQ_ASSETS_URL', MCQ_URL . '/assets' );
    }

    /**
     * Include all required files
     *
     * since 1.0.0
     *
     * @return void
     */
    public function includes() {
        include_once MCQ_INCLUDES . '/custom-post-types.php';
        include_once MCQ_INCLUDES . '/class-custom-metabox.php';
        include_once MCQ_INCLUDES . '/class-shortcode.php';

    }

    /**
     * Hook into actions and filters.
     *
     * @since 1.0.0
     */
    public function init_hooks() {
        add_action( 'init', array( $this, 'localization_setup' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'add_admin_styles_scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'add_frontend_styles_scripts' ) );
    }

    /**
     * Initialize plugin for localization
     *
     * @return void
     * @since 1.0.0
     *
     */
    public function localization_setup() {
        load_plugin_textdomain( 'mcq-quiz', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Add admin scripts and styles.
     */
    public function add_admin_styles_scripts() {
        wp_enqueue_style( 'select2css', '//cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.css', false, MCQ_VERSION, 'all' );
        wp_enqueue_script( 'select2', '//cdnjs.cloudflare.com/ajax/libs/select2/3.4.8/select2.js', array( 'jquery' ), MCQ_VERSION, true );
        wp_enqueue_style( 'mcq-admin-style', MCQ_ASSETS_URL . '/css/admin.css', false, MCQ_VERSION, 'all' );
        wp_enqueue_script( 'mcq-admin-scripts', MCQ_ASSETS_URL . '/js/admin.js', array( 'jquery' ), MCQ_VERSION, true );
    }

    /**
     * Add frontend scripts and styles.
     */
    public function add_frontend_styles_scripts() {
        wp_enqueue_script( 'mcq-frontend-scripts', MCQ_ASSETS_URL . '/js/scripts.js', array( 'jquery' ), MCQ_VERSION, true );
        wp_localize_script( 'mcq-frontend-scripts', 'mcq_quiz_submission',
            array(
                'ajax_url' => admin_url( 'admin-ajax.php' )
            )
        );
    }
}

/**
 * @return mcqQuiz
 */
function mcqQuiz() {
    return McqQuiz::instance();
}

//fire off the plugin
mcqQuiz();