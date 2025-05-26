@extends('admin.layouts.app')

@section('style')
@endsection

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Edit Brand</h1>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <form action="" method="post">
                            {{ csrf_field() }}
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Brand Name<span style="color:red">*</span> </label>
                                    <input type="text" class="form-control" required value="{{ old('name' , $getRecord->name) }}" name="name" placeholder="Brand Name">
                                </div>

                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Slug<span style="color:red">*</span></label>
                                        <input type="text" class="form-control" required value="{{ old('slug' , $getRecord->slug) }}" name="slug" placeholder="slug Ex. URL">
                                        
                                    </div>

                                <div class="form-group">
                                    <label>Status<span style="color:red">*</span></label>
                                    <select class="form-control" name="status" required>
                                        <option value="1" {{ old('status', $getRecord->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $getRecord->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <div class="form-group">
                                <label>Meta title<span style="color:red">*</span></label>
                                <input type="text" class="form-control" required name="meta_title" placeholder="Meta title" value="{{ old('meta_title', $getRecord->meta_title) }}">
                            </div>
                            
                            <div class="form-group">
                                <label>Meta Description</label>
                                <textarea class="form-control" placeholder="Meta Description" name="meta_description">{{ old('meta_description', $getRecord->meta_description) }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label>Meta Keywords</label>
                                <input type="text" class="form-control" name="meta_keywords" placeholder="Meta Keywords" value="{{ old('meta_keywords', $getRecord->meta_keywords) }}">
                            </div>
                            

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('script')
@endsection
