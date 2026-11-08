<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barbershop</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('assets/CSS/landing.css') }}">

</head>
<body>
<header class="navbar">
    <div class="navbar-container">
        <a href="#" class="brand">Barbershop</a>

        <nav class="nav-links">
            <a href="#hero" class="nav-link">Home</a>
            <a href="#services" class="nav-link">Services</a>
            <a href="#about" class="nav-link">About</a>
            <a href="#contact" class="nav-link">Contact</a>
            <a  href="{{ route('login') }}" class= "nav-link nav-btn">BOOK APPOINTMENT</a>
        </nav>
    </div>
</header>

<section id="hero" class="hero"> 
    <div class="hero-text"> 
        <h1>WELCOME TO BARBERSHOP</h1>

        <p>Get a fresh cut from the best barbers in town. Book your appointment today.</p>

        <div class="hero-buttons"> 
            <a href="#" class="hero-btn">Book Now</a> 
            <a href="#services" class="hero-btn2">View Services</a>
        </div>

        <!-- Rating below the buttons -->
        <div class="rating"> 
            <img src="{{ asset('assets/images/customer1.jpg') }}" alt="Customer">
            
            <span>★★★★★</span> 
            <strong>5.0 (100+ reviews)</strong> 
        </div>
    </div> 

    <div class="hero-image"> 
        <img src="{{ asset('assets/images/barbershop.png') }}" alt="Barbershop"> 
    </div> 
</section>

<section class="black-section">

    <div class="black-section-content">

        <div class="service-item">
            <img class="service-image" src="{{ asset('assets/images/scissor.png') }}" alt="Scissors">
            <h2>PROFESSIONAL BARBERS</h2>
            <p>Our experienced barbers are ready to give you a fresh, clean, and stylish haircut that fits your look.</p>
        </div>

        <div class="service-item">
            <img class="service-image" src="{{ asset('assets/images/bottle.png') }}" alt="Premium Products">
            <h2>PREMIUM PRODUCTS</h2>
            <p>We use high-quality grooming products to keep your hair and skin in top shape.</p>
        </div>

        <div class="service-item">
            <img class="service-image" src="{{ asset('assets/images/chair.png') }}" alt="Comfort Seating">
            <h2>CLEAN & HYGENIC</h2>
            <p>We Maintain The Highest Standards Of Hygiene To Ensure Your Safety.</p>
        </div>

        <div class="service-item">
            <img class="service-image" src="{{ asset('assets/images/ribbon.png') }}" alt="Award Winning">
            <h2>SATISFACTION GUARANTEED</h2>
            <p>Your Satisfaction is our Priority.</p>
        </div>

    </div>

</section>

<section id="services" class="white-section">

    <h2 class="menu-title">SERVICES WE OFFER</h2>

    <div class="menu-cards">

        <div class="menu-card">
            <img class="menu-image" src="{{ asset('assets/images/hair cut.jpg') }}" alt="Classic Haircut">
            <h3 class="menu-name">Classic Haircut</h3>
            <span class="menu-price">₱200</span>
        </div>

        <div class="menu-card">
            <img class="menu-image" src="{{ asset('assets/images/hair style.jpg') }}" alt="Hair Styling">
            <h3 class="menu-name">Hair Styling</h3>
            <span class="menu-price">₱300</span>
        </div>

        <div class="menu-card">
            <img class="menu-image" src="{{ asset('assets/images/beard trim.jpg') }}" alt="Beard Trim">
            <h3 class="menu-name">Beard Trim</h3>
            <span class="menu-price">₱150</span>
        </div>

        <div class="menu-card">
            <img class="menu-image" src="{{ asset('assets/images/hair wash.jpg') }}" alt="Hair Wash">
            <h3 class="menu-name">Hair Wash</h3>
            <span class="menu-price">₱300</span>
        </div>

        <div class="menu-card">
            <img class="menu-image" src="{{ asset('assets/images/kids cut.jpg') }}" alt="Kids Cut">
            <h3 class="menu-name">Kids Cut</h3>
            <span class="menu-price">₱150</span>
        </div>

    </div>

    <div class="view-all-container">
    <a href="#" class="view-all-btn">View All Services</a>
    </div>



</section>

<section id="about" class="about-section">


    <div class="recycle-view">

        <div class="rec-card">
            <div class="rec-image-wrap">
                <img class="rec-image" src="{{ asset('assets/images/aboutUs.png') }}" alt="Our Barbers">
            </div>
            <div class="rec-text">
                <h2>About us</h2>
                <h1>Precision.Style.Confidence</h1>
                <p>We are a modern barbershop dedicated to providing quality haircuts, clean grooming, and a relaxing experience<br>
                for every customer. Our skilled barbers focus on detail, style, and customer satisfaction <br>
                 to make sure you leave looking and feeling your best. Whether you want a classic haircut, a fresh fade,<br>
                  or a clean beard trim, we are here to give you a sharp and confident look.</p>
                <a href="#" class="more-aboutus-btn">More About us</a>
            </div>
        </div>

    </div>

</section>



<section id="contact" class="footer-section">
    <div class="footer-container">

        <div class="footer-col">
            <h3 class="footer-heading">Services</h3>
            <ul class="footer-links">
                <li><a href="#">Classic Haircut</a></li>
                <li><a href="#">Hair Styling</a></li>
                <li><a href="#">Beard Trim</a></li>
                <li><a href="#">Hair Wash</a></li>
                <li><a href="#">Kids Cut</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h3 class="footer-heading">Quick Links</h3>
            <ul class="footer-links">
                <li><a href="#hero">Home</a></li>
                <li><a href="#about">About Us</a></li>
                <li><a href="#services">Services</a></li>
                <li><a href="{{ route('login') }}" class="nav-link nav-btn">Book Appointment</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h3 class="footer-heading">Contact Us</h3>
            <ul class="footer-links">
                <li>123 Barbershop Street, Manila</li>
                <li>+63 912 345 6789</li>
                <li>barbershop@gmail.com</li>
                <li>Mon - Sat: 9:00 AM - 8:00 PM</li>
            </ul>
        </div>

        <div class="footer-col">
            <h3 class="footer-heading">Newsletter</h3>
            <p class="footer-newsletter-text">Subscribe to get updates on promotions and offers.</p>
            <form class="newsletter-form">
                <input type="email" class="newsletter-input" placeholder="Enter your email">
                <button type="submit" class="newsletter-btn">Subscribe</button>
            </form>
        </div>

    </div>

    <div class="footer-bottom">
        <p>&copy; 2026 Barbershop. All rights reserved.</p>
    </div>
</section>

</body>
</html>