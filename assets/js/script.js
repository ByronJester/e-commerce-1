$(document).ready(function() {

	
	$('#view-register').on('click', function(){

		$('#login-view').hide();
		$('#register-view').show();

	});

	$('#view-login').on('click', function(){

		$('#login-view').show();
		$('#register-view').hide();

	});

	$('#login-form').on('submit', function(e){

		e.preventDefault();

		var data = $("#login-form").serialize();

		$.ajax({

			type: "POST",
			dataType: "JSON",
			url: base_url + 'auth/login',
			data: data,

			success: function(data){

				
				if (data['reply']==1){
					window.location.href ='home';
				}else{
					$('#error_msg').html(data['reply']);
				}
			}


		});

	});

})