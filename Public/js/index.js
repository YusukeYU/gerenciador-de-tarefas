const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');
const cadastrar = document.getElementById('cadastrar');

signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});


function signUp() {
	$('.my-loader').css('display','flex');
	var myForm = document.getElementById('form-cadastro');
	formData = new FormData(myForm);
	fetch(`/`, {
		method: 'POST',
		body: formData,
	}).then(response => response.json())
		.then(jsonBody => {
			if (jsonBody.status == 'error') {
				$('.span-message').html(jsonBody.message);
				$('#h1-criar-conta').hide();
				$('.message-error').show();
				$('.my-loader').hide();
			} else {
				window.location.href = "/dashboard";
			}
		});
	setTimeout(function () {
		$('.message-error').hide("slow");
		$('#h1-criar-conta').show("slow");
	}, 2500);
};


