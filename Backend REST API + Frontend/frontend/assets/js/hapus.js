const id =
document.getElementById('id').value;

document
.getElementById('formDelete')
.addEventListener('submit', function(e){

    e.preventDefault();

    fetch(
        `../backend/delete.php?id=${id}`,
        {
            method:'DELETE'
        }
    )
    .then(response => response.json())
    .then(result => {

        alert(result.message);

        window.location =
        'index.php';

    });

});