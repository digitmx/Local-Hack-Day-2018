<?php /* Template Name: Dashboard */ ?>

<?php $wp_session= WP_Session::get_instance(); ?>

<?php if ($wp_session['logged']) { ?>

<?php get_header(); ?>

		<?php get_template_part( 'includes/navbar' ); ?>
		
		<div class="container-fluid">
			<div class="row">
				<div class="col s12">
					<pre>
						<?php print_r($wp_session['user']); ?>
					</pre>
				</div>
			</div>
		</div>

<?php get_footer(); ?>

<?php } else { wp_redirect( home_url() ); exit; } ?>