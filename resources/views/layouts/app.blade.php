<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Battleships</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@1.0.4/css/bulma.min.css">

    <link href="/css/site.css?v13" rel="stylesheet">
    <!-- Javascript -->
    <script type="text/javascript" src="/js/battleships.js?v5"></script>
</head>
<body>

@include('partials.nav')
@include('partials.header')

@yield('content')

<div class="bs-footer-spacer">&nbsp;</div>
<div class="bs-footer">
    <div class="bs-copyright">&copy; {{ (new DateTime)->format('Y') }} Brian Etheridge</div>
</div>

@yield('page-scripts')
@yield('global-scripts')

<script type="text/javascript">
    // Delete the cookie for testing purposes
//    document.cookie = "cookieWarningAccepted=; Max-Age=0; path=/;";
//    document.cookie = "cookieLoadAll=; Max-Age=0; path=/;";
//    document.cookie = "user_token=; Max-Age=0; path=/;";

    // Function to set a cookie
    function setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + d.toUTCString();
        document.cookie = name + "=" + value + ";" + expires + ";path=/";
    }

    // Function to check if a cookie exists
    function checkCookie(name) {
        const nameEQ = name + "=";
        const ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') c = c.substring(1, c.length); // Trim whitespace
            if (c.indexOf(nameEQ) == 0) return true; // Cookie found
        }
        return false; // Cookie not found
    }

    function getCookie(name) {
        let nameEQ = name + "=";
        let ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            let c = ca[i];
            //console.log(c);
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

</script>
</body>
</html>