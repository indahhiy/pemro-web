import { useEffect, useState } from "react";
import axios from "axios";

const API = "http://127.0.0.1:8000/api/cats";

const emptyForm = {
  nama: "",
  ras: "",
  warna: "",
  umur: "",
  jenis_kelamin: "Jantan",
  berat: "",
  status_vaksin: "Sudah",
};

export default function App() {
  const [cats, setCats] = useState([]);
  const [meta, setMeta] = useState({});
  const [loading, setLoading] = useState(false);

  const [page, setPage] = useState(1);
  const [search, setSearch] = useState("");

  const [form, setForm] = useState(emptyForm);
  const [editId, setEditId] = useState(null);

  // ================= FETCH =================
  const fetchData = async (p = 1, keyword = "") => {
    setLoading(true);
    try {
      const res = await axios.get(API, {
        params: { page: p, limit: 5, search: keyword },
      });

      setCats(res.data.data.data);
      setMeta(res.data.data);
    } catch (err) {
      console.log(err);
      alert("Gagal ambil data");
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchData(page, search);
  }, [page]);

  // ================= INPUT =================
  const handleChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  const reset = () => {
    setForm(emptyForm);
    setEditId(null);
  };

  // ================= SAVE =================
  const handleSubmit = async (e) => {
    e.preventDefault();

    const payload = {
      ...form,
      umur: Number(form.umur),
      berat: Number(form.berat),
    };

    try {
      if (editId) {
        await axios.put(`${API}/${editId}`, payload);
      } else {
        await axios.post(API, payload);
      }

      reset();
      fetchData(page, search);
    } catch (err) {
      console.log(err.response?.data || err);
      alert("Gagal simpan data");
    }
  };

  // ================= DELETE =================
  const handleDelete = async (id) => {
    if (!confirm("Yakin hapus data ini?")) return;
    await axios.delete(`${API}/${id}`);
    fetchData(page, search);
  };

  // ================= EDIT =================
  const handleEdit = (cat) => {
    setForm(cat);
    setEditId(cat.id);
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-950 via-indigo-950 to-slate-900 text-white">

      {/* HEADER */}
      <div className="text-center py-8 text-3xl font-bold">
        🐱 CAT CRUD SYSTEM
        <p className="text-sm text-gray-300 mt-2">
          Laravel API + React + Tailwind CSS
        </p>
      </div>

      <div className="max-w-7xl mx-auto grid md:grid-cols-3 gap-6 px-6">

        {/* FORM */}
        <div className="bg-white/10 backdrop-blur-xl p-5 rounded-2xl border border-white/20">

          <h2 className="text-xl font-bold mb-4">
            {editId ? "Edit Data 📝" : "Tambah Kucing ➕"}
          </h2>

          <form onSubmit={handleSubmit} className="space-y-3">

            <input
              name="nama"
              value={form.nama}
              onChange={handleChange}
              placeholder="Nama kucing"
              className="w-full p-2 rounded-lg bg-white/10 border"
            />

            <input
              name="ras"
              value={form.ras}
              onChange={handleChange}
              placeholder="Ras (contoh: Persia)"
              className="w-full p-2 rounded-lg bg-white/10 border"
            />

            <input
              name="warna"
              value={form.warna}
              onChange={handleChange}
              placeholder="Warna (contoh: Putih)"
              className="w-full p-2 rounded-lg bg-white/10 border"
            />

            <input
              name="umur"
              type="number"
              value={form.umur}
              onChange={handleChange}
              placeholder="Umur (tahun)"
              className="w-full p-2 rounded-lg bg-white/10 border"
            />

            <input
              name="berat"
              type="number"
              step="0.1"
              value={form.berat}
              onChange={handleChange}
              placeholder="Berat (kg)"
              className="w-full p-2 rounded-lg bg-white/10 border"
            />

            {/* JENIS KELAMIN + KETERANGAN */}
            <div>
              <label className="text-sm text-gray-300">
                Jenis Kelamin (pilih salah satu)
              </label>
              <select
                name="jenis_kelamin"
                value={form.jenis_kelamin}
                onChange={handleChange}
                className="w-full p-2 rounded-lg bg-white/10 border mt-1"
              >
                <option value="Jantan">🐱 Jantan (Male)</option>
                <option value="Betina">🐱 Betina (Female)</option>
              </select>
            </div>

            {/* VAKSIN + KETERANGAN */}
            <div>
              <label className="text-sm text-gray-300">
                Status Vaksin (apakah sudah divaksin?)
              </label>
              <select
                name="status_vaksin"
                value={form.status_vaksin}
                onChange={handleChange}
                className="w-full p-2 rounded-lg bg-white/10 border mt-1"
              >
                <option value="Sudah">💉 Sudah divaksin</option>
                <option value="Belum">⚠️ Belum divaksin</option>
              </select>
            </div>

            <button className="w-full bg-indigo-500 hover:bg-indigo-600 p-2 rounded-lg font-bold">
              {editId ? "Update Data" : "Simpan Data"}
            </button>

            {editId && (
              <button
                type="button"
                onClick={reset}
                className="w-full bg-gray-500 p-2 rounded-lg"
              >
                Cancel
              </button>
            )}
          </form>
        </div>

        {/* TABLE */}
        <div className="md:col-span-2 bg-white/10 backdrop-blur-xl p-5 rounded-2xl">

          {/* SEARCH */}
          <div className="flex gap-2 mb-4">
            <input
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              placeholder="Cari kucing..."
              className="w-full p-2 rounded-lg bg-white/10 border"
            />
            <button
              onClick={() => fetchData(1, search)}
              className="bg-indigo-500 px-4 rounded-lg"
            >
              Search
            </button>
          </div>

          {/* TABLE */}
          {loading ? (
            <div className="text-center py-10">Loading...</div>
          ) : (
            <table className="w-full text-sm">
              <thead>
                <tr className="border-b border-white/20">
                  <th className="p-2">Nama</th>
                  <th className="p-2">Ras</th>
                  <th className="p-2">Warna</th>
                  <th className="p-2">Aksi</th>
                </tr>
              </thead>

              <tbody>
                {cats.map((c) => (
                  <tr key={c.id} className="text-center border-b border-white/10">
                    <td className="p-2">{c.nama}</td>
                    <td className="p-2">{c.ras}</td>
                    <td className="p-2">{c.warna}</td>

                    <td className="p-2 space-x-2">
                      <button
                        onClick={() => handleEdit(c)}
                        className="bg-yellow-500 px-3 py-1 rounded"
                      >
                        Edit
                      </button>

                      <button
                        onClick={() => handleDelete(c.id)}
                        className="bg-red-500 px-3 py-1 rounded"
                      >
                        Hapus
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}

          {/* PAGINATION */}
          <div className="flex justify-center gap-3 mt-6">
            <button
              disabled={meta.current_page <= 1}
              onClick={() => setPage(page - 1)}
              className="px-3 py-1 bg-white/20 rounded disabled:opacity-30"
            >
              Prev
            </button>

            <span>Page {meta.current_page}</span>

            <button
              disabled={meta.current_page >= meta.last_page}
              onClick={() => setPage(page + 1)}
              className="px-3 py-1 bg-white/20 rounded disabled:opacity-30"
            >
              Next
            </button>
          </div>

        </div>
      </div>
    </div>
  );
}