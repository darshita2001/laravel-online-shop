var KTDatatablesDataSourceAjaxServer = (function () {
    var initTable1 = function () {
        var table = $("#DataTables_Table_0");

        // begin first table
        datatable = table.DataTable({
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [1, "asc"],
            dom: '<"top"f>rt<"bottom"ilp><"clear">',
            ajax: {
                url: "/categories/datatable",
                type: "POST",
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.error(jqXHR.responseJSON.message);
                },
            },
            columns: [{ data: "id" }, { data: "name" }, { data: "id" }],
            columnDefs: [
                {
                    targets: 0,
                    title: "SN",
                    orderable: false,
                    render: function (data, type, full, meta) {
                        let start = datatable.ajax.params().start;
                        return start + meta.row + 1;
                    },
                },
                {
                    targets: 1,
                    title: "name",
                    // className: "text-center",
                },

                {
                    targets: -1,
                    title: "Actions",
                    orderable: false,
                    className: "text-center min-w-150px",
                    render: function (data, type, full, meta) {
                        var action = `<a href="javascript:" data-toggle="modal" data-target="#categoryModal" data-id="${data}" data-placement="top" title="Edit" data-original-title="Edit" class="mr-3 edit-category">\
                                      <i class="fa fa-pencil color-muted m-r-5"></i>\
                                      </a>`;
                        action += `<a href="javascript:" data-toggle="tooltip" data-placement="top" title="Delete" data-id="${data}" data-original-title="Delete" class="delete-category">\
                            <i class="fa fa-trash color-muted m-r-5"></i>\
                            </a>`;

                        return action;
                    },
                },
            ],
            initComplete: function () {
                // Move the length and pagination controls to the same line with vertical alignment
                var table = $("#DataTables_Table_0").DataTable();
                var bottom = $(table.table().container()).find("div.bottom");
                bottom
                    .css("display", "flex")
                    .css("align-items", "center")
                    .css("justify-content", "space-between");
            },
        });
        datatable.on("xhr", function (e) {
            // console.log(e);
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            initTable1();
        },
    };
})();

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    KTDatatablesDataSourceAjaxServer.init();

    const form = $("#category_form");
    const submitButton = $("#category_submit");

    form.on("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        let url = "/categories";
        let method = "POST";
        let updateId = submitButton.attr("update-field");
        if (updateId) {
            url += `/${updateId}`;
            formData.append("_method", "PUT");
        }

        $.ajax({
            url: url,
            method: method,
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                updateId = null;
                $("#categoryModal").modal("hide");
                toastr.success(response.message);
                submitButton.attr("update-field", "");
                datatable.ajax.reload(null, false);
            },
            error: function (xhr, status, message) {
                if (xhr.responseJSON.errors != undefined) {
                    let err = "";
                    for (const key in xhr.responseJSON.errors) {
                        const element = xhr.responseJSON.errors[key];
                        err += element + "\n";
                    }

                    sweetAlert("Oops...", err, "error");
                }
                if (xhr.responseJSON.error != undefined) {
                    toastr.error(xhr.responseJSON.message);
                }
            },
        });
    });

    $("#categoryModal").on("hide.bs.modal", function () {
        form[0].reset();
        submitButton.attr("update-field", "");
    });

    $(document).on("click", ".edit-category", function () {
        let id = $(this).data("id");
        submitButton.attr("update-field", id);

        $.ajax({
            url: `categories/${id}/edit`,
            method: "GET",
            success: function (response) {
                let data = response.data;
                $("#name").val(data[0].name);
                submitButton.attr("update-field", data.id);
            },
            error: function (xhr, status, message) {
                if (xhr.responseJSON.errors != undefined) {
                    let err = "";
                    for (const key in xhr.responseJSON.errors) {
                        const element = xhr.responseJSON.errors[key];
                        err += element + "\n";
                    }

                    sweetAlert("Oops...", err, "error");
                }
                if (xhr.responseJSON.error != undefined) {
                    toastr.error(xhr.responseJSON.message);
                }
            },
        });
    });

    $(document).on("click", ".delete-category", function () {
        let id = $(this).data("id");

        swal(
            {
                title: "",
                text: "Are you sure to delete this category?",
                type: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Yes, delete it !!",
                closeOnConfirm: !1,
            },
            function () {
                $.ajax({
                    method: "delete",
                    url: `categories/${id}`,
                    success: function (response) {
                        toastr.success(response.message);
                        datatable.ajax.reload(null, false);
                        swal(
                            "Deleted !!",
                            response.message,
                            "success"
                        );
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        sweetAlert("Oops...", jqXHR.responseJSON.message, "error");

                    },
                });
            }
        );
    });
});
