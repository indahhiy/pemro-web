import React, { useEffect, useState } from 'react';
import api from './api'; // Mengambil konfigurasi axios langsung dari satu folder
import CategoryForm from './CategoryForm';

const CategoryList = () => {
    const [categories, setCategories] = useState([]);
    const [currentCategory, setCurrentCategory] = useState(null);

    // 1. Ambil Data (GET)
    const fetchCategories = async () => {
        try {
            const res = await api.get('/categories');
            setCategories(res.data.result); // Menangkap key 'result' dari fungsi sendSuccess backend Anda
        } catch (error) {
            console.error(error);
            alert('Gagal mengambil data dari backend server');
        }
    };

    useEffect(() => {
        fetchCategories();
    }, []);

    // 2. Tambah & Edit Data (POST & PUT)
    const handleFormSubmit = async (formData) => {
        try {
            if (currentCategory) {
                await api.put(`/categories/${currentCategory.id}`, formData);
                alert('Kategori sukses diperbarui!');
            } else {
                await api.post('/categories', formData);
                alert('Kategori baru sukses ditambahkan!');
            }
            setCurrentCategory(null);
            fetchCategories(); // Reload isi tabel
        } catch (error) {
            alert('Aksi gagal dikirim ke backend');
        }
    };

    // 3. Hapus Data (DELETE)
    const handleDelete = async (id) => {
        if (window.confirm('Yakin ingin menghapus kategori ini?')) {
            try {
                await api.delete(`/categories/${id}`);
                alert('Kategori berhasil dihapus!');
                fetchCategories(); // Reload isi tabel
            } catch (error) {
                alert('Gagal menghapus data');
            }
        }
    };

    return (
        <div style={{ background: '#fff', padding: '20px', borderRadius: '8px', color: '#333' }}>
            <CategoryForm 
                onSubmit={handleFormSubmit} 
                selectedCategory={currentCategory}
                onCancel={() => setCurrentCategory(null)}
            />

            <h2 style={{ textAlign: 'left', marginTop: '20px' }}>📋 Tabel Data Kategori</h2>
            <table border="1" cellPadding="10" style={{ width: '100%', borderCollapse: 'collapse', textAlign: 'left' }}>
                <thead>
                    <tr style={{ backgroundColor: '#f2f2f2' }}>
                        <th>ID</th>
                        <th>Nama Kategori</th>
                        <th>Deskripsi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {categories.length > 0 ? (
                        categories.map((cat) => (
                            <tr key={cat.id}>
                                <td>{cat.id}</td>
                                <td>{cat.category_name}</td>
                                <td>{cat.description || '-'}</td>
                                <td>
                                    <button onClick={() => setCurrentCategory(cat)} style={{ marginRight: '5px', backgroundColor: '#ffc107', border: 'none', padding: '5px 10px', borderRadius: '3px', cursor: 'pointer' }}>Edit</button>
                                    <button onClick={() => handleDelete(cat.id)} style={{ backgroundColor: '#dc3545', color: 'white', border: 'none', padding: '5px 10px', borderRadius: '3px', cursor: 'pointer' }}>Hapus</button>
                                </td>
                            </tr>
                        ))
                    ) : (
                        <tr>
                            <td colSpan="4" style={{ textAlign: 'center' }}>Tidak ada data di database.</td>
                        </tr>
                    )}
                </tbody>
            </table>
        </div>
    );
};

export default CategoryList;