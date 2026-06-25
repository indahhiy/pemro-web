import { useEffect, useState } from "react";
import axios from "axios";
import "./App.css";

const API_URL = "http://localhost:5000/api/sewa-alat";

const dataAwal = {
  nama_penyewa: "",
  no_hp: "",
  nama_alat: "",
  kategori_alat: "",
  jumlah_sewa: "",
  harga_per_hari: "",
  lama_sewa: "",
  tanggal_sewa: "",
  tanggal_kembali: "",
  status_sewa: "Dipinjam",
};

function App() {
  const [dataSewa, setDataSewa] = useState([]);
  const [formData, setFormData] = useState(dataAwal);
  const [idEdit, setIdEdit] = useState(null);

  const [search, setSearch] = useState("");
  const [searchInput, setSearchInput] = useState("");

  const [page, setPage] = useState(1);
  const [pagination, setPagination] = useState({
    page: 1,
    limit: 5,
    total: 0,
    total_pages: 1,
  });

  const [loading, setLoading] = useState(false);
  const [pesan, setPesan] = useState("");

  // Mengambil data dari backend
  const getDataSewa = async () => {
    try {
      setLoading(true);

      const response = await axios.get(API_URL, {
        params: {
          page: page,
          limit: 5,
          search: search,
        },
      });

      setDataSewa(response.data.data);
      setPagination(response.data.pagination);
    } catch (error) {
      console.log(error);
      setPesan("Gagal mengambil data dari backend.");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    getDataSewa();
  }, [page, search]);

  // Saat input form berubah
  const handleChange = (e) => {
    const { name, value } = e.target;

    setFormData({
      ...formData,
      [name]: value,
    });
  };

  // Tambah atau edit data
  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      if (idEdit) {
        await axios.put(`${API_URL}/${idEdit}`, formData);
        setPesan("Data sewa alat berhasil diubah.");
      } else {
        await axios.post(API_URL, formData);
        setPesan("Data sewa alat berhasil ditambahkan.");
      }

      setFormData(dataAwal);
      setIdEdit(null);
      setPage(1);
      getDataSewa();
    } catch (error) {
      console.log(error);

      if (error.response?.data?.message) {
        setPesan(error.response.data.message);
      } else {
        setPesan("Terjadi kesalahan saat menyimpan data.");
      }
    }
  };

  // Menampilkan data ke form edit
  const handleEdit = (item) => {
    setIdEdit(item.id);

    setFormData({
      nama_penyewa: item.nama_penyewa,
      no_hp: item.no_hp,
      nama_alat: item.nama_alat,
      kategori_alat: item.kategori_alat,
      jumlah_sewa: item.jumlah_sewa,
      harga_per_hari: item.harga_per_hari,
      lama_sewa: item.lama_sewa,
      tanggal_sewa: item.tanggal_sewa?.substring(0, 10),
      tanggal_kembali: item.tanggal_kembali?.substring(0, 10),
      status_sewa: item.status_sewa,
    });

    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  };

  // Menghapus data
  const handleHapus = async (id) => {
    const yakin = window.confirm("Apakah Anda yakin ingin menghapus data ini?");

    if (!yakin) return;

    try {
      await axios.delete(`${API_URL}/${id}`);
      setPesan("Data sewa alat berhasil dihapus.");

      if (dataSewa.length === 1 && page > 1) {
        setPage(page - 1);
      } else {
        getDataSewa();
      }
    } catch (error) {
      console.log(error);
      setPesan("Gagal menghapus data.");
    }
  };

  // Membatalkan edit
  const batalEdit = () => {
    setIdEdit(null);
    setFormData(dataAwal);
    setPesan("");
  };

  // Menjalankan search
  const handleSearch = (e) => {
    e.preventDefault();
    setPage(1);
    setSearch(searchInput);
  };

  // Format rupiah
  const formatRupiah = (angka) => {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(angka || 0);
  };

  return (
    <div className="container">
      <header>
        <h1>🏕️ Sistem Sewa Alat Pendakian</h1>
        <p>Manajemen data penyewaan alat pendakian</p>
      </header>

      {pesan && <div className="pesan">{pesan}</div>}

      <section className="card">
        <h2>{idEdit ? "Edit Data Sewa" : "Tambah Data Sewa"}</h2>

        <form onSubmit={handleSubmit}>
          <div className="form-grid">
            <div>
              <label>Nama Penyewa</label>
              <input
                type="text"
                name="nama_penyewa"
                value={formData.nama_penyewa}
                onChange={handleChange}
                placeholder="Masukkan nama penyewa"
              />
            </div>

            <div>
              <label>Nomor HP</label>
              <input
                type="text"
                name="no_hp"
                value={formData.no_hp}
                onChange={handleChange}
                placeholder="Contoh: 081234567890"
              />
            </div>

            <div>
              <label>Nama Alat</label>
              <input
                type="text"
                name="nama_alat"
                value={formData.nama_alat}
                onChange={handleChange}
                placeholder="Contoh: Tenda Kapasitas 4 Orang"
              />
            </div>

            <div>
              <label>Kategori Alat</label>
              <select
                name="kategori_alat"
                value={formData.kategori_alat}
                onChange={handleChange}
              >
                <option value="">-- Pilih Kategori --</option>
                <option value="Tenda">Tenda</option>
                <option value="Tas Carrier">Tas Carrier</option>
                <option value="Sleeping Bag">Sleeping Bag</option>
                <option value="Jaket">Jaket</option>
                <option value="Kompor">Kompor</option>
                <option value="Sepatu">Sepatu</option>
                <option value="Lainnya">Lainnya</option>
              </select>
            </div>

            <div>
              <label>Jumlah Sewa</label>
              <input
                type="number"
                name="jumlah_sewa"
                value={formData.jumlah_sewa}
                onChange={handleChange}
                min="1"
              />
            </div>

            <div>
              <label>Harga per Hari</label>
              <input
                type="number"
                name="harga_per_hari"
                value={formData.harga_per_hari}
                onChange={handleChange}
                min="1"
                placeholder="Contoh: 50000"
              />
            </div>

            <div>
              <label>Lama Sewa (hari)</label>
              <input
                type="number"
                name="lama_sewa"
                value={formData.lama_sewa}
                onChange={handleChange}
                min="1"
              />
            </div>

            <div>
              <label>Status Sewa</label>
              <select
                name="status_sewa"
                value={formData.status_sewa}
                onChange={handleChange}
              >
                <option value="Dipinjam">Dipinjam</option>
                <option value="Dikembalikan">Dikembalikan</option>
                <option value="Terlambat">Terlambat</option>
              </select>
            </div>

            <div>
              <label>Tanggal Sewa</label>
              <input
                type="date"
                name="tanggal_sewa"
                value={formData.tanggal_sewa}
                onChange={handleChange}
              />
            </div>

            <div>
              <label>Tanggal Kembali</label>
              <input
                type="date"
                name="tanggal_kembali"
                value={formData.tanggal_kembali}
                onChange={handleChange}
              />
            </div>
          </div>

          <div className="form-button">
            <button type="submit">
              {idEdit ? "Simpan Perubahan" : "Tambah Data"}
            </button>

            {idEdit && (
              <button type="button" className="btn-batal" onClick={batalEdit}>
                Batal
              </button>
            )}
          </div>
        </form>
      </section>

      <section className="card">
        <div className="table-header">
          <div>
            <h2>Data Sewa Alat</h2>
            <p>Total data: {pagination.total}</p>
          </div>

          <form className="search-form" onSubmit={handleSearch}>
            <input
              type="text"
              value={searchInput}
              onChange={(e) => setSearchInput(e.target.value)}
              placeholder="Cari penyewa atau alat..."
            />
            <button type="submit">Cari</button>
          </form>
        </div>

        {loading ? (
          <p className="loading">Memuat data...</p>
        ) : (
          <div className="table-wrapper">
            <table>
              <thead>
                <tr>
                  <th>No</th>
                  <th>Penyewa</th>
                  <th>No. HP</th>
                  <th>Alat</th>
                  <th>Kategori</th>
                  <th>Jumlah</th>
                  <th>Harga/Hari</th>
                  <th>Lama</th>
                  <th>Total Harga</th>
                  <th>Tanggal Sewa</th>
                  <th>Tanggal Kembali</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>

              <tbody>
                {dataSewa.length > 0 ? (
                  dataSewa.map((item, index) => (
                    <tr key={item.id}>
                      <td>{(page - 1) * pagination.limit + index + 1}</td>
                      <td>{item.nama_penyewa}</td>
                      <td>{item.no_hp}</td>
                      <td>{item.nama_alat}</td>
                      <td>{item.kategori_alat}</td>
                      <td>{item.jumlah_sewa}</td>
                      <td>{formatRupiah(item.harga_per_hari)}</td>
                      <td>{item.lama_sewa} hari</td>
                      <td>{formatRupiah(item.total_harga)}</td>
                      <td>{item.tanggal_sewa?.substring(0, 10)}</td>
                      <td>{item.tanggal_kembali?.substring(0, 10)}</td>
                      <td>
                        <span
                          className={`status ${item.status_sewa
                            .toLowerCase()
                            .replace(" ", "-")}`}
                        >
                          {item.status_sewa}
                        </span>
                      </td>
                      <td className="aksi">
                        <button
                          className="btn-edit"
                          onClick={() => handleEdit(item)}
                        >
                          Edit
                        </button>

                        <button
                          className="btn-hapus"
                          onClick={() => handleHapus(item.id)}
                        >
                          Hapus
                        </button>
                      </td>
                    </tr>
                  ))
                ) : (
                  <tr>
                    <td colSpan="13" className="data-kosong">
                      Data sewa alat belum tersedia.
                    </td>
                  </tr>
                )}
              </tbody>
            </table>
          </div>
        )}

        <div className="pagination">
          <button
            onClick={() => setPage(page - 1)}
            disabled={page === 1}
          >
            Sebelumnya
          </button>

          <span>
            Halaman {pagination.page} dari {pagination.total_pages || 1}
          </span>

          <button
            onClick={() => setPage(page + 1)}
            disabled={page >= pagination.total_pages}
          >
            Selanjutnya
          </button>
        </div>
      </section>
    </div>
  );
}

export default App;