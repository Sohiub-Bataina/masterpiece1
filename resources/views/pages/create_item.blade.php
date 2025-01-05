<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="create-item"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Create Custom Item"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-3">
                            <h3>Create Custom Item</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <!-- Item Name -->
                                <div class="mb-3">
                                    <label for="item_name" class="form-label">Item Name</label>
                                    <input type="text" name="item_name" id="item_name" class="form-control @error('item_name') is-invalid @enderror" value="{{ old('item_name') }}" required>
                                    @error('item_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Item Description -->
                                <div class="mb-3">
                                    <label for="item_description" class="form-label">Item Description</label>
                                    <textarea name="item_description" id="item_description" class="form-control @error('item_description') is-invalid @enderror" rows="3">{{ old('item_description') }}</textarea>
                                    @error('item_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Brand -->
                                <div class="mb-3">
                                    <label for="brand_id" class="form-label">Brand</label>
                                    <select name="brand_id" id="brand_id" class="form-select @error('brand_id') is-invalid @enderror" required>
                                        <option value="">Select Brand</option>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->brand_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Vehicle Status -->
                                <div class="mb-3">
                                    <label for="vehicle_status" class="form-label">Vehicle Status</label>
                                    <select name="vehicle_status" id="vehicle_status" class="form-select @error('vehicle_status') is-invalid @enderror" required>
                                        <option value="drivable" {{ old('vehicle_status') == 'drivable' ? 'selected' : '' }}>Drivable</option>
                                        <option value="non_drivable" {{ old('vehicle_status') == 'non_drivable' ? 'selected' : '' }}>Non-Drivable</option>
                                    </select>
                                    @error('vehicle_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Storage Location -->
                                <div class="mb-3">
                                    <label for="storage_location" class="form-label">Storage Location</label>
                                    <select name="storage_location" id="storage_location" class="form-select @error('storage_location') is-invalid @enderror" required>
                                        <option value="Amman Customs" {{ old('storage_location') == 'Amman Customs' ? 'selected' : '' }}>Amman Customs</option>
                                        <option value="Zarqa Free Zone" {{ old('storage_location') == 'Zarqa Free Zone' ? 'selected' : '' }}>Zarqa Free Zone</option>
                                        <option value="Aqaba" {{ old('storage_location') == 'Aqaba' ? 'selected' : '' }}>Aqaba</option>
                                    </select>
                                    @error('storage_location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Item Images (Multiple Images) -->
                                <div class="mb-3" id="image-container">
                                    <label for="images" class="form-label">Item Images</label>
                                    <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror">
                                    <button type="button" class="btn btn-secondary mt-2" id="add-image-btn">Add Another Image</button>
                                    @error('images')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary">Save Item</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<script>
    document.getElementById('add-image-btn').addEventListener('click', function() {
        const container = document.getElementById('image-container');
        const newInput = document.createElement('input');
        newInput.type = 'file';
        newInput.name = 'images[]';
        newInput.classList.add('form-control', 'mt-2');
        container.insertBefore(newInput, this);
    });
</script>
