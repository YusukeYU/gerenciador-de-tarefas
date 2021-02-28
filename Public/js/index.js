const signUpButton = document.getElementById('signUp');
const signInButton = document.getElementById('signIn');
const container = document.getElementById('container');
const cadastrar = document.getElementById('cadastrar');
//const axios = require('axios');


signUpButton.addEventListener('click', () => {
	container.classList.add("right-panel-active");
});

signInButton.addEventListener('click', () => {
	container.classList.remove("right-panel-active");
});
cadastrar.addEventListener('click', () => {
	var name =  document.getElementById('name_register');
	var email =  document.getElementById('email_register');
	var password =  document.getElementById('password_register');

	fetch(`http://www.task.pontesdev.com.br/`, {
		method: 'POST',
		headers: {
			'Content-Type': 'application/json',
			'Accept': 'application/json'
		},
		body: JSON.stringify({
			name : name,
			email :email,
			password : password
		}),
	})
	.then(response => response.json())
	.then(jsonBody => {
		console.log(jsonBody);
	});
	
});


