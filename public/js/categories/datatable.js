


// jQuery(".form-valide-with-icon").validate({
//     rules: {
//         "name": {
//             required: !0,
//             minlength: 3
//         },
//     },
//     messages: {
//         "name": {
//             required: "Please enter a category name",
//         },
//     },

//     ignore: [],
//     errorClass: "invalid-feedback animated fadeInUp",
//     errorElement: "div",
//     errorPlacement: function(e, a) {
//         jQuery(a).parents(".form-group > div").append(e)
//     },
//     highlight: function(e) {
//         jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
//     },
//     success: function(e) {
//         jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-valid")
//     }

// });

jQuery(".form-valide").validate({
    rules: {
        "name": {
            required: !0,
            minlength: 3
        },
    },
    messages: {
        "name": {
            required: "Please enter a category name",
        },
    },

    ignore: [],
    errorClass: "invalid-feedback animated fadeInUp",
    errorElement: "div",
    errorPlacement: function (e, a) {
        jQuery(a).parents(".form-group > div").append(e)
    },
    highlight: function (e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid").addClass("is-invalid")
    },
    success: function (e) {
        jQuery(e).closest(".form-group").removeClass("is-invalid"), jQuery(e).remove()
    },
});

$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    const form = $('#category_form');
    const submitButton = $('#category_submit');

    form.on('submit', function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        console.log(formData.get('name'));
        let url = '/categories';
        let method = 'POST';
        let updateId = submitButton.attr("update-field");
        if (updateId) {
            url += `/${updateId}`;
            formData.append("_method", "PUT");
        }

        $.ajax({
            url: url,
            method: method,
            dataType: 'json',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log('success');
                updateId = null;
            },
            error: function (xhr, status, message) {
                if (xhr.responseJSON.errors != undefined) {
                    let err = "";
                    for (const key in xhr.responseJSON.errors) {
                        const element =
                            xhr.responseJSON.errors[key];
                        err += element + "\n";
                    }
                    Swal.fire({
                        text: err,
                        icon: "error",
                        confirmButtonText: "Ok, got it!",
                        showCloseButton: true,
                    });
                }
                if (xhr.responseJSON.error != undefined) {
                    toastr.error(xhr.responseJSON.message);
                }
            },
        });
    })
})
