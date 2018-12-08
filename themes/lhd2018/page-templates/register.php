<?php /* Template Name: Register */ ?>

<?php get_header(); ?>

		<?php get_template_part( 'includes/navbar' ); ?>
		
		<div class="container-fluid">
			<div class="row">
				<div class="col s12 m12 l4 offset-l4">
					<div class="space20"></div>
					<img class="responsive-img" src="<?php bloginfo("template_directory"); ?>/img/logolhd.png">
					<div class="space20"></div>
					<form id="formRegister" name="formRegister">
						<div class="row">
							<div class="col s12">
					        	<input placeholder="Correo Electrónico" autocomplete="off" id="email" name="email" type="text" class="validate">
					        </div>
					        <div class="col s12">
					        	<input placeholder="Contraseña" autocomplete="off" id="password" name="password" type="password" class="validate">
					        </div>
						</div>
						<div class="row">
							<div class="centered">
								<button class="btn waves-effect waves-light red darken-4" id="btnSubmit" type="submit" name="action">Registrar
									<i class="material-icons right">send</i>
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
			<div class="row">
				<div class="col s12">
					<div class="centered">
						<a href="<?php bloginfo("url"); ?>" class="waves-effect waves-light btn red darken-4">Iniciar Sesión</a>
					</div>
				</div>
			</div>
			
		</div>

<?php get_footer(); ?>