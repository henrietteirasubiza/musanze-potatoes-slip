<?php
// app/controllers/AuthController.php

class AuthController {
    private UserModel $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function showLogin(): void {
        if (isLoggedIn()) redirect('/dashboard');
        $flash = getFlash();
        require __DIR__ . '/../views/auth/login.php';
    }

    public function login(): void {
        $username = sanitize($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $errors   = [];

        if (empty($username)) $errors[] = 'Username is required.';
        if (empty($password)) $errors[] = 'Password is required.';

        if (empty($errors)) {
            $user = $this->userModel->findByUsername($username);
            if ($user && $this->userModel->verifyPassword($password, $user['password_hash'])) {
                $_SESSION['user_id']       = $user['id'];
                $_SESSION['user_role']     = $user['role'];
                $_SESSION['user_name']     = $user['full_name'];
                $_SESSION['user_username'] = $user['username'];
                $_SESSION['login_time']    = time();
                redirect('/dashboard');
            } else {
                $errors[] = 'Invalid username or password.';
            }
        }

        $flash = ['type' => 'error', 'message' => implode(' ', $errors)];
        require __DIR__ . '/../views/auth/login.php';
    }

    public function logout(): void {
        session_destroy();
        redirect('/login');
    }
}
