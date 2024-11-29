<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WinTech</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=SF+Pro+Display:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'SF Pro Display', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        :root {
            --primary: #2997ff;
            --hover: #0077ed;
            --background: #000000;
            --text: #f5f5f7;
        }

        body {
            background-color: var(--background);
            color: #f5f5f7;
            overflow-x: hidden;
            line-height: 1.47059;
            font-weight: 400;
            letter-spacing: -.022em;
        }
        .hero {
            padding-top: 44px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            position: relative;
            overflow: hidden;
            background: #000;
        }

        .hero-content {
            text-align: center;
            padding-top: 50px;
            position: relative;
            z-index: 1;
            width: 100%;
        }

        .hero h1 {
            font-size: 56px;
            line-height: 1.07143;
            font-weight: 600;
            letter-spacing: -.005em;
            margin-bottom: 6px;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 1s forwards;
        }

        .hero p {
            font-size: 28px;
            line-height: 1.10722;
            font-weight: 400;
            letter-spacing: .004em;
            margin-bottom: 0.5em;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 1s 0.2s forwards;
        }

        .hero-image {
            width: 100%;
            height: calc(100vh - 200px);
            position: relative;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 1s 0.4s forwards;
            overflow: hidden;
        }

        .hero-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
        }

        .cta-buttons {
            display: flex;
            gap: 35px;
            justify-content: center;
            margin-top: 1.6em;
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 1s 0.6s forwards;
        }

        .button {
            font-size: 21px;
            line-height: 1.381;
            font-weight: 400;
            letter-spacing: .011em;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .button-primary {
            color: var(--primary);
        }

        .button-primary:hover {
            text-decoration: underline;
        }

        .button-primary::after {
            content: ">";
            margin-left: 0.5em;
            font-family: 'SF Pro Icons';
        }

        .products {
            background: #fbfbfd;
            color: #1d1d1f;
            padding: 100px 0;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);  
            gap: 3rem;
            max-width: 980px;
            margin: 0 auto;
            padding: 0 22px;
        }

        .product-card {
            width: 295px;
            background: white;
            border-radius: 18px;
            padding: 30px;
            text-align: center;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            transform: translateY(30px);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            height: 100%;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.1);
        }

        .product-card.animate {
            animation: fadeUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .product-card:hover {
            transform: scale(1.02);
        }

        .product-card img {
            width: 100%;
            height: 200px;
            object-fit: contain;
            margin-bottom: 35px;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .product-card h3 {
            font-size: 24px;
            line-height: 1.16667;
            font-weight: 600;
            letter-spacing: .009em;
            margin-bottom: 8px;
        }

        .product-card p {
            font-size: 14px;
            line-height: 1.42859;
            font-weight: 400;
            letter-spacing: -.016em;
            color: #86868b;
            margin-bottom: 12px;
        }

        .product-card .price {
            font-size: 17px;
            line-height: 1.23536;
            font-weight: 400;
            letter-spacing: -.022em;
            margin-bottom: 20px;
        }

        .buy-button {
            background: var(--primary);
            color: white;
            padding: 8px 16px;
            border-radius:2px;
            font-size: 12px;
            line-height: 1.33337;
            font-weight: 400;
            letter-spacing: -.01em;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }

        .buy-button:hover {
            background: var(--hover);
        }
        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 1068px) {
            .hero h1 {
                font-size: 48px;
            }

            .hero p {
                font-size: 24px;
            }

            .button {
                font-size: 19px;
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 734px) {
            .hero h1 {
                font-size: 40px;
            }

            .hero p {
                font-size: 19px;
            }

            .button {
                font-size: 17px;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .nav {
                gap: 1rem;
            }

            .hero-image {
                height: calc(100vh - 300px);
            }
        }
        .see-all-products {
            text-decoration: none;
            color: var(--primary);
            text-align: center;
            justify-content: center;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <section class="hero">
        <div class="hero-content">
            <h1>iPhone 16 Pro Max</h1>
            <p>Titanium. So strong. So light. So Pro.</p>
            <div class="hero-image">
                <img src="https://www.apple.com/v/iphone-16-pro/c/images/overview/media-card/highlights_apple_intelligence_endframe__esdley4zqkya_xlarge.jpg" alt="iPhone 16 Pro">
            </div>
        </div>
    </section>

    <div class="container">
    <section class="products">
        <div class="products-grid">
        <?php 
        $limitedProducts = array_slice($products, 0, 4);
        foreach ($limitedProducts as $product) : 
            $imagePath = preg_replace('/\./', '', $product['img'], 1);
        ?>
        <div class="product-card">
            <img src="<?= htmlspecialchars($imagePath) ?>" alt="iPhone 16 Pro">
            <h3><?= htmlspecialchars($product['product_name']) ?></h3>
            <p>HOT</p>
            <p class="price"><?= htmlspecialchars($product['Lowest_Price']) ?></p>
            <a href="?act=product_detail&id=<?= $product['id'] ?>" class="buy-button">Buy</a>
        </div>
        <?php endforeach; ?>
        </div>
    </section>
    <a class="see-all-products" href="?act=home">See all products</a>
    </div>
    <script>
        const cards = document.querySelectorAll('.product-card');
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    entry.target.style.animationDelay = `${index * 0.2}s`;
                    entry.target.classList.add('animate');
                }
            });
        }, {
            threshold: 0.1
        });

        cards.forEach(card => observer.observe(card));
        const heroImage = document.querySelector('.hero-image img');
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            if (heroImage && scrolled < window.innerHeight) {
                heroImage.style.transform = `scale(${1 + scrolled * 0.0005}) translateY(${scrolled * 0.5}px)`;
            }
        });
    </script>
</body>
</html>            