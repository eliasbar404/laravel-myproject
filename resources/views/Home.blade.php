<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        {{-- <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet"> --}}
        <link rel="stylesheet" href="../css/bootstrap.css" >


        {{-- <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style> --}}

    <script src="../js/bootstrap.js"></script>
    </head>
    <body class="antialiased">
        <a href={{ route('Add') }}>Add page</a>

        <h1>hello from home page</h1>


<table class="table table-striped table-hover">
    <thead>
    <tr>
        <th scope="col">Id</th>
        <th scope="col">Name</th>
        <th scope="col">Age</th>
    </tr>
    </thead>

<tbody>
@foreach ($data as $d)

    <tr>
        <td>{{ $d->id }}</td>
        <td>{{ $d->name }}</td>
        <td>{{ $d->age }}</td>
        <td><a href={{'/update/'.$d->id}}>update</a></td>
        <td><a href={{'/delete/'.$d->id}}>delete</a></td>
        
    </tr>

@endforeach
</tbody>

</table>












    </body>
</html>
