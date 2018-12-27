$('table').addClass("table-hover");
$('input[type=text]').addClass("form-control");
$('input[type=date]').addClass("form-control");
$('input[type=url]').addClass("form-control");
$('input[type=number]').addClass("form-control");
$('select').addClass("form-control");
$('textarea').addClass("form-control");
$(function() {
    $('[data-toggle="tooltip"]').tooltip();
})
$('.btn-danger').on("click", function(e) {
    e.preventDefault();
    var choice = confirm("¿Estás seguro de eliminar?");
    if (choice) {
        window.location.href = $(this).attr('href');
    }
});
$(".ckeditorTextarea").each(function() {
    CKEDITOR.replace(this, {
        customConfig: 'config.js'
    });
});
$(document).ready(function() {
    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("table tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

function agregar_input(div, name) {
    var cod = 1 + Math.floor(Math.random() * 999999);
    $('#' + div).append('<div class="col-md-3 input-group" id="' + cod + '"><input type="text" class="form-control mb-10 mr-10"  name="' + name + '[]"></div>');
    $('#' + cod).append(' <div class="input-group-addon"><a href="#" onclick="$(\'#' + cod + '\').remove()" class="btn btn-danger"> - </a> </div>');
}