<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="edit-item"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Edit Item"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-3">
                            <h3>Edit Item</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('items.update', $customItem->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Item Name -->
                                <div class="mb-3">
                                    <label for="item_name" class="form-label">Item Name</label>
                                    <input type="text" id="item_name" name="item_name" value="{{ old('item_name', $customItem->item_name) }}" class="form-control" required>
                                </div>

                                <!-- Category -->
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select id="category_id" name="category_id" class="form-select" required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $customItem->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Brand -->
                                <div class="mb-3">
                                    <label for="brand_id" class="form-label">Brand</label>
                                    <select id="brand_id" name="brand_id" class="form-select" required>
                                        @foreach($brands as $brand)
                                            <option value="{{ $brand->id }}" {{ old('brand_id', $customItem->brand_id) == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->brand_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Vehicle Status -->
                                <div class="mb-3">
                                    <label for="vehicle_status" class="form-label">Vehicle Status</label>
                                    <select id="vehicle_status" name="vehicle_status" class="form-select" required>
                                        <option value="drivable" {{ old('vehicle_status', $customItem->vehicle_status) == 'drivable' ? 'selected' : '' }}>Drivable</option>
                                        <option value="non_drivable" {{ old('vehicle_status', $customItem->vehicle_status) == 'non_drivable' ? 'selected' : '' }}>Non-Drivable</option>
                                    </select>
                                </div>

                                <!-- Storage Location -->
                                <div class="mb-3">
                                    <label for="storage_location" class="form-label">Storage Location</label>
                                    <select id="storage_location" name="storage_location" class="form-select" required>
                                        <option value="Amman Customs" {{ old('storage_location', $customItem->storage_location) == 'Amman Customs' ? 'selected' : '' }}>Amman Customs</option>
                                        <option value="Zarqa Free Zone" {{ old('storage_location', $customItem->storage_location) == 'Zarqa Free Zone' ? 'selected' : '' }}>Zarqa Free Zone</option>
                                        <option value="Aqaba" {{ old('storage_location', $customItem->storage_location) == 'Aqaba' ? 'selected' : '' }}>Aqaba</option>
                                    </select>
                                </div>

                                <!-- Manager Approval -->
                                @if(auth()->user()->role === 'superAdmin')
                                <div class="mb-3">
                                    <label for="manager_approval" class="form-label">Manager Approval</label>
                                    <select id="manager_approval" name="manager_approval" class="form-select" required>
                                        <option value="pending" {{ $customItem->manager_approval == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ $customItem->manager_approval == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ $customItem->manager_approval == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </div>
                                <div class="mb-3 d-none" id="rejection_reason_container">
                                    <label for="rejection_reason" class="form-label">Rejection Reason</label>
                                    <textarea id="rejection_reason" name="rejection_reason" class="form-control">{{ old('rejection_reason', $customItem->rejection_reason) }}</textarea>
                                </div>
                            @endif

                                 <!-- Displaying current images with checkboxes for deletion -->
                    <div class="mb-3">
                        <label for="existing_images" class="form-label">Existing Images</label>
                        <div class="row">
                            @foreach($customItem->images as $image)
                                <div class="col-md-3 mb-3">
                                    <img src="{{ asset($image->image_url) }}" class="img-fluid" alt="item image" style="width: 150px; height: 150px; object-fit: cover;">
                                    <div>
                                        <input type="checkbox" name="delete_images[]" value="{{ $image->id }}"> Delete
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Adding new images -->
                    <div class="mb-3" id="image-container">
                        <label for="images" class="form-label">Add New Images</label>
                        <input type="file" name="images[]" class="form-control @error('images') is-invalid @enderror" multiple>
                        <button type="button" class="btn btn-secondary mt-2" id="add-image-btn">Add Another Image</button>
                        @error('images')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                                <!-- Submit Button -->
                                <div class="d-grid mt-3">
                                    <button type="submit" class="btn btn-primary">Update Item</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Add new image input dynamically
        document.getElementById('add-image-btn').addEventListener('click', function () {
            const newInput = document.createElement('input');
            newInput.type = 'file';
            newInput.name = 'images[]';
            newInput.classList.add('form-control', 'mt-2');
            document.getElementById('image-container').appendChild(newInput);
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
    const managerApproval = document.getElementById('manager_approval');
    const rejectionReasonContainer = document.getElementById('rejection_reason_container');

    // Function to toggle rejection reason visibility
    const toggleRejectionReason = () => {
        if (managerApproval.value === 'rejected') {
            rejectionReasonContainer.classList.remove('d-none');
        } else {
            rejectionReasonContainer.classList.add('d-none');
        }
    };

    // Initial check
    toggleRejectionReason();

    // Listen for changes
    managerApproval.addEventListener('change', toggleRejectionReason);
});

</script>
