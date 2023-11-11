<div class="container-xxl">
    <a onclick="test()" class="btn btn-primary">DO</a>
</div>

@section('title')
    پیشخان
@endsection
@section('description')
    پیشخان کنترل پنل
@endsection
@push('scripts')
    <script>
        var test = null;
        var connection = new WebSocket('ws://127.0.0.1:8080');
        connection.onopen = function () {
            var i = 0;
            while (true) {
                i++;
                if(i == 100000) {
                    connection.send(Date.now());
                    i = 0;
                }
            }
            test = function () {
                console.log("sdfsdfd");

                connection.send(Date.now()); // Send the message 'Ping' to the server

            }};
        const canvas = document.getElementById("gameArea");
        const ctx = canvas.getContext("2d");

        let playerWidthAndHeight = 0;
        let playerX = 0;
        let playerY = 0;
        let playerColor = "orange";
        let gear = 1;
        let velocity = 0;
        let lr = 0;
        let ud = 0;
        let f = 0;
        let b = 0;

        let controllerIndex = null;
        let leftPressed = false;
        let rightPressed = false;
        let upPressed = false;
        let downPressed = false;

        let bluePressed = false;
        let orangePressed = false;
        let redPressed = false;
        let greenPressed = false;

        function setupCanvas() {
            canvas.width = window.innerWidth;
            canvas.height = window.innerHeight;
            playerWidthAndHeight = canvas.width * 0.1;
            velocity = 0.01;

            playerX = (canvas.width - playerWidthAndHeight) / 2;
            playerY = (canvas.height - playerWidthAndHeight) / 2;
        }

        setupCanvas();

        window.addEventListener("resize", setupCanvas);
        window.addEventListener("gamepadconnected", (event) => {
            controllerIndex = event.gamepad.index;
            console.log("connected");
        });

        window.addEventListener("gamepaddisconnected", (event) => {
            console.log("disconnected");
            controllerIndex = null;
        });

        function clearScreen() {
            ctx.fillStyle = "#333331";
            ctx.fillRect(0, 0, canvas.width, canvas.height);
        }

        function drawPlayer() {
            ctx.fillStyle = playerColor;
            ctx.fillRect(playerX, playerY, playerWidthAndHeight, playerWidthAndHeight);
        }

        function controllerInput() {
            if (controllerIndex !== null) {
                const gamepad = navigator.getGamepads()[controllerIndex];

                const buttons = gamepad.buttons;
                upPressed = buttons[12].pressed;
                downPressed = buttons[13].pressed;
                leftPressed = buttons[14].pressed;
                rightPressed = buttons[15].pressed;

                const stickDeadZone = 0.4;
                const leftRightValue = gamepad.axes[0];
                const forwardForce = gamepad.buttons[7].value;
                const backwardForce = gamepad.buttons[6].value;
                console.log("leftRightValue:" + leftRightValue);
                if (leftRightValue >= stickDeadZone) {
                    rightPressed = true;
                } else if (leftRightValue <= -stickDeadZone) {
                    leftPressed = true;
                }

                const upDownValue = gamepad.axes[1];

                @this.command(leftRightValue, upDownValue, gamepad.buttons[7].value, gamepad.buttons[6].value,gear, Date.now());


                if (upDownValue >= stickDeadZone) {
                    downPressed = true;
                } else if (upDownValue <= -stickDeadZone) {
                    upPressed = true;
                }

                redPressed = buttons[0].pressed;
                bluePressed = buttons[1].pressed;
                orangePressed = buttons[2].pressed;
                greenPressed = buttons[3].pressed;

                if (bluePressed) {
                    greenPressed = false;
                    redPressed = false;
                    orangePressed = false;
                    gear = 1;
                } else if (greenPressed) {
                    bluePressed = false;
                    redPressed = false;
                    orangePressed = false;
                    gear = 4;
                } else if (redPressed) {
                    greenPressed = false;
                    bluePressed = false;
                    orangePressed = false;
                    gear = 3;
                } else if (orangePressed) {
                    greenPressed = false;
                    redPressed = false;
                    bluePressed = false;
                    gear = 2;
                }
            }
        }

        function changePlayerColor() {
        }

        function updatePlayer() {
            changePlayerColor();
        }

        function gameLoop() {
            controllerInput();
            updatePlayer();
            requestAnimationFrame(gameLoop);
        }

        gameLoop();
    </script>
@endpush
