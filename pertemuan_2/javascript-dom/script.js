const formSapa = document.getElementById("formSapa");
const namaUser = document.getElementById("namaUser");
const sapaan = document.getElementById("sapaan");

formSapa.addEventListener("submit", function(event) {

    event.preventDefault();

    const nama = namaUser.value;

    if (nama === "") {

        sapaan.innerHTML = "Nama tidak boleh kosong!";

    } else {

        sapaan.innerHTML = "<marquee>Halo, " + nama + " 😋 </marquee>";

    }

});
