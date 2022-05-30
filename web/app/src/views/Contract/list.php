<div class="card shadow-sm p-1 mb-1 bg-body rounded">
    <div class="card-header">
        <label for="">Contracts</label>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Property</th>
                        <th scope="col">Owner</th>
                        <th scope="col">Client</th>
                        <th scope="col">Start date</th>
                        <th scope="col">End date</th>
                        <th scope="col">Administrative fee</th>
                        <th scope="col">Rent value</th>
                        <th scope="col">Condominium value</th>
                        <th scope="col">Iptu value</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">-</th>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<button class="btn btn-success position-fixed bottom-0 end-0" style="margin-bottom: 15px; margin-right: 15px;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" onclick="getAllSelects()">+</button>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-light">
        <h5 id="offcanvasRightLabel">Create Contract</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="row g-3">
            <div class="col-md-12">
                <div class="form-floating">
                    <select class="form-select" id="property" aria-label="Floating label select example" onchange="getOwners(this)">
                    </select>
                    <label for="owner">Select property</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="owner" disabled>
                    <input type="text" class="d-none" id="owner_id">
                    <label for="owner">Owner</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <select class="form-select" id="client" aria-label="Floating label select example">
                    </select>
                    <label for="owner">Select client</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="start_date" placeholder="2022-01-01" value="<?= date('Y/m/d'); ?>">
                    <label for="start_date">Start date</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="end_date" placeholder="2022-01-01" value="<?= date('Y/m/d'); ?>">
                    <label for="end_date">End date</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control money" id="administrative_fee" placeholder="0.00">
                    <label for="administrative_fee">Administrative fee</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control money" id="rent_value" placeholder="0.00">
                    <label for="rent_value">Rent value</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control money" id="condominium_value" placeholder="0.00">
                    <label for="condominium_value">Condominium value</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control money" id="iptu_value" placeholder="0.00">
                    <label for="iptu_value">Iptu value</label>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer bg-light p-3" style="display: flex; justify-content: end;">
        <button type="button" class="btn btn-secondary" onclick="submitContract()">Create</button>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight_" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-light">
        <h5 id="offcanvasRightLabel">Update Contract</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="row g-3">
            <div class="col-md-12">
                <input type="text" class="d-none" id="id_update">
                <div class="form-floating">
                    <select class="form-select" id="update_property" aria-label="Floating label select example" onchange="getOwnersUpdate(this)">
                    </select>
                    <label for="update_property">Select property</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="update_owner" disabled>
                    <input type="text" class="d-none" id="update_owner_id">
                    <label for="update_owner">Owner</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <select class="form-select" id="update_client" aria-label="Floating label select example">
                    </select>
                    <label for="update_owner">Select client</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="update_start_date" placeholder="2022-01-01" disabled>
                    <label for="update_start_date">Start date</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="update_end_date" placeholder="2022-01-01" disabled>
                    <label for="update_end_date">End date</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control money" id="update_administrative_fee" disabled>
                    <label for="update_administrative_fee">Administrative fee</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control money" id="update_rent_value" disabled>
                    <label for="update_rent_value">Rent value</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control money" id="update_condominium_value" disabled>
                    <label for="update_condominium_value">Condominium value</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control money" id="update_iptu_value" disabled>
                    <label for="update_iptu_value">Iptu value</label>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer bg-light p-3" style="display: flex; justify-content: end;">
        <button type="button" class="btn btn-secondary" onclick="submitContractUpdate()">Update</button>
    </div>
</div>

<div class="loading" delay-hide="50000"></div>

<style>
    .loading {
        display: none;
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        background: hsla(254, 76%, 7%, 0.3);
        z-index: 1100;
    }

    .loading:after {
        content: "";
        width: 50px;
        height: 50px;
        position: absolute;
        top: -30px;
        right: 0;
        left: 0;
        bottom: 0;
        margin: auto;
        border: 6px solid #f2f2f2;
        border-top: 6px dotted #f2f2f2;
        border-bottom: 6px dotted #f2f2f2;
        border-radius: 50%;
        animation: loading 2s infinite;
    }

    .loading:before {
        font-family: 'Lobster', cursive;
        font-size: 20px;
        letter-spacing: 1px;
        color: white;
        content: "Salvando...";
        position: absolute;
        top: 57%;
        text-align: center;
        right: 0;
        left: 0;
        margin: auto;
    }

    @keyframes loading {
        0% {
            transform: rotate(0);
        }

        50% {
            transform: rotate(360deg);
        }
    }
</style>