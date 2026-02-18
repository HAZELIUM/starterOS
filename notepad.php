<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notepad</title>
</head>
<body>
    <form id="note" onsubmit="return false;">
        <textarea id="notepad" rows="20" cols="50"></textarea>
        <br>
        <button onclick="kaydet();">Kaydet</button>
        <br>
        <button onclick="sil();">Sil</button>
    </form>

    <script>
        if (typeof Storage === "undefined")
        {
            console.error("LocalStorage desteği bulunamadı.");
        }

        function kaydet()
        {
            const notepad = document.getElementById("notepad");
            const text = notepad.value;
            localStorage.setItem("notepad", text);
            alert("notunuz kaydedildi!");
        }

        function sil()
        {
            if (confirm("Notunuzu sileceğim. emin misiniz?"))
            {
                localStorage.removeItem("notepad");
                document.getElementById("notepad").value = "";
                alert("sildim...");
            }
    }

        window.onload = () =>
        {
            const kaydedilennot = localStorage.getItem("notepad");
            if (kaydedilennot)
            {
                document.getElementById("notepad").value = kaydedilennot;
            }
        }
    </script>
</body>
</html>