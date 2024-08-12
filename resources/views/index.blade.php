<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gaming Night City</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animejs/3.2.1/anime.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/howler/2.2.3/howler.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/vanilla-tilt@1.7.0/dist/vanilla-tilt.min.js"></script>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            font-family: "Arial", sans-serif;
            background: linear-gradient(135deg, #2b2d2f, #1a202c);
            color: white;
            font-family: "P5";
            overflow: hidden;
            /* Prevent scrolling during intro */
        }

        @font-face {
            font-family: "HeavyHea";
            src: url(assets/fonts/HEAVYHEA.TTF);
        }

        @font-face {
            font-family: "P5";
            src: url(assets/fonts/p5hatty-1.ttf);
        }

        .welcome-screen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background-color: rgba(0, 0, 0, 0.8);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            z-index: 999;
            color: #edf2f7;
            font-size: 2rem;
            text-align: center;
        }

        .welcome-screen p {
            margin-bottom: 1rem;
        }

        .welcome-screen button {
            background-color: #4a5568;
            border: none;
            color: #edf2f7;
            font-size: 1.25rem;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .welcome-screen button:hover {
            background-color: #2d3748;
        }

        .preview-section {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 50vh;
            background-color: #1a202c;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 4px solid #4a5568;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .selection-section {
            margin-top: 50vh;
            padding: 2rem;
            overflow-x: auto;
            white-space: nowrap;
            background-color: #2d3748;
            border-top: 4px solid #4a5568;
            box-shadow: inset 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .character-grid {
            display: inline-flex;
            gap: 20px;
            padding: 20px 0;
        }

        .character-card {
            height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            /* background: #3a4556;
            border: 2px solid #4a5568; */
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .character-card:hover {
            transform: scale(1.05);
            /* box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); */
        }

        .character-card img {
            width: 80%;
            height: auto;
            max-height: 70%;
            object-fit: cover;
            margin-bottom: 10px;
        }

        .character-card p {
            font-size: 1.25rem;
            color: #edf2f7;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
        }
    </style>
</head>

<body>
    <div class="welcome-screen" id="welcome-screen">
        <p class="animate__animated animate__slideInDown animate__fast text-5xl">Choose Your Character!</p>
        <button id="continue-button" class="animate__animated animate__slideInDown">Continue</button>
    </div>
    <div class="preview-section">
        <img id="preview-image" src="/api/placeholder/400/600" alt="Select a character"
            class="max-w-full max-h-full object-contain" />
    </div>
    <div class="selection-section" draggable="false">
        <div class="character-grid w-full" draggable="false">
            <img src="{{ URL::asset('assets/images/cards/Nastro-spider_nastromeister.png') }}" id="nastro"
                class="character-card hover:drop-shadow-[0_4px_12px_#4301A1] grayscale hover:grayscale-0" alt=""
                draggable="false" data-character="Nastromeister"
                data-image="{{ URL::asset('assets/images/previews/spider-nastro.png') }}" />
            <img src=" {{ URL::asset('assets/images/cards/King_Thekingdx.png') }}" id="thekingdx"
                class="character-card hover:drop-shadow-[0_4px_12px_#8B1E1E] grayscale hover:grayscale-0" alt=""
                draggable="false" data-character="Thekingdx" data-image="spider-nastro.png" />
            <img src="{{ URL::asset('assets/images/cards/nigth_owl_dustydee.png') }} " id="dustydee"
                class="character-card hover:drop-shadow-[0_4px_12px_#B1430D] grayscale hover:grayscale-0" alt=""
                draggable="false" data-character="DustyDee" data-image="spider-nastro.png" />
            <img src="{{ URL::asset('assets/images/cards/Ferocity_ichisansfw.png') }}" id="ichisansfw"
                class="character-card hover:drop-shadow-[0_4px_12px_rgba(0,255,0,0.5)] grayscale hover:grayscale-0"
                draggable="false" alt="" data-character="IchisanSFW" data-image="spider-nastro.png" />
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            VanillaTilt.init(document.querySelectorAll(".character-card"), {
                max: 20,
                speed: 400,
                scale: 1.1,
            });

            const previewImage = document.getElementById("preview-image");
            const characterCards = document.querySelectorAll(".character-card");

            const hoverSound = new Howl({
                src: ["{{ URL::asset('assets/sounds/hover.wav') }}"],
                preload: true,
            });

            const selectSound = new Howl({
                src: ["{{ URL::asset('assets/sounds/select.wav') }}"],
                preload: true,
            });

            characterCards.forEach((card) => {
                card.addEventListener("mouseenter", () => handleHover(card));
                card.addEventListener("click", () => handleSelect(card));
            });

            function handleHover(card) {
                const characterName = card.getAttribute("data-character");
                const characterImage = card.getAttribute("data-image");

                hoverSound.play();

                gsap.to(previewImage, {
                    opacity: 0,
                    duration: 0.3,
                    onComplete: () => {
                        previewImage.src = characterImage;
                        previewImage.alt = characterName;
                        gsap.to(previewImage, {
                            opacity: 1,
                            duration: 0.3
                        });
                    },
                });
            }

            function handleSelect(card) {
                const characterName = card.getAttribute("data-character");
                selectSound.play();
                console.log(`Selected character: ${characterName}`);
                // Add your character selection logic here
            }

            // Initial animation
            anime({
                targets: ".character-card",
                translateX: [100, 0],
                opacity: [0, 1],
                delay: anime.stagger(100),
                easing: "easeOutQuad",
                duration: 800,
            });

            // Fade out welcome screen on button click
            document
                .getElementById("continue-button")
                .addEventListener("click", () => {
                    gsap.to("#welcome-screen", {
                        opacity: 0,
                        duration: 1,
                        onComplete: () => {
                            document.querySelector("#welcome-screen").style.display =
                                "none";
                            document.body.style.overflow = "auto";
                        },
                    });
                });
        });
    </script>
</body>

</html>
