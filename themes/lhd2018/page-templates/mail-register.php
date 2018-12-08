<?php /* Template Name: Mail Register */ ?>
<?php setup_postdata($post); ?>
<?php $wp_session= WP_Session::get_instance(); /* SESSION */ ?>
<?php $wp_session['mail_register_email'] = (isset($_GET['param01'])) ? (string)trim($_GET['param01']) : 'milio.hernandez@gmail.com'; ?>
<?php $wp_session['mail_register_password'] = (isset($_GET['param02'])) ? (string)trim($_GET['param02']) : 'admin123'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width"/>
		<link rel="stylesheet" href="<?php bloginfo("stylesheet_directory"); ?>/css/foundation.css">
	</head>

	<body>
		<!-- <style> -->
		<table class="body" data-made-with-foundation>
	    	<tr>
				<td class="float-center" align="center" valign="top">
					<center>
						<table class="container">
							<tr>
						    	<td>
							    	<table class="row">
								    	<thead>
									    	<tr>
												<th class="small-12 large-6 first columns">
													<br />
													<img style="width: 400px; margin: 0 auto;" src="<?php bloginfo("stylesheet_directory"); ?>/img/logohdl.png" alt="Local Hack Day" />
													<br />
												</th>
												<th class="expander"></th>
									    	</tr>
								    	</thead>
								    	<tbody>
											<tr>
												<td class="small-12 large-6 first columns ">
													<?php the_content(); ?>
												</td>
												<td class="expander"></td>
											</tr>
								    	</tbody>
									</table>
						    	</td>
						  	</tr>
						</table>
					</center>
	      		</td>
	    	</tr>
	  	</table>
	</body>

</html>