window.addEventListener("load", function () {
  var app = new Vue({
    el: "#app",
    data: {
      windowStatus: 0,
      window: {
        0: {
          buttons: [
            {
              class: "btn2-city",
              img: "./img/si.png",
              label: "Sístema de Información",
              action: {
                type: "navigate",
                to: './si'
              }
            },
            {
              class: "btn2-city",
              img: "./img/game.png",
              label: "Valle Mágico",
              action: {
                type: "navigate",
                to: 0
              }
            }
          ]
        },
      }
    },
    methods: {
      btnOnAction: action => {
        var type = action.type;
        var to = action.to;
        if (type === "navigate") {
          window.location = to;
        } else if (type === "window") {
          app.windowStatus = to;
        }
      },
      goHome: () => {
        app.windowStatus = 0;
      }
    }
  });
});
