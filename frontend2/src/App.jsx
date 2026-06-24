import { useState, useEffect } from 'react';
import './App.css';

function App() {
  const [laundryData, setLaundryData] = useState([]);
  const [formData, setFormData] = useState({ id: '', nama_pelanggan: '', jenis_layanan: 'Cuci Komplit', berat: '' });

  const API_URL = 'http://localhost:3000/laundry';

  const HARGA_LAYANAN = {
    'Cuci Komplit': 6000, 
    'Cuci Kering': 5000,  
    'Setrika Saja': 4000  
  };

  const fetchLaundry = async () => {
    try {
      const response = await fetch(API_URL);
      const result = await response.json();
      if (result.status) setLaundryData(result.data);
    } catch (error) {
      console.error('Error fetching data:', error);
    }
  };

  useEffect(() => {
    fetchLaundry();
  }, []);

  const handleChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    const beratAngka = parseFloat(formData.berat);
    const totalHarga = beratAngka * HARGA_LAYANAN[formData.jenis_layanan];

    const payload = {
      nama_pelanggan: formData.nama_pelanggan,
      jenis_layanan: formData.jenis_layanan,
      berat: beratAngka,
      total_harga: totalHarga
    };

    const method = formData.id ? 'PUT' : 'POST';
    const url = formData.id ? `${API_URL}/${formData.id}` : API_URL;

    try {
      const response = await fetch(url, {
        method: method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });

      const result = await response.json();
      if (result.status) {
        setFormData({ id: '', nama_pelanggan: '', jenis_layanan: 'Cuci Komplit', berat: '' });
        fetchLaundry();
      }
    } catch (error) {
      console.error('Gagal menyimpan:', error);
    }
  };

  const handleEdit = (item) => {
    setFormData({ id: item.id, nama_pelanggan: item.nama_pelanggan, jenis_layanan: item.jenis_layanan, berat: item.berat });
  };

  const handleDelete = async (id) => {
    if (!window.confirm('Yakin ingin menghapus transaksi ini?')) return;
    try {
      await fetch(`${API_URL}/${id}`, { method: 'DELETE' });
      fetchLaundry();
      if (formData.id === id) setFormData({ id: '', nama_pelanggan: '', jenis_layanan: 'Cuci Komplit', berat: '' });
    } catch (error) {
      console.error('Gagal menghapus:', error);
    }
  };

  const formatRupiah = (angka) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(angka);
  
  const formatTanggal = (stringTanggal) => new Date(stringTanggal).toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'short' });

  const liveHarga = (parseFloat(formData.berat) || 0) * HARGA_LAYANAN[formData.jenis_layanan];

  return (
    <div className="container">
      <div className="header">
        <h2>🫧 Fresh Laundry System</h2>
        <p>Kasir & Manajemen Transaksi</p>
      </div>

      <div className="form-container">
        <form onSubmit={handleSubmit}>
          <div className="input-row">
            <div className="input-group">
              <label>Nama Pelanggan</label>
              <input type="text" name="nama_pelanggan" value={formData.nama_pelanggan} onChange={handleChange} placeholder="Masukkan nama..." required />
            </div>
            
            <div className="input-group">
              <label>Jenis Layanan</label>
              <select name="jenis_layanan" value={formData.jenis_layanan} onChange={handleChange}>
                <option value="Cuci Komplit">Cuci Komplit (Rp 6.000/kg)</option>
                <option value="Cuci Kering">Cuci Kering (Rp 5.000/kg)</option>
                <option value="Setrika Saja">Setrika Saja (Rp 4.000/kg)</option>
              </select>
            </div>
            
            <div className="input-group">
              <label>Berat (Kg)</label>
              <input type="number" step="0.1" name="berat" value={formData.berat} onChange={handleChange} placeholder="Misal: 2.5" required />
            </div>
          </div>

          <div className="price-display">
            <span>Estimasi Bayar: </span>
            <strong>{formatRupiah(liveHarga)}</strong>
          </div>

          <button type="submit" className="btn-submit">
            {formData.id ? 'Update Transaksi' : 'Simpan Transaksi Baru'}
          </button>
        </form>
      </div>

      <div className="table-container">
        <table>
          <thead>
            <tr>
              <th>ID</th>
              <th>Tanggal</th>
              <th>Nama Pelanggan</th>
              <th>Layanan</th>
              <th>Berat</th>
              <th>Total Harga</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            {laundryData.map((item) => (
              <tr key={item.id}>
                <td>{item.id}</td>
                <td className="text-sm">{formatTanggal(item.tanggal)}</td>
                <td className="fw-bold">{item.nama_pelanggan}</td>
                <td><span className="badge">{item.jenis_layanan}</span></td>
                <td>{item.berat} Kg</td>
                <td className="fw-bold text-blue">{formatRupiah(item.total_harga)}</td>
                <td className="action-buttons">
                  <button className="btn-edit" onClick={() => handleEdit(item)}>Edit</button>
                  <button className="btn-delete" onClick={() => handleDelete(item.id)}>Hapus</button>
                </td>
              </tr>
            ))}
            {laundryData.length === 0 && (
              <tr>
                <td colSpan="7" style={{ textAlign: 'center', padding: '20px' }}>Belum ada data transaksi.</td>
              </tr>
            )}
          </tbody>
        </table>
      </div>
    </div>
  );
}

export default App;