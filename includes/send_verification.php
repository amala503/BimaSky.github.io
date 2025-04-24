<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendVerificationEmail($email, $token, $username) {
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi Server
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; // Ganti dengan SMTP server Anda
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your-email@gmail.com'; // Ganti dengan email Anda
        $mail->Password   = 'your-app-password'; // Ganti dengan password aplikasi Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Penerima
        $mail->setFrom('your-email@gmail.com', 'SkyLink Market');
        $mail->addAddress($email, $username);

        // Konten
        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Akun SkyLink Market';
        
        // URL verifikasi
        $verificationUrl = "http://localhost/skripsi/verify.php?token=" . $token;
        
        // Template email
        $mail->Body = '
        <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
            <div style="background-color: #003366; padding: 20px; text-align: center;">
                <h1 style="color: white;">SkyLink Market</h1>
            </div>
            <div style="padding: 20px; background-color: #f8f9fa;">
                <h2>Selamat Datang di SkyLink Market!</h2>
                <p>Terima kasih telah mendaftar. Untuk mengaktifkan akun Anda, silakan klik tombol di bawah ini:</p>
                <div style="text-align: center; margin: 30px 0;">
                    <a href="' . $verificationUrl . '" style="background-color: #0066cc; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px;">Verifikasi Akun</a>
                </div>
                <p>Atau copy dan paste link berikut di browser Anda:</p>
                <p style="background-color: #e9ecef; padding: 10px; word-break: break-all;">' . $verificationUrl . '</p>
                <p>Link verifikasi ini akan kadaluarsa dalam 24 jam.</p>
                <p>Jika Anda tidak merasa mendaftar di SkyLink Market, Anda dapat mengabaikan email ini.</p>
            </div>
            <div style="background-color: #f1f1f1; padding: 20px; text-align: center; font-size: 12px;">
                <p>&copy; 2025 SkyLink Market. All rights reserved.</p>
            </div>
        </div>';

        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Email tidak dapat dikirim. Mailer Error: {$mail->ErrorInfo}");
        return false;
    }
}
?>
