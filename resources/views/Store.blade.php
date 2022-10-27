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
        

        <form action="/api/products" method="post" enctype="multipart/form-data">
            @csrf
            <input type="text" placeholder="name"        name="name">
            <br>
            <input type="text" placeholder="description" name="description">
            <br>
            <input type="text" placeholder="price"        name="price">
            <br>
            <input type="text" placeholder="discount" name="discount">
            <br>
            <input type="text" placeholder="shopping_store_id" name="shopping_store_id">
            <br>
            <input type="text" placeholder="category_id" name="category_id">
            <br>

            <input type="file" name="image1" placeholder="image">
            <br>
            <input type="file" name="image2" placeholder="image">
            <br>
            <input type="file" name="image3" placeholder="image">
            <br>
            <input type="file" name="image4" placeholder="image">
            <br>
            <input type="file" name="image5" placeholder="image">
            <br>

            <button type="submit">ADD</button>
        </form>

    </body>
</html>