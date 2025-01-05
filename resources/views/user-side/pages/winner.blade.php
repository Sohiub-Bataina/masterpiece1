@extends('user-side.components.app')

@section('content')
<div class="container">
    <h2 class="mt-5">Congratulations, {{ $bid->user->full_name }}!</h2>
    <p>You have won the auction for <strong>{{ $bid->auction->auction_name }}</strong> with a bid of ${{ number_format($bid->bid_amount, 2) }}.</p>
    <!-- يمكنك إضافة المزيد من التفاصيل أو الإجراءات هنا -->
</div>
@endsection
