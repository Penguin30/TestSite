<?php
/*
Plugin Name: My plugin for test task
Version: 0.0.1
Author: Yaroslav Stefaniuk
*/

require_once 'functions.php';

$my_class = new my_class;

if(isset($_POST['action'])){
	switch ($_POST['action']) {
		case 'quan':
			$my_class->show_num_tasks($_POST['show_quanity']);
			break;
		case 'add_task':
			$my_class->add_task_modal( $_POST['title'], $_POST['freelancer'] );
			break;
		case 'sort':
			$my_class->sort_column($_POST['title'],$_POST['num'],$_POST['order']);
			break;
		case 'search':
			$my_class->search($_POST['text'],$_POST['num']);
			break;
	}
}

/**
*
* When plugin activates
*/
register_activation_hook( __FILE__, array( $my_class,'myplugin_activate' ));



/**
*
* Register scripts
*/
add_action('wp_enqueue_scripts', array( $my_class,'init_scripts' ));



/**
*
* Register post type
*/
add_action( 'init', array( $my_class,'register_post_type_freelancers' ));



/**
*
* Add metabox
*/
add_action('add_meta_boxes', array( $my_class,'myplugin_add_custom_box' ));



/**
*
* Save data from metabox
*/
add_action( 'save_post', array( $my_class,'save_freelancer' ), 1, 2 );



/**
*
* Print modal in footer
*/
add_action('wp_footer',array( $my_class,'modals' ));
?>