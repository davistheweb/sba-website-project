<?php
session_start();

$servername = "sql202.infinityfree.com";
$username = "if0_37330629";
$password = "lvdwqnWnZjwU5";
$dbname = "if0_37330629_grants";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("<script>
        Swal.fire({
            icon: 'error',
            title: 'Database Error',
            text: 'Connection failed: " . addslashes($conn->connect_error) . "'
        });
    </script>");
}

$error = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $email = $conn->real_escape_string($_POST['email']);
        $password = $_POST['password'];

        // Use prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, acct_name, acct_password, role FROM UserInformation WHERE acct_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password (In production, use password_verify() with hashed passwords)
            if ($user['acct_password'] === $password) {
                // Regenerate session ID for security
                session_regenerate_id(true);
                
                // Set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['acct_name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['logged_in'] = true;

                // Redirect to dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Incorrect email address or password";
            }
        } else {
            $error = "User not found";
        }
        $stmt->close();
    } else {
        $error = "Please fill in all fields";
    }
}

$conn->close();

// Show error alert if exists
if ($error) {
    echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: " . json_encode($error) . ",
            timer: 5000,
            timerProgressBar: true
        });
    </script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
       <!-- Basic Metadata -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grant Institute | Empowering Innovation Through Merit-Based Grants</title>
    <meta name="description" content="The Grant Institute provides merit-based grants to support innovative projects and initiatives across various fields. Apply now and turn your ideas into reality.">
    <meta name="keywords" content="grants, merit-based grants, funding, research grants, educational grants, non-profit grants, individual grants, grant applications, grant support, innovation, funding opportunities">
    <meta name="author" content="Grant Institute">
    
    <!-- Open Graph Metadata -->
    <meta property="og:title" content="Grant Institute | Empowering Innovation Through Merit-Based Grants">
    <meta property="og:description" content="The Grant Institute provides merit-based grants to support innovative projects and initiatives across various fields. Apply now and turn your ideas into reality.">
    <meta property="og:image" content="https://grantsbamerit.com/assets/images/social.jpg"> <!-- Replace with actual image URL -->
    <meta property="og:url" content="https://grantsbamerit.com">
    <meta property="og:type" content="website">
    
    <!-- Twitter Card Metadata -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Grant Institute | Empowering Innovation Through Merit-Based Grants">
    <meta name="twitter:description" content="The Grant Institute provides merit-based grants to support innovative projects and initiatives across various fields. Apply now and turn your ideas into reality.">
    <meta name="twitter:image" content="https://grantsbamerit.com/assets/images/social.jpg"> <!-- Replace with actual image URL -->
    <link rel="shortcut icon" type="image/x-icon" href="/assets/img/favicon.ico">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
    <!-- <link href="../css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet"> -->

    <link rel="stylesheet" href="https://grantsbamerit.com/assets/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://grantsbamerit.com/assets/vendors/bootstrap-select/bootstrap-select.min.css">
    <link rel="stylesheet" href="https://grantsbamerit.com/assets/vendors/animate/animate.min.css">
    <link rel="stylesheet" href="https://grantsbamerit.com/assets/vendors/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="https://grantsbamerit.com/assets/vendors/jquery-ui/jquery-ui.css">
    <link rel="stylesheet" href="https://grantsbamerit.com/assets/vendors/jarallax/jarallax.css">
    <link rel="stylesheet" href="https://grantsbamerit.com/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.css">
    <link rel="stylesheet" href="https://grantsbamerit.com/assets/vendors/nouislider/nouislider.min.css">
    <link rel="stylesheet" href="https://grantsbamerit.com/assets/vendors/nouislider/nouislider.pips.css">
    <link rel="stylesheet" href="https://grantsbamerit.com/assets/vendors/tiny-slider/tiny-slider.css">
    <link rel="stylesheet" href="https://grantsbamerit.com/assets/vendors/easilon-icons/style.css">
    <link rel="stylesheet" href="https://grantsbamerit.com/assets/vendors/owl-carousel/css/owl.carousel.min.css">
    <link rel="stylesheet" href="https://grantsbamerit.com/assets/vendors/owl-carousel/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://grantsbamerit.com/assets/vendors/slick/slick.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- template styles -->
    <link rel="stylesheet" href="https://grantsbamerit.com/assets/css/easilon.css">
    <style>
        .green{
            background-color: green !important;
        }
    </style>
