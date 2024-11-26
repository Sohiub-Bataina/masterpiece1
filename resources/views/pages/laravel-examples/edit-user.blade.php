<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="text-center">Edit User</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->full_name) }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="residence" class="form-label">Residence</label>
                        <input type="text" id="residence" name="residence" value="{{ old('residence', $user->residence) }}" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select id="role" name="role" class="form-select">
                            <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
