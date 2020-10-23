<html>
<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" >
</head>
<title>Import Characters</title>
<body>
    <div class="container-southern">
        @if($output['success'])
            <h1>Importing Characters into DB status: Success</h1>
            <p>{{$output['messages'][0]}}</p>
        @else
            <h1>Importing Characters into DB status: Failure</h1>
            <ul class="container-text-southern">
                @foreach ($output['messages'] as $message)
                    <li>{{$message}}</li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>
