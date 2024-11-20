<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs - Your Company</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, Tahoma;
            background-color: #f0f4f8;
        }
        header {
            background: #2e7d32;
            color: white;
            padding: 60px 20px;
        }
        header h1 {
            font-size: 3rem;
            color: yellow;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }
        header p {
            font-size: 1.2rem;
            color: yellow;
            font-weight: 300;
        }
        .faq-section {
            padding: 60px 15px;
        }
        .faq-question {
            font-weight: bold;
            cursor: pointer;
            font-size: 1.1rem;
            color: yellow;
        }
        .faq-answer {
            display: none;
            margin-top: 10px;
            padding-left: 20px;
            font-size: 1rem;
            color: yellow;
        }
        .faq-card {
            background-color: #2e7d32;
            border-radius: 10px;
            border: 1px solid #ddd;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .faq-card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }
        .faq-card i {
            color: #28a745;
        }
        .btn-primary {
            background-color: #2e7d32;
            border-color: #81c784;
            color: yellow;
            padding: 12px 30px;
            font-size: 1rem;
            border-radius: 30px;
            transition: all 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #81c784;
            color: yellow;
            border-color: #2e7d32;
        }
        footer {
            background-color: #2e7d32;
            color: white;
            padding: 20px 0;
        }
        footer p {
            font-size: 0.9rem;
            color: yellow;
            margin: 0;
        }
        @media (max-width: 768px) {
            header h1 {
                font-size: 2rem;
            }
            .faq-question {
                font-size: 1rem;
            }
            .faq-answer {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header Section -->
    <header class="text-center">
        <h1>Frequently Asked Questions</h1>
        <p>Find answers to our most common questions.</p>
    </header>

    <!-- FAQ Section -->
    <section class="faq-section container">
        <div class="row">
            <div class="col-md-6">
                <!-- FAQ 1 -->
                <div class="faq-card">
                    <p class="faq-question" onclick="toggleAnswer('faq1')">
                        Q: What products do you offer? <i class="fas fa-chevron-down float-right"></i>
                    </p>
                    <p id="faq1" class="faq-answer">
                        A: We offer a variety of fresh produce, roasted vegetable snacks, and other quality goods.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <!-- FAQ 2 -->
                <div class="faq-card">
                    <p class="faq-question" onclick="toggleAnswer('faq2')">
                        Q: Do I need an account to shop? <i class="fas fa-chevron-down float-right"></i>
                    </p>
                    <p id="faq2" class="faq-answer">
                        A: Yes, creating an account helps us track orders and save <br>
                        your preferences.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <!-- FAQ 3 -->
                <div class="faq-card">
                    <p class="faq-question" onclick="toggleAnswer('faq3')">
                        Q: Do you offer delivery services? <i class="fas fa-chevron-down float-right"></i>
                    </p>
                    <p id="faq3" class="faq-answer">
                        A: Yes, we provide delivery services for your convenience.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <!-- FAQ 4 -->
                <div class="faq-card">
                    <p class="faq-question" onclick="toggleAnswer('faq4')">
                        Q: What payment methods do you accept? <i class="fas fa-chevron-down float-right"></i>
                    </p>
                    <p id="faq4" class="faq-answer">
                        A: We accept cash and Gcash
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <!-- FAQ 5 -->
                <div class="faq-card">
                    <p class="faq-question" onclick="toggleAnswer('faq5')">
                        Q: Can the system handle bulk orders? <i class="fas fa-chevron-down float-right"></i>
                    </p>
                    <p id="faq5" class="faq-answer">
                        A: Yes, the system allows customers to place bulk orders.
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <!-- FAQ 6 -->
                <div class="faq-card">
                    <p class="faq-question" onclick="toggleAnswer('faq6')">
                        Q: How do I place an order? <i class="fas fa-chevron-down float-right"></i>
                    </p>
                    <p id="faq6" class="faq-answer">
                        A: You can place an order by browsing products, adding them to your cart, and proceeding to checkout to complete the payment.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Back to Home Button -->
    <div class="text-center my-4">
        <a href="index.php" class="btn btn-primary">Back to Home</a>
    </div>

    <!-- Footer -->
    <footer class="text-center">
        <p>&copy; <?= date('Y'); ?> Daniel And Marlyn's General Merchandise. All rights reserved.</p>
    </footer>

    <!-- JavaScript -->
    <script>
        function toggleAnswer(id) {
            const answer = document.getElementById(id);
            if (answer.style.display === 'none' || answer.style.display === '') {
                answer.style.display = 'block';
            } else {
                answer.style.display = 'none';
            }
        }
    </script>
</body>
</html>
