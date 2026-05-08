function sapaUser() {
    let nama = document.getElementById("nama").value;

    if (nama === "") {
        document.getElementById("hasil").innerHTML = "⚠️ Nama tidak boleh kosong!";
    } else {
        document.getElementById("hasil").innerHTML =
            "Selamat datang, " + nama + " 😊";
    }
}