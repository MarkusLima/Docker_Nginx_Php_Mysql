<script>
    $(document).ready(function() {

        $('#dataTable').DataTable({
            ajax: {
                url: '?route=contract_all',
                type: 'GET',
                contentType: 'application/json',
                success: function(data) {
                    console.log(data.body);

                    if (data.msg == "success") {
                        $.each(data.body, function(index, value) {
                            $('#dataTable').dataTable().fnAddData([
                                value.id,
                                value.property_id,
                                value.owner_id,
                                value.client_id,
                                value.start_date,
                                value.end_date,
                                'R$ ' + value.administrative_fee,
                                'R$ ' + value.rent_value,
                                'R$ ' + value.condominium_value,
                                'R$ ' + value.iptu_value,
                                '<div class="btn-group" role="group" aria-label="Basic example">' +
                                '<button type="button" class="btn btn-outline-success" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight_" aria-controls="offcanvasRight_" onclick="editContract(' + value.id + ',' + value.property_id + ',' + value.owner_id + ',' + value.client_id + ')">Edit</button>' +
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

        $('tbody tr .phone_number').mask('(00)0000-0000');
        $('#phone_number').mask('(00)00000-0000');
        $('#update_phone_number').mask('(00)00000-0000');
        $('#start_date').mask('0000-00-00');
        $('#end_date').mask('0000-00-00');
        $('.money').mask('###0.00', {
            reverse: true
        });
    });

    function submitContract() {
        var property_id = $('#property').val();
        var owner_id = $('#owner_id').val();
        var client_id = $('#client').val();
        var start_date = $('#start_date').val();
        var end_date = $('#end_date').val();
        var administrative_fee = $('#administrative_fee').val();
        var rent_value = $('#rent_value').val();
        var condominium_value = $('#condominium_value').val();
        var iptu_value = $('#iptu_value').val();

        if (
            (property_id != "") &&
            (owner_id != "") &&
            (client_id != "") &&
            (start_date != "") &&
            (end_date != "") &&
            (administrative_fee != "") &&
            (rent_value != "") &&
            (condominium_value != "") &&
            (iptu_value != "")
        ) {

            postContract(
                property_id,
                owner_id,
                client_id,
                start_date,
                end_date,
                administrative_fee,
                rent_value,
                condominium_value,
                iptu_value
            );

        } else {
            alertCustomizer("Fill in all fields", '#c86864');
        }
    }

    function postContract(
        property_id,
        owner_id,
        client_id,
        start_date,
        end_date,
        administrative_fee,
        rent_value,
        condominium_value,
        iptu_value
    ) {

        $('.loading').css('display', 'block');

        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");
        myHeaders.append("Accept", "application/json");

        var raw = JSON.stringify({
            "property_id": property_id,
            "owner_id": owner_id,
            "client_id": client_id,
            "start_date": start_date,
            "end_date": end_date,
            "administrative_fee": administrative_fee,
            "rent_value": rent_value,
            "condominium_value": condominium_value,
            "iptu_value": iptu_value
        });

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        fetch("?route=contract_add", requestOptions)
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

    function editContract(id, property_id, owner_id, client_id) {

        $('.loading').css('display', 'block');


        var myHeaders = new Headers();
        myHeaders.append("Accept", "application/json");
        myHeaders.append("Content-Type", "application/json");

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch("?route=property_all", requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    var select = '';
                    $.each(result.body, function(index, value) {
                        if (property_id == value.id) {
                            select += '<option id_owner="' + value.owner_id + '" selected value="' + value.id + '">' + value.address + '</option>';
                        } else {
                            select += '<option id_owner="' + value.owner_id + '" value="' + value.id + '">' + value.address + '</option>';
                        }
                    });

                    $('#update_property').html("");
                    $('#update_property').append(select);
                    $('.loading').css('display', 'none');
                }
            })
            .catch(error => {

                console.log('error', error);
                $('.loading').css('display', 'none');

                alertCustomizer("There was an error", '#c86864');

            });

        fetch("?route=client_all", requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    var select = '';
                    $.each(result.body, function(index, value) {
                        if (client_id == value.id) {
                            select += '<option selected value="' + value.id + '">' + value.name + '</option>';
                        } else {
                            select += '<option value="' + value.id + '">' + value.name + '</option>';
                        }
                    });

                    $('#update_client').html("");
                    $('#update_client').append(select);
                    $('.loading').css('display', 'none');
                }
            })
            .catch(error => {

                console.log('error', error);
                $('.loading').css('display', 'none');

                alertCustomizer("There was an error", '#c86864');

            });

        fetch("?route=owner_find&params=" + owner_id, requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    $('#update_owner').val(result.body[0].name);

                    $('.loading').css('display', 'none');
                }
            })
            .catch(error => {

                console.log('error', error);
                $('.loading').css('display', 'none');

                alertCustomizer("There was an error", '#c86864');

            });

        fetch("?route=contract_find&params=" + id, requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    $('#id_update').val(result.body[0].id);
                    $('#update_start_date').val(result.body[0].start_date);
                    $('#update_end_date').val(result.body[0].end_date);
                    $('#update_administrative_fee').val(result.body[0].administrative_fee);
                    $('#update_rent_value').val(result.body[0].rent_value);
                    $('#update_condominium_value').val(result.body[0].condominium_value);
                    $('#update_iptu_value').val(result.body[0].iptu_value);

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

    function submitContractUpdate() {

        var id = $('#id_update').val();
        var property_id = $('#update_property').val();
        var owner_id = $('#update_owner_id').val();
        var client_id = $('#update_client').val();
        var start_date = $('#update_start_date').val();
        var end_date = $('#update_end_date').val();
        var administrative_fee = $('#update_administrative_fee').val();
        var rent_value = $('#update_rent_value').val();
        var condominium_value = $('#update_condominium_value').val();
        var iptu_value = $('#update_iptu_value').val();

        if (
            (property_id != "") &&
            (owner_id != "") &&
            (client_id != "") &&
            (start_date != "") &&
            (end_date != "") &&
            (administrative_fee != "") &&
            (rent_value != "") &&
            (condominium_value != "") &&
            (iptu_value != "")
        ) {

            postContractUpdate(
                id,
                property_id,
                owner_id,
                client_id,
                start_date,
                end_date,
                administrative_fee,
                rent_value,
                condominium_value,
                iptu_value
            );

        } else {
            alertCustomizer("Fill in all fields", '#c86864');
        }
    }

    function postContractUpdate(
        id,
        property_id,
        owner_id,
        client_id,
        start_date,
        end_date,
        administrative_fee,
        rent_value,
        condominium_value,
        iptu_value
    ) {
        $('.loading').css('display', 'block');

        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        var raw = JSON.stringify({
            "property_id": property_id,
            "owner_id": owner_id,
            "client_id": client_id,
            "start_date": start_date,
            "end_date": end_date,
            "administrative_fee": administrative_fee,
            "rent_value": rent_value,
            "condominium_value": condominium_value,
            "iptu_value": iptu_value
        });

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        fetch("?route=contract_update&params=" + id, requestOptions)
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

        fetch("?route=property_all", requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    var select = '<option selected>Select property</option>';
                    $.each(result.body, function(index, value) {
                        select += '<option id_owner="' + value.owner_id + '" value="' + value.id + '">' + value.address + '</option>';
                    });

                    $('#property').html("");
                    $('#property').append(select);
                    $('.loading').css('display', 'none');
                }
            })
            .catch(error => {

                console.log('error', error);
                $('.loading').css('display', 'none');

                alertCustomizer("There was an error", '#c86864');

            });

        fetch("?route=client_all", requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    var select = '<option selected>Select client</option>';
                    $.each(result.body, function(index, value) {
                        select += '<option value="' + value.id + '">' + value.name + '</option>';
                    });

                    $('#client').html("");
                    $('#client').append(select);
                    $('.loading').css('display', 'none');
                }
            })
            .catch(error => {

                console.log('error', error);
                $('.loading').css('display', 'none');

                alertCustomizer("There was an error", '#c86864');

            });
    }

    function getOwnersUpdate(element) {

        var values = $("#update_property option:selected");
        var id_owner = ($(values).attr('id_owner'));
        console.log(id_owner);

        var myHeaders = new Headers();
        myHeaders.append("Accept", "application/json");
        myHeaders.append("Content-Type", "application/json");

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch("?route=owner_find&params=" + id_owner, requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                } else {

                    $('#update_owner').val(result.body[0].name);
                    $('#update_owner_id').val(result.body[0].id);
                }
            })
            .catch(error => {

                console.log('error', error);
                $('.loading').css('display', 'none');

                alertCustomizer("There was an error", '#c86864');

            });

    }



    function getOwners(element) {

        //console.log($(element+' option:selected'));
        var values = $("#property option:selected");
        var id_owner = ($(values).attr('id_owner'));

        var myHeaders = new Headers();
        myHeaders.append("Accept", "application/json");
        myHeaders.append("Content-Type", "application/json");

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch("?route=owner_find&params=" + id_owner, requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                } else {

                    $('#owner').val(result.body[0].name);
                    $('#owner_id').val(result.body[0].id);
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