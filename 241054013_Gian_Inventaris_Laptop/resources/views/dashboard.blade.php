@extends('layouts.app')

@section('content')

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <h3 class="fw-bold mb-1">
                    Dashboard Inventaris Laptop
                </h3>

                <p class="text-muted mb-0">
                    Selamat datang Admin.
                    Pantau seluruh inventaris laptop dari satu dashboard.
                </p>

            </div>

            <div class="text-end">

                <small class="text-muted">
                    Waktu Saat Ini
                </small>

                <h5 id="jamSekarang"
                    class="mb-0 fw-bold">
                </h5>

            </div>

        </div>

    </div>

</div>

<div class="d-flex gap-4 align-items-start">

    <div class="card border flex-grow-1 p-4">

        <p class="text-muted small mb-3">
            Gambaran Kondisi Laptop saat ini
        </p>

        <canvas id="donutChart" height="220"></canvas>

    </div>

    <div
        style="
        width:220px;
        flex-shrink:0;
        display:flex;
        flex-direction:column;
        gap:12px;">

        <div class="card border p-3">

            <p
                class="text-muted"
                style="
                font-size:11px;
                text-transform:uppercase;
                letter-spacing:.06em;
                margin-bottom:4px;">

                Total Laptop

            </p>

            <p
                class="fw-semibold mb-0"
                style="font-size:30px;">

                {{ $totalLaptop }}

            </p>

            <p class="text-muted small mb-0">

                unit terdaftar

            </p>

        </div>

        <div
            class="card border p-3"
            id="legendBox">

        </div>

    </div>

</div>

<br>

<div class="card border shadow-sm">

    <div class="card-body">

        <h5 class="mb-4">
            Progres Kondisi Laptop
        </h5>

        <p class="mb-1">
            Kondisi Baik
        </p>

        <div class="progress mb-3">

            <div
                class="progress-bar bg-success"
                style="width:
                {{ $totalLaptop > 0 ? ($kondisiBaik/$totalLaptop)*100 : 0 }}%">

                {{ $kondisiBaik }}

            </div>

        </div>

        <p class="mb-1">
            Rusak Ringan
        </p>

        <div class="progress mb-3">

            <div
                class="progress-bar bg-warning"
                style="width:
                {{ $totalLaptop > 0 ? ($rusakRingan/$totalLaptop)*100 : 0 }}%">

                {{ $rusakRingan }}

            </div>

        </div>

        <p class="mb-1">
            Rusak Berat
        </p>

        <div class="progress">

            <div
                class="progress-bar bg-danger"
                style="width:
                {{ $totalLaptop > 0 ? ($rusakBerat/$totalLaptop)*100 : 0 }}%">

                {{ $rusakBerat }}

            </div>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>

const data = {

    labels: [
        'Kondisi Baik',
        'Rusak Ringan',
        'Rusak Berat'
    ],

    values: [
        {{ $kondisiBaik }},
        {{ $rusakRingan }},
        {{ $rusakBerat }}
    ],

    colors: [
        '#22c55e',
        '#f59e0b',
        '#ef4444'
    ]
};

const total =
    data.values.reduce(
        (a,b) => a+b,
        0
    );

const box =
document.getElementById(
    'legendBox'
);

data.labels.forEach((label, i) => {

    const pct =
        total > 0
        ? Math.round(
            data.values[i]
            / total * 100
          )
        : 0;

    box.innerHTML += `
        <div style="
            display:flex;
            align-items:center;
            gap:8px;
            font-size:13px;
            margin-bottom:8px;">

            <span style="
                width:10px;
                height:10px;
                border-radius:50%;
                background:${data.colors[i]};
                flex-shrink:0">
            </span>

            <span class="text-secondary">
                ${label}
            </span>

            <span class="ms-auto fw-semibold">
                ${data.values[i]}
            </span>

            <span class="text-muted"
                  style="font-size:11px">

                (${pct}%)

            </span>

        </div>`;
});

new Chart(
    document.getElementById(
        'donutChart'
    ),
{
    type: 'doughnut',

    data: {

        labels: data.labels,

        datasets: [{

            data: data.values,

            backgroundColor:
                data.colors,

            borderWidth: 2,

            borderColor:
                'transparent'

        }]
    },

    options: {

        cutout: '65%',

        plugins: {

            legend: {
                display: false
            },

            tooltip: {

                callbacks: {

                    label: ctx =>
                        ` ${ctx.label}: ${ctx.parsed} unit`
                }
            }
        }
    }
});

</script>

<script>

function updateJam()
{
    const sekarang = new Date();

    document
        .getElementById(
            'jamSekarang'
        )
        .innerHTML =
        sekarang.toLocaleString(
            'id-ID'
        );
}

setInterval(
    updateJam,
    1000
);

updateJam();

</script>

@endsection