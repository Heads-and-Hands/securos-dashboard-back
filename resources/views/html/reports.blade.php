<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <link rel="icon" href="favicon.ico">
    <title>securos-dashboard</title>
    <link href="css/app.6c371a2e.css" rel="preload" as="style"><link href="js/app.446c54b8.js" rel="preload" as="script"><link href="js/chunk-vendors.f99d67b3.js" rel="preload" as="script"><link href="css/app.6c371a2e.css" rel="stylesheet"></head>
<body>
<noscript>
    <strong>We're sorry but securos-dashboard doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
</noscript>
<div id="app"></div>
<script type="text/javascript">
    /**
     * сюда указать параметры формирования отчета
     */
    window.reportSettings = {!! json_encode($reportSettings) !!}
    /**
     * сюда указать объект
     */
    window.dataToShow = {!! json_encode($dataToShow) !!}
    /**
     * сюда указать язык - ru или en
     */
    window.lang = '{{ $lang }}'
</script>
<!-- built files will be auto injected -->
<script type="text/javascript" src="js/chunk-vendors.f99d67b3.js"></script><script type="text/javascript" src="js/app.446c54b8.js"></script></body>
</html>
