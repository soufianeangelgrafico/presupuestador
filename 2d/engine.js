document.querySelector("#lin").addEventListener("mouseup", _MOUSEUP);
document.querySelector("#lin").addEventListener(
  "mousemove",
  throttle(function (event) {
    _MOUSEMOVE(event);
  }, 30)
);
document.querySelector("#lin").addEventListener("mousedown", _MOUSEDOWN, true);

//Version tactil
document.querySelector("#lin").addEventListener("touchend", _MOUSEUP);
document.querySelector("#lin").addEventListener(
  "touchmove",
  throttle(function (event) {
    _MOUSEMOVE(event);
  }, 30)
);
document.querySelector("#lin").addEventListener("touchstart", _MOUSEDOWN, true);

$(document).on("click", "#lin", function (event) {
  event.preventDefault();
});

$(document).on("touchstart", "#lin", function (event) {
  event.preventDefault();
});

/*
var scrollOffsets = (function () {
    var w = window;

    // This works for all browsers except IE versions 8 and before
    if (w.pageXOffset != null) return {x: w.pageXOffset, y:w.pageYOffset};
    // For IE (or any browser) in Standards mode
    var d = w.document;
    if (document.compatMode == "CSS1Compat")
    return {x:d.documentElement.scrollLeft, y:d.documentElement.scrollTop};
    // For browsers in Quirks mode
    return { x: d.body.scrollLeft, y: d.body.scrollTop };
}());
*/
document
  .querySelector("#panel")
  .addEventListener("mousemove", function (event) {
    if ((mode == "line_mode" || mode == "partition_mode") && action == 1) {
      action = 0;
      if (typeof binder != "undefined") {
        binder.remove();
        delete binder;
      }
      $("#linetemp").remove();
      $("#line_construc").remove();
      lengthTemp.remove();
      delete lengthTemp;
    }
  });

window.addEventListener("resize", function (event) {
  width_viewbox = $("#lin").width();
  height_viewbox = $("#lin").height();
  document
    .querySelector("#lin")
    .setAttribute(
      "viewBox",
      originX_viewbox +
        " " +
        originY_viewbox +
        " " +
        width_viewbox +
        " " +
        height_viewbox
    );
});

// *****************************************************************************************************
// ******************************        KEYPRESS on KEYBOARD          *********************************
// *****************************************************************************************************

/*
COMENTO PARA EVITAR ERROR AL CALCULAR DISTANCIA D OBJETOS
document.addEventListener("keydown", function(event) {
    if (mode != "text_mode") {
      if (event.keyCode == '37') {
          //LEFT
          zoom_maker('zoomleft', 100, 30);
      }
      if (event.keyCode == '38') {
          //UP
          zoom_maker('zoomtop', 100, 30);
      }
      if (event.keyCode == '39') {
          //RIGHT
          zoom_maker('zoomright', 100, 30);
      }
      if (event.keyCode == '40') {
          //DOWN
          zoom_maker('zoombottom', 100, 30);
      }
      if (event.keyCode == '107') {
          //+
          zoom_maker('zoomin', 20, 50);
      }
      if (event.keyCode == '109') {
          //-
          zoom_maker('zoomout', 20, 50);
      }
    }
    // else {
    //   if (action == 1) {
    //     binder.textContent = binder.textContent + event.key;
    //     console.log(field.value);
    //   }
    // }
});

*/
// *****************************************************************************************************
// ******************************        MOUSE MOVE          *******************************************
// *****************************************************************************************************

