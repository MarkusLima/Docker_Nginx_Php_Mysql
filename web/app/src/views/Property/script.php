<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            ajax: {
                url: '?route=property_all',
                type: 'GET',
                contentType: 'application/json',
                success: function(data) {
                    console.log(data.body);

                    if (data.msg == "success") {
                        $.each(data.body, function(index, value) {
                            $('#dataTable').dataTable().fnAddData([
                                value.id,
                                value.address,
                                value.owner_id,
                                '<div class="btn-group" role="group" aria-label="Basic example">' +
                                '<button type="button" class="btn btn-outline-success" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight_" aria-controls="offcanvasRight_" onclick="editProperty(' + value.id + ',' + value.owner_id + ')">Edit</button>' +
                                '<button type="button" class="btn btn-outline-danger" onclick="deleteProperty(' + value.id + ')">Delete</button>' +
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
    });

    function submitProperty() {
        var body = {};
        var address = $('#address').val();
        var owner = $('#owner').val();

        if ((address != "") && (owner != "")) {

            postProperty(address, owner);

        } else {
            alertCustomizer("Fill in all fields", '#c86864');
        }
    }

    function postProperty(address, owner) {

        $('.loading').css('display', 'block');

        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");
        myHeaders.append("Accept", "application/json");

        var raw = JSON.stringify({
            "address": address,
            "owner_id": owner
        });

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        fetch("?route=property_add", requestOptions)
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

    function deleteProperty(id) {
        $('.loading').css('display', 'block');

        var requestOptions = {
            method: 'GET',
            redirect: 'follow'
        };

        fetch("?route=property_delete&params=" + id, requestOptions)
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

    function editProperty(id, owner_id) {

        $('.loading').css('display', 'block');

        var myHeaders = new Headers();
        myHeaders.append("Accept", "application/json");
        myHeaders.append("Content-Type", "application/json");

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch("?route=owner_all", requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    var select = '';
                    $.each(result.body, function(index, value) {
                        if (value.id == owner_id) {
                            select += '<option selected value="' + value.id + '">' + value.name + '</option>';
                        } else {
                            select += '<option value="' + value.id + '">' + value.name + '</option>';
                        }
                    });

                    $('#update_owner').html("");
                    $('#update_owner').append(select);
                    $('#update_address').val(address);
                    $('#id_update').val(id);

                    $('.loading').css('display', 'none');
                }
            })
            .catch(error => {

                console.log('error', error);
                $('.loading').css('display', 'none');

                alertCustomizer("There was an error", '#c86864');

            });

        fetch("?route=property_find&params="+id, requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result.body);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    $('#update_address').val(result.body[0].address);

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

    function submitPropertyUpdate() {
 
        var id = $('#id_update').val();
        var address = $('#update_address').val();
        var owner = $('#update_owner').val();

        if ((address != "") && (owner != "")) {

            postPropertyUpdate(address, owner, id);

        } else {
            alertCustomizer("Fill in all fields", '#c86864');
        }
    }

    function postPropertyUpdate(address, owner, id) {
        $('.loading').css('display', 'block');

        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        var raw = JSON.stringify({
            "address": address,
            "owner_id": owner
        });

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        fetch("?route=property_update&params=" + id, requestOptions)
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

    function getOners() {
        $('.loading').css('display', 'block');

        var myHeaders = new Headers();
        myHeaders.append("Accept", "application/json");
        myHeaders.append("Content-Type", "application/json");

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch("?route=owner_all", requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    var select = '<option selected>Select owner</option>';
                    $.each(result.body, function(index, value) {
                        select += '<option value="' + value.id + '">' + value.name + '</option>';
                    });

                    $('#owner').html("");
                    $('#owner').append(select);
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