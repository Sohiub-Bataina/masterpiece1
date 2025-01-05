<!-- resources/views/user-side/pages/user_bids.blade.php -->
@extends('user-side.components.app')

@section('content')
<!-- إضافة بعض التنسيقات الإضافية في نفس ملف الـ Blade أو في ملف CSS منفصل -->
<style>
    .bids-card {
        background-color: var(--card-background);
        border-radius: var(--border-radius);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .bids-header h2 {
        margin: 0;
    }

    .bids-content .table {
        margin-bottom: 0;
        width: 100%;
        border-collapse: collapse;
    }

    .table th:first-child, .table td:first-child {
        padding-left: 2rem; /* مسافة إضافية على الجانب الأيسر فقط */
    }

    .badge {
        padding: 0.5em 1em;
        font-size: 0.875rem;
        border-radius: 9999px;
    }

    .badge.bg-success {
        background-color: #28a745;
        color: white;
    }

    .badge.bg-secondary {
        background-color: #6c757d;
        color: white;
    }

    /* Responsive Table for Smaller Screens */
    @media (max-width: 768px) {
        .table {
            display: block;
            overflow-x: auto;
            white-space: nowrap;
        }

        .table th, .table td {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
        }
    }

    @media (max-width: 576px) {
        .table thead {
            display: none; /* إخفاء رؤوس الأعمدة للشاشات الصغيرة جدًا */
        }

        .table tbody tr {
            display: flex;
            flex-direction: column; /* جعل كل خلية في صف جديد */
            align-items: center; /* توسيط الخلايا أفقياً */
            justify-content: center; /* توسيط الخلايا عمودياً */
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 1rem; /* إضافة مسافة داخلية */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .table tbody td {
            display: flex;
            justify-content: space-between;
            width: 100%; /* التأكد من أن الخلايا تأخذ عرض كامل */
            padding: 0.5rem 1rem;
        }

        .table tbody td::before {
            content: attr(data-label); /* عرض اسم العمود */
            font-weight: bold;
            color: var(--text-secondary);
            flex: 1;
            text-align: right; /* جعل اسم العمود بمحاذاة اليمين */
            margin-right: 1rem;
        }

        .table tbody td:last-child {
            text-align: center; /* محاذاة خاصة بالحالة */
        }
    }
</style>

<main class="main-container">
    <div class="bids-card">
        <div class="bids-header" style="background: linear-gradient(135deg, var(--primary-color), var(--accent-color)); padding: 20px; color: white; text-align: center;">
            <h2>My Bids</h2>
        </div>

        <div class="bids-content" style="padding: 20px;">
            @if($bids->isEmpty())
                <p>You have not placed any bids yet.</p>
            @else
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Auction Title</th>
                                <th>Bid Amount</th>
                                <th>Bid Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bids as $bid)
                                <tr>
                                    <td data-label="Auction Title">
                                        <a href="{{ route('auction-details', $bid->auction->id) }}">
                                            {{ $bid->auction->auction_name }}
                                        </a>
                                    </td>
                                    <td data-label="Bid Amount">${{ number_format($bid->bid_amount, 2) }}</td>
                                    <td data-label="Bid Time">{{ \Carbon\Carbon::parse($bid->bid_time)->format('Y/m/d H:i') }}</td>
                                    <td data-label="Status">
                                        @if($bid->is_winner)
                                            <span class="badge bg-success">Winner</span>
                                        @else
                                            <span class="badge bg-secondary">Not Winner</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <div class="button-group mt-4">
                <a href="{{ route('user.profile') }}" class="btn btn-primary">
                    <i class="fa-solid fa-arrow-left"></i>
                    Back to Profile
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
