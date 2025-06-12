<!DOCTYPE html>
<html>
<head>
    <title>Instructions PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        h1 { font-weight: bold; }
        p { margin-bottom: 1rem; }
    </style>
</head>
<body>
    <h1>{{ $scholarship->title }}</h1>
    <hr>
    <h3>Instructions</h3>
    <div>{!! $scholarship->instructions !!}</div>
</body>
</html>
