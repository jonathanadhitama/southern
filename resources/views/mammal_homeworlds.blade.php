<html>
<title>Mammals</title>
<body>
<h1>List of Mammals Species And Their Homeworld in Starwars</h1>
@if (count($species) > 0)
    <ul>
        @foreach ($species as $entry)
            <li>Species name: {{$entry['name']}}; Homeworld: {{$entry['homeworld']}}</li>
        @endforeach
    </ul>
@else
    <p>No mammal species found</p>
@endif
</body>
</html>
