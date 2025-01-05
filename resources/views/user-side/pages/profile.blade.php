<!-- header.blade.php -->
@extends('user-side.components.app')

<!-- profile.blade.php -->
@section('content')
<main class="main-container">
    <div class="profile-card">
        <div class="profile-header" style="display: flex; justify-content: center; align-items: center; height: 150px; text-align: center; color: white; font-size: 3rem; font-weight: bold; padding-bottom: 10px;">
            Profile
        </div>

        <div class="profile-info">
            <h1 class="user-name">
                {{ $user->full_name }}
                @if($user->role === 'premium')
                    <span class="premium-badge">
                        <i class="fa-solid fa-crown"></i>
                        Premium Member
                    </span>
                @endif
            </h1>

            <div class="stats-grid">
                <div class="stat-card">
                    <i class="fa-solid fa-wallet stat-icon"></i>
                    <div class="stat-label">Insurance Balance</div>
                    <div class="stat-value">{{ $user->insurance_balance }}</div>
                </div>


                <div class="stat-card">
                    <i class="fa-solid fa-calendar-days stat-icon"></i>
                    <div class="stat-label">Member Since</div>
                    <div class="stat-value">{{ $user->created_at->format('Y/m/d') }}</div>
                </div>
            </div>

            <div class="details-section">
                <h2 class="section-title">Contact Information</h2>
                <div class="details-grid">
                    <div class="detail-item">
                        <i class="fa-solid fa-envelope detail-icon"></i>
                        <span>{{ $user->email }}</span>
                    </div>

                    <div class="detail-item">
                        <i class="fa-solid fa-phone detail-icon"></i>
                        <span>{{ $user->phone_number }}</span>
                    </div>

                    <div class="detail-item">
                        <i class="fa-solid fa-venus-mars detail-icon"></i>
                        <span>{{ ucfirst($user->gender) }}</span>
                    </div>

                    <div class="detail-item">
                        <i class="fa-solid fa-location-dot detail-icon"></i>
                        <span>{{ $user->residence }}</span>
                    </div>
                </div>
            </div>

            <div class="button-group">
                <a href="{{ route('user-side.home') }}" class="btn btn-primary">
                    <i class="fa-solid fa-house"></i>
                    Back to Home
                </a>
                <a href="{{ route('user.profile.edit') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Edit Profile
                </a>

            </div>
        </div>
    </div>
</main>
@endsection

@section('footer')
<!-- Footer Section -->
<footer>
  <!-- Footer Content -->
</footer>

@endsection
<!-- styles.css -->
<style>
    /* Root Variables */
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

    /* Global Styles */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Inter', sans-serif;
    }

    body {
        background-color: var(--background-color);
        color: var(--text-primary);
        line-height: 1.6;
    }

    /* Main Content Styles */
    .main-container {
        max-width: 1200px;
        margin: 2rem auto;
        padding: 0 2rem;
    }

    .profile-header {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        height: 150px;
        border-radius: var(--border-radius) var(--border-radius) 0 0;
        position: relative;
    }

    .profile-card {
        background-color: var(--card-background);
        border-radius: var(--border-radius);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .profile-info {
        padding: 2rem;
    }

    .user-name {
        font-size: 2rem;
        font-weight: bold;
        margin-bottom: 1rem;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }

    .stat-card {
        background-color: var(--background-color);
        padding: 1.5rem;
        border-radius: var(--border-radius);
        transition: transform var(--transition-speed);
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-icon {
        font-size: 1.5rem;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .stat-value {
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--text-primary);
    }

    .details-section {
        background-color: var(--background-color);
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-top: 2rem;
    }

    .details-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .detail-icon {
        color: var(--primary-color);
        font-size: 1.25rem;
    }

    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: var(--border-radius);
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all var(--transition-speed);
        cursor: pointer;
    }

    .btn-primary {
        background-color: var(--primary-color);
        color: white;
        border: none;
    }

    .btn-primary:hover {
        background-color: var(--accent-color);
    }

    .btn-secondary {
        background-color: var(--background-color);
        color: var(--text-primary);
        border: none;
    }

    .btn-secondary:hover {
        background-color: #e5e7eb;
    }

    /* Premium Badge */
    .premium-badge {
        background-color: #fef3c7;
        color: #92400e;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.875rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
        margin-left: 1rem;
    }

    /* Section Title */
    .section-title {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 1.5rem;
        color: var(--text-primary);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .profile-info {
            text-align: center;
        }

        .button-group {
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .details-grid {
            grid-template-columns: 1fr;
        }

        .detail-item {
            justify-content: center;
        }
    }
</style>
