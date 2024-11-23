<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="auctions"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Auctions"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="card">
                <div class="card-header p-3">
                    <h3>Auctions</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered align-items-center mb-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Auction Name</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($auctions as $auction)
                                <tr>
                                    <td>{{ $auction->id }}</td>
                                    <td>{{ $auction->auction_name }}</td>
                                    <td>{{ $auction->start_time }}</td>
                                    <td>{{ $auction->end_time }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($auction->status == 'pending') bg-warning
                                            @elseif($auction->status == 'active') bg-success
                                            @elseif($auction->status == 'ended') bg-secondary
                                            @elseif($auction->status == 'cancelled') bg-danger
                                            @endif">
                                            {{ ucfirst($auction->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $auction->created_at }}</td>
                                    <td>{{ $auction->updated_at }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No auctions available.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $auctions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
