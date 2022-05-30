<div class="card shadow-sm p-1 mb-1 bg-body rounded">
    <div class="card-header">
        <label for="">Properties</label>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Address</th>
                        <th scope="col">Owner</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">-</th>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<button class="btn btn-success position-fixed bottom-0 end-0" style="margin-bottom: 15px; margin-right: 15px;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" onclick="getOners()">+</button>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-light">
        <h5 id="offcanvasRightLabel">Create Property</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" style="display: flex;justify-content: center;align-items: center;">
        <div class="row g-3">
            <div class="col-12">
                <div class="form-floating">
                    <textarea class="form-control" id="address" placeholder="2300 Traverwood Dr. Ann Arbor, MI 48105 United States" style="height: 100px">2300 Traverwood Dr. Ann Arbor, MI 48105 United States
                    </textarea>
                    <label for="address">Address</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <select class="form-select" id="owner" aria-label="Floating label select example">
                    </select>
                    <label for="owner">Select owner</label>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer bg-light p-3" style="display: flex; justify-content: end;">
        <button type="button" class="btn btn-secondary" onclick="submitProperty()">Create</button>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight_" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-light">
        <h5 id="offcanvasRightLabel">Update Property</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" style="display: flex;justify-content: center;align-items: center;">
        <div class="row g-3">
            <div class="col-12">
                <input type="text" class="d-none" id="id_update">
                <div class="form-floating">
                    <textarea class="form-control" id="update_address" placeholder="2300 Traverwood Dr. Ann Arbor, MI 48105 United States" style="height: 100px">2300 Traverwood Dr. Ann Arbor, MI 48105 United States
                    </textarea>
                    <label for="address">Address</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <select class="form-select" id="update_owner" aria-label="Floating label select example">
                    </select>
                    <label for="owner">Select owner</label>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer bg-light p-3" style="display: flex; justify-content: end;">
        <button type="button" class="btn btn-secondary" onclick="submitPropertyUpdate()">Update</button>
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