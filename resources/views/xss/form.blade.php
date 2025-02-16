<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Proteksi XSS</title>
</head>
<body>
    <h2>Form Input dengan Proteksi XSS</h2>
    <form action="{{ route('submit.comment') }}" method="POST">
        @csrf
        <label for="comment">Komentar:</label><br>
        <textarea name="comment" id="comment" rows="5"></textarea><br>
        <button type="submit">Kirim</button>
    </form>
</body>
</html>
