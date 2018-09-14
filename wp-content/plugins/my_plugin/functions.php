<?php


class my_class{

	/**
	* show number of tasks that user has chosen
	* @return string
	*/
	public function show_num_tasks($num){
		$args = array(
			'posts_per_page' => $num,
			'post_type' => 'task'
		);
		$tasks = get_posts( $args );
		foreach($tasks as $task){
			echo '<tr class="even">
        		<td>#'.$task->ID.'</td>
           		<td>'.$task->post_title.'</td>
           		<td>'.get_the_title(get_post_meta($task->ID,'freelancer',true)).'</td>
           		<td>'.$task->post_date.'</td>
       		</tr>';
		}
		wp_reset_postdata();
		die;
	}


	/**
	*
	* Admin notice
	*/
	public function notice_not_activated(){
		echo '<div id="message" class="error"><p>Активируйте плагин Coding 	Ninjas Tasks . Он нужен для работы данного плагина.</p></div>';
	}



	/**
	*
	* When activate my_plugin
	*/
	public function myplugin_activate() {
		add_action('admin_notices', array($this,'notice_not_activated'));
		if (!is_plugin_active('cn_php_wp_plugin_for_tasks/coding-ninjas.php')) {
			$this->notice_not_activated();
			die;
		}
	}	



	/*
	*
	* Init scripts
	*/
	public function init_scripts(){
		
		wp_deregister_script( 'jquery' );
		
		wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js');
		
		wp_enqueue_script( 'jquery' );

		wp_enqueue_script( 'main', plugins_url('/my_plugin/js/main.js'),array('jquery'),null,true);
		
		$protocol = isset( $_SERVER['HTTPS'] ) ? 'https://' : 'http://';
		
		$params = array(
    		'ajaxurl' => admin_url( 'admin-ajax.php', $protocol ),
		);
		
		wp_localize_script('main', 'spyr_params', $params );

	}


	/**
	*
	* Register post type freelancers
	*/
	public function register_post_type_freelancers(){
		register_post_type('freelancers', array(
			'labels' => array(
				'name'               => 'Freelancers',
				'singular_name'      => 'Freelancer',
				'add_new'            => 'Add a freelancer',
				'add_new_item'       => 'Add a freelancer',
				'edit_item'          => 'Edit freelancer',
				'new_item'           => 'New freelancer',
				'view_item'          => 'View freelancer',
				'search_items'       => 'Search freelancers',
				'not_found'          => 'No freelancers found',
				'not_found_in_trash' => 'No freelancers found in trash',
				'menu_name'          => 'Freelancers',
			),
			'public'              => true,
			'publicly_queryable'  => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'supports'            => array('title','thumbnail'),
			'rewrite'             => array('slug' => 'freelancer'),
			'query_var'           => true,
		));
	}



	/**
	*
	* Add metabox
	*/
	public function myplugin_add_custom_box(){
		add_meta_box( $id, $title, $callback, $screen, $context, $priority, $callback_args );
		add_meta_box( 'freelancers-div',__('Freelancers'),array($this,'freelancers_metabox'),'task','side','low');
	}


	/**
	*
	* HTML generate for metabox
	*/
	public function freelancers_metabox($post) {
    	$freelancer = get_post_meta($post->ID, 'freelancer', true);    
    	$query = new WP_Query( array( 'post_type'=>'freelancers' ) );
    	?>    
		<select name="freelancer_select" id="">
			<option value="">Choose freelancer on this task</option>
			<?php
			while ( $query->have_posts() ) {
				$query->the_post();
			?>
				<option value="<?php the_id(); ?>" <?php if($freelancer==get_the_ID()){echo 'selected';} ?>><?php the_title(); ?></option>
			<?php		
			}
			?>
		</select>
		<?php
	}



