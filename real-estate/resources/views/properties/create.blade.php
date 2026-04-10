@extends('layouts.app')
@section('title', isset($property) ? 'Edit Property' : 'Add Property')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card p-4">
            <h6 class="fw-semibold mb-4">
                <i class="bi bi-house-door me-2 text-primary"></i>
                {{ isset($property) ? 'Edit Property' : 'Add New Property' }}
            </h6>

            <form action="{{ isset($property) ? route('properties.update', $property) : route('properties.store') }}"
                  method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($property)) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label fw-semibold">Property Title *</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $property->title ?? '') }}" placeholder="e.g. 3BHK Apartment in Whitefield">
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Property Type *</label>
                        <select name="type" class="form-select @error('type') is-invalid @enderror">
                            @foreach(['apartment','villa','plot','commercial'] as $type)
                            <option value="{{ $type }}" {{ old('type', $property->type ?? '') == $type ? 'selected' : '' }}>
                                {{ ucfirst($type) }}
                            </option>
                            @endforeach
                        </select>
                        @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Status *</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror">
                            @foreach(['available','sold','rented'] as $s)
                            <option value="{{ $s }}" {{ old('status', $property->status ?? '') == $s ? 'selected' : '' }}>
                                {{ ucfirst($s) }}
                            </option>
                            @endforeach
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Price (₹) *</label>
                        <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price', $property->price ?? '') }}" placeholder="e.g. 4500000">
                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Location *</label>
                        <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                               value="{{ old('location', $property->location ?? '') }}" placeholder="e.g. Whitefield, Bengaluru">
                        @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Area (sq ft)</label>
                        <input type="text" name="area_sqft" class="form-control"
                               value="{{ old('area_sqft', $property->area_sqft ?? '') }}" placeholder="e.g. 1200">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Bedrooms</label>
                        <input type="number" name="bedrooms" class="form-control"
                               value="{{ old('bedrooms', $property->bedrooms ?? '') }}" placeholder="e.g. 3">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Bathrooms</label>
                        <input type="number" name="bathrooms" class="form-control"
                               value="{{ old('bathrooms', $property->bathrooms ?? '') }}" placeholder="e.g. 2">
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" class="form-control" rows="3"
                                  placeholder="Describe the property...">{{ old('description', $property->description ?? '') }}</textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Property Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        @if(isset($property) && $property->image)
                        <small class="text-muted">Current image: {{ basename($property->image) }}</small>
                        @endif
                    </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-lg me-1"></i>
                        {{ isset($property) ? 'Update Property' : 'Add Property' }}
                    </button>
                    <a href="{{ route('properties.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
