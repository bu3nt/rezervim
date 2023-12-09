<x-admin-layout>
    <x-slot:title>
    Shmangja e përplasjeve
    </x-slot>
    <x-slot name="header">
        <div class="row">
            <div class="col-6">
                <!-- <h3>{{ __('plan.index.title') }}</h3> -->
            </div>
            <div class="col-6">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">                                       
                        <svg class="stroke-icon">
                            <use href="{{ asset('assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                        </svg></a></li>
                    <li class="breadcrumb-item">Semestri 1</li>
                    <li class="breadcrumb-item">Multimedia Kompjuterike</li>
                    <li class="breadcrumb-item active">Shmangja e përplasjeve</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">   
            <div class="card">
                <div class="card-header pb-0 card-no-border">
                    <h5>Shmangja e përplasjeve</h5><span>Lojë e zhvilluar me Canvas</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>
                    <style>
                        .centered-div {
                            text-align: center;
                        }        
                        canvas {
                            border: 1px solid #000;
                            display: block;
                            margin: 20px auto;
                        }
                        .styled-button {
                            padding: 10px 20px;
                            font-size: 16px;
                            font-weight: bold;
                            text-transform: uppercase;
                            background-color: #3498db;
                            color: #fff;
                            border: none;
                            border-radius: 5px;
                            cursor: pointer;
                            margin-top: 10px;
                        }

                        .styled-button:hover {
                            background-color: #2980b9;
                        }      
                    </style>                    
                    <div class="centered-div">
                        <h1>Shmangja e përplasjeve</h1>
                        <p>Tento që duke levizur me tastet e drejtimit (Arrow Keys) ti shmangni sa më tepër kontaktet me topat e kuq.</p>    
                        <canvas id="canvas" width="400" height="400"></canvas>
                        <button class="styled-button" onclick="resetGame()">Loje e Re</button>        
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <x-slot:custom_js>
    <script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');

    // Objekti i Lojës (katrori i kuq)
    const player = {
        x: 50,
        y: 50,
        size: 30,
        color: '#3498db',
        speed: 5,
    };

    // Varku per ruajten e topave
    const circles = [];

    // Ndegjuesi i ngjarjeve per prekjen e butonave te drejtimit
    window.addEventListener('keydown', (e) => {
        switch (e.key) {
        case 'ArrowUp':
            player.y -= player.speed;
            break;
        case 'ArrowDown':
            player.y += player.speed;
            break;
        case 'ArrowLeft':
            player.x -= player.speed;
            break;
        case 'ArrowRight':
            player.x += player.speed;
            break;
        }
    });

    // Funksioni per gjenerimin e Topave ne pozita te rastesishme
    function generateRandomCircle() {
        const circle = {
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        radius: 20,
        color: '#e74c3c',
        };
        circles.push(circle);
    }

    // Function per te kontrolluar kontaktin mes topave dhe lojtarit
    function checkCollisions() {
        circles.forEach((circle, index) => {
        const dx = player.x - circle.x;
        const dy = player.y - circle.y;
        const distance = Math.sqrt(dx * dx + dy * dy);

        if (distance < player.size / 2 + circle.radius) {
            // U detektua kontakti, largo topin e kuq
            circles.splice(index, 1);
        }
        });
    }

    // Cikli i lojes
    function gameLoop() {
        // Pastro Canvasin
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Leviz lojtarin
        checkCollisions();

        // Vizato lojtarin
        ctx.fillStyle = player.color;
        ctx.fillRect(player.x - player.size / 2, player.y - player.size / 2, player.size, player.size);

        // Vizato topat
        circles.forEach((circle) => {
        ctx.beginPath();
        ctx.arc(circle.x, circle.y, circle.radius, 0, Math.PI * 2);
        ctx.fillStyle = circle.color;
        ctx.fill();
        });

        // Gjenerimi i topit ne intervale te rastesishme
        if (Math.random() < 0.02) {
        generateRandomCircle();
        }

        // Kerko kornizen e ardhshme te lojes
        requestAnimationFrame(gameLoop);
    }

    // Function per ta rifilluar lojen
    function resetGame() {
        player.x = 50;
        player.y = 50;
        circles.length = 0; // Pastro vargun e topave
    }
    // Fillo Ciklin e lojes
    gameLoop();
    </script>
    </x-slot:custom_js>
</x-admin-layout>