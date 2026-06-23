import React, { useState, useEffect } from 'react';

function App() {
  // State Utama untuk Data Tabel
  const [rooms, setRooms] = useState([]);
  const [search, setSearch] = useState('');
  const [page, setPage] = useState(1);
  const [pagination, setPagination] = useState({ total_pages: 1, total: 0 });
  const [loading, setLoading] = useState(false);

  // State Form untuk Operasi Create & Update
  const [form, setForm] = useState({ id: null, room_number: '', room_type: '', floor: '', status: 'Available', price_per_night: '' });
  const [isEdit, setIsEdit] = useState(false);
  const [errors, setErrors] = useState({});

  // URL mengarah ke port 5000 sesuai dengan backend Express.js Anda
  const API_URL = 'http://localhost:5000/rooms';

  // 1. READ: Fungsi mengambil data dari backend dengan format Search & Pagination
  const fetchRooms = async () => {
    setLoading(true);
    try {
      // Mengirim page dan search melalui query params sesuai instruksi PDF
      const response = await fetch(`${API_URL}?page=${page}&search=${search}&limit=5`, {
        headers: { 
          'Accept': 'application/json' 
        }
      });
      const result = await response.json();
      
      // Menyesuaikan dengan response helper "status: true" dari backend
      if (result.status) {
        setRooms(result.data);
        setPagination(result.pagination);
      }
    } catch (error) {
      console.error("Gagal mengambil data dari server:", error);
    }
    setLoading(false);
  };

  // Menjalankan fungsi fetch setiap kali halaman (page) atau kolom pencarian (search) berubah
  useEffect(() => {
    fetchRooms();
  }, [page, search]);

  // Handler mengubah nilai state form ketika user mengetik
  const handleInputChange = (e) => {
    setForm({ ...form, [e.target.name]: e.target.value });
  };

  // 2. CREATE & UPDATE: Fungsi submit data (Tambah baru atau Update)
  const handleSubmit = async (e) => {
    e.preventDefault();
    setErrors({});
    
    const method = isEdit ? 'PUT' : 'POST';
    const url = isEdit ? `${API_URL}/${form.id}` : API_URL;

    try {
      const response = await fetch(url, {
        method: method,
        headers: { 
          'Content-Type': 'application/json', 
          'Accept': 'application/json' 
        },
        body: JSON.stringify(form) // Kirim request body / payload sesuai instruksi PDF
      });
      const result = await response.json();

      if (response.status === 422) {
        // Menangkap response error validasi gagal (422) dari backend
        setErrors(result.errors);
      } else if (result.status) {
        alert(result.message);
        resetForm();
        fetchRooms(); // Refresh data tabel setelah sukses
      }
    } catch (error) {
      console.error("Gagal menyimpan data:", error);
    }
  };

  // Fungsi memicu mode edit dan memasukkan data baris tabel ke dalam form
  const handleEdit = (room) => {
    setIsEdit(true);
    setForm(room);
  };

  // 3. DELETE: Fungsi menghapus data berdasarkan ID
  const handleDelete = async (id) => {
    if (window.confirm("Apakah Anda yakin ingin menghapus data kamar hotel ini?")) {
      try {
        const response = await fetch(`${API_URL}/${id}`, {
          method: 'DELETE',
          headers: { 'Accept': 'application/json' }
        });
        const result = await response.json();
        if (result.status) {
          alert(result.message);
          fetchRooms(); // Refresh data tabel setelah sukses menghapus
        }
      } catch (error) {
        console.error("Gagal menghapus data:", error);
      }
    }
  };

  // Reset form kembali ke kondisi kosong semula
  const resetForm = () => {
    setForm({ id: null, room_number: '', room_type: '', floor: '', status: 'Available', price_per_night: '' });
    setIsEdit(false);
    setErrors({});
  };

  return (
    <div style={{ padding: '20px', fontFamily: 'Arial, sans-serif', maxWidth: '1200px', margin: '0 auto' }}>
      <h2>📋 Sistem Manajemen Kamar Hotel (Hotel Rooms)</h2>
      <p style={{ color: '#666' }}>Teknologi: Express.js (Backend) + React.js (Frontend DataTable)</p>
      <hr />

      {/* COMPONENT FORM (TAMBAH & EDIT DATA) */}
      <div style={{ backgroundColor: '#f9f9f9', padding: '15px', borderRadius: '8px', marginBottom: '20px', border: '1px solid #ddd' }}>
        <h3>{isEdit ? "✏️ Edit Data Kamar" : "➕ Tambah Kamar Baru"}</h3>
        <form onSubmit={handleSubmit} style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '10px' }}>
          <div>
            <label>Nomor Kamar:</label>
            <input type="text" name="room_number" value={form.room_number} onChange={handleInputChange} style={{ width: '100%', padding: '8px', marginTop: '5px' }} />
            {errors.room_number && <span style={{ color: 'red', fontSize: '12px' }}>{errors.room_number[0]}</span>}
          </div>
          <div>
            <label>Tipe Kamar:</label>
            <input type="text" name="room_type" value={form.room_type} onChange={handleInputChange} style={{ width: '100%', padding: '8px', marginTop: '5px' }} />
            {errors.room_type && <span style={{ color: 'red', fontSize: '12px' }}>{errors.room_type[0]}</span>}
          </div>
          <div>
            <label>Lantai Kamar:</label>
            <input type="number" name="floor" value={form.floor} onChange={handleInputChange} style={{ width: '100%', padding: '8px', marginTop: '5px' }} />
          </div>
          <div>
            <label>Status Kamar:</label>
            <select name="status" value={form.status} onChange={handleInputChange} style={{ width: '100%', padding: '8px', marginTop: '5px' }}>
              <option value="Available">Available</option>
              <option value="Booked">Booked</option>
            </select>
          </div>
          <div style={{ gridColumn: 'span 2' }}>
            <label>Harga per Malam (IDR):</label>
            <input type="number" name="price_per_night" value={form.price_per_night} onChange={handleInputChange} style={{ width: '100%', padding: '8px', marginTop: '5px' }} />
          </div>
          <div style={{ gridColumn: 'span 2', marginTop: '10px' }}>
            <button type="submit" style={{ padding: '10px 15px', backgroundColor: '#007BFF', color: 'white', border: 'none', cursor: 'pointer', marginRight: '5px', borderRadius: '4px' }}>
              {isEdit ? "Perbarui Data" : "Simpan Data"}
            </button>
            <button type="button" onClick={resetForm} style={{ padding: '10px 15px', backgroundColor: '#f44336', color: 'white', border: 'none', cursor: 'pointer', borderRadius: '4px' }}>
              Batal
            </button>
          </div>
        </form>
      </div>

      {/* FILTER SEARCH & PANEL INFORMASI */}
      <div style={{ marginBottom: '15px', display: 'flex', justifyContent: 'space-between', alignItems: 'center' }}>
        <input 
          type="text" 
          placeholder="🔍 Cari No. Kamar atau Tipe Kamar..." 
          value={search} 
          onChange={(e) => { setSearch(e.target.value); setPage(1); }} // Reset ke halaman 1 saat mengetik kata kunci baru
          style={{ padding: '10px', width: '320px', borderRadius: '4px', border: '1px solid #ccc' }}
        />
        <span style={{ fontWeight: 'bold' }}>Total Data: {pagination.total}</span>
      </div>

      {/* COMPONENT DATATABLE */}
      {loading ? <p>Sedang memuat data dari server...</p> : (
        <table border="1" cellPadding="10" cellSpacing="0" style={{ width: '100%', borderCollapse: 'collapse', textAlign: 'left', border: '1px solid #ddd' }}>
          <thead style={{ backgroundColor: '#007BFF', color: 'white' }}>
            <tr>
              <th>ID</th>
              <th>No. Kamar</th>
              <th>Tipe Kamar</th>
              <th>Lantai</th>
              <th>Status</th>
              <th>Harga/Malam</th>
              <th style={{ textAlign: 'center' }}>Aksi / Operasi</th>
            </tr>
          </thead>
          <tbody>
            {rooms.length > 0 ? rooms.map((room) => (
              <tr key={room.id} style={{ borderBottom: '1px solid #ddd' }}>
                <td>{room.id}</td>
                <td><strong>{room.room_number}</strong></td>
                <td>{room.room_type}</td>
                <td>Lantai {room.floor}</td>
                <td>
                  <span style={{ 
                    backgroundColor: room.status === 'Available' ? '#d4edda' : '#f8d7da', 
                    color: room.status === 'Available' ? '#155724' : '#721c24', 
                    padding: '4px 10px', 
                    borderRadius: '4px',
                    fontSize: '14px',
                    fontWeight: 'bold'
                  }}>
                    {room.status}
                  </span>
                </td>
                <td>Rp {parseInt(room.price_per_night).toLocaleString('id-ID')}</td>
                <td style={{ textAlign: 'center' }}>
                  <button onClick={() => handleEdit(room)} style={{ marginRight: '5px', backgroundColor: '#ff9800', color: 'white', border: 'none', padding: '6px 12px', cursor: 'pointer', borderRadius: '4px' }}>Edit</button>
                  <button onClick={() => handleDelete(room.id)} style={{ backgroundColor: '#f44336', color: 'white', border: 'none', padding: '6px 12px', cursor: 'pointer', borderRadius: '4px' }}>Hapus</button>
                </td>
              </tr>
            )) : (
              <tr>
                <td colSpan="7" style={{ textAlign: 'center', color: '#999', padding: '20px' }}>Data kamar hotel tidak ditemukan pada database.</td>
              </tr>
            )}
          </tbody>
        </table>
      )}

      {/* PANEL NAVIGASI PAGINATION */}
      <div style={{ marginTop: '15px', display: 'flex', justifyContent: 'center', alignItems: 'center', gap: '8px' }}>
        <button 
          disabled={page === 1} 
          onClick={() => setPage(page - 1)} 
          style={{ padding: '6px 12px', cursor: page === 1 ? 'not-allowed' : 'pointer' }}
        >
          Sebelumnya
        </button>
        <span style={{ padding: '6px 12px', backgroundColor: '#eee', borderRadius: '4px' }}>
          Halaman {page} dari {pagination.total_pages}
        </span>
        <button 
          disabled={page === pagination.total_pages} 
          onClick={() => setPage(page + 1)} 
          style={{ padding: '6px 12px', cursor: page === pagination.total_pages ? 'not-allowed' : 'pointer' }}
        >
          Selanjutnya
        </button>
      </div>
    </div>
  );
}

export default App;