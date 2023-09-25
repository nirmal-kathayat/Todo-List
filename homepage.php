<!DOCTYPE html>
<html lang="en">

<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>TODO home page</title>
      <link rel="stylesheet" href="./css/home.css">

      <style>
            .navbar-home {
                  background-color: #2711b5;
                  border-radius: 4px;
                  display: flex;
                  align-items: center;
                  justify-content: center;
                  height: 6.2rem;
            }

            .navbar-home .apps-todo {
                  font-size: 8vh;
                  margin-left: 4rem;
            }

            .navbar-home ul {
                  overflow: auto;
                  padding: 3px 3px;
            }

            .navbar-home li {
                  float: left;
                  list-style: none;
                  margin: 35px 30px;
                  font-size: 1.5rem;
                  text-decoration: none;
            }

            .navbar-home a {
                  text-decoration: none;
                  color: #fff;
            }

            .apps-todo {
                  width: 30%;
                  margin: 1rem auto;
                  padding: 42px;
            }

            .nav-container {
                  position: fixed;
                  top: 0;
                  left: 0;
                  right: 0;
                  z-index: 1;
            }
      </style>



</head>

<body>
      <div class="nav-container">
            <div class="navbar-home">
                  <h1 class="apps-todo">TODO LIST</h1>
                  <nav>
                        <ul>
                              <li><a href="./homePage.php">Home</a></li>
                              <li><a href="./AboutPage.html">About</a></li>
                              <li><a href="#">Contact</a></li>
                              <li><a href="./login.php" data-bs-toggle="modal" data-bs-target="#exampleModal">Login</a>
                              </li>
                        </ul>
                  </nav>
            </div>
      </div>
      <div class="container-main">
            <span id="currentDate"></span>

            <div class="banner-video">
                  <video autoplay muted loop infinite style="height:30%; width:100%; object-fit:cover; opacity:0.3;">
                        <source src="./assets/banner-vid.mp4">
                  </video>
                  <div class="banner-body">
                        <div class="banner-title">
                              <h1>Let's Start</h1>

                        </div>
                        <div class="content">
                              <p class="banner-content">
                                    "Streamline your tasks and boost productivity with our
                                    todo
                                    website."
                              </p>
                        </div>
                  </div>
            </div>
      </div>
      <div class="container contact-form">
            <div class="row">
                  <h1>contact us</h1>
            </div>
            <div class="row">
                  <h4 style="text-align:center">We'd love to hear from you!</h4>
            </div>
            <div class="row input-container">
                  <div class="col-xs-12">
                        <div class="styled-input wide">
                              <input type="text" required />
                              <label>Name</label>
                        </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                        <div class="styled-input">
                              <input type="text" required />
                              <label>Email</label>
                        </div>
                  </div>
                  <div class="col-md-6 col-sm-12">
                        <div class="styled-input" style="float:right;">
                              <input type="text" required />
                              <label>Phone Number</label>
                        </div>
                  </div>
                  <div class="col-xs-12">
                        <div class="styled-input wide">
                              <textarea required></textarea>
                              <label>Message</label>
                        </div>
                  </div>
                  <div class="col-xs-12">
                        <div class="btn-lrg submit-btn">Send Message</div>
                  </div>
            </div>
      </div>

      <footer class="footer-main">
            <div class="copyright">
                  <p class="copyright-text">Copyright &copy; 2023 TODO. All rights reserved</p>
            </div>
      </footer>

</body>


</html>