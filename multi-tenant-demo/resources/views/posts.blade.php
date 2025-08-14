<!DOCTYPE html>
<html>

<head>
    <title>Tenant Posts</title>
</head>

<body>
    <h1>Posts for Tenant</h1>

    <ul>
        @foreach ($posts as $post)
            <li>
                <strong>{{ $post->title }}</strong><br>
                {{ $post->body }}<br>
                <small>{{ $post->created_at }}</small>
            </li>
        @endforeach
    </ul>
</body>

</html>
