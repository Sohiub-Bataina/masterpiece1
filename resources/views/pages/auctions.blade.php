<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="auctions"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Auctions"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <!-- Auctions Section -->
                <div class="col-12 mb-5">
                    <div class="card">
                        <div class="card-header p-3 d-flex justify-content-between align-items-center">
                            <h3>Auctions</h3>
                            <!-- Add Auction Button -->
                            @if(auth()->user()->role === 'superAdmin')  <!-- Check if the user is superAdmin -->
                                <a href="{{ route('auction.create') }}" class="btn btn-primary">
                                    <i class="material-icons">add</i> Add Auction
                                </a>
                            @endif
                        </div>
                        <div class="card-body" style="padding: 0.5rem;">
                            <div class="table-responsive">
                                <table class="table align-items-center" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">ID</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Auction Name</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Start Time</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">End Time</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Item Name</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($auctions as $auction)
                                            <tr>
                                                <td class="text-center">{{ $auction->id }}</td>
                                                <td class="text-center">{{ $auction->auction_name }}</td>
                                                <td class="text-center">{{ $auction->start_time }}</td>
                                                <td class="text-center">{{ $auction->end_time }}</td>
                                                <td class="text-center">{{ $auction->item_name ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    <span class="badge
                                                        @if($auction->status == 'pending') bg-warning
                                                        @elseif($auction->status == 'active') bg-success
                                                        @elseif($auction->status == 'ended') bg-secondary
                                                        @elseif($auction->status == 'cancelled') bg-danger
                                                        @endif">
                                                        {{ ucfirst($auction->status) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if($auction->main_image)
                                                        <img src="{{ asset($auction->main_image) }}" alt="Auction Image" style="max-width: 80px; max-height: 80px; object-fit: cover;">
                                                    @else
                                                        <span>No Image</span>
                                                    @endif
                                                </td>

                                                <td class="text-center">
                                                    <!-- View Details Button -->
                                                    <a href="javascript:void(0)" class="btn btn-info btn-link" onclick="showViewDialog({{ $auction }})">
                                                        <i class="material-icons">visibility</i>
                                                    </a>

                                                    @if(auth()->user()->role === 'superAdmin')  <!-- Check if the user is superAdmin -->
                                                        <!-- Edit Button -->
                                                        <a href="{{ route('auctions.edit', $auction->id) }}" class="btn btn-success btn-link">
                                                            <i class="material-icons">edit</i>
                                                        </a>

                                                        <!-- Delete Button -->
                                                        <button type="button" class="btn btn-danger btn-link" onclick="confirmDelete({{ $auction->id }})">
                                                            <i class="material-icons">close</i>
                                                        </button>
                                                        <form id="delete-form-{{ $auction->id }}" action="{{ route('auctions.destroy', $auction->id) }}" method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $auctions->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(auctionId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${auctionId}`).submit();
            }
        });
    }

    function showViewDialog(auction) {
        Swal.fire({
            title: `${auction.auction_name} Auction Details`,
            html: `
                <p><strong>Created At:</strong> ${auction.created_at}</p>
                <p><strong>Updated At:</strong> ${auction.updated_at}</p>
                <p><strong>Item ID:</strong> ${auction.item_id}</p>
                <p><strong>Announcement Start Time:</strong> ${auction.announcement_start_time}</p>
                <p><strong>Announcement End Time:</strong> ${auction.announcement_end_time}</p>
                <p><strong>Inspection Start Time:</strong> ${auction.inspection_start_time}</p>
                <p><strong>Inspection End Time:</strong> ${auction.inspection_end_time}</p>
                <p><strong>Minimum Price:</strong> ${auction.minimum_price}</p>
                <p><strong>Starting Price:</strong> ${auction.starting_price}</p>
                <p><strong>Minimum Bid:</strong> ${auction.minimum_bid}</p>
                <p><strong>Insurance Fee:</strong> ${auction.insurance_fee}</p>
            `,
            focusConfirm: false,
            confirmButtonText: 'Close',
        });
    }
</script>

@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
        });
    </script>
@endif
