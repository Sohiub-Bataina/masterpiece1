<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white">
                <h2 class="text-center">Create New Category</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Category Name -->
                    <div class="mb-3">
                        <label for="category_name" class="form-label">Category Name</label>
                        <input type="text" id="category_name" name="category_name" value="{{ old('category_name') }}" class="form-control" required>
                    </div>

                    <!-- Category Image -->
                    <div class="mb-3">
                        <label for="category_image" class="form-label">Category Image</label>
                        <input type="file" id="category_image" name="category_image" class="form-control" accept="image/png, image/jpeg, image/jpg">
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Create Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
