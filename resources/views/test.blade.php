<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenid@</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;500;700&display=swap');

        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            color: #42484e;
            font-family: 'Open Sans', sans-serif;
            font-style: normal;
        }

        .card {
            width: 600px;
            box-shadow: 0px 0px 3px rgba(52, 52, 52, 0.15);
            border-radius: 10px;
            background: #ffffff;
            padding-bottom: 32px;
        }


        .liner_gradient {
            padding-left: 0 !important;
            height: 12px;
            /* background: linear-gradient(296.48deg, #ac24f1 46.11%, #ff585d 97.89%); */
            background-color: #00a787;
            border-radius: 10px 10px 0px 0px;
        }


        .svg {
            text-align: center;

            margin-top: 28px;
        }

        .text_initial {
            font-style: normal;
            margin-top: 26.48px;
            font-weight: 700;
            font-size: 24px;
            line-height: 24px;
            text-align: center;
            color: #4a4f54;
        }

        .subtitle {
            font-style: normal;
            margin-top: 8px;
            font-weight: 400;
            font-size: 14px;
            line-height: 16px;
            text-align: center;
            color: #4a4f54;
        }

        .text {
            font-style: normal;
            margin-top: 40px;
            width: 518px;
            height: 54px;
            font-weight: 400;
            font-size: 16px;
            line-height: 20px;
            color: #4a4f54;
        }

        button {
            cursor: pointer;
            margin-top: 58px;
            width: 514px;
            height: 56px;
            background: #007aff;
            border-radius: 10px;
            border: 0px;
        }

        .text_button {
            font-style: normal;
            font-weight: 500;
            font-size: 16px;
            line-height: 20px;
            color: #ffffff;
        }

        .separator {
            margin-top: 40px;
            margin-bottom: 32px;
            border: 1px solid #dcdcdc;
            width: 514px;
        }

        .footer_card {
            padding-left: 43px;
            width: 514px;
        }
    </style>
</head>

<body style="background-color:#f6f6f7; width: 100%; padding: 3rem 0;">
    <div style="width: 100%; margin-bottom: 2rem;">
        <div style="width: 100%; display: flex; flex-direction: column;">
            <img style="width: 140px;display: flex; margin: 0 auto;" src="https://www.cifrado.com.co/wp-content/uploads/2020/09/cropped-CIFRADO-LOGO-FULL-240x61.png" alt="Logo cifrado">
        </div>
    </div>
    <div style="width: 100%; display: flex; flex-direction: column;">
        <div style="display: flex; margin: 0 auto;">
            <div class="card">
                <div class="liner_gradient"></div>
                <div style="padding-left: 43px;">
                    <div style="flex-direction:column;">
                        <div class="svg">
                            <img src="https://app.aveonline.co/assets/img/mano-onboarding.png" alt="">
                        </div>
                        <h1 class="text_initial">Bienvenido a Cifrado, {{ $user }}</h1>
                        <p class=" subtitle">Estamos felices de que por fin funcione los correos.</p>
                        <p class="text">
                            Este es un email de test
                        </p>
                        <a>
                            <button><span class="text_button">Click aqui</span></button>
                        </a>
                        <div class="separator"></div>
                    </div>
                </div>
                <div class="footer_card">
                    <div style="margin-bottom:8px;">
                        <span>Gracias por elegirnos,</span>
                    </div>
                    <span style="font-family: 'Open Sans', sans-serif;
            font-style: normal;font-weight: 700;">El equipo de Cifrado.</span>
                </div>
            </div>
        </div>
    </div>

    <div style="width: 100%; margin-top:40px;">
        <div style="width:100%; display: flex; flex-direction: row;">
            <div style="display:flex;width:100px; margin:0 auto; ">
                <a href="https://www.facebook.com/CifradoSAS" target="_blank" rel="noopener noreferrer">
                    <img width="13" height="23" src="https://app.aveonline.co/assets/img/facebook-onboarding.png" alt="">
                </a>
                <a href="https://www.instagram.com/cifradosas/" target="_blank" rel="noopener noreferrer">
                    <img width="24" height="24" style="margin-left: 1rem;" src="https://app.aveonline.co/assets/img/Instagram-ave-onboarding.png" alt="icon ave">
                </a>
            </div>
        </div>
    </div>
    <div style=" width:100%; text-align:center; margin-top:30px;">
        <span>© Cifrado {{ $year }} · Medellín - CO.</span>
    </div>

</body>

</html>
