<?php
	
	/* SESSION */
	ob_start();
    $wp_session= WP_Session::get_instance();
    
    //Remove Enqueue Scripts
	remove_action( 'wp_enqueue_scripts', 'required_load_scripts' );

	if( function_exists('acf_add_options_page') ) {

		acf_add_options_page();

	}

	// Thumbnails Support
	if ( function_exists( 'add_theme_support' ) ) {
	  add_theme_support( 'post-thumbnails' );
	}

	//CHANGE POST MENU LABELS
	function change_post_menu_label() {
	    global $menu;
	    global $submenu;
	    $menu[70][0] = 'Administradores';
	    echo '';
	}
    add_action( 'admin_menu', 'change_post_menu_label' );

	//Change Footer Text
	add_filter( 'admin_footer_text', 'my_footer_text' );
	add_filter( 'update_footer', 'my_footer_version', 11 );
	function my_footer_text() {
	    return '<i>Wordcamp CDMX 2018</i>';
	}
	function my_footer_version() {
	    return 'Version 1.0';
	}

	// Páginas de Configuración
	add_filter('acf/options_page/settings', 'my_options_page_settings');

	function my_options_page_settings ( $options )
	{
		$options['title'] = __('Configuración');
		$options['pages'] = array(
			__('Home'),
			__('Footer')
		);

		return $options;
	}

	/* Definición de Directorios */
	define( 'JSPATH', get_template_directory_uri() . '/js/' );
	define( 'CSSPATH', get_template_directory_uri() . '/css/' );
	define( 'THEMEPATH', get_template_directory_uri() . '/' );
	define( 'IMGPATH', get_template_directory_uri() . '/img/' );
	define( 'SITEURL', site_url('/') );

	/* Enqueue scripts and styles. */
	function scripts() {
		// Load CSS
		wp_enqueue_style( 'fontMaterialDesign', 'https://fonts.googleapis.com/icon?family=Material+Icons' );
		wp_enqueue_style( 'materializecss', CSSPATH . 'materialize.min.css', array(), '1.0.0' );
		wp_enqueue_style( 'styles', THEMEPATH . 'style.css', array(), '1.0.9' );
		
		// Load JS
		wp_deregister_script('jquery');
		wp_enqueue_script('jquery', JSPATH . 'jquery-3.3.1.min.js', array(), '3.3.1', false );
		wp_enqueue_script( 'materializecss', JSPATH . 'materialize.min.js', array('jquery'), '1.0.0', false );
		wp_enqueue_script('jquery-validate', JSPATH . 'validation/jquery.validate.min.js', array('jquery'), '1.17.0', false );
		wp_enqueue_script('jquery-validate-additional-methods', JSPATH . 'validation/additional-methods.min.js', array('jquery-validate'), '1.17.0', false );
		wp_enqueue_script('jquery-validate-localization', JSPATH . 'validation/localization/messages_es.min.js', array('jquery-validate-additional-methods'), '3.3.1', false );
		wp_enqueue_script('functions', JSPATH . 'functions.js', array('jquery-validate-localization'), '1.0.12', false );
	}
	add_action( 'wp_enqueue_scripts', 'scripts' );

	//CUSTOM POST TYPES
	add_action( 'init', 'codex_custom_init' );
	function codex_custom_init() {
		
		//Usuarios
		$labels = array(
		    'name' => _x('Usuarios', 'post type general name'),
		    'singular_name' => _x('Usuario', 'post type singular name'),
		    'add_new' => _x('Agregar Nuevo', 'usuario'),
		    'add_new_item' => __('Agregar Nuevo Usuario'),
		    'edit_item' => __('Editar Usuario'),
		    'new_item' => __('Nuevo Usuario'),
		    'all_items' => __('Todos los Usuarios'),
		    'view_item' => __('Ver Usuario'),
		    'search_items' => __('Buscar Usuarios'),
		    'not_found' =>  __('No encontrado'),
		    'not_found_in_trash' => __('No encontrado en Papelera'),
		    'parent_item_colon' => '',
		    'menu_name' => 'Usuarios'
		);
		$args = array(
		    'labels' => $labels,
		    'public' => true,
		    'publicly_queryable' => true,
		    'show_ui' => true,
		    'show_in_menu' => true,
		    'query_var' => true,
		    'rewrite' => true,
		    'capability_type' => 'post',
		    'has_archive' => true,
		    'hierarchical' => false,
		    'menu_position' => 4,
		    'menu_icon' => 'dashicons-admin-users',
		    'supports' => array( 'title', 'custom-fields' )
		);
		register_post_type('usuario',$args);
	}

	//Funcion para identar JSON
	function indent($json)
	{
	    $result      = '';
	    $pos         = 0;
	    $strLen      = strlen($json);
	    $indentStr   = '  ';
	    $newLine     = "\n";
	    $prevChar    = '';
	    $outOfQuotes = true;

	    for ($i=0; $i<=$strLen; $i++) {

	        // Grab the next character in the string.
	        $char = substr($json, $i, 1);

	        // Are we inside a quoted string?
	        if ($char == '"' && $prevChar != '\\') {
	            $outOfQuotes = !$outOfQuotes;

	        // If this character is the end of an element,
	        // output a new line and indent the next line.
	        } else if(($char == '}' || $char == ']') && $outOfQuotes) {
	            $result .= $newLine;
	            $pos --;
	            for ($j=0; $j<$pos; $j++) {
	                $result .= $indentStr;
	            }
	        }

	        // Add the character to the result string.
	        $result .= $char;

	        // If the last character was the beginning of an element,
	        // output a new line and indent the next line.
	        if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
	            $result .= $newLine;
	            if ($char == '{' || $char == '[') {
	                $pos ++;
	            }

	            for ($j = 0; $j < $pos; $j++) {
	                $result .= $indentStr;
	            }
	        }

	        $prevChar = $char;
	    }

	    return $result;
	}

	function printJSON($array)
	{
		$json = json_encode($array);
		header('Content-Type: application/json',true);
		echo indent($json);
	}

	//SUBIR IMAGEN A CAMPO IMG DE ACF
	function my_update_attachment($f,$pid,$t='',$c='') {
	  	wp_update_attachment_metadata( $pid, $f );
	  	if( !empty( $_FILES[$f]['name'] )) { //New upload
	    	require_once( ABSPATH . 'wp-admin/includes/file.php' );
			include( ABSPATH . 'wp-admin/includes/image.php' );
			// $override['action'] = 'editpost';
			$override['test_form'] = false;
			$file = wp_handle_upload( $_FILES[$f], $override );

			if ( isset( $file['error'] )) {
				return new WP_Error( 'upload_error', $file['error'] );
	    	}

			$file_type = wp_check_filetype($_FILES[$f]['name'], array(
				'jpg|jpeg' => 'image/jpeg',
				'gif' => 'image/gif',
				'png' => 'image/png',
			));

			if ($file_type['type']) {
				$name_parts = pathinfo( $file['file'] );
				$name = $file['filename'];
				$type = $file['type'];
				$title = $t ? $t : $name;
				$content = $c;

				$attachment = array(
					'post_title' => $title,
					'post_type' => 'attachment',
					'post_content' => $content,
					'post_parent' => $pid,
					'post_mime_type' => $type,
					'guid' => $file['url'],
				);

				foreach( get_intermediate_image_sizes() as $s ) {
					$sizes[$s] = array( 'width' => '', 'height' => '', 'crop' => true );
					$sizes[$s]['width'] = get_option( "{$s}_size_w" ); // For default sizes set in options
					$sizes[$s]['height'] = get_option( "{$s}_size_h" ); // For default sizes set in options
					$sizes[$s]['crop'] = get_option( "{$s}_crop" ); // For default sizes set in options
	      		}

		  		$sizes = apply_filters( 'intermediate_image_sizes_advanced', $sizes );

		  		foreach( $sizes as $size => $size_data ) {
		  			$resized = image_make_intermediate_size( $file['file'], $size_data['width'], $size_data['height'], $size_data['crop'] );
		  			if ( $resized )
		  				$metadata['sizes'][$size] = $resized;
	      		}

		  		$attach_id = wp_insert_attachment( $attachment, $file['file'] /*, $pid - for post_thumbnails*/);

		  		if ( !is_wp_error( $attach_id )) {
		  			$attach_meta = wp_generate_attachment_metadata( $attach_id, $file['file'] );
		  			wp_update_attachment_metadata( $attach_id, $attach_meta );
	      		}

		  		return array(
		  			'pid' =>$pid,
		  			'url' =>$file['url'],
		  			'file'=>$file,
		  			'attach_id'=>$attach_id
		  		);
	    	}
	  	}
	}
	
	//Function to Replace Variables
	function replace_content($content)
	{
		$wp_session= WP_Session::get_instance();
	
		//WELCOME USER
		if ($wp_session['mail_register_email']) { $content = str_replace('@email@', $wp_session['mail_register_email'], $content); unset($wp_session['mail_register_email']); }
		if ($wp_session['mail_register_password']) { $content = str_replace('@password@', $wp_session['mail_register_password'], $content); unset($wp_session['mail_register_password']); }
	
		return $content;
	}
	add_filter('the_content','replace_content');

?>