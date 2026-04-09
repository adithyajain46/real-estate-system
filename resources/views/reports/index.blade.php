@extends('layouts.app')
@section('title', 'Reports & Analytics')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<div class="row g-4">
    <!-- Properties by Type -->
    <div class="col-md-6">
        <div class="card p-4">
            <h6 class="fw-semibold mb-3">Properties by Type</h6>
            <canvas id="typeChart" height="250"></canvas>
        </div>
    </div>

    <!-- Properties by Status -->
    <div class="col-md-6">
        <div class="card p-4">
            <h6 class="fw-semibold mb-3">Properties by Status</h6>
            <canvas id="statusChart" height="250"></canvas>
        </div>
    </div>

    <!-- Clients by Type -->
    <div class="col-md-6">
        <div class="card p-4">
            <h6 class="fw-semibold mb-3">Clients by Type</h6>
            <canvas id="clientChart" height="250"></canvas>
        </div>
    </div>

    <!-- Summary Table -->
    <div class="col-md-6">
        <div class="card p-4">
            <h6 class="fw-semibold mb-3">Property Value by Type</h6>
            <table class="table">
                <thead>
                    <tr><th>Type</th><th>Count</th><th>Total Value (₹)</th></tr>
                </thead>
                <tbody>
                    @foreach($byType as $row)
                    <tr>
                        <td><span class="badge bg-primary">{{ ucfirst($row->type) }}</span></td>
                        <td>{{ $row->count }}</td>
                        <td>{{ number_format($row->total_value) }}</td>
                    </tr>
                    @endforeach
                    @if($byType->isEmpty())
                    <tr><td colspan="3" class="text-center text-muted">No data yet</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const typeLabels  = @json($byType->pluck('type')->map(fn($t) => ucfirst($t)));
const typeCounts  = @json($byType->pluck('count'));
const statLabels  = @json($byStatus->pluck('status')->map(fn($s) => ucfirst($s)));
const statCounts  = @json($byStatus->pluck('count'));
const clientLabels = @json($clientByType->pluck('type')->map(fn($t) => ucfirst($t)));
const clientCounts = @json($clientByType->pluck('count'));

new Chart(document.getElementById('typeChart'), {
    type: 'bar',
    data: {
        labels: typeLabels,
        datasets: [{ label: 'Properties', data: typeCounts,
            backgroundColor: ['#4299e1','#48bb78','#ed8936','#805ad5'], borderRadius: 6 }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});

new Chart(document.getElementById('statusChart'), {
    type: 'pie',
    data: {
        labels: statLabels,
        datasets: [{ data: statCounts, backgroundColor: ['#48bb78','#fc8181','#4299e1'], borderWidth: 0 }]
    },
    options: { plugins: { legend: { position: 'bottom' } } }
});

new Chart(document.getElementById('clientChart'), {
    type: 'bar',
    data: {
        labels: clientLabels,
        datasets: [{ label: 'Clients', data: clientCounts,
            backgroundColor: ['#2c5282','#ed8936','#805ad5'], borderRadius: 6 }]
    },
    options: { plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
});
</script>
@endsection
