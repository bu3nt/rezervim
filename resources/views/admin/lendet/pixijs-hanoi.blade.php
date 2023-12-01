<x-admin-layout>
    <x-slot:custom_css>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/sweetalert2.css') }}">  
    </x-slot:custom_css>
    <x-slot:title>
        Kullat Hanoi
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
                    <li class="breadcrumb-item active">Kullat Hanoi</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">   
            <div class="card">
                <div class="card-header pb-0 card-no-border">
                    <h5>Kullat Hanoi</h5><span>Lojë e zhvilluar me PixiJS</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>
                    <style>
                        .centered-div {
                            text-align: center;
                        }      
                    </style>                    
                    <div class="centered-div">
                        <h1>Kullat e Hanoi-t</h1>
                        <p>Tentoni ti vendosni disqet nga kulla e parë në kullën e fundit</p>
                        <div id="hanoi">

                        </div>        
                    </div> 
                </div>
            </div>
        </div>
    </div>
    <x-slot:custom_js>
    <script src="https://pixijs.download/release/pixi.js"></script> 
    <script src="{{ asset('assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script>
        const hanoi = document.getElementById('hanoi');
        // Krijimi dhe vendosa e PixiJS canvasit ne body te dokumentit
        const app = new PIXI.Application({ width: 800, height: 600 });
        hanoi.appendChild(app.view);
    
        // Parametrat e Kullat e Hanoi-t
        const numDiscs = 4;
        const towerWidth = 150;
        const towerHeight = 200;
        const towerStickWidth = 10;
        const towerStickHeight = 200;
        const discWidth = 30;
        const discHeight = 20;
        const towerGap = 200;
    
        // Pozicioni i Kullave
        const towers = [
            { x: 100, y: app.renderer.height - towerHeight, discs: [] },
            { x: 300, y: app.renderer.height - towerHeight, discs: [] },
            { x: 500, y: app.renderer.height - towerHeight, discs: [] }
        ];
    
        // Krijimi i Kullave
        for (let i = 0; i < towers.length; i++) {
            const tower = new PIXI.Graphics();
            const towerStick = new PIXI.Graphics();
            tower.beginFill(0x663300);
            tower.drawRect(0, 0, towerWidth, towerHeight);
            tower.position.set(towers[i].x, towers[i].y);
            towerStick.beginFill(0xFFFFFF);
            towerStick.drawRect(0, 0, towerStickWidth, towerStickHeight);
            towerStick.position.set(towers[i].x + ((towerWidth / 2) - (towerStickWidth / 2)), towers[i].y - towerHeight);            
            app.stage.addChild(tower);
            app.stage.addChild(towerStick);
        }
    
        // Krijimi i disqeve me ngjyra te ndryshme
        const discColors = [0xFF0000, 0x00FF00, 0x0000FF, 0xFFFF00];
        const selectedDiscColor = 0xFFFF00; // Ngjyra per diskun e selektuar
        let selectedDisc = null;

        for (let i = 0; i < numDiscs; i++) {
            const disc = new PIXI.Graphics();
            disc.beginFill(discColors[i]);
            disc.drawRect(0, 0, discWidth + i * 20, discHeight);
            disc.position.set(towers[0].x + (towerWidth - discWidth - i * 20) / 2, towers[0].y - (i + 1) * discHeight);
            towers[0].discs.push(disc);
            app.stage.addChild(disc);

            // Event listener for disc click
            disc.interactive = true;
            disc.on('pointerdown', () => {
                if (selectedDisc !== null) {
                    selectedDisc.tint = selectedDisc.originalColor;
                }

                selectedDisc = disc;
                selectedDisc.originalColor = disc.tint;
                disc.tint = selectedDiscColor;
            });
        }
    
        // Degjimi per eventin e klikimit 
        app.view.addEventListener("click", (event) => {
            const clickX = event.clientX - app.view.getBoundingClientRect().left;
            const clickY = event.clientY - app.view.getBoundingClientRect().top;

            for (const tower of towers) {
                if (clickX >= tower.x && clickX <= tower.x + towerWidth && clickY >= tower.y && clickY <= tower.y + towerHeight) {
                    if (selectedTower === null) {
                        selectedTower = tower;
                    } else {
                        moveDisc(selectedTower, tower);
                        selectedTower = null;
                        checkWinCondition();
                    }
                    break;
                }
            }
        });
    
        let selectedTower = null;
    
        // Funksioni i per zhvendosjen e diskut
        function moveDisc(fromTower, toTower) {
            if (fromTower.discs.length === 0 || (toTower.discs.length > 0 && fromTower.discs[fromTower.discs.length - 1].width > toTower.discs[toTower.discs.length - 1].width)) {
                console.log("Lëvizje e palejuar!");
                return;
            }

            const disc = fromTower.discs.pop();
            disc.x = toTower.x + (towerWidth - disc.width) / 2;
            disc.y = (toTower.y - toTower.discs.length * discHeight) - discHeight;
            toTower.discs.push(disc);

            // Reset the selected disc's tint
            if (selectedDisc !== null) {
                selectedDisc.tint = selectedDisc.originalColor;
            }
        }
    
        // Kontrollo per gjendjen e fitores, shiko a jane te gjitha disqet mbi kullen e fundit
        function checkWinCondition() {
            if (towers[2].discs.length === numDiscs) {
                swal({
                        title: "Ju fituat!",
                        text: "Të gjitha disqet jane zhvendosur ne kullen e fundit.",
                        icon: "success"
                    });
            }
        }
    
        // Funksioni Update
        function update() {
            // Ketu mund te implementohet ndonje logjike gjate ekzekutimit te ticker.
        }
    
        // Leshimi i lojes (tickerit)
        app.ticker.add((delta) => {
            update();
        });
    </script> 
    </x-slot:custom_js>
</x-admin-layout>