function _MOUSEMOVE(event) {
  event.preventDefault();
  $(".sub").hide(100);

  //**************************************************************************
  //********************   TEXTE   MODE **************************************
  //**************************************************************************
  if (mode == "text_mode") {
    snap = calcul_snap(event, grid_snap);
    if (action == 0) cursor("text");
    else {
      cursor("none");
    }
  }

  //**************************************************************************
  //**************        OBJECT   MODE **************************************
  //**************************************************************************
  if (mode == "object_mode") {
    snap = calcul_snap(event, grid_snap);
    if (typeof binder == "undefined") {
      $("#object_list").hide(200);
      if (modeOption == "simpleStair")
        binder = new editor.obj2D(
          "free",
          "stair",
          "simpleStair",
          snap,
          0,
          0,
          0,
          "normal",
          0,
          15
        );
      else {
        var typeObj = modeOption;
        binder = new editor.obj2D(
          "free",
          "energy",
          typeObj,
          snap,
          0,
          0,
          0,
          "normal",
          0
        );
      }

      $("#boxbind").append(binder.graph);
    } else {
      if (
        ((binder.family != "stick" && binder.family != "collision") ||
          WALLS.length == 0) &&
        binder.type != "segment"
      ) {
        binder.x = snap.x;
        binder.y = snap.y;
        binder.oldX = binder.x;
        binder.oldY = binder.y;
        binder.update();
      }
      if (binder.family == "collision") {
        var found = false;

        if (editor.rayCastingWalls({ x: binder.bbox.left, y: binder.bbox.top }))
          found = true;
        if (
          !found &&
          editor.rayCastingWalls({ x: binder.bbox.left, y: binder.bbox.bottom })
        )
          found = true;
        if (
          !found &&
          editor.rayCastingWalls({ x: binder.bbox.right, y: binder.bbox.top })
        )
          found = true;
        if (
          !found &&
          editor.rayCastingWalls({
            x: binder.bbox.right,
            y: binder.bbox.bottom,
          })
        )
          found = true;

        if (!found) {
          binder.x = snap.x;
          binder.y = snap.y;
          binder.oldX = binder.x;
          binder.oldY = binder.y;
          binder.update();
        } else {
          binder.x = binder.oldX;
          binder.y = binder.oldY;
          binder.update();
        }
      }
      if (binder.family == "stick") {
        pos = editor.stickOnWall(snap);
        binder.oldX = pos.x;
        binder.oldY = pos.y;
        var angleWall = qSVG.angleDeg(
          pos.wall.start.x,
          pos.wall.start.y,
          pos.wall.end.x,
          pos.wall.end.y
        );
        var v1 = qSVG.vectorXY(
          { x: pos.wall.start.x, y: pos.wall.start.y },
          { x: pos.wall.end.x, y: pos.wall.end.y }
        );
        var v2 = qSVG.vectorXY({ x: pos.wall.end.x, y: pos.wall.end.y }, snap);
        binder.x =
          pos.x -
          (Math.sin(pos.wall.angle * ((360 / 2) * Math.PI)) * binder.thick) / 2;
        binder.y =
          pos.y -
          (Math.cos(pos.wall.angle * ((360 / 2) * Math.PI)) * binder.thick) / 2;
        var newAngle = qSVG.vectorDeter(v1, v2);
        if (Math.sign(newAngle) == 1) {
          angleWall += 180;
          binder.x =
            pos.x +
            (Math.sin(pos.wall.angle * ((360 / 2) * Math.PI)) * binder.thick) /
              2;
          binder.y =
            pos.y +
            (Math.cos(pos.wall.angle * ((360 / 2) * Math.PI)) * binder.thick) /
              2;
        }
        binder.angle = angleWall;
        binder.update();
      }
    }
  }

  //**************************************************************************
  //**************        DISTANCE MODE **************************************
  //**************************************************************************
  if (mode == "distance_mode") {
    console.log("Entro en distance_mode");
    snap = calcul_snap(event, grid_snap);
    if (typeof binder == "undefined") {
      cross = qSVG.create("boxbind", "path", {
        d: "M-3000,0 L3000,0 M0,-3000 L0,3000",
        "stroke-width": 0.5,
        "stroke-opacity": "0.8",
        stroke: "#e2b653",
        fill: "#e2b653",
      });
      binder = new editor.obj2D(
        "free",
        "measure",
        "",
        { x: 0, y: 0 },
        0,
        0,
        0,
        "normal",
        0,
        ""
      );
      labelMeasure = qSVG.create("none", "text", {
        x: 0,
        y: -10,
        "font-size": "1.2em",
        stroke: "#ffffff",
        "stroke-width": "0.4px",
        "font-family": "roboto",
        "text-anchor": "middle",
        fill: "#3672d9",
      });
      binder.graph.append(labelMeasure);
      $("#boxbind").append(binder.graph);
    } else {
      x = snap.x;
      y = snap.y;
      cross.attr({
        transform: "translate(" + snap.x + "," + snap.y + ")",
      });
      if (action == 1) {
        var startText = qSVG.middle(pox, poy, x, y);
        var angleText = qSVG.angle(pox, poy, x, y);
        var valueText = qSVG.measure(
          {
            x: pox,
            y: poy,
          },
          {
            x: x,
            y: y,
          }
        );
        binder.size = valueText;
        binder.x = startText.x;
        binder.y = startText.y;
        binder.angle = angleText.deg;
        valueText = (valueText / meter).toFixed(2) + " m";
        labelMeasure.context.textContent = valueText;
        binder.update();
      }
    }
  }

  //**************************************************************************
  //**************        ROOM MODE *****************************************
  //**************************************************************************

  if (mode == "room_mode") {
    snap = calcul_snap(event, grid_snap);
    var roomTarget;
    if ((roomTarget = editor.rayCastingRoom(snap))) {
      if (typeof binder != "undefined") {
        binder.remove();
        delete binder;
      }

      var pathSurface = roomTarget.coords;
      var pathCreate = "M" + pathSurface[0].x + "," + pathSurface[0].y;
      for (var p = 1; p < pathSurface.length - 1; p++) {
        pathCreate =
          pathCreate + " " + "L" + pathSurface[p].x + "," + pathSurface[p].y;
      }
      pathCreate = pathCreate + "Z";

      if (roomTarget.inside.length > 0) {
        for (var ins = 0; ins < roomTarget.inside.length; ins++) {
          pathCreate =
            pathCreate +
            " M" +
            Rooms.polygons[roomTarget.inside[ins]].coords[
              Rooms.polygons[roomTarget.inside[ins]].coords.length - 1
            ].x +
            "," +
            Rooms.polygons[roomTarget.inside[ins]].coords[
              Rooms.polygons[roomTarget.inside[ins]].coords.length - 1
            ].y;
          for (
            var free = Rooms.polygons[roomTarget.inside[ins]].coords.length - 2;
            free > -1;
            free--
          ) {
            pathCreate =
              pathCreate +
              " L" +
              Rooms.polygons[roomTarget.inside[ins]].coords[free].x +
              "," +
              Rooms.polygons[roomTarget.inside[ins]].coords[free].y;
          }
        }
      }

      binder = qSVG.create("boxbind", "path", {
        id: "roomSelected",
        d: pathCreate,
        fill: "#c9c14c",
        "fill-opacity": 0.5,
        stroke: "#c9c14c",
        "fill-rule": "evenodd",
        "stroke-width": 3,
      });
      binder.type = "room";
      binder.area = roomTarget.area;
      binder.id = ROOM.indexOf(roomTarget);
    } else {
      if (typeof binder != "undefined") {
        binder.remove();
        delete binder;
      }
    }
  }

  //**************************************************************************
  //**************        DOOR/WINDOW MODE   *********************************
  //**************************************************************************

  if (mode == "door_mode") {
    snap = calcul_snap(event, grid_snap);
    if ((wallSelect = editor.nearWall(snap))) {
      var wall = wallSelect.wall;
      if (wall.type != "separate") {
        if (typeof binder == "undefined") {
          // family, classe, type, pos, angle, angleSign, size, hinge, thick
          binder = new editor.obj2D(
            "inWall",
            "doorWindow",
            modeOption,
            wallSelect,
            0,
            0,
            60,
            "normal",
            wall.thick
          );
          var angleWall = qSVG.angleDeg(
            wall.start.x,
            wall.start.y,
            wall.end.x,
            wall.end.y
          );
          var v1 = qSVG.vectorXY(
            { x: wall.start.x, y: wall.start.y },
            { x: wall.end.x, y: wall.end.y }
          );
          var v2 = qSVG.vectorXY({ x: wall.end.x, y: wall.end.y }, snap);
          var newAngle = qSVG.vectorDeter(v1, v2);
          if (Math.sign(newAngle) == 1) {
            angleWall += 180;
            binder.angleSign = 1;
          }
          var startCoords = qSVG.middle(
            wall.start.x,
            wall.start.y,
            wall.end.x,
            wall.end.y
          );
          binder.x = startCoords.x;
          binder.y = startCoords.y;
          binder.angle = angleWall;
          binder.update();
          $("#boxbind").append(binder.graph);
        } else {
          var angleWall = qSVG.angleDeg(
            wall.start.x,
            wall.start.y,
            wall.end.x,
            wall.end.y
          );
          var v1 = qSVG.vectorXY(
            { x: wall.start.x, y: wall.start.y },
            { x: wall.end.x, y: wall.end.y }
          );
          var v2 = qSVG.vectorXY({ x: wall.end.x, y: wall.end.y }, snap);
          var newAngle = qSVG.vectorDeter(v1, v2);
          binder.angleSign = 0;
          if (Math.sign(newAngle) == 1) {
            binder.angleSign = 1;
            angleWall += 180;
          }

          var limits = limitObj(wall.equations.base, binder.size, wallSelect);
          if (
            qSVG.btwn(limits[0].x, wall.start.x, wall.end.x) &&
            qSVG.btwn(limits[0].y, wall.start.y, wall.end.y) &&
            qSVG.btwn(limits[1].x, wall.start.x, wall.end.x) &&
            qSVG.btwn(limits[1].y, wall.start.y, wall.end.y)
          ) {
            binder.x = wallSelect.x;
            binder.y = wallSelect.y;
            binder.angle = angleWall;
            binder.thick = wall.thick;
            binder.limit = limits;
            binder.update();
          }

          if (
            (wallSelect.x == wall.start.x && wallSelect.y == wall.start.y) ||
            (wallSelect.x == wall.end.x && wallSelect.y == wall.end.y)
          ) {
            if (
              qSVG.btwn(limits[0].x, wall.start.x, wall.end.x) &&
              qSVG.btwn(limits[0].y, wall.start.y, wall.end.y)
            ) {
              binder.x = limits[0].x;
              binder.y = limits[0].y;
            }
            if (
              qSVG.btwn(limits[1].x, wall.start.x, wall.end.x) &&
              qSVG.btwn(limits[1].y, wall.start.y, wall.end.y)
            ) {
              binder.x = limits[1].x;
              binder.y = limits[1].y;
            }
            binder.limit = limits;
            binder.angle = angleWall;
            binder.thick = wall.thick;
            binder.update();
          }
        }
      }
    } else {
      if (typeof binder != "undefined") {
        binder.graph.remove();
        delete binder;
      }
    }
  } // END DOOR MODE

  //**************************************************************************
  //**************        NODE MODE *****************************************
  //**************************************************************************

  if (mode == "node_mode") {
    snap = calcul_snap(event, grid_snap);
    console.log("Entro en node_mode");
    if (typeof binder == "undefined") {
      if ((addNode = editor.nearWall(snap, 30))) {
        var x2 = addNode.wall.end.x;
        var y2 = addNode.wall.end.y;
        var x1 = addNode.wall.start.x;
        var y1 = addNode.wall.start.y;
        angleWall = qSVG.angle(x1, y1, x2, y2);
        binder = qSVG.create("boxbind", "path", {
          id: "circlebinder",
          d: "M-20,-10 L-13,0 L-20,10 Z M-13,0 L13,0 M13,0 L20,-10 L20,10 Z",
          stroke: "#04A8BB",
          fill: "#04A8BB",
          "stroke-width": "1.5px",
        });
        binder.attr({
          transform:
            "translate(" +
            addNode.x +
            "," +
            addNode.y +
            ") rotate(" +
            (angleWall.deg + 90) +
            ",0,0)",
        });
        binder.data = addNode;
        binder.x1 = x1;
        binder.x2 = x2;
        binder.y1 = y1;
        binder.y2 = y2;
      }
    } else {
      if ((addNode = editor.nearWall(snap, 30))) {
        if (addNode) {
          var x2 = addNode.wall.end.x;
          var y2 = addNode.wall.end.y;
          var x1 = addNode.wall.start.x;
          var y1 = addNode.wall.start.y;
          angleWall = qSVG.angle(x1, y1, x2, y2);
          binder.attr({
            transform:
              "translate(" +
              addNode.x +
              "," +
              addNode.y +
              ") rotate(" +
              (angleWall.deg + 90) +
              ",0,0)",
          });
          binder.data = addNode;
          console.log("Entro<");
        } else {
          binder.remove();
          delete binder;
        }
      } else {
        binder.remove();
        delete binder;
      }
    }
  } // END NODE MODE

  //**********************************  SELECT MODE ***************************************************************
  if (mode == "select_mode" && drag == "off") {
    // FIRST TEST ON SELECT MODE (and drag OFF) to detect MOUSEOVER DOOR
    //console.log("ES OFF!");
    snap = calcul_snap(event, "off");

    var objTarget = false;
    //console.log("Length de los objetos es "+OBJDATA.length);
    for (var i = 0; i < OBJDATA.length; i++) {
      console.log("Vemos que tiene OBJDAta de i");
      console.log(OBJDATA[i]);
      console.log("El tipo es");
      console.log(OBJDATA[i].type);

      if (OBJDATA[i].type != "segment") {
        var objX1 = OBJDATA[i].bbox.left;
        var objX2 = OBJDATA[i].bbox.right;
        var objY1 = OBJDATA[i].bbox.top;
        var objY2 = OBJDATA[i].bbox.bottom;
        var realBboxCoords = OBJDATA[i].realBbox;
        if (qSVG.rayCasting(snap, realBboxCoords)) {
          objTarget = OBJDATA[i];
        }
      }
    }
    if (objTarget !== false) {
      if (typeof binder != "undefined" && binder.type == "segment") {
        binder.graph.remove();
        delete binder;
        cursor("default");
      }
      if (objTarget.params.bindBox) {
        // OBJ -> BOUNDINGBOX TOOL
        // alert("XX");
        if (typeof binder == "undefined") {
          binder = new editor.obj2D(
            "free",
            "boundingBox",
            "",
            objTarget.bbox.origin,
            objTarget.angle,
            0,
            objTarget.size,
            "normal",
            objTarget.thick,
            objTarget.realBbox
          );
          binder.update();
          binder.obj = objTarget;
          binder.type = "boundingBox";
          binder.oldX = binder.x;
          binder.oldY = binder.y;
          $("#boxbind").append(binder.graph);
          if (!objTarget.params.move) cursor("trash"); // LIKE MEASURE ON PLAN
          if (objTarget.params.move) cursor("move");
        }
      } else {
        // DOOR, WINDOW, APERTURE.. -- OBJ WITHOUT BINDBOX (params.bindBox = False) -- !!!!
        if (typeof binder == "undefined") {
          var wallList = editor.rayCastingWall(objTarget);
          if (wallList.length > 1) wallList = wallList[0];
          inWallRib(wallList);
          var thickObj = wallList.thick;
          var sizeObj = objTarget.size;

          binder = new editor.obj2D(
            "inWall",
            "socle",
            "",
            objTarget,
            objTarget.angle,
            0,
            sizeObj,
            "normal",
            thickObj
          );
          binder.update();

          binder.oldXY = { x: objTarget.x, y: objTarget.y }; // FOR OBJECT MENU
          $("#boxbind").append(binder.graph);
        } else {
          if (event.target == binder.graph.get(0).firstChild) {
            cursor("move");
            binder.graph
              .get(0)
              .firstChild.setAttribute("class", "circle_css_2");
            binder.type = "obj";
            binder.obj = objTarget;
          } else {
            cursor("default");
            binder.graph
              .get(0)
              .firstChild.setAttribute("class", "circle_css_1");
            binder.type = false;
          }
        }

        //Hago que me muestre las medidas de todos los elementos de puertas y ventanas
        for (var i in WALLS) {
          inWallRib(WALLS[i], "all");
        }
      }
    } else {
      if (typeof binder != "undefined") {
        if (typeof binder.graph != "undefined") binder.graph.remove();
        else binder.remove();
        delete binder;
        cursor("default");
        rib();
      }
    }

    // BIND CIRCLE IF nearNode and GROUP ALL SAME XY SEG POINTS
    if ((wallNode = editor.nearWallNode(snap, 2))) {
      if (typeof binder == "undefined" || binder.type == "segment") {
        binder = qSVG.create("boxbind", "circle", {
          id: "circlebinder",
          class: "circle_css_2",
          cx: wallNode.x,
          cy: wallNode.y,
          r: Rcirclebinder,
        });
        binder.data = wallNode;
        binder.type = "node";
        if ($("#linebinder").length) $("#linebinder").remove();
      } else {
        // REMAKE CIRCLE_CSS ON BINDER AND TAKE DATA SEG GROUP
        // if (typeof(binder) != 'undefined') {
        //     binder.attr({
        //         class: "circle_css_2"
        //     });
        // }
      }
      cursor("move");
    } else {
      if (typeof binder != "undefined" && binder.type == "node") {
        binder.remove();
        delete binder;
        hideAllSize();
        cursor("default");
        rib();
      }
    }

    // BIND WALL WITH NEARPOINT function ---> WALL BINDER CREATION
    if ((wallBind = editor.rayCastingWalls(snap, WALLS))) {
      console.log("Length de Wallbind " + wallBind.length);

      if (wallBind.length > 1) wallBind = wallBind[wallBind.length - 1];
      if (wallBind && typeof binder == "undefined") {
        var objWall = editor.objFromWall(wallBind);
        if (objWall.length > 0) editor.inWallRib2(wallBind);
        binder = {};
        binder.wall = wallBind;
        inWallRib(binder.wall);
        var line = qSVG.create("none", "line", {
          x1: binder.wall.start.x,
          y1: binder.wall.start.y,
          x2: binder.wall.end.x,
          y2: binder.wall.end.y,
          "stroke-width": 5,
          stroke: "#04A8BB",
        });
        var ball1 = qSVG.create("none", "circle", {
          class: "circle_css",
          cx: binder.wall.start.x,
          cy: binder.wall.start.y,
          r: Rcirclebinder / 1.8,
        });
        var ball2 = qSVG.create("none", "circle", {
          class: "circle_css",
          cx: binder.wall.end.x,
          cy: binder.wall.end.y,
          r: Rcirclebinder / 1.8,
        });
        binder.graph = qSVG.create("none", "g");
        binder.graph.append(line);
        binder.graph.append(ball1);
        binder.graph.append(ball2);
        $("#boxbind").append(binder.graph);
        binder.type = "segment";
        cursor("pointer");
      }
    } else {
      if ((wallBind = editor.nearWall(snap, 6))) {
        console.log("WallBind else");
        console.log(wallBind);
        console.log("Snap Wallbind");
        console.log(snap);

        if (wallBind && typeof binder == "undefined") {
          wallBind = wallBind.wall;
          var objWall = editor.objFromWall(wallBind);
          if (objWall.length > 0) editor.inWallRib2(wallBind);
          binder = {};
          binder.wall = wallBind;
          inWallRib(binder.wall);
          var line = qSVG.create("none", "line", {
            x1: binder.wall.start.x,
            y1: binder.wall.start.y,
            x2: binder.wall.end.x,
            y2: binder.wall.end.y,
            "stroke-width": 5,
            stroke: "#04A8BB",
          });
          var ball1 = qSVG.create("none", "circle", {
            class: "circle_css",
            cx: binder.wall.start.x,
            cy: binder.wall.start.y,
            r: Rcirclebinder / 1.8,
          });
          var ball2 = qSVG.create("none", "circle", {
            class: "circle_css",
            cx: binder.wall.end.x,
            cy: binder.wall.end.y,
            r: Rcirclebinder / 1.8,
          });
          binder.graph = qSVG.create("none", "g");
          binder.graph.append(line);
          binder.graph.append(ball1);
          binder.graph.append(ball2);
          $("#boxbind").append(binder.graph);
          binder.type = "segment";
          cursor("pointer");
        }
      } else {
        //console.log("Type of de binder es "+typeof(binder)+" y el tipo es "+binder.type);
        //Esto devuelve: engine.js:614 Uncaught ReferenceError: binder is not defined
        //Y se queda marcada la línea del muro como seleccionada.

        if (typeof binder != "undefined" && binder.type == "segment") {
          binder.graph.remove();
          delete binder;
          hideAllSize();
          cursor("default");
          rib();
        }
        //! No sé para qué es, pero no deja mostrar el objeto seleccionado
        /*
            else 
            {
               //Es undefined
              hideAllSize();
              cursor('default');
              rib();
            } */
      }
    }

    //Actualizo información (medidas) de los muros, si no, las medidas de las puertas y ventanas no aparecen
    //Solo aparecerían si te pones encima de ellas (mouseover)
    for (var i in WALLS) {
      inWallRib(WALLS[i], "all");
    }

    //Reinicio el target para que no se quede el último elemento
    //objTarget = false;
  } // END mode == 'select_mode' && drag == 'off'

  // ------------------------------  LINE MODE ------------------------------------------------------

  if ((mode == "line_mode" || mode == "partition_mode") && action == 0) {
    snap = calcul_snap(event, "off");
    cursor("grab");
    pox = snap.x;
    poy = snap.y;
    if ((helpConstruc = intersection(snap, 25))) {
      if (helpConstruc.distance < 10) {
        pox = helpConstruc.x;
        poy = helpConstruc.y;
        cursor("grab");
      } else {
        cursor("crosshair");
      }
    }
    if ((wallNode = editor.nearWallNode(snap, 20))) {
      pox = wallNode.x;
      poy = wallNode.y;
      cursor("grab");
      if (typeof binder == "undefined") {
        binder = qSVG.create("boxbind", "circle", {
          id: "circlebinder",
          class: "circle_css_2",
          cx: wallNode.x,
          cy: wallNode.y,
          r: Rcirclebinder / 1.5,
        });
      }
      intersectionOff();
    } else {
      if (!helpConstruc) cursor("crosshair");
      if (typeof binder != "undefined") {
        if (binder.graph) binder.graph.remove();
        else binder.remove();
        delete binder;
      }
    }
  }

  // ******************************************************************************************************
  // ************************** ACTION = 1   LINE MODE => WALL CREATE                 *********************
  // ******************************************************************************************************

  if (action == 1 && (mode == "line_mode" || mode == "partition_mode")) {
    snap = calcul_snap(event, grid_snap);
    x = snap.x;
    y = snap.y;
    starter = minMoveGrid(snap);

    if (!$("#line_construc").length) {
      if ((wallNode = editor.nearWallNode(snap, 20))) {
        pox = wallNode.x;
        poy = wallNode.y;

        wallStartConstruc = false;
        if (wallNode.bestWall == WALLS.length - 1) {
          cursor("validation");
        } else {
          cursor("grab");
        }
      } else {
        cursor("crosshair");
      }
    }

    if (starter > grid) {
      if (!$("#line_construc").length) {
        var ws = 5; //antes 20
        if (mode == "partition_mode") ws = 5; //antes 10
        lineconstruc = qSVG.create("boxbind", "line", {
          id: "line_construc",
          x1: pox,
          y1: poy,
          x2: x,
          y2: y,
          "stroke-width": ws,
          "stroke-linecap": "butt",
          "stroke-opacity": 0.7,
          stroke: "#9fb2e2",
        });

        svgadd = qSVG.create("boxbind", "line", {
          // ORANGE TEMP LINE FOR ANGLE 0 90 45 -+
          id: "linetemp",
          x1: pox,
          y1: poy,
          x2: x,
          y2: y,
          stroke: "transparent",
          "stroke-width": 0.5,
          "stroke-opacity": "0.9",
        });
      } else {
        // THE LINES AND BINDER ARE CREATED

        $("#linetemp").attr({
          x2: x,
          y2: y,
        });

        if ((helpConstrucEnd = intersection(snap, 10))) {
          x = helpConstrucEnd.x;
          y = helpConstrucEnd.y;
        }
        if ((wallEndConstruc = editor.nearWall(snap, 12))) {
          // TO SNAP SEGMENT TO FINALIZE X2Y2
          x = wallEndConstruc.x;
          y = wallEndConstruc.y;
          cursor("grab");
        } else {
          cursor("crosshair");
        }

        // nearNode helped to attach the end of the construc line
        if ((wallNode = editor.nearWallNode(snap, 20))) {
          if (typeof binder == "undefined") {
            binder = qSVG.create("boxbind", "circle", {
              id: "circlebinder",
              class: "circle_css_2",
              cx: wallNode.x,
              cy: wallNode.y,
              r: Rcirclebinder / 1.5,
            });
          }
          $("#line_construc").attr({
            x2: wallNode.x,
            y2: wallNode.y,
          });
          x = wallNode.x;
          y = wallNode.y;
          wallEndConstruc = true;
          intersectionOff();
          //if (wallNode.bestWall == WALLS.length-1 && document.getElementById("multi").checked)
          if (wallNode.bestWall == WALLS.length - 1) {
            cursor("validation");
          } else {
            cursor("grab");
          }
        } else {
          if (typeof binder != "undefined") {
            binder.remove();
            delete binder;
          }
          if (wallEndConstruc === false) cursor("crosshair");
        }
        // LINETEMP AND LITLLE SNAPPING FOR HELP TO CONSTRUC ANGLE 0 90 45 *****************************************
        var fltt = qSVG.angle(pox, poy, x, y);
        var flt = Math.abs(fltt.deg);
        var coeff = fltt.deg / flt; // -45 -> -1     45 -> 1
        var phi = poy - coeff * pox;
        var Xdiag = (y - phi) / coeff;
        if (typeof binder == "undefined") {
          // HELP FOR H LINE
          var found = false;
          if (flt < 15 && Math.abs(poy - y) < 25) {
            y = poy;
            found = true;
          } // HELP FOR V LINE
          if (flt > 75 && Math.abs(pox - x) < 25) {
            x = pox;
            found = true;
          } // HELP FOR DIAG LINE
          if (flt < 55 && flt > 35 && Math.abs(Xdiag - x) < 20) {
            x = Xdiag;
            found = true;
          }
          if (found) $("#line_construc").attr({ "stroke-opacity": 1 });
          else $("#line_construc").attr({ "stroke-opacity": 0.7 });
        }
        $("#line_construc").attr({
          x2: x,
          y2: y,
        });

        // SHOW WALL SIZE -------------------------------------------------------------------------
        // console.log("Wall size - Aquí calcula los m2 cuando estás creando la línea - Distance");
        //console.log(qSVG.pDistance);
        //console.log("Wall size - measure");
        //console.log(qSVG.measure);
        //console.log("Wall size - área");
        //console.log(qSVG.area);

        var startText = qSVG.middle(pox, poy, x, y);
        var angleText = qSVG.angle(pox, poy, x, y);
        var valueText = (
          qSVG.measure(
            {
              x: pox,
              y: poy,
            },
            {
              x: x,
              y: y,
            }
          ) / 60
        ).toFixed(2);
        if (typeof lengthTemp == "undefined") {
          lengthTemp = document.createElementNS(
            "http://www.w3.org/2000/svg",
            "text"
          );
          lengthTemp.setAttributeNS(null, "x", startText.x);
          lengthTemp.setAttributeNS(null, "y", startText.y - 15);
          lengthTemp.setAttributeNS(null, "text-anchor", "middle");
          lengthTemp.setAttributeNS(null, "stroke", "none");
          lengthTemp.setAttributeNS(null, "stroke-width", "0.6px");
          lengthTemp.setAttributeNS(null, "fill", "#777777");
          lengthTemp.textContent = valueText + "m";
          $("#boxbind").append(lengthTemp);
        }
        if (typeof lengthTemp != "undefined" && valueText > 0.1) {
          lengthTemp.setAttributeNS(null, "x", startText.x);
          lengthTemp.setAttributeNS(null, "y", startText.y - 15);
          lengthTemp.setAttribute(
            "transform",
            "rotate(" +
              angleText.deg +
              " " +
              startText.x +
              "," +
              startText.y +
              ")"
          );
          lengthTemp.textContent = valueText + " m";
        }
        if (typeof lengthTemp != "undefined" && valueText < 0.1) {
          lengthTemp.textContent = "";
        }
      }
    }
  } // END LINE MODE DETECT && ACTION = 1

  //ONMOVE
  // **************************************************************************************************
  //        ____ ___ _   _ ____  _____ ____
  //        | __ )_ _| \ | |  _ \| ____|  _ \
  //        |  _ \| ||  \| | | | |  _| | |_) |
  //        | |_) | || |\  | |_| | |___|  _ <
  //        |____/___|_| \_|____/|_____|_| \_\
  //
  // **************************************************************************************************

  if (mode == "bind_mode") {
    snap = calcul_snap(event, grid_snap);

    if (binder.type == "node") {
      var coords = snap;
      var magnetic = false;
      for (var k in wallListRun) {
        if (isObjectsEquals(wallListRun[k].end, binder.data)) {
          if (Math.abs(wallListRun[k].start.x - snap.x) < 20) {
            coords.x = wallListRun[k].start.x;
            magnetic = "H";
          }
          if (Math.abs(wallListRun[k].start.y - snap.y) < 20) {
            coords.y = wallListRun[k].start.y;
            magnetic = "V";
          }
        }
        if (isObjectsEquals(wallListRun[k].start, binder.data)) {
          if (Math.abs(wallListRun[k].end.x - snap.x) < 20) {
            coords.x = wallListRun[k].end.x;
            magnetic = "H";
          }
          if (Math.abs(wallListRun[k].end.y - snap.y) < 20) {
            coords.y = wallListRun[k].end.y;
            magnetic = "V";
          }
        }
      }

      if ((nodeMove = editor.nearWallNode(snap, 15, wallListRun))) {
        coords.x = nodeMove.x;
        coords.y = nodeMove.y;
        $("#circlebinder").attr({
          class: "circleGum",
          cx: coords.x,
          cy: coords.y,
        });
        cursor("grab");
      } else {
        if (magnetic != false) {
          if (magnetic == "H") snap.x = coords.x;
          else snap.y = coords.y;
        }
        if ((helpConstruc = intersection(snap, 10, wallListRun))) {
          coords.x = helpConstruc.x;
          coords.y = helpConstruc.y;
          snap.x = helpConstruc.x;
          snap.y = helpConstruc.y;
          if (magnetic != false) {
            if (magnetic == "H") snap.x = coords.x;
            else snap.y = coords.y;
          }
          cursor("grab");
        } else {
          cursor("move");
        }
        $("#circlebinder").attr({
          class: "circle_css",
          cx: coords.x,
          cy: coords.y,
        });
      }
      for (var k in wallListRun) {
        if (isObjectsEquals(wallListRun[k].start, binder.data)) {
          wallListRun[k].start.x = coords.x;
          wallListRun[k].start.y = coords.y;
        }
        if (isObjectsEquals(wallListRun[k].end, binder.data)) {
          wallListRun[k].end.x = coords.x;
          wallListRun[k].end.y = coords.y;
        }
      }
      binder.data = coords;
      editor.wallsComputing(WALLS, false); // UPDATE FALSE

      for (var k in wallListObj) {
        var wall = wallListObj[k].wall;
        var objTarget = wallListObj[k].obj;
        var angleWall = qSVG.angleDeg(
          wall.start.x,
          wall.start.y,
          wall.end.x,
          wall.end.y
        );
        var limits = limitObj(
          wall.equations.base,
          2 * wallListObj[k].distance,
          wallListObj[k].from
        ); // COORDS OBJ AFTER ROTATION
        var indexLimits = 0;
        if (
          qSVG.btwn(limits[1].x, wall.start.x, wall.end.x) &&
          qSVG.btwn(limits[1].y, wall.start.y, wall.end.y)
        )
          indexLimits = 1;
        // NEW COORDS OBJDATA[obj]
        objTarget.x = limits[indexLimits].x;
        objTarget.y = limits[indexLimits].y;
        objTarget.angle = angleWall;
        if (objTarget.angleSign == 1) objTarget.angle = angleWall + 180;

        var limitBtwn = limitObj(
          wall.equations.base,
          objTarget.size,
          objTarget
        ); // OBJ SIZE OK BTWN xy1/xy2

        if (
          qSVG.btwn(limitBtwn[0].x, wall.start.x, wall.end.x) &&
          qSVG.btwn(limitBtwn[0].y, wall.start.y, wall.end.y) &&
          qSVG.btwn(limitBtwn[1].x, wall.start.x, wall.end.x) &&
          qSVG.btwn(limitBtwn[1].y, wall.start.y, wall.end.y)
        ) {
          objTarget.limit = limitBtwn;
          objTarget.update();
        } else {
          objTarget.graph.remove();
          delete objTarget;
          OBJDATA.splice(wall.indexObj, 1);
          wallListObj.splice(k, 1);
        }
      }
      // for (k in toClean)
      $("#boxRoom").empty();
      $("#boxSurface").empty();
      Rooms = qSVG.polygonize(WALLS);
      editor.roomMaker(Rooms);
    }

    // WALL MOVING ----BINDER TYPE SEGMENT-------- FUNCTION FOR H,V and Calculate Vectorial Translation

    if (binder.type == "segment" && action == 1) {
      rib();

      if (equation2.A == "v") {
        equation2.B = snap.x;
      } else if (equation2.A == "h") {
        equation2.B = snap.y;
      } else {
        equation2.B = snap.y - snap.x * equation2.A;
      }

      var intersection1 = qSVG.intersectionOfEquations(
        equation1,
        equation2,
        "obj"
      );
      var intersection2 = qSVG.intersectionOfEquations(
        equation2,
        equation3,
        "obj"
      );
      var intersection3 = qSVG.intersectionOfEquations(
        equation1,
        equation3,
        "obj"
      );

      if (binder.wall.parent != null) {
        if (isObjectsEquals(binder.wall.parent.end, binder.wall.start))
          binder.wall.parent.end = intersection1;
        else if (isObjectsEquals(binder.wall.parent.start, binder.wall.start))
          binder.wall.parent.start = intersection1;
        else binder.wall.parent.end = intersection1;
      }

      if (binder.wall.child != null) {
        if (isObjectsEquals(binder.wall.child.start, binder.wall.end))
          binder.wall.child.start = intersection2;
        else if (isObjectsEquals(binder.wall.child.end, binder.wall.end))
          binder.wall.child.end = intersection2;
        else binder.wall.child.start = intersection2;
      }

      binder.wall.start = intersection1;
      binder.wall.end = intersection2;

      binder.graph[0].children[0].setAttribute("x1", intersection1.x);
      binder.graph[0].children[0].setAttribute("x2", intersection2.x);
      binder.graph[0].children[0].setAttribute("y1", intersection1.y);
      binder.graph[0].children[0].setAttribute("y2", intersection2.y);
      binder.graph[0].children[1].setAttribute("cx", intersection1.x);
      binder.graph[0].children[1].setAttribute("cy", intersection1.y);
      binder.graph[0].children[2].setAttribute("cx", intersection2.x);
      binder.graph[0].children[2].setAttribute("cy", intersection2.y);

      // THE EQ FOLLOWED BY eq (PARENT EQ1 --- CHILD EQ3)
      if (equation1.follow != undefined) {
        if (!qSVG.rayCasting(intersection1, equation1.backUp.coords)) {
          // IF OUT OF WALL FOLLOWED
          var distanceFromStart = qSVG.gap(
            equation1.backUp.start,
            intersection1
          );
          var distanceFromEnd = qSVG.gap(equation1.backUp.end, intersection1);
          if (distanceFromStart > distanceFromEnd) {
            // NEAR FROM End
            equation1.follow.end = intersection1;
          } else {
            equation1.follow.start = intersection1;
          }
        } else {
          equation1.follow.end = equation1.backUp.end;
          equation1.follow.start = equation1.backUp.start;
        }
      }
      if (equation3.follow != undefined) {
        if (!qSVG.rayCasting(intersection2, equation3.backUp.coords)) {
          // IF OUT OF WALL FOLLOWED
          var distanceFromStart = qSVG.gap(
            equation3.backUp.start,
            intersection2
          );
          var distanceFromEnd = qSVG.gap(equation3.backUp.end, intersection2);
          if (distanceFromStart > distanceFromEnd) {
            // NEAR FROM End
            equation3.follow.end = intersection2;
          } else {
            equation3.follow.start = intersection2;
          }
        } else {
          equation3.follow.end = equation3.backUp.end;
          equation3.follow.start = equation3.backUp.start;
        }
      }

      // EQ FOLLOWERS WALL MOVING
      for (var i = 0; i < equationFollowers.length; i++) {
        var intersectionFollowers = qSVG.intersectionOfEquations(
          equationFollowers[i].eq,
          equation2,
          "obj"
        );
        if (
          qSVG.btwn(
            intersectionFollowers.x,
            binder.wall.start.x,
            binder.wall.end.x,
            "round"
          ) &&
          qSVG.btwn(
            intersectionFollowers.y,
            binder.wall.start.y,
            binder.wall.end.y,
            "round"
          )
        ) {
          var size = qSVG.measure(
            equationFollowers[i].wall.start,
            equationFollowers[i].wall.end
          );
          if (equationFollowers[i].type == "start") {
            equationFollowers[i].wall.start = intersectionFollowers;
            if (size < 5) {
              if (equationFollowers[i].wall.child == null) {
                WALLS.splice(WALLS.indexOf(equationFollowers[i].wall), 1);
                equationFollowers.splice(i, 1);
              }
            }
          }
          if (equationFollowers[i].type == "end") {
            equationFollowers[i].wall.end = intersectionFollowers;
            if (size < 5) {
              if (equationFollowers[i].wall.parent == null) {
                WALLS.splice(WALLS.indexOf(equationFollowers[i].wall), 1);
                equationFollowers.splice(i, 1);
              }
            }
          }
        }
      }
      // WALL COMPUTING, BLOCK FAMILY OF BINDERWALL IF NULL (START OR END) !!!!!
      editor.wallsComputing(WALLS, "move");
      Rooms = qSVG.polygonize(WALLS);

      // OBJDATA(s) FOLLOW 90° EDGE SELECTED
      for (var rp = 0; rp < equationsObj.length; rp++) {
        var objTarget = equationsObj[rp].obj;
        var intersectionObj = qSVG.intersectionOfEquations(
          equationsObj[rp].eq,
          equation2
        );
        // NEW COORDS OBJDATA[o]
        objTarget.x = intersectionObj[0];
        objTarget.y = intersectionObj[1];
        var limits = limitObj(equation2, objTarget.size, objTarget);
        if (
          qSVG.btwn(limits[0].x, binder.wall.start.x, binder.wall.end.x) &&
          qSVG.btwn(limits[0].y, binder.wall.start.y, binder.wall.end.y) &&
          qSVG.btwn(limits[1].x, binder.wall.start.x, binder.wall.end.x) &&
          qSVG.btwn(limits[1].y, binder.wall.start.y, binder.wall.end.y)
        ) {
          objTarget.limit = limits;
          objTarget.update();
        }
      }
      // DELETING ALL OBJECT "INWALL" OVERSIZED INTO ITS EDGE (EDGE BY EDGE CONTROL)
      for (var k in WALLS) {
        var objWall = editor.objFromWall(WALLS[k]); // LIST OBJ ON EDGE
        for (var ob in objWall) {
          var objTarget = objWall[ob];
          var eq = editor.createEquationFromWall(WALLS[k]);
          var limits = limitObj(eq, objTarget.size, objTarget);
          if (
            !qSVG.btwn(limits[0].x, WALLS[k].start.x, WALLS[k].end.x) ||
            !qSVG.btwn(limits[0].y, WALLS[k].start.y, WALLS[k].end.y) ||
            !qSVG.btwn(limits[1].x, WALLS[k].start.x, WALLS[k].end.x) ||
            !qSVG.btwn(limits[1].y, WALLS[k].start.y, WALLS[k].end.y)
          ) {
            objTarget.graph.remove();
            delete objTarget;
            var indexObj = OBJDATA.indexOf(objTarget);
            OBJDATA.splice(indexObj, 1);
          }
        }
      }

      equationsObj = []; // REINIT eqObj -> MAYBE ONE OR PLUS OF OBJDATA REMOVED !!!!
      var objWall = editor.objFromWall(binder.wall); // LIST OBJ ON EDGE
      for (var ob = 0; ob < objWall.length; ob++) {
        var objTarget = objWall[ob];
        equationsObj.push({
          obj: objTarget,
          wall: binder.wall,
          eq: qSVG.perpendicularEquation(equation2, objTarget.x, objTarget.y),
        });
      }

      $("#boxRoom").empty();
      $("#boxSurface").empty();
      editor.roomMaker(Rooms);
      $("#lin").css("cursor", "pointer");
    }

    // **********************************************************************
    // ----------------------  BOUNDING BOX ------------------------------
    // **********************************************************************
    // binder.obj.params.move ---> FOR MEASURE DONT MOVE
    if (binder.type == "boundingBox" && action == 1 && binder.obj.params.move) {
      binder.x = snap.x;
      binder.y = snap.y;
      binder.obj.x = snap.x;
      binder.obj.y = snap.y;
      binder.obj.update();
      binder.update();
    }

    // **********************************************************************
    // OBJ MOVING
    // **********************************************************************
    if (binder.type == "obj" && action == 1) {
      console.log("Moviendo el objeto");
      if ((wallSelect = editor.nearWall(snap))) {
        if (wallSelect.wall.type != "separate") {
          inWallRib(wallSelect.wall);

          var objTarget = binder.obj;
          var wall = wallSelect.wall;
          var angleWall = qSVG.angleDeg(
            wall.start.x,
            wall.start.y,
            wall.end.x,
            wall.end.y
          );
          var v1 = qSVG.vectorXY(
            { x: wall.start.x, y: wall.start.y },
            { x: wall.end.x, y: wall.end.y }
          );
          var v2 = qSVG.vectorXY({ x: wall.end.x, y: wall.end.y }, snap);
          var newAngle = qSVG.vectorDeter(v1, v2);
          binder.angleSign = 0;
          objTarget.angleSign = 0;
          if (Math.sign(newAngle) == 1) {
            angleWall += 180;
            binder.angleSign = 1;
            objTarget.angleSign = 1;
          }
          var limits = limitObj(wall.equations.base, binder.size, wallSelect);
          if (
            qSVG.btwn(limits[0].x, wall.start.x, wall.end.x) &&
            qSVG.btwn(limits[0].y, wall.start.y, wall.end.y) &&
            qSVG.btwn(limits[1].x, wall.start.x, wall.end.x) &&
            qSVG.btwn(limits[1].y, wall.start.y, wall.end.y)
          ) {
            binder.x = wallSelect.x;
            binder.y = wallSelect.y;
            binder.angle = angleWall;
            binder.thick = wall.thick;
            objTarget.x = wallSelect.x;
            objTarget.y = wallSelect.y;
            objTarget.angle = angleWall;
            objTarget.thick = wall.thick;
            objTarget.limit = limits;
            binder.update();
            objTarget.update();
          }

          if (
            (wallSelect.x == wall.start.x && wallSelect.y == wall.start.y) ||
            (wallSelect.x == wall.end.x && wallSelect.y == wall.end.y)
          ) {
            if (
              qSVG.btwn(limits[0].x, wall.start.x, wall.end.x) &&
              qSVG.btwn(limits[0].y, wall.start.y, wall.end.y)
            ) {
              binder.x = limits[0].x;
              binder.y = limits[0].y;
              objTarget.x = limits[0].x;
              objTarget.y = limits[0].y;
              objTarget.limit = limits;
            }
            if (
              qSVG.btwn(limits[1].x, wall.start.x, wall.end.x) &&
              qSVG.btwn(limits[1].y, wall.start.y, wall.end.y)
            ) {
              binder.x = limits[1].x;
              binder.y = limits[1].y;
              objTarget.x = limits[1].x;
              objTarget.y = limits[1].y;
              objTarget.limit = limits;
            }
            binder.angle = angleWall;
            binder.thick = wall.thick;
            objTarget.angle = angleWall;
            objTarget.thick = wall.thick;
            binder.update();
            objTarget.update();
          }
        }
      }
    } // END OBJ MOVE
    if (binder.type != "obj" && binder.type != "segment") rib();
  }
  // ENDBIND ACTION MOVE **************************************************************************

  // ---DRAG VIEWBOX PANNING -------------------------------------------------------

  if (mode == "select_mode" && drag == "on") {
    snap = calcul_snap(event, grid_snap);
    $("#lin").css("cursor", "move");
    distX = (snap.xMouse - pox) * factor;
    distY = (snap.yMouse - poy) * factor;
    // pox = event.pageX;
    // poy = event.pageY;
    //Solo drag si tiras hacia los lados o hacia abajo no hacia arriba si no hay ningún muro creado
    //Esto es porque hacia arriba no pone bien los textos (hay un error con los valores Y negativos)
    //Es decir, si no dibujas nada y haces scroll hacia arriba y te pones a dibujar, las medidas las pone
    //En su lugar original en lugar de dónde tocan.

    if (document.getElementById("muro1")) zoom_maker("zoomdrag", distX, distY);
    else if (distY < 0) zoom_maker("zoomdrag", distX, distY);
  }
} // END MOUSEMOVE

