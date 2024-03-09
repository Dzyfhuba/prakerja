<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    @routes
    <script>
        Ziggy.url = '{{ env('APP_URL') }}'
    </script>
    @viteReactRefresh
    @vite(['resources/js/react.tsx', "resources/js/Pages/{$page['component']}.tsx"])
    @inertiaHead
  </head>
  <body>
    @inertia
  </body>
</html>
