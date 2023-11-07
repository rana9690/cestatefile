var urlController = '';
var submitText = '';
function getUrl() {
    return urlController;
}
function getSubmitText() {
    return submitText;
}
function linkCase(type,filing_no) {
    // reset the form
    $("#data-form")[0].reset();
    $(".form-control").removeClass('is-invalid').removeClass('is-valid');
    urlController = 'suggestedcase/validatecode';
    submitText = 'SAVE';
    $.ajax({
        url: 'suggestedcase/getOne',
        type: 'post',
        data: {
            type:type,
            filing_no: filing_no,
            csrf_token:$("#csrf_token").val(),
        },
        dataType: 'json',
        success: function (response) {
            $("input[name='"+_CSRF_NAME_+"']").val(response.csrf_token);
            if(response.filing_no) {
                $('#model-header').removeClass('bg-success').addClass('bg-dark');
                $("#info-header-modalLabel").text('Validate Token');
                $("#form-btn").text(submitText);
                $('#data-modal').modal('show');
                //insert data to form
                $("#data-form #filing_no").val(response.filing_no);
                if(response.appfiling_no) {
                    $("#data-form #appfiling_no").val(response.appfiling_no);
                }
                $("#data-form #type").val(type);
               /* var List=response.dtls;
                if(List.length>0) {
                    var div_data2 = '<tr><th colspan="3" class="text-center">Last Added Payments</th></tr><tr><th>Tr. No.</th><th>Tr. Date</th><th>Amount</th></tr>'
                    for (i in List) {
                        div_data2 += '<tr><td>' + List[i].dd_no + '</td><td>' + List[i].dd_date + '</td><td>' + List[i].amount + '</td></tr>';
                    }
                    $('#feeDetail').html('');
                    $('#feeDetail').html(div_data2);
                }*/



            }else
            {
                Swal.fire({
                    toast: false,
                    position: 'bottom-end',
                    icon: 'error',
                    title:response.messages,
                    showConfirmButton: false,
                    timer: 3000
                })
            }
        }
    });

    $.validator.setDefaults({
        highlight: function(element) {
            $(element).addClass('is-invalid').removeClass('is-valid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid').addClass('is-valid');
        },
        errorElement: 'div ',
        errorClass: 'invalid-feedback',
        errorPlacement: function(error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if ($(element).is('.select')) {
                element.next().after(error);
            } else if (element.hasClass('select2')) {
                //error.insertAfter(element);
                error.insertAfter(element.next());
            } else if (element.hasClass('selectpicker')) {
                error.insertAfter(element.next());
            } else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) {
            var form = $('#data-form');
            $(".text-danger").remove();
            $.ajax({
                // fixBug get url from global function only
                // get global variable is bug!
                url: getUrl(),
                type: 'post',
                data: form.serialize(),
                cache: false,
                dataType: 'json',
                beforeSend: function() {
                    $('#form-btn').html('<i class="fa fa-spinner fa-spin"></i>');
                },
                success: function(response) {
                    if (response.success === true) {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: response.messages,
                            showConfirmButton: false,
                            timer: 1500
                        }).then(function() {
                            // $('#data_table').DataTable().ajax.reload(null, false).draw(false);
                            $('#data-modal').modal('hide');
                        })
						 setTimeout(function(){
                    window.location.reload(true);
                }, 500);
                    } else {
                        if (response.messages instanceof Object) {
                            $.each(response.messages, function(index, value) {
                                var ele = $("#" + index);
                                ele.closest('.form-control')
                                    .removeClass('is-invalid')
                                    .removeClass('is-valid')
                                    .addClass(value.length > 0 ? 'is-invalid' : 'is-valid');
                                ele.after('<div class="invalid-feedback">' + response.messages[index] + '</div>');
                            });
                        } else {
                            Swal.fire({
                                toast: false,
                                position: 'bottom-end',
                                icon: 'error',
                                title: response.messages,
                                showConfirmButton: false,
                                timer: 3000
                            })

                        }
                    }
					
                    $('#form-btn').html(getSubmitText());
                }
            });
            return false;
        }
    });

    $('#data-form').validate({

        //insert data-form to database

    });
}