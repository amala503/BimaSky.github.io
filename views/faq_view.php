<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ - SkyLink Market</title>
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

        .category-filter {
            margin-bottom: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .category-btn {
            background-color: rgba(108, 117, 125, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .category-btn:hover, .category-btn.active {
            background-color: var(--primary-color);
            color: #fff;
        }

        .search-box {
            margin-bottom: 20px;
        }

        .search-box input {
            background-color: rgba(108, 117, 125, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 10px 15px;
            border-radius: 8px;
        }

        .search-box input::placeholder {
            color: rgba(255, 255, 255, 0.5);
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
                            <a class="nav-link" href="home">
                                <i class="bi bi-house"></i> Beranda
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="produk">
                                <i class="bi bi-box"></i> Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="promo">
                                <i class="bi bi-tag"></i> Promo
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="faq">
                                <i class="bi bi-question-circle"></i> FAQ
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tracking.order">
                                <i class="bi bi-cart"></i> Pesanan
                            </a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        <a class="nav-link text-white" href="profile">
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

            <!-- Kategori dinonaktifkan karena kolom kategori tidak ada di tabel faq -->
            <!-- <div class="category-filter">
                <a href="faq" class="category-btn active">Semua</a>
            </div> -->

            <div class="search-box">
                <form action="faq" method="GET">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="Cari pertanyaan..."
                               value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <?php if (!empty($faqs)): ?>
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
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="bi bi-search display-4"></i>
                    <p class="mt-3">Tidak ada FAQ yang ditemukan.</p>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="text-center py-4">
        <div class="container">
            <p class="mb-0"> 2025 SkyLink Market. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
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
