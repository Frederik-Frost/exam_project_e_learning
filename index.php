<?php
    // require_once(__DIR__."globals.php");
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
</head>
<body>
    <h1>Signup</h1>
    <form onsubmit="signup(); return false">
        <input type="text" name="firstName" placeholder="first name">
        <input type="text" name="lastName" placeholder="last name">
        <input type="email" name="email" placeholder="email">
        <input type="password" name="password" placeholder="password"  autocomplete="true">
        <label for="isAdmin">Admin</label>
        <input type="checkbox" id="isAdmin" name="isAdmin" value="1">
        <button type="submit">Sign up</button>
    </form>

    <h1>Login</h1>
    <form onsubmit="login(); return false">
        <input type="email" name="email" placeholder="email">
        <input type="password" name="password" placeholder="password" autocomplete="true">
        <button type="submit">Login</button>
    </form>

    <script>
        async function signup(){
            const signupData = event.target
        let conn = await fetch('api/signup.php', {
                'method': 'POST',
                'Content-Type': 'application/json',
                'body' : new FormData(signupData)
            })
            let res = await conn.json()
            console.log(conn)
            console.log(res)
        }
        async function login(){
            const loginData = event.target
        let conn = await fetch('api/login-user.php', {
                'method': 'POST',
                'Content-Type': 'application/json',
                'body' : new FormData(loginData)
            })
            let res = await conn.json()
            console.log(conn)
            console.log(res)
            if(conn.ok){
                location.href = "topics.php"
            }
        }
    </script>
</body>
</html>