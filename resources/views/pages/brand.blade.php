<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="brands"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Brands"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <!-- Brands Section -->
                <div class="col-12 mb-5">
                    <div class="card">
                        <div class="card-header p-3 d-flex justify-content-between align-items-center">
                            <h3>Brands</h3>
                            <!-- Add Brand Button -->
                            <a href="{{ route('brand.create') }}" class="btn btn-primary">
                                <i class="material-icons">add</i> Add Brand
                            </a>
                        </div>
                        <div class="card-body" style="padding: 0.5rem;">
                            <div class="table-responsive">
                                <table class="table align-items-center" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ID</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Brand Name</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Brand Image</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($brands as $brand)
                                            <tr>
                                                <td class="text-center">{{ $brand->id }}</td>
                                                <td class="text-center">{{ $brand->brand_name }}</td>
                                                <td class="text-center">
                                                    @if($brand->brand_image)
                                                        <img src="{{ asset('storage/' . $brand->brand_image) }}" alt="Brand Image" width="50">
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="text-center">{{ $brand->category->category_name ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    <!-- View Details Button -->
                                                    <a href="javascript:void(0)" class="btn btn-info btn-link" onclick="showViewDialog('{{ $brand->id }}', '{{ $brand->brand_name }}', '{{ $brand->brand_image }}', '{{ $brand->category->category_name ?? 'N/A' }}')">
                                                        <i class="material-icons">visibility</i>
                                                    </a>

                                                    <!-- Edit Button -->
                                                    <a href="{{ route('brand.edit', $brand->id) }}" class="btn btn-success btn-link">
                                                        <i class="material-icons">edit</i>
                                                    </a>

                                                    <!-- Delete Button -->
                                                    <button type="button" class="btn btn-danger btn-link" onclick="confirmDelete({{ $brand->id }})">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                    <form id="delete-form-{{ $brand->id }}" action="{{ route('brand.destroy', $brand->id) }}" method="POST" style="display: none;">
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
                                {{ $brands->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(brandId) {
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
                document.getElementById(`delete-form-${brandId}`).submit();
            }
        });
    }

    function showViewDialog(id, name, image, category) {
        Swal.fire({
            title: 'Brand Details',
            html: `
                <p><strong>Brand Name:</strong> ${name}</p>
                <p><strong>Brand Image:</strong> ${image ? '<img src="' + image + '" width="50">' : 'N/A'}</p>
                <p><strong>Category:</strong> ${category}</p>
            `,
            focusConfirm: false,
        });
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
