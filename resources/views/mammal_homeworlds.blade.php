<html>
<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" >
</head>
<title>Mammals</title>
<body>
    <div class="container-southern">
        <h1>List of Mammals Species And Their Homeworld in Starwars</h1>
        @if (count($species) > 0)
            <ul class="container-text-southern">
                @foreach ($species as $entry)
                    <li>Species name: {{$entry['name']}}; Homeworld: {{$entry['homeworld']}}</li>
                @endforeach
            </ul>
        @else
            <p>No mammal species found</p>
        @endif
    </div>
</body>
</html>
