<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Product Catalog v1.0/registration</title>
</head>

<body>
<h1>Register Page</h1>

<form method="post" action="/register">
    <label for="name" > Name </label>
        <input type="text" name="name" required>

    <br><br>
    <label> e-mail </label>
        <input type="text" name="email" required>

    <br><br>
    <label>  Password </label>
        <input type="password" name="password" required>

    <br><br>
    <label>  Repeat password  </label>
        <input type="password" name="repeat_password" required>

<button type="submit">Register</button>
</form>


</body>
</html>