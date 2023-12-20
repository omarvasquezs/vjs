<div class="row justify-content-center">
    <div class="col-lg-10">
        <h1 class="mb-5">ADICIONALES</h1>
        <form method="post" action="/submit_adicionales">
            <input type="hidden" name="comprobante_id" id="comprobante_id" value="<?=service('uri')->getSegment(service('uri')->getTotalSegments())?>">
            <div class="row g-5">
                <div class="col-lg-12 col-md-12">
                    <div class="row mb-4">
                        <div class="col-md-8 input-group-lg">
                            <select class="form-select is-required" name="servicioDropdown" id="servicioDropdown">
                                <!-- Servicios will be populated here through JavaScript -->
                            </select>
                        </div>
                        <div class="col-md-4 d-grid gap-2">
                            <button class="btn btn-primary" id="addRowButton">AÑADIR</button>
                        </div>
                    </div>
                    <!-- START TABLE -->
                    <div class="row mb-5 pb-5">
                        <div class="col-md-12">
                            <table class="table table-hover" id="productTableBody">
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
                    </div>
                    <!-- END TABLE -->
                </div>
                <div class="col-lg-12 col-md-12">
                    <!-- START SUBMIT BUTTON -->
                    <div class="row">
                        <div class="d-grid gap-2 py-4">
                            <button id="btn_registrar_comprobante" class="btn btn-success btn-lg">REGISTRAR ADICIONALES</button>
                        </div>
                    </div>
                    <!-- END SUBMIT BUTTON -->
                </div>
            </div>
        </form>
    </div>
</div>