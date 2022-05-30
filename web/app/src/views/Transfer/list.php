<div class="card shadow-sm p-1 mb-1 bg-body rounded">
    <div class="card-header">
        <label for="">Transfers</label>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Monthlyfee</th>
                        <th scope="col">Status</th>
                        <th scope="col">Value</th>
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
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>


<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight_" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-light">
        <h5 id="offcanvasRightLabel">Update Transfer</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" style="display: flex; align-items: center; justify-content: center;">
        <div class="row g-3">
            <div class="col-md-12">
                <input type="text" class="d-none" id="id_update">
                <div class="form-floating">
                    <input type="text" class="form-control" id="update_monthly_fee" disabled>
                    <label for="update_monthly_fee">Select monthly fee</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <select class="form-select" id="update_status" aria-label="Floating label select example">
                        <option selected value="Pending">Pending</option>
                        <option value="Paid">Paid</option>
                    </select>
                    <label for="update_status">Select status</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="update_value" disabled>
                    <label for="update_value">Value</label>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer bg-light p-3" style="display: flex; justify-content: end;">
        <button type="button" class="btn btn-secondary" onclick="submitTransferUpdate()">Update</button>
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