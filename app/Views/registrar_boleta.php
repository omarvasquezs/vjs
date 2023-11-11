<div class="row justify-content-center">
    <div class="col-lg-7">
        <h1 class="mb-5">REGISTRO DE COMPROBANTE</h1>
        <form>
            <div class="row mb-4">
                <div class="col-md-8 input-group-lg">
                    <input type="text" style="background: #e9ecef;" class="form-control" id="id_user_register"
                        placeholder="Cod. Cliente" required>
                </div>
                <div class="d-grid gap-2 col-4 mx-auto">
                    <button class="btn btn-secondary btn-lg" data-bs-toggle="modal"
                        data-bs-target="#consultaUsuarios">SELECCIONAR</button>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 input-group-lg">
                    <select class="form-select is-required" id="metodopagoDropdown" required>
                        <option value="" selected>-- CONDICIÓN DE PAGO --</option>
                        <!-- Metodo de Pago will be populated here through JavaScript -->
                    </select>
                </div>
                <div class="col-md-6 d-grid gap-2">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="btnradio" id="btnradio1" autocomplete="off" checked>
                        <label style="line-height: 2rem;" class="btn btn-outline-primary" for="btnradio1">NOTA DE
                            VENTA</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio2" autocomplete="off">
                        <label style="line-height: 2rem;" class="btn btn-outline-primary" for="btnradio2">BOLETA</label>

                        <input type="radio" class="btn-check" name="btnradio" id="btnradio3" autocomplete="off">
                        <label style="line-height: 2rem;" class="btn btn-outline-primary"
                            for="btnradio3">FACTURA</label>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-8 input-group-lg">
                    <select class="form-select is-required" id="servicioDropdown" required>
                        <option value="" selected>-- SELECCIONAR SERVICIO --</option>
                        <!-- Servicios will be populated here through JavaScript -->
                    </select>
                </div>
                <div class="col-md-4 d-grid gap-2">
                    <button class="btn btn-primary" id="addRowButton">AÑADIR</button>
                </div>
            </div>

            <div class="row mb-5 pb-5">
                <table class="table" id="productTableBody">
                    <thead>
                        <tr>
                            <th scope="col">SERVICIO</th>
                            <th scope="col">PESO EN KG</th>
                            <th scope="col" style="text-align: center;">PRECIO POR KG (S/.)</th>
                            <th scope="col" style="text-align: center;">TOTAL (S/.)</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>

            <div class="row mt-5">                
                <h4>OP. GRAVADAS: S/. <span id="igv_register"></span></h4>
                <h4>IGV 18%: S/. <span id="igv_register"></span></h4>                
                <h4>TOTAL A PAGAR: S/. <span id="total_register"></span></h4>
            </div>

            <div class="row mt-5">
                <div class="d-grid gap-2 col-6 mx-auto"><button class="btn btn-success btn-lg">Registrar</button></div>
                <div class="d-grid gap-2 col-6 mx-auto"><a href="/" class="btn btn-danger btn-lg">Cancelar</a></div>
            </div>

        </form>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="consultaUsuarios" tabindex="-1" aria-labelledby="consultaUsuariosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Seleccionar Cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ...
            </div>
        </div>
    </div>
</div>