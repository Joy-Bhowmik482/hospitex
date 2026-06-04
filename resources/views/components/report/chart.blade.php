<!-- Chart Component -->
<div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
    <h3 class="text-lg font-semibold text-slate-900 mb-6">{{ $title }}</h3>
    <div style="position: relative; height: 400px; width: 100%;">
        <canvas id="chart-{{ $chartId }}" data-type="{{ $type ?? 'line' }}"></canvas>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const canvas = document.getElementById('chart-{{ $chartId }}');
        const data = {!! json_encode($data) !!};
        const type = canvas.getAttribute('data-type');

        if (typeof Chart !== 'undefined') {
            new Chart(canvas, {
                type: type,
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)',
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                            }
                        }
                    }
                }
            });
        }
    });
</script>
