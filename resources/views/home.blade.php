<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    @auth
    <p>Congrats you are logged in </p>
    <form action="/logout" method="POST">
    @csrf
    <button> Logout </button>
    </form>
    @else
                                <!--<div style="border: 3px solid black;">
                                    <h2>Register</h2>
                                    <form action="/register" method="POST">
                                        @csrf
                                        <input type="text" placeholder="name" name="name">
                                        <input type="text" placeholder="email" name="email">
                                        <input type="password" placeholder="password" name="password">
                                        <button> Register </button>
                                    </form>
                                </div>-->
    <div class="login-container">
        <div class="left-side">
            <div class="overlay"></div>
        </div>
        <div class="right-side">
            <h2>Welcome to <br><strong>Moldex Residences</strong></h2>
            <p>Enter your credentials to access your account</p>

            <form action="/login" method="POST">   
                @if ($errors->any())
                    <div class="error-message">
                        {{ $errors->first() }}
                    </div>
                @endif
                @csrf
                <label for="Username">Username</label>
                <input type="text" placeholder="Enter your username" name="Username">
                <div class="password-label">
                    <label for="password">Password</label>
                    <a href="#" class="forgot-password">Forgot password?</a>
                </div>
                
                <input type="password" placeholder="Enter your password" name="Password">
                <button> Login </button>
            </form>

            <a href="/adminlogin" class="admin-login">Admin Login</a>
            
        </div>
    </div> 
    @endauth 
</body>
</html>