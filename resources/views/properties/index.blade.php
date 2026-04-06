@extends('layouts.app')
@section('title', 'Properties')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h5 class="fw-semibold mb-0">All Properties</h5>
    <a href="{{ route('properties.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-1"></i> Add Property
    </a>
</div>

<!-- Filters -->
<div class="card p-3 mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5">
            <input type="text" name="search" class="form-control" placeholder="Search by title or location..."
                   value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="available" {{ request('status')=='available'?'selected':'' }}>Available</option>
                <option value="sold"      {{ request('status')=='sold'?'selected':'' }}>Sold</option>
                <option value="rented"    {{ request('status')=='rented'?'selected':'' }}>Rented</option>
            </select>
        </div>
        <div class="col-md-2">
            <select name="type" class="form-select">
                <option value="">All Types</option>
                <option value="apartment"  {{ request('type')=='apartment'?'selected':'' }}>Apartment</option>
                <option value="villa"      {{ request('type')=='villa'?'selected':'' }}>Villa</option>
                <option value="plot"       {{ request('type')=='plot'?'selected':'' }}>Plot</option>
                <option value="commercial" {{ request('type')=='commercial'?'selected':'' }}>Commercial</option>
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                <i class="bi bi-search me-1"></i> Filter
            </button>
        </div>
    </form>
</div>

<!-- Table -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Price (₹)</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($properties as $property)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td class="fw-semibold">{{ $property->title }}</td>
                    <td><span class="badge bg-secondary">{{ ucfirst($property->type) }}</span></td>
                    <td><i class="bi bi-geo-alt text-muted me-1"></i>{{ $property->location }}</td>
                    <td>₹ {{ number_format($property->price) }}</td>
                    <td>
                        <span class="badge badge-{{ $property->status }}">
                            {{ ucfirst($property->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('properties.show', $property) }}" class="btn btn-sm btn-outline-info">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('properties.edit', $property) }}" class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('properties.destroy', $property) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Are you sure?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-muted">
                        <i class="bi bi-house-door fs-2 d-block mb-2"></i>
                        No properties found. <a href="{{ route('properties.create') }}">Add one now</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="card-footer bg-transparent">
        {{ $properties->withQueryString()->links() }}
    </div>
</div>
@endsection
