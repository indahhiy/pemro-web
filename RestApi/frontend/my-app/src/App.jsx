import { useEffect, useState } from "react";
import axios from "axios";

const API = "http://127.0.0.1:8000/api/films";

function App() {
  const [films, setFilms] = useState([]);
  const [search, setSearch] = useState("");
  const [editId, setEditId] = useState(null);

  // ✅ PAGINATION STATE
  const [page, setPage] = useState(1);

  const [form, setForm] = useState({
    kode_film: "",
    judul: "",
    genre: "",
    sutradara: "",
    tahun_rilis: "",
    rating: "",
  });

  // GET (SEARCH + PAGINATION)
  const fetchData = async () => {
    try {
      const res = await axios.get(
        `${API}?search=${search}&page=${page}&limit=5`,
        {
          headers: {
            Accept: "application/json",
          },
        }
      );

      setFilms(res.data.data);
    } catch (err) {
      console.log("GET ERROR:", err.response?.data || err.message);
    }
  };

  useEffect(() => {
    fetchData();
  }, [search, page]); // ✅ page ikut trigger

  const handleChange = (e) => {
    setForm({
      ...form,
      [e.target.name]: e.target.value,
    });
  };

  // CREATE / UPDATE
  const handleSubmit = async (e) => {
    e.preventDefault();

    try {
      const payload = {
        kode_film: form.kode_film,
        judul: form.judul,
        genre: form.genre,
        sutradara: form.sutradara,
        tahun_rilis: parseInt(form.tahun_rilis),
        rating: parseFloat(form.rating),
      };

      if (editId) {
        await axios.put(`${API}/${editId}`, payload, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
        });
      } else {
        await axios.post(API, payload, {
          headers: {
            "Content-Type": "application/json",
            Accept: "application/json",
          },
        });
      }

      setForm({
        kode_film: "",
        judul: "",
        genre: "",
        sutradara: "",
        tahun_rilis: "",
        rating: "",
      });

      setEditId(null);
      fetchData();
    } catch (err) {
      console.log(err.response?.data || err.message);
      alert(JSON.stringify(err.response?.data));
    }
  };

  // DELETE
  const handleDelete = async (id) => {
    if (!confirm("Hapus data?")) return;

    try {
      await axios.delete(`${API}/${id}`);
      fetchData();
    } catch (err) {
      console.log(err.response?.data || err.message);
    }
  };

  // EDIT
  const handleEdit = (film) => {
    setEditId(film.id);

    setForm({
      kode_film: film.kode_film,
      judul: film.judul,
      genre: film.genre,
      sutradara: film.sutradara,
      tahun_rilis: film.tahun_rilis,
      rating: film.rating,
    });
  };

  return (
    <div className="min-h-screen bg-gray-900 text-white p-8">
      <div className="max-w-6xl mx-auto">

        <h1 className="text-4xl font-bold text-center mb-8">
          🎬 CRUD FILM
        </h1>

        {/* SEARCH */}
        <input
          type="text"
          placeholder="Cari judul..."
          value={search}
          onChange={(e) => {
            setSearch(e.target.value);
            setPage(1); // reset page kalau search
          }}
          className="w-full p-3 rounded bg-gray-800 mb-6"
        />

        {/* FORM */}
        <form
          onSubmit={handleSubmit}
          className="grid grid-cols-2 gap-3 bg-gray-800 p-6 rounded-xl mb-8"
        >
          {Object.keys(form).map((key) => (
            <input
              key={key}
              name={key}
              value={form[key]}
              onChange={handleChange}
              placeholder={key}
              className="p-3 rounded bg-gray-700"
            />
          ))}

          <button
            type="submit"
            className="col-span-2 bg-blue-600 hover:bg-blue-700 p-3 rounded font-bold"
          >
            {editId ? "UPDATE FILM" : "TAMBAH FILM"}
          </button>
        </form>

        {/* TABLE */}
        <div className="overflow-x-auto">
          <table className="w-full bg-gray-800 rounded-xl overflow-hidden">
            <thead className="bg-gray-700">
              <tr>
                <th className="p-3">Kode</th>
                <th className="p-3">Judul</th>
                <th className="p-3">Genre</th>
                <th className="p-3">Sutradara</th>
                <th className="p-3">Tahun</th>
                <th className="p-3">Rating</th>
                <th className="p-3">Aksi</th>
              </tr>
            </thead>

            <tbody>
              {films.map((film) => (
                <tr key={film.id} className="border-t border-gray-700">
                  <td className="p-3">{film.kode_film}</td>
                  <td className="p-3">{film.judul}</td>
                  <td className="p-3">{film.genre}</td>
                  <td className="p-3">{film.sutradara}</td>
                  <td className="p-3">{film.tahun_rilis}</td>
                  <td className="p-3">{film.rating}</td>

                  <td className="p-3 flex gap-2 justify-center">
                    <button
                      onClick={() => handleEdit(film)}
                      className="bg-yellow-500 px-3 py-1 rounded"
                    >
                      Edit
                    </button>

                    <button
                      onClick={() => handleDelete(film.id)}
                      className="bg-red-600 px-3 py-1 rounded"
                    >
                      Hapus
                    </button>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>

        {/* PAGINATION UI */}
        <div className="flex items-center justify-center gap-4 mt-6">
          <button
            onClick={() => setPage((p) => Math.max(p - 1, 1))}
            className="px-4 py-2 bg-gray-700 rounded"
          >
            Prev
          </button>

          <span>Page {page}</span>

          <button
            onClick={() => setPage((p) => p + 1)}
            className="px-4 py-2 bg-gray-700 rounded"
          >
            Next
          </button>
        </div>

      </div>
    </div>
  );
}

export default App;