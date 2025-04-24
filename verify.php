<?php
session_start();
require_once 'includes/db_connect.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    
    // Cek token dan waktu kadaluarsa
    $query = "SELECT id, email_perusahaan FROM pelanggan 
              WHERE verification_token = ? 
              AND token_expiry > NOW() 
              AND is_verified = 0";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Update status verifikasi dan status approved
        $updateQuery = "UPDATE pelanggan 
                       SET is_verified = 1, 
                           verification_token = NULL, 
                           token_expiry = NULL,
                           status = 'approved'
                       WHERE id = ?";
        
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("i", $user['id']);
        
        if ($updateStmt->execute()) {
            $_SESSION['verify_success'] = true;
            
            // Kirim email notifikasi bahwa akun telah disetujui
            require_once 'includes/send_verification.php';
            $approvalEmail = new PHPMailer(true);
            try {
                // Konfigurasi Server
                $approvalEmail->isSMTP();
                $approvalEmail->Host       = 'smtp.gmail.com';
                $approvalEmail->SMTPAuth   = true;
                $approvalEmail->Username   = 'your-email@gmail.com'; // Ganti dengan email Anda
                $approvalEmail->Password   = 'your-app-password'; // Ganti dengan password aplikasi Gmail
                $approvalEmail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $approvalEmail->Port       = 587;

                // Penerima
                $approvalEmail->setFrom('your-email@gmail.com', 'SkyLink Market');
                $approvalEmail->addAddress($user['email_perusahaan']);

                // Konten
                $approvalEmail->isHTML(true);
                $approvalEmail->Subject = 'Akun Anda Telah Disetujui - SkyLink Market';
                
                // Template email persetujuan
                $approvalEmail->Body = '
                <div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;">
                    <div style="background-color: #003366; padding: 20px; text-align: center;">
                        <h1 style="color: white;">SkyLink Market</h1>
                    </div>
                    <div style="padding: 20px; background-color: #f8f9fa;">
                        <h2>Selamat! Akun Anda Telah Disetujui</h2>
                        <p>Akun Anda di SkyLink Market telah berhasil diverifikasi dan disetujui.</p>
                        <p>Anda sekarang dapat mengakses semua fitur SkyLink Market dengan login menggunakan email dan password Anda.</p>
                        <div style="text-align: center; margin: 30px 0;">
                            <a href="http://localhost/skripsi/login.php" style="background-color: #0066cc; color: white; padding: 12px 25px; text-decoration: none; border-radius: 5px;">Login Sekarang</a>
                        </div>
                        <p>Jika Anda memiliki pertanyaan atau kendala, silakan hubungi tim support kami.</p>
                    </div>
                    <div style="background-color: #f1f1f1; padding: 20px; text-align: center; font-size: 12px;">
                        <p>&copy; 2025 SkyLink Market. All rights reserved.</p>
                    </div>
                </div>';

                $approvalEmail->send();
            } catch (Exception $e) {
                error_log("Email persetujuan tidak dapat dikirim. Mailer Error: {$approvalEmail->ErrorInfo}");
            }

            header("Location: login.php?verified=1");
            exit();
        } else {
            $_SESSION['verify_error'] = "Terjadi kesalahan saat memverifikasi akun.";
            header("Location: login.php?error=1");
            exit();
        }
    } else {
        $_SESSION['verify_error'] = "Token verifikasi tidak valid atau sudah kadaluarsa.";
        header("Location: login.php?error=2");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>