// *****************************************************************************************************
// *****************************************************************************************************
// *****************************************************************************************************
// ******************************        MOUSE DOWN            *****************************************
// *****************************************************************************************************
// *****************************************************************************************************
// *****************************************************************************************************

function _MOUSEDOWN(event) {
  event.preventDefault();
  // *******************************************************************
  // **************************   DISTANCE MODE   **********************
  // *******************************************************************
  if (mode == "distance_mode") {
    if (action == 0) {
      action = 1;
      snap = calcul_snap(event, grid_snap);
      pox = snap.x;
      poy = snap.y;
    }
  }

  // *******************************************************************
  // *************************   LINE/WALL MODE   **********************
  // *******************************************************************
  if (mode == "line_mode" || mode == "partition_mode") {
    if (action == 0) {
      snap = calcul_snap(event, grid_snap);
      pox = snap.x;
      poy = snap.y;
      if ((wallStartConstruc = editor.nearWall(snap, 12))) {
        // TO SNAP SEGMENT TO FINALIZE X2Y2
        pox = wallStartConstruc.x;
        poy = wallStartConstruc.y;
      }
    } else {
      // FINALIZE LINE_++
      construc = 1;
    }
    action = 1;
  }
  if (mode == "edit_door_mode") {
    // ACTION 1 ACTIVATE EDITION OF THE DOOR
    action = 1;
    $("#lin").css("cursor", "pointer");
  }

  // *******************************************************************
  // **********************   SELECT MODE + BIND   *********************
  // *******************************************************************
  if (mode == "select_mode") {
    if (
      typeof binder != "undefined" &&
      (binder.type == "segment" ||
        binder.type == "node" ||
        binder.type == "obj" ||
        binder.type == "boundingBox")
    ) {
      mode = "bind_mode";

      if (binder.type == "obj") {
        action = 1;
      }

      if (binder.type == "boundingBox") {
        action = 1;
      }

      // INIT FOR HELP BINDER NODE MOVING H V (MOUSE DOWN)
      if (binder.type == "node") {
        $("#boxScale").hide(100);
        var node = binder.data;
        pox = node.x;
        poy = node.y;
        var nodeControl = { x: pox, y: poy };

        // DETERMINATE DISTANCE OF OPPOSED NODE ON EDGE(s) PARENT(s) OF THIS NODE !!!! NODE 1 -- NODE 2 SYSTE% :-(
        wallListObj = []; // SUPER VAR -- WARNING
        var objWall;
        wallListRun = [];
        for (var ee = WALLS.length - 1; ee > -1; ee--) {
          // SEARCH MOST YOUNG WALL COORDS IN NODE BINDER
          if (
            isObjectsEquals(WALLS[ee].start, nodeControl) ||
            isObjectsEquals(WALLS[ee].end, nodeControl)
          ) {
            wallListRun.push(WALLS[ee]);
            break;
          }
        }
        if (wallListRun[0].child != null) {
          if (
            isObjectsEquals(wallListRun[0].child.start, nodeControl) ||
            isObjectsEquals(wallListRun[0].child.end, nodeControl)
          )
            wallListRun.push(wallListRun[0].child);
        }
        if (wallListRun[0].parent != null) {
          if (
            isObjectsEquals(wallListRun[0].parent.start, nodeControl) ||
            isObjectsEquals(wallListRun[0].parent.end, nodeControl)
          )
            wallListRun.push(wallListRun[0].parent);
        }

        for (var k in wallListRun) {
          if (
            isObjectsEquals(wallListRun[k].start, nodeControl) ||
            isObjectsEquals(wallListRun[k].end, nodeControl)
          ) {
            var nodeTarget = wallListRun[k].start;
            if (isObjectsEquals(wallListRun[k].start, nodeControl)) {
              nodeTarget = wallListRun[k].end;
            }
            objWall = editor.objFromWall(wallListRun[k]); // LIST OBJ ON EDGE -- NOT INDEX !!!
            wall = wallListRun[k];
            for (var ob = 0; ob < objWall.length; ob++) {
              var objTarget = objWall[ob];
              var distance = qSVG.measure(objTarget, nodeTarget);
              wallListObj.push({
                wall: wall,
                from: nodeTarget,
                distance: distance,
                obj: objTarget,
                indexObj: ob,
              });
            }
          }
        }
        magnetic = 0;
        action = 1;
      }
      if (binder.type == "segment") {
        $("#boxScale").hide(100);
        var wall = binder.wall;
        binder.before = binder.wall.start;
        equation2 = editor.createEquationFromWall(wall);
        if (wall.parent != null) {
          equation1 = editor.createEquationFromWall(wall.parent);
          var angle12 = qSVG.angleBetweenEquations(equation1.A, equation2.A);
          if (angle12 < 20 || angle12 > 160) {
            var found = true;
            for (var k in WALLS) {
              if (
                qSVG.rayCasting(wall.start, WALLS[k].coords) &&
                !isObjectsEquals(WALLS[k], wall.parent) &&
                !isObjectsEquals(WALLS[k], wall)
              ) {
                if (
                  wall.parent.parent != null &&
                  isObjectsEquals(wall, wall.parent.parent)
                )
                  wall.parent.parent = null;
                if (
                  wall.parent.child != null &&
                  isObjectsEquals(wall, wall.parent.child)
                )
                  wall.parent.child = null;
                wall.parent = null;
                found = false;
                break;
              }
            }
            if (found) {
              var newWall;
              if (isObjectsEquals(wall.parent.end, wall.start, "1")) {
                newWall = new editor.wall(
                  wall.parent.end,
                  wall.start,
                  "normal",
                  wall.thick
                );
                WALLS.push(newWall);
                newWall.parent = wall.parent;
                newWall.child = wall;
                wall.parent.child = newWall;
                wall.parent = newWall;
                equation1 = qSVG.perpendicularEquation(
                  equation2,
                  wall.start.x,
                  wall.start.y
                );
              } else if (isObjectsEquals(wall.parent.start, wall.start, "2")) {
                newWall = new editor.wall(
                  wall.parent.start,
                  wall.start,
                  "normal",
                  wall.thick
                );
                WALLS.push(newWall);
                newWall.parent = wall.parent;
                newWall.child = wall;
                wall.parent.parent = newWall;
                wall.parent = newWall;
                equation1 = qSVG.perpendicularEquation(
                  equation2,
                  wall.start.x,
                  wall.start.y
                );
              }
              // CREATE NEW WALL
            }
          }
        }
        if (wall.parent == null) {
          var foundEq = false;
          for (var k in WALLS) {
            if (
              qSVG.rayCasting(wall.start, WALLS[k].coords) &&
              !isObjectsEquals(WALLS[k].coords, wall.coords)
            ) {
              var angleFollow = qSVG.angleBetweenEquations(
                WALLS[k].equations.base.A,
                equation2.A
              );
              if (angleFollow < 20 || angleFollow > 160) break;
              equation1 = editor.createEquationFromWall(WALLS[k]);
              equation1.follow = WALLS[k];
              equation1.backUp = {
                coords: WALLS[k].coords,
                start: WALLS[k].start,
                end: WALLS[k].end,
                child: WALLS[k].child,
                parent: WALLS[k].parent,
              };
              foundEq = true;
              break;
            }
          }
          if (!foundEq)
            equation1 = qSVG.perpendicularEquation(
              equation2,
              wall.start.x,
              wall.start.y
            );
        }

        if (wall.child != null) {
          equation3 = editor.createEquationFromWall(wall.child);
          var angle23 = qSVG.angleBetweenEquations(equation3.A, equation2.A);
          if (angle23 < 20 || angle23 > 160) {
            var found = true;
            for (var k in WALLS) {
              if (
                qSVG.rayCasting(wall.end, WALLS[k].coords) &&
                !isObjectsEquals(WALLS[k], wall.child) &&
                !isObjectsEquals(WALLS[k], wall)
              ) {
                if (
                  wall.child.parent != null &&
                  isObjectsEquals(wall, wall.child.parent)
                )
                  wall.child.parent = null;
                if (
                  wall.child.child != null &&
                  isObjectsEquals(wall, wall.child.child)
                )
                  wall.child.child = null;
                wall.child = null;
                found = false;
                break;
              }
            }
            if (found) {
              if (isObjectsEquals(wall.child.start, wall.end)) {
                var newWall = new editor.wall(
                  wall.end,
                  wall.child.start,
                  "new",
                  wall.thick
                );
                WALLS.push(newWall);
                newWall.parent = wall;
                newWall.child = wall.child;
                wall.child.parent = newWall;
                wall.child = newWall;
                equation3 = qSVG.perpendicularEquation(
                  equation2,
                  wall.end.x,
                  wall.end.y
                );
              } else if (isObjectsEquals(wall.child.end, wall.end)) {
                var newWall = new editor.wall(
                  wall.end,
                  wall.child.end,
                  "normal",
                  wall.thick
                );
                WALLS.push(newWall);
                newWall.parent = wall;
                newWall.child = wall.child;
                wall.child.child = newWall;
                wall.child = newWall;
                equation3 = qSVG.perpendicularEquation(
                  equation2,
                  wall.end.x,
                  wall.end.y
                );
              }
              // CREATE NEW WALL
            }
          }
        }
        if (wall.child == null) {
          var foundEq = false;
          for (var k in WALLS) {
            if (
              qSVG.rayCasting(wall.end, WALLS[k].coords) &&
              !isObjectsEquals(WALLS[k].coords, wall.coords, "4")
            ) {
              var angleFollow = qSVG.angleBetweenEquations(
                WALLS[k].equations.base.A,
                equation2.A
              );
              if (angleFollow < 20 || angleFollow > 160) break;
              equation3 = editor.createEquationFromWall(WALLS[k]);
              equation3.follow = WALLS[k];
              equation3.backUp = {
                coords: WALLS[k].coords,
                start: WALLS[k].start,
                end: WALLS[k].end,
                child: WALLS[k].child,
                parent: WALLS[k].parent,
              };
              foundEq = true;
              break;
            }
          }
          if (!foundEq)
            equation3 = qSVG.perpendicularEquation(
              equation2,
              wall.end.x,
              wall.end.y
            );
        }

        equationFollowers = [];
        for (var k in WALLS) {
          if (
            WALLS[k].child == null &&
            qSVG.rayCasting(WALLS[k].end, wall.coords) &&
            !isObjectsEquals(wall, WALLS[k])
          ) {
            equationFollowers.push({
              wall: WALLS[k],
              eq: editor.createEquationFromWall(WALLS[k]),
              type: "end",
            });
          }
          if (
            WALLS[k].parent == null &&
            qSVG.rayCasting(WALLS[k].start, wall.coords) &&
            !isObjectsEquals(wall, WALLS[k])
          ) {
            equationFollowers.push({
              wall: WALLS[k],
              eq: editor.createEquationFromWall(WALLS[k]),
              type: "start",
            });
          }
        }

        equationsObj = [];
        var objWall = editor.objFromWall(wall); // LIST OBJ ON EDGE
        for (var ob = 0; ob < objWall.length; ob++) {
          var objTarget = objWall[ob];
          equationsObj.push({
            obj: objTarget,
            wall: wall,
            eq: qSVG.perpendicularEquation(equation2, objTarget.x, objTarget.y),
          });
        }
        action = 1;
      }
    } else {
      action = 0;
      drag = "on";
      snap = calcul_snap(event, grid_snap);
      pox = snap.xMouse;
      poy = snap.yMouse;
    }
  }
}

