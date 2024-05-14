@extends('master')

@section('styles')
    <link href="{{ asset('plugins/tables/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#categoryModal">Launch demo modal</button> --}}

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pt-0">
                        {{-- <h4 class="card-title">Data Table</h4> --}}
                        <div class="table-responsive-xl">
                            <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4 p-0">

                                <div class="top d-flex">
                                    <div><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#categoryModal">Add Category</button></div>

                                </div>
                                {{-- <div class="row">
                                    <div class="col-sm-12"> --}}
                                <table
                                    class="table table-responsive-xl table-striped table-bordered zero-configuration dataTable p-0"
                                    id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                    <thead>
                                        <tr role="row">
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>

                                </table>
                                {{-- </div>
                                </div> --}}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Start -->
    <div class="modal fade" id="categoryModal">
        <div class="modal-dialog modal-dialog" role="document">
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
                            <div class="col-lg-8">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter a name..">
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
    {{-- <script src="{{ asset('plugins/validation/jquery.validate-init.js') }}"></script> --}}
    <script src="{{ asset('plugins/tables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/tables/js/datatable/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('js/categories/datatable.js') }}"></script>
@endsection