	/**
	*
	* Save data from metabox
	*/
	public function save_freelancer($post_id){
    	if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
        	return $post_id;
    	if ( !current_user_can( 'edit_post', $post_id ) )
        	return $post_id; 
    	$post = get_post($post_id);
    	if ($post->post_type == 'task') { 
    		if(get_post_meta( $post_id, 'freelancer', false )){
    			update_post_meta($post_id, 'freelancer', esc_attr($_POST['freelancer_select']) );
    		}else{
    			add_post_meta( $post_id, 'freelancer', esc_attr($_POST['freelancer_select']));
    		}           
    	}
	}


	
	/**
	*
	* Select freelancer in modal
	*/
	public function freelancers_select(){
		$query = new WP_Query( array( 'post_type'=>'freelancers' ) );
		$data='<select name="freelancer" class="form-control">';
			while ( $query->have_posts() ) {
				$query->the_post();
				$posts = get_posts( array(
					'meta_key'    => 'freelancer',
					'meta_value'  => get_the_ID(),
					'post_type'   => 'task',
				));
				if(count($posts)<=2){
					$data.='<option value="'.get_the_ID().'">'.get_the_title().'</option>';
					$quantity_of_f++;
				}
			}
		if($quantity_of_f==0){
			$data.='<option value="">Нет свободных фрилансеров!</option>';
		}
		$data.='</select>';
		echo $data;
	}



	/**
	*
	* Print modal in footer
	*/
	public function modals(){
		echo '<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	      <div class="modal-dialog" role="document">
	        <div class="modal-content">
	          <div class="modal-header">
	            <h2 class="modal-title" id="exampleModalLabel">Add new task</h2>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	              <span aria-hidden="true">&times;</span>
	            </button>
	          </div>
	          <div class="modal-body">
	            <form id="add_task_form" action="javascript:void(0)">
	                <div class="container-fluid">
	                    <div class="row">
	                        <div class="col-md-5 col-lg-5">
	                            <h4 style="float: right;">Task title</h4>
	                        </div>
	                        <div class="col-lg-5 col-md-5">
	                            <input type="text" name="task_title" class="form-control">
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-lg-5 col-md-5">
	                            <h4 style="float: right;">Freelancer</h4>
	                        </div>
	                        <div class="col-lg-5 col-md-5">';
	                        	$this->freelancers_select();
	                        echo '</div>
	                    </div>
	                    <button type="submit" class="btn btn-primary">Add</button>
	                </form>
	                </div>                
	          </div>        
	        </div>
	      </div>
	    </div>';
	}


	/**
	*
	* Add task from modal
	*/
	public function add_task_modal( $title, $freelancer ){
		$post = array( 
			'post_status'	=> 'publish',
			'post_title'	=> $title,
			'post_type'		=> 'task',
			'meta_input'	=> array(
				'freelancer' => $freelancer
			)     
		);
		echo 'ok';
		wp_insert_post($post,false);
	}



	/**
	*
	* Sort columns
	*/
	public function sort_column( $title,$num,$order ){
		if($title=='ID'){
			$title='id';
		}elseif($title=='Title'){
			$title='title';
		}elseif($title=='Date'){
			$title='date';
		}elseif($title=='Freelancer'){
			$title='freelancer';
		}
		$args = array(
			'posts_per_page' => $num,
			'post_type' => 'task',
			'meta_key'  => 'freelancer',
			'orderby'     => $title,
			'order'       => $order,
		);
		$tasks = get_posts( $args );
		foreach($tasks as $task){
			echo '<tr class="even">
        		<td>#'.$task->ID.'</td>
           		<td>'.$task->post_title.'</td>
           		<td>'.get_the_title(get_post_meta($task->ID,'freelancer',true)).'</td>
           		<td>'.$task->post_date.'</td>
       		</tr>';
		}
		wp_reset_postdata();
		die;
	}


	/**
	*
	* Search
	*/
	public function search($text,$num){
		if(empty($text)){
			$num=-1;
		}
		$args = array(
			'posts_per_page' => $num,
			'post_type' => 'task',
			'meta_key'  => 'freelancer',
			'orderby'     => $title,
			'order'       => $order,
		);
		$tasks = get_posts( $args );
		foreach($tasks as $task){
			$id=$task->ID;
			$title=$task->post_title;
			$freelancer=get_the_title(get_post_meta($task->ID,'freelancer',true));
			$date=$task->post_date;
			if(stristr($id,$text)!==false || stristr($title,$text)!==false || stristr($freelancer,$text)!==false || stristr($date,$text)!==false){
				if(!empty($text)){
					echo '<tr class="even">
		        			<td>#'.$task->ID.'</td>
		           			<td>'.$task->post_title.'</td>
		           			<td>'.get_the_title(get_post_meta($task->ID,'freelancer',true)).'</td>
		           			<td>'.$task->post_date.'</td>
		       			</tr>';
		       	}
       		}
		}
		wp_reset_postdata();
		die;	
	}
}