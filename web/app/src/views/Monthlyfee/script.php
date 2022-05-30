<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            ajax: {
                url: '?route=monthlyfee_all',
                type: 'GET',
                contentType: 'application/json',
                success: function(data) {
                    console.log(data.body);

                    if (data.msg == "success") {
                        $.each(data.body, function(index, value) {
                            $('#dataTable').dataTable().fnAddData([
                                value.id,
                                value.contract_id,
                                value.status,
                                "R$ " + value.value,
                                value.reference_month,
                                value.expiration,
                                '<div class="btn-group" role="group" aria-label="Basic example">' +
                                '<button type="button" class="btn btn-outline-success" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight_" aria-controls="offcanvasRight_" onclick="editMonthlyfee(' + value.id + ',' + value.contract_id + ')">Edit</button>' +
                                '<button type="button" class="btn btn-outline-danger" onclick="deleteContract(' + value.id + ')">Delete</button>' +
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

        $('.date').mask('0000-00-00');
        $('.money').mask('###0.00', {
            reverse: true
        });
    });

    function submitMonthlyfee() {
        var contract_id = $('#contract').val();
        var status = $('#status').val();
        var value = $('#value').val();
        var reference_month = $('#reference_month').val();
        var expiration = $('#expiration').val();

        if (
            (contract_id != "") &&
            (status != "") &&
            (value != "") &&
            (reference_month != "") &&
            (expiration != "")
        ) {

            postMonthlyfee(
                contract_id,
                status,
                value,
                reference_month,
                expiration
            );

        } else {
            alertCustomizer("Fill in all fields", '#c86864');
        }
    }

    function postMonthlyfee(
        contract_id,
        status,
        value,
        reference_month,
        expiration
    ) {

        $('.loading').css('display', 'block');

        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");
        myHeaders.append("Accept", "application/json");

        var raw = JSON.stringify({
            "contract_id": contract_id,
            "status": status,
            "value": value,
            "reference_month": reference_month,
            "expiration": expiration
        });

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        fetch("?route=monthlyfee_add", requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "already exists") {
                    alertCustomizer("Already exists", '#c86864');

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

    function deleteContract(id) {
        $('.loading').css('display', 'block');

        var requestOptions = {
            method: 'GET',
            redirect: 'follow'
        };

        fetch("?route=contract_delete&params=" + id, requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("Not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    alertCustomizer("Success", 'blue');

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

    function editMonthlyfee(id, contract_id) {

        $('.loading').css('display', 'block');

        var myHeaders = new Headers();
        myHeaders.append("Accept", "application/json");
        myHeaders.append("Content-Type", "application/json");

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch("?route=contract_all", requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    var select = '';
                    $.each(result.body, function(index, value) {
                        if (contract_id == value.id) {
                            select += '<option selected value="' + value.id + '">' + value.id + '</option>';
                        } else {
                            select += '<option value="' + value.id + '">' + value.id + '</option>';
                        }
                    });

                    $('#update_contract').html("");
                    $('#update_contract').append(select);
                    $('.loading').css('display', 'none');
                }
            })
            .catch(error => {

                console.log('error', error);
                $('.loading').css('display', 'none');

                alertCustomizer("There was an error", '#c86864');

            });

        fetch("?route=monthlyfee_find&params=" + id, requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    $('#id_update').val(result.body[0].id);
                    $('#update_status').val(result.body[0].status);
                    $('#update_value').val(result.body[0].value);
                    $('#update_reference_month').val(result.body[0].reference_month);
                    $('#update_expiration').val(result.body[0].expiration);

                    $('.loading').css('display', 'none');
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

    function submitMonthlyfeeUpdate() {

        var id = $('#id_update').val();
        var contract_id = $('#update_contract').val();
        var status = $('#update_status').val();
        var value = $('#update_value').val();
        var reference_month = $('#update_reference_month').val();
        var expiration = $('#update_expiration').val();

        if (
            (contract_id != "") &&
            (status != "") &&
            (value != "") &&
            (reference_month != "") &&
            (expiration != "")
        ) {

            postMonthlyfeeUpdate(
                id,
                contract_id,
                status,
                value,
                reference_month,
                expiration
            );

        } else {
            alertCustomizer("Fill in all fields", '#c86864');
        }
    }

    function postMonthlyfeeUpdate(
        id,
        contract_id,
        status,
        value,
        reference_month,
        expiration
    ) {
        $('.loading').css('display', 'block');

        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        var raw = JSON.stringify({
            "contract_id": contract_id,
            "status": status,
            "value": value,
            "reference_month": reference_month,
            "expiration": expiration
        });

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        fetch("?route=monthlyfee_update&params=" + id, requestOptions)
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

    function getAllSelects() {
        $('.loading').css('display', 'block');

        var myHeaders = new Headers();
        myHeaders.append("Accept", "application/json");
        myHeaders.append("Content-Type", "application/json");

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch("?route=contract_all", requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    var select = '<option selected>Select contract</option>';
                    $.each(result.body, function(index, value) {
                        select += '<option value="' + value.id + '">' + value.id + '</option>';
                    });

                    $('#contract').html("");
                    $('#contract').append(select);
                    $('.loading').css('display', 'none');
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