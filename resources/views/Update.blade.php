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

        <form action="/update" method="post">
            @csrf
            @foreach ($data as $d)
            <input type="hidden" name="id"         value={{$d->id}}>
            <input type="text"   name="user_name"  value={{$d->name}} placeholder="Name">
            <input type="text"   name="user_age"   value={{$d->age}} placeholder="Age">
            <button type="submit">Update</button>
            @endforeach

        </form>

    </body>
</html>