@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('content')
    @php
        $hide = true;
    @endphp
    <style>
        .card {
            min-height: 130px;
            /* Adjust height as needed */
            display: flex;
            min-width: 200px;
            /* Adjust width as needed */
            flex-direction: column;
            justify-content: space-between;
            margin: 10px;
            /* Adjust margin as needed */

        }

        .icon {
            width: 48px;
            height: 48px;
            /* padding: 10px; */
        }
    </style>
    <div class="container-fluid py-2">
        <div class="row">
            <div class="ms-3">
                <h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
                <p class="mb-4">
                    Applicants analytics.
                </p>
            </div>
            @if($hide == false)
            <div class="ms-3">
                <p class=" font-weight-bolder">
                    Users
                </p>
            </div>
            <div class="row">
                <!-- Left Side Content -->
                <div class="col-md-12">
                    <div class="row mb-3">
                        <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 mt-2">
                            <div class="card">
                                <div class="card-header p-2 ps-3">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <p class="text-m mb-0 text-capitalize font-weight-black font-weight-bold">
                                                Total
                                                Users</p>
                                            <h4 class="mb-0 mt-1">{{ $analytics['totalUsers'] ?? 0 }}</h4>
                                        </div>
                                        <div
                                                class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                            <i class="material-symbols-rounded opacity-10">person</i>
                                        </div>
                                    </div>
                                </div>

                                <hr class="dark horizontal my-0">
                                <div class="card-footer p-2 ps-3">
                                    <p class="mb-0 text-sm"><a href="{{ route('users.list') }}"><span
                                                    class="text-success font-weight-bolder">Click here </span></a>for
                                        more info.</p>
                                </div>
                            </div>


                        </div>
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4 mt-2">
                                    <div class="card">
                                        <div class="card-header p-2 ps-3">
                                            Active User Analytics
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <p class="text-m mb-0 text-capitalize font-weight-black font-weight-bold">
                                                    </p>
                                                    <h4 class="mb-0 mt-1"></h4>
                                                </div>
                                                <div class="card-footer p-2 ps-3">
                                                    <p class="mb-0 text-sm">
                                                        <a href="{{ route('active.users.analytics') }}"
                                                        <span class="text-warning font-weight-bolder">Click Here</span> </a>
                                                        —
                                                        for more information.
                                                    </p>
                                                </div>


                                                {{-- <div
                                                    class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                                    <i class="material-symbols-rounded opacity-10">person</i>
                                                </div> --}}
                                            </div>
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 mt-2">
                                <div class="card">
                                    <div class="card-header p-2 ps-3">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="text-m mb-0 text-capitalize font-weight-black font-weight-bold">
                                                    Payment Receipt Uploaded</p>
                                                <h4 class="mb-0 mt-1">{{ $analytics['payments'][0] ?? 0 }}</h4>
                                            </div>
                                            <div
                                                    class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                                <i class="material-symbols-rounded opacity-10">person</i>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="dark horizontal my-0">
                                    <div class="card-footer p-2 ps-3">
                                        <p class="mb-0 text-sm"><a href="{{route('invoice.list')}}"><span
                                                        class="text-success font-weight-bolder">Click here </span></a>for
                                            more info.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 mt-2">
                                <div class="card">
                                    <div class="card-header p-2 ps-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <p class="mb-0 text-capitalize font-weight-bold"
                                                   style="font-size: 1rem;">
                                                    Co-Exhibitor Applications Awaiting Approval
                                                </p>
                                                <h4 class="mb-0 mt-1">
                                                    <span class="text-warning">{{ $coExhibitorCount ?? 0 }}</span>
                                                    /
                                                    <span class="text-success">{{ $approvedCoexhibitorCount }}</span>
                                                </h4>
                                            </div>
                                            <div
                                                    class="icon icon-md icon-shape bg-gradient-warning shadow text-center border-radius-lg">
                                                <i class="fa-solid fa-user-clock opacity-10"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="dark horizontal my-0">
                                    <div class="card-footer p-2 ps-3">
                                        <p class="mb-0 text-sm">
                                            <a href="{{ route('co_exhibitors') }}"
                                            <span class="text-warning font-weight-bolder">Pending review</span> </a> —
                                            Click
                                            here for more information.
                                        </p>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                    <div class="col-md-6">
                        <div class="row mb-3">
                            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4 mt-2">
                                <div class="card">
                                    <div class="card-header p-2 ps-3">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="text-m mb-0 text-capitalize font-weight-black font-weight-bold">
                                                    Requested SQM Sum</p>
                                                <h4 class="mb-0 mt-1">{{ $analytics['req_sqm_sum'] . ' SQM' ?? 0 }}</h4>
                                            </div>
                                            <div
                                                    class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-archive" viewBox="0 0 16 16"
                                                     style="color: #FFFFFF; margin-top: 15px;">
                                                    <path
                                                            d="M0 2a1 1 0 0 1 1-1h14a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1v7.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 12.5V5a1 1 0 0 1-1-1zm2 3v7.5A1.5 1.5 0 0 0 3.5 14h9a1.5 1.5 0 0 0 1.5-1.5V5zm13-3H1v2h14zM5 7.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    {{--                        <hr class="dark horizontal my-0"> --}}
                                    {{--                        <div class="card-footer p-2 ps-3"> --}}
                                    {{--                            <p class="mb-0 text-sm"><a href="/users/list"><span class="text-success font-weight-bolder">Click here </span></a>for --}}
                                    {{--                                more info.</p> --}}
                                    {{--                        </div> --}}
                                </div>
                            </div>
                            <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4 mt-2">
                                <div class="card">
                                    <div class="card-header p-2 ps-3">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <p class="text-m mb-0 text-capitalize font-weight-black font-weight-bold">
                                                    Approved SQM Sum</p>
                                                <h4 class="mb-0 mt-1">{{ $analytics['approved_sqm_sum'] . ' SQM' ?? 0 }}</h4>
                                            </div>
                                            <div
                                                    class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                     fill="currentColor" class="bi bi-archive-fill" viewBox="0 0 16 16"
                                                     style="color: #FFFFFF; margin-top: 15px;">
                                                    <path
                                                            d="M12.643 15C13.979 15 15 13.845 15 12.5V5H1v7.5C1 13.845 2.021 15 3.357 15zM5.5 7h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1 0-1M.8 1a.8.8 0 0 0-.8.8V3a.8.8 0 0 0 .8.8h14.4A.8.8 0 0 0 16 3V1.8a.8.8 0 0 0-.8-.8z"/>
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                    {{--                        <hr class="dark horizontal my-0"> --}}
                                    {{--                        <div class="card-footer p-2 ps-3"> --}}
                                    {{--                            <p class="mb-0 text-sm"><a href="/invoice"><span class="text-success font-weight-bolder">Click here </span></a>for --}}
                                    {{--                                more info.</p> --}}
                                    {{--                        </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
            @endif

                <div class="ms-3 mt-2">
                    <p class="font-weight-bolder">
                        Exhibition
                    </p>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="text-uppercase text-secondary text-sm font-weight-bolder">Type</th>
                                                <th class="text-uppercase text-secondary text-sm font-weight-bolder text-center">Total Registration</th>
                                                <th class="text-uppercase text-secondary text-sm font-weight-bolder text-center">Paid</th>
                                                <th class="text-uppercase text-secondary text-sm font-weight-bolder text-center">Not Paid</th>
                                                <th class="text-uppercase text-secondary text-sm font-weight-bolder text-center">Approved</th>
                                                <th class="text-uppercase text-secondary text-sm font-weight-bolder text-center">Approval Required</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="font-weight-bold">Exhibitor</td>
                                                <td class="text-center">
                                                    <a href="{{ route('application.lists', ['type' => 'exhibitor-registration']) }}" class="text-primary font-weight-bold h5 mb-0">
                                                        {{ $analytics['exhibitor-registration']['total'] ?? 0 }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('application.list', ['status' => 'submitted', 'type' => 'exhibitor-registration', 'payment_status' => 'paid']) }}" class="text-success font-weight-bold h5 mb-0">
                                                        {{ $analytics['exhibitor-registration']['paid'] ?? 0 }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('application.list', ['status' => 'submitted', 'type' => 'exhibitor-registration', 'payment_status' => 'unpaid']) }}" class="text-danger font-weight-bold h5 mb-0">
                                                        {{ $analytics['exhibitor-registration']['unpaid'] ?? 0 }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('application.list', ['status' => 'approved', 'type' => 'exhibitor-registration']) }}" class="text-info font-weight-bold h5 mb-0">
                                                        {{ $analytics['exhibitor-registration']['approved'] ?? 0 }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('application.list', ['status' => 'submitted', 'type' => 'exhibitor-registration']) }}" class="text-warning font-weight-bold h5 mb-0">
                                                        {{ $analytics['exhibitor-registration']['submitted'] ?? 0 }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="font-weight-bold">Startup</td>
                                                <td class="text-center">
                                                    <a href="{{ route('application.lists', ['type' => 'startup-zone']) }}" class="text-primary font-weight-bold h5 mb-0">
                                                        {{ $analytics['startupZone']['total'] ?? 0 }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('application.list', ['status' => 'submitted', 'type' => 'startup-zone', 'payment_status' => 'paid']) }}" class="text-success font-weight-bold h5 mb-0">
                                                        {{ $analytics['startupZone']['paid'] ?? 0 }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('application.list', ['status' => 'submitted', 'type' => 'startup-zone', 'payment_status' => 'unpaid']) }}" class="text-danger font-weight-bold h5 mb-0">
                                                        {{ $analytics['startupZone']['unpaid'] ?? 0 }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('application.list', ['status' => 'approved', 'type' => 'startup-zone']) }}" class="text-info font-weight-bold h5 mb-0">
                                                        {{ $analytics['startupZone']['approved'] ?? 0 }}
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('application.list', ['status' => 'submitted', 'type' => 'startup-zone']) }}" class="text-warning font-weight-bold h5 mb-0">
                                                        {{ $analytics['startupZone']['submitted'] ?? 0 }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr class="table-light">
                                                <td class="font-weight-bolder">Total</td>
                                                <td class="text-center">
                                                    <span class="text-dark font-weight-bolder h5 mb-0">
                                                        {{ ($analytics['exhibitor-registration']['total'] ?? 0) + ($analytics['startupZone']['total'] ?? 0) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-success font-weight-bolder h5 mb-0">
                                                        {{ ($analytics['exhibitor-registration']['paid'] ?? 0) + ($analytics['startupZone']['paid'] ?? 0) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-danger font-weight-bolder h5 mb-0">
                                                        {{ ($analytics['exhibitor-registration']['unpaid'] ?? 0) + ($analytics['startupZone']['unpaid'] ?? 0) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-info font-weight-bolder h5 mb-0">
                                                        {{ ($analytics['exhibitor-registration']['approved'] ?? 0) + ($analytics['startupZone']['approved'] ?? 0) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <span class="text-warning font-weight-bolder h5 mb-0">
                                                        {{ ($analytics['exhibitor-registration']['submitted'] ?? 0) + ($analytics['startupZone']['submitted'] ?? 0) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="ms-3 mt-3">
                    <p class="font-weight-bolder">
                        Enquiries
                    </p>
                </div>

                <div class="row mb-3">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-3">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover align-middle mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th class="text-uppercase text-secondary text-sm font-weight-bolder text-center">Total Enquiries</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center">
                                                    <a href="{{ route('enquiries.index') }}" class="text-primary font-weight-bold h5 mb-0">
                                                        {{ $analytics['enquiries']['total'] ?? 0 }}
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="dark horizontal my-0">

                {{-- Delegate Registration Analytics Section --}}
                @if(isset($delegateAnalytics))
                <div class="ms-3 mt-4">
                    <h5 class="font-weight-bolder mb-3">
                        <i class="fas fa-users me-2"></i>Delegate Registration
                    </h5>
                </div>

                {{-- Main Statistics Table --}}
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-gradient-dark py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-white">
                                        <i class="fas fa-chart-bar me-2"></i>Registration Statistics by Category
                                    </h6>
                                    <a href="{{ route('admin.delegates.list', ['filter' => 'total']) }}" class="btn btn-sm btn-outline-light">
                                        View All Delegates
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead>
                                            <tr class="bg-light">
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder ps-3" style="width: 25%;">Category</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">Total</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">
                                                    <i class="fas fa-flag me-1 text-info"></i>National
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">
                                                    <i class="fas fa-globe me-1 text-warning"></i>International
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">
                                                    <i class="fas fa-check-circle me-1 text-success"></i>Paid
                                                </th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">
                                                    <i class="fas fa-times-circle me-1 text-danger"></i>Not Paid
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $catTotalDelegates = 0;
                                                $catNationalDelegates = 0;
                                                $catInternationalDelegates = 0;
                                                $catPaidDelegates = 0;
                                                $catUnpaidDelegates = 0;
                                            @endphp
                                            @forelse($delegateAnalytics['by_category'] as $category)
                                                @php
                                                    $catTotalDelegates += $category->total_delegates;
                                                    $catNationalDelegates += $category->national_delegates;
                                                    $catInternationalDelegates += $category->international_delegates;
                                                    $catPaidDelegates += $category->paid_delegates;
                                                    $catUnpaidDelegates += $category->unpaid_delegates;
                                                @endphp
                                                <tr>
                                                    <td class="ps-3">
                                                        <span class="font-weight-bold text-dark">{{ $category->category_name }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.delegates.list', ['filter' => 'category', 'category_id' => $category->category_id]) }}" 
                                                           class="btn btn-link text-primary font-weight-bold h5 mb-0 p-0" 
                                                           title="View all {{ $category->category_name }} delegates">
                                                            {{ $category->total_delegates }}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.delegates.list', ['filter' => 'category', 'category_id' => $category->category_id, 'value' => 'national']) }}" 
                                                           class="btn btn-link text-info font-weight-bold h6 mb-0 p-0"
                                                           title="View national {{ $category->category_name }} delegates">
                                                            {{ $category->national_delegates }}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.delegates.list', ['filter' => 'category', 'category_id' => $category->category_id, 'value' => 'international']) }}" 
                                                           class="btn btn-link text-warning font-weight-bold h6 mb-0 p-0"
                                                           title="View international {{ $category->category_name }} delegates">
                                                            {{ $category->international_delegates }}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.delegates.list', ['filter' => 'category', 'category_id' => $category->category_id, 'value' => 'paid']) }}" 
                                                           class="btn btn-link text-success font-weight-bold h6 mb-0 p-0"
                                                           title="View paid {{ $category->category_name }} delegates">
                                                            {{ $category->paid_delegates }}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.delegates.list', ['filter' => 'category', 'category_id' => $category->category_id, 'value' => 'unpaid']) }}" 
                                                           class="btn btn-link text-danger font-weight-bold h6 mb-0 p-0"
                                                           title="View unpaid {{ $category->category_name }} delegates">
                                                            {{ $category->unpaid_delegates }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted py-4">
                                                        <i class="fas fa-info-circle me-2"></i>No delegate registrations found
                                                    </td>
                                                </tr>
                                            @endforelse
                                            @if(count($delegateAnalytics['by_category']) > 0)
                                                <tr class="bg-light border-top border-2">
                                                    <td class="ps-3">
                                                        <span class="font-weight-bolder text-dark">TOTAL</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.delegates.list', ['filter' => 'total']) }}" 
                                                           class="btn btn-link text-dark font-weight-bolder h4 mb-0 p-0">
                                                            {{ $catTotalDelegates }}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.delegates.list', ['filter' => 'nationality', 'value' => 'national']) }}" 
                                                           class="btn btn-link text-info font-weight-bolder h5 mb-0 p-0">
                                                            {{ $catNationalDelegates }}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.delegates.list', ['filter' => 'nationality', 'value' => 'international']) }}" 
                                                           class="btn btn-link text-warning font-weight-bolder h5 mb-0 p-0">
                                                            {{ $catInternationalDelegates }}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.delegates.list', ['filter' => 'payment_status', 'value' => 'paid']) }}" 
                                                           class="btn btn-link text-success font-weight-bolder h5 mb-0 p-0">
                                                            {{ $catPaidDelegates }}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.delegates.list', ['filter' => 'payment_status', 'value' => 'unpaid']) }}" 
                                                           class="btn btn-link text-danger font-weight-bolder h5 mb-0 p-0">
                                                            {{ $catUnpaidDelegates }}
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Days Access and Summary Row --}}
                <div class="row mb-4">
                    {{-- Days Access Breakdown --}}
                    @if(count($delegateAnalytics['by_days_access']) > 0)
                    <div class="col-lg-7 mb-3 mb-lg-0">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-gradient-info py-3">
                                <h6 class="mb-0 text-white">
                                    <i class="fas fa-calendar-alt me-2"></i>Delegates by Day Access
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead>
                                            <tr class="bg-light">
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder ps-3">Day</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">Date</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">Total</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">Paid</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">Not Paid</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($delegateAnalytics['by_days_access'] as $day)
                                                <tr>
                                                    <td class="ps-3">
                                                        <span class="font-weight-bold text-dark">{{ $day['day_label'] }}</span>
                                                    </td>
                                                    <td>
                                                        @if($day['day_date'])
                                                            <span class="badge bg-light text-dark">
                                                                {{ \Carbon\Carbon::parse($day['day_date'])->format('d M Y') }}
                                                            </span>
                                                        @else
                                                            <span class="text-muted">-</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="{{ route('admin.delegates.list', ['filter' => 'day_access', 'value' => $day['day_id']]) }}" 
                                                           class="btn btn-link text-primary font-weight-bold h6 mb-0 p-0"
                                                           title="View delegates with {{ $day['day_label'] }} access">
                                                            {{ $day['total_delegates'] }}
                                                        </a>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-success-subtle text-success px-3 py-2">
                                                            {{ $day['paid_delegates'] }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-danger-subtle text-danger px-3 py-2">
                                                            {{ $day['unpaid_delegates'] }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- Quick Summary Cards --}}
                    <div class="col-lg-{{ count($delegateAnalytics['by_days_access']) > 0 ? '5' : '12' }}">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-gradient-success py-3">
                                <h6 class="mb-0 text-white">
                                    <i class="fas fa-chart-pie me-2"></i>Quick Summary
                                </h6>
                            </div>
                            <div class="card-body">
                                @php
                                    $paymentTotal = $delegateAnalytics['by_payment_status']['total'] ?? 1;
                                    $paidPercent = $paymentTotal > 0 ? round(($delegateAnalytics['by_payment_status']['paid'] / $paymentTotal) * 100, 1) : 0;
                                    $unpaidPercent = $paymentTotal > 0 ? round(($delegateAnalytics['by_payment_status']['unpaid'] / $paymentTotal) * 100, 1) : 0;
                                @endphp
                                
                                {{-- Payment Status Progress --}}
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-sm font-weight-bold">Payment Status</span>
                                        <span class="text-xs text-muted">{{ $delegateAnalytics['by_payment_status']['total'] ?? 0 }} total</span>
                                    </div>
                                    <div class="progress" style="height: 24px;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $paidPercent }}%;" title="Paid: {{ $delegateAnalytics['by_payment_status']['paid'] ?? 0 }}">
                                            @if($paidPercent > 15)
                                                <span class="text-xs">Paid {{ $paidPercent }}%</span>
                                            @endif
                                        </div>
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: {{ $unpaidPercent }}%;" title="Not Paid: {{ $delegateAnalytics['by_payment_status']['unpaid'] ?? 0 }}">
                                            @if($unpaidPercent > 15)
                                                <span class="text-xs">Not Paid {{ $unpaidPercent }}%</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <a href="{{ route('admin.delegates.list', ['filter' => 'payment_status', 'value' => 'paid']) }}" 
                                           class="text-success text-decoration-none">
                                            <i class="fas fa-check-circle me-1"></i>
                                            <strong>{{ $delegateAnalytics['by_payment_status']['paid'] ?? 0 }}</strong> Paid
                                        </a>
                                        <a href="{{ route('admin.delegates.list', ['filter' => 'payment_status', 'value' => 'unpaid']) }}" 
                                           class="text-danger text-decoration-none">
                                            <i class="fas fa-times-circle me-1"></i>
                                            <strong>{{ $delegateAnalytics['by_payment_status']['unpaid'] ?? 0 }}</strong> Not Paid
                                        </a>
                                    </div>
                                </div>

                                {{-- Nationality Stats --}}
                                <div class="row">
                                    <div class="col-6">
                                        <a href="{{ route('admin.delegates.list', ['filter' => 'nationality', 'value' => 'national']) }}" 
                                           class="card bg-info-subtle border-0 text-decoration-none h-100">
                                            <div class="card-body text-center py-3">
                                                <i class="fas fa-flag text-info fa-2x mb-2"></i>
                                                <h3 class="mb-0 text-info">{{ $delegateAnalytics['summary']['national_delegates'] ?? 0 }}</h3>
                                                <small class="text-muted">National</small>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('admin.delegates.list', ['filter' => 'nationality', 'value' => 'international']) }}" 
                                           class="card bg-warning-subtle border-0 text-decoration-none h-100">
                                            <div class="card-body text-center py-3">
                                                <i class="fas fa-globe text-warning fa-2x mb-2"></i>
                                                <h3 class="mb-0 text-warning">{{ $delegateAnalytics['summary']['international_delegates'] ?? 0 }}</h3>
                                                <small class="text-muted">International</small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Poster Registration Analytics Section --}}
                @if(isset($posterAnalytics))
                <div class="ms-3 mt-4">
                    <h5 class="font-weight-bolder mb-3">
                        <i class="fas fa-image me-2"></i>Poster Registration
                    </h5>
                </div>

                <div class="row mb-4">
                    <div class="col-lg-8">
                        <div class="card shadow-sm">
                            <div class="card-header bg-gradient-primary py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-white">
                                        <i class="fas fa-chart-bar me-2"></i>Poster Statistics
                                    </h6>
                                    <a href="{{ route('admin.posters.list') }}" class="btn btn-sm btn-outline-light">
                                        View All Posters
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead>
                                            <tr class="bg-light">
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder ps-3">Metric</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">Count</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="ps-3"><span class="font-weight-bold">Total Registrations</span></td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.posters.list') }}" class="btn btn-link text-primary font-weight-bold h5 mb-0 p-0">
                                                        {{ $posterAnalytics['total'] ?? 0 }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-3"><span class="font-weight-bold text-success">Paid</span></td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.posters.list', ['payment_status' => 'paid']) }}" class="btn btn-link text-success font-weight-bold h5 mb-0 p-0">
                                                        {{ $posterAnalytics['paid'] ?? 0 }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-3"><span class="font-weight-bold text-warning">Pending</span></td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.posters.list', ['payment_status' => 'pending']) }}" class="btn btn-link text-warning font-weight-bold h5 mb-0 p-0">
                                                        {{ $posterAnalytics['pending'] ?? 0 }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-3"><span class="font-weight-bold text-info">Indian (INR)</span></td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.posters.list', ['currency' => 'INR']) }}" class="btn btn-link text-info font-weight-bold h5 mb-0 p-0">
                                                        {{ $posterAnalytics['indian'] ?? 0 }}
                                                    </a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="ps-3"><span class="font-weight-bold text-secondary">International (USD)</span></td>
                                                <td class="text-center">
                                                    <a href="{{ route('admin.posters.list', ['currency' => 'USD']) }}" class="btn btn-link text-secondary font-weight-bold h5 mb-0 p-0">
                                                        {{ $posterAnalytics['international'] ?? 0 }}
                                                    </a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-header bg-gradient-success py-3">
                                <h6 class="mb-0 text-white">
                                    <i class="fas fa-rupee-sign me-2"></i>Revenue
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <span class="text-muted text-sm">Revenue (INR)</span>
                                    <h3 class="mb-0 text-success">₹{{ number_format($posterAnalytics['revenue_inr'] ?? 0, 2) }}</h3>
                                </div>
                                <div>
                                    <span class="text-muted text-sm">Revenue (USD)</span>
                                    <h3 class="mb-0 text-info">${{ number_format($posterAnalytics['revenue_usd'] ?? 0, 2) }}</h3>
                                </div>
                            </div>
                            <div class="card-footer bg-light">
                                <a href="{{ route('admin.posters.analytics') }}" class="btn btn-sm btn-primary w-100">
                                    <i class="fas fa-chart-line me-1"></i> View Detailed Analytics
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Visa Clearance Analytics Section --}}
                @if(isset($visaAnalytics))
                <div class="ms-3 mt-4">
                    <h5 class="font-weight-bolder mb-3">
                        <i class="fas fa-passport me-2"></i>Visa Clearance Requests
                    </h5>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-gradient-warning py-3">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0 text-white">
                                        <i class="fas fa-chart-bar me-2"></i>Visa Request Statistics
                                    </h6>
                                    <span class="badge bg-white text-dark">Total: {{ $visaAnalytics['total'] ?? 0 }}</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <div class="card bg-light border-0 h-100">
                                            <div class="card-body text-center py-3">
                                                <i class="fas fa-clock text-warning fa-2x mb-2"></i>
                                                <h3 class="mb-0 text-warning">{{ $visaAnalytics['pending'] ?? 0 }}</h3>
                                                <small class="text-muted">Pending</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <div class="card bg-light border-0 h-100">
                                            <div class="card-body text-center py-3">
                                                <i class="fas fa-spinner text-info fa-2x mb-2"></i>
                                                <h3 class="mb-0 text-info">{{ $visaAnalytics['processing'] ?? 0 }}</h3>
                                                <small class="text-muted">Processing</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <div class="card bg-light border-0 h-100">
                                            <div class="card-body text-center py-3">
                                                <i class="fas fa-check-circle text-success fa-2x mb-2"></i>
                                                <h3 class="mb-0 text-success">{{ $visaAnalytics['approved'] ?? 0 }}</h3>
                                                <small class="text-muted">Approved</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 mb-3">
                                        <div class="card bg-light border-0 h-100">
                                            <div class="card-body text-center py-3">
                                                <i class="fas fa-times-circle text-danger fa-2x mb-2"></i>
                                                <h3 class="mb-0 text-danger">{{ $visaAnalytics['rejected'] ?? 0 }}</h3>
                                                <small class="text-muted">Rejected</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @if(count($visaAnalytics['by_nationality'] ?? []) > 0)
                                <hr>
                                <h6 class="mb-3">Top Countries</h6>
                                <div class="row">
                                    @foreach($visaAnalytics['by_nationality'] as $country)
                                        <div class="col-md-4 col-sm-6 mb-2">
                                            <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                                <span class="text-sm font-weight-bold">{{ $country->nationality }}</span>
                                                <span class="badge bg-primary">{{ $country->count }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- Export Logs Section --}}
                @if(isset($exportLogs) && count($exportLogs) > 0)
                <div class="ms-3 mt-4">
                    <h5 class="font-weight-bolder mb-3">
                        <i class="fas fa-file-export me-2"></i>Recent Exports
                    </h5>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card shadow-sm">
                            <div class="card-header bg-gradient-secondary py-3">
                                <h6 class="mb-0 text-white">
                                    <i class="fas fa-history me-2"></i>Export Log (Last 15)
                                </h6>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle mb-0">
                                        <thead>
                                            <tr class="bg-light">
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder ps-3">Export Type</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">User</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder text-center">Records</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">File</th>
                                                <th class="text-uppercase text-secondary text-xs font-weight-bolder">Date/Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($exportLogs as $log)
                                                <tr>
                                                    <td class="ps-3">
                                                        <span class="badge bg-primary-subtle text-primary">{{ ucwords(str_replace('_', ' ', $log->export_type)) }}</span>
                                                    </td>
                                                    <td>
                                                        <span class="font-weight-bold text-sm">{{ $log->user_name }}</span>
                                                        <br>
                                                        <small class="text-muted">{{ $log->user_email }}</small>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-info">{{ $log->record_count }}</span>
                                                    </td>
                                                    <td>
                                                        <small class="text-muted">{{ $log->file_name ?? '-' }}</small>
                                                    </td>
                                                    <td>
                                                        <span class="text-sm">{{ \Carbon\Carbon::parse($log->created_at)->format('d M Y') }}</span>
                                                        <br>
                                                        <small class="text-muted">{{ \Carbon\Carbon::parse($log->created_at)->format('H:i:s') }}</small>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{-- <hr class="dark horizontal my-0"> --}}

                @if($hide == false)

                <div class="ms-3 mt-2">
                    <p class="font-weight-bolder">
                        Declaration Forms
                    </p>
                </div>
    
                <div class="row mb-3">
                    <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4 mt-4">
                        <div class="card">
                            <div class="card-header p-2 ps-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-m mb-0 text-capitalize font-weight-black font-weight-bold">Declaration Forms Filled</p>
                                        <h4 class="mb-0 mt-1">{{ $analytics['declarationsFilled'] ?? 0 }}</h4>
                                    </div>
                                    <div class="icon icon-md icon-shape bg-gradient-success shadow-success shadow text-center border-radius-lg">
                                        <i class="material-symbols-rounded opacity-10">check_circle</i>
                                    </div>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-2 ps-3">
                                <p class="mb-0 text-sm"><a href="{{ route('admin.declarations.list', ['status' => 'filled']) }}"><span class="text-success font-weight-bolder">Click here </span></a>for more info.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-sm-6 mb-xl-0 mb-4 mt-4">
                        <div class="card">
                            <div class="card-header p-2 ps-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-m mb-0 text-capitalize font-weight-black font-weight-bold">Declaration Forms Not Filled</p>
                                        <h4 class="mb-0 mt-1">{{ $analytics['declarationsNotFilled'] ?? 0 }}</h4>
                                    </div>
                                    <div class="icon icon-md icon-shape bg-gradient-danger shadow-danger shadow text-center border-radius-lg">
                                        <i class="material-symbols-rounded opacity-10">cancel</i>
                                    </div>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-2 ps-3">
                                <p class="mb-0 text-sm"><a href="{{ route('admin.declarations.list', ['status' => 'not_filled']) }}"><span class="text-success font-weight-bolder">Click here </span></a>for more info.</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                {{--
                <div class="ms-3 mt-2">
                    <p class="font-weight-bolder">
                        Sponsorship
                    </p>
                </div>

                <div class="row mb-3">
                    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 mt-4">
                        <div class="card">
                            <div class="card-header p-2 ps-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-m mb-0 text-capitalize font-weight-black font-weight-bold">Total
                                            Sponsorship Application</p>
                                        <h4 class="mb-0 mt-1">{{ $analytics['sponsors_count'] ?? 0 }}</h4>
                                    </div>
                                    <div
                                            class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                        <i class="material-symbols-rounded opacity-10">person</i>
                                    </div>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-2 ps-3">
                                <p class="mb-0 text-sm"><a href="/sponsorship-list/"><span
                                                class="text-success font-weight-bolder"> Click here </span></a>for more
                                    info.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 mt-4">
                        <div class="card">
                            <div class="card-header p-2 ps-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-m mb-0 text-capitalize font-weight-black font-weight-bold">Total
                                            Initiated</p>
                                        <h4 class="mb-0 mt-1">{{ $analytics['sponsorshipByStatus']['initiated'] ?? 0 }}</h4>
                                    </div>
                                    <div
                                            class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                        <i class="material-symbols-rounded opacity-10">person</i>
                                    </div>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-2 ps-3">
                                <p class="mb-0 text-sm"><a href="/sponsorship-list/in-progress"><span
                                                class="text-success font-weight-bolder"> Click here</span> </a>for more
                                    info.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 mt-4">
                        <div class="card">
                            <div class="card-header p-2 ps-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-m mb-0 text-capitalize font-weight-black font-weight-bold">Total
                                            Submitted</p>
                                        <h4 class="mb-0 mt-1">{{ $analytics['sponsorshipByStatus']['submitted'] ?? 0 }}</h4>
                                    </div>
                                    <div
                                            class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                        <i class="material-symbols-rounded opacity-10">Person</i>
                                    </div>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-2 ps-3">
                                <p class="mb-0 text-sm"><a href="/sponsorship-list/submitted"><span
                                                class="text-success font-weight-bolder">Click here </span></a>for more
                                    info.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4  mt-4">
                        <div class="card">
                            <div class="card-header p-2 ps-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-m mb-0 text-capitalize font-weight-black font-weight-bold">Total
                                            Approved Application</p>
                                        <h4 class="mb-0 mt-1">{{ $analytics['sponsorshipByStatus']['approved'] ?? 0 }}</h4>
                                    </div>
                                    <div
                                            class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                                        <i class="material-symbols-rounded opacity-10">Person</i>
                                    </div>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-2 ps-3">
                                <p class="mb-0 text-sm"><a href="/sponsorship-list/approved"><span
                                                class="text-success font-weight-bolder">Click here </span></a>for more
                                    info.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4 mt-4">
                        <div class="card">
                            <div class="card-header p-2 ps-3">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <p class="text-m mb-0 text-capitalize font-weight-black font-weight-bold">Total
                                            Rejected Application</p>
                                        <h4 class="mb-0 mt-1">{{ $analytics['sponsorshipByStatus']['rejected'] ?? 0 }}</h4>
                                    </div>
                                    <div
                                            class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg ">
                                        <i class="material-symbols-rounded opacity-10 ">Person</i>
                                    </div>
                                </div>
                            </div>
                            <hr class="dark horizontal my-0">
                            <div class="card-footer p-2 ps-3">
                                <p class="mb-0 text-sm"><a href="/sponsorship-list/rejected"><span
                                                class="text-success font-weight-bolder">Click here </span></a>for more
                                    info.</p>
                            </div>
                        </div>
                    </div>
                </div>
                --}}

                @if($hide == false)
                <div class="ms-3 mt-2">
                    <p class="font-weight-bolder">
                        Statistics
                    </p>
                </div>
                <!-- Right Side Content -->
                <div class="row">
                    <div class="col-md-6">

                        <div class="card card-raised">
                            <div class="card-body">
                                <h2 class="overline">Country Wise Stats Submitted Applications</h2>
                                <div class="list-group list-group-flush list-group-light">
                                    <div class="list-group-item d-flex justify-content-between px-0">
                                        <div class="me-2">Total Countries</div>
                                        <div class="text-end"><strong>{{ $totalCountries }}</strong></div>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between px-0">
                                        <div class="me-2">Total Applications</div>
                                        <div class="text-end">
                                            <strong>{{ $indiaInternationalStats->india_count + $indiaInternationalStats->international_count }}</strong>
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between px-0">
                                        <div class="caption font-monospace ">India</div>
                                        <div class="caption font-monospace  ms-2 text-end">
                                            {{ $indiaInternationalStats->india_count }} /
                                            {{ $indiaInternationalStats->india_sqm }} sqm
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between px-0">
                                        <div class="caption font-monospace ">International</div>
                                        <div class="caption font-monospace  ms-2 text-end">
                                            {{ $indiaInternationalStats->international_count }} /
                                            {{ $indiaInternationalStats->international_sqm }} sqm
                                        </div>
                                    </div>

                                    @php
                                        $tots =
                                            $indiaInternationalStats->india_sqm +
                                            $indiaInternationalStats->international_sqm;
                                    @endphp
                                    {{-- <p class="text-white">Total Countries with Submitted Applications: <strong>{{ $totalCountries }}</strong></p> --}}

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Country</th>
                                                <th>Total Companies</th>
                                                <th>Total SQM / Share</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($applicationsByCountry as $data)
                                                @php
                                                    $share = ($data->total_sqm / $tots) * 100;
                                                    $share = number_format($share, 2);
                                                @endphp
                                                <tr>
                                                    <td>{{ $data->country_name }}</td>
                                                    <td class="text-center">{{ $data->total_companies }}</td>
                                                    <td class="text-center">{{ $data->total_sqm }} / {{ $share }}
                                                        %
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="card card-raised">
                            <div class="card-body">
                                <h2 class="overline">Country Wise Stats Approved Applications</h2>
                                <div class="list-group list-group-flush list-group-light">
                                    <div class="list-group-item d-flex justify-content-between px-0">
                                        <div class="me-2">Total Countries</div>
                                        <div class="text-end"><strong>{{ $totalApprovedCountries }}</strong></div>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between px-0">
                                        <div class="me-2">Total Application</div>
                                        <div class="text-end">
                                            <strong>{{ $approvedIndiaInternationalStats->india_count + $approvedIndiaInternationalStats->international_count }}</strong>
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between px-0">
                                        <div class="caption font-monospace ">India</div>
                                        <div class="caption font-monospace  ms-2 text-end">
                                            {{ $approvedIndiaInternationalStats->india_count }} /
                                            {{ $approvedIndiaInternationalStats->india_sqm }} sqm
                                        </div>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between px-0">
                                        <div class="caption font-monospace ">International</div>
                                        <div class="caption font-monospace  ms-2 text-end">
                                            {{ $approvedIndiaInternationalStats->international_count }} /
                                            {{ $approvedIndiaInternationalStats->international_sqm }} sqm
                                        </div>
                                    </div>

                                    @php
                                        $app_tots =
                                            $approvedIndiaInternationalStats->india_sqm +
                                            $approvedIndiaInternationalStats->international_sqm;
                                    @endphp

                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Country</th>
                                                <th>Total Companies</th>
                                                <th>Total SQM / Share</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($approvedApplicationsByCountry as $data)
                                                @php
                                                    $share = ($data->total_sqm / $app_tots) * 100;
                                                    $share = number_format($share, 2);
                                                @endphp
                                                <tr>
                                                    <td>{{ $data->country_name }}</td>
                                                    <td class="text-center">{{ $data->total_companies }}</td>
                                                    <td class="text-center">{{ $data->total_sqm }} / {{ $share }}
                                                        %
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                @endif


            </div>
        </div>
    {{--    <form method="POST" action="{{ route('logout') }}"> --}}
    {{--        @csrf --}}
    {{--        <button type="submit">Logout</button> --}}
    {{--    </form> --}}

@endsection
