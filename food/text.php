<!DOCTYPE HTML>
<html>
<body>

<p id="demo" style="display:none;">ddfdsfsfsfs</p>
<button onclick="clockStart()">Start Timer</button>

<script>
// Set the date we're counting down to

function clockStart() {
    document.getElementById("demo").style.display = "block";
    setInterval(function() {
        date = new Date();
        let hour = date.getHours();
        let minutes = date.getMinutes();
        let seconds = date.getSeconds();
        document.getElementById("demo").style.display = "none";
    }, 5000);

    }
</script>

</body>
</html>