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
                        <label for="base_price" class="form-label">Base Price</label>
                        <input type="text" id="base_price" name="base_price" value="{{ old('base_price', $customItem->base_price) }}" class="form-control" required>
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
