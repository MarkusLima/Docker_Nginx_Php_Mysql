<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            ajax: {
                url: '?route=transfer_all',
                type: 'GET',
                contentType: 'application/json',
                success: function(data) {
                    console.log(data.body);

                    if (data.msg == "success") {
                        $.each(data.body, function(index, value) {
                            $('#dataTable').dataTable().fnAddData([
                                value.id,
                                value.monthlyfee_id,
                                value.status,
                                "R$ " + value.value,
                                '<div class="btn-group" role="group" aria-label="Basic example">' +
                                '<button type="button" class="btn btn-outline-success" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight_" aria-controls="offcanvasRight_" onclick="editTransfer(' + value.id + ')">Edit</button>' +
                                '</div>'
                            ]);
                        });
                    }
                },
                error: function(e) {
                    console.log("There was an error with your request...");
                    console.log("error: " + JSON.stringify(e));
                }
            }
        });

    });

    function editTransfer(id) {

        console.log(id);
        // console.log(monthly_fee);
        // console.log(status);
        // console.log(value);
        // $('#id_update').val(id);
        // $('#update_monthly_fee').val(monthly_fee);

        // if(status == "Paid"){
        //     $('#update_status').attr('disabled', 'disabled');
        // }

        // $('#update_value').val(value);

        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch("?route=transfer_find&params=" + id, requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {
                    alertCustomizer("Not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    $('#id_update').val(id);
                    $('#update_monthly_fee').val(result.body[0].monthlyfee_id);

                    if (result.body[0].status == "Paid") {
                        $('#update_status').attr('disabled','disabled');
                        $('#update_status').val('Paid');
                    }else{
                        $('#update_status').attr('disabled', false);
                        $('#update_status').val('Pending');
                    }

                    $('#update_value').val(result.body[0].value);

                }

            })
            .catch(error => {

                console.log('error', error);
                $('.loading').css('display', 'none');

                alertCustomizer("There was an error", '#c86864');

            });

    }

    function alertCustomizer(text, color) {
        $.toast({
            text: text,
            showHideTransition: 'slide', // It can be plain, fade or slide
            bgColor: color, // Background color for toast
            textColor: '#eee', // text color
            allowToastClose: true, // Show the close button or not
            hideAfter: 4000, // `false` to make it sticky or time in miliseconds to hide after
            stack: 5, // `fakse` to show one stack at a time count showing the number of toasts that can be shown at once
            textAlign: 'left', // Alignment of text i.e. left, right, center
            position: 'top-right' // bottom-left or bottom-right or bottom-center or top-left or top-right or top-center or mid-center or an object representing the left, right, top, bottom values to position the toast on page
        })
    }

    function submitTransferUpdate() {

        var id = $('#id_update').val();
        var monthlyfee_id = $('#update_monthly_fee').val();
        var status = $('#update_status').val();
        var value = $('#update_value').val();

        if (
            (monthlyfee_id != "") &&
            (status != "") &&
            (value != "")
        ) {

            postTransferUpdate(
                id,
                monthlyfee_id,
                status,
                value
            );

        } else {
            alertCustomizer("Fill in all fields", '#c86864');
        }
    }

    function postTransferUpdate(
        id,
        monthlyfee_id,
        status,
        value
    ) {
        $('.loading').css('display', 'block');

        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        var raw = JSON.stringify({
            "monthlyfee_id": monthlyfee_id,
            "status": status,
            "value": value
        });

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        fetch("?route=transfer_update&params=" + id, requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {
                    alertCustomizer("Not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    alertCustomizer("Success!", 'blue');

                    setTimeout(() => {
                        window.location.reload();
                    }, 4000);
                }

            })
            .catch(error => {

                console.log('error', error);
                $('.loading').css('display', 'none');

                alertCustomizer("There was an error", '#c86864');

            });
    }
</script>

</html>