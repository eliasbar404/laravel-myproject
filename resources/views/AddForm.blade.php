<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">


        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <a href={{ route('Home') }}>Home page</a>

        <form action="/add" method="post">
            @csrf

            <input type="text" name="user_name" placeholder="Name">
            <input type="text" name="user_age" placeholder="Age">
            <button type="submit">ADD</button>

        </form>

    </body>
</html>