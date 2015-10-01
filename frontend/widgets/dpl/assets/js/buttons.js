/**
 * Created by Maxwellt on 01.10.2015.
 */
$("#fromLower").click(function () {
    var selectedItem = $("#note-lowernotes option:selected");
    $("#assocNotes").append(selectedItem);
});

$("#toLower").click(function () {
    var selectedItem = $("#assocNotes option:selected");
    $("#note-lowernotes").append(selectedItem);
});

$("#fromHigher").click(function () {
    var selectedItem = $("#note-highernotes option:selected");
    $("#assocNotes").append(selectedItem);
});

$("#toHigher").click(function () {
    var selectedItem = $("#assocNotes option:selected");
    $("#note-lowernotes").append(selectedItem);
});