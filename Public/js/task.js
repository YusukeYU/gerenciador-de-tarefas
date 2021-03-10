$("#dateNewTask").pickadate()
$("#timeNewTask").pickatime({
    format: 'M!arc!ado em H:i',
    formatLabel: 'H:i',
    formatSubmit: 'H:i'
});
$('#imgCalendar').on('click', function (e) {
    e.preventDefault();
    $("#dateNewTask").trigger('click')
})
$('#imgClock').on('click', function (e) {
    e.preventDefault();
    $("#timeNewTask").trigger('click')
})
function changeElement(id) {
    $('.my-loader').css('display', 'flex')
    var elements = ['#tableAllTasks', '#receiveFormNewTask'];
    var element = "#" + id;
    elements.forEach(function (item, indice, array) {
        $(item).hide();
    });
    $(element).show();
    $('.my-loader').hide();
}

$("#saveNewTask").on('click', function (e) {
	e.preventDefault()
	$('.my-loader').css('display', 'flex')
	formData = new FormData($('#formNewTask').get(0))
    console.log(formData)
	fetch(`/task`, {
		method: 'POST',
		body: formData,
	}).then(response => response.json())
		.then(jsonBody => {
			if (jsonBody.status == 'error') {
                 alert(jsonBody.message)
				//$('.span-message').html(jsonBody.message)
			//	$('#h1-criar-conta').hide()
			//	$('.message-error').show()
				$('.my-loader').hide()
			} else {
				window.location.href = "/dashboard"
			}
		})
//	setTimeout(function () {
	//	$('.message-error').hide("slow")
	//	$('#h1-criar-conta').show("slow")
//	}, 2500)
})
