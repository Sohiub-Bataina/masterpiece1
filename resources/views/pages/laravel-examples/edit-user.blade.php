<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <div class="container">
        <h2>Edit User</h2>
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phone_number">Phone Number</label>
                <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="residence">Residence</label>
                <input type="text" id="residence" name="residence" value="{{ old('residence', $user->residence) }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="role">Role</label>
                <select id="role" name="role" class="form-control">
                    <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer</option>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="superAdmin" {{ $user->role == 'superAdmin' ? 'selected' : '' }}>Super Admin</option>
                </select>
            </div>

            <div class="form-group">
                <label for="is_deleted">Is Deleted?</label>
                <select id="is_deleted" name="is_deleted" class="form-control">
                    <option value="0" {{ $user->is_deleted == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $user->is_deleted == 1 ? 'selected' : '' }}>Yes</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update User</button>
            </div>
        </form>
    </div>
</x-layout>
