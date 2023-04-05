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

      var canvasPenguji = document.getElementById("sig-canvas-penguji");
      var ctxPenguji = canvasPenguji.getContext("2d");
      ctxPenguji.strokeStyle = "#222222";
      ctxPenguji.lineWidth = 5;

      var drawingPenguji = false;
      var mousePosPenguji = {
          x: 0,
          y: 0
      };
      var lastPosPenguji = mousePosPenguji;

      canvasPenguji.addEventListener("mousedown", function(e) {
          drawingPenguji = true;
          lastPosPenguji = getMousePos(canvasPenguji, e);
      }, false);

      canvasPenguji.addEventListener("mouseup", function(e) {
          drawingPenguji = false;
      }, false);

      canvasPenguji.addEventListener("mousemove", function(e) {
          mousePosPenguji = getMousePos(canvasPenguji, e);
      }, false);

      // Add touch event support for mobile
      canvasPenguji.addEventListener("touchstart", function(e) {

      }, false);

      canvasPenguji.addEventListener("touchmove", function(e) {
          var touchPenguji = e.touches[0];
          var me = new MouseEvent("mousemove", {
              clientX: touchPenguji.clientX,
              clientY: touchPenguji.clientY
          });
          canvasPenguji.dispatchEvent(me);
      }, false);

      canvasPenguji.addEventListener("touchstart", function(e) {
          mousePosPenguji = getTouchPos(canvasPenguji, e);
          var touchPenguji = e.touches[0];
          var mePenguji = new MouseEvent("mousedown", {
              clientX: touchPenguji.clientX,
              clientY: touchPenguji.clientY
          });
          canvasPenguji.dispatchEvent(mePenguji);
      }, false);

      canvasPenguji.addEventListener("touchend", function(e) {
          var mePenguji = new MouseEvent("mouseup", {});
          canvasPenguji.dispatchEvent(mePenguji);
      }, false);

      function getMousePos(canvasPengujiDom, mouseEvent) {
          var rectPenguji = canvasPengujiDom.getBoundingClientRect();
          return {
              x: mouseEvent.clientX - rectPenguji.left,
              y: mouseEvent.clientY - rectPenguji.top
          }
      }

      function getTouchPos(canvasPengujiDom, touchEvent) {
          var rectPenguji = canvasPengujiDom.getBoundingClientRect();
          return {
              x: touchEvent.touches[0].clientX - rectPenguji.left,
              y: touchEvent.touches[0].clientY - rectPenguji.top
          }
      }

      function renderCanvasPenguji() {
          if (drawingPenguji) {
              ctxPenguji.moveTo(lastPosPenguji.x, lastPosPenguji.y);
              ctxPenguji.lineTo(mousePosPenguji.x, mousePosPenguji.y);
              ctxPenguji.stroke();
              lastPosPenguji = mousePosPenguji;
          }
      }

      // Prevent scrolling when touching the canvasPenguji
      document.body.addEventListener("touchstart", function(e) {
          if (e.target == canvasPenguji) {
              e.preventDefault();
          }
      }, false);
      document.body.addEventListener("touchend", function(e) {
          if (e.target == canvasPenguji) {
              e.preventDefault();
          }
      }, false);
      document.body.addEventListener("touchmove", function(e) {
          if (e.target == canvasPenguji) {
              e.preventDefault();
          }
      }, false);

      (function drawLoop() {
          requestAnimFrame(drawLoop);
          renderCanvasPenguji();
      })();

      function clearCanvasPenguji() {
          canvasPenguji.width = canvasPenguji.width;
      }

      // Set up the UI
      var clearBtnPenguji = document.getElementById("sig-clearBtn-penguji");
      var submitBtnPenguji = document.getElementById("sig-submitBtn-penguji");
      var sigImagePenguji = document.getElementById("sig-image-penguji");
      var sigTextPenguji = document.getElementById("sig-dataUrl-penguji");
      if (clearBtnPenguji) {
          clearBtnPenguji.addEventListener("click", function(e) {
              clearCanvasPenguji();
              Swal.fire({
                  title: "Tanda tangan penguji telah dibersihkan",
                  text: "Silahkan melakukan tanda tangan ulang",
                  timer: 2000,
                  timerProgressBar: true,
                  icon: "warning",
              })
              // sigImage.setAttribute("src", "");
          }, false);
      }
      if (submitBtnPenguji) {
          submitBtnPenguji.addEventListener("click", function(e) {
              var dataUrlPenguji = canvasPenguji.toDataURL();
              sigTextPenguji.innerHTML = dataUrlPenguji;
              // alert('Berhasil menyimpan tanda tangan!');
              Swal.fire({
                  title: "Tanda tangan penguji berhasil disimpan",
                  icon: "success",
                  timer: 1500,
                  timerProgressBar: true,
              });
              document.getElementById("sig-check-penguji").style.display = "block";
              console.log('ttd penguji' + dataUrlPenguji);
              // var ttd = dataUrl;
              // sigImage.setAttribute("src", dataUrl);
          }, false);
      }

  })();
