<div class="p-1 text-gray-400">
    <div id="clock"></div>

    <script>
        function setClock() {
            var d = new Date();
            ap = 'am';
            h = d.getHours();
            m = d.getMinutes();
            if (h > 11) {
                ap = 'pm';
            }
            if (h > 12) {
                h = h - 12;
            }
            if (h == 0) {
                h = 12;
            }
            if (m < 10) {
                m = '0' + m;
            }
            document.getElementById('clock').innerHTML = h + ':' + m + ' ' + ap;
            t = setTimeout('setClock()', 500);
        }
        setClock();
    </script>
</div>
