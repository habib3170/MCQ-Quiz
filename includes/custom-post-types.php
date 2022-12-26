<?php
/**
 * Custom post types
 */
defined( 'ABSPATH' ) || exit();

function mcq_quiz_post_types_setup() {
    $quiz_labels = array(
        'name'                  => _x( 'Quizzes', 'mcq-quiz' ),
        'singular_name'         => _x( 'Quiz', 'mcq-quiz' ),
        'menu_name'             => _x( 'Quiz', 'mcq-quiz' ),
        'add_new'               => __( 'Add New', 'mcq-quiz' ),
        'add_new_item'          => __( 'Add New Quiz', 'mcq-quiz' ),
        'edit_item'             => __( 'Edit Quiz', 'mcq-quiz' ),
        'update_item'           => __( 'Update Quiz', 'mcq-quiz' ),
        'new_item'              => __( 'New Quiz', 'mcq-quiz' ),
        'all_items'             => __( 'All Quizzes', 'mcq-quiz' ),
        'view_item'             => __( 'View Quiz', 'mcq-quiz' ),
        'view_items'            => __( 'View Quizzes', 'mcq-quiz' ),
        'search_items'          => __( 'Search Quizzes', 'mcq-quiz' ),
        'not_found'             => __( 'No Quizzes found', 'mcq-quiz' ),
        'not_found_in_trash'    => __( 'No Quizzes found in Trash', 'mcq-quiz' ),
        'parent'                => __( 'Parent Quiz', 'mcq-quiz' ),
        'featured_image'        => __( 'Quiz image', 'mcq-quiz' ),
        'set_featured_image'    => __( 'Set Quiz image', 'mcq-quiz' ),
        'remove_featured_image' => __( 'Remove Quiz image', 'mcq-quiz' ),
        'use_featured_image'    => __( 'Use as Quiz image', 'mcq-quiz' ),
    );

    $quiz_args = array(
        'labels'              => $quiz_labels,
        'description'         => __( 'This is where you can add new Quizzes', 'mcq-quiz' ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'menu_icon'           => 'dashicons-list-view',
        'exclude_from_search' => false,
        'menu_position'       => 11,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => false,
        'capability_type'     => 'page',
        'map_meta_cap'        => true,
        'has_archive'         => false,
        'hierarchical'        => false,
        'rewrite'             => array( 'slug' => 'mcq-quizzes', 'with_front' => false ),
        'supports'            => array( 'title' ),
    );
    register_post_type( 'mcq-quiz', apply_filters( 'register_post_type_mcq-quiz', $quiz_args ) );


    /** Register Question Post type */

    $questions_labels = array(
        'name'                  => _x( 'Questions', 'question post type name', 'mcq-quiz' ),
        'singular_name'         => _x( 'Question', 'singular question post type name', 'mcq-quiz' ),
        'menu_name'             => _x( 'Question', 'mcq-quiz' ),
        'add_new'               => __( 'Add New', 'mcq-quiz' ),
        'add_new_item'          => __( 'Add New Question', 'mcq-quiz' ),
        'edit_item'             => __( 'Edit Question', 'mcq-quiz' ),
        'update_item'           => __( 'Update Question', 'mcq-quiz' ),
        'new_item'              => __( 'New Question', 'mcq-quiz' ),
        'all_items'             => __( 'All Question', 'mcq-quiz' ),
        'view_item'             => __( 'View Question', 'mcq-quiz' ),
        'view_items'            => __( 'View Questions', 'mcq-quiz' ),
        'search_items'          => __( 'Search Questions', 'mcq-quiz' ),
        'not_found'             => __( 'No Questions found', 'mcq-quiz' ),
        'not_found_in_trash'    => __( 'No Questions found in Trash', 'mcq-quiz' ),
        'parent'                => __( 'Parent Question', 'mcq-quiz' ),
        'featured_image'        => __( 'Question image', 'mcq-quiz' ),
        'set_featured_image'    => __( 'Set Question image', 'mcq-quiz' ),
        'remove_featured_image' => __( 'Remove Question image', 'mcq-quiz' ),
        'use_featured_image'    => __( 'Use as Question image', 'mcq-quiz' ),
    );

    $questions_args = array(
        'labels'              => $questions_labels,
        'description'         => __( 'This is where you can add new Questions.', 'mcq-quiz' ),
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'query_var'           => true,
        'capability_type'     => 'page',
        'exclude_from_search' => false,
        'menu_position'       => 12,
        'menu_icon'           => 'dashicons-list-view',
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => false,
        'map_meta_cap'        => true,
        'has_archive'         => false,
        'hierarchical'        => false,
        'rewrite'             => array( 'slug' => 'mcq-questions', 'with_front' => false ),
        'supports'            => array( 'title', 'editor' ),
        'show_in_rest'        => false,
    );

    register_post_type( 'mcq-question', apply_filters( 'register_post_type_mcq-question', $questions_args ) );

}
add_action( 'init', 'mcq_quiz_post_types_setup' );