<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div class="register" style="border: 3px solid black;">
        <h1>REGISTER</h1>
        <form action="/register" method="POST">
            @csrf
            <input name="name" type="text" placeholder="name">
            <input name="email" type="text" placeholder="email">
            <input name="password"type="password" placeholder="password">
            <label>
                <input type="checkbox" name="is_admin" value="1">
                Register as Admin
            </label>
            <button>Register</button>
        </form>
    </div>
</body>
</html>