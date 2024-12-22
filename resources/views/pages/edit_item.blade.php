<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="text-center">Edit Item</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('items.update', $customItem->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name</label>
                        <input type="text" id="item_name" name="item_name" value="{{ old('item_name', $customItem->item_name) }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $customItem->quantity) }}" class="form-control" required>
                    </div>

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

                    <!-- Dropdown for vehicle_status -->
                    <div class="mb-3">
                        <label for="vehicle_status" class="form-label">Vehicle Status</label>
                        <select id="vehicle_status" name="vehicle_status" class="form-select" required>
                            <option value="drivable" {{ old('vehicle_status', $customItem->vehicle_status) == 'drivable' ? 'selected' : '' }}>Drivable</option>
                            <option value="non_drivable" {{ old('vehicle_status', $customItem->vehicle_status) == 'non_drivable' ? 'selected' : '' }}>Non-Drivable</option>
                        </select>
                    </div>

                    <!-- Dropdown for storage_location -->
                    <div class="mb-3">
                        <label for="storage_location" class="form-label">Storage Location</label>
                        <select id="storage_location" name="storage_location" class="form-select" required>
                            <option value="Amman Customs" {{ old('storage_location', $customItem->storage_location) == 'Amman Customs' ? 'selected' : '' }}>Amman Customs</option>
                            <option value="Zarqa Free Zone" {{ old('storage_location', $customItem->storage_location) == 'Zarqa Free Zone' ? 'selected' : '' }}>Zarqa Free Zone</option>
                            <option value="Aqaba" {{ old('storage_location', $customItem->storage_location) == 'Aqaba' ? 'selected' : '' }}>Aqaba</option>
                        </select>
                    </div>

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

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const approvalSelect = document.getElementById('manager_approval');
            const rejectionReasonContainer = document.getElementById('rejection_reason_container');

            approvalSelect.addEventListener('change', function () {
                if (approvalSelect.value === 'rejected') {
                    rejectionReasonContainer.classList.remove('d-none');
                } else {
                    rejectionReasonContainer.classList.add('d-none');
                }
            });

            // Trigger change event on page load to handle default selection
            approvalSelect.dispatchEvent(new Event('change'));
        });
    </script>
</x-layout>
