<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style1.css" rel="Stylesheet" type="text/css" /> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
       <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <title>RBI Manila</title>
    <style>
        h3 {
            text-align: center;
            font-size: 25px;
            color: #333;
            text-transform: uppercase;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            letter-spacing: 1px;
            font-weight: 900;
        }

        button {
            border: none; 
            margin-top: 1px;  
            width: 100%;
            height: 50px; 
            background-color:  #2E8B57 ; 
            color: white; 
            font-size: 20px;
            border-radius: 8px;
            cursor: pointer;
            transition-duration: 0.4s;
        }

        button:hover {
            background-color: #055a05 ;
        }
    </style>
</head>
<body class="body1">
    
   <div class="box">
    <div class="logo">
   <img src="images/logo.png" class="img-fluid" draggable="false" style="width: 320px; padding-bottom: 15px;">
</div>
    <!--<div class ="header-image">
</div>-->
    <h3>Gender-Sensitive Registry of Barangay Inhabitants</h3>
    <hr class="mb-4">
    <form action="process_login.php" method="post">
  
    <label class="input-label">
    <span class="login__icon fas fa-user"></span>
    <input type="text" name="username" placeholder="Username" required>
</label>
<br>

<label class="input-label">
    <span class="login__icon fas fa-key"></span>
    <input type="password" name="password" id="password" placeholder="Password" required>
    <span class="password-toggle-icon"><i class="fas fa-eye-slash"></i></span>
</label>

<script>
const passwordField = document.getElementById("password");
const togglePassword = document.querySelector(".password-toggle-icon i");

togglePassword.addEventListener("click", function () {
    if (passwordField.type === "password") {
        passwordField.type = "text";
        togglePassword.classList.remove("fa-eye-slash");
        togglePassword.classList.add("fa-eye");
    } else {
        passwordField.type = "password";
        togglePassword.classList.remove("fa-eye");
        togglePassword.classList.add("fa-eye-slash");
    }
});
 </script>

<div class="forgot-password">
    <a href="forgot-pass.php"  draggable="false">Forgot Password?</a>
</div><br>
            <button type="submit">Login</button>
            <?php if(isset($error)): ?>
                <div class="alert alert-danger mt-2" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
    </form>

</div>
</body>
</html> 

