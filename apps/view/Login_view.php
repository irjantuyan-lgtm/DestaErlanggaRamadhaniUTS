<!DOCTYPE html>
<html lang="id">
<head>
    <title>Login - Digital Mading</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7fb; height: 100vh; display: flex; align-items: center; }
        .login-card { max-width: 400px; width: 100%; margin: auto; padding: 40px; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); background: white; }
    </style>
</head>
<body>
    <div class="login-card text-center">
        <h3 class="fw-bold mb-1" style="color: #2b2d42;">Mading UHN</h3>
        <p class="text-muted mb-4">Silakan login untuk melanjutkan</p>
        
        <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger py-2">Username atau Password salah!</div>
        <?php endif; ?>

        <form method="POST" action="index.php?url=user&action=proses_login">
            <div class="mb-3">
                <input type="text" name="username" class="form-control p-3" placeholder="Username" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password" class="form-control p-3" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 p-3 fw-bold">Login Sistem</button>
        </form>
    </div>
</body>
</html>