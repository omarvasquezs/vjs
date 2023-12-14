<h1 class="mt-4">REPORTE INGRESOS</h1>

<form method="post" name="reporte_ingresos" id="reporte_ingresos" action="/exportcsv">
    <div class="row mt-5 align-items-end">
        <div class="col-lg-3 col-md-12 mb-3">
            <div class="form-group">
                <label for="start_date" class="form-label">FECHA INICIO:</label>
                <input type="date" id="start_date" name="start_date" class="form-control">
            </div>
        </div>
        <div class="col-lg-3 col-md-12 mb-3">
            <div class="form-group">
                <label for="end_date" class="form-label">FECHA FIN:</label>
                <input type="date" id="end_date" name="end_date" class="form-control">
            </div>
        </div>
        <div class="col-lg-3 col-md-12 mb-3">
            <div class="form-group">
                <button type="submit" class="w-100 btn btn-primary">DESCARGAR CSV</button>
            </div>
        </div>
    </div>
</form>