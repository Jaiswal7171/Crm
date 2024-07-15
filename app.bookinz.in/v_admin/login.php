<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: "Times New Roman", serif;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-color: #f5f5f5;
            color: #333;
            overflow: hidden; 
        }

        .video-background {
            position: fixed;
            width: 100%;
            min-height: 300px;
            object-fit: cover;
        }

        
        .container {
            position: relative;
            z-index: 1; 
            width: 100%;
            max-width: 400px;
            padding-top: 130px;
        }

        

        h2 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            padding-top: 30px;
        }

        input {
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            transition: border-color 0.3s ease-in-out;
            outline: none;
            color: white;
            background-color: rgba(0,0,0,0); 
        }

        input:focus {
            border-color: #555;
        }

        button {
            background-color: #555;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 2px;
            width: 80px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
            align-self: center; 
        }

        button:hover {
            background-color: #333;
        }

        /* Media query for smaller screens */
        @media only screen and (max-width: 600px) {
            .container {
                padding-top: 130px;
            }
}

    </style>
</head>
<body>
    <!-- Video background -->
    <video autoplay loop muted class="video-background">
        <source src="./assets/kkr.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <div class="container">
        <div class="card">
            <!-- <h2>Login</h2> -->
            <form action="config.php" method="POST">
                <input type="email" id="username" name="email" placeholder="Username" required>
                <input type="password" id="password"  name="password" placeholder="Password" required>
                <a href="forgot.php" style="color:white;">Forgot Password</a>
                <button type="submit" class="pre pre-primary" name="login_admin">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
