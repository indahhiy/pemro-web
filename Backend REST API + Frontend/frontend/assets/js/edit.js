const id =
document.getElementById('id').value;

/*
=========================
AMBIL DATA
=========================
*/

fetch(
    `../backend/read.php?id=${id}`
)
.then(response => response.json())
.then(result => {

    const data = result.data;

    document.getElementById('nip').value =
    data.nip;

    document.getElementById('nama').value =
    data.nama;

    document.getElementById('jabatan').value =
    data.jabatan;

    document.getElementById('departemen').value =
    data.departemen;

    document.getElementById('tanggal_masuk').value =
    data.tanggal_masuk;

});


/*
=========================
UPDATE DATA
=========================
*/

document
.getElementById('formEdit')
.addEventListener('submit', function(e){

    e.preventDefault();

    fetch(
        `../backend/update.php?id=${id}`,
        {
            method:'PUT',

            headers:{
                'Content-Type':'application/json'
            },

            body:JSON.stringify({

                nip:
                document.getElementById('nip').value,

                nama:
                document.getElementById('nama').value,

                jabatan:
                document.getElementById('jabatan').value,

                departemen:
                document.getElementById('departemen').value,

                tanggal_masuk:
                document.getElementById('tanggal_masuk').value

            })

        }
    )
    .then(response => response.json())
    .then(result => {

        alert(result.message);

        window.location =
        'index.php';

    });

});