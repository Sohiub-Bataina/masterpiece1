@extends('user-side.components.app')

@section('content')
<main class="main-container">
    <div class="profile-card">
        <div class="profile-header"></div>
        <div class="profile-info">
            <h1 class="section-title">Edit Profile</h1>

            <!-- عرض الأخطاء -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- عرض رسالة النجاح -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- أزرار التبويب -->
            <div class="tab-buttons">
                <button type="button" class="tab-button active" onclick="showTab('personal')">
                    <i class="fa-solid fa-user"></i>
                    Personal Information
                </button>
                <button type="button" class="tab-button" onclick="showTab('password')">
                    <i class="fa-solid fa-lock"></i>
                    Change Password
                </button>
            </div>

            <!-- نموذج المعلومات الشخصية -->
            <form id="personal-form" action="{{ route('user.profile.update') }}" method="POST" class="edit-form">
                @csrf
                <div class="form-section" id="personal-section">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input type="text" name="full_name" id="full_name" class="form-input" value="{{ old('full_name', $user->full_name) }}">
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" name="phone_number" id="phone_number" class="form-input" value="{{ old('phone_number', $user->phone_number) }}">
                    </div>

                    <div class="form-group">
                        <label for="residence">Residence</label>
                        <input type="text" name="residence" id="residence" class="form-input" value="{{ old('residence', $user->residence) }}">
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select name="gender" id="gender" class="form-input">
                            <option value="" disabled selected>Choose Gender</option>
                            <option value="male" {{ $user->gender === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $user->gender === 'female' ? 'selected' : '' }}>Female</option>
                        </select>
                    </div>
                </div>

                <div class="form-section hidden" id="password-section">
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" name="current_password" id="current_password" class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" name="password" id="password" class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-input">
                    </div>
                </div>

                <div class="button-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i>
                        Save Changes
                    </button>
                    <a href="{{ route('user.profile') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-times"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
function showTab(tabName) {
    // تحديث الأزرار النشطة
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    event.currentTarget.classList.add('active');

    // إخفاء/إظهار الأقسام
    document.querySelectorAll('.form-section').forEach(section => {
        section.classList.add('hidden');
    });
    document.getElementById(tabName + '-section').classList.remove('hidden');
}
</script>

<style>
:root {
    --primary-color: #2563eb;
    --secondary-color: #3b82f6;
    --accent-color: #1d4ed8;
    --background-color: #f3f4f6;
    --card-background: #ffffff;
    --text-primary: #1f2937;
    --text-secondary: #6b7280;
    --border-radius: 12px;
    --transition-speed: 0.3s;
}

.profile-card {
    background-color: var(--card-background);
    border-radius: var(--border-radius);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    margin: 2rem auto;
    max-width: 800px;
}

.profile-header {
    background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
    height: 120px;
}

.profile-info {
    padding: 2rem;
}

.section-title {
    font-size: 1.875rem;
    font-weight: bold;
    color: var(--text-primary);
    margin-bottom: 2rem;
    text-align: center;
}

/* Tab Buttons */
.tab-buttons {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    justify-content: center;
}

.tab-button {
    padding: 0.75rem 1.5rem;
    border-radius: var(--border-radius);
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background-color: var(--background-color);
    color: var(--text-secondary);
    border: none;
    cursor: pointer;
    transition: all var(--transition-speed);
}

.tab-button.active {
    background-color: var(--primary-color);
    color: white;
}

.tab-button:hover:not(.active) {
    background-color: #e5e7eb;
}

/* Form Styles */
.edit-form {
    max-width: 600px;
    margin: 0 auto;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.5rem;
}

.form-input {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #e5e7eb;
    border-radius: var(--border-radius);
    background-color: white;
    transition: border-color var(--transition-speed);
}

.form-input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

/* Button Group */
.button-group {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
}

.btn {
    padding: 0.75rem 1.5rem;
    border-radius: var(--border-radius);
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all var(--transition-speed);
    cursor: pointer;
    border: none;
    text-decoration: none;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background-color: var(--accent-color);
}

.btn-secondary {
    background-color: var(--background-color);
    color: var(--text-primary);
}

.btn-secondary:hover {
    background-color: #e5e7eb;
}

/* Alert Styles */
.alert {
    padding: 1rem;
    border-radius: var(--border-radius);
    margin-bottom: 1.5rem;
}

.alert-danger {
    background-color: #fef2f2;
    border: 1px solid #fee2e2;
    color: #dc2626;
}

.alert-success {
    background-color: #ecfdf5;
    border: 1px solid #d1fae5;
    color: #059669;
}

.hidden {
    display: none;
}

/* Responsive Design */
@media (max-width: 640px) {
    .profile-info {
        padding: 1.5rem;
    }

    .tab-buttons {
        flex-direction: column;
    }

    .button-group {
        flex-direction: column;
    }

    .btn {
        width: 100%;
        justify-content: center;
    }
}
</style>
@endsection
