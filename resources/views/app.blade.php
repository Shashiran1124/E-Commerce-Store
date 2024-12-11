<!-- resources/views/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--If the title is missing in web.php 'Pick & Pay' will trigger-->
    <title>{{ isset($page['props']['pageTitle']) ? $page['props']['pageTitle'] : 'Pick & Pay' }}</title>
    @vite('resources/js/app.js') <!-- Include the compiled JavaScript -->
</head>
<body>
    @inertia <!-- This renders the Inertia.js app -->
</body>
</html>
