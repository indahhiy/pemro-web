import React, { useState, useEffect } from 'react';

const CategoryForm = ({ onSubmit, selectedCategory, onCancel }) => {
    const [categoryName, setCategoryName] = useState('');
    const [description, setDescription] = useState('');

    useEffect(() => {
        if (selectedCategory) {
            setCategoryName(selectedCategory.category_name);
            setDescription(selectedCategory.description || '');
        } else {
            setCategoryName('');
            setDescription('');
        }
    }, [selectedCategory]);

    const handleSubmit = (e) => {
        e.preventDefault();
        if (!categoryName) return alert('Nama kategori wajib diisi!');
        onSubmit({ category_name: categoryName, description });
        setCategoryName('');
        setDescription('');
    };

    return (
        <div style={{ marginBottom: '20px', padding: '15px', border: '1px solid #ccc', borderRadius: '5px', textAlign: 'left' }}>
            <h3>{selectedCategory ? '✏️ Edit Kategori' : '➕ Tambah Kategori Baru'}</h3>
            <form onSubmit={handleSubmit}>
                <div style={{ marginBottom: '10px' }}>
                    <label style={{ display: 'block', marginBottom: '5px' }}>Nama Kategori: </label>
                    <input 
                        type="text" 
                        value={categoryName} 
                        onChange={(e) => setCategoryName(e.target.value)} 
                        placeholder="Contoh: Makanan, Elektronik"
                        style={{ width: '100%', padding: '8px', boxSizing: 'border-box' }}
                    />
                </div>
                <div style={{ marginBottom: '10px' }}>
                    <label style={{ display: 'block', marginBottom: '5px' }}>Deskripsi: </label>
                    <textarea 
                        value={description} 
                        onChange={(e) => setDescription(e.target.value)} 
                        placeholder="Deskripsi singkat..."
                        style={{ width: '100%', padding: '8px', boxSizing: 'border-box' }}
                    />
                </div>
                <button type="submit" style={{ backgroundColor: '#28a745', color: 'white', padding: '8px 15px', border: 'none', borderRadius: '3px', cursor: 'pointer' }}>
                    {selectedCategory ? 'Perbarui' : 'Simpan'}
                </button>
                {selectedCategory && (
                    <button type="button" onClick={onCancel} style={{ marginLeft: '10px', padding: '8px 15px', borderRadius: '3px', cursor: 'pointer' }}>
                        Batal
                    </button>
                )}
            </form>
        </div>
    );
};

export default CategoryForm;