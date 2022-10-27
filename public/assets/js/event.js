function selected_filter_office(id) {
    $("#" + id).addClass('active');
    var id_before = localStorage.getItem("id_before");
    localStorage.setItem("id_before", id);
    $("#" + id_before).removeClass('active');
    var name = $("#" + id).attr("name")
    $("#title_event_data").text('Data Event ' + name);
}