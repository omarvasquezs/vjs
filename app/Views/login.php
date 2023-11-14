<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>.::Sistema de Lavanderia 1.0::.</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f0f0f0;
        }

        .login-container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 40px 40px 55px 40px; /* Increased padding at top and bottom */
            margin: 0 auto;
            width: 100%;
            max-width: 30rem;
            margin-top: 100px;
        }

        .login-form {
            margin-top: 20px;
        }

        .login-button {
            background-color: #007BFF;
            color: #fff;
        }

        .login-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">            
            <img class="img-fluid" src="<?=base_url()?>assets/img/main_logo.jpeg">
            <form class="login-form" action="/authenticate" method="post">
                <div class="mb-3">                    
                    <input type="text" class="form-control" id="username" name="username" placeholder="USUARIO" required>
                </div>
                <div class="mb-4">                    
                    <input type="password" class="form-control" id="password" name="password" placeholder="CONTRASEÑA" required>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary login-button">Login</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
