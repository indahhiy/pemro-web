const namaInput = document.getElementById('nama');
const sapaBtn = document.getElementById('sapaBtn');
const greetingArea = document.getElementById('greetingArea');

function sapaPengguna() {
    // Ambil nilai dari input, hilangkan spasi di awal/akhir
    let nama = namaInput.value.trim();

    // Validasi jika input kosong
    if (nama === "") {
        greetingArea.innerHTML = `
            <div class="greeting-text">
                ⚠️ <span>Oops!</span> Nama tidak boleh kosong. Silakan isi terlebih dahulu.
            </div>
        `;
        greetingArea.style.borderLeftColor = "#e53e3e";
        return;
    }
    // Jika ada isi, tampilkan sapaan
    greetingArea.innerHTML = `
        <div class="greeting-text">
             Halo selamat datang <span>${escapeHTML(nama)}</span>! Selamat belajar Pemrograman Web. <br>
            Senang berkenalan dengan Anda 
        </div>
    `;
    greetingArea.style.borderLeftColor = "#764ba2";
}
function escapeHTML(str) {
    return str.replace(/[&<>]/g, function(m) {
        if (m === '&') return '&amp;';
        if (m === '<') return '&lt;';
        if (m === '>') return '&gt;';
        return m;
    });
}

// Event listener tombol klik
sapaBtn.addEventListener('click', sapaPengguna);

namaInput.addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
        sapaPengguna();
    }
});
