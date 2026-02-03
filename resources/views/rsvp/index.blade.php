@extends('layouts.dashboard')
@section('title', 'RSVP List')
@section('content')
<div class="container">
    <h2 class="mb-4">RSVPs</h2>
    <form method="GET" action="" class="mb-3">
        <div class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search RSVPs..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="association_name" class="form-select">
                    <option value="">All Organisation Types</option>
                    @foreach($organizationTypes as $type)
                        <option value="{{ $type }}" {{ request('association_name') == $type ? 'selected' : '' }}>
                            {{ $type }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control" placeholder="From Date" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control" placeholder="To Date" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary w-100" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>
        <div class="mt-2">
            <a href="{{ route('admin.rsvps.export', request()->query()) }}" class="btn btn-success">
                <i class="fas fa-download me-1"></i> Export to CSV
            </a>
        </div>
    </form>
    
    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Sr No</th>
                    <th>Name</th>
                    <th>Organization</th>
                    <th>Designation</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Event Identity</th>
                    <th>RSVP Location</th>
                    <th>Association</th>
                    <th>Date/Time</th>
                    <th>Comment</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rsvps as $index => $rsvp)
                    <tr>
                        <td>{{ ($rsvps->currentPage() - 1) * $rsvps->perPage() + $index + 1 }}</td>
                        <td>{{ $rsvp->name }}</td>
                        <td>{{ $rsvp->org }}</td>
                        <td>{{ $rsvp->desig }}</td>
                        <td>
                            <a href="mailto:{{ $rsvp->email }}">{{ $rsvp->email }}</a>
                        </td>
                        <td>
                            @if($rsvp->phone_country_code)
                                +{{ $rsvp->phone_country_code }}-{{ $rsvp->mob }}
                            @else
                                {{ $rsvp->mob }}
                            @endif
                        </td>
                        <td>{{ $rsvp->city }}</td>
                        <td>{{ $rsvp->country }}</td>
                        <td>{{ $rsvp->event_identity }}</td>
                        <td>{{ $rsvp->rsvp_location }}</td>
                        <td>{{ $rsvp->association_name }}</td>
                        <td>
                            @if($rsvp->ddate)
                                {{ $rsvp->ddate->format('d M Y') }}
                            @endif
                            @if($rsvp->ttime)
                                <br><small class="text-muted">{{ $rsvp->ttime }}</small>
                            @endif
                        </td>
                        <td>
                            @if($rsvp->comment)
                                <span title="{{ $rsvp->comment }}">
                                    {{ Str::limit($rsvp->comment, 50) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.rsvps.show', $rsvp->id) }}" class="btn btn-sm btn-info" title="View">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form action="{{ route('admin.rsvps.destroy', $rsvp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this RSVP?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="14" class="text-center">No RSVPs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    {{-- Pagination Info --}}
    <div class="row mt-3">
        <div class="col-md-6">
            <p class="text-muted">
                Showing {{ $rsvps->firstItem() ?? 0 }} to {{ $rsvps->lastItem() ?? 0 }} of {{ $rsvps->total() }} results
            </p>
        </div>
        <div class="col-md-6">
            <div class="d-flex justify-content-end">
                <form method="GET" action="" class="me-3">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="association_name" value="{{ request('association_name') }}">
                    <input type="hidden" name="date_from" value="{{ request('date_from') }}">
                    <input type="hidden" name="date_to" value="{{ request('date_to') }}">
                    <select name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15 per page</option>
                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25 per page</option>
                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50 per page</option>
                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100 per page</option>
                    </select>
                </form>
            </div>
        </div>
    </div>
    
    {{-- Pagination Links --}}
    <div class="d-flex justify-content-center">
        {{ $rsvps->appends(request()->query())->links() }}
    </div>
</div>
@endsection
