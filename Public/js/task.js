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