//******************************************************************************************************
//*******************  *****  ******        ************************************************************
//*******************  *****  ******  ****  ************************************************************
//*******************  *****  ******  ****  ************************************************************
//*******************  *****  ******        ************************************************************
//*******************         ******  ******************************************************************
//**********************************  ******************************************************************
var unidades_puestas = 0;
function _MOUSEUP(event) {
  if (showRib) $("#boxScale").show(200);
  drag = "off";
  cursor("default");
  if (mode == "select_mode") {
    if (typeof binder != "undefined") {
      binder.remove();
      delete binder;
      save();
    }
  }

  //**************************************************************************
  //********************   TEXTE   MODE **************************************
  //**************************************************************************
  if (mode == "text_mode") {
    if (action == 0) {
      action = 1;
      $("#textToLayer").modal();
      mode == "edit_text_mode";
    }
  }

  //**************************************************************************
  //**************        OBJECT   MODE **************************************
  //**************************************************************************

  if (mode == "object_mode") {
    console.log("En object mode, las unidades puestas son " + unidades_puestas);
    //Coordenadas plano dibujado
    var plano = document.getElementById("boxRoom").getBoundingClientRect();
    console.log(plano.top, plano.right, plano.bottom, plano.left);

    //Saco coordenadas de los objetos

    OBJDATA.push(binder);
    binder.graph.remove();
    var targetBox = "boxcarpentry";
    if (OBJDATA[OBJDATA.length - 1].class == "energy") targetBox = "boxEnergy"; //Este hace referencia al div que contiene los elementos
    if (OBJDATA[OBJDATA.length - 1].class == "furniture")
      targetBox = "boxFurniture";
    $("#" + targetBox).append(OBJDATA[OBJDATA.length - 1].graph);

    var id_objeto_actual = OBJDATA[OBJDATA.length - 1].type;
    var objetos_plano = document
      .getElementById("boxEnergy")
      .getBoundingClientRect();
    console.log(
      objetos_plano.top,
      objetos_plano.right,
      objetos_plano.bottom,
      objetos_plano.left
    );

    /*if (objetos_plano.top <= plano.bottom && objetos_plano.right <= plano.right && objetos_plano.bottom >= plano.top && objetos_plano.left >= plano.left && objetos_plano.bottom <= plano.bottom && objetos_plano.top >= plano.top)
	  {
	  */
    //Objeto en posición correcta
    unidades_puestas++;
    delete binder;
    $("#boxinfo").html("Objeto añadido");

    /*
		 
		 Si el texto de las medidas lo añado así (junto al append de boxEnergy), el texto se crea
		 de forma independiente al elemento, por lo tanto cuando mueves el elemento (por ejemplo, la lavadora)
		 el texto se queda fijo.
		 
		 Por ello, hay que hacer el append sobre el padre
		 
		 sizeText[0].setAttributeNS(null, 'x', objetos_plano.left);
         sizeText[0].setAttributeNS(null, 'y', objetos_plano.top);
		 
		 */

    //Compruebo el elemento que es para saber si le añado texto o no
    // $('#boxEnergy').append(sizeText[0]);

    if (id_objeto_actual == "alto1") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 20);
      sizeText[0].setAttributeNS(null, "y", 17);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#000000");
      sizeText[0].textContent = "37x60";
      sizeText[0].setAttributeNS(null, "font-size", "8px");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", -60);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "skyblue");
      sizeText[1].textContent = "37x60";
      sizeText[1].setAttributeNS(null, "font-size", "8px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      //$("path[stroke-dasharray='alto1 fillblue']").parent().append($(sizeText[0]));
      $("path[stroke-dasharray='alto1 fillblue']")
        .parent()
        .append($(sizeText[1]));
    } else if (id_objeto_actual == "alto2") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 17);
      sizeText[0].setAttributeNS(null, "y", 18);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#000000");
      sizeText[0].textContent = "37x50";
      sizeText[0].setAttributeNS(null, "font-size", "8px");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 17);
      sizeText[1].setAttributeNS(null, "y", -60);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "skyblue");
      sizeText[1].textContent = "37x50";
      sizeText[1].setAttributeNS(null, "font-size", "8px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      // $("path[stroke-dasharray='alto2 fillblue']").parent().append($(sizeText[0]));
      $("path[stroke-dasharray='alto2 fillblue']")
        .parent()
        .append($(sizeText[1]));
    } else if (id_objeto_actual == "alto3") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 14);
      sizeText[0].setAttributeNS(null, "y", 18);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#000000");
      sizeText[0].textContent = "37x40";
      sizeText[0].setAttributeNS(null, "font-size", "8px");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 14);
      sizeText[1].setAttributeNS(null, "y", -60);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "skyblue");
      sizeText[1].textContent = "37x40";
      sizeText[1].setAttributeNS(null, "font-size", "8px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      //$("path[stroke-dasharray='alto3 fillblue']").parent().append($(sizeText[0]));
      $("path[stroke-dasharray='alto3 fillblue']")
        .parent()
        .append($(sizeText[1]));
    } else if (id_objeto_actual == "alto4") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 11);
      sizeText[0].setAttributeNS(null, "y", 18);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#000000");
      sizeText[0].textContent = "37x30";
      sizeText[0].setAttributeNS(null, "font-size", "7px");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 11);
      sizeText[1].setAttributeNS(null, "y", -60);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "skyblue");
      sizeText[1].textContent = "37x30";
      sizeText[1].setAttributeNS(null, "font-size", "8px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      //$("path[stroke-dasharray='alto4 fillblue']").parent().append($(sizeText[0]));
      $("path[stroke-dasharray='alto4 fillblue']")
        .parent()
        .append($(sizeText[1]));
    } else if (id_objeto_actual == "alto5") {
      /*sizeText[0] = document.createElementNS('http://www.w3.org/2000/svg', 'text');
		   sizeText[0].setAttributeNS(null, 'x', 14)
		   sizeText[0].setAttributeNS(null, 'y', 18)
		   sizeText[0].setAttributeNS(null, 'text-anchor', 'middle');
		   sizeText[0].setAttributeNS(null, 'font-family', 'roboto');
		   sizeText[0].setAttributeNS(null, 'stroke', '#000000');
		   sizeText[0].textContent = "37x20";
		   sizeText[0].setAttributeNS(null, 'font-size', '8px');
		   sizeText[0].setAttributeNS(null, 'stroke-width', '0.4px');
		   sizeText[0].setAttributeNS(null, 'fill', '#666666');
		   sizeText[0].setAttribute("transform", "rotate(0,0,0)");	 
			 */

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 8);
      sizeText[1].setAttributeNS(null, "y", -60);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "skyblue");
      sizeText[1].textContent = "37x20";
      sizeText[1].setAttributeNS(null, "font-size", "8px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      //$("path[stroke-dasharray='alto5 fillblue']").parent().append($(sizeText[0]));
      $("path[stroke-dasharray='alto5 fillblue']")
        .parent()
        .append($(sizeText[1]));
    } else if (id_objeto_actual == "bajo1") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 20);
      sizeText[0].setAttributeNS(null, "y", 25);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#000000");
      sizeText[0].textContent = "60x60";
      sizeText[0].setAttributeNS(null, "font-size", "8px");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", -30);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "60x60";
      sizeText[1].setAttributeNS(null, "font-size", "8px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      //$("path[stroke-dasharray='bajo1 fillnegro']").parent().append($(sizeText[0]));
      $("path[stroke-dasharray='bajo1 fillnegro']")
        .parent()
        .append($(sizeText[1]));
    } else if (id_objeto_actual == "bajo2") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 15);
      sizeText[0].setAttributeNS(null, "y", 25);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#000000");
      sizeText[0].textContent = "60x50";
      sizeText[0].setAttributeNS(null, "font-size", "8px");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 15);
      sizeText[1].setAttributeNS(null, "y", -30);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "60x50";
      sizeText[1].setAttributeNS(null, "font-size", "8px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      //$("path[stroke-dasharray='bajo2 fillnegro']").parent().append($(sizeText[0]));
      $("path[stroke-dasharray='bajo2 fillnegro']")
        .parent()
        .append($(sizeText[1]));
    } else if (id_objeto_actual == "bajo3") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 15);
      sizeText[0].setAttributeNS(null, "y", 25);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#000000");
      sizeText[0].textContent = "60x45";
      sizeText[0].setAttributeNS(null, "font-size", "8px");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 15);
      sizeText[1].setAttributeNS(null, "y", -30);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "60x45";
      sizeText[1].setAttributeNS(null, "font-size", "8px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      //$("path[stroke-dasharray='bajo3 fillnegro']").parent().append($(sizeText[0]));
      $("path[stroke-dasharray='bajo3 fillnegro']")
        .parent()
        .append($(sizeText[1]));
    } else if (id_objeto_actual == "bajo4") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 14);
      sizeText[0].setAttributeNS(null, "y", 25);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#000000");
      sizeText[0].textContent = "60x40";
      sizeText[0].setAttributeNS(null, "font-size", "8px");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 14);
      sizeText[1].setAttributeNS(null, "y", -30);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "60x40";
      sizeText[1].setAttributeNS(null, "font-size", "8px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      //$("path[stroke-dasharray='bajo4 fillnegro']").parent().append($(sizeText[0]));
      $("path[stroke-dasharray='bajo4 fillnegro']")
        .parent()
        .append($(sizeText[1]));
    } else if (id_objeto_actual == "bajo5") {
      /* sizeText[0] = document.createElementNS('http://www.w3.org/2000/svg', 'text');
		   sizeText[0].setAttributeNS(null, 'x', 15)
		   sizeText[0].setAttributeNS(null, 'y', 25)
		   sizeText[0].setAttributeNS(null, 'text-anchor', 'middle');
		   sizeText[0].setAttributeNS(null, 'font-family', 'roboto');
		   sizeText[0].setAttributeNS(null, 'stroke', '#000000');
		   sizeText[0].textContent = "60x30";
		   sizeText[0].setAttributeNS(null, 'font-size', '8px');
		   sizeText[0].setAttributeNS(null, 'stroke-width', '0.4px');
		   sizeText[0].setAttributeNS(null, 'fill', '#666666');
		   sizeText[0].setAttribute("transform", "rotate(0,0,0)");	 
			 */
      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 10);
      sizeText[1].setAttributeNS(null, "y", -30);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "60x30";
      sizeText[1].setAttributeNS(null, "font-size", "8px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      // $("path[stroke-dasharray='bajo5 fillnegro']").parent().append($(sizeText[0]));
      $("path[stroke-dasharray='bajo5 fillnegro']")
        .parent()
        .append($(sizeText[1]));
    } else if (id_objeto_actual == "bajo6") {
      /*sizeText[0] = document.createElementNS('http://www.w3.org/2000/svg', 'text');
		   sizeText[0].setAttributeNS(null, 'x', 15)
		   sizeText[0].setAttributeNS(null, 'y', 25)
		   sizeText[0].setAttributeNS(null, 'text-anchor', 'middle');
		   sizeText[0].setAttributeNS(null, 'font-family', 'roboto');
		   sizeText[0].setAttributeNS(null, 'stroke', '#000000');
		   sizeText[0].textContent = "60x20";
		   sizeText[0].setAttributeNS(null, 'font-size', '8px');
		   sizeText[0].setAttributeNS(null, 'stroke-width', '0.4px');
		   sizeText[0].setAttributeNS(null, 'fill', '#666666');
		   sizeText[0].setAttribute("transform", "rotate(0,0,0)");	 
			 */
      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 7);
      sizeText[1].setAttributeNS(null, "y", -30);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "60x20";
      sizeText[1].setAttributeNS(null, "font-size", "8px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      // $("path[stroke-dasharray='bajo6 fillnegro']").parent().append($(sizeText[0]));
      $("path[stroke-dasharray='bajo6 fillnegro']")
        .parent()
        .append($(sizeText[1]));
    } else if (id_objeto_actual == "lavadora") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 20);
      sizeText[0].setAttributeNS(null, "y", -25);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#ffffff");
      sizeText[0].textContent = "60cm";
      sizeText[0].setAttributeNS(null, "font-size", "0.6em");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='lavadora fillnegro']")
        .parent()
        .append($(sizeText[0]));

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", 20);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "LAVA";
      sizeText[1].setAttributeNS(null, "font-size", "0.5em");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='lavadora fillnegro']")
        .parent()
        .append($(sizeText[1]));

      sizeText[2] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[2].setAttributeNS(null, "x", 20);
      sizeText[2].setAttributeNS(null, "y", 35);
      sizeText[2].setAttributeNS(null, "text-anchor", "middle");
      sizeText[2].setAttributeNS(null, "font-family", "roboto");
      sizeText[2].setAttributeNS(null, "stroke", "#000000");
      sizeText[2].textContent = "DORA";
      sizeText[2].setAttributeNS(null, "font-size", "0.5em");
      sizeText[2].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[2].setAttributeNS(null, "fill", "#666666");
      sizeText[2].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='lavadora fillnegro']")
        .parent()
        .append($(sizeText[2]));
    } else if (id_objeto_actual == "campana") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 20);
      sizeText[0].setAttributeNS(null, "y", 14);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#000000");
      sizeText[0].textContent = "CAMPANA";
      sizeText[0].setAttributeNS(null, "font-size", "7px");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='campana fillnegro']")
        .parent()
        .append($(sizeText[0]));
    } else if (id_objeto_actual == "lavavajillas") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 20);
      sizeText[0].setAttributeNS(null, "y", -25);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#ffffff");
      sizeText[0].textContent = "60cm";
      sizeText[0].setAttributeNS(null, "font-size", "0.6em");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='lavavajillas fillnegro']")
        .parent()
        .append($(sizeText[0]));

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", 14);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "LAVA";
      sizeText[1].setAttributeNS(null, "font-size", "10px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='lavavajillas fillnegro']")
        .parent()
        .append($(sizeText[1]));

      sizeText[2] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[2].setAttributeNS(null, "x", 20);
      sizeText[2].setAttributeNS(null, "y", 24);
      sizeText[2].setAttributeNS(null, "text-anchor", "middle");
      sizeText[2].setAttributeNS(null, "font-family", "roboto");
      sizeText[2].setAttributeNS(null, "stroke", "#000000");
      sizeText[2].textContent = "VAJI";
      sizeText[2].setAttributeNS(null, "font-size", "10px");
      sizeText[2].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[2].setAttributeNS(null, "fill", "#666666");
      sizeText[2].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='lavavajillas fillnegro']")
        .parent()
        .append($(sizeText[2]));

      sizeText[3] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[3].setAttributeNS(null, "x", 20);
      sizeText[3].setAttributeNS(null, "y", 34);
      sizeText[3].setAttributeNS(null, "text-anchor", "middle");
      sizeText[3].setAttributeNS(null, "font-family", "roboto");
      sizeText[3].setAttributeNS(null, "stroke", "#000000");
      sizeText[3].textContent = "LLAS";
      sizeText[3].setAttributeNS(null, "font-size", "10px");
      sizeText[3].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[3].setAttributeNS(null, "fill", "#666666");
      sizeText[3].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='lavavajillas fillnegro']")
        .parent()
        .append($(sizeText[3]));
    } else if (id_objeto_actual == "horno") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 20);
      sizeText[0].setAttributeNS(null, "y", -25);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#ffffff");
      sizeText[0].textContent = "60cm";
      sizeText[0].setAttributeNS(null, "font-size", "0.6em");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='horno fillnegro']")
        .parent()
        .append($(sizeText[0]));

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", 25);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "HORNO";
      sizeText[1].setAttributeNS(null, "font-size", "10px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='horno fillnegro']")
        .parent()
        .append($(sizeText[1]));
    } else if (id_objeto_actual == "vitro_induccion") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 20);
      sizeText[0].setAttributeNS(null, "y", -25);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#ffffff");
      sizeText[0].textContent = "60cm";
      sizeText[0].setAttributeNS(null, "font-size", "0.6em");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='vitro_induccion fillnegro']")
        .parent()
        .append($(sizeText[0]));

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", 14);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "VITRO";
      sizeText[1].setAttributeNS(null, "font-size", "10px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='vitro_induccion fillnegro']")
        .parent()
        .append($(sizeText[1]));

      sizeText[2] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[2].setAttributeNS(null, "x", 20);
      sizeText[2].setAttributeNS(null, "y", 24);
      sizeText[2].setAttributeNS(null, "text-anchor", "middle");
      sizeText[2].setAttributeNS(null, "font-family", "roboto");
      sizeText[2].setAttributeNS(null, "stroke", "#000000");
      sizeText[2].textContent = "INDUC";
      sizeText[2].setAttributeNS(null, "font-size", "10px");
      sizeText[2].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[2].setAttributeNS(null, "fill", "#666666");
      sizeText[2].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='vitro_induccion fillnegro']")
        .parent()
        .append($(sizeText[2]));

      sizeText[3] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[3].setAttributeNS(null, "x", 20);
      sizeText[3].setAttributeNS(null, "y", 34);
      sizeText[3].setAttributeNS(null, "text-anchor", "middle");
      sizeText[3].setAttributeNS(null, "font-family", "roboto");
      sizeText[3].setAttributeNS(null, "stroke", "#000000");
      sizeText[3].textContent = "CIÓN";
      sizeText[3].setAttributeNS(null, "font-size", "10px");
      sizeText[3].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[3].setAttributeNS(null, "fill", "#666666");
      sizeText[3].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='vitro_induccion fillnegro']")
        .parent()
        .append($(sizeText[3]));
    } else if (id_objeto_actual == "placa_gas") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 20);
      sizeText[0].setAttributeNS(null, "y", -25);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#ffffff");
      sizeText[0].textContent = "60cm";
      sizeText[0].setAttributeNS(null, "font-size", "0.6em");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='placa_gas fillnegro']")
        .parent()
        .append($(sizeText[0]));

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", 20);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "PLACA";
      sizeText[1].setAttributeNS(null, "font-size", "12px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='placa_gas fillnegro']")
        .parent()
        .append($(sizeText[1]));

      sizeText[2] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[2].setAttributeNS(null, "x", 20);
      sizeText[2].setAttributeNS(null, "y", 35);
      sizeText[2].setAttributeNS(null, "text-anchor", "middle");
      sizeText[2].setAttributeNS(null, "font-family", "roboto");
      sizeText[2].setAttributeNS(null, "stroke", "#000000");
      sizeText[2].textContent = "GAS";
      sizeText[2].setAttributeNS(null, "font-size", "12px");
      sizeText[2].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[2].setAttributeNS(null, "fill", "#666666");
      sizeText[2].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='placa_gas fillnegro']")
        .parent()
        .append($(sizeText[2]));
    } else if (id_objeto_actual == "micro") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 20);
      sizeText[0].setAttributeNS(null, "y", -25);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#ffffff");
      sizeText[0].textContent = "60cm";
      sizeText[0].setAttributeNS(null, "font-size", "0.6em");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='micro fillnegro']")
        .parent()
        .append($(sizeText[0]));

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", 25);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "MICRO";
      sizeText[1].setAttributeNS(null, "font-size", "10px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='micro fillnegro']")
        .parent()
        .append($(sizeText[1]));
    } else if (id_objeto_actual == "frigo") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 20);
      sizeText[0].setAttributeNS(null, "y", -25);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#ffffff");
      sizeText[0].textContent = "60cm";
      sizeText[0].setAttributeNS(null, "font-size", "0.6em");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='frigo fillnegro']")
        .parent()
        .append($(sizeText[0]));

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", 25);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "FRIGO";
      sizeText[1].setAttributeNS(null, "font-size", "10px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='frigo fillnegro']")
        .parent()
        .append($(sizeText[1]));
    } else if (id_objeto_actual == "secadora") {
      console.log("ENTRO EN SECADORA");
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 20);
      sizeText[0].setAttributeNS(null, "y", -25);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#ffffff");
      sizeText[0].textContent = "60cm";
      sizeText[0].setAttributeNS(null, "font-size", "0.6em");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='secadora fillnegro']")
        .parent()
        .append($(sizeText[0]));

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", 20);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "SECA";
      sizeText[1].setAttributeNS(null, "font-size", "1em");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='secadora fillnegro']")
        .parent()
        .append($(sizeText[1]));

      sizeText[2] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[2].setAttributeNS(null, "x", 20);
      sizeText[2].setAttributeNS(null, "y", 35);
      sizeText[2].setAttributeNS(null, "text-anchor", "middle");
      sizeText[2].setAttributeNS(null, "font-family", "roboto");
      sizeText[2].setAttributeNS(null, "stroke", "#000000");
      sizeText[2].textContent = "DORA";
      sizeText[2].setAttributeNS(null, "font-size", "1em");
      sizeText[2].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[2].setAttributeNS(null, "fill", "#666666");
      sizeText[2].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='secadora fillnegro']")
        .parent()
        .append($(sizeText[2]));
    } else if (id_objeto_actual == "fregadero") {
      sizeText[0] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[0].setAttributeNS(null, "x", 20);
      sizeText[0].setAttributeNS(null, "y", -25);
      sizeText[0].setAttributeNS(null, "text-anchor", "middle");
      sizeText[0].setAttributeNS(null, "font-family", "roboto");
      sizeText[0].setAttributeNS(null, "stroke", "#ffffff");
      sizeText[0].textContent = "60cm";
      sizeText[0].setAttributeNS(null, "font-size", "0.6em");
      sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[0].setAttributeNS(null, "fill", "#666666");
      sizeText[0].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='fregadero fillnegro']")
        .parent()
        .append($(sizeText[0]));

      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", 20);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "FREGA";
      sizeText[1].setAttributeNS(null, "font-size", "12px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='fregadero fillnegro']")
        .parent()
        .append($(sizeText[1]));

      sizeText[2] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[2].setAttributeNS(null, "x", 20);
      sizeText[2].setAttributeNS(null, "y", 35);
      sizeText[2].setAttributeNS(null, "text-anchor", "middle");
      sizeText[2].setAttributeNS(null, "font-family", "roboto");
      sizeText[2].setAttributeNS(null, "stroke", "#000000");
      sizeText[2].textContent = "DERO";
      sizeText[2].setAttributeNS(null, "font-size", "12px");
      sizeText[2].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[2].setAttributeNS(null, "fill", "#666666");
      sizeText[2].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='fregadero fillnegro']")
        .parent()
        .append($(sizeText[2]));
    } else if (id_objeto_actual == "lavadero") {
      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", 20);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "LAVA";
      sizeText[1].setAttributeNS(null, "font-size", "12px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='lavadero fillnegro']")
        .parent()
        .append($(sizeText[1]));

      sizeText[2] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[2].setAttributeNS(null, "x", 20);
      sizeText[2].setAttributeNS(null, "y", 35);
      sizeText[2].setAttributeNS(null, "text-anchor", "middle");
      sizeText[2].setAttributeNS(null, "font-family", "roboto");
      sizeText[2].setAttributeNS(null, "stroke", "#000000");
      sizeText[2].textContent = "DERO";
      sizeText[2].setAttributeNS(null, "font-size", "12px");
      sizeText[2].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[2].setAttributeNS(null, "fill", "#666666");
      sizeText[2].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='lavadero fillnegro']")
        .parent()
        .append($(sizeText[2]));
    } else if (id_objeto_actual == "termo_electrico") {
      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", 20);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "TERMO";
      sizeText[1].setAttributeNS(null, "font-size", "10px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='termo_electrico fillnegro']")
        .parent()
        .append($(sizeText[1]));

      sizeText[2] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[2].setAttributeNS(null, "x", 20);
      sizeText[2].setAttributeNS(null, "y", 35);
      sizeText[2].setAttributeNS(null, "text-anchor", "middle");
      sizeText[2].setAttributeNS(null, "font-family", "roboto");
      sizeText[2].setAttributeNS(null, "stroke", "#000000");
      sizeText[2].textContent = "ELECT.";
      sizeText[2].setAttributeNS(null, "font-size", "10px");
      sizeText[2].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[2].setAttributeNS(null, "fill", "#666666");
      sizeText[2].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='termo_electrico fillnegro']")
        .parent()
        .append($(sizeText[2]));
    } else if (id_objeto_actual == "calentador_gas") {
      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", 20);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "CALENT.";
      sizeText[1].setAttributeNS(null, "font-size", "9px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='calentador_gas fillnegro']")
        .parent()
        .append($(sizeText[1]));

      sizeText[2] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[2].setAttributeNS(null, "x", 20);
      sizeText[2].setAttributeNS(null, "y", 35);
      sizeText[2].setAttributeNS(null, "text-anchor", "middle");
      sizeText[2].setAttributeNS(null, "font-family", "roboto");
      sizeText[2].setAttributeNS(null, "stroke", "#000000");
      sizeText[2].textContent = "GAS";
      sizeText[2].setAttributeNS(null, "font-size", "9px");
      sizeText[2].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[2].setAttributeNS(null, "fill", "#666666");
      sizeText[2].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='calentador_gas fillnegro']")
        .parent()
        .append($(sizeText[2]));
    } else if (id_objeto_actual == "caldera_gas") {
      sizeText[1] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[1].setAttributeNS(null, "x", 20);
      sizeText[1].setAttributeNS(null, "y", 20);
      sizeText[1].setAttributeNS(null, "text-anchor", "middle");
      sizeText[1].setAttributeNS(null, "font-family", "roboto");
      sizeText[1].setAttributeNS(null, "stroke", "#000000");
      sizeText[1].textContent = "CALDERA";
      sizeText[1].setAttributeNS(null, "font-size", "8px");
      sizeText[1].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[1].setAttributeNS(null, "fill", "#666666");
      sizeText[1].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='caldera_gas fillnegro']")
        .parent()
        .append($(sizeText[1]));

      sizeText[2] = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "text"
      );
      sizeText[2].setAttributeNS(null, "x", 20);
      sizeText[2].setAttributeNS(null, "y", 35);
      sizeText[2].setAttributeNS(null, "text-anchor", "middle");
      sizeText[2].setAttributeNS(null, "font-family", "roboto");
      sizeText[2].setAttributeNS(null, "stroke", "#000000");
      sizeText[2].textContent = "GAS";
      sizeText[2].setAttributeNS(null, "font-size", "8px");
      sizeText[2].setAttributeNS(null, "stroke-width", "0.4px");
      sizeText[2].setAttributeNS(null, "fill", "#666666");
      sizeText[2].setAttribute("transform", "rotate(0,0,0)");

      $("path[stroke-dasharray='caldera_gas fillnegro']")
        .parent()
        .append($(sizeText[2]));
    }

    //OBJDATA[OBJDATA.length-1] devuelve algo como esto:
    /*
		  	obj2D {family: "free", class: "energy", type: "bajo2", x: 453.1875, y: 487.59375, …}
			angle: 0
			angleSign: 0
			bbox: DOMRect {origin: {…}, x: 518.3505859375, y: 542.1119791666667, width: 66.34375, height: 80, …}
			class: "energy"
			family: "free"
			graph: m.fn.init [g, context: g]
			height: "1.33"
			hinge: "normal"
			limit: []
			oldX: 453.1875
			oldY: 487.59375
			params: {bindBox: true, move: true, resize: false, resizeLimit: {…}, rotate: true, …}
			realBbox: (4) [{…}, {…}, {…}, {…}]
			scale: {x: 1, y: 1}
			size: 80
			thick: 80
			type: "bajo2"
			update: ƒ ()
			value: undefined
			width: "1.33"
			x: 453.1875
			y: 487.59375
			__proto__: Object
		  
		  OBJDATA[OBJDATA.length-1].type me devuelve el ID del elemento que está añadiendo al mapa
		  */

    console.log("El id del objeto actual es " + id_objeto_actual);
    fonc_button("select_mode");
    save();

    /*
      if ($("#"+id_objeto_actual+" + .unidades_elemento").length)
		  {
			  
			  var valorLength=parseInt($("path[stroke-dasharray*='"+id_objeto_actual+"']").parent().length);
			  console.log("El valor de Length "+valorLength);
			
			  
			  //Si es un elemento en que ha especificado cantidad, miro qué cantidad ha puesto para dejarle añadir
			  //ese elemento tantas veces como número de unidades haya escrito
			  var valorInput=$("select."+id_objeto_actual).val();
			  
			  //Tengo que mirar si por ejemplo ha elegido 7 unidades, pero ya hay 4 puestas, solo le permito poner 3
			  //console.log("El valor del input es "+parseInt(valorInput));
			 // console.log("El valor del length es "+parseInt($("path[stroke-dasharray='puntos_electricos_extras fillblanco']").length));
			  
			  
			  
			  //valorInput = parseInt(valorInput) - parseInt(valorLength);
			  
			  //console.log("El valor despues de la resta es "+valorInput);
			  
			  if ($("#"+id_objeto_actual).hasClass("selected"))
			  {
				 //var valorInput=$("select."+id_objeto_actual).val();
			  }
			  else
			  {
				 valorInput=0; //Ha desclickeado ese elemento
			     fonc_button('select_mode'); 
		    	 save();
			  }
			  
			  console.log("VALOR LENGTH "+valorLength+" VS VALOR INPUT "+valorInput);
			  if (unidades_puestas >= valorInput || valorLength >= valorInput)
			  {
				 fonc_button('select_mode');
				 save(); 
				 unidades_puestas=0; 
			  }
			  
			  
			  console.log("Unidades puestas "+unidades_puestas+" VS unidades totales "+valorInput);
		  }
		  else  // si es un elemento en el que no se especifica unidades, vuelvo al modo de selección
		  {
			fonc_button('select_mode'); 
		    save();
		  }
		  */

    /*	  
	  }
	  else
	  {
		  alertify.error("Los elementos deben estar dentro de los límites del plano");
	      //binder.obj.graph.remove();
		  binder.graph.remove();
		  OBJDATA.splice(OBJDATA.indexOf(binder.obj), 1);
		  $('#objBoundingBox').hide(100);
		  $('#panel').show(200);
		  fonc_button('select_mode');
		  $('#boxinfo').html('Objeto eliminado');
		  delete binder;
		  rib();
		
	  }
	 */
  }

  // *******************************************************************
  // **************************   DISTANCE MODE   **********************
  // *******************************************************************
  if (mode == "distance_mode") {
    if (action == 1) {
      action = 0;
      // MODIFY BBOX FOR BINDER ZONE (TXT)
      var bbox = labelMeasure.get(0).getBoundingClientRect();
      bbox.x = bbox.x * factor - offset.left * factor + originX_viewbox;
      bbox.y = bbox.y * factor - offset.top * factor + originY_viewbox;
      bbox.origin = { x: bbox.x + bbox.width / 2, y: bbox.y + bbox.height / 2 };
      binder.bbox = bbox;
      binder.realBbox = [
        { x: binder.bbox.x, y: binder.bbox.y },
        { x: binder.bbox.x + binder.bbox.width, y: binder.bbox.y },
        {
          x: binder.bbox.x + binder.bbox.width,
          y: binder.bbox.y + binder.bbox.height,
        },
        { x: binder.bbox.x, y: binder.bbox.y + binder.bbox.height },
      ];
      binder.size = binder.bbox.width;
      binder.thick = binder.bbox.height;
      binder.graph.append(labelMeasure);
      OBJDATA.push(binder);
      binder.graph.remove();
      $("#boxcarpentry").append(OBJDATA[OBJDATA.length - 1].graph);
      delete binder;
      delete labelMeasure;
      cross.remove();
      delete cross;
      $("#boxinfo").html("Medida agregada");
      fonc_button("select_mode");
      save();
    }
  }

  // *******************************************************************
  // **************************   ROOM MODE   **************************
  // *******************************************************************

  if (mode == "room_mode") {
    if (typeof binder == "undefined") {
      return false;
    }

    var area = binder.area / 3600;
    binder.attr({ fill: "none", stroke: "#ddf00a", "stroke-width": 7 });
    $(".size").html(area.toFixed(2) + " m²");
    $("#roomIndex").val(binder.id);
    if (ROOM[binder.id].surface != "")
      $("#roomSurface").val(ROOM[binder.id].surface);
    else $("#roomSurface").val("");
    document.querySelector("#seeArea").checked = ROOM[binder.id].showSurface;
    document.querySelector("#roomBackground").value = ROOM[binder.id].color;
    var roomName = ROOM[binder.id].name;
    document.querySelector("#roomName").value = roomName;
    if (ROOM[binder.id].name != "") {
      document.querySelector("#roomLabel").innerHTML =
        roomName + ' <span class="caret"></span>';
    } else {
      document.querySelector("#roomLabel").innerHTML =
        'None <span class="caret"></span>';
    }

    var actionToDo = ROOM[binder.id].action;
    document.querySelector("#" + actionToDo + "Action").checked = true;
    $("#panel").hide(100);
    $("#roomTools").show("300", function () {
      $("#lin").css("cursor", "default");
      $("#boxinfo").html("Configura la cocina");
    });
    mode = "edit_room_mode";
    save();
  }

  // *******************************************************************
  // **************************   NODE MODE   **************************
  // *******************************************************************

  if (mode == "node_mode") {
    if (typeof binder != "undefined") {
      // ALSO ON MOUSEUP WITH HAVE CIRCLEBINDER ON ADDPOINT
      var newWall = new editor.wall(
        { x: binder.data.x, y: binder.data.y },
        binder.data.wall.end,
        "normal",
        binder.data.wall.thick
      );
      WALLS.push(newWall);
      binder.data.wall.end = { x: binder.data.x, y: binder.data.y };
      binder.remove();
      delete binder;
      editor.architect(WALLS);
      save();
    }
    fonc_button("select_mode");
  }

  // *******************************************************************  ***** ****      *******  ******  ******  *****
  // **************************   OBJ MODE   ***************************  *   * *******     *****  ******  ******   **
  // *******************************************************************  ***** ****       ******  ******  ******  ***

  if (mode == "door_mode") {
    if (typeof binder == "undefined") {
      $("#boxinfo").html("El plan actualmente no contiene muros.");
      fonc_button("select_mode");
      return false;
    }
    OBJDATA.push(binder);
    binder.graph.remove();
    $("#boxcarpentry").append(OBJDATA[OBJDATA.length - 1].graph);
    delete binder;
    $("#boxinfo").html("Elemento añadido");
    fonc_button("select_mode");
    save();
  }

  // *******************************************************************
  // ********************   LINE MODE MOUSE UP   ***********************
  // *******************************************************************

  if (mode == "line_mode" || mode == "partition_mode") {
    $("#linetemp").remove(); // DEL LINE HELP CONSTRUC 0 45 90
    intersectionOff();
    //console.log("METER ES "+meter);
    var sizeWall = qSVG.measure({ x: x, y: y }, { x: pox, y: poy });
    sizeWall = sizeWall / meter;
    //console.log("sizeWall "+sizeWall); sizeWall tiene el tamaño REAL de esa pared
    console.log("sizeWall " + sizeWall + " VS wallSize " + wallSize);
    if ($("#line_construc").length && sizeWall > 0.3) {
      var sizeWall = wallSize; //si wallSize le ponemos valor de 0.1, la medida es EXACTA a la interior
      if (mode == "partition_mode") sizeWall = partitionSize;
      var wall = new editor.wall(
        { x: pox, y: poy },
        { x: x, y: y },
        "normal",
        sizeWall
      );

      //Para evitar errores de que el muro se queda marcado cuando accedes al menú
      //Debo dejar una separación entre tu dibujo y el menú
      //Por ello compruebo el tamaño del menú y le sumo 160px para tener ese margen
      //sfar: Para evitar problemas con la versión vertical quito el margen
      //var distancia_menu_muro = parseInt($("#parte_superior").width() + 160);
      var distancia_menu_muro = 1;

      if (
        wall.start.x < distancia_menu_muro ||
        wall.end.x < distancia_menu_muro
      ) {
        alert(
          "Tu muro está muy cerca de los límites. Debes dejar más separación horizontal"
        );
        fonc_button("select_mode");
        location.reload();
      } else {
        WALLS.push(wall);

        //console.log(wall.start.x);
        //alert($('#parte_superior').offset().left - $(this).offset().left);
        editor.architect(WALLS);

        //if (document.getElementById("multi").checked && !wallEndConstruc) {
        if (!wallEndConstruc) {
          cursor("validation");
          action = 1;
        } else action = 0;
        $("#boxinfo").html(
          "Muro creado <span style='font-size:0.6em'>Moy. " +
            (qSVG.measure({ x: pox, y: poy }, { x: x, y: y }) / 60).toFixed(2) +
            " m</span>"
        );
        $("#line_construc").remove(); // DEL LINE CONSTRUC HELP TO VIEW NEW SEG PATH
        lengthTemp.remove();
        delete lengthTemp;
        construc = 0;
        if (wallEndConstruc) action = 0;
        delete wallEndConstruc;
        pox = x;
        poy = y;
        save();
      }
    } else {
      action = 0;
      construc = 0;
      $("#boxinfo").html("Modo selección");
      fonc_button("select_mode");
      if (typeof binder != "undefined") {
        binder.remove();
        delete binder;
      }
      snap = calcul_snap(event, grid_snap);
      pox = snap.x;
      poy = snap.y;
    }
  }
  // **************************** END LINE MODE MOUSE UP **************************

  //**************************************************************************************
  //**********************      BIND MODE MOUSE UP    ************************************
  //**************************************************************************************

  if (mode == "bind_mode") {
    action = 0;
    construc = 0; // CONSTRUC 0 TO FREE BINDER GROUP NODE WALL MOVING
    if (typeof binder != "undefined") {
      fonc_button("select_mode");
      if (binder.type == "node") {
      } // END BINDER NODE

      if (binder.type == "segment") {
        var found = false;
        if (binder.wall.start == binder.before) {
          found = true;
        }

        if (found) {
          //$('#panel').hide(100);
          var objWall = editor.objFromWall(wallBind);
          $("#boxinfo").html(
            'Modififca el muro<br/><span style="font-size:0.7em;color:#de9b43">Este muro no puede convertirse en una separación (contiene puertas o ventanas) !</span>'
          );
          if (objWall.length > 0) $("#separate").hide();
          else if (binder.wall.type == "separate") {
            $("#separate").hide();
            $("#rangeThick").hide();
            $("#recombine").show();
            $("#cutWall").hide();
            document.getElementById("titleWallTools").textContent =
              "Modify the separation";
          } else {
            $("#cutWall").show();
            $("#separate").show();
            $("#rangeThick").show();
            $("#recombine").hide();
            // document.getElementById('titleWallTools').textContent = "Modify the wall";
            $("#boxinfo").html("Modifica el muro");
            $("input[name='opcion_tabique']").removeAttr("checked");
          }

          $("#menu_plano").trigger("click");
          $("#panel").hide();
          $("#wallTools").show(200);

          //document.getElementById('wallWidth').setAttribute('min', 7);
          //document.getElementById('wallWidth').setAttribute('max', 50);
          //document.getElementById('wallWidthScale').textContent = "7-50";
          //document.getElementById("wallWidth").value = binder.wall.thick;
          //document.getElementById("wallWidthVal").textContent = binder.wall.thick;

          //console.log("TEST");
          //console.log(binder.wall.graph.context);
          //document.getElementById('wallWidthScale').textContent = binder.wall.graph.context.id;

          document.getElementById("wallWidth").className =
            binder.wall.graph.context.id;
          console.log(binder.wall.graph.context.id); //id de la pared (muro1,muro2,muro3,muro4...)

          //Segun el muro que sea (muro1,muro2,muro3,muro4... saco su respectivo m2 quedando con la primera coincidencia que corresponde con el interior). Hay que meterlo dentro de un set time out porque si no, muestra 0 coincidencias. (se ejecuta antes de tiempo. Tras varias pruebas, con 1 segundo es suficiente)

          setTimeout(function () {
            if (binder.wall.graph.context.id == "muro1")
              var str = $(".texto1").first().text();
            else if (binder.wall.graph.context.id == "muro2")
              var str = $(".texto2").first().text();
            else if (binder.wall.graph.context.id == "muro3")
              var str = $(".texto3").first().text();
            else if (binder.wall.graph.context.id == "muro4")
              var str = $(".texto4").first().text();
            else if (binder.wall.graph.context.id == "muro5")
              var str = $(".texto5").first().text();
            else if (binder.wall.graph.context.id == "muro6")
              var str = $(".texto6").first().text();
            else if (binder.wall.graph.context.id == "muro7")
              var str = $(".texto7").first().text();
            else if (binder.wall.graph.context.id == "muro8")
              var str = $(".texto8").first().text();
            else if (binder.wall.graph.context.id == "muro9")
              var str = $(".texto9").first().text();
            else if (binder.wall.graph.context.id == "muro10")
              var str = $(".texto10").first().text();
            else if (binder.wall.graph.context.id == "muro11")
              var str = $(".texto11").first().text();
            else if (binder.wall.graph.context.id == "muro12")
              var str = $(".texto12").first().text();
            else if (binder.wall.graph.context.id == "muro13")
              var str = $(".texto13").first().text();
            else if (binder.wall.graph.context.id == "muro14")
              var str = $(".texto14").first().text();
            else if (binder.wall.graph.context.id == "muro15")
              var str = $(".texto15").first().text();
            else if (binder.wall.graph.context.id == "muro16")
              var str = $(".texto16").first().text();
            else if (binder.wall.graph.context.id == "muro17")
              var str = $(".texto17").first().text();
            else if (binder.wall.graph.context.id == "muro18")
              var str = $(".texto18").first().text();
            else if (binder.wall.graph.context.id == "muro19")
              var str = $(".texto19").first().text();
            else if (binder.wall.graph.context.id == "muro20")
              var str = $(".texto20").first().text();

            var valormetros = str.split(" -"); // posicion 0 = metros cuadrados posición 1 - LETRA

            document.getElementById("wallWidth").value = valormetros[0];

            document.getElementById("wallWidthScale").textContent = str;
          }, 500);

          console.log(binder);
          mode = "edit_wall_mode";
        }
        delete equation1;
        delete equation2;
        delete equation3;
        delete intersectionFollowers;
      }

      if (binder.type == "obj") {
        var moveObj =
          Math.abs(binder.oldXY.x - binder.x) +
          Math.abs(binder.oldXY.y - binder.y);
        if (moveObj < 1) {
          $("#panel").hide(100);
          $("#objTools").show("200", function () {
            $("#lin").css("cursor", "default");
            $("#boxinfo").html("Configura la puerta/ventana");

            console.log("Saco la altura");
            console.log(binder.obj.params);
            console.log("-----");

            //Altura, le pongo la misma que está en el min del height
            if (binder.obj.params.resizeLimit.height.min !== false) {
              $("#doorWindowHeight").val(
                binder.obj.params.resizeLimit.height.min
              );
              $("#doorWindowHeight + output").html(
                binder.obj.params.resizeLimit.height.min
              );
            } else {
              $("#doorWindowHeight").val(1);
              $("#doorWindowHeight + output").html(1);
            }
            //Anchura
            document
              .getElementById("doorWindowWidth")
              .setAttribute("min", binder.obj.params.resizeLimit.width.min);
            document
              .getElementById("doorWindowWidth")
              .setAttribute("max", binder.obj.params.resizeLimit.width.max);
            document.getElementById("doorWindowWidthScale").textContent =
              binder.obj.params.resizeLimit.width.min +
              "-" +
              binder.obj.params.resizeLimit.width.max;
            document.getElementById("doorWindowWidth").value = binder.obj.size;
            document.getElementById("doorWindowWidthVal").textContent =
              binder.obj.size;
          });
          mode = "edit_door_mode";
        } else {
          mode = "select_mode";
          action = 0;
          binder.graph.remove();
          delete binder;
        }
      }

      if (typeof binder != "undefined" && binder.type == "boundingBox") {
        //Cuando clickeas en el elemento (paraver sus propiedades), ejecuta este código
        var moveObj =
          Math.abs(binder.oldX - binder.x) + Math.abs(binder.oldY - binder.y);
        var objTarget = binder.obj;
        if (!objTarget.params.move) {
          // TO REMOVE MEASURE ON PLAN
          objTarget.graph.remove();
          OBJDATA.splice(OBJDATA.indexOf(objTarget), 1);
          $("#boxinfo").html("Eliminado!");
        }
        if (moveObj < 1 && objTarget.params.move) {
          if (!objTarget.params.resize) $("#objBoundingBoxScale").hide();
          else $("#objBoundingBoxScale").show();
          if (!objTarget.params.rotate) $("#objBoundingBoxRotation").hide();
          else $("#objBoundingBoxRotation").show();
          $("#panel").hide(100);
          $("#objBoundingBox").show("200", function () {
            $("#lin").css("cursor", "default");
            $("#boxinfo").html("Modify the object");
            document
              .getElementById("bboxWidth")
              .setAttribute("min", objTarget.params.resizeLimit.width.min);
            document
              .getElementById("bboxWidth")
              .setAttribute("max", objTarget.params.resizeLimit.width.max);
            document.getElementById("bboxWidthScale").textContent =
              objTarget.params.resizeLimit.width.min +
              "-" +
              objTarget.params.resizeLimit.height.max;
            document
              .getElementById("bboxHeight")
              .setAttribute("min", objTarget.params.resizeLimit.height.min);
            document
              .getElementById("bboxHeight")
              .setAttribute("max", objTarget.params.resizeLimit.height.max);
            document.getElementById("bboxHeightScale").textContent =
              objTarget.params.resizeLimit.height.min +
              "-" +
              objTarget.params.resizeLimit.height.max;
            $("#stepsCounter").hide();
            if (objTarget.class == "stair") {
              document.getElementById("bboxStepsVal").textContent =
                objTarget.value;
              $("#stepsCounter").show();
            }
            document.getElementById("bboxWidth").value = objTarget.width * 100;
            document.getElementById("bboxWidthVal").textContent =
              objTarget.width * 100;
            document.getElementById("bboxHeight").value =
              objTarget.height * 100;
            document.getElementById("bboxHeightVal").textContent =
              objTarget.height * 100;
            document.getElementById("bboxRotation").value = objTarget.angle;
            document.getElementById("bboxRotationVal").textContent =
              objTarget.angle;
          });
          mode = "edit_boundingBox_mode";
        } else {
          mode = "select_mode";
          action = 0;
          binder.graph.remove();
          delete binder;
        }
      }

      if (mode == "bind_mode") {
        binder.remove();
        delete binder;
      }
    } // END BIND IS DEFINED
    save();
  } // END BIND MODE

  if (mode != "edit_room_mode") {
    editor.showScaleBox();
    rib();
  }
}

