(function() {
    window.requestAnimFrame = (function(callback) {
        return window.requestAnimationFrame ||
            window.webkitRequestAnimationFrame ||
            window.mozRequestAnimationFrame ||
            window.oRequestAnimationFrame ||
            window.msRequestAnimaitonFrame ||
            function(callback) {
                window.setTimeout(callback, 1000 / 60);
            };
    })();

    var canvasManager = document.getElementById("sig-canvas-manager");
    var ctxManager = canvasManager.getContext("2d");
    ctxManager.strokeStyle = "#222222";
    ctxManager.lineWidth = 5;

    var drawingManager = false;
    var mousePosManager = {
        x: 0,
        y: 0
    };
    var lastPosManager = mousePosManager;

    canvasManager.addEventListener("mousedown", function(e) {
        drawingManager = true;
        lastPosManager = getMousePos(canvasManager, e);
    }, false);

    canvasManager.addEventListener("mouseup", function(e) {
        drawingManager = false;
    }, false);

    canvasManager.addEventListener("mousemove", function(e) {
        mousePosManager = getMousePos(canvasManager, e);
    }, false);

    // Add touch event support for mobile
    canvasManager.addEventListener("touchstart", function(e) {

    }, false);

    canvasManager.addEventListener("touchmove", function(e) {
        var touchManager = e.touches[0];
        var me = new MouseEvent("mousemove", {
            clientX: touchManager.clientX,
            clientY: touchManager.clientY
        });
        canvasManager.dispatchEvent(me);
    }, false);

    canvasManager.addEventListener("touchstart", function(e) {
        mousePosManager = getTouchPos(canvasManager, e);
        var touchManager = e.touches[0];
        var meManager = new MouseEvent("mousedown", {
            clientX: touchManager.clientX,
            clientY: touchManager.clientY
        });
        canvasManager.dispatchEvent(meManager);
    }, false);

    canvasManager.addEventListener("touchend", function(e) {
        var meManager = new MouseEvent("mouseup", {});
        canvasManager.dispatchEvent(meManager);
    }, false);

    function getMousePos(canvasManagerDom, mouseEvent) {
        var rectManager = canvasManagerDom.getBoundingClientRect();
        return {
            x: mouseEvent.clientX - rectManager.left,
            y: mouseEvent.clientY - rectManager.top
        }
    }

    function getTouchPos(canvasManagerDom, touchEvent) {
        var rectManager = canvasManagerDom.getBoundingClientRect();
        return {
            x: touchEvent.touches[0].clientX - rectManager.left,
            y: touchEvent.touches[0].clientY - rectManager.top
        }
    }

    function renderCanvasManager() {
        if (drawingManager) {
            ctxManager.moveTo(lastPosManager.x, lastPosManager.y);
            ctxManager.lineTo(mousePosManager.x, mousePosManager.y);
            ctxManager.stroke();
            lastPosManager = mousePosManager;
        }
    }

    // Prevent scrolling when touching the canvasManager
    document.body.addEventListener("touchstart", function(e) {
        if (e.target == canvasManager) {
            e.preventDefault();
        }
    }, false);
    document.body.addEventListener("touchend", function(e) {
        if (e.target == canvasManager) {
            e.preventDefault();
        }
    }, false);
    document.body.addEventListener("touchmove", function(e) {
        if (e.target == canvasManager) {
            e.preventDefault();
        }
    }, false);

    (function drawLoop() {
        requestAnimFrame(drawLoop);
        renderCanvasManager();
    })();

    function clearCanvasManager() {
        canvasManager.width = canvasManager.width;
    }

    // Set up the UI
    var clearBtnManager = document.getElementById("sig-clearBtn-manager");
    var submitBtnManager = document.getElementById("sig-submitBtn-manager");
    var sigImageManager = document.getElementById("sig-image-manager");
    var sigTextManager = document.getElementById("sig-dataUrl-manager");
    if (clearBtnManager) {
        clearBtnManager.addEventListener("click", function(e) {
            clearCanvasManager();
            Swal.fire({
                title: "Tanda tangan manager telah dibersihkan",
                text: "Silahkan melakukan tanda tangan ulang",
                timer: 2000,
                timerProgressBar: true,
                icon: "warning",
            })
            // sigImage.setAttribute("src", "");
        }, false);
    }
    if (submitBtnManager) {
        submitBtnManager.addEventListener("click", function(e) {
            var dataUrlManager = canvasManager.toDataURL();
            sigTextManager.innerHTML = dataUrlManager;
            // alert('Berhasil menyimpan tanda tangan!');
            Swal.fire({
                title: "Tanda tangan manager berhasil disimpan",
                icon: "success",
                timer: 1500,
                timerProgressBar: true,
            })
            console.log('ttd manager' + dataUrlManager);
            // var ttd = dataUrl;
            // sigImage.setAttribute("src", dataUrl);
        }, false);
    }

})();
