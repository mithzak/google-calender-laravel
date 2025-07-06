<!DOCTYPE html>
<html>
<head>
    <title>Today's Meetings</title>
</head>
<body>
    <h1>Today's Meetings</h1>
    @if(count($meetings) > 0)
        <ul>
            @foreach($meetings as $meeting)
                <li>{{ $meeting }}</li>
            @endforeach
        </ul>
    @else
        <p>You have no meetings today.</p>
    @endif
</body>
</html> 