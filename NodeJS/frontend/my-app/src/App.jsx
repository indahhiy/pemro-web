import { useEffect, useState } from "react";
import axios from "axios";

const API = "http://localhost:3000";

export default function App() {
  const [categories, setCategories] = useState([]);
  const [categoryName, setCategoryName] = useState("");
  const [editId, setEditId] = useState(null);

  const [loading, setLoading] = useState(false);
  const [fetching, setFetching] = useState(false);

  // GET
  const fetchData = async () => {
    try {
      setFetching(true);
      const res = await axios.get(`${API}/categories`);
      setCategories(res.data.data);
    } catch (err) {
      console.log(err);
    } finally {
      setFetching(false);
    }
  };

  useEffect(() => {
    fetchData();
  }, []);

  // CREATE / UPDATE (EDIT)
  const submitCategory = async () => {
    if (!categoryName.trim()) return;

    try {
      setLoading(true);

      if (editId) {
        await axios.put(`${API}/categories/${editId}`, {
          category_name: categoryName,
        });
      } else {
        await axios.post(`${API}/categories`, {
          category_name: categoryName,
        });
      }

      setCategoryName("");
      setEditId(null);
      fetchData();
    } catch (err) {
      console.log(err);
    } finally {
      setLoading(false);
    }
  };

  // DELETE
  const deleteCategory = async (id) => {
    if (!confirm("Hapus kategori ini?")) return;

    await axios.delete(`${API}/categories/${id}`);
    fetchData();
  };

  // EDIT SELECT
  const startEdit = (item) => {
    setEditId(item.id);
    setCategoryName(item.category_name);
  };

  const cancelEdit = () => {
    setEditId(null);
    setCategoryName("");
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-slate-950 via-slate-900 to-black text-white">

      {/* HEADER */}
      <div className="max-w-6xl mx-auto p-8">
        <h1 className="text-5xl font-black bg-gradient-to-r from-cyan-400 via-blue-500 to-purple-500 bg-clip-text text-transparent">
          CATEGORY DASHBOARD
        </h1>

        <p className="text-slate-400 mt-2">
          React • Express • MySQL CRUD System
        </p>

        {/* STATS */}
        <div className="grid md:grid-cols-3 gap-5 mt-8">

          <div className="bg-white/5 border border-white/10 backdrop-blur-xl p-5 rounded-2xl">
            <p className="text-slate-400 text-sm">Total</p>
            <h2 className="text-4xl font-bold text-cyan-400">
              {categories.length}
            </h2>
          </div>

          <div className="bg-white/5 border border-white/10 backdrop-blur-xl p-5 rounded-2xl">
            <p className="text-slate-400 text-sm">Status</p>
            <h2 className="text-2xl font-bold text-green-400">Online</h2>
          </div>

          <div className="bg-white/5 border border-white/10 backdrop-blur-xl p-5 rounded-2xl">
            <p className="text-slate-400 text-sm">Database</p>
            <h2 className="text-2xl font-bold text-purple-400">MySQL</h2>
          </div>

        </div>

        {/* INPUT */}
        <div className="bg-white/5 border border-white/10 backdrop-blur-xl rounded-2xl p-6 mt-8">

          <h2 className="text-xl font-bold mb-4">
            {editId ? "✏️ Edit Category" : "➕ Tambah Category"}
          </h2>

          <div className="flex gap-3">

            <input
              className="flex-1 bg-slate-900 border border-slate-700 rounded-xl px-4 py-3 outline-none focus:border-cyan-400"
              placeholder="Masukkan kategori..."
              value={categoryName}
              onChange={(e) => setCategoryName(e.target.value)}
            />

            <button
              onClick={submitCategory}
              className="bg-gradient-to-r from-cyan-500 to-blue-600 px-6 rounded-xl font-bold hover:scale-105 transition"
            >
              {loading ? "..." : editId ? "Update" : "Tambah"}
            </button>

            {editId && (
              <button
                onClick={cancelEdit}
                className="bg-slate-700 px-5 rounded-xl hover:bg-slate-600"
              >
                Batal
              </button>
            )}

          </div>
        </div>

        {/* TABLE */}
        <div className="bg-white/5 border border-white/10 backdrop-blur-xl rounded-2xl mt-8 overflow-hidden">

          <div className="flex justify-between p-5 border-b border-white/10">
            <h2 className="font-bold">📁 Categories</h2>

            <button
              onClick={fetchData}
              className="text-sm bg-white/10 px-3 py-1 rounded-lg hover:bg-white/20"
            >
              Refresh
            </button>
          </div>

          <table className="w-full">

            <thead className="bg-white/5 text-slate-300">
              <tr>
                <th className="p-4 text-left">ID</th>
                <th className="p-4 text-left">Name</th>
                <th className="p-4 text-center">Action</th>
              </tr>
            </thead>

            <tbody>

              {fetching ? (
                <tr>
                  <td colSpan="3" className="text-center py-10 text-gray-400">
                    Loading...
                  </td>
                </tr>
              ) : categories.length === 0 ? (
                <tr>
                  <td colSpan="3" className="text-center py-10 text-gray-500">
                    Belum ada data
                  </td>
                </tr>
              ) : (
                categories.map((item) => (
                  <tr
                    key={item.id}
                    className="border-t border-white/10 hover:bg-white/5 transition"
                  >

                    <td className="p-4 text-cyan-400 font-bold">
                      #{item.id}
                    </td>

                    <td className="p-4 font-semibold">
                      {item.category_name}
                    </td>

                    <td className="p-4">

                      <div className="flex gap-2 justify-center">

                        <button
                          onClick={() => startEdit(item)}
                          className="bg-yellow-500 hover:bg-yellow-600 text-black px-3 py-1 rounded-lg font-bold"
                        >
                          Edit
                        </button>

                        <button
                          onClick={() => deleteCategory(item.id)}
                          className="bg-red-500 hover:bg-red-600 px-3 py-1 rounded-lg font-bold"
                        >
                          Hapus
                        </button>

                      </div>

                    </td>

                  </tr>
                ))
              )}

            </tbody>

          </table>

        </div>

      </div>
    </div>
  );
}