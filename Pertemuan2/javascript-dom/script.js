const formSapa = document.getElementById("formSapa");
const namaUser = document.getElementById("namaUser");
const sapaan = document.getElementById("sapaan");
const pesan = document.getElementById("pesan");


// style untuk validasi 
pesan.style.display = "block";
pesan.style.textAlign = "left";
pesan.style.marginBottom = "15px";
pesan.style.color = "red";
pesan.style.fontSize = "13px";


namaUser.addEventListener("keypress", function(event) {
    // validasi tidak boleh memasukkan angka
    if (event.key >= 0 && event.key <= 9) {
        event.preventDefault();
        pesan.innerHTML = "Angka tidak boleh dimasukkan";
        return;
    }

    // validasi max 20 karakter
    if (namaUser.value.length >= 20) {
        event.preventDefault();
        pesan.innerHTML = "Maksimal 20 karakter";
        return;
    }

    // hilangkan pesan jika normal
    pesan.innerHTML = "";

});


// untuk submit
formSapa.addEventListener("submit", function(event) {
    event.preventDefault();
    const nama = namaUser.value.trim();
    if (nama === "") {
        pesan.innerHTML = "Nama tidak boleh kosong!";
        return;
    }
    pesan.innerHTML = "";
    sapaan.innerHTML = "Halo, " + nama + " 👋";
});
