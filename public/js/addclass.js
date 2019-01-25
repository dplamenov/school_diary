let addstudents;
$('document').ready(function () {
    addstudents = document.getElementById('addstudents');
});
let counter = 1;

function add() {
    counter++;
    var input = document.createElement('input');
    input.type = "text";
    input.name = "name" + counter;
    input.placeholder = "Full Name";
    console.log(addstudents);
    addstudents.appendChild(input);
}