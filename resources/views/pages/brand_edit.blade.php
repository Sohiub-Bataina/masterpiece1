<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="brands"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Edit Brand"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12 mb-5">
                    <div class="card">
                        <div class="card-header p-3">
                            <h3>Edit Brand</h3>
                        </div>
                        <div class="card-body" style="padding: 0.5rem;">
                            <form action="{{ route('brand.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="brand_name" class="form-label">Brand Name</label>
                                    <input type="text" class="form-control" id="brand_name" name="brand_name" value="{{ old('brand_name', $brand->brand_name) }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Category</label>
                                    <select class="form-select" id="category_id" name="category_id" required>
                                        <option value="" disabled>Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $brand->category_id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="brand_image" class="form-label">Brand Image</label>
                                    <input type="file" class="form-control" id="brand_image" name="brand_image" accept="image/png, image/jpeg, image/jpg">
                                    @if($brand->brand_image)
                                        <img src="{{ asset('storage/' . $brand->brand_image) }}" alt="Current Image" class="mt-2" width="100">
                                    @endif
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Update Brand</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
