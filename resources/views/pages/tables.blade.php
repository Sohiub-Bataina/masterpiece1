<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="custom-items"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Custom Items"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12 mb-5">
                    <div class="card">
                        <div class="card-header p-3 d-flex justify-content-between align-items-center">
                            <h3>Custom Items</h3>
                            <!-- Add Custom Item Button -->
                            <a href="{{ route('items.create') }}" class="btn btn-primary">
                                <i class="material-icons">add</i> Add Custom Item
                            </a>
                        </div>
                        <div class="card-body" style="padding: 0.5rem;">
                            <div class="table-responsive">
                                <table class="table align-items-center" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item Name</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Vehicle Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Storage Location</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Approval Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($customItems as $item)
                                            <tr>
                                                <td>{{ $item->item_name }}</td>
                                                <td class="text-center">{{ $item->category->category_name ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $item->vehicle_status }}</td>
                                                <td class="text-center">{{ $item->storage_location }}</td>
                                                <td class="text-center">
                                                    <span class="badge 
                                                        {{ $item->manager_approval == 'pending' ? 'bg-gradient-warning' : '' }} 
                                                        {{ $item->manager_approval == 'approved' ? 'bg-gradient-success' : '' }} 
                                                        {{ $item->manager_approval == 'rejected' ? 'bg-gradient-danger' : '' }}">
                                                        {{ $item->manager_approval }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <img src="{{ asset('assets/item_images/' . $item->image_url) }}" alt="Item Image" class="avatar avatar-sm me-2">
                                                </td>
                                                <td class="text-center">
                                                    <!-- View Details Button -->
                                                    <button type="button" class="btn btn-info btn-link" onclick="viewDetails({{ $item->id }})">
                                                        <i class="material-icons">visibility</i>
                                                    </button>
                                                    <!-- Edit Button -->
                                                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-success btn-link">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <!-- Delete Button -->
                                                    <button type="button" class="btn btn-danger btn-link" onclick="confirmDelete({{ $item->id }})">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                    <form id="delete-form-{{ $item->id }}" action="{{ route('items.destroy', $item->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $customItems->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // حذف العنصر
    function confirmDelete(itemId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${itemId}`).submit();
            }
        });
    }

    // عرض التفاصيل
    function viewDetails(itemId) {
        const item = @json($customItems->keyBy('id'));
        const details = item[itemId];

        if (details) {
            let detailsHtml = `
                <p><strong>Created At:</strong> ${details.created_at}</p>
                <p><strong>Quantity:</strong> ${details.quantity}</p>
                <p><strong>Vehicle Status:</strong> ${details.vehicle_status}</p>
                <p><strong>Storage Location:</strong> ${details.storage_location}</p>
            `;

            if (details.manager_approval === 'rejected') {
                detailsHtml += `<p><strong>Rejection Reason:</strong> ${details.rejection_reason}</p>`;
            }

            Swal.fire({
                title: 'Item Details',
                html: detailsHtml,
                icon: 'info',
                confirmButtonText: 'Close'
            });
        } else {
            Swal.fire({
                title: 'Error!',
                text: 'Item details not found.',
                icon: 'error',
                confirmButtonText: 'Close'
            });
        }
    }
</script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
        });
    </script>
@endif
