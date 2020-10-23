<html>
    <title>ROTJ</title>
    <body>
        <h1>List of Characters in Return of the Jedi</h1>
        @if (count($characters) > 0)
            <ul>
                @foreach ($characters as $name)
                    <li>{{$name}}</li>
                @endforeach
            </ul>
        @else
            <p>No characters for Return of The Jedi</p>
        @endif
    </body>
</html>
