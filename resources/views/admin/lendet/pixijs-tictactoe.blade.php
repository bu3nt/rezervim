<x-admin-layout>
    <x-slot:custom_css>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/vendors/sweetalert2.css') }}">  
    </x-slot:custom_css>
    <x-slot:title>
        Tic Tac Toe
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
                    <li class="breadcrumb-item active">Tic Tac Toe</li>
                </ol>
            </div>
        </div>        
    </x-slot>
    <div class="row">
        <div class="col-sm-12">   
            <div class="card">
                <div class="card-header pb-0 card-no-border">
                    <h5>Tic Tac Toe</h5><span>Lojë e zhvilluar me PixiJS</span>
                </div>
                <div class="card-body">
                    <x-response-message></x-response-message>
                    <style>
                        .centered-div {
                            text-align: center;
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
                        <h1>Tic Tac Toe</h1>
                        <p>Dueli në mes të Master Card dhe VISA</p>
                        <div id="tictactoe">

                        </div>        
                        <button class="styled-button" onclick="resetGame()">Loje e Re</button>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <x-slot:custom_js>
    <script src="https://pixijs.download/release/pixi.js"></script> 
    <script src="{{ asset('assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script>
        const tictactoe = document.getElementById('tictactoe');
        // Krijimi dhe vendosa e PixiJS canvasit ne div
        const app = new PIXI.Application({ width: 300, height: 300 });
        tictactoe.appendChild(app.view);

        // Krijimi i figurave
        const mastercard = '{{ asset('assets/images/ecommerce/mastercard.png') }}';
        const visa = '{{ asset('assets/images/ecommerce/visa.png') }}';

        // Paramertat e Tic Tac Toe
        const boardSize = 3;
        const cellSize = app.renderer.width / boardSize;
        const players = [['Master Card', mastercard], ['Visa', visa]];
        let currentPlayer = players[0];
        let gameBoard = [];
    

        // Funksioni i inicializimit te Lojes
        function initializeGame() {
            for (let i = 0; i < boardSize; i++) {
                gameBoard[i] = [];
                for (let j = 0; j < boardSize; j++) {
                    const cell = new PIXI.Graphics();
                    cell.beginFill(0xFFFFFF);
                    cell.lineStyle(2, 0x000000); // Stilizimi i kornizes
                    cell.drawRect(j * cellSize, i * cellSize, cellSize, cellSize);
                    cell.endFill();
                    cell.interactive = true;
                    cell.on('pointerdown', () => handleCellClick(i, j, cell));
                    app.stage.addChild(cell);
                    gameBoard[i][j] = { value: '', cell };
                }
            }
        }
    
        // Function per ta trajtuar eventin e klikimit
        function handleCellClick(row, col, cell) {
            if (gameBoard[row][col].value === '') {
                gameBoard[row][col].value = currentPlayer[1];

                const currentSprite = PIXI.Sprite.from(currentPlayer[1]);
                currentSprite.anchor.set(0.5);
                currentSprite.x = col * cellSize + cellSize / 2;
                currentSprite.y = row * cellSize + cellSize / 2;   
                app.stage.addChild(currentSprite);

                // Kontrollimi per fitore apo barazim
                if (checkWin(row, col)) {
                    swal({
                        title: "Loja Mbaroi!",
                        text: currentPlayer[0] + " fitoi!",
                        icon: "success"
                    });
                    resetGame();
                } else if (checkDraw()) {
                    swal({
                        title: "Loja Mbaroi!",
                        text: "Barazim!",
                        icon: "success"
                    });
                    resetGame();
                } else {
                    currentPlayer = (currentPlayer === players[0]) ? players[1] : players[0];
                }
            }
        }
    
        // Funksioni per te kontrolluar per fitore
        function checkWin(row, col) {
            // Check row
            if (gameBoard[row].every(cell => cell.value === currentPlayer[1])) {
                return true;
            }
    
            // Check column
            if (gameBoard.every(row => row[col].value === currentPlayer[1])) {
                return true;
            }
    
            // Check diagonals
            if (row === col && gameBoard.every((row, index) => row[index].value === currentPlayer[1])) {
                return true;
            }
    
            if (row + col === boardSize - 1 && gameBoard.every((row, index) => row[boardSize - 1 - index].value === currentPlayer[1])) {
                return true;
            }
    
            return false;
        }
    
        // Function per te kontrolluar per barazim
        function checkDraw() {
            return gameBoard.every(row => row.every(cell => cell.value !== ''));
        }
    
        // Function per ta rifilluar lojen
        function resetGame() {
            gameBoard.forEach(row => row.forEach(cell => {
                cell.value = '';
                app.stage.removeChild(cell.cell);
            }));
            currentPlayer = players[0];
            initializeGame();
        }
    
        // Inicializimi i lojes ne ngarkim te faqes
        initializeGame();
    </script>
    </x-slot:custom_js>
</x-admin-layout>