<html>
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" >
    </head>
    <title>ROTJ</title>
    <body>
        <div class="container-southern">
            <h1>List of Characters in Return of the Jedi</h1>
            @if (count($characters) > 0)
                <ul class="container-text-southern">
                    @foreach ($characters as $name)
                        <li>{{$name}}</li>
                    @endforeach
                </ul>
            @else
                <p class="container-text-southern container-error-southern">No characters for Return of The Jedi</p>
            @endif
        </div>
    </body>
</html>
