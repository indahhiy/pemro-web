document
.getElementById('formTambah')
.addEventListener('submit', function(e){

    e.preventDefault();

    const formData = {
        nip: document.getElementById('nip').value,
        nama: document.getElementById('nama').value,
        jabatan: document.getElementById('jabatan').value,
        departemen: document.getElementById('departemen').value,
        tanggal_masuk: document.getElementById('tanggal_masuk').value
    };

    console.log('Mengirim data:', formData);

    fetch(
        '../backend/create.php',
        {
            method:'POST',

            headers:{
                'Content-Type':'application/json'
            },

            body:JSON.stringify(formData)
        }
    )
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error('HTTP error, status = ' + response.status);
        }
        return response.json();
    })
    .then(result => {
        console.log('Response dari server:', result);

        if (!result.status) {
            alert('Error: ' + result.message);
            console.log('Errors detail:', result.errors);
            return;
        }

        alert(result.message);
        window.location = 'index.php';

    })
    .catch(error => {
        console.error('Error details:', error);
        alert('Terjadi kesalahan: ' + error.message);
    });

});