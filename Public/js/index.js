//Animation signIn and SignUp
$("#signUp").on('click', function (e) {
	$("#container").addClass("right-panel-active")
})
$("#signIn").on('click', function (e) {
	$("#container").removeClass("right-panel-active")
})


// Login function starts
$("#btn-login").on('click', function (e) {
	e.preventDefault()
	$('.my-loader').css('display', 'flex')
	formData = new FormData($('#form-login').get(0))
	fetch(`/login`, {
		method: 'POST',
		body: formData,
	}).then(response => response.json())
		.then(jsonBody => {
			if (jsonBody.status == 'error') {
				$('.span-message').html(jsonBody.message)
				$('#h1-criar-conta').hide()
				$('.message-error').show()
				$('.my-loader').hide()
			} else {
				window.location.href = "/dashboard"
			}
		})
	setTimeout(function () {
		$('.message-error').hide("slow")
		$('#h1-criar-conta').show("slow")
	}, 2500)
})
// End login function

// Sign Up function starts
$("#cadastrar").on('click', function (e) {
	e.preventDefault()
	$('.my-loader').css('display', 'flex')
	formData = new FormData($('#form-cadastro').get(0))
	fetch(`/`, {
		method: 'POST',
		body: formData,
	}).then(response => response.json())
		.then(jsonBody => {
			if (jsonBody.status == 'error') {
				$('.span-message').html(jsonBody.message)
				$('#h1-criar-conta').hide()
				$('.message-error').show()
				$('.my-loader').hide()
			} else {
				window.location.href = "/dashboard"
			}
		})
	setTimeout(function () {
		$('.message-error').hide("slow")
		$('#h1-criar-conta').show("slow")
	}, 2500)
})
	// End Sign Up function