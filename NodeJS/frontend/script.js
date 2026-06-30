const API_BASE_URL = 'http://localhost:3000';
let table;
let editId = null;

// Initialize on page load
$(document).ready(function() {
    initDataTable();
    loadKategori();
    setupEventListeners();
});

// Initialize DataTable
function initDataTable() {
    table = $('#tabelKategori').DataTable({
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json'
        },
        columnDefs: [
            { width: '5%', targets: 0 },
            { width: '25%', targets: 1 },
            { width: '50%', targets: 2 },
            { width: '20%', targets: 3, orderable: false, searchable: false }
        ],
        pageLength: 10,
        responsive: true
    });
}

// Load all categories
function loadKategori() {
    $.ajax({
        url: `${API_BASE_URL}/categories`,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                populateTable(response.data);
            } else {
                showAlert('error', response.message);
            }
        },
        error: function(err) {
            showAlert('error', 'Gagal memuat data kategori');
            console.error(err);
        }
    });
}

// Populate table with data
function populateTable(data) {
    table.clear().draw();
    if (data.length === 0) {
        table.row.add(['', 'Tidak ada data', '', '']).draw();
        return;
    }
    
    data.forEach(function(item, index) {
        const aksi = `
            <button class="btn btn-sm btn-warning btnEdit" data-id="${item.id}">
                <i class="fas fa-edit"></i> Edit
            </button>
            <button class="btn btn-sm btn-danger btnHapus" data-id="${item.id}" data-name="${item.name}">
                <i class="fas fa-trash"></i> Hapus
            </button>
        `;
        table.row.add([
            index + 1,
            item.name,
            item.description || '-',
            aksi
        ]).draw(false);
    });
    
    // Attach click handlers to dynamically added buttons
    attachButtonHandlers();
}

// Setup event listeners
function setupEventListeners() {
    // Tambah button
    $('#btnTambah').click(function() {
        resetForm();
        editId = null;
        $('#modalTitle').text('Tambah Kategori');
        $('#btnSimpan').text('Simpan');
        new bootstrap.Modal(document.getElementById('modalKategori')).show();
    });

    // Form submit
    $('#formKategori').submit(function(e) {
        e.preventDefault();
        const nama = $('#kategoriNama').val().trim();
        
        if (!nama) {
            $('#errorNama').text('Nama kategori wajib diisi');
            return;
        }
        
        if (editId) {
            updateKategori();
        } else {
            addKategori();
        }
    });
}

// Attach handlers to edit and delete buttons
function attachButtonHandlers() {
    $('.btnEdit').off('click').on('click', function() {
        const id = $(this).data('id');
        editKategoriModal(id);
    });

    $('.btnHapus').off('click').on('click', function() {
        const id = $(this).data('id');
        const name = $(this).data('name');
        showDeleteConfirm(id, name);
    });
}

// Add new category
function addKategori() {
    const data = {
        name: $('#kategoriNama').val(),
        description: $('#kategoriDeskripsi').val()
    };

    $.ajax({
        url: `${API_BASE_URL}/categories`,
        method: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            if (response.status) {
                showAlert('success', response.message);
                bootstrap.Modal.getInstance(document.getElementById('modalKategori')).hide();
                loadKategori();
            } else {
                showAlert('error', response.message);
            }
        },
        error: function(err) {
            showAlert('error', 'Gagal menambah kategori');
            console.error(err);
        }
    });
}

// Show edit modal and load data
function editKategoriModal(id) {
    $.ajax({
        url: `${API_BASE_URL}/categories`,
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status) {
                const kategori = response.data.find(k => k.id == id);
                if (kategori) {
                    editId = id;
                    $('#kategoriId').val(kategori.id);
                    $('#kategoriNama').val(kategori.name);
                    $('#kategoriDeskripsi').val(kategori.description || '');
                    $('#modalTitle').text('Edit Kategori');
                    $('#btnSimpan').text('Update');
                    new bootstrap.Modal(document.getElementById('modalKategori')).show();
                } else {
                    showAlert('error', 'Data kategori tidak ditemukan');
                }
            }
        },
        error: function(err) {
            showAlert('error', 'Gagal memuat detail kategori');
            console.error(err);
        }
    });
}

// Update category
function updateKategori() {
    const data = {
        name: $('#kategoriNama').val(),
        description: $('#kategoriDeskripsi').val()
    };

    $.ajax({
        url: `${API_BASE_URL}/categories/${editId}`,
        method: 'PUT',
        contentType: 'application/json',
        data: JSON.stringify(data),
        success: function(response) {
            if (response.status) {
                showAlert('success', response.message);
                bootstrap.Modal.getInstance(document.getElementById('modalKategori')).hide();
                loadKategori();
            } else {
                showAlert('error', response.message);
            }
        },
        error: function(err) {
            showAlert('error', 'Gagal mengupdate kategori');
            console.error(err);
        }
    });
}

// Show delete confirmation modal
function showDeleteConfirm(id, name) {
    $('#hapusNama').text(name);
    const modal = new bootstrap.Modal(document.getElementById('modalHapus'));
    modal.show();

    $('#btnKonfirmasiHapus').off('click').on('click', function() {
        deleteKategori(id);
        modal.hide();
    });
}

// Delete category
function deleteKategori(id) {
    $.ajax({
        url: `${API_BASE_URL}/categories/${id}`,
        method: 'DELETE',
        success: function(response) {
            if (response.status) {
                showAlert('success', response.message);
                loadKategori();
            } else {
                showAlert('error', response.message);
            }
        },
        error: function(err) {
            showAlert('error', 'Gagal menghapus kategori');
            console.error(err);
        }
    });
}

// Reset form
function resetForm() {
    $('#formKategori')[0].reset();
    $('#errorNama').text('');
    $('#kategoriId').val('');
}

// Show alert
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const icon = type === 'success' ? 'check-circle' : 'exclamation-circle';
    
    const alertHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="fas fa-${icon}"></i> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    $('.container-fluid').prepend(alertHTML);
    
    setTimeout(() => {
        $('.alert').fadeOut(() => {
            $('.alert').remove();
        });
    }, 4000);
}
