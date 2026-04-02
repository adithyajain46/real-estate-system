@extends('layouts.app')
@section('title', 'Dashboard')

@section('styles')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<!-- Stat Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="background: linear-gradient(135deg,#2c5282,#4299e1)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small text-white-50 mb-1">Total Properties</div>
                    <div class="number">{{ $totalProperties }}</div>
                </div>
                <div class="icon"><i class="bi bi-house-door"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="background: linear-gradient(135deg,#276749,#48bb78)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small text-white-50 mb-1">Available</div>
                    <div class="number">{{ $availableProps }}</div>
                </div>
                <div class="icon"><i class="bi bi-check-circle"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="background: linear-gradient(135deg,#744210,#ed8936)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small text-white-50 mb-1">Total Clients</div>
                    <div class="number">{{ $totalClients }}</div>
                </div>
                <div class="icon"><i class="bi bi-people"></i></div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="stat-card" style="background: linear-gradient(135deg,#702459,#ed64a6)">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="small text-white-50 mb-1">Portfolio Value</div>
                    <div class="number" style="font-size:1.4rem">₹{{ number_format($totalValue/100000,1) }}L</div>
                </div>
                <div class="icon"><i class="bi bi-currency-rupee"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row g-4 mb-4">
    <div class="col-md-6">
        <div class="card p-4">
            <h6 class="fw-semibold mb-3">Properties by Status</h6>
            <canvas id="statusChart" height="200"></canvas>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-4">
            <h6 class="fw-semibold mb-3">Clients by Type</h6>
            <canvas id="clientChart" height="200"></canvas>
        </div>
    </div>
</div>

<!-- Recent Tables -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="card p-4">
            <div class="d-flex justify-content-between mb-3">
                <h6 class="fw-semibold mb-0">Recent Properties</h6>
                <a href="{{ route('properties.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <table class="table table-sm">
                <thead><tr><th>Title</th><th>Price</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($recentProperties as $p)
                    <tr>
                        <td>{{ Str::limit($p->title, 25) }}</td>
                        <td>₹{{ number_format($p->price) }}</td>
                        <td><span class="badge badge-{{ $p->status }}">{{ ucfirst($p->status) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">No properties yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card p-4">
            <div class="d-flex justify-content-between mb-3">
                <h6 class="fw-semibold mb-0">Recent Clients</h6>
                <a href="{{ route('clients.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <table class="table table-sm">
                <thead><tr><th>Name</th><th>Phone</th><th>Type</th></tr></thead>
                <tbody>
                    @forelse($recentClients as $c)
                    <tr>
                        <td>{{ $c->name }}</td>
                        <td>{{ $c->phone }}</td>
                        <td><span class="badge bg-secondary">{{ ucfirst($c->type) }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center text-muted">No clients yet</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Available', 'Sold', 'Rented'],
        datasets: [{
            data: [{{ $availableProps }}, {{ $soldProps }}, {{ $rentedProps }}],
            backgroundColor: ['#48bb78','#fc8181','#4299e1'],
            borderWidth: 0
        }]
    },
    options: { plugins: { legend: { position: 'bottom' } }, cutout: '65%' }
});
new Chart(document.getElementById('clientChart'), {
    type: 'doughnut',
    data: {
        labels: ['Buyers', 'Sellers', 'Tenants'],
        datasets: [{
            data: [{{ $buyers }}, {{ $sellers }}, {{ $totalClients - $buyers - $sellers }}],
            backgroundColor: ['#2c5282','#ed8936','#805ad5'],
            borderWidth: 0
        }]
    },
    options: { plugins: { legend: { position: 'bottom' } }, cutout: '65%' }
});
</script>
@endsection
