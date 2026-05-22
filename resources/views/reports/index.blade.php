@extends('layouts.app')

@section('content')
    <div class="mb-10 pb-6 border-b border-zinc-800">
        <h1 class="text-3xl font-bold text-white tracking-wide uppercase">Laporan Keuangan</h1>
        <p class="text-zinc-500 mt-1 text-sm">Analisis Pendapatan Sistem</p>
    </div>

    <!-- GRAFIK PENDAPATAN -->
    <div class="bg-zinc-900/50 border border-zinc-800 rounded-xl p-6">
        <h2 class="text-sm font-bold text-emerald-500 uppercase tracking-widest mb-4">Grafik Pendapatan (7 Hari Terakhir)</h2>
        <div class="relative h-96 w-full">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const labels = @json($chartLabels);
            const data = @json($chartValues);
            const ctx = document.getElementById('revenueChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Pendapatan (Rp)',
                        data: data,
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 3,
                        pointBackgroundColor: '#10b981',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(255,255,255,0.05)' },
                            ticks: {
                                color: '#71717a',
                                callback: function(value) { return 'Rp ' + value.toLocaleString('id-ID'); }
                            }
                        },
                        x: { grid: { display: false }, ticks: { color: '#71717a' } }
                    }
                }
            });
        });
    </script>
@endsection