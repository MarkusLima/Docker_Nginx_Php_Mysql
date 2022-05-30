<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" rel="stylesheet">

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow p-3 mb-3">
        <div class="container">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                    <a class="navbar-brand" href="/">Home</a>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0"></ul>

                    <form class="d-flex">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item">
                                <a class="nav-link active" id="nav_client_list" aria-current="page" href="?route=client_list">Clients</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="nav_owner_list" href="?route=owner_list">Owners</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="nav_property_list" href="?route=property_list">Properties</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="nav_contract_list" href="?route=contract_list">Contracts</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="nav_monthlyfee_list" href="?route=monthlyfee_list">Monthly fees</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="nav_transfer_list" href="?route=transfer_list">Transfers</a>
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">