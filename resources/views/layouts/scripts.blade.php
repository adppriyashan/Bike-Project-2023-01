<script src="{{ asset('assets/app-assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('assets/app-assets/data/jvector/visitor-data.js') }}"></script>
<script src="{{ asset('assets/app-assets/js/core/app-menu.js') }}"></script>
<script src="{{ asset('assets/app-assets/js/trix.js') }}"></script>
<script src="{{ asset('assets/app-assets/js/core/app.js') }}"></script>
<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"
    integrity="sha512-CNgIRecGo7nphbeZ04Sc13ka07paqdeTu0WR1IM4kNcpmBAUSHSQX0FslNhTDadL4O5SAGapGt4FodqL8My0mA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src='https://cdn.plot.ly/plotly-2.14.0.min.js'></script>

<script>
    $('#isnew').change(function(e) {
        let submitbtn = $('#submitbtn');
        if ($(this).val() == '1') {
            submitbtn.removeClass('btn-success btn-warning').addClass('btn-success')
                .val('Submit');
        } else {
            submitbtn.removeClass('btn-success btn-warning').addClass('btn-warning')
                .val('Update');
        }
    });

    $('#resetbtn').click(function(e) {
        e.preventDefault();
        $('#' + $(this).attr('form')).trigger("reset");
        $('#isnew').val('1').trigger('change');
        $('.textarea').html('');
        $('.readonly').removeAttr('readonly');
        $('.permissions').bootstrapToggle('off');
        $('.select2reset').val(null).trigger('change');
    });

    function refreshTable() {
        listTable.search('');
        listTable.ajax.reload();
    }

    function showAlertWithCancel(message, func, funcCancel) {
        $.confirm({
            title: 'Confirmation',
            content: message,
            buttons: {
                cancel: funcCancel,
                confirm: {
                    btnClass: 'btn-primary',
                    text: 'OK',
                    action: func
                }
            }
        });
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function showWarning(message) {
        $.alert({
            title: 'OoPs !',
            content: message,
        });
    }

    function showSuccess(message) {
        $.alert({
            title: 'Successfull',
            content: message,
        });
    }

    function showMessage(message) {
        $.alert({
            title: 'Feedback',
            content: message,
        });
    }

    function showAlert(message, func) {
        $.confirm({
            title: 'Confirmation',
            content: message,
            buttons: {
                cancel: function() {},
                confirm: {
                    btnClass: 'btn-primary',
                    text: 'OK',
                    action: func
                }
            }
        });
    }

    $("#image").on("change", function(e) {
        var output = document.getElementById("imageview");
        output.src = URL.createObjectURL(e.target.files[0]);
        output.onload = function() {
            URL.revokeObjectURL(output.src);
        };
    });

    $("#excel_file").on("change", function(e) {
        if (e.target.files[0]) {
            $('#excel_file_chooser').html(e.target.files[0].name);
            $('#excel_file_chooser').removeClass('btn-primary').addClass('btn-success');
            $('#upload_excel_btn').removeClass('d-none');
        }
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>
