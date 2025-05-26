@extends('admin.layouts.app')

@section('style')
<!-- Add your styles here -->
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders List</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('admin.layouts._massage')
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Orders List</h3>
                        </div>
                        <div class="card-body p-8" style="overflow: auto;">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Company Name</th>
                                        <th>County</th>
                                        <th>Address One</th>
                                        <th>Address Two</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Postcode</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Total Amount ($)</th>
                                        <th>Payment Method</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getRecord as $value)
                                    <tr>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->first_name }}</td>
                                        <td>{{ $value->last_name }}</td>
                                        <td>{{ $value->company_name }}</td>
                                        <td>{{ $value->county }}</td>
                                        <td>{{ $value->address_one }}</td>
                                        <td>{{ $value->address_two }}</td>
                                        <td>{{ $value->city }}</td>
                                        <td>{{ $value->state }}</td>
                                        <td>{{ $value->postcode }}</td>
                                        <td>{{ $value->phone }}</td>
                                        <td>{{ $value->email }}</td>
                                        <td>{{ number_format((float)$value->total_amount, 2) }}</td>
                                        <td style="text-transform: capitalize;">{{ $value->payment_method }}</td>
                                        <td>{{ $value->status }}</td>
                                        <td>{{ date('d-m-Y h:i A', strtotime($value->created_at)) }}</td>
                                        <td><!-- Add any action buttons here --></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
