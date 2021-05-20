<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Header Surat Tugas</title>
<style>
.showLast {
    display: none;
}

.pLast .showLast {
    display: block;
}
</style> 
{{-- <script>
    function setPageClass() {
        var vars = {};
        var x = document.location.search.substring(1).split('&');
        for (var i in x) {
            var z = x[i].split('=', 2);
            vars[z[0]] = unescape(z[1]);
        }

        var y = document.getElementsByClassName('PageClass');
        for (var j = 0; j < y.length; ++j) {
            y[j].setAttribute('class', 'PageClass ' + 'p' + vars['page'] + (vars['page'] == 1 ? ' pFirst ' : '') + (vars['page'] == vars['topage'] ? ' pLast ' : ''));
        }
    };
</script> --}}
<script>
    $(window).on('load', function(){ 
    $('body').html('THIS IS A MESSAGE');
    //do other things here
}
</script>
</head>
// <body onload="setPageClass()">
<body>
    <div class="PageClass">
        footer
        <div class="showLast">
          Last Page Footer
        </div>
      </div>
      
</body>

</html>