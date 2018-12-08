
	$( document ).ready(function() {
    	
    	//Leer Valores
		var base_url = $('#base_url').val();
		
		//Materialize Init
		M.AutoInit();
	
    	//Validate Form
    	$("#formRegister").validate({
			rules: {
		    	email: {
					required: true,
					email: true
		   		},
		   		password: {
			   		required: true
		   		}
			}
		});

    	//btnSubmit Click
    	$('#btnSubmit').on('click', function(e) {
	    	e.preventDefault();
	    	
	    	if ($("#formRegister").valid())
	    	{
		    	//Leemos los Datos
		    	var email = $.trim($('#email').val());
				var password = $.trim($('#password').val());
		
		    	//Creamos la llamada
				var param = '{"msg": "createUser","fields": {"email": "' + email + '", "password": "' + password + '"}}';
				
				//Verificamos el Correo Electrónico
				$('#btnSubmit').prop( 'disabled', true );
				$('#btnSubmit').text('PROCESANDO...');

				//API Call
				$.post(base_url + '/api', { param: param }).done(function( data ) {
					console.log(data);
					
					//Check Status Call
					if (data.status == 1)
					{
						//Redirect to Gracias
						window.location.href = base_url + '/dashboard';
					}
					else
					{
						//Show Error
						var instance = new M.Toast({html:data.msg});

						//Enable Button
						$('#btnSubmit').prop( 'disabled', false );
		                $('#btnSubmit').html('ENVIAR');
					}
				});
				
				return false;
	    	}
	    	
	    	return false;
    	});
    	
    	//Validate Form
    	$("#formLogin").validate({
			rules: {
		    	email: {
					required: true,
					email: true
		   		},
		   		password: {
			   		required: true
		   		}
			}
		});

    	//btnSubmit Click
    	$('#btnLoginSubmit').on('click', function(e) {
	    	e.preventDefault();
	    	
	    	if ($("#formLogin").valid())
	    	{
		    	//Leemos los Datos
		    	var email = $.trim($('#email').val());
				var password = $.trim($('#password').val());
		
		    	//Creamos la llamada
				var param = '{"msg": "doLogin","fields": {"email": "' + email + '", "password": "' + password + '"}}';
				
				//Verificamos el Correo Electrónico
				$('#btnSubmit').prop( 'disabled', true );
				$('#btnSubmit').text('PROCESANDO...');

				//API Call
				$.post(base_url + '/api', { param: param }).done(function( data ) {
					console.log(data);
					
					//Check Status Call
					if (data.status == 1)
					{
						//Redirect to Gracias
						window.location.href = base_url + '/dashboard';
					}
					else
					{
						//Show Error
						var instance = new M.Toast({html:data.msg});

						//Enable Button
						$('#btnSubmit').prop( 'disabled', false );
		                $('#btnSubmit').html('ENVIAR');
					}
				});
				
				return false;
	    	}
	    	
	    	return false;
    	});
    	
	});