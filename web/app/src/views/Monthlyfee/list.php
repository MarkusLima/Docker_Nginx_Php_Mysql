<div class="card shadow-sm p-1 mb-1 bg-body rounded">
    <div class="card-header">
        <label for="">Monthly fees</label>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Contract</th>
                        <th scope="col">Status</th>
                        <th scope="col">Value</th>
                        <th scope="col">Reference month</th>
                        <th scope="col">Expiration</th>
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
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<button class="btn btn-success position-fixed bottom-0 end-0" style="margin-bottom: 15px; margin-right: 15px;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" onclick="getAllSelects()">+</button>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-light">
        <h5 id="offcanvasRightLabel">Create Monthly fee</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="row g-3">
            <div class="col-md-12">
                <div class="form-floating">
                    <select class="form-select" id="contract" aria-label="Floating label select example" onchange="getContracts(this)">
                    </select>
                    <label for="contract">Select contract</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-select" id="status" aria-label="Floating label select example" disabled>
                        <option value="Pending">Pending</option>
                    </select>
                    <label for="status">Select status</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control money" id="value" placeholder="0.00">
                    <label for="value">Value</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control date" id="reference_month" placeholder="2022-01-01" value="<?= date("Y-m-d"); ?>">
                    <label for="reference_month">Reference month</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control date" id="expiration" placeholder="2022-01-01" value="<?= date("Y-m-d"); ?>">
                    <label for="expiration">Expiration</label>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer bg-light p-3" style="display: flex; justify-content: end;">
        <button type="button" class="btn btn-secondary" onclick="submitMonthlyfee()">Create</button>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight_" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-light">
        <h5 id="offcanvasRightLabel">Update Monthly fee</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="row g-3">
            <div class="col-md-12">
                <input type="text" class="d-none" id="id_update">
                <div class="form-floating">
                    <select class="form-select" id="update_contract" aria-label="Floating label select example" onchange="getContracts(this)">
                    </select>
                    <label for="update_contract">Select contract</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-select" id="update_status" aria-label="Floating label select example">
                        <option value="Pending">Pending</option>
                        <option value="Paid">Paid</option>
                    </select>
                    <label for="update_status">Select status</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control money" id="update_value" placeholder="0.00">
                    <label for="update_value">Value</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control date" id="update_reference_month" placeholder="2022-01-01" value="<?= date("Y-m-d"); ?>">
                    <label for="update_reference_month">Reference month</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control date" id="update_expiration" placeholder="2022-01-01" value="<?= date("Y-m-d"); ?>">
                    <label for="update_expiration">Expiration</label>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer bg-light p-3" style="display: flex; justify-content: end;">
        <button type="button" class="btn btn-secondary" onclick="submitMonthlyfeeUpdate()">Update</button>
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