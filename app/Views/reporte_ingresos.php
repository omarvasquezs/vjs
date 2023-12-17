<h1 class="mt-4">REPORTE INGRESOS</h1>

<form method="post" name="reporte_ingresos" id="reporte_ingresos" action="">
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
        <div class="col-lg-2 col-md-12 mb-3">           
            <div class="form-check form-switch">                
                <input class="form-check-input" type="checkbox" id="set_current_date">
                <label for="set_current_date" class="form-check-label">FECHA HOY DÍA</label>
            </div>
            <div class="form-check form-switch">                
                <input class="form-check-input" type="checkbox" id="set_this_month">
                <label for="set_this_month" class="form-check-label">MES ACTUAL</label>
            </div>
        </div>
        <div class="col-lg-2 col-md-12 mb-3">           
            <div class="btn-group w-100" role="group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    OPCIONES
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item export-option" id="fetch_reporte_ingresos_web" data-action="/fetch_reporte_ingresos_web" href="">VER EN WEB</a></li>
                    <li><a class="dropdown-item export-option" data-action="/exportexcel" href="">DESCARGAR XLSX</a></li>
                    <li><a class="dropdown-item export-option" data-action="/exportcsv" href="">DESCARGAR CSV</a></li>
                </ul>
            </div>
        </div>
    </div>
</form>
<div class="row mt-5">
    <div class="col">
        <div id="data-table"></div>
    </div>
</div>