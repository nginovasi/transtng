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

      var canvasPenyidik = document.getElementById("sig-canvas-penyidik");
      var ctxPenyidik = canvasPenyidik.getContext("2d");
      ctxPenyidik.strokeStyle = "#222222";
      ctxPenyidik.lineWidth = 5;

      var drawingPenyidik = false;
      var mousePosPenyidik = {
          x: 0,
          y: 0
      };
      var lastPosPenyidik = mousePosPenyidik;

      canvasPenyidik.addEventListener("mousedown", function(e) {
          drawingPenyidik = true;
          lastPosPenyidik = getMousePos(canvasPenyidik, e);
      }, false);

      canvasPenyidik.addEventListener("mouseup", function(e) {
          drawingPenyidik = false;
      }, false);

      canvasPenyidik.addEventListener("mousemove", function(e) {
          mousePosPenyidik = getMousePos(canvasPenyidik, e);
      }, false);

      // Add touch event support for mobile
      canvasPenyidik.addEventListener("touchstart", function(e) {

      }, false);

      canvasPenyidik.addEventListener("touchmove", function(e) {
          var touchPenyidik = e.touches[0];
          var me = new MouseEvent("mousemove", {
              clientX: touchPenyidik.clientX,
              clientY: touchPenyidik.clientY
          });
          canvasPenyidik.dispatchEvent(me);
      }, false);

      canvasPenyidik.addEventListener("touchstart", function(e) {
          mousePosPenyidik = getTouchPos(canvasPenyidik, e);
          var touchPenyidik = e.touches[0];
          var mePenyidik = new MouseEvent("mousedown", {
              clientX: touchPenyidik.clientX,
              clientY: touchPenyidik.clientY
          });
          canvasPenyidik.dispatchEvent(mePenyidik);
      }, false);

      canvasPenyidik.addEventListener("touchend", function(e) {
          var mePenyidik = new MouseEvent("mouseup", {});
          canvasPenyidik.dispatchEvent(mePenyidik);
      }, false);

      function getMousePos(canvasPenyidikDom, mouseEvent) {
          var rectPenyidik = canvasPenyidikDom.getBoundingClientRect();
          return {
              x: mouseEvent.clientX - rectPenyidik.left,
              y: mouseEvent.clientY - rectPenyidik.top
          }
      }

      function getTouchPos(canvasPenyidikDom, touchEvent) {
          var rectPenyidik = canvasPenyidikDom.getBoundingClientRect();
          return {
              x: touchEvent.touches[0].clientX - rectPenyidik.left,
              y: touchEvent.touches[0].clientY - rectPenyidik.top
          }
      }

      function renderCanvasPenyidik() {
          if (drawingPenyidik) {
              ctxPenyidik.moveTo(lastPosPenyidik.x, lastPosPenyidik.y);
              ctxPenyidik.lineTo(mousePosPenyidik.x, mousePosPenyidik.y);
              ctxPenyidik.stroke();
              lastPosPenyidik = mousePosPenyidik;
          }
      }

      // Prevent scrolling when touching the canvasPenyidik
      document.body.addEventListener("touchstart", function(e) {
          if (e.target == canvasPenyidik) {
              e.preventDefault();
          }
      }, false);
      document.body.addEventListener("touchend", function(e) {
          if (e.target == canvasPenyidik) {
              e.preventDefault();
          }
      }, false);
      document.body.addEventListener("touchmove", function(e) {
          if (e.target == canvasPenyidik) {
              e.preventDefault();
          }
      }, false);

      (function drawLoop() {
          requestAnimFrame(drawLoop);
          renderCanvasPenyidik();
      })();

      function clearCanvasPenyidik() {
          canvasPenyidik.width = canvasPenyidik.width;
      }

      // Set up the UI
      var clearBtnPenyidik = document.getElementById("sig-clearBtn-penyidik");
      var submitBtnPenyidik = document.getElementById("sig-submitBtn-penyidik");
      var sigImagePenyidik = document.getElementById("sig-image-penyidik");
      var sigTextPenyidik = document.getElementById("sig-dataUrl-penyidik");
      if (clearBtnPenyidik) {
          clearBtnPenyidik.addEventListener("click", function(e) {
              clearCanvasPenyidik();
              Swal.fire({
                  title: "Tanda tangan penyidik telah dibersihkan",
                  text: "Silahkan melakukan tanda tangan ulang",
                  timer: 2000,
                  timerProgressBar: true,
                  icon: "warning",
              })
              // sigImage.setAttribute("src", "");
          }, false);
      }
      if (submitBtnPenyidik) {
          submitBtnPenyidik.addEventListener("click", function(e) {
              var dataUrlPenyidik = canvasPenyidik.toDataURL();
              sigTextPenyidik.innerHTML = dataUrlPenyidik;
              // alert('Berhasil menyimpan tanda tangan!');
              Swal.fire({
                  title: "Tanda tangan penyidik berhasil disimpan",
                  icon: "success",
                  timer: 1500,
                  timerProgressBar: true,
              });
              document.getElementById("sig-check-penyidik").style.display = "block";
              console.log('ttd penyidik' + dataUrlPenyidik);
              // var ttd = dataUrl;
              // sigImage.setAttribute("src", dataUrl);
          }, false);
      }

  })();
