<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <form action="/login" method="POST">
    @csrf
    <input type="text" name="username">
    <input type="password" name="password">
    <button type="submit">LOGIN</button>
    </form>
    <p>Register</p>
    <form action="/register" method="POST">
        @csrf
        <input type="text" name="username">
        <input type="text" name="password">
        <button type="submit">Create</button>
    </form>
</body>
</html>
