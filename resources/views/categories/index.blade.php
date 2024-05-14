@extends('master')

@section('content')

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">Launch demo modal</button>

<!-- Modal Start -->
<div class="modal fade" id="exampleModalCenter">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-valide" action="#" method="post" id="category_form">
                    @csrf
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label" for="name">Name <span class="text-danger">*</span>
                        </label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter a name..">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="category_submit" update-field="">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Modal Start -->
@endsection

@section('scripts')
<script src="{{asset('plugins/validation/jquery.validate-init.js')}}"></script>
<script src="{{asset('js/categories/datatable.js')}}"></script>
@endsection
