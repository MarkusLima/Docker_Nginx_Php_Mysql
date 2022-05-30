<div class="card shadow-sm p-1 mb-1 bg-body rounded">
    <div class="card-header">
        <label for="">Owners</label>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover" id="dataTable">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Day to pass on</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">-</th>
                        <td>-</td>
                        <td>-</td>
                        <td class="phone_number">-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

<button class="btn btn-success position-fixed bottom-0 end-0" style="margin-bottom: 15px; margin-right: 15px;" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">+</button>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-light">
        <h5 id="offcanvasRightLabel">Create Owner</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" style="display: flex;justify-content: center;align-items: center;">
        <div class="row g-3">
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="full_name" placeholder="Markus Lima da Silva" value="Markus Lima da Silva">
                    <label for="full_name">Full name</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="email" placeholder="markus@mkbits.com.br" value="markus@mkbits.com.br">
                    <label for="email">Email</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="phone_number" placeholder="(21)98798-7897" value="2198798-7897">
                    <label for="phone_number">Phone number</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="number" class="form-control" min="1" max="31" id="day_to_pass_on" placeholder="Day to pass on" value="10">
                    <label for="day_to_pass_on">Day to pass on</label>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer bg-light p-3" style="display: flex; justify-content: end;">
        <button type="button" class="btn btn-secondary" onclick="submitOwner()">Create</button>
    </div>
</div>

<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight_" aria-labelledby="offcanvasRightLabel">
    <div class="offcanvas-header bg-light">
        <h5 id="offcanvasRightLabel">Update Client</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body" style="display: flex;justify-content: center;align-items: center;">
        <div class="row g-3">
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="d-none" id="id_update">
                    <input type="text" class="form-control" id="update_full_name" placeholder="Markus Lima da Silva" value="Markus Lima da Silva">
                    <label for="full_name">Full name</label>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="update_email" placeholder="markus@mkbits.com.br" value="markus@mkbits.com.br">
                    <label for="email">Email</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="text" class="form-control" id="update_phone_number" placeholder="(21)98798-7897" value="2198798-7897">
                    <label for="phone_number">Phone number</label>
                </div>
            </div>
            <div class="col-12">
                <div class="form-floating">
                    <input type="number" class="form-control" min="1" max="31" id="update_day_to_pass_on" placeholder="Day to pass on" value="10">
                    <label for="day_to_pass_on">Day to pass on</label>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-footer bg-light p-3" style="display: flex; justify-content: end;">
        <button type="button" class="btn btn-secondary" onclick="submitOwnerUpdate()">Update</button>
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