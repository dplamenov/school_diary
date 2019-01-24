$('document').ready(function () {

});
let counter = 1;

function add() {
    counter++;
    let addstudents = document.getElementById('addstudents');
    console.log(addstudents);
    var input = '<br><input type="text" name="name' + counter + '" placeholder="Full Name"/>';
    addstudents.innerHTML += input;
}