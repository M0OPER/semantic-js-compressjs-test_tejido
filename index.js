window.addEventListener("load", function () {
  const form = document.querySelector("form");

  form.addEventListener("submit", function (e) {
    e.preventDefault();
    const files = form.querySelector('[type="file"]').files;
    const promises = [];
    var formData = new FormData();

    for (let file of files) {
      promises.push(
        new Promise(function (resolve, reject) {
          new Compressor(file, {
            quality: 0.6,
            success(result) {
              if (result["type"] != "image/jpeg") {
                //MENSAJE FLASH
                $("body").toast({
                  title: "Error",
                  class: "error",
                  position: "bottom attached",
                  message: "Verifica que todos los archivos sean jpg",
                });
                reject();
              } else {
                formData.append("files[]", result);
                resolve();
              }
            },
            error(err) {
              console.log(err.message);
              reject();
            },
          });
        })
      );
    }

    //AJAX XHR
    Promise.all(promises).then(() => {
      var ajax = new XMLHttpRequest();
      ajax.open("POST", "files-handler.php", true);
      ajax.send(formData);
      ajax.onload = function () {
        if (ajax.readyState === ajax.DONE) {
          if (ajax.status === 200) {
            res = JSON.parse(this.response);
            if (res.res == true) {
              //MENSAJE FLASH
              $("body").toast({
                title: "CORRECTO",
                class: "success",
                position: "bottom attached",
                message: res.men,
              });
              form.reset();
            } else {
              //MENSAJE FLASH
              $("body").toast({
                title: "ERROR",
                class: "error",
                position: "bottom attached",
                message: res.men,
              });
            }
          } else {
            //MENSAJE FLASH
            $("body").toast({
              title: "Error",
              class: "error",
              position: "bottom attached",
              message: "Error dentro del servidor",
            });
          }
        }
      };
    });
  });
});
