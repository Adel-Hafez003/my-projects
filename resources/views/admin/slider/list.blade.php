@extends('admin.layouts.app')

@section('style')
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @include('admin.layouts._massage')
                    
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Slider List</h3>
                        </div>
                        
                        <div class="card-body p-8">
                            <!-- Button to add a new slider -->
                            <div class="row mb-2">
                                <div class="col-sm-12 text-right">
                                    <a href="{{ url('admin/slider/add') }}" class="btn btn-primary">Add New Slider</a>
                                </div>
                            </div>
                            
                            <!-- Table displaying sliders -->
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Button Name</th>
                                        <th>Button Link</th>
                                        <th>Status</th>
                                        <th>Created Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($getRecord as $value)
                                        <tr>
                                            <td>{{ $value->id }}</td>
                                            <td>
                                                @if(!empty($value->getImage()))
                                                    <img src="{{ $value->getImage() }}" style="height: 100px;">
                                                @else
                                                    <span>No Image</span>
                                                @endif
                                            </td>
                                            <td>{{ $value->title }}</td>
                                            <td>{{ $value->button_name }}</td>
                                            <td>{{ $value->button_link }}</td>
                                            <td>{{ $value->status == 'e' ? 'Active' : 'Inactive' }}</td>
                                            <td>{{ date('d-m-Y', strtotime($value->created_at)) }}</td>
                                            <td>
                                            <a href="{{ url('admin/slider/edit/' . $value->id) }}" class="btn btn-primary">Edit</a>
                                            <a href="{{ url('admin/slider/delete/' . $value->id) }}" class="btn btn-danger">Delete</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            
                            <!-- Pagination links -->
                            <div style="padding: 10px; float: right;">
                                {!! $getRecord->appends(Illuminate\Support\Facades\Request::except('page'))->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
@endsection
