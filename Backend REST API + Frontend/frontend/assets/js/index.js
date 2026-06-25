let currentPage = 1;
let currentSearch = '';

function loadData(page = 1, search = '') {

    currentPage = page;

    fetch(
        `../backend/index.php?page=${page}&limit=5&search=${search}`
    )
    .then(response => response.json())
    .then(result => {

        let html = '';

        result.data.forEach(item => {

            html += `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.nip}</td>
                    <td>${item.nama}</td>
                    <td>${item.jabatan}</td>
                    <td>${item.departemen}</td>
                    <td>${item.tanggal_masuk}</td>

                    <td>

                        <a
                            href="edit.php?id=${item.id}"
                            class="btn btn-warning btn-sm"
                        >
                            Edit
                        </a>

                        <button
                            class="btn btn-danger btn-sm"
                            onclick="hapusData(${item.id})"
                        >
                            Hapus
                        </button>

                    </td>

                </tr>
            `;

        });

        document.getElementById(
            'tableBody'
        ).innerHTML = html;

        let paging = '';

        for (
            let i = 1;
            i <= result.pagination.total_pages;
            i++
        ) {

            paging += `
                <button
                    class="pagination-btn btn me-1 ${
                        i == page
                        ? 'btn-primary'
                        : 'btn-secondary opacity-50'
                    }"
                    onclick="loadData(${i}, '${search}')"
                >
                    ${i}
                </button>
            `;
        }

        document.getElementById(
            'pagination'
        ).innerHTML = paging;

    });
}

function hapusData(id){

    if(
        confirm(
            'Yakin ingin menghapus data ini?'
        )
    ){

        fetch(
            `../backend/delete.php?id=${id}`,
            {
                method:'DELETE'
            }
        )
        .then(response => response.json())
        .then(result => {

            alert(result.message);

            loadData(
                currentPage,
                currentSearch
            );

        });
    }
}

document
.getElementById('search')
.addEventListener('keyup', function(){

    currentSearch = this.value;

    loadData(
        1,
        currentSearch
    );

});

loadData();
