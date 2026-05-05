const input = document.getElementById("namaInput");
const tombol = document.getElementById("btnSapa");
const hasil = document.getElementById("hasil");

tombol.addEventListener("click", function () {
    const nama = input.value.trim();

    if (nama === "") {
        hasil.textContent = "Masukkan nama dulu!";
    } else {
        hasil.textContent = "Halo, " + nama + "!";
    }
});