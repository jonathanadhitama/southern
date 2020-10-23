<html>
<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}" >
</head>
<title>Update Characters</title>
<body>
    <div class="container-southern">
        @if($output['success'])
            <h1>Updating Characters into DB status: Success</h1>
            <p>{{$output['messages'][0]}}</p>
        @else
            <h1>Updating Characters into DB status: Failure</h1>
            <ul class="container-text-southern">
                @foreach ($output['messages'] as $message)
                    <li class="container-error-southern">{{$message}}</li>
                @endforeach
            </ul>
        @endif
    </div>
</body>
</html>
