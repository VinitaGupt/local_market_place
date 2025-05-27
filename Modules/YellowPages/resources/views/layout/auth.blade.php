<!DOCTYPE html>
<html lang="hi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>@yield('meta_title', 'Yellow Pages - Find Businesses & Services')</title>

    <meta name="description" content="@yield('meta_description', 'Discover local businesses, services, and more.')">
    <meta name="keywords" content="@yield('meta_keywords', 'yellow pages, local directory, businesses')">

    <!-- Open Graph Meta Tags for SEO & Social Sharing -->
    <meta property="og:locale" content="en_IN">
    <meta name="robots" content="index, follow">
    <meta property="og:type" content="article">
    <meta property="og:image:width" content="600">
    <meta property="og:image:height" content="315">
    <meta property="og:site_name" content="Yellow Pages">

    <meta property="og:title" content="@yield('meta_og_title', 'Yellow Pages - Business Directory')">
    <meta property="og:description" content="@yield('meta_og_description', 'Find the best businesses and services near you.')">
    <meta property="og:image" content="@yield('meta_og_image', asset('assets/images/yp_logo_img.jpg'))">
    <meta property="og:url" content="{{ url()->current() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="{{ asset('assets/main/style-new.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/js/script-new.js') }}"></script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css" />


</head>
<body>
 


    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
