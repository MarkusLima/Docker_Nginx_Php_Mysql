<script>
    $(document).ready(function() {
        $('#dataTable').DataTable({
            ajax: {
                url: '?route=owner_all',
                type: 'GET',
                contentType: 'application/json',
                success: function(data) {
                    console.log(data.body);

                    if (data.msg == "success") {
                        $.each(data.body, function(index, value) {
                            $('#dataTable').dataTable().fnAddData([
                                value.id,
                                value.name,
                                value.email,
                                value.phone,
                                value.day_to_pass_on,
                                '<div class="btn-group" role="group" aria-label="Basic example">' +
                                '<button type="button" class="btn btn-outline-success" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight_" aria-controls="offcanvasRight_" onclick="editOwner(' + value.id + ')">Edit</button>' +
                                '<button type="button" class="btn btn-outline-danger" onclick="deleteOwner(' + value.id + ')">Delete</button>' +
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

    function submitOwner() {
        var body = {};
        var name = $('#full_name').val();
        var email = $('#email').val();
        var phone = $('#phone_number').val();
        var day_to_pass_on = $('#day_to_pass_on').val();

        if ((name != "") && (email != "") && (phone != "") && (day_to_pass_on != "")) {

            postOwner(name, email, phone, day_to_pass_on);

        } else {
            alertCustomizer("Fill in all fields", '#c86864');
        }
    }

    function postOwner(name, email, phone, day_to_pass_on) {

        $('.loading').css('display', 'block');

        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");
        myHeaders.append("Accept", "application/json");

        var raw = JSON.stringify({
            "name": name,
            "email": email,
            "phone": phone,
            "day_to_pass_on": day_to_pass_on
        });

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        fetch("?route=owner_add", requestOptions)
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

    function deleteOwner(id) {
        $('.loading').css('display', 'block');

        var requestOptions = {
            method: 'GET',
            redirect: 'follow'
        };

        fetch("?route=owner_delete&params=" + id, requestOptions)
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

    function editOwner(id) {

        $('.loading').css('display', 'block');

        var myHeaders = new Headers();
        myHeaders.append("Accept", "application/json");
        myHeaders.append("Content-Type", "application/json");

        var requestOptions = {
            method: 'GET',
            headers: myHeaders,
            redirect: 'follow'
        };

        fetch("?route=owner_find&params=" + id, requestOptions)
            .then(response => response.json())
            .then(result => {
                console.log(result);
                if (result.msg == "not found") {

                    alertCustomizer("not found", '#c86864');

                    $('.loading').css('display', 'none');
                } else {

                    $('#update_full_name').val(result.body[0].name);
                    $('#update_email').val(result.body[0].email);
                    $('#update_phone_number').val(result.body[0].phone);
                    $('#update_day_to_pass_on').val(result.body[0].day_to_pass_on);
                    $('#id_update').val(result.body[0].id);
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

    function submitOwnerUpdate() {
        var name = $('#update_full_name').val();
        var email = $('#update_email').val();
        var phone = $('#update_phone_number').val();
        var day_to_pass_on = $('#update_day_to_pass_on').val();
        var id = $('#id_update').val();

        if ((name != "") && (email != "") && (phone != "") && (day_to_pass_on != "")) {

            postOwnerUpdate(name, email, phone, id, day_to_pass_on);

        } else {
            alertCustomizer("Fill in all fields", '#c86864');
        }
    }

    function postOwnerUpdate(name, email, phone, id, day_to_pass_on) {
        $('.loading').css('display', 'block');

        var myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        var raw = JSON.stringify({
            "name": name,
            "email": email,
            "phone": phone,
            "day_to_pass_on": day_to_pass_on
        });

        var requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: raw,
            redirect: 'follow'
        };

        fetch("?route=owner_update&params=" + id, requestOptions)
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