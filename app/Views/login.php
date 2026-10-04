<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Four Beans Café - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --primary-brown: #5D4037;
            --light-brown: #8D6E63;
            --beige: #F5F0E8;
        }
        body {
            background-color: var(--beige);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 20px;
            padding: 50px 45px;
            box-shadow: 0 8px 40px rgba(93,64,55,0.15);
            width: 100%;
            max-width: 420px;
        }
        .login-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .login-logo i {
            font-size: 3rem;
            color: var(--primary-brown);
        }
        .login-logo h3 {
            color: var(--primary-brown);
            font-weight: 700;
            margin-top: 10px;
            margin-bottom: 5px;
        }
        .login-logo p {
            color: #888;
            font-size: 0.9rem;
            margin: 0;
        }
        .form-label {
            color: #555;
            font-weight: 500;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px 15px;
            border: 1.5px solid #e0e0e0;
        }
        .form-control:focus {
            border-color: var(--primary-brown);
            box-shadow: 0 0 0 0.2rem rgba(93,64,55,0.15);
        }
        .btn-login {
            background-color: var(--primary-brown);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 13px;
            font-weight: 600;
            font-size: 1rem;
            width: 100%;
            margin-top: 10px;
            transition: all 0.3s;
        }
        .btn-login:hover {
            background-color: var(--light-brown);
            color: white;
        }
        .input-group-text {
            border-radius: 0 10px 10px 0;
            border: 1.5px solid #e0e0e0;
            border-left: none;
            background: #fafafa;
            cursor: pointer;
        }
        .form-control.rounded-end-0 {
            border-radius: 10px 0 0 10px;
        }
    
        input::-ms-reveal,
        input::-ms-clear {
            display: none;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="login-logo">
            <i class="bi bi-cup-hot"></i>
            <h3>Four Beans Café</h3>
            <p>Point-of-Sale Management System</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form action="/login" method="POST">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username"
                       value="<?= old('username') ?>" placeholder="Enter your username" required autofocus>
            </div>
            <div class="mb-4">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control rounded-end-0" id="password" name="password"
                           placeholder="Enter your password" required>
                    <span class="input-group-text" onclick="togglePassword()">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </span>
                </div>
            </div>
            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-2"></i> Sign In
            </button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function togglePassword() {
            const pwd = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            if (pwd.type === 'password') {
                pwd.type = 'text';
                icon.className = 'bi bi-eye-slash';
            } else {
                pwd.type = 'password';
                icon.className = 'bi bi-eye';
            }
        }
    </script>
</body>
</html>
