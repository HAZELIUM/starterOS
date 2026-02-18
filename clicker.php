<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clicker</title>
    <style>
        /* Genel sayfa ayarları */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1e1e2f, #2c2c54);
            color: #f1f1f1;
            text-align: center;
            margin: 0;
            padding: 20px;
        }

        /* Skor göstergesi */
        #skor {
            font-size: 2rem;
            font-weight: bold;
            margin: 20px 0;
            color: #ffd700;
        }

        /* Butonların genel stili */
        button {
            background: #4cafef;
            border: none;
            border-radius: 8px;
            padding: 12px 20px;
            margin: 10px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #fff;
        }

        /* Hover efekti */
        button:hover {
            background: #3a8fd8;
            transform: scale(1.05);
        }

        /* Özel buton renkleri */
        #tikla {
            background: #ff5722;
        }
        #tikla:hover {
            background: #e64a19;
        }

        #sil {
            background: #d32f2f;
        }
        #sil:hover {
            background: #b71c1c;
        }

        /* Fiyat ve açıklama yazıları */
        span {
            display: block;
            margin: 5px 0 15px;
            font-size: 0.9rem;
            color: #ccc;
        }

        /* Bonus açıklaması */
        p {
            margin-top: 20px;
            font-size: 1rem;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <button id="tikla">Tıkla</button>
    <p id="skor">0</p>
    <br>
    <button id="gelis">Geliştir</button>
    <span id="gelisfiyat"></span>
    <br>
    <button id="otoart">Otomatik Arttırma</button>
    <span id="otofiyat"></span>
    <br>
    <button id="bonus">Bonus arttırma</button>
    <span id="bonusfiyat"></span>
    <p> her <span id="clickbonus">50</span> tıklamada ekstra puan kazanırsın.
    <br>
    <br>
    <button id="bonusguc">bonus gücü arttırma</button>
    <span id="bonusgucfiyat"></span>
    <br>
    <br>
    <button id="sil">Sıfırla</button>

    <script>
        if (typeof Storage === "undefined")
        {
            console.error("LocalStorage desteği bulunamadı.");
        }

        const tiklabtn = document.getElementById("tikla");
        const skorspan = document.getElementById("skor");
        const gelisbtn = document.getElementById("gelis");
        const gelisfiyatspan = document.getElementById("gelisfiyat");
        const otoartbtn = document.getElementById("otoart");
        const otofiyatspan = document.getElementById("otofiyat");
        const silbtn = document.getElementById("sil");
        const clickbonusspan = document.getElementById("clickbonus");
        const bonusbtn = document.getElementById("bonus");
        const bonusfiyatspan = document.getElementById("bonusfiyat");
        const bonusgucbtn = document.getElementById("bonusguc");
        const bonusgucfiyatspan = document.getElementById("bonusgucfiyat");

        let skor = localStorage.getItem("skor") ? Number(localStorage.getItem("skor")) : 0;
        let guc = localStorage.getItem("guc") ? Number(localStorage.getItem("guc")) : 1;
        let otoart = localStorage.getItem("otoart") ? Number(localStorage.getItem("otoart")) : 0;
        let gelisfiyat = localStorage.getItem("gelisfiyat") ? Number(localStorage.getItem("gelisfiyat")) : 10;
        let otofiyat = localStorage.getItem("otofiyat") ? Number(localStorage.getItem("otofiyat")) : 50;
        let gucartlog = localStorage.getItem("gucartlog") ? Number(localStorage.getItem("gucartlog")) : 1;
        let otoartlog = localStorage.getItem("otoartlog") ? Number(localStorage.getItem("otoartlog")) : 1;
        let otoartinterval = null;
        let clickpoint = 0; // tıklama sayısını takip eder.
        let clickbonus = localStorage.getItem("clickbonus") ? Number(localStorage.getItem("clickbonus")) : null; // bonus tıklama sayısı. bu sayıya ulaşılınca bonus verilir.
        let bonusfiyat = localStorage.getItem("bonusfiyat") ? Number(localStorage.getItem("bonusfiyat")) : 25; //bonusun fiyatı
        let bonusguc = localStorage.getItem("bonusguc") ? Number(localStorage.getItem("bonusguc")) : 50; // bonus gücü, tıklama bonusu aldığında tıklama gücüe eklenir.
        let bonusgucfiyat = localStorage.getItem("bonusgucfiyat") ? Number(localStorage.getItem("bonusgucfiyat")) : null; // bonus gücün fiyatı

        function guncelle()
        {
            skorspan.textContent = skor;
            gelisfiyatspan.innerText = "FİYAT: " + gelisfiyat + " güç: " + guc;
            otofiyatspan.innerText = "FİYAT: " + otofiyat + " artış: " + otoart + " / sn";
            clickbonusspan.innerText = clickbonus;
            bonusfiyatspan.innerText = "FİYAT: " + bonusfiyat + " tıklama bonusu için gerekli tıklamayı 1 azaltır.";
            bonusgucfiyatspan.innerText = "FİYAT: " + bonusgucfiyat + " güç x " + bonusguc + " kadar artış sağlar her bonus tıklamada.";
            kaydet();
        }

        function kaydet()
        {
            localStorage.setItem("skor", skor);
            localStorage.setItem("guc", guc);
            localStorage.setItem("otoart", otoart);
            localStorage.setItem("gelisfiyat", gelisfiyat);
            localStorage.setItem("otofiyat", otofiyat);
            localStorage.setItem("gucartlog", gucartlog);
            localStorage.setItem("bonusguc", bonusguc);
            localStorage.setItem("bonusgucfiyat", bonusgucfiyat);
            localStorage.setItem("otoartlog", otoartlog);
            localStorage.setItem("clickbonus", clickbonus);
            localStorage.setItem("bonusfiyat", bonusfiyat);
            localStorage.setItem("bonusgucfiyat", bonusgucfiyat);
            localStorage.setItem("bonusguc", bonusguc);
        }

        tiklabtn.onclick = () =>
        {
            clickpoint++;
            if (clickpoint >= clickbonus && clickbonus !== null)
            {
                clickpoint = 0;
                skor += guc * bonusguc;
                guncelle();
            }
            else
            {
                skor += guc;
                guncelle();
            }
        }

        gelisbtn.onclick = () =>
        {
            if (skor >= gelisfiyat)
            {
                skor -= gelisfiyat;
                guc += gucartlog;
                gelisfiyat = Math.round(gelisfiyat * 1.5);
                gucartlog += 1;
                guncelle();
            }
        }

        otoartbtn.onclick = () => {
            if (skor >= otofiyat) {
                skor -= otofiyat;
                otoart += otoartlog;
                otofiyat = Math.round(otofiyat * 1.5);
                otoartlog += 1;
                guncelle();

                if (!otoartinterval) {
                    otoartinterval = setInterval(() => {
                        skor += otoart;
                        guncelle();
                    }, 1000);
                }
            }
        };

        bonusbtn.onclick = () =>
        {
            if (skor >= bonusfiyat)
            {
                skor -= bonusfiyat;
                if (clickbonus === null)
                {
                    clickbonus = 50;
                    bonusgucfiyat = 100;
                }
                else if(clickbonus > 1)
                {
                    clickbonus --;
                    bonusfiyat = Math.round(bonusfiyat * 2);
                }
                else if (clickbonus === 1) // 1 olursa bonus tuşunu kapatır
                {
                    bonusfiyat = null;
                }
                guncelle();
            }
        }

        bonusgucbtn.onclick = () =>
        {
            if (skor >= bonusgucfiyat && bonusguc !== null)
            {
                skor -= bonusgucfiyat;
                bonusguc += 50;
                bonusgucfiyat = Math.round(bonusgucfiyat * 2);
                guncelle();
            }
        }

        silbtn.onclick = () =>
        {
            if (confirm("Tüm ilerleme sıfılanacak, emin misin?"))
            {
                skor = 0;
                guc = 1;
                otoart = 0;
                gelisfiyat = 10;
                otofiyat = 50;
                gucartlog = 1;
                otoartlog = 1;
                bonusfiyat = 50;
                clickbonus = null;
                bonusguc = 50;
                bonusgucfiyat = null;
                if (otoartinterval)
                {
                    clearInterval(otoartinterval);
                    otoartinterval = null;
                }
                guncelle();
            }
        }

        if (otoart > 0 && !otoartinterval)
        {
            otoartinterval = setInterval(() =>
            {
                skor +=otoart;
                guncelle();
            }, 1000);
        }
        guncelle();

    </script>

</body>
</html>