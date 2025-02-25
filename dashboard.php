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
    die("Connection failed: " . $conn->connect_error);
}

// session_start();

// Set the session timeout duration (in seconds)
// $session_timeout = 300; // 5 minutes

// Check if the user is logged in
if (!isset($_SESSION['login']) || $_SESSION["login"] !== true) {
  // Unset all session variables and destroy the session
  session_unset();
  session_destroy();
  header("Location: /login.php");
  exit();
}


if (isset($_GET['id'])) {
  // Get the value of 'id' from the URL and sanitize it
  $id = intval($_GET['id']); // Convert to integer to prevent SQL injection

  // Prepare the SQL statement
  $sql = "SELECT * FROM UserInformation WHERE id = ?";
  // Prepare the statement
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, 'i', $id); // Bind the parameter
  mysqli_stmt_execute($stmt); // Execute the statement

  // Get the result
  $result = mysqli_stmt_get_result($stmt);

  // Check if the query was successful
  if ($result) {
      // Fetch the result row
      $row = mysqli_fetch_assoc($result);
      // echo $row['email'];
  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }

  // Close the statement
  mysqli_stmt_close($stmt);
}

// Close connection
$conn->close();

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
                            <a href="mailto:service@sbaorg.com">service@sbaorg.com</a>
                        </li>
                        <li>
                            <span class="topbar__info__icon topbar__info__icon--phone">
                                <i class="icon-headset"></i>
                            </span>
                            <!-- <a href="tel:+18572981694">+1(857) 298-1694</a> -->
                        </li>
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
                            <li>
                                <a href="/logout.php">Logout</a>
                            </li>
                        </ul>
            </nav><!-- /.main-header__nav -->
                        <div class="mobile-nav__btn mobile-nav__toggler">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div><!-- /.mobile-nav__toggler -->
                        <a href="/dashboard.php" class="easilon-btn main-header__btn">
                            <span><?php echo $row['acct_name']; ?></span>
                            <span class="easilon-btn__icon"><i class="icon-right-arrow"></i></span>
                        </a><!-- /.easilon-btn main-header__btn -->
                    </div><!-- /.main-header__right -->
                                        
                        
                </div><!-- /.main-header__inner -->
            </div><!-- /.container-fluid -->
        </header><!-- /.main-header -->

		
                                                      <style>
.et-hero-tabs {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  height: 8vh;
  position: relative;
  background: #eee;
  text-align: center;
  padding: 0 2em;
}
.et-slide {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  position: relative;
  background: #eee;
  text-align: center;
  padding: 10px 20px;
}
.et-hero-tabs h1,
.et-slide h1 {
  font-size: 2rem;
  margin: 0;
  letter-spacing: 1rem;
}
.et-hero-tabs h3,
.et-slide h3 {
  font-size: 1rem;
  letter-spacing: 0.3rem;
  opacity: 0.6;
}

.et-hero-tabs-container {
  display: flex;
  flex-direction: row;
  position: absolute;
  bottom: 0;
  width: 100%;
  height: 70px;
  box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
  background: #fff;
  z-index: 10;
}
.et-hero-tabs-container--top {
  position: fixed;
  top: 80px;
}

.et-hero-tab {
  display: flex;
  justify-content: center;
  align-items: center;
  flex: 1;
  color: #000;
  letter-spacing: 0.1rem;
  transition: all 0.5s ease;
  font-size: 0.8rem;
}
.et-hero-tab:hover {
  color: white;
  background: rgba(102, 177, 241, 0.8);
  transition: all 0.5s ease;
}