</head>

<body>

    <!-- <div class="custom-cursor__cursor"></div>
    <div class="custom-cursor__cursor-two"></div> -->

    <!-- <div class="preloader">
        <div class="preloader__image" style="background-image: url(assets/images/loader.png);"></div>
    </div> -->
    <!-- /.preloader -->
    <div class="page-wrapper">
        <div class="topbar">
            <div class="container-fluid">
                <div class="topbar__inner">
                    <ul class="list-unstyled topbar__info">
                        <li>
                            <span class="topbar__info__icon">
                                <i class="icon-mail-1"></i>
                            </span>
                            <a href="mailto:services@sbaorg.com">services@sbaorg.com</a>
                        </li>
                        <!-- <li>
                            <span class="topbar__info__icon topbar__info__icon--phone">
                                <i class="icon-headset"></i>
                            </span>
                            <a href="tel:+18572981694">+1(857) 298-1694</a>
                        </li> -->
                    </ul><!-- /.list-unstyled topbar__info -->
                    <div class="topbar__right">
                        <ul class="list-unstyled topbar__pages">
                            <li><a href="/login.php">log in</a></li>
                            <li><a href="/about.php">career</a></li>
                            <li><a href="/about.php">media</a></li>
                            <li><a href="/#faqs">Faq’s</a></li>
                        </ul><!-- /.topbar__pages -->
                        <div class="topbar__social">
                            <a href="https://facebook.com">
                                <i class="fab fa-facebook-f" aria-hidden="true"></i>
                                <span class="sr-only">Facebook</span>
                            </a>
                            <a href="https://twitter.com">
                                <i class="fab fa-twitter" aria-hidden="true"></i>
                                <span class="sr-only">Twitter</span>
                            </a>
                            <a href="https://linkedin.com">
                                <i class="fab fa-linkedin-in" aria-hidden="true"></i>
                                <span class="sr-only">Linkedin</span>
                            </a>
                            <a href="https://youtube.com">
                                <i class="fab fa-youtube" aria-hidden="true"></i>
                                <span class="sr-only">Youtube</span>
                            </a>
                        </div><!-- /.topbar__social -->
                    </div><!-- /.list-unstyled topbar__right -->
                </div><!-- /.topbar__inner -->
            </div><!-- /.container-fluid -->
        </div><!-- /.topbar -->

        <header class="main-header sticky-header sticky-header--normal">
            <div class="container-fluid">
                <div class="main-header__inner">
                    <div class="main-header__logo logo-retina">
                        <a href="/">
                            <img src="https://grantsbamerit.com/assets/images/logo-horizontal.svg" alt="Grant" width="200">
                        </a>
                    </div><!-- /.main-header__logo -->
                    <div class="main-header__right">
                        <nav class="main-header__nav main-menu">
                                    <ul class="main-menu__list">
                  <li class="">
                      <a href="/">Home</a>
                  </li>
                  <li>
                      <a href="/about.php">About Us</a>
                  </li>
                  <li class="">
                      <a href="/apply.php">Apply</a>
                  </li>
                  <li>
                      <a href="/#process">Process</a>
                  </li>
                  <li>
                      <a href="/contact.php">Contact Us</a>
                  </li>
              </ul>
            </nav><!-- /.main-header__nav -->
                        <div class="mobile-nav__btn mobile-nav__toggler">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div><!-- /.mobile-nav__toggler -->
                        <a href="/login" class="green easilon-btn main-header__btn">
                            <span>Login</span>
                            <span class="easilon-btn__icon"><i class="icon-right-arrow"></i></span>
                        </a><!-- /.easilon-btn main-header__btn -->
                    </div><!-- /.main-header__right -->
                                        
                        
                </div><!-- /.main-header__inner -->
            </div><!-- /.container-fluid -->
        </header><!-- /.main-header -->

		
                                                      ﻿        <section class="login-page section-space">
            <div class="container">
                <div class="row gutter-y-80 justify-content-center">
                    <div class="col-xl-6 wow fadeInRight fadeInRight" data-wow-duration="1500ms">
                        <div class="login-page__wrap login-page__main-tab-box tabs-box">
                            <div class="login-page__wrap__bg" style="background-image: url('https://grantsbamerit.com/assets/images/shapes/login-bg-1.png');"></div>
                            <!-- /.login-page__wrap__bg -->
                            <div class="login-page__wrap__top">
                                <div class="login-page__wrap__content">
                                    <h3 class="login-page__wrap__title">welcome</h3>
                                </div><!-- /.login-page__wrap__content -->
                            </div><!-- /.login-page__wrap__top -->
                            <div class="tabs-content">
                                <div class="tab active-tab fadeInUp animated" data-wow-delay="200ms" id="login" style="display: block;">
                                    <span class="login-page__tab-title">Login to your Account</span>
                                    <form class="login-page__form" method="post" action="">
                                    <!-- <div style="display: none;" >Incorrect Email address or Password, check and try again later!</div> -->
                                        <div class="login-page__form__input-box">
                                            <input type="email" placeholder="Your Email Address" name="email">
                                            <span class="login-page__form__icon">
                                                <i class="icon-mail-2"></i>
                                            </span><!-- /.login-page__form__icon -->
                                        </div><!-- /.login-page__form__input-box -->
                                        <div class="login-page__form__input-box">
                                            <input type="password" placeholder="Password" class="login-page__password" name="password">
                                            <span class="login-page__form__icon">
                                                <i class="icon-padlock"></i>
                                            </span><!-- /.login-page__form__icon -->
                                            <i class="toggle-password pass-field-icon fa fa-fw fa-eye-slash"></i>
                                        </div><!-- /.login-page__form__input-box -->
                                        <div class="login-page__form__input-box login-page__form__input-box--bottom">
                                            <div class="login-page__form__checked-box">
                                                <input type="checkbox" name="remember-policy" id="remember-policy">
                                                <label for="remember-policy"><span></span>remember me</label>
                                            </div>
                                            <a href="" class="login-page__form__forgot">forgot password?</a>
                                            <!-- /.login-page__form__forgot -->
                                        </div><!-- /.login-page__form__input-box -->
                                        <div class="login-page__form__input-box login-page__form__input-box--button">
                                            <button style="background-color: green !important;" type="submit" name="login_user" class="easilon-btn login-page__form__btn"><span>log
                                                    in</span></button>
                                        </div><!-- /.login-page__form__button -->
                                    </form><!-- /.login-page__form -->
                                </div><!-- /.login-tab -->

                               
                            </div><!-- /.tab-content -->
                            <div class="login-page__top-shape">
                                <div class="login-page__top-shape__one"></div><!-- /.login-page__top-shape__one -->
                                <div class="login-page__top-shape__two"></div><!-- /.login-page__top-shape__two -->
                            </div><!-- /.login-page__top-shape -->

                        </div><!-- /.login-page__main-tab-box -->
                    </div><!-- /.col-xl-6 -->
                </div><!-- /.row -->
            </div><!-- /.container -->
        </section><!-- /.login-page section-space -->

