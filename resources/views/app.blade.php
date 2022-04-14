<!DOCTYPE html>
<html>
  <head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-0PN9EQTZZP"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());
      gtag('config', 'G-0PN9EQTZZP');
      </script>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    @include('meta')
    <link rel="shortcut icon" href="{{url('favicon.ico')}}">
    <link href="{{ mix('/css/app.css') }}?v=1.02" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}?v=1.02" defer></script>
  </head>
    @inertia
  </body>
</html>