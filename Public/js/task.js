$("#dateNewTask").pickadate()
$("#timeNewTask").pickatime({
	format: 'M!arc!ado em H:i',
	formatLabel: 'H:i',
	formatSubmit: 'H:i'
});

this.getResults()

$('#imgCalendar').on('click', function (e) {
	e.preventDefault()
	$("#dateNewTask").trigger('click')
})
$('#imgClock').on('click', function (e) {
	e.preventDefault()
	$("#timeNewTask").trigger('click')
})

$('#menu-mobile-img').on('click',function(e){
	e.preventDefault();
	if($('.navbar').css('display')== 'none'){
		$('.navbar').show('slow');
	} else {
		$('.navbar').hide('slow');
	}
})
function changeElement(id) {
	$('.my-loader').css('display', 'flex')
	var elements = ['#tableAllTasks', '#receiveFormNewTask'];
	var element = "#" + id;
	elements.forEach(function (item, indice, array) {
		$(item).hide();
	});
	$(element).show();
	if(!($('#menu-mobile-img').css('display') == 'none')){
		$('#menu-mobile-img').trigger('click');
	}
	$('.my-loader').hide();
}

function clearInputs(){
	$('#dateNewTask').val('')
	$('#timeNewTask').val('')
	$('#inputTitleNewTask').val('')
	$('#desNewTask').val('')
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
				$('.span-message').html(jsonBody.message)
				$('.message-error').show()
				$('.my-loader').hide()
				$('#saveNewTask').hide()
				$('#cancelNewTask').hide()
				setTimeout(function () {
					$('.message-error').hide("slow")
					$('#saveNewTask').show("slow")
				$('#cancelNewTask').show("slow")
				}, 2000)
			} else {
				$('.my-loader').hide();
				changeElement('tableAllTasks')
				getResults()
				clearInputs()
			}
		})
})
function getResults() {
	$('.my-loader').css('display', 'flex')

	fetch(`/task`, {
		method: 'GET',
	}).then(response => response.json())
		.then(jsonBody => {
			$('.my-loader').hide()
			var div = $(".table"); 	
			$( ".line-table" ).remove();
			$.each(jsonBody.data[0], function (idx, elem) {
				div.append(
					"<div class ='row line-table'>" + "<div class ='cell' data-title='Protocolo'>" + elem.id +
					"</div> <div class ='cell' data-title='Título'>" + elem.title +
					"</div> <div class ='cell'>" + elem.date + "</div>"+ "<div class = cell> <a onClick='deleteTask("+elem.id+")'><img class='img-table' src='../../Public/Assets/trash.png'> </a> </div>" +" </div>");
			});
		})
}


function deleteTask(id){
	$('.my-loader').css('display', 'flex')
	formData = new FormData()
	//id = toString(id)
	formData.append('id', id);
	fetch(`/task/delete`, {
		method: 'POST',
		body: formData,
	}).then(response => response.json())
	.then(jsonBody => {
		if (jsonBody.status == 'error') {
			alert(jsonBody.message)
			$('.my-loader').hide()
		} else {
			$('.my-loader').hide()
			getResults()
		}
	})
}