setInterval(function () {
  //console.log("setInterval");
  var contador = 0;
  $("#boxEnergy > g").each(function () {
    contador++;
  });

  var plano = document.getElementById("boxRoom").getBoundingClientRect();
  //console.log(plano.top, plano.right, plano.bottom, plano.left);

  var objetos_plano = document
    .getElementById("boxEnergy")
    .getBoundingClientRect();
  //console.log(objetos_plano.top, objetos_plano.right, objetos_plano.bottom, objetos_plano.left);

  if (
    objetos_plano.top != 0 &&
    objetos_plano.right != 0 &&
    objetos_plano.bottom != 0 &&
    objetos_plano.left != 0 &&
    contador > 0
  ) {
    if (
      objetos_plano.top <= plano.bottom &&
      objetos_plano.right <= plano.right &&
      objetos_plano.bottom >= plano.top &&
      objetos_plano.left >= plano.left &&
      objetos_plano.bottom <= plano.bottom &&
      objetos_plano.top >= plano.top
    ) {
      //OK
      var primer_muro = document
        .getElementById("muro1")
        .getBoundingClientRect();
      $("#boxEnergy > g").each(function () {
        console.log("Voy a sacar el g de ");
        console.log(this);
        var objeto = this.getBoundingClientRect();
        console.log(objeto.top, objeto.right, objeto.bottom, objeto.left);

        var distancia = objeto.left - primer_muro.left;
        console.log("Está a " + distancia + " distancia del muro1");
        var startText = qSVG.middle(
          primer_muro.top,
          primer_muro.left,
          objeto.top,
          objeto.left
        );
        console.log("Y su startText es de ");
        console.log(startText);
        console.log("Y su value text es de ");
        var valueText = (
          qSVG.measure(
            {
              x: primer_muro.left,
              y: primer_muro.top,
            },
            {
              x: objeto.left,
              y: objeto.top,
            }
          ) / 60
        ).toFixed(2);
        console.log(valueText);

        //Añado el texto de medida
        sizeText[0] = document.createElementNS(
          "http://www.w3.org/2000/svg",
          "text"
        );
        sizeText[0].setAttributeNS(null, "x", 20);
        sizeText[0].setAttributeNS(null, "y", -25);
        sizeText[0].setAttributeNS(null, "text-anchor", "middle");
        sizeText[0].setAttributeNS(null, "font-family", "roboto");
        sizeText[0].setAttributeNS(null, "stroke", "#ffffff");
        sizeText[0].textContent = valueText;
        sizeText[0].setAttributeNS(null, "font-size", "1em");
        sizeText[0].setAttributeNS(null, "stroke-width", "0.4px");
        sizeText[0].setAttributeNS(null, "fill", "#666666");
        sizeText[0].setAttribute("transform", "rotate(0,0,0)");

        //$(sizeText[0]).remove();
        // $("path[stroke-dasharray='bajo2 fillnegro']").closest('g').find('text').remove(); //Elimino el texto que había previamente
        // $("path[stroke-dasharray='bajo2 fillnegro']").parent().append($(sizeText[0]));

        //$(this).append('<text x="'+objetos_plano.top+'" y="'+objetos_plano.left+'" text-anchor="middle" font-family="roboto" stroke="#ffffff" font-size="0.9em" stroke-width="0.2px" class="texto1" fill="white" transform="rotate(0 725.5,65)">'+valueText+'</text>	');
      });
    } else {
      //alertify.error("¡ATENCIÓN! Todos los elementos deben estar dentro de los límites del plano. Rectifica tu plano.");
    }
  }
}, 15000);

