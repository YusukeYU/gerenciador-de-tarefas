$("#dateNewTask").pickadate()
$("#timeNewTask").pickatime({
	format: 'M!arc!ado em H:i',
	formatLabel: 'H:i',
	formatSubmit: 'H:i'
});
this.getResults()
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
				$('.my-loader').hide()
			} else {
				window.location.href = "/dashboard"
			}
		})
})

function getResults() {
	$('.my-loader').css('display', 'flex')

	fetch(`/task`, {
		method: 'GET',
	}).then(response => response.json())
		.then(jsonBody => {
			console.log(jsonBody.data[0])
			$('.my-loader').hide()
			var div = $(".table");
			$.each(jsonBody.data[0], function (idx, elem) {
				div.append(
					"<div class ='row'>" + "<div class ='cell' data-title='Protocolo'>" + elem.id +
					"</div> <div class ='cell' data-title='Título'>" + elem.title +
					"</div> <div class ='cell'>" + elem.date + "</div> </div>");
			});
		})
}

$("#saveNewTask").on('click', function (e) {
	e.preventDefault()
	$('.my-loader').css('display', 'flex')
	formData = new FormData($('#formNewTask').get(0))
	fetch(`/task`, {
		method: 'POST',
		body: formData,
	}).then(response => response.json())
		.then(jsonBody => {
			if (jsonBody.status == 'error') {
				alert(jsonBody.message)
				$('.my-loader').hide()
			} else {
				window.location.href = "/dashboard"
			}
		})
})