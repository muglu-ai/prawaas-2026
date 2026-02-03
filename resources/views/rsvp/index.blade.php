@extends('layouts.dashboard')
@section('title', 'RSVP List')
@section('content')
<div class="container">
    <h2 class="mb-4">RSVP Registrations</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @php
        $sort = request('sort', 'created_at');
        $dir = request('direction', 'desc');
    @endphp
    <form method="GET" action="{{ route('admin.rsvps.index') }}" class="mb-3">
        <input type="hidden" name="sort" value="{{ $sort }}">
        <input type="hidden" name="direction" value="{{ $dir }}">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Name, email, org, city..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small">Association</label>
                <select name="association_id" class="form-select">
                    <option value="">All</option>
                    @foreach($associations as $association)
                        <option value="{{ $association->id }}" {{ request('association_id') == $association->id ? 'selected' : '' }}>
                            {{ $association->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small">From date</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label small">To date</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-1">
                <button class="btn btn-primary w-100" type="submit" title="Filter">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.rsvps.export', request()->query()) }}" class="btn btn-success w-100">
                    <i class="fas fa-download me-1"></i> Export CSV
                </a>
            </div>
        </div>
        <p class="small text-muted mt-2 mb-0">Exports are logged. Showing {{ $rsvps->total() }} total; use filters and pagination below.</p>
    </form>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>
                        <a href="{{ route('admin.rsvps.index', array_merge(request()->all(), ['sort' => 'name', 'direction' => ($sort === 'name' && $dir === 'asc') ? 'desc' : 'asc'])) }}" class="text-white text-decoration-none">
                            Name @if($sort === 'name')<i class="fas fa-sort-{{ $dir === 'asc' ? 'up' : 'down' }} ms-1"></i>@endif
                        </a>
                    </th>
                    <th>Organization</th>
                    <th>Designation</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Event / Location</th>
                    <th>Association</th>
                    <th>
                        <a href="{{ route('admin.rsvps.index', array_merge(request()->all(), ['sort' => 'created_at', 'direction' => ($sort === 'created_at' && $dir === 'asc') ? 'desc' : 'asc'])) }}" class="text-white text-decoration-none">
                            Date/Time @if($sort === 'created_at')<i class="fas fa-sort-{{ $dir === 'asc' ? 'up' : 'down' }} ms-1"></i>@endif
                        </a>
                    </th>
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
                        <td><a href="mailto:{{ $rsvp->email }}">{{ $rsvp->email }}</a></td>
                        <td>
                            @if($rsvp->phone_country_code)+{{ $rsvp->phone_country_code }}-@endif{{ $rsvp->mob }}
                        </td>
                        <td>{{ $rsvp->city }}</td>
                        <td>{{ $rsvp->country }}</td>
                        <td>
                            @if($rsvp->event_identity)<span title="{{ $rsvp->rsvp_location }}">{{ Str::limit($rsvp->event_identity, 20) }}</span>@endif
                            @if($rsvp->rsvp_location)<br><small class="text-muted">{{ Str::limit($rsvp->rsvp_location, 15) }}</small>@endif
                        </td>
                        <td>{{ $rsvp->association_name }}</td>
                        <td>
                            @if($rsvp->ddate){{ $rsvp->ddate->format('d M Y') }}@endif
                            @if($rsvp->ttime)<br><small>{{ $rsvp->ttime }}</small>@endif
                        </td>
                        <td>@if($rsvp->comment)<span title="{{ $rsvp->comment }}">{{ Str::limit($rsvp->comment, 40) }}</span>@endif</td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.rsvps.show', $rsvp->id) }}" class="btn btn-info" title="View"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('admin.rsvps.preview', $rsvp->id) }}" class="btn btn-secondary" target="_blank" title="Email preview"><i class="fas fa-envelope-open-text"></i></a>
                                <form action="{{ route('admin.rsvps.resend', $rsvp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Resend confirmation email to {{ $rsvp->email }}?');">
                                    @csrf
                                    <button type="submit" class="btn btn-warning" title="Resend email"><i class="fas fa-paper-plane"></i></button>
                                </form>
                                <form action="{{ route('admin.rsvps.destroy', $rsvp->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this RSVP?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" title="Delete"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="13" class="text-center">No RSVPs found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="row mt-3 align-items-center">
        <div class="col-md-4">
            <p class="text-muted mb-0">
                Showing {{ $rsvps->firstItem() ?? 0 }} to {{ $rsvps->lastItem() ?? 0 }} of {{ $rsvps->total() }}
            </p>
        </div>
        <div class="col-md-4 d-flex justify-content-center">
            {{ $rsvps->appends(request()->query())->links() }}
        </div>
        <div class="col-md-4 d-flex justify-content-end">
            <form method="GET" action="{{ route('admin.rsvps.index') }}" class="d-inline">
                @foreach(request()->except('per_page') as $key => $val)
                    @if($val)<input type="hidden" name="{{ $key }}" value="{{ $val }}">@endif
                @endforeach
                <label class="me-2 small">Per page:</label>
                <select name="per_page" class="form-select form-select-sm d-inline-block w-auto" onchange="this.form.submit()">
                    <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                </select>
            </form>
        </div>
    </div>
</div>
@endsection
