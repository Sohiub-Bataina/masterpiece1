<x-layout>
    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="input-group">
            <label for="name">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required>
        </div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" name="password" required>
        </div>

        <div class="input-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" required>
        </div>

        <button type="submit">Create User</button>
    </form>
</x-layout>