/* 
Para evitar el error del círculo verde que bloquea toda la app. 
Si estás dibujando muy cerca del menú, se queda el círculo verde de la esquina
activo y bloquea la app. Por eso, hay que simular como que has marcado el 'select mode'
*/

jQuery("#parte_superior").mouseenter(function () {
  if (jQuery("#circlebinder").length) {
    setTimeout(function () {
      jQuery("#select_mode").trigger("click");
    }, 300);
  }

  //Para corregir el error que se queda un muro marcado
  /*setTimeout(function(){    
    if ($(".circle_css").length == 2)
    {
      $("#parte_superior").attr("style","z-index:0");
       setTimeout(function(){    
         $("#parte_superior").attr("style","z-index:9");
       } , 500)   
    }
   }, 300)
*/

  if (document.getElementById("wallTools").style.display == "none") {
    /* setTimeout(function(){  
      
      if (jQuery(".circle_css").length == 2)
      hideAllSize();
      rib();
    }, 300);
    */
    /*setTimeout(function(){  
      hideAllSize();
      /*rib();
    }, 300);
   */
  }
});
/*
$( "#parte_superior" ).hover(function() {
  setTimeout(function(){    
   if ($(".circle_css").length == 2)
   {
     $("#parte_superior").attr("style","z-index:0");
      setTimeout(function(){    
        $("#parte_superior").attr("style","z-index:9");
      } , 500)   
   }
  }, 500);   
 });
 */
