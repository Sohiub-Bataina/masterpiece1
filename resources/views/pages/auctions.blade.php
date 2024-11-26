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
                        <div class="card-header p-3">
                            <h3>Auctions</h3>
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
                                                   
                                                    <a href="javascript:void(0)" class="btn btn-info btn-link" onclick="showViewDialog('{{ $auction->id }}', '{{ $auction->auction_name }}', '{{ $auction->start_time }}', '{{ $auction->end_time }}', '{{ $auction->status }}', '{{ $auction->created_at }}', '{{ $auction->updated_at }}')">
                                                        <i class="material-icons">visibility</i>
                                                    </a>
                                                    
                                                    <a href="{{ route('auctions.edit', $auction->id) }}" class="btn btn-success btn-link">
                                                        <i class="material-icons">edit</i>
                                                    </a>

                                                    
                                                    <button type="button" class="btn btn-danger btn-link" onclick="confirmDelete({{ $auction->id }})">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                    <form id="delete-form-{{ $auction->id }}" action="{{ route('auctions.destroy', $auction->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
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

    function showViewDialog(id, name, startTime, endTime, status, createdAt, updatedAt) {
        Swal.fire({
            title: 'Auction Details',
            html: `
                <p><strong>Created At:</strong> ${createdAt}</p>
                <p><strong>Updated At:</strong> ${updatedAt}</p>
            `,
            focusConfirm: false,
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