.et-hero-tab-slider {
  position: absolute;
  bottom: 0;
  width: 0;
  height: 6px;
  background: #002e6d;
  transition: left 0.3s ease;
}

  /* @media (max-width: 587px) {
  .et-hero-tabs-container--top {
  position: fixed;
  top: 100px;
  }
} */
@media (min-width: 800px) {
  .et-hero-tabs h1,
.et-slide h1 {
    font-size: 3rem;
  }
  .et-hero-tabs h3,
.et-slide h3 {
    font-size: 1rem;
  }

  .et-hero-tab {
    font-size: 1rem;
  }
}
  .dashboarda {
    background-color: white;
    width:100%;
    border:#e5e5e5 solid 2px; 
    display:flex; 
    color:#002e6d;
    justify-content: space-between;
    padding:20px 50px;
    margin:0 20px;
    text-align: left;
  }
  .dashboarda > div {
    width:45%;
  }
  .dashboarda > div.full {
    width:90%;
  }
  .dashboarda > div.full > div {
    border-bottom:#e5e5e5 solid 2px; 
    width: 100%;
    position: relative;
    padding:10px 0px;
  }
  .dashboarda > div.full > div > a{
    position:absolute;
    right:20px;
    top:10px;
    padding:15px 20px;
    background-color: transparent;
    color:skyblue;
    border:skyblue solid 2px; 
  }
  .dashboarda > div.full > div > h6.success {
    color:skyblue;
  }
  .dashboarda > div > div > p {
    font-size: 1rem;
    line-height: 20px;
    margin: 0px;
  }

  @media (max-width: 587px) {
    .dashboarda {
    background-color: white;
    width:100%;
    border:#e5e5e5 solid 2px; 
    display:flex; 
    flex-direction: column;
    color:#002e6d;
    justify-content: space-between;
    padding:20px;
    margin:0 20px;
  }
  .dashboarda > div.full > div > h6.success {
    color:skyblue;
    font-size: 10px;
  }
    .dashboarda > div {
    width:90%;
  }
  .dashboarda > div > div > p {
    font-size: 0.8rem;
    line-height: 20px;
  }
  .dashboarda > div.full > div > a{
    font-size: 10px;
    right:10px;
    top:15px;
    padding:10px 15px;
  }
  }
  .dashboarda > div > p {
    color:#002e6d;
    font-weight: 500;
    font-size: 1.2rem;
    border-bottom:solid 3px #002e6d;
    text-align:left;
    padding:5px 12px;
  }
  /* .dashboarda > div > div.alert {
    justify-content: start;
    display: flex;
    flex-direction: ;
    width: auto !important;
  } */
  .dashboarda > div > div > h4 {
    color:red;
    font-size: 1.5rem;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  .dashboarda > div > div.alert.alert-success > p {
    color:darkgreen;
  }
  .dashboarda > div > div.alert.alert-secondary > p {
    color:black;
  }
  .media-body p{
    font-size:0.8rem;
  }
  .alert {
  position: relative;
  padding: 0.75rem 1.25rem;
  margin-bottom: 1rem;
  border: 1px solid transparent;
  border-radius: 0.25rem;
}

.alert-primary {
  color: #004085;
  background-color: #cce5ff;
  border-color: #b8daff;
}

.alert-secondary {
  color: #383d41;
  background-color: #e2e3e5;
  border-color: #d6d8db;
}

.alert-success {
  color: #155724;
  background-color: #d4edda;
  border-color: #c3e6cb;
}

.alert-danger {
  color: #721c24;
  background-color: #f8d7da;
  border-color: #f5c6cb;
}

.alert-warning {
  color: #856404;
  background-color: #fff3cd;
  border-color: #ffeeba;
}

.alert-info {
  color: #0c5460;
  background-color: #d1ecf1;
  border-color: #bee5eb;
}

.alert-light {
  color: #818182;
  background-color: #fefefe;
  border-color: #fdfdfe;
}

.alert-dark {
  color: #1b1e21;
  background-color: #d6d8d9;
  border-color: #c6c8ca;
}

</style>

    <main>
        <!-- Hero -->
        <section class="et-hero-tabs">
            <div class="et-hero-tabs-container">
                <a class="et-hero-tab" href="#tab-es6">Application</a>
                <a class="et-hero-tab" href="#tab-flexbox">Disbursement</a>
                <a class="et-hero-tab" href="#tab-react">Verification</a>
                <span class="et-hero-tab-slider"></span>
            </div>
        </section>

        <!-- Main -->
        <main class="et-main">
            <section class="et-slide" id="tab-es6">           
              <div class="container p-0 d-flex justify-center">
              
                        <div class="dashboarda">
                                      <div>
                                          <p>Your Quote</p>
                                          <div class="alert alert-secondary">
                                          <?php if($row['status_qoute'] == "amount_not_confirmed"){?>
                                            <p><strong>Status:</strong>Amount not confirmed!</p>
                            <?php } else {?>
                              <p><strong>Status:</strong>Amount confirmed!</p>
                            <?php }?>


                                          <?php if($row['your_qoute'] == 0){?>
                              <h4>$0.00</h4>
                            <?php } else {?>
                              <h4 class="text-success">$<?php echo number_format($row['your_qoute'], 2); ?></h4>
                            <?php }?>
                                          </div>
                                      </div>
                                      <div>
                                          <p>Status:</p>
                                          <div class="alert alert-warning">
                                          <?php if($row["status"] == "is Pending") {?>
                                            <p class="text-warning">Your Grant Application Is Pending</p>
                                          <?php } else if($row["status"] == "is Approved") {?>
                                            <p class="text-success">Your Grant Application <?php echo $row["status"]; ?></p>
                                          <?php } else {?>
                                            <p class="text-danger">Your Grant Application <?php echo $row["status"]; ?></p>
                                          <?php } ?>
                                        </div>                                          
                                          
                                      </div>
                                      
                          </div> 
                          <!-- <div class="dashboarda">
                          <div class="full">
                                      <p>Applicant</p>
                                    </div>
                          </div> -->
                    </div>
                    <div class="container p-0 d-flex justify-center">
            <div class="dashboarda">
                        <div class="full">
                            <p>Your Profile</p>
                            <div class="">
                                <div class="media contact-info p-0 m-0" style="width: 100% !important;">
                                  <span class="contact-info__icon"><i class="ti-user"></i></span>
                                <div class="media-body">
                                    <h3 style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;letter-spacing:0 !important;"><?php echo $row['acct_name'] ?></h3>
                                    <p><?php echo $row['acct_email']; ?></p>
                                </div>
                              </div>
                            </div>
                            <div class="">
                            <div class="media contact-info p-0 m-0" style="width: 100% !important;">
                                  <span class="contact-info__icon"><i class="ti-layers"></i></span>
                                <div class="media-body">
                                    <h3 style="font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;letter-spacing:0 !important;">Beneficiary Bank:  <?php echo $row['name_of_bank']; ?></h3>
                                    <p class="m-0">Account Number: <span style="color: blue;" class="text-primary"><?php echo $row['account_number']; ?></span></p>
                                    <p class="m-0">Routing No.: <?php echo $row['routing_number']; ?></p>
                                    <p class="m-0 mb-2">Beneficiary Bank Address: <?php echo $row['bank_address']; ?></p>
                                    <p class="m-0 mb-2">Applied Amount: <span style="color:green">$<?php echo $row['amount_applied']; ?>.00</span></p>
                                </div>
                              </div>
                            <p></p>
                            </div>
                        </div>
            </div>
      </div>
            </section>
            <section class="et-slide" id="tab-flexbox">
<div class="container p-0 d-flex justify-center">
            <div class="dashboarda">
                        <div>
                            <p>Advance Type</p>
                            <div class="">
                            <p>Disbursement fee</p>
                            <?php if($row['disbursement_fee'] == 0){?>
                              <h4>$0.00</h4>
                            <?php } else {?>
                              <h4 class="text-success">$<?php echo number_format($row['disbursement_fee'], 2); ?></h4>
                            <?php }?>
                            
                            </div>
                        </div>
                        <div>
                            <p>Status:</p>
                              <h6><?php echo $row['disbursement_fee_status']; ?></h6>                                                       
                        </div>
            </div>
        </div>
        <div class="container p-0 d-flex justify-center">
            <div class="dashboarda">
                        <div>
                            <p>Advance Type</p>
                            <div class="">
                            <p>Over Age Payment</p>
                            <?php if($row['over_age_payement'] == 0){?>
                              <h4>$0.00</h4>
                            <?php } else {?>
                              <h4 class="text-success">$<?php echo number_format($row['over_age_payement'], 2); ?></h4>
                            <?php }?>
                            </div>
                        </div>
                        <div>
                            <p>Status:</p>
                              <h6><?php echo $row['over_age_payement_status']; ?></h6>                                                       
                        </div>
            </div>
        </div>
            </section>
            <section class="et-slide" id="tab-react">
<div class="container p-0 d-flex justify-center">
            <div class="dashboarda">
                        <div class="full">
                            <p>Steps to complete</p>
                            <div class="">
                            <p>Verify Identification</p>
                            <h6 class="success"><?php echo $row["verify_identification"]; ?></h6>
                            <!-- <a class="small" style="border:2px solid green;padding:5px;color:green">Submitted</a> -->
                            </div>
                            <div class="">
                            <p>Electronic Disbursement</p>
                            <h6 class="success"><?php echo $row["electronic_disbursement"]; ?></h6>
                            <!-- <a class="btn" href="/view">view</a> -->
                            </div>
                        </div>
            </div>
      </div>
            </section>
        </main>
    </main>
    
<footer class="main-footer main-footer--home">
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
                    <a href="mailto:businessgrant.sba@aol.com">businessgrant.sba@aol.com</a>
                </li>
                <li>
                    <span class="mobile-nav__contact__icon"><i class="fa fa-phone-alt"></i></span>
                    <a href="tel:+18572981694">+1(857) 298-1694</a>
                </li>
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
