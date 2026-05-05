function sapaPengguna() {
    let nama = document.getElementById("nama").value;
    let hasil = document.getElementById("hasil");

    if (nama === "") {
        hasil.innerHTML = "Silakan masukkan nama terlebih dahulu!";
    } else {
        hasil.innerHTML = "Halo, " + nama + "! Selamat datang di website kami ";
    }
}