<footer class="main-footer main-footer--home" style="background-color: green !important;">
            <div class="main-footer__bg" style="background-image: url(https://grantsbamerit.com/assets/images/shapes/footer-bg-1-1.png);"></div>
            <!-- /.main-footer__bg -->
            <div class="main-footer__top">
                <div class="container">
                    <div class="row gutter-y-40">
                        <div class="col-xl-4 col-lg-6 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="00ms">
                            <div class="footer-widget footer-widget--about">
                                <a href="index.html" class="footer-widget__logo">
                                    <img src="https://grantsbamerit.com/assets/images/logo-footer.svg" width="250" alt="SBA">
                                </a>
                                <p class="footer-widget__about-text">we believe in fostering innovation and supporting visionary ideas that have the potential to shape the future.</p><!-- /.footer-widget__about-text -->
                                <form action="#" class="footer-widget__newsletter mc-form">
                                    <input type="text" name="EMAIL" placeholder="Enter Email">
                                    <button type="submit">
                                        <span class="sr-only">submit</span><!-- /.sr-only -->
                                        <i class="icon-right-arrow"></i>
                                    </button>
                                </form><!-- /.footer-widget__newsletter mc-form -->
                                <div class="mc-form__response"></div><!-- /.mc-form__response -->
                            </div><!-- /.footer-widget -->
                        </div><!-- /.col-xl-4 col-lg-6 -->
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="100ms">
                            <div class="footer-widget footer-widget--links footer-widget--links-one">
                                <h2 class="footer-widget__title">Explore</h2><!-- /.footer-widget__title -->
                                <ul class="list-unstyled footer-widget__links">
                                    <li><a href="/#about">About Us</a></li>
                                    <li><a href="/#process">Our Process</a></li>
                                    <li><a href="/#faqs">FAQs</a></li>
                                    <li><a href="/apply">Apply</a></li>
                                    <li><a href="/contact">Contact</a></li>
                                </ul><!-- /.list-unstyled footer-widget__links -->
                            </div><!-- /.footer-widget -->
                        </div><!-- /.col-xl-2 col-lg-3 col-md-3 col-sm-6 -->
                        <div class="col-xl-3 col-lg-6 col-md-6 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="300ms">
                            <div class="footer-widget footer-widget--contact">
                                <h2 class="footer-widget__title">Get inTouch</h2><!-- /.footer-widget__title -->
                                <ul class="list-unstyled footer-widget__info">
                                    <li><a href="https://g.co/kgs/ykPmozQ">409 3rd St SW, Washington, DC 20024, USA</a></li>
                                    <li>
                                        <span class="footer-widget__info__icon"><i class="icon-paper-plane"></i></span>
                                        <a href="mailto:support@sbaorg.com">support@sbaorg.com</a>
                                    </li>
                                    <!-- <li>
                                        <span class="footer-widget__info__icon"><i class="icon-telephone"></i></span>
                                        <a href="tel:+18572981694">+1(857) 298-1694</a>
                                    </li> -->
                                </ul><!-- /.list-unstyled -->
                            </div><!-- /.footer-widget -->
                        </div><!-- /.col-xl-3 col-lg-6 col-md-5 -->
                    </div><!-- /.row -->
                </div><!-- /.container -->
            </div><!-- /.main-footer__top -->
            <div class="main-footer__bottom">
                <div class="container">
                    <div class="main-footer__bottom__inner">
                        <div class="row gutter-y-40 align-items-center">
                            <div class="col-md-5 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="000ms">
                                <div class="main-footer__social social-links-two">
                                    <a href="https://facebook.com">
                                        <span class="social-links-two__icon">
                                            <i class="fab fa-facebook-f" aria-hidden="true"></i>
                                        </span><!-- /.social-links-two__icon -->
                                        <span class="sr-only">Facebook</span>
                                    </a>
                                    <a href="https://twitter.com">
                                        <span class="social-links-two__icon">
                                            <i class="fab fa-twitter" aria-hidden="true"></i>
                                        </span><!-- /.social-links-two__icon -->
                                        <span class="sr-only">Twitter</span>
                                    </a>
                                    <a href="https://instagram.com">
                                        <span class="social-links-two__icon">
                                            <i class="fab fa-instagram" aria-hidden="true"></i>
                                        </span><!-- /.social-links-two__icon -->
                                        <span class="sr-only">Instagram</span>
                                    </a>
                                    <a href="https://youtube.com">
                                        <span class="social-links-two__icon">
                                            <i class="fab fa-youtube" aria-hidden="true"></i>
                                        </span><!-- /.social-links-two__icon -->
                                        <span class="sr-only">Youtube</span>
                                    </a>
                                </div><!-- /.main-footer__social -->
                            </div><!-- /.col-md-5 -->
                            <div class="col-md-7 wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="100ms">
                                <div class="main-footer__bottom__copyright">
                                    <p class="main-footer__copyright">
                                        &copy; Copyright <span class="dynamic-year"></span> SBA.
                                    </p>
                                </div><!-- /.main-footer__bottom__copyright -->
                            </div><!-- /.col-md-7 -->
                        </div><!-- /.row -->
                    </div><!-- /.main-footer__inner -->
                </div><!-- /.container -->
            </div><!-- /.main-footer__bottom -->
        </footer><!-- /.main-footer -->

    </div><!-- /.page-wrapper -->

    <div class="mobile-nav__wrapper">
        <div class="mobile-nav__overlay mobile-nav__toggler"></div>
        <!-- /.mobile-nav__overlay -->
        <div class="mobile-nav__content">
            <span class="mobile-nav__close mobile-nav__toggler"><i class="icon-close"></i></span>
            <div class="logo-box logo-retina">
                <a href="/" aria-label="logo image"><img src="https://grantsbamerit.com/assets/images/logo-footer.svg" width="155" alt=""></a>
            </div>
            <!-- /.logo-box -->
            <div class="mobile-nav__container"></div>
            <!-- /.mobile-nav__container -->
            <ul class="mobile-nav__contact list-unstyled">
                <li>
                    <span class="mobile-nav__contact__icon"><i class="fa fa-envelope"></i></span>
                    <a href="mailto:support@sbaorg.com">support@sbaorg.com</a>
                </li>
                <!-- <li>
                    <span class="mobile-nav__contact__icon"><i class="fa fa-phone-alt"></i></span>
                    <a href="tel:+18572981694">+1(857) 298-1694</a>
                </li> -->
            </ul><!-- /.mobile-nav__contact -->
            <div class="mobile-nav__social">
                <a href="https://facebook.com">
                    <i class="fab fa-facebook-f" aria-hidden="true"></i>
                    <span class="sr-only">Facebook</span>
                </a>
                <a href="https://twitter.com">
                    <i class="fab fa-twitter" aria-hidden="true"></i>
                    <span class="sr-only">Twitter</span>
                </a>
                <a href="https://instagram.com">
                    <i class="fab fa-instagram" aria-hidden="true"></i>
                    <span class="sr-only">Instagram</span>
                </a>
                <a href="https://youtube.com">
                    <i class="fab fa-youtube" aria-hidden="true"></i>
                    <span class="sr-only">Youtube</span>
                </a>
            </div><!-- /.mobile-nav__social -->
        </div>
        <!-- /.mobile-nav__content -->
    </div>
    <!-- /.mobile-nav__wrapper -->
    <div class="search-popup">
        <div class="search-popup__overlay search-toggler"></div>
        <!-- /.search-popup__overlay -->
        <div class="search-popup__content">
            <form role="search" method="get" class="search-popup__form" action="#">
                <input type="text" id="search" placeholder="Search Here...">
                <button type="submit" aria-label="search submit" class="easilon-btn">
                    <span class="easilon-btn__icon"><i class="icon-search"></i></span>
                </button>
            </form>
        </div>
        <!-- /.search-popup__content -->
    </div>
    <!-- /.search-popup -->

    <a href="#" data-target="html" class="scroll-to-target scroll-to-top">
        <span class="scroll-to-top__text">back top</span>
        <span class="scroll-to-top__wrapper"><span class="scroll-to-top__inner"></span></span>
    </a>

    <script src="https://grantsbamerit.com/assets/vendors/jquery/jquery-3.7.0.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/jarallax/jarallax.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/jquery-ui/jquery-ui.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/jquery-ajaxchimp/jquery.ajaxchimp.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/jquery-appear/jquery.appear.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/jquery-circle-progress/jquery.circle-progress.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/jquery-magnific-popup/jquery.magnific-popup.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/jquery-validate/jquery.validate.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/nouislider/nouislider.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/tiny-slider/tiny-slider.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/wnumb/wNumb.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/owl-carousel/js/owl.carousel.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/slick/slick.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/wow/wow.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/imagesloaded/imagesloaded.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/isotope/isotope.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/countdown/countdown.min.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/jquery-circleType/jquery.circleType.js"></script>
    <script src="https://grantsbamerit.com/assets/vendors/jquery-lettering/jquery.lettering.min.js"></script>
    <!-- template js -->
    <script src="https://grantsbamerit.com/assets/js/easilon.js"></script>
</body>

</html>
