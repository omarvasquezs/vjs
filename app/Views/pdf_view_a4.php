<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>A4</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz9K68v6QIeh79" crossorigin="anonymous">

    <style>
        body {
            width: 210mm;
            height: 297mm;
            margin: 10px;
            padding: 10px;
            max-width: 98%;
        }
        .invoice-container {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding: 10px;
            box-sizing: border-box;
        }
        .invoice-header {
            text-align: center;
            background: #dedede;
            border-radius: 10px;
            padding-bottom: 10px;
            padding-top: 5px;
            border: 1px solid #a8a8a8;
            margin-bottom: 1.5rem;
        }
        .invoice-title {
            font-size: 15px;
            font-weight: bold;
            line-height: 4px;
        }
        .invoice-table {
            width: 90%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ccc;
            padding: 5px;
        }
        .invoice-table th {
            background-color: #eee;
            text-align: center;
        }
        .invoice-notes {
            margin-top: 20px;
        }
        .comprobante-contact p {
            line-height: 1.25rem;
        }
    </style>
</head>

<body>
    <div class="container invoice-container">
        <div class="row">
            <div class="col-xs-5">
                <img width="80%" src="<?=base_url()?>assets/img/main_logo.jpeg">
            </div>
            <div class="col-xs-5 invoice-header">
                <h2 class="invoice-title">R.U.C. N° 20602340466</h2>
                <h2 class="invoice-title">BOLETA DE VENTA ELECTRÓNICA</h2>
                <h2 class="invoice-title">B001-1</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-5 comprobante-company-contact" style="padding-top: 1rem;">
                <p><b>VJS LAUNDRY S.A.C.<b></p>
                <p>Av. Agustín de la Rosa Toro 318, San Luis 15021</p>
                <p><b>Teléfono:</b> 913 027 176</p>
            </div>
            <div class="col-xs-5 comprobante-contact" style="border: 1px solid #a8a8a8;border-radius: 10px;padding-top: 1rem;margin-bottom: 2rem;">
                <p><b>Fecha emisión: </b> <?= $comprobante['fecha'] ?></p>
                <p><b>Señor(a): </b> <?=$comprobante['nombres'] ?></p>
                <p><b>DNI: </b><?= $comprobante['dni'] ?></p>
                <p><b>Dirección: </b><?= $comprobante['direccion'] ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <table class="table invoice-table">
                    <thead>
                        <tr>                            
                            <th>SERVICIO</th>
                            <th>PESO (KG)</th>
                            <th>COSTO POR KG (S/.)</th>
                            <th>TOTAL (S/.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>                            
                            <td>Cuysito con papas lorem ipsum dolor etc etc</td>
                            <td><center>1</center></td>
                            <td><center>40.00</center></td>
                            <td><center>40.00</center></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <p>SUB TOTAL</p>
                <p>IG.V</p>
                <p><b>TOTAL</b></p>
            </div>
            <div class="col-xs-6">
                <p>S/. 33.90</p>
                <p>S/. 6.10</p>
                <p><b>S/. 40.00</b></p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 invoice-notes">
                <p>¡Gracias por su preferencia!</p>
            </div>
        </div>
    </div>
</body>

</html>