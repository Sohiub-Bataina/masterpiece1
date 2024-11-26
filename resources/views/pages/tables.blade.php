<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="custom-items"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Custom Items"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card my-4">
                        <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                            <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                                <h6 class="text-white text-capitalize ps-3">Custom Items</h6>
                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="table-responsive p-0">
                                <table class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item Name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Approval Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($customItems as $item)
                                            <tr>
                                                <td>{{ $item->item_name }}</td>
                                                <td>{{ Str::limit($item->item_description, 50) }}</td>
                                                <td class="text-center">{{ $item->category->category_name ?? 'N/A' }}</td>
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
                                                <button type="button" class="btn btn-info btn-link" onclick="viewDetails({{ $item->id }})">
                                                        <i class="material-icons">visibility</i>
                                                    </button>
                                                    <a href="{{ route('items.edit', $item->id) }}" class="btn btn-success btn-link">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    
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
                            <div class="d-flex justify-content-center mt-3">
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
        const item = @json($customItems->keyBy('id')); // تحويل البيانات إلى JSON
        const details = item[itemId];

        if (details) {
            let detailsHtml = `
                <p><strong>Created At:</strong> ${details.created_at}</p>
                <p><strong>Quantity:</strong> ${details.quantity}</p>
                <p><strong>Base Price:</strong> ${details.base_price}</p>
            `;

            // إذا كانت الحالة 'rejected' نعرض سبب الرفض
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
