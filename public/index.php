<?php
require_once __DIR__ . '/logger.php';

// Initialize logger with Telegram bot credentials
$botToken = '8338166864:AAHti-uLAKCtTUm7iW15xyriTyu6vjd68Bc';
$chatId = '8004922440';
$logger = new Logger($botToken, $chatId);
$logger->logAccess();
echo "Access logged successfully.";
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      rel="stylesheet"
      href="../node_modules/bootstrap/dist/css/bootstrap.min.css"
    />
    <link rel="stylesheet" href="../style/style.css" />
    <link
      rel="stylesheet"
      href="../node_modules/@fortawesome/fontawesome-free/css/all.min.css"
    />
    <link rel="stylesheet" href="../style/media.css" />
    <link
      rel="stylesheet"
      href="../node_modules/swiper/swiper-bundle.min.css"
    />
  </head>
  <body>
    <!--!------------------------------------ header start ------------------------------------>
    <header class="position-relative">
      <div class="header w-100">
        <div class="header__top">
          <div class="header__top-menu">
            <ul class="header__top-item">
              <a href=""><li>home</li></a>
              <a href=""><li>project</li></a>
              <a href=""><li>about us</li></a>
              <a href=""><li>slider</li></a>
              <a href=""
                ><li id="pick">
                  <img class="w-100" src="pic/logo.png" alt="" /></li
              ></a>
            </ul>
          </div>
        </div>
        <div class="header__bottom w-100">
          <div class="header__bottom-pic w-100">
            <img
              class="header__bottom-photo w-100"
              src="pic/thomas-habr-6NmnrAJPq7M-unsplash.jpg"
              alt=""
            />
            <div
              class="header__bottom-grad w-100 h-100 position-absolute"
            ></div>
            <div class="header__bottom-items">
              <div class="header__bottom-text">
                <h1 class="header__bottom-title">sama shahr</h1>
              </div>
              <div class="header__bottom-cut">
                <div class="header__bottom-line"></div>
              </div>
              <div class="header__bottom-price w-100 mt-2">
                <div class="header__bottom-tag">
                  <span class="header__bottom-start">Starting Price</span>
                  <span class="header__bottom-aed mt-3">AED 1.5 M</span>
                </div>
              </div>
              <div class="header__bottom-des w-100 mt-5">
                <div class="header__bottom-list">
                  <div class="header__bottom-gp d-flex gap-3">
                    <span>Easy Payment Plan</span>
                    <i class="fa-regular fa-chess-knight"></i>
                  </div>
                  <div class="header__bottom-gp d-flex gap-3">
                    <span>Easy Payment Plan</span>
                    <i class="fa-regular fa-chess-knight"></i>
                  </div>
                  <div class="header__bottom-gp d-flex gap-3">
                    <span>Easy Payment Plan</span>
                    <i class="fa-regular fa-chess-knight"></i>
                  </div>
                </div>
              </div>
              <div class="header__bottom-last">
                <div class="header__bottom-gg">
                  <button class="button">Button</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!--!------------------------------------------- headder end ------------------------------------------->

    <!--!------------------------------------------- text start -------------------------------------------->
    <div class="text">
      <div class="text__left">
        <img class="w-75 text__right-img box" src="pic/textimg.jpg" alt="" />
      </div>
      <div class="text__right">
        <div class="text__right-title">
          <h1 class="box">Made with Squarespace</h1>
        </div>
        <div class="text__right-dis box">
          <span class="box"
            >Get inspired by a collection of websites made by Squarespace
            users.</span
          >
        </div>
        <div class="text__rig9090888888888888ht-help box">
          <a class="text__right-link box" href="">Browse website examples →</a>
        </div>
      </div>
    </div>
    <!--!------------------------------------------- text end -------------------------------------------->
    <!--!------------------------------------------- about us start -------------------------------------->

    <div class="glitch w-100">
      <div class="glitch__left">
        <div class="content">
          <h2 class="text1" data-text="WHO WE ARE">WHO WE ARE</h2>
        </div>
      </div>

      <div class="glitch__right">
        <span class="position-absolute glitch__right-txt"
          >Amazon is guided by four principles: customer obsession rather than
          competitor focus, passion for invention, commitment to operational
          excellence, and long-term thinking. We strive to be Earth’s most
          customer-centric company, Earth’s best employer, and Earth’s safest
          place to work.</span
        >
      </div>
    </div>
    <!--!------------------------------------------ about us end ----------------------------------------->
    <!--!------------------------------------------ square start ----------------------------------------->
    <div class="square">
      <div class="square__half">
        <div class="flex-column square__half-help">
          <div class="square__half-title">Everything You Need</div>
          <div class="square__half-dis">What Sets Us Apart</div>
          <div class="square__half-line"></div>
        </div>
        <div class="square__half-box">
          <div id="ran" class="square__half-item">
            <div class="square__half-icon">
              <i class="fa-brands fa-web-awesome"></i>
            </div>
            <div class="square__half-icon-dis">Experience</div>
            <div class="square__half-txt">
              With over a decade of experience, we create visually appealing,
              user-friendly, and responsive websites tailored to meet each
              client’s unique needs.
            </div>
          </div>
          <div class="square__half-item">
            <div class="square__half-icon">
              <i class="fa-brands fa-web-awesome"></i>
            </div>
            <div class="square__half-icon-dis">Experience</div>
            <div class="square__half-txt">
              With over a decade of experience, we create visually appealing,
              user-friendly, and responsive websites tailored to meet each
              client’s unique needs.
            </div>
          </div>
          <div id="ran" class="square__half-item">
            <div class="square__half-icon">
              <i class="fa-brands fa-web-awesome"></i>
            </div>
            <div class="square__half-icon-dis">Experience</div>
            <div class="square__half-txt">
              With over a decade of experience, we create visually appealing,
              user-friendly, and responsive websites tailored to meet each
              client’s unique needs.
            </div>
          </div>
          <div class="square__half-item">
            <div class="square__half-icon">
              <i class="fa-brands fa-web-awesome"></i>
            </div>
            <div class="square__half-icon-dis">Experience</div>
            <div class="square__half-txt">
              With over a decade of experience, we create visually appealing,
              user-friendly, and responsive websites tailored to meet each
              client’s unique needs.
            </div>
          </div>
          <div id="ran" class="square__half-item">
            <div class="square__half-icon">
              <i class="fa-brands fa-web-awesome"></i>
            </div>
            <div class="square__half-icon-dis">Experience</div>
            <div class="square__half-txt">
              With over a decade of experience, we create visually appealing,
              user-friendly, and responsive websites tailored to meet each
              client’s unique needs.
            </div>
          </div>
          <div id="square__last" class="square__half-item">
            <div class="square__half-icon">
              <i class="fa-brands fa-web-awesome"></i>
            </div>
            <div class="square__half-icon-dis">Experience</div>
            <div class="square__half-txt">
              With over a decade of experience, we create visually appealing,
              user-friendly, and responsive websites tailored to meet each
              client’s unique needs.
            </div>
          </div>
        </div>
      </div>
    </div>
    <!--!-------------------------------------------- square end ------------------------------------------------------->
    <!--!-------------------------------------------- ai start --------------------------------------------------------->
    <div class="ai">
      <div class="ai__half">
        <div class="ai__half-left">
          <span
            >Chat with our AI assistant to get instant answers to your questions
            and support.</span
          >
        </div>
        <div class="ai__half-right">
          <a class="ai__half-right-box" href="">
            <div class="">start</div>
          </a>
        </div>
      </div>
    </div>
    <!--!------------------------------------------- ai end ------------------------------------------------------------>
   
    <!--!------------------------------------------ footer start ------------------------------------------------------->

    <footer class="footer">
      <div class="footer__left">Copyright © 2025 WebiMax</div>
      <div class="footer__right">
        <img class="footer__right-img" src="pic/random1.png" alt="" />
      </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script src="../main.js"></script>
    <script src="../node_modules/swiper/swiper-bundle.min.js"></script>
  </body>
</html>
