<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Posts</title>
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        halo :D
        @foreach ($posts as $post)
            <div class="card mb-3 shadow">
                <img
                    class="card-img-top"
                    src="{{ Str::startsWith($post['gambar'], 'http') ? $post['gambar'] : asset('images/' . $post['gambar']) }}"
                    alt="{{ $post['judul'] }}"
                />
                <div class="card-body">
                    <h4 class="card-title">{{ $post['judul'] }}</h4>
                    <p class="card-text text-secondary">{{ $post->category->name }}</p>
                    <p class="card-text text-secondary">{{ $post->author->name }}</p>
                    <div class="card-text">{!! $post['content'] !!}</div>
                    <a href="#" class="card-link">Card link</a>
                    <a href="#" class="card-link">Another link</a>
                </div>
            </div>

        @endforeach
    </div>
    <script src="/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
