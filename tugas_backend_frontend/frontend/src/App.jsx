import { useState, useEffect } from 'react'
import './App.css'

const API_URL = 'http://localhost:3000'

function App() {
  const [products, setProducts] = useState([])
  const [categories, setCategories] = useState([])
  const [loading, setLoading] = useState(false)
  const [error, setError] = useState(null)
  const [successMsg, setSuccessMsg] = useState(null)

  // Modal state
  const [showModal, setShowModal] = useState(false)
  const [modalMode, setModalMode] = useState('add') // 'add' | 'edit'
  const [selectedProduct, setSelectedProduct] = useState(null)

  // Delete confirm state
  const [showDeleteConfirm, setShowDeleteConfirm] = useState(false)
  const [deleteTarget, setDeleteTarget] = useState(null)

  // Form state
  const emptyForm = {
    category_id: '',
    name: '',
    code: '',
    description: '',
    price: '',
    stock: '',
    unit: 'pcs',
  }
  const [form, setForm] = useState(emptyForm)
  const [formErrors, setFormErrors] = useState({})
  const [formLoading, setFormLoading] = useState(false)

  // Search
  const [search, setSearch] = useState('')

  useEffect(() => {
    fetchProducts()
    fetchCategories()
  }, [])

  const showSuccess = (msg) => {
    setSuccessMsg(msg)
    setTimeout(() => setSuccessMsg(null), 3000)
  }

  const fetchProducts = async () => {
    setLoading(true)
    setError(null)
    try {
      const res = await fetch(`${API_URL}/products`)
      const json = await res.json()
      if (json.status) setProducts(json.data)
      else setError('Gagal memuat data produk')
    } catch {
      setError('Tidak dapat terhubung ke server. Pastikan backend berjalan.')
    } finally {
      setLoading(false)
    }
  }

  const fetchCategories = async () => {
    try {
      const res = await fetch(`${API_URL}/categories`)
      const json = await res.json()
      if (json.status) setCategories(json.data)
    } catch {
      // silent fail
    }
  }

  const openAddModal = () => {
    setForm(emptyForm)
    setFormErrors({})
    setModalMode('add')
    setSelectedProduct(null)
    setShowModal(true)
  }

  const openEditModal = (product) => {
    setForm({
      category_id: product.category_id,
      name: product.name,
      code: product.code,
      description: product.description || '',
      price: product.price,
      stock: product.stock,
      unit: product.unit,
    })
    setFormErrors({})
    setModalMode('edit')
    setSelectedProduct(product)
    setShowModal(true)
  }

  const closeModal = () => {
    setShowModal(false)
    setSelectedProduct(null)
    setFormErrors({})
  }

  const handleFormChange = (e) => {
    const { name, value } = e.target
    setForm((prev) => ({ ...prev, [name]: value }))
    if (formErrors[name]) {
      setFormErrors((prev) => ({ ...prev, [name]: undefined }))
    }
  }

  const handleSubmit = async () => {
    setFormLoading(true)
    setFormErrors({})
    try {
      const url =
        modalMode === 'add'
          ? `${API_URL}/products`
          : `${API_URL}/products/${selectedProduct.id}`
      const method = modalMode === 'add' ? 'POST' : 'PUT'

      const res = await fetch(url, {
        method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(form),
      })
      const json = await res.json()

      if (json.status) {
        closeModal()
        fetchProducts()
        showSuccess(
          modalMode === 'add'
            ? 'Produk berhasil ditambahkan!'
            : 'Produk berhasil diperbarui!'
        )
      } else if (json.errors) {
        setFormErrors(json.errors)
      } else {
        setFormErrors({ general: json.message || 'Terjadi kesalahan' })
      }
    } catch {
      setFormErrors({ general: 'Tidak dapat terhubung ke server' })
    } finally {
      setFormLoading(false)
    }
  }

  const confirmDelete = (product) => {
    setDeleteTarget(product)
    setShowDeleteConfirm(true)
  }

  const handleDelete = async () => {
    if (!deleteTarget) return
    try {
      const res = await fetch(`${API_URL}/products/${deleteTarget.id}`, {
        method: 'DELETE',
      })
      const json = await res.json()
      if (json.status) {
        setShowDeleteConfirm(false)
        setDeleteTarget(null)
        fetchProducts()
        showSuccess(`Produk "${deleteTarget.name}" berhasil dihapus!`)
      }
    } catch {
      setError('Gagal menghapus produk')
    }
  }

  const filteredProducts = products.filter(
    (p) =>
      p.name.toLowerCase().includes(search.toLowerCase()) ||
      p.code.toLowerCase().includes(search.toLowerCase()) ||
      (p.category_name || '').toLowerCase().includes(search.toLowerCase())
  )

  const formatPrice = (price) =>
    new Intl.NumberFormat('id-ID', {
      style: 'currency',
      currency: 'IDR',
      minimumFractionDigits: 0,
    }).format(price)

  return (
    <div className="app">
      {/* Header */}
      <header className="header">
        <div className="header-inner">
          <div className="header-brand">
            <div className="header-logo">SP</div>
            <div>
              <div className="header-title">Sparepart Manager</div>
              <div className="header-sub">Manajemen Produk Sparepart</div>
            </div>
          </div>
        </div>
      </header>

      {/* Main */}
      <main className="main">
        {/* Alert */}
        {successMsg && (
          <div className="alert alert-success">
            <span className="alert-icon">✓</span>
            {successMsg}
          </div>
        )}
        {error && (
          <div className="alert alert-error">
            <span className="alert-icon">✕</span>
            {error}
            <button className="alert-close" onClick={() => setError(null)}>×</button>
          </div>
        )}

        {/* Toolbar */}
        <div className="toolbar">
          <div className="toolbar-left">
            <h2 className="section-title">Daftar Produk</h2>
            <span className="badge">{filteredProducts.length} produk</span>
          </div>
          <div className="toolbar-right">
            <div className="search-wrap">
              <span className="search-icon">⌕</span>
              <input
                type="text"
                className="search-input"
                placeholder="Cari produk, kode, kategori..."
                value={search}
                onChange={(e) => setSearch(e.target.value)}
              />
            </div>
            <button className="btn btn-primary" onClick={openAddModal}>
              + Tambah Produk
            </button>
          </div>
        </div>

        {/* Table */}
        <div className="table-wrap">
          {loading ? (
            <div className="state-box">
              <div className="spinner" />
              <p>Memuat data...</p>
            </div>
          ) : filteredProducts.length === 0 ? (
            <div className="state-box">
              <div className="empty-icon">📦</div>
              <p>
                {search
                  ? `Tidak ada produk yang cocok dengan "${search}"`
                  : 'Belum ada produk. Klik "+ Tambah Produk" untuk mulai.'}
              </p>
            </div>
          ) : (
            <table className="table">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Kode</th>
                  <th>Nama Produk</th>
                  <th>Kategori</th>
                  <th>Harga</th>
                  <th>Stok</th>
                  <th>Satuan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                {filteredProducts.map((p, i) => (
                  <tr key={p.id}>
                    <td className="td-center td-num">{i + 1}</td>
                    <td>
                      <span className="code-badge">{p.code}</span>
                    </td>
                    <td>
                      <div className="product-name">{p.name}</div>
                      {p.description && (
                        <div className="product-desc">{p.description}</div>
                      )}
                    </td>
                    <td>
                      <span className="category-tag">{p.category_name}</span>
                    </td>
                    <td className="td-price">{formatPrice(p.price)}</td>
                    <td className="td-center">
                      <span className={`stock-badge ${p.stock <= 5 ? 'stock-low' : ''}`}>
                        {p.stock}
                      </span>
                    </td>
                    <td className="td-center td-unit">{p.unit}</td>
                    <td className="td-actions">
                      <button
                        className="btn-action btn-edit"
                        onClick={() => openEditModal(p)}
                        title="Edit produk"
                      >
                        ✎ Edit
                      </button>
                      <button
                        className="btn-action btn-delete"
                        onClick={() => confirmDelete(p)}
                        title="Hapus produk"
                      >
                        ✕ Hapus
                      </button>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          )}
        </div>
      </main>

      {/* Modal Tambah/Edit */}
      {showModal && (
        <div className="modal-overlay" onClick={closeModal}>
          <div className="modal" onClick={(e) => e.stopPropagation()}>
            <div className="modal-header">
              <h3 className="modal-title">
                {modalMode === 'add' ? '+ Tambah Produk Baru' : '✎ Edit Produk'}
              </h3>
              <button className="modal-close" onClick={closeModal}>×</button>
            </div>

            <div className="modal-body">
              {formErrors.general && (
                <div className="form-error-banner">{formErrors.general}</div>
              )}

              <div className="form-row">
                <div className="form-group">
                  <label className="form-label">
                    Kategori <span className="required">*</span>
                  </label>
                  <select
                    name="category_id"
                    className={`form-control ${formErrors.category_id ? 'is-error' : ''}`}
                    value={form.category_id}
                    onChange={handleFormChange}
                  >
                    <option value="">-- Pilih Kategori --</option>
                    {categories.map((c) => (
                      <option key={c.id} value={c.id}>
                        {c.name}
                      </option>
                    ))}
                  </select>
                  {formErrors.category_id && (
                    <span className="form-error">{formErrors.category_id}</span>
                  )}
                </div>

                <div className="form-group">
                  <label className="form-label">
                    Kode Produk <span className="required">*</span>
                  </label>
                  <input
                    type="text"
                    name="code"
                    className={`form-control ${formErrors.code ? 'is-error' : ''}`}
                    placeholder="Contoh: OLI-001"
                    value={form.code}
                    onChange={handleFormChange}
                  />
                  {formErrors.code && (
                    <span className="form-error">{formErrors.code}</span>
                  )}
                </div>
              </div>

              <div className="form-group">
                <label className="form-label">
                  Nama Produk <span className="required">*</span>
                </label>
                <input
                  type="text"
                  name="name"
                  className={`form-control ${formErrors.name ? 'is-error' : ''}`}
                  placeholder="Nama lengkap produk"
                  value={form.name}
                  onChange={handleFormChange}
                />
                {formErrors.name && (
                  <span className="form-error">{formErrors.name}</span>
                )}
              </div>

              <div className="form-group">
                <label className="form-label">Deskripsi</label>
                <textarea
                  name="description"
                  className="form-control"
                  placeholder="Deskripsi singkat produk (opsional)"
                  rows={3}
                  value={form.description}
                  onChange={handleFormChange}
                />
              </div>

              <div className="form-row">
                <div className="form-group">
                  <label className="form-label">
                    Harga (Rp) <span className="required">*</span>
                  </label>
                  <input
                    type="number"
                    name="price"
                    className={`form-control ${formErrors.price ? 'is-error' : ''}`}
                    placeholder="0"
                    min="0"
                    value={form.price}
                    onChange={handleFormChange}
                  />
                  {formErrors.price && (
                    <span className="form-error">{formErrors.price}</span>
                  )}
                </div>

                <div className="form-group">
                  <label className="form-label">
                    Stok <span className="required">*</span>
                  </label>
                  <input
                    type="number"
                    name="stock"
                    className={`form-control ${formErrors.stock ? 'is-error' : ''}`}
                    placeholder="0"
                    min="0"
                    value={form.stock}
                    onChange={handleFormChange}
                  />
                  {formErrors.stock && (
                    <span className="form-error">{formErrors.stock}</span>
                  )}
                </div>

                <div className="form-group">
                  <label className="form-label">Satuan</label>
                  <select
                    name="unit"
                    className="form-control"
                    value={form.unit}
                    onChange={handleFormChange}
                  >
                    <option value="pcs">pcs</option>
                    <option value="botol">botol</option>
                    <option value="set">set</option>
                    <option value="liter">liter</option>
                    <option value="kg">kg</option>
                    <option value="box">box</option>
                    <option value="roll">roll</option>
                  </select>
                </div>
              </div>
            </div>

            <div className="modal-footer">
              <button className="btn btn-outline" onClick={closeModal} disabled={formLoading}>
                Batal
              </button>
              <button
                className="btn btn-primary"
                onClick={handleSubmit}
                disabled={formLoading}
              >
                {formLoading
                  ? 'Menyimpan...'
                  : modalMode === 'add'
                  ? 'Simpan Produk'
                  : 'Perbarui Produk'}
              </button>
            </div>
          </div>
        </div>
      )}

      {/* Modal Konfirmasi Hapus */}
      {showDeleteConfirm && (
        <div className="modal-overlay" onClick={() => setShowDeleteConfirm(false)}>
          <div className="modal modal-sm" onClick={(e) => e.stopPropagation()}>
            <div className="modal-header modal-header-danger">
              <h3 className="modal-title">Konfirmasi Hapus</h3>
              <button className="modal-close" onClick={() => setShowDeleteConfirm(false)}>×</button>
            </div>
            <div className="modal-body">
              <div className="delete-icon">🗑️</div>
              <p className="delete-msg">
                Yakin ingin menghapus produk <strong>"{deleteTarget?.name}"</strong>?
              </p>
              <p className="delete-warn">Tindakan ini tidak dapat dibatalkan.</p>
            </div>
            <div className="modal-footer">
              <button className="btn btn-outline" onClick={() => setShowDeleteConfirm(false)}>
                Batal
              </button>
              <button className="btn btn-danger" onClick={handleDelete}>
                Ya, Hapus
              </button>
            </div>
          </div>
        </div>
      )}
    </div>
  )
}

export default App