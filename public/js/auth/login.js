(function ($) {
    "use strict";

    /*==================================================================
    [ Focus Contact2 ]*/
    $(".input100").each(function () {
        $(this).on("blur", function () {
            if ($(this).val().trim() != "") {
                $(this).addClass("has-val");
            } else {
                $(this).removeClass("has-val");
            }
        });
    });

    /*==================================================================
    [ Validate ]*/
    var input = $(".validate-input .input100");

    $(".validate-form").on("submit", function (e) {
        e.preventDefault();

        var check = true;
        let formData = new FormData(this);

        for (var i = 0; i < input.length; i++) {
            if (validate(input[i]) == false) {
                showValidate(input[i]);
                check = false;
            }
        }

        if (!check) {
            return check;
        }


        $.ajax({
            url: "authenticate",
            method: "POST",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            success: function (response) {
                window.location.href = '/';
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
                if (xhr.responseJSON.message != undefined) {
                    toastr.error(xhr.responseJSON.message);
                }
            },
        });
    });

    $(".validate-form .input100").each(function () {
        $(this).focus(function () {
            hideValidate(this);
        });
    });

    function validate(input) {
        if (
            $(input).attr("type") == "email" ||
            $(input).attr("name") == "email"
        ) {
            if (
                $(input)
                    .val()
                    .trim()
                    .match(
                        /^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{1,5}|[0-9]{1,3})(\]?)$/
                    ) == null
            ) {
                return false;
            }
        } else {
            if ($(input).val().trim() == "") {
                return false;
            }
        }
    }

    function showValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).addClass("alert-validate");
    }

    function hideValidate(input) {
        var thisAlert = $(input).parent();

        $(thisAlert).removeClass("alert-validate");
    }

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    // $('#login_form').on('submit',function(e){

    // })
})(jQuery);
