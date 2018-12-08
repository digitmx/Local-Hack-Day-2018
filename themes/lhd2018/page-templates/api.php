<?php /* Template Name: API */

	//Include PHPMailer
	include_once( getcwd().'/wp-includes/class-phpmailer.php' );
	
	//Read Param Field
	$json = (isset($_POST['param'])) ? $_POST['param'] : NULL; $output = FALSE;
	$json = str_replace('\\', '', $json);

	//Check JSON
	if ($json != NULL)
	{
		//Decode Data JSON
		$json_decode = json_decode($json, true);

		//Read Action JSON
		$msg = (isset($json_decode['msg'])) ? (string)trim($json_decode['msg']) : '';

		//Read Fields JSON
		$fields = (isset($json_decode['fields'])) ? $json_decode['fields'] : array();
		
		//createUser
		if ($msg == 'createUser')
		{
			//Read Data
			$email = (isset($fields['email'])) ? (string)trim($fields['email']) : '';
			$password = (isset($fields['password'])) ? (string)trim($fields['password']) : '';
			
			//Check Values
			if ($email && $password)
			{
				//Query User
				$args = array(
					'post_type' => 'usuario',
					'meta_query' => array(
						array(
							'key' => 'email',
							'value' => $email,
							'compare' => '='
						)
					)
				);
				$query = get_posts($args);
				
				//Check User exists
				if (count($query) == 0)
				{
					//Register User
					$my_post = array(
					  'post_title'    => wp_strip_all_tags($email, true),
					  'post_status'   => 'publish',
					  'post_author'   => 1,
					  'post_type'	  => 'usuario'
					);

					// Save Data
					$post_id = wp_insert_post( $my_post );

					//Verify
					if ($post_id != 0)
					{
						// Save Custom Fields
						if ( ! update_post_meta ($post_id, 'email', $email ) ) add_post_meta( $post_id, 'email', $email );
						if ( ! update_post_meta ($post_id, 'password', sha1($password) ) ) add_post_meta( $post_id, 'password', sha1($password) );
					}
					
					//Create User Session
					$array_user = array(
						'id' => $post_id,
						'email' => get_post_meta($post_id,'email',true)
					);
					
					//Set User Session
					$wp_session['user'] = $array_user;
					$wp_session['logged'] = TRUE;
					
					//Mail Notification
					$subject = 'Bienvenido al Local Hack Day 2018';
					$template = wp_remote_get( esc_url_raw (get_bloginfo('url').'/mail-register/?param01='.$email.'&param02='.$password) );
					$body = $template['body'];
					$altbody = strip_tags($body);

					//Check Email Data
					if ($subject != '' && $body != '' && $altbody != '' && $email != '')
					{
						//Send Email
						add_filter('wp_mail_content_type',create_function('', 'return "text/html"; '));
						$response = wp_mail( $email, $subject, $body );
					}
					
					//Build Response Array
					$array = array(
						'status' => (int)1,
						'msg' => 'success',
						'data' => $array_user
					);

					//Print JSON Array
					printJSON($array);
					$output = TRUE;
				}
				else
				{
					//Show Error
					$array = array(
						'status' => (int)0,
						'msg' => (string)'Este usuario ya está registrado. Inicia Sesión.',
						'data' => array()
					);

					//Print JSON Array
					printJSON($array);
					$output = TRUE;
				}
			}
			else
			{
				//Show Error
				$array = array(
					'status' => (int)0,
					'msg' => (string)'Faltan campos.',
					'data' => array()
				);

				//Print JSON Array
				printJSON($array);
				$output = TRUE;
			}
		}
		
		//doLogin
		if ($msg == 'doLogin')
		{
			//Read Data
			$email = (isset($fields['email'])) ? (string)trim($fields['email']) : '';
			$password = (isset($fields['password'])) ? (string)trim($fields['password']) : '';
			
			//Check Values
			if ($email && $password)
			{
				//Query User
				$args = array(
					'post_type' => 'usuario',
					'meta_query' => array(
						'relation' => 'AND',
						array(
							'key' => 'email',
							'value' => $email,
							'compare' => '='
						)
					)
				);
				$query = new WP_Query( $args );
				
				//Check User exists
				if (count($query->posts) > 0)
				{
					//Read Object
					foreach ($query->posts as $row) { $post_id = $row->ID; }
					
					//Verificamos si el Password coincide
					if (sha1($password) == get_field("password", $post_id))
					{
						//Create User Session
						$array_user = array(
							'id' => $post_id,
							'email' => get_post_meta($post_id,'email',true)
						);
						
						//Set User Session
						$wp_session['user'] = $array_user;
						$wp_session['logged'] = TRUE;
						
						//Build Response Array
						$array = array(
							'status' => (int)1,
							'msg' => 'success',
							'data' => $array_user
						);
	
						//Print JSON Array
						printJSON($array);
						$output = TRUE;
					}
					else
					{
						//Show Error
						$array = array(
							'status' => (int)0,
							'msg' => (string)'La contraseña es incorrecta. Revísala e intenta de nuevo.',
							'data' => array()
						);
		
						//Print JSON Array
						printJSON($array);
						$output = TRUE;
					}
				}
				else
				{
					//Show Error
					$array = array(
						'status' => (int)0,
						'msg' => (string)'El usuario no existe. Crea una cuenta.',
						'data' => array()
					);
	
					//Print JSON Array
					printJSON($array);
					$output = TRUE;
				}
			}
			else
			{
				//Show Error
				$array = array(
					'status' => (int)0,
					'msg' => (string)'Faltan campos.',
					'data' => array()
				);

				//Print JSON Array
				printJSON($array);
				$output = TRUE;
			}
		}
	}
	else
	{
		//Show Error
		$array = array(
			'status' => (int)0,
			'msg' => (string)'API Call Invalid.'
		);

		//Print JSON Array
		printJSON($array);
		$output = TRUE;
	}

	//Check Output
	if (!$output)
	{
		//Show Error
		$array = array(
			'status' => (int)0,
			'msg' => (string)'API Error.'
		);

		//Print JSON Array
		printJSON($array);
		$output = TRUE;
	}
	
?>