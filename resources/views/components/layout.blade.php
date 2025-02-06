<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta property="og:title" content="Legnicki Meetup Technologiczny - Weź udział!" />
  <meta property="og:description" content="Otwarte spotkanie dla programistów, specjalistów IT, przedsiębiorców, badaczy, studentów i wszystkich, którzy chcą poszerzyć swoje horyzonty w dziedzinie programowania, technologii i designu." />
  <meta property="og:image" content={{ asset('images/fb-image.png') }} />
  <meta property="og:url" content="{{ config("app.url") }}" />
  <meta property="”description”" content="Otwarte spotkanie dla programistów, specjalistów IT, przedsiębiorców,badaczy, studentów i wszystkich, którzy chcą poszerzyć swoje horyzonty w dziedzinie programowania, technologii i designu." />

  <title>Legnicki Meetup Technologiczny</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet" />
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
  @vite('resources/css/app.css')
  @vite('resources/js/app.js')
</head>
<body class="overflow-x-hidden bg-slate-950 bg-cover" style="background-image: url({{ asset('/images/background.webp') }})">
 {{ $slot }}
</body>
</html>
