<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hesap makinesi</title>

    <style>
        :root{
            --bg: #b4b4b4;
            --panel: #f0f0f0;
            --btn: #d4d4d4;
            --btn-hover: #c4c4c4;
            --accent: #3b82f6;
        }
        *{box-sizing: border-box}
        body{font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; background: #fafafa;}
        .dis{
            background-color: var(--bg);
            width: min(92vw, 420px);
            padding: 18px;
            border-radius: 20px;
            margin: 50px auto;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .ekran{
            background-color: var(--panel);
            border-radius: 10px;
            padding: 10px 14px;
            font-size: 1.25rem;
            min-height: 56px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            overflow: auto;
            white-space: nowrap;
        }
        .keys{
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            align-items: stretch;
        }
        .dis button{
            background-color: var(--btn);
            height: 64px;
            border-radius: 10px;
            margin: 0;
            font-size: 1.05rem;
            border: none;
            transition: background-color 120ms, transform 80ms;
        }
        .dis button:hover{background-color: var(--btn-hover); cursor: pointer}
        .dis button:active{transform: translateY(1px)}
        .dis button:focus{outline: 2px solid var(--accent); outline-offset: 2px}
        /* make operator buttons visually distinct */
        .dis button[name="topla"], .dis button[name="cikar"], .dis button[name="carp"], .dis button[name="bol"], .dis button[name="sonuc"]{
            background: linear-gradient(180deg, rgb(201, 201, 201), rgb(128, 128, 128));
        }
        @media (max-width:420px){
            .dis{padding:12px}
            .dis button{height:56px}
            .ekran{font-size:1rem; min-height:48px}
        }
    </style>
</head>
<body>
    <div class="dis">
        <br>
        <div class="ekran">
            <span id="ekran"></span>
        </div>
        <div class="keys">
            <button name="7" value="7" id="7">7</button>
            <button name="8" value="8" id="8">8</button>
            <button name="9" value="9" id="9">9</button>
            <button name="bol" value=" / " id="bol">/</button>

            <button name="4" value="4" id="4">4</button>
            <button name="5" value="5" id="5">5</button>
            <button name="6" value="6" id="6">6</button>
            <button name="carp" value=" x " id="carp">x</button>

            <button name="1" value="1" id="1">1</button>
            <button name="2" value="2" id="2">2</button>
            <button name="3" value="3" id="3">3</button>
            <button name="cikar" value=" - " id="cikar">-</button>

            <button name="0" value="0" id="0">0</button>
            <button name="temizle" value="temizle" id="temizle">C</button>
            <button name="sonuc" value="hesapla" id="sonuc">=</button>
            <button name="topla" value=" + " id="topla">+</button>
        </div>
    </div>

    <script>
        const ekran = document.getElementById("ekran");
        const girdisayi = document.querySelectorAll("button[name='1'], button[name='2'], button[name='3'], button[name='4'], button[name='5'], button[name='6'], button[name='7'], button[name='8'], button[name='9'], button[name='0']");
        const islem = document.querySelectorAll("button[name='topla'], button[name='cikar'], button[name='carp'], button[name='bol']");
        const sonuc = document.getElementById("sonuc");
        const temizle = document.getElementById("temizle");

        let token = [];
        let currentnumber = "";
        let opizin = true; // bir operatörden sonra yine operatöre basılırsa, operatörü yenisiyle değiştirir.

        girdisayi.forEach (button => {
            button.addEventListener("click", () => {
                currentnumber += button.value;
                ekran.textContent = currentnumber;
                opizin = true;
            })
        })

        islem.forEach(button => {
            button.addEventListener("click", () => {
                if (currentnumber === "") return;
                token.push(Number(currentnumber));
                if(opizin)
                {
                    token.push(button.value);
                    opizin = false;
                    currentnumber = "";
                }
                else
                {
                    token[token.length - 1] = button.value;
                }
                ekran.textContent = token.join("");
            })
        })

        temizle.addEventListener("click", () => {
            token = [];
            currentnumber = "";
            ekran.textContent = "";
            opizin = true;
        })

        sonuc.addEventListener("click", () => {
            if (currentnumber === "") return;
            token.push(Number(currentnumber));
            let result = token[0];
            for (let i = 1; i < token.length; i += 2)
            {
                const operator = token[i];
                const sayi = token[i + 1];
                if (operator === " + ")
                {
                    result += sayi;
                }
                else if (operator === " - ")
                {
                    result -= sayi;
                }
                else if (operator === " x ")
                {
                    result *= sayi;
                }
                else if (operator === " / ")
                {
                    if (sayi === 0)
                    {
                        ekran.textContent = "Sence sıfıra bölünür mü salak?";
                        return;
                    }
                    else
                    {
                        result /= sayi;
                    }
                }
            }
            ekran.textContent = result;
            currentnumber = result.toString();
            token = [];
            opizin = true;
        })




        // sonuç olarak yapılanlar:
        // token adlı bir dizi oluşturduk. bu dizide kullanıcının girdiği sayılar ve operatörleri sırasıyla tuttuk. örneğin kullanıcı 2 + 3 x 4 yazarsa, token dizisi [2, " + ", 3, " x ", 4] şeklinde olur.
        // kullanıcı sayı buttonuna bastığında, currentnumber adlı bir değişkenine o sayıyı ekledik ve ekranı güncelledik. böylece kullanıcı 2 yazarsa, currentnumber "2" olur ve ekranda 2 görünür.
        // kullanıcı operatör buttonuna bastığında, önce currentnumber'ı token dizisine SAYIYA ÇEVİREREK ekledik, sonra operatörü ekledik ve currentnumber'ı sıfırladık. böylece kullanıcı 2 + yazarsa token dizisi [2, " + "] olur ve currentnumber boş olur.
        // ayrıca opizin adlı bir değişken ile kullanıcının ekstra operatör girmesini engelledik.
        // kullanıcı temizle tuşu ile her şeyi sıfırlayabilir.
        // kullanıcı sonuç tuşuna bastığında önce currentnumber'ı token dizisine ekledik, sonra token dizisini sırayla işleyerek sonucu hesapladık.
        // sonucu ekrana yazdırdık, currentnumber'ı sonucu string olarak atadık, token dizisini sıfırladık ve opizin'i true olarak yaptık. böylece kullanıcı sonucu gördükten sonra yeni işlem yapabilir.
    </script>
</body>
</html>