   <?php
    session_start();
    ?>
   <!DOCTYPE html>
   <html lang="en">

   <head>
       <meta charset="UTF-8">
       <meta name="viewport" content="width=device-width, initial-scale=1.0">
       <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
       <link rel="stylesheet" href="includes/styles/auth.css">
       <link rel="stylesheet" href="includes/styles/main.css">
       <title>Signup - ULAVi Community</title>
   </head>

   <body>


       <div class="auth-container">
           <div class="auth-banner">
               <h1>
                   ULAVi Community <br />
                   <span>Welcome back to our creative space 👋🏾</span>
               </h1>
               <!-- <p>
                   Login to access your account and participate in our artistic community.
               </p> -->
               <ul>
                   <li>Connect with fellow artists, share project updates, and stay involved with community initiatives</li>
               </ul>
           </div>
           <div class="auth-form">
               <form action="includes/backend/auth.php" method="post">
                   <h2>Sign in</h2>
                   <label for="email">Enter email</label>
                   <input
                       type="email"
                       name="email"
                       id="email"
                       required />
                   <label for="password">Enter password</label>

                   <input
                       type="password"
                       name="password"
                       id="password"
                       required />

                   <span class="switch-form">
                       Don't have an account?
                       <a class="switch-form-btn" href="signup.php">
                           Sign up
                       </a>
                   </span>
                   <button type="submit" name="signin">Sign in</button>
                   <?php if (isset($_SESSION['signin_error'])): ?>
                       <p class="error-message"><?php echo $_SESSION['signin_error']; ?></p>
                       <?php unset($_SESSION['signin_error']);
                        ?>
                   <?php endif; ?>
                   <div class="error"></div>
                   <div class="password-manager">

                       <a href="/">Forgot password?</a>
                   </div>
               </form>
           </div>
       </div>
   </body>

   </html>