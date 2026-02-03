@extends('layouts.dashboard')
@section('title', $title)
@section('content')
<div class="container-fluid py-2">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-gradient-dark text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="mb-0 text-white">{{ $title }}</h5>
                            @if($subtitle)
                                <small class="text-white-50">{{ $subtitle }}</small>
                            @endif
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-white text-dark fs-6">{{ $delegates->count() }} delegates</span>
                            <a href="{{ route('admin.delegates.export', ['filter' => $filter, 'value' => $value, 'category_id' => request('category_id')]) }}" 
                               class="btn btn-sm btn-success">
                                <i class="fas fa-file-export me-1"></i> Export CSV
                            </a>
                            <a href="{{ route('dashboard.admin') }}" class="btn btn-sm btn-outline-light">
                                <i class="fas fa-arrow-left me-1"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0" id="delegateTable">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Name</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email / Phone</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Company</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Category</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nationality</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Payment Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Reg. Date</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($delegates as $index => $delegate)
                                    <tr>
                                        <td class="ps-3">
                                            <span class="text-xs font-weight-bold">{{ $index + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <div class="d-flex flex-column justify-content-center">
                                                    <h6 class="mb-0 text-sm">{{ $delegate->salutation }} {{ $delegate->first_name }} {{ $delegate->last_name }}</h6>
                                                    @if($delegate->job_title)
                                                        <p class="text-xs text-secondary mb-0">{{ $delegate->job_title }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $delegate->email }}</p>
                                            <p class="text-xs text-secondary mb-0">{{ $delegate->phone ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $delegate->company_name ?? '-' }}</p>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm bg-gradient-info">{{ $delegate->category }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $isNational = in_array(strtolower($delegate->nationality ?? ''), ['national', 'indian', '']) || is_null($delegate->nationality);
                                            @endphp
                                            <span class="badge badge-sm {{ $isNational ? 'bg-gradient-primary' : 'bg-gradient-warning' }}">
                                                {{ $isNational ? 'National' : 'International' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @php
                                                $isPaid = in_array($delegate->payment_status, ['paid', 'complimentary']);
                                            @endphp
                                            <span class="badge badge-sm {{ $isPaid ? 'bg-gradient-success' : 'bg-gradient-danger' }}">
                                                {{ $isPaid ? 'Paid' : 'Not Paid' }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="text-xs font-weight-bold">
                                                {{ $delegate->registration_date ? \Carbon\Carbon::parse($delegate->registration_date)->format('d M Y') : '-' }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if($delegate->registration_id)
                                                <a href="{{ route('admin.delegate.details', $delegate->registration_id) }}" 
                                                   class="btn btn-sm btn-outline-primary px-3" 
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-users fa-3x mb-3 opacity-50"></i>
                                                <p class="mb-0">No delegates found matching the criteria</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    if ($.fn.DataTable) {
        $('#delegateTable').DataTable({
            "pageLength": 25,
            "order": [[0, "asc"]],
            "language": {
                "search": "Search delegates:",
                "lengthMenu": "Show _MENU_ entries",
            }
        });
    }
});
</script>
@endpush
@endsection
