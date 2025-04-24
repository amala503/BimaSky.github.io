<?php
// Koneksi ke database
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'dtptelkomsat';

$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil data FAQ dari database
$query = "SELECT pertanyaan, jawaban FROM faq";
$result = $conn->query($query);
$faqs = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $faqs[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/skripsi/css/style.css">
    <link rel="stylesheet" href="/skripsi/css/skylink-theme.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            background: linear-gradient(to bottom, var(--space-dark), var(--space-blue));
            color: var(--text-light);
            font-family: 'Poppins', sans-serif;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: start;
            padding-top: 120px;
            padding-bottom: 40px;
        }

        .faq-container {
            width: 100%;
            max-width: 800px;
            padding: 30px;
            background-color: rgba(73, 80, 87, 0.9);
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .faq-item {
            border-bottom: 1px solid rgba(108, 117, 125, 0.3);
            padding: 20px 0;
            transition: all 0.3s ease;
        }

        .faq-item:last-child {
            border-bottom: none;
        }

        .faq-question {
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 1.1rem;
            font-weight: 500;
            color: #fff;
            transition: color 0.3s ease;
        }

        .faq-answer {
            display: none;
            margin-top: 15px;
            padding: 15px;
            background-color: rgba(108, 117, 125, 0.2);
            border-radius: 8px;
            color: #e9ecef;
            line-height: 1.6;
        }

        .faq-question:hover,
        .faq-item.active .faq-question {
            color: var(--primary-color, #ffc107);
        }

        .faq-item.active .faq-answer {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        footer {
            background: rgba(26, 35, 126, 0.9);
            color: var(--text-light);
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <i class="bi bi-broadcast"></i> BimaSky
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="home.php">
                                <i class="bi bi-house"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="produk.php">
                                <i class="bi bi-box"></i> Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="promo.php">
                                <i class="bi bi-tag"></i> Promo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="faq.php">
                                <i class="bi bi-question-circle"></i> FAQ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tracking.order.php">
                                <i class="bi bi-cart"></i> Pesanan
                            </a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <a class="nav-link text-white" href="profile.php">
                            <i class="bi bi-person-circle"></i> Profile
                        </a>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <div class="faq-container">
            <h1 class="text-center mb-4">
                <i class="bi bi-question-circle"></i> Frequently Asked Questions
            </h1>
            <?php foreach ($faqs as $faq): ?>
                <div class="faq-item">
                    <div class="faq-question">
                        <span><?php echo htmlspecialchars($faq['pertanyaan']); ?></span>
                        <i class="bi bi-chevron-down"></i>
                    </div>
                    <div class="faq-answer">
                        <?php echo htmlspecialchars($faq['jawaban']); ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer class="text-center py-4">
        <div class="container">
            <p class="mb-0"> 2025 SkyLink Market. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');

                question.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');

                    // Close all other items
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                            const icon = otherItem.querySelector('.bi');
                            icon.classList.remove('bi-chevron-up');
                            icon.classList.add('bi-chevron-down');
                        }
                    });

                    // Toggle current item
                    item.classList.toggle('active');
                    const icon = item.querySelector('.bi');
                    if (isActive) {
                        icon.classList.remove('bi-chevron-up');
                        icon.classList.add('bi-chevron-down');
                    } else {
                        icon.classList.remove('bi-chevron-down');
                        icon.classList.add('bi-chevron-up');
                    }
                });
            });
        });
    </script>
</body>

</html>