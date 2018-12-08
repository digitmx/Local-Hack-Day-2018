<?php $wp_session= WP_Session::get_instance(); ?>

	<nav>
    	<div class="nav-wrapper red darken-4">
			<a href="#" class="brand-logo">Local Hack Day 2018</a>
			<?php if ($wp_session['logged']) { ?>
			<ul id="nav-mobile" class="right hide-on-med-and-down">
				<li><a href="<?php bloginfo("url"); ?>/logout">Cerrar Sesión</a></li>
    		</ul>
    		<?php } ?>
    	</div>
  	</nav>