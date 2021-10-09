<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>

</head>
<body>
<script>
    if (localStorage.getItem('a_t') === null)
    {
        localStorage.setItem('a_t', @json($access_token ?? ''));
        window.location.replace('../../utcapi/home')
    }
</script>
</body>
</html>
