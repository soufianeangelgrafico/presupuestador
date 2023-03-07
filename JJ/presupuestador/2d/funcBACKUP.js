//init
WALLS = [];
OBJDATA = [];
ROOM = [];
HISTORY = [];
wallSize = 20;
partitionSize = 8;
var drag = 'off';
var action = 0;
var magnetic = 0;
var construc = 0;
var Rcirclebinder = 8;
var mode = 'select_mode';
var modeOption;
taille_w = $('#lin').width();
taille_h = $('#lin').height();
var offset = $('#lin').offset();
grid = 20;
showRib = true;
showArea = true;
meter = 60;
grid_snap = 'off';
colorbackground = "#ffffff";
colorline = "#fff";
colorroom = "#f0daaf";
colorWall = "#666";
pox = 0;
poy = 0;
segment = 0;
xpath = 0;
ypath = 0;
var width_viewbox = taille_w;
var height_viewbox = taille_h;
var ratio_viewbox = height_viewbox / width_viewbox;
var originX_viewbox = 0;
var originY_viewbox = 0;
var zoom = 7;
var factor = 1;

/*var zoom=3;
var factor=0.79;
*/
$(document).on('click', '#crear_paredes', function(event) {

if (typeof contador_muro !== 'undefined') {
	
  if (confirm("Has creado un total de "+contador_muro+" muros. ¿Has finalizado tu plano y quieres añadir información de las paredes?"))
  {
	var contenido="<html>";
	 contenido+=$("html").html();
	 contenido+="</html>";
	  
	 localStorage.setItem('dibujo2d', contenido);
     window.location.assign("https://rehubik.com/presupuestador/2d/paredes/?creadas=0&totales="+contador_muro);  
  }
}
else
{
		alert("Para especificar los puntos de agua y luz de tus paredes, primero debes crear el 2d (plano) de tu cocina");
}
	
});

// **************************************************************************
// *****************   LOAD / SAVE LOCALSTORAGE      ************************
// **************************************************************************

function initHistory(boot = false) {
  HISTORY.index = 0;
  if (!boot && localStorage.getItem('history')) localStorage.removeItem('history');
    if (localStorage.getItem('history') && boot == "recovery") {
      var historyTemp = JSON.parse(localStorage.getItem('history'));
      load(historyTemp.length-1, "boot");
      save("boot");
    }
    if (boot == "newSquare") {
      if (localStorage.getItem('history')) localStorage.removeItem('history');
      HISTORY.push({"objData":[],"wallData":[{"thick":20,"start":{"x":540,"y":194},"end":{"x":540,"y":734},"type":"normal","parent":3,"child":1,"angle":1.5707963267948966,"equations":{"up":{"A":"v","B":550},"down":{"A":"v","B":530},"base":{"A":"v","B":540}},"coords":[{"x":550,"y":204},{"x":530,"y":184},{"x":530,"y":744},{"x":550,"y":724}],"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":540,"y":734},"end":{"x":1080,"y":734},"type":"normal","parent":0,"child":2,"angle":0,"equations":{"up":{"A":"h","B":724},"down":{"A":"h","B":744},"base":{"A":"h","B":734}},"coords":[{"x":550,"y":724},{"x":530,"y":744},{"x":1090,"y":744},{"x":1070,"y":724}],"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1080,"y":734},"end":{"x":1080,"y":194},"type":"normal","parent":1,"child":3,"angle":-1.5707963267948966,"equations":{"up":{"A":"v","B":1070},"down":{"A":"v","B":1090},"base":{"A":"v","B":1080}},"coords":[{"x":1070,"y":724},{"x":1090,"y":744},{"x":1090,"y":184},{"x":1070,"y":204}],"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1080,"y":194},"end":{"x":540,"y":194},"type":"normal","parent":2,"child":0,"angle":3.141592653589793,"equations":{"up":{"A":"h","B":204},"down":{"A":"h","B":184},"base":{"A":"h","B":194}},"coords":[{"x":1070,"y":204},{"x":1090,"y":184},{"x":530,"y":184},{"x":550,"y":204}],"graph":{"0":{},"context":{},"length":1}}],"roomData":[{"coords":[{"x":540,"y":734},{"x":1080,"y":734},{"x":1080,"y":194},{"x":540,"y":194},{"x":540,"y":734}],"coordsOutside":[{"x":1090,"y":744},{"x":1090,"y":184},{"x":530,"y":184},{"x":530,"y":744},{"x":1090,"y":744}],"coordsInside":[{"x":1070,"y":724},{"x":1070,"y":204},{"x":550,"y":204},{"x":550,"y":724},{"x":1070,"y":724}],"inside":[],"way":["0","2","3","1","0"],"area":270400,"surface":"","name":"","color":"gradientWhite","showSurface":true,"action":"add"}]});
      HISTORY[0] = JSON.stringify(HISTORY[0]);
      localStorage.setItem('history', JSON.stringify(HISTORY));
      load(0);
      save();
    }
    if (boot == "newL") {
      if (localStorage.getItem('history')) localStorage.removeItem('history');
      HISTORY.push({"objData":[],"wallData":[{"thick":20,"start":{"x":447,"y":458},"end":{"x":447,"y":744},"type":"normal","parent":5,"child":1,"angle":1.5707963267948966,"equations":{"up":{"A":"v","B":457},"down":{"A":"v","B":437},"base":{"A":"v","B":447}},"coords":[{"x":457,"y":468},{"x":437,"y":448},{"x":437,"y":754},{"x":457,"y":734}],"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":447,"y":744},"end":{"x":1347,"y":744},"type":"normal","parent":0,"child":2,"angle":0,"equations":{"up":{"A":"h","B":734},"down":{"A":"h","B":754},"base":{"A":"h","B":744}},"coords":[{"x":457,"y":734},{"x":437,"y":754},{"x":1357,"y":754},{"x":1337,"y":734}],"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1347,"y":744},"end":{"x":1347,"y":144},"type":"normal","parent":1,"child":3,"angle":-1.5707963267948966,"equations":{"up":{"A":"v","B":1337},"down":{"A":"v","B":1357},"base":{"A":"v","B":1347}},"coords":[{"x":1337,"y":734},{"x":1357,"y":754},{"x":1357,"y":134},{"x":1337,"y":154}],"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1347,"y":144},"end":{"x":1020,"y":144},"type":"normal","parent":2,"child":4,"angle":3.141592653589793,"equations":{"up":{"A":"h","B":154},"down":{"A":"h","B":134},"base":{"A":"h","B":144}},"coords":[{"x":1337,"y":154},{"x":1357,"y":134},{"x":1010,"y":134},{"x":1030,"y":154}],"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1020,"y":144},"end":{"x":1020,"y":458},"type":"normal","parent":3,"child":5,"angle":1.5707963267948966,"equations":{"up":{"A":"v","B":1030},"down":{"A":"v","B":1010},"base":{"A":"v","B":1020}},"coords":[{"x":1030,"y":154},{"x":1010,"y":134},{"x":1010,"y":448},{"x":1030,"y":468}],"graph":{"0":{},"context":{},"length":1}},{"thick":20,"start":{"x":1020,"y":458},"end":{"x":447,"y":458},"type":"normal","parent":4,"child":0,"angle":3.141592653589793,"equations":{"up":{"A":"h","B":468},"down":{"A":"h","B":448},"base":{"A":"h","B":458}},"coords":[{"x":1030,"y":468},{"x":1010,"y":448},{"x":437,"y":448},{"x":457,"y":468}],"graph":{"0":{},"context":{},"length":1}}],"roomData":[{"coords":[{"x":447,"y":744},{"x":1347,"y":744},{"x":1347,"y":144},{"x":1020,"y":144},{"x":1020,"y":458},{"x":447,"y":458},{"x":447,"y":744}],"coordsOutside":[{"x":1357,"y":754},{"x":1357,"y":134},{"x":1010,"y":134},{"x":1010,"y":448},{"x":437,"y":448},{"x":437,"y":754},{"x":1357,"y":754}],"coordsInside":[{"x":1337,"y":734},{"x":1337,"y":154},{"x":1030,"y":154},{"x":1030,"y":468},{"x":457,"y":468},{"x":457,"y":734},{"x":1337,"y":734}],"inside":[],"way":["0","2","3","4","5","1","0"],"area":330478,"surface":"","name":"","color":"gradientWhite","showSurface":true,"action":"add"}]});
      HISTORY[0] = JSON.stringify(HISTORY[0]);
      localStorage.setItem('history', JSON.stringify(HISTORY));
      load(0);
      save();
    }
}

document.getElementById('redo').addEventListener("click", function() {
  if (HISTORY.index < HISTORY.length) {
    load(HISTORY.index);
    HISTORY.index++;
    $('#undo').removeClass('disabled');
    if (HISTORY.index == HISTORY.length) {
      $('#redo').addClass('disabled');
    }
  }
});

document.getElementById('undo').addEventListener("click", function() {
  if (HISTORY.index > 0) {
    $('#undo').removeClass('disabled');
    if (HISTORY.index-1 >0) {
      HISTORY.index--;
      load(HISTORY.index-1);
      $('#redo').removeClass('disabled');
    }
  }
  if (HISTORY.index == 1) $('#undo').addClass('disabled');
});

function save(boot = false) {
  if (boot) localStorage.removeItem('history');
  // FOR CYCLIC OBJ INTO LOCALSTORAGE !!!
  for (var k in WALLS) {
    if (WALLS[k].child != null) WALLS[k].child = WALLS.indexOf(WALLS[k].child);
    if (WALLS[k].parent != null) WALLS[k].parent = WALLS.indexOf(WALLS[k].parent);
  }
  if (JSON.stringify({objData: OBJDATA, wallData: WALLS, roomData: ROOM}) == HISTORY[HISTORY.length-1]) {
    for (var k in WALLS) {
      if (WALLS[k].child != null) WALLS[k].child = WALLS[WALLS[k].child];
      if (WALLS[k].parent != null) WALLS[k].parent = WALLS[WALLS[k].parent];
    }
    return false;
  }

  if (HISTORY.index < HISTORY.length) {
    HISTORY.splice(HISTORY.index, (HISTORY.length - HISTORY.index));
    $('#redo').addClass('disabled');
  }
  HISTORY.push(JSON.stringify({objData: OBJDATA, wallData: WALLS, roomData: ROOM}));
  localStorage.setItem('history', JSON.stringify(HISTORY));
  HISTORY.index++;
  if (HISTORY.index>1) $('#undo').removeClass('disabled');
  for (var k in WALLS) {
    if (WALLS[k].child != null) WALLS[k].child = WALLS[WALLS[k].child];
    if (WALLS[k].parent != null) WALLS[k].parent = WALLS[WALLS[k].parent];
  }
  return true;
}

function load(index = HISTORY.index, boot = false) {
  if (HISTORY.length == 0 && !boot) return false;
  for (var k in OBJDATA){
    OBJDATA[k].graph.remove();
  }
  OBJDATA = [];
  var historyTemp = [];
  historyTemp = JSON.parse(localStorage.getItem('history'));
  historyTemp = JSON.parse(historyTemp[index]);

  for (var k in historyTemp.objData) {
    var OO = historyTemp.objData[k];
    // if (OO.family == 'energy') OO.family = 'byObject';
    var obj = new editor.obj2D(OO.family, OO.class, OO.type, {x: OO.x, y: OO.y}, OO.angle, OO.angleSign, OO.size, OO.hinge = 'normal', OO.thick, OO.value);
    obj.limit = OO.limit;
    OBJDATA.push(obj);
    $('#boxcarpentry').append(OBJDATA[OBJDATA.length-1].graph);
    obj.update();
  }
  WALLS = historyTemp.wallData;
  for (var k in WALLS) {
    if (WALLS[k].child != null) WALLS[k].child = WALLS[WALLS[k].child];
    if (WALLS[k].parent != null) WALLS[k].parent = WALLS[WALLS[k].parent];
  }
  ROOM = historyTemp.roomData;
  editor.architect(WALLS);
  editor.showScaleBox();
  rib();
}

$('svg').each(function() {
    $(this)[0].setAttribute('viewBox', originX_viewbox + ' ' + originY_viewbox + ' ' + width_viewbox + ' ' + height_viewbox)
});

// **************************************************************************
// *****************   FUNCTIONS ON BUTTON click     ************************
// **************************************************************************
/*
document.getElementById('report_mode').addEventListener("click", function() {
  if (typeof(globalArea) == "undefined") return false;
  mode = "report_mode";
  $('#panel').hide();
  $('#reportTools').show(200, function() {
    document.getElementById('reportTotalSurface').innerHTML = "Total de la surface : <b>"+(globalArea/3600).toFixed(1)+ "</b> m²";
    $('#reportTotalSurface').show(1000);
    document.getElementById('reportNumberSurface').innerHTML = "Nombre pièces : <b>"+ROOM.length+ "</b>";
    $('#reportNumberSurface').show(1000);
    var number = 1;
    var reportRoom = '<div class="row">\n';
    for (var k in ROOM) {
      var nameRoom = "Pièce n°"+number+" <small>(sans nom)</small>";
      if (ROOM[k].name != "") nameRoom = ROOM[k].name;
      reportRoom+= '<div class="col-md-6"><p>'+nameRoom+'</p></div>\n';
      reportRoom+= '<div class="col-md-6"><p>Surface : <b>'+((ROOM[k].area)/3600).toFixed(2)+'</b> m²</p></div>\n';
      number++;
    }
    reportRoom+='</div><hr/>\n';
    reportRoom+='<div>\n';
    var switchNumber = 0;
    var plugNumber = 0;
    var lampNumber = 0;
    for (var k in OBJDATA) {
      if (OBJDATA[k].class == 'energy') {
        if (OBJDATA[k].type == 'switch' || OBJDATA[k].type == 'doubleSwitch' || OBJDATA[k].type == 'dimmer') switchNumber++;
        if (OBJDATA[k].type == 'plug' || OBJDATA[k].type == 'plug20' || OBJDATA[k].type == 'plug32') plugNumber++;
        if (OBJDATA[k].type == 'wallLight' || OBJDATA[k].type == 'roofLight') lampNumber++;
      }
    }
    reportRoom+='<p>Nombre d\'interrupteur(s) : '+switchNumber+'</p>';
    reportRoom+='<p>Nombre de prise(s) secteur : '+plugNumber+'</p>';
    reportRoom+='<p>Nombre de point(s) de lumière : '+lampNumber+'</p>';
    reportRoom+='</div>';
    reportRoom+='<div>\n';
    reportRoom+='<h2>Répartition énergie par pièce</h2>\n';
    var number = 1;
    reportRoom+= '<div class="row">\n';
    reportRoom+= '<div class="col-md-4"><p>Libellé</p></div>\n';
    reportRoom+= '<div class="col-md-2"><small>Int.</small></div>\n';
    reportRoom+= '<div class="col-md-2"><small>Pri. sec.</small></div>\n';
    reportRoom+= '<div class="col-md-2"><small>Pt lum.</small></div>\n';
    reportRoom+= '<div class="col-md-2"><small>Watts Max</small></div>\n';
    reportRoom+='</div>';

    var roomEnergy = [];
    for (var k in ROOM) {
      reportRoom+= '<div class="row">\n';
      var nameRoom = "Pièce n°"+number+" <small>(sans nom)</small>";
      if (ROOM[k].name != "") nameRoom = ROOM[k].name;
      reportRoom+= '<div class="col-md-4"><p>'+nameRoom+'</p></div>\n';
      var switchNumber = 0;
      var plugNumber = 0;
      var plug20 = 0;
      var plug32 = 0;
      var lampNumber = 0;
      var wattMax = 0;
      var plug = false;
      for (var i in OBJDATA) {
        if (OBJDATA[i].class == 'energy') {
          if (OBJDATA[i].type == 'switch' || OBJDATA[i].type == 'doubleSwitch' || OBJDATA[i].type == 'dimmer') {
            if (roomTarget = editor.rayCastingRoom(OBJDATA[i])) {
              if (isObjectsEquals(ROOM[k], roomTarget)) switchNumber++;
            }
          }
          if (OBJDATA[i].type == 'plug' || OBJDATA[i].type == 'plug20' || OBJDATA[i].type == 'plug32') {
            if (roomTarget = editor.rayCastingRoom(OBJDATA[i])) {
              if (isObjectsEquals(ROOM[k], roomTarget)) {
                plugNumber++;
                if (OBJDATA[i].type == 'plug' && !plug) {wattMax+=3520;plug = true;}
                if (OBJDATA[i].type == 'plug20') {wattMax+=4400;plug20++;}
                if (OBJDATA[i].type == 'plug32') {wattMax+=7040;plug32++;}
              }
            }
          }
          if (OBJDATA[i].type == 'wallLight' || OBJDATA[i].type == 'roofLight') {
            if (roomTarget = editor.rayCastingRoom(OBJDATA[i])) {
              if (isObjectsEquals(ROOM[k], roomTarget)) {
              lampNumber++;
               wattMax+=100;
              }
            }
          }
        }
      }
      roomEnergy.push({switch: switchNumber, plug: plugNumber, plug20: plug20, plug32: plug32, light: lampNumber});
      reportRoom+= '<div class="col-md-2"><b>'+switchNumber+'</b></div>\n';
      reportRoom+= '<div class="col-md-2"><b>'+plugNumber+'</b></div>\n';
      reportRoom+= '<div class="col-md-2"><b>'+lampNumber+'</b></div>\n';
      reportRoom+= '<div class="col-md-2"><b>'+wattMax+'</b></div>\n';
      number++;
      reportRoom+='</div>';
    }
    reportRoom+='<hr/><h2>Détails Norme NF C 15-100</h2>\n';
    var number = 1;

    for (var k in ROOM) {
      reportRoom+= '<div class="row">\n';
      var nfc = true;
      var nameRoom = "Pièce n°"+number+" <small>(sans nom)</small>";
      if (ROOM[k].name != "") nameRoom = ROOM[k].name;
      reportRoom+= '<div class="col-md-4"><p>'+nameRoom+'</p></div>\n';
      if (ROOM[k].name == "") {
        reportRoom+= '<div class="col-md-8"><p><i class="fa fa-ban" aria-hidden="true" style="color:red"></i> La pièce n\'ayant pas de libellé, Home Rough Editor ne peut vous fournir d\'informations.</p></div>\n';
      }
      else {
        if (ROOM[k].name == "Salon") {
          for (var g in ROOM) {
            if (ROOM[g].name == "Salle à manger") {
              roomEnergy[k].light+=roomEnergy[g].light;
              roomEnergy[k].plug+=roomEnergy[g].plug;
              roomEnergy[k].switch+=roomEnergy[g].switch;
            }
          }
          reportRoom+= '<div class="col-md-8">';
          if (roomEnergy[k].light == 0) {reportRoom+= '<p><i class="fa fa-exclamation-triangle" style="color:orange" aria-hidden="true"></i> Cette pièce doit disposer d\'au moins <b>1 point lumineux commandé</b> <small>(actuellement '+roomEnergy[k].light+')</small>.</p>\n';nfc=false;}
          if (roomEnergy[k].plug < 5) {reportRoom+= '<p><i class="fa fa-exclamation-triangle" style="color:orange" aria-hidden="true"></i> Cette pièce doit disposer d\'au moins <b>5 prises de courant</b> <small>(actuellement '+roomEnergy[k].plug+')</small>.</p>\n';nfc=false;}
          if (nfc) reportRoom+='<i class="fa fa-check" aria-hidden="true" style="color:green"></i>';
          reportRoom+= '</div>';
        }
        if (ROOM[k].name == "Salle à manger") {
          reportRoom+= '<div class="col-md-8"><p><i class="fa fa-info" aria-hidden="true" style="color:blue"></i> Cette pièce est liée au <b>salon / séjour</b> selon la norme.</p></div>\n';
        }
        if (ROOM[k].name.substr(0,7) == "Chambre") {
          reportRoom+= '<div class="col-md-8">';
          if (roomEnergy[k].light == 0) {reportRoom+= '<p><i class="fa fa-exclamation-triangle" style="color:orange" aria-hidden="true"></i> Cette pièce doit disposer d\'au moins <b>1 point lumineux commandé</b> <small>(actuellement '+roomEnergy[k].light+')</small>.</p>\n';nfc=false;}
          if (roomEnergy[k].plug < 3) {reportRoom+= '<p><i class="fa fa-exclamation-triangle" style="color:orange" aria-hidden="true"></i> Cette pièce doit disposer d\'au moins <b>3 prises de courant</b> <small>(actuellement '+roomEnergy[k].plug+')</small>.</p>\n';nfc=false;}
          if (nfc) reportRoom+='<i class="fa fa-check" aria-hidden="true" style="color:green"></i>';
          reportRoom+= '</div>';
        }
        if (ROOM[k].name == "SdB") {
          reportRoom+= '<div class="col-md-8">';
          if (roomEnergy[k].light == 0) {reportRoom+= '<p><i class="fa fa-exclamation-triangle" style="color:orange" aria-hidden="true"></i> Cette pièce doit disposer d\'au moins <b>1 point lumineux</b> <small>(actuellement '+roomEnergy[k].light+')</small>.</p>\n';nfc=false;}
          if (roomEnergy[k].plug < 2) {reportRoom+= '<p><i class="fa fa-exclamation-triangle" style="color:orange" aria-hidden="true"></i> Cette pièce doit disposer d\'au moins <b>2 prises de courant</b> <small>(actuellement '+roomEnergy[k].plug+')</small>.</p>\n';nfc=false;}
          if (roomEnergy[k].switch == 0) {reportRoom+= '<p><i class="fa fa-exclamation-triangle" style="color:orange" aria-hidden="true"></i> Cette pièce doit disposer d\'au moins <b>1 interrupteur</b> <small>(actuellement '+roomEnergy[k].switch+')</small>.</p>\n';nfc=false;}
          if (nfc) reportRoom+='<i class="fa fa-check" aria-hidden="true" style="color:green"></i>';
          reportRoom+= '</div>';
        }
        if (ROOM[k].name == "Couloir") {
          reportRoom+= '<div class="col-md-8">';
          if (roomEnergy[k].light == 0) {reportRoom+= '<p><i class="fa fa-exclamation-triangle" style="color:orange" aria-hidden="true"></i> Cette pièce doit disposer d\'au moins <b>1 point lumineux commandé</b> <small>(actuellement '+roomEnergy[k].light+')</small>.</p>\n';nfc=false;}
          if (roomEnergy[k].plug < 1) {reportRoom+= '<p><i class="fa fa-exclamation-triangle" style="color:orange" aria-hidden="true"></i> Cette pièce doit disposer d\'au moins <b>1 prise de courant</b> <small>(actuellement '+roomEnergy[k].plug+')</small>.</p>\n';nfc=false;}
          if (nfc) reportRoom+='<i class="fa fa-check" aria-hidden="true" style="color:green"></i>';
          reportRoom+= '</div>';
        }
        if (ROOM[k].name == "Toilette") {
          reportRoom+= '<div class="col-md-8">';
          if (roomEnergy[k].light == 0) {reportRoom+= '<p><i class="fa fa-exclamation-triangle" style="color:orange" aria-hidden="true"></i> Cette pièce doit disposer d\'au moins <b>1 point lumineux</b>. <small>(actuellement '+roomEnergy[k].light+')</small>.</p>\n';nfc=false;}
          if (nfc) reportRoom+='<i class="fa fa-check" aria-hidden="true" style="color:green"></i>';
          reportRoom+= '</div>';
        }
        if (ROOM[k].name == "Cuisine") {
          reportRoom+= '<div class="col-md-8">';
          if (roomEnergy[k].light == 0) {reportRoom+= '<p><i class="fa fa-exclamation-triangle" style="color:orange" aria-hidden="true"></i> Cette pièce doit disposer d\'au moins <b>1 point lumineux commandé</b> <small>(actuellement '+roomEnergy[k].light+')</small>.</p>\n';nfc=false;}
          if (roomEnergy[k].plug < 6) {reportRoom+= '<p><i class="fa fa-exclamation-triangle" style="color:orange" aria-hidden="true"></i> Cette pièce doit disposer d\'au moins <b>6 prise de courant</b> <small>(actuellement '+roomEnergy[k].plug+')</small>.</p>\n';nfc=false;}
          if (roomEnergy[k].plug32 == 0) {reportRoom+= '<p><i class="fa fa-exclamation-triangle" style="color:orange" aria-hidden="true"></i> Cette pièce doit disposer d\'au moins <b>1 prise de courant 32A</b> <small>(actuellement '+roomEnergy[k].plug32+')</small>.</p>\n';nfc=false;}
          if (roomEnergy[k].plug20 < 2) {reportRoom+= '<p><i class="fa fa-exclamation-triangle" style="color:orange" aria-hidden="true"></i> Cette pièce doit disposer d\'au moins <b>2 prise de courant 20A</b> <small>(actuellement '+roomEnergy[k].plug20+')</small>.</p>\n';nfc=false;}
          if (nfc) reportRoom+='<i class="fa fa-check" aria-hidden="true" style="color:green"></i>';
          reportRoom+= '</div>';
        }
      }
      number++;
      reportRoom+='</div>';
    }

    document.getElementById('reportRooms').innerHTML = reportRoom;
    $('#reportRooms').show(1000);
  });


});
*/
document.getElementById('wallWidth').addEventListener("input", function() {
	
	//miro que muro está modificando y asigno el valor INTERIOR en m2 a la pared que corresponde 
  var muro_modifica=this.className;
  console.log("Modificando pared "+muro_modifica+" con un valor de "+this.value);
  var cadena = $("#wallWidthScale").text();
  console.log("La cadena es "+cadena); 
	
  var valormetros = cadena.split(" -"); // posicion 0 = metros cuadrados posición 1 - LETRA
  //valormetros[0]=this.value; //reemplazo los m2 por lo que él haya escrito en el input
	
  if (muro_modifica == "muro1")
   {
	 //$(".texto1").html=this.value;
	 
	 //Asigno los m2 y el texto que tenía la cadena (A,B,C,D.... que en definitiva, es el muro)
	 document.getElementsByClassName("texto1")[0].innerHTML=this.value+" - "+valormetros[1]; 
	   //console.log("elementos "+elementos);
   } 
  else if (muro_modifica == "muro2")
  {
    document.getElementsByClassName("texto2")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro3")
  {

    document.getElementsByClassName("texto3")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro4")
  {
   
    document.getElementsByClassName("texto4")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro5")
  {
  
    document.getElementsByClassName("texto5")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro6")
  {
  
    document.getElementsByClassName("texto6")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro7")
  {
  
    document.getElementsByClassName("texto7")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro8")
  {
   
    document.getElementsByClassName("texto8")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro9")
  {
   
    document.getElementsByClassName("texto9")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro10")
  {
   
    document.getElementsByClassName("texto10")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro11")
  {
    
    document.getElementsByClassName("texto11")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro12")
  {
   
    document.getElementsByClassName("texto12")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro13")
  {
   
    document.getElementsByClassName("texto13")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro14")
  {
  
    document.getElementsByClassName("texto14")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro15")
  {
  
    document.getElementsByClassName("texto15")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro16")
  {
    
    document.getElementsByClassName("texto16")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro17")
  {
    
    document.getElementsByClassName("texto17")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }	
  else if (muro_modifica == "muro18")
  {
    
    document.getElementsByClassName("texto18")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }	
  else if (muro_modifica == "muro19")
  {
    
    document.getElementsByClassName("texto19")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
  else if (muro_modifica == "muro20")
  {
    
    document.getElementsByClassName("texto20")[0].innerHTML=this.value+" - "+valormetros[1]; 
  }
	
  /*var sliderValue = this.value;
  binder.wall.thick = 1;
  binder.wall.type = "normal";
  editor.architect(WALLS);
  var objWall = editor.objFromWall(binder.wall); // LIST OBJ ON EDGE
  for (var w = 0; w < objWall.length; w++) {
    objWall[w].thick = 1;
    objWall[w].update();
  }
  //rib();
  document.getElementById("wallWidthVal").textContent = sliderValue;*/
});

document.getElementById("bboxTrash").addEventListener("click", function () {
	console.log("eliminando");
	console.log(binder.obj);
  binder.obj.graph.remove();
  binder.graph.remove();
  OBJDATA.splice(OBJDATA.indexOf(binder.obj), 1);
  $('#objBoundingBox').hide(100);
  $('#panel').show(200);
  fonc_button('select_mode');
  $('#boxinfo').html('Objeto eliminado');
  delete binder;
  rib();
});

document.getElementById("bboxStepsAdd").addEventListener("click", function () {
  var newValue = document.getElementById("bboxStepsVal").textContent;
  if (newValue < 15) {
    newValue++;
    binder.obj.value  = newValue;
    binder.obj.update();
    document.getElementById("bboxStepsVal").textContent = newValue;
  }
});

document.getElementById("bboxStepsMinus").addEventListener("click", function () {
  var newValue = document.getElementById("bboxStepsVal").textContent;
  if (newValue > 2) {
    newValue--;
    binder.obj.value  = newValue;
    binder.obj.update();
    document.getElementById("bboxStepsVal").textContent = newValue;
  }
});

document.getElementById('bboxWidth').addEventListener("input", function() {
  var sliderValue = this.value;
  var objTarget = binder.obj;
  objTarget.size  = (sliderValue / 100) * meter;
  objTarget.update();
  binder.size = (sliderValue / 100) * meter;
  binder.update();
  document.getElementById("bboxWidthVal").textContent = sliderValue;
});

document.getElementById('bboxHeight').addEventListener("input", function() {
  var sliderValue = this.value;
  var objTarget = binder.obj;
  objTarget.thick  = (sliderValue / 100) * meter;
  objTarget.update();
  binder.thick = (sliderValue / 100) * meter;
  binder.update();
  document.getElementById("bboxHeightVal").textContent = sliderValue;
});

document.getElementById('bboxRotation').addEventListener("input", function() {
    var sliderValue = this.value;
    var objTarget = binder.obj;
    objTarget.angle  = sliderValue;
    objTarget.update();
    binder.angle = sliderValue;
    binder.update();
    document.getElementById("bboxRotationVal").textContent = sliderValue;
  });

document.getElementById('doorWindowWidth').addEventListener("input", function() {
  var sliderValue = this.value;
  var objTarget = binder.obj;
  var wallBind = editor.rayCastingWalls(objTarget, WALLS);
  if (wallBind.length > 1) wallBind = wallBind[wallBind.length-1];
  var limits = limitObj(wallBind.equations.base, sliderValue, objTarget);
  if (qSVG.btwn(limits[1].x, wallBind.start.x, wallBind.end.x) && qSVG.btwn(limits[1].y, wallBind.start.y, wallBind.end.y) && qSVG.btwn(limits[0].x, wallBind.start.x, wallBind.end.x) && qSVG.btwn(limits[0].y, wallBind.start.y, wallBind.end.y)) {
    objTarget.size  = sliderValue;
    objTarget.limit = limits;
    objTarget.update();
    binder.size  = sliderValue;
    binder.limit = limits;
    binder.update();
    document.getElementById("doorWindowWidthVal").textContent = sliderValue;
  }
  inWallRib(wallBind);
});

document.getElementById("objToolsHinge").addEventListener("click", function () {
  var objTarget = binder.obj;
  var hingeStatus = objTarget.hinge; // normal - reverse
  if (hingeStatus == 'normal') objTarget.hinge = 'reverse';
  else objTarget.hinge = 'normal';
  objTarget.update();
});

window.addEventListener("load", function(){
  document.getElementById('panel').style.transform = "translateX(200px)";
  document.getElementById('panel').addEventListener("transitionend", function() {
    document.getElementById('moveBox').style.transform = "translateX(-165px)";
    document.getElementById('zoomBox').style.transform = "translateX(-165px)";
  });
  if (!localStorage.getItem('history')) $('#recover').html("<p style='display:none;'>Selecciona un modelo de cocina.</p>");
  $('#myModal').modal();
});

document.getElementById('sizePolice').addEventListener("input", function() {
  document.getElementById('labelBox').style.fontSize = this.value+'px';
});

$('#textToLayer').on('hidden.bs.modal', function (e) {
  fonc_button('select_mode');
  action = 0;
  var textToMake = document.getElementById('labelBox').textContent;
  if (textToMake != "" && textToMake != "Votre texte") {
    binder = new editor.obj2D("free", "text", document.getElementById('labelBox').style.color, snap, 0, 0, 0, "normal", 0, {text: textToMake, size: document.getElementById('sizePolice').value});
    binder.update();
    OBJDATA.push(binder);
    binder.graph.remove();
    $('#boxText').append(OBJDATA[OBJDATA.length-1].graph);
    OBJDATA[OBJDATA.length-1].update();
    delete binder;
    $('#boxinfo').html('Texte ajouté');
    save();
  }
  else {
    $('#boxinfo').html('Modo selección');
  }
  document.getElementById('labelBox').textContent = "Votre texte";
  document.getElementById('labelBox').style.color = "#333333";
  document.getElementById('labelBox').style.fontSize = "15px";
  document.getElementById('sizePolice').value = 15;
})

if (!Array.prototype.includes) {
  Object.defineProperty(Array.prototype, 'includes', {
    value: function(searchElement, fromIndex) {
      if (this == null) {
        throw new TypeError('"this" is null or not defined');
      }

      var o = Object(this);
      var len = o.length >>> 0;
      if (len === 0) {
        return false;
      }
      var n = fromIndex | 0;
      var k = Math.max(n >= 0 ? n : len - Math.abs(n), 0);

      while (k < len) {
        if (o[k] === searchElement) {
          return true;
        }
        k++;
      }
      return false;
    }
  });
}

function isObjectsEquals(a, b, message = false) {
  if (message) console.log(message)
  var isOK = true;
  for (var prop in a) {
    if (a[prop] !== b[prop]) {
      isOK = false;
      break;
    }
  }
  return isOK;
};

function throttle(callback, delay) {
    var last;
    var timer;
    return function () {
        var context = this;
        var now = +new Date();
        var args = arguments;
        if (last && now < last + delay) {
            // le délai n'est pas écoulé on reset le timer
            clearTimeout(timer);
            timer = setTimeout(function () {
                last = now;
                callback.apply(context, args);
            }, delay);
        } else {
            last = now;
            callback.apply(context, args);
        }
    };
}
/*
OCULTO PARA EVITAR PROBLEMA CON DISTANCIA ENTRE OBJETOS
$("#lin").mousewheel(throttle(function(event) {
    event.preventDefault();
    if (event.deltaY > 0) {
        zoom_maker('zoomin', 200);
    } else {
        zoom_maker('zoomout', 200);
    }
},100));
*/
/*
document.getElementById("showRib").addEventListener("click", function () {
  if (document.getElementById("showRib").checked) {
    $('#boxScale').show(200);
    $('#boxRib').show(200);
    showRib = true;
  }
  else {
    $('#boxScale').hide(100);
    $('#boxRib').hide(100);
    showRib = false;
  }
});
*/

/*
document.getElementById("showArea").addEventListener("click", function () {
  if (document.getElementById("showArea").checked) {
    $('#boxArea').show(200);
  }
  else {
    $('#boxArea').hide(100);
  }
});

document.getElementById("showLayerRoom").addEventListener("click", function () {
  if (document.getElementById("showLayerRoom").checked) {
    $('#boxRoom').show(200);
  }
  else {
    $('#boxRoom').hide(100);
  }
});
*/

/*
document.getElementById("showLayerEnergy").addEventListener("click", function () {
  if (document.getElementById("showLayerEnergy").checked) {
    $('#boxEnergy').show(200);
  }
  else {
    $('#boxEnergy').hide(100);
  }
});
*/


// document.getElementById("showLayerFurniture").addEventListener("click", function () {
//   if (document.getElementById("showLayerFurniture").checked) {
//     $('#boxFurniture').show(200);
//   }
//   else {
//     $('#boxFurniture').hide(100);
//   }
// });

document.getElementById("applySurface").addEventListener("click", function () {
      $('#roomTools').hide(100);
      $('#panel').show(200);
      binder.remove();
      delete binder;
      var id = $('#roomIndex').val();
      //COLOR
      var data = $('#roomBackground').val();
      ROOM[id].color = data;
      //ROOM NAME
      var roomName = $('#roomName').val();
      if (roomName == 'None') roomName = '';
      ROOM[id].name = roomName;
      //ROOM SURFACE
      var area = $('#roomSurface').val();
      ROOM[id].surface = area;
      //SHOW SURFACE
      var show = document.querySelector("#seeArea").checked;
      ROOM[id].showSurface = show;
      //ACTION PARAM
      var action = document.querySelector('input[type=radio]:checked').value;
      ROOM[id].action = action;
      if (action == 'sub') ROOM[id].color = 'hatch';
      if (action != 'sub' && data == 'hatch') ROOM[id].color = 'gradientNeutral';
      $('#boxRoom').empty();
      $('#boxSurface').empty();
      editor.roomMaker(Rooms);
      $('#boxinfo').html('Parte modificada');
      fonc_button('select_mode');
});

document.getElementById("resetRoomTools").addEventListener("click", function () {
  $('#roomTools').hide(100);
  $('#panel').show(200);
  binder.remove();
  delete binder;
  $('#boxinfo').html('Parte modificada');
  fonc_button('select_mode');

});

document.getElementById("wallTrash").addEventListener("click", function () {
  var wall = binder.wall;
	console.log("Wall Trash ");
	console.log(wall);
  for (var k in WALLS) {
      if (isObjectsEquals(WALLS[k].child, wall)) WALLS[k].child = null;
      if (isObjectsEquals(WALLS[k].parent, wall)) {WALLS[k].parent = null;}
  }
  WALLS.splice(WALLS.indexOf(wall),1);
  $('#wallTools').hide(100);
  wall.graph.remove();
  binder.graph.remove();
  editor.architect(WALLS);
  rib();
  mode = "select_mode";
  $('#panel').show(200);
});

var textEditorColorBtn = document.querySelectorAll('.textEditorColor');
  for (var k = 0; k < textEditorColorBtn.length; k++) {
    textEditorColorBtn[k].addEventListener('click', function(){
      document.getElementById('labelBox').style.color = this.style.color;
    });
}

var zoomBtn = document.querySelectorAll('.zoom');
  for (var k = 0; k < zoomBtn.length; k++) {
    zoomBtn[k].addEventListener("click", function () {
        lens = this.getAttribute('data-zoom');
        zoom_maker(lens, 200, 50);
    })
}

var roomColorBtn = document.querySelectorAll(".roomColor");
  for (var k = 0; k < roomColorBtn.length; k++) {
    roomColorBtn[k].addEventListener("click", function () {
      var data = this.getAttribute('data-type');
      $('#roomBackground').val(data);
      binder.attr({'fill':'url(#'+data+')'});
    });
  }

var objTrashBtn = document.querySelectorAll(".objTrash");
  for (var k = 0; k < objTrashBtn.length; k++) {
    objTrashBtn[k].addEventListener("click", function () {
      $('#objTools').hide('100');
      var obj = binder.obj;
      obj.graph.remove();
      OBJDATA.splice(OBJDATA.indexOf(obj), 1);
      fonc_button('select_mode');
      $('#boxinfo').html('Mode sélection');
      $('#panel').show('200');
      binder.graph.remove();
      delete binder;
      rib();
      $('#panel').show('300');
    });
}

var dropdownMenu = document.querySelectorAll(".dropdown-menu li a");
  for (var k = 0; k < dropdownMenu.length; k++) {
    dropdownMenu[k].addEventListener("click", function () {
      var selText = this.textContent;
      $(this).parents('.btn-group').find('.dropdown-toggle').html(selText+' <span class="caret"></span>');
      if (selText != 'None') $('#roomName').val(selText);
      else $('#roomName').val('');
    });
  }

// TRY MATRIX CALC FOR BBOX REAL COORDS WITH TRAS + ROT.
function matrixCalc(el, message = false) {
  if (message) console.log("matrixCalc called by -> "+message);
  var m = el.getCTM();
  var bb = el.getBBox();
  var tpts = [
    matrixXY(m,bb.x,bb.y),
    matrixXY(m,bb.x+bb.width,bb.y),
    matrixXY(m,bb.x+bb.width,bb.y+bb.height),
    matrixXY(m,bb.x,bb.y+bb.height)];
  return tpts;
}
function matrixXY(m,x,y) {
            return { x: x * m.a + y * m.c + m.e, y: x * m.b + y * m.d + m.f };
}
function realBboxShow(coords) {
  for (var k in coords) {
    debugPoint(coords[k]);
  }
}


function limitObj(equation, size, coords,message = false) {
  if (message) console.log(message)
  var Px = coords.x;
  var Py = coords.y;
  var Aq =  equation.A;
  var Bq =  equation.B;
  if (Aq == 'v') {
    var pos1 = {x: Px, y: Py - size/2};
    var pos2 = {x: Px, y: Py + size/2};
  }
  else if (Aq == 'h') {
    var pos1 = {x: Px - size/2, y: Py};
    var pos2 = {x: Px + size/2, y: Py};
  }
  else {
    var A = 1 + Aq*Aq;
    var B = (-2 * Px) + (2 * Aq * Bq) + (-2 * Py * Aq);
    var C = (Px*Px) + (Bq*Bq) - (2*Py*Bq) + (Py*Py) - (size*size)/4; // -N
    var Delta = (B*B) - (4*A*C);
    var posX1 = (-B-(Math.sqrt(Delta))) / (2*A);
    var posX2 = (-B+(Math.sqrt(Delta))) / (2*A);
    var pos1 = {x: posX1, y: (Aq * posX1) + Bq};
    var pos2 = {x: posX2, y: (Aq * posX2) + Bq};
  }
  return [pos1, pos2];
}

function zoom_maker(lens, xmove, xview) {
	console.log("Factor es "+factor);
    if (lens == 'zoomout' && zoom > 1 && zoom < 17) {
        zoom--;
        width_viewbox += xmove;
        var ratioWidthZoom =  taille_w / width_viewbox;
        height_viewbox = width_viewbox * ratio_viewbox;
        myDiv = document.getElementById("scaleVal");
        myDiv.style.width =  60*ratioWidthZoom+'px';
        originX_viewbox = originX_viewbox - (xmove/2);
        originY_viewbox = originY_viewbox - (xmove/2 * ratio_viewbox);
    }
    if (lens == 'zoomin' && zoom < 14 && zoom > 0) {
        zoom++;
        var oldWidth = width_viewbox;
        width_viewbox -= xmove;
        var ratioWidthZoom = taille_w / width_viewbox;
        height_viewbox = width_viewbox * ratio_viewbox;
        myDiv = document.getElementById("scaleVal");
      myDiv.style.width = 60*ratioWidthZoom+'px';

        originX_viewbox =  originX_viewbox + (xmove/2);
        originY_viewbox =  originY_viewbox + (xmove/2 * ratio_viewbox);
    }
    factor = width_viewbox / taille_w;
    if (lens == 'zoomreset') {
      originX_viewbox = 0;
      originY_viewbox = 0;
      width_viewbox = taille_w;
      height_viewbox = taille_h;
      factor = 1;
		//factor=0.79;
    }
    if (lens == 'zoomright') {
        originX_viewbox += xview;
    }
    if (lens == 'zoomleft') {
        originX_viewbox -= xview;
    }
    if (lens == 'zoomtop') {
        originY_viewbox -= xview;
    }
    if (lens == 'zoombottom') {
        originY_viewbox += xview;
    }
    if (lens == 'zoomdrag') {
        originX_viewbox -= xmove;
        originY_viewbox -= xview;
    }
    $('svg').each(function() {
        $(this)[0].setAttribute('viewBox', originX_viewbox + ' ' + originY_viewbox + ' ' + width_viewbox + ' ' + height_viewbox)
    });
}

tactile = false;
function calcul_snap(event, state) {
  if (event.touches) {
    var touches = event.changedTouches;
    console.log("toto")
    eX = touches[0].pageX;
    eY = touches[0].pageY;
    tactile = true;
  }
  else {
    eX = event.pageX;
    eY = event.pageY;
  }
    x_mouse = (eX * factor) - (offset.left * factor) + originX_viewbox;
    y_mouse = (eY * factor) - (offset.top * factor) + originY_viewbox;

    if (state == 'on') {
        x_grid = Math.round(x_mouse / grid) * grid;
        y_grid = Math.round(y_mouse / grid) * grid;
    }
    if (state == 'off') {
        x_grid = x_mouse;
        y_grid = y_mouse;
    }
    return {
        x: x_grid,
        y: y_grid,
        xMouse: x_mouse,
        yMouse: y_mouse
    };
}

minMoveGrid = function(mouse) {
    return Math.abs(Math.abs(pox - mouse.x) + Math.abs(poy - mouse.y));
}

function intersectionOff() {
  if (typeof(lineIntersectionP) != 'undefined') {
      lineIntersectionP.remove();
      delete lineIntersectionP;
  }
}

function intersection(snap, range = Infinity, except = ['']) {
  // ORANGE LINES 90° NEAR SEGMENT
  var bestEqPoint = {};
  var equation = {};

  bestEqPoint.distance = range;

  if (typeof(lineIntersectionP) != 'undefined') {
      lineIntersectionP.remove();
      delete lineIntersectionP;
  }

  lineIntersectionP = qSVG.create("boxbind", "path", { // ORANGE TEMP LINE FOR ANGLE 0 90 45 -+
      d: "",
      "stroke": "transparent",
      "stroke-width": 0.5,
      "stroke-opacity": "1",
      fill : "none"
    });

  for (index = 0; index < WALLS.length; index++) {
    if (except.indexOf(WALLS[index]) == -1) {
    var x1 = WALLS[index].start.x;
    var y1 = WALLS[index].start.y;
    var x2 = WALLS[index].end.x;
    var y2 = WALLS[index].end.y;

    // EQUATION 90° of segment nf/nf-1 at X2/Y2 Point
    if (Math.abs(y2 - y1) == 0) {
      equation.C = 'v'; // C/D equation 90° Coef = -1/E
      equation.D = x1;
      equation.E = 'h'; // E/F equation Segment
      equation.F = y1;
      equation.G = 'v'; // G/H equation 90° Coef = -1/E
      equation.H = x2;
      equation.I = 'h'; // I/J equation Segment
      equation.J = y2;
    }
    else if (Math.abs(x2 - x1) == 0) {
      equation.C = 'h'; // C/D equation 90° Coef = -1/E
      equation.D = y1;
      equation.E = 'v'; // E/F equation Segment
      equation.F = x1;
      equation.G = 'h'; // G/H equation 90° Coef = -1/E
      equation.H = y2;
      equation.I = 'v'; // I/J equation Segment
      equation.J = x2;
    }
    else {
      equation.C = (x1 - x2) / (y2 - y1);
      equation.D = y1 - (x1 * equation.C);
      equation.E = (y2 - y1) / (x2 - x1);
      equation.F = y1 - (x1 * equation.E);
      equation.G = (x1 - x2) / (y2 - y1);
      equation.H = y2 - (x2 * equation.C);
      equation.I = (y2 - y1) / (x2 - x1);
      equation.J = y2 - (x2 * equation.E);
      }
      equation.A = equation.C;
      equation.B = equation.D;
      eq = qSVG.nearPointOnEquation(equation, snap);
      if (eq.distance < bestEqPoint.distance) {
          bestEqPoint.distance = eq.distance;
          bestEqPoint.node = index;
          bestEqPoint.x = eq.x;
          bestEqPoint.y = eq.y;
          bestEqPoint.x1 = x1;
          bestEqPoint.y1 = y1;
          bestEqPoint.x2 = x2;
          bestEqPoint.y2 = y2;
          bestEqPoint.way = 1;
      }
      equation.A = equation.E;
      equation.B = equation.F;
      eq = qSVG.nearPointOnEquation(equation, snap);
      if (eq.distance < bestEqPoint.distance) {
          bestEqPoint.distance = eq.distance;
          bestEqPoint.node = index;
          bestEqPoint.x = eq.x;
          bestEqPoint.y = eq.y;
          bestEqPoint.x1 = x1;
          bestEqPoint.y1 = y1;
          bestEqPoint.x2 = x2;
          bestEqPoint.y2 = y2;
          bestEqPoint.way = 1;
      }
      equation.A = equation.G;
      equation.B = equation.H;
      eq = qSVG.nearPointOnEquation(equation, snap);
      if (eq.distance < bestEqPoint.distance) {
          bestEqPoint.distance = eq.distance;
          bestEqPoint.node = index;
          bestEqPoint.x = eq.x;
          bestEqPoint.y = eq.y;
          bestEqPoint.x1 = x1;
          bestEqPoint.y1 = y1;
          bestEqPoint.x2 = x2;
          bestEqPoint.y2 = y2;
          bestEqPoint.way = 2;
      }
      equation.A = equation.I;
      equation.B = equation.J;
      eq = qSVG.nearPointOnEquation(equation, snap);
      if (eq.distance < bestEqPoint.distance) {
          bestEqPoint.distance = eq.distance;
          bestEqPoint.node = index;
          bestEqPoint.x = eq.x;
          bestEqPoint.y = eq.y;
          bestEqPoint.x1 = x1;
          bestEqPoint.y1 = y1;
          bestEqPoint.x2 = x2;
          bestEqPoint.y2 = y2;
          bestEqPoint.way = 2;
      }
   } // END INDEXOF EXCEPT TEST
  } // END LOOP FOR

  if (bestEqPoint.distance < range) {
    if (bestEqPoint.way == 2) {
      lineIntersectionP.attr({ // ORANGE TEMP LINE FOR ANGLE 0 90 45 -+
          d: "M"+bestEqPoint.x1+","+bestEqPoint.y1+" L"+bestEqPoint.x2+","+bestEqPoint.y2+" L"+bestEqPoint.x+","+bestEqPoint.y,
          "stroke": "#d7ac57"
        });
    }
    else {
      lineIntersectionP.attr({ // ORANGE TEMP LINE FOR ANGLE 0 90 45 -+
          d: "M"+bestEqPoint.x2+","+bestEqPoint.y2+" L"+bestEqPoint.x1+","+bestEqPoint.y1+" L"+bestEqPoint.x+","+bestEqPoint.y,
          "stroke": "#d7ac57"
        });
    }
    return ({
    x: bestEqPoint.x,
    y: bestEqPoint.y,
    wall : WALLS[bestEqPoint.node],
    distance: bestEqPoint.distance
    });
  }
  else {
    return false;
  }
}

function debugPoint(point, name, color = "#00ff00") {
      qSVG.create('boxDebug', 'circle', {
      cx: point.x,
      cy: point.y,
      r: 7,
      fill: color,
      id: name,
      class: "visu"
  });
}

function showVertex() {
  for (var i=0; i < vertex.length; i++) {
    debugPoint(vertex[i], i);

  }
}

function showJunction() {
  for (var i=0; i < junction.length; i++) {
    debugPoint({x: junction[i].values[0], y: junction[i].values[1]}, i);

  }
}

$('.visu').mouseover(function() {console.log(this.id)});

var sizeText = [];
var showAllSizeStatus = 0;
function hideAllSize() {
  $('#boxbind').empty();
  sizeText = [];
  showAllSizeStatus = 0;
}

function allRib() {
  $('#boxRib').empty();
  for (var i in WALLS) {
    inWallRib(WALLS[i], 'all');
  }
}

function inWallRib(wall, option = false) {
	
  if (!option) $('#boxRib').empty();
  ribMaster = [];
  ribMaster.push([]);
  ribMaster.push([]);
  var inter;
  var distance;
  var cross;
  var angleTextValue = wall.angle*(180/Math.PI);
  var objWall = editor.objFromWall(wall); // LIST OBJ ON EDGE
  ribMaster[0].push({wall: wall, crossObj: false, side : 'up', coords: wall.coords[0], distance: 0});
  ribMaster[1].push({wall: wall, crossObj: false, side : 'down', coords: wall.coords[1], distance: 0});
  for (var ob in objWall) {
    var objTarget = objWall[ob];
    objTarget.up = [
      qSVG.nearPointOnEquation(wall.equations.up, objTarget.limit[0]),
      qSVG.nearPointOnEquation(wall.equations.up, objTarget.limit[1])
    ];
    objTarget.down = [
      qSVG.nearPointOnEquation(wall.equations.down, objTarget.limit[0]),
      qSVG.nearPointOnEquation(wall.equations.down, objTarget.limit[1])
    ];

    distance = qSVG.measure(wall.coords[0], objTarget.up[0]) / meter;
    ribMaster[0].push({wall: objTarget, crossObj: ob, side : 'up', coords: objTarget.up[0], distance: distance.toFixed(2)});
    distance = qSVG.measure(wall.coords[0], objTarget.up[1]) / meter;
    ribMaster[0].push({wall: objTarget, crossObj: ob, side : 'up', coords: objTarget.up[1], distance: distance.toFixed(2)});
    distance = qSVG.measure(wall.coords[1], objTarget.down[0]) / meter;
    ribMaster[1].push({wall: objTarget, crossObj: ob, side : 'down', coords: objTarget.down[0], distance: distance.toFixed(2)});
    distance = qSVG.measure(wall.coords[1], objTarget.down[1]) / meter;
    ribMaster[1].push({wall: objTarget, crossObj: ob, side : 'down', coords: objTarget.down[1], distance: distance.toFixed(2)});
  }
  distance = qSVG.measure(wall.coords[0], wall.coords[3]) / meter;
  ribMaster[0].push({wall: objTarget, crossObj: false, side : 'up', coords: wall.coords[3], distance: distance});
  distance = qSVG.measure(wall.coords[1], wall.coords[2]) / meter;
  ribMaster[1].push({wall: objTarget, crossObj: false, side : 'down', coords: wall.coords[2], distance: distance});
    ribMaster[0].sort(function(a,b) {
      return (a.distance - b.distance).toFixed(2);
    });
    ribMaster[1].sort(function(a,b) {
      return (a.distance - b.distance).toFixed(2);
    });
  for (var t in ribMaster) {
    for (var n = 1; n < ribMaster[t].length; n++) {
      var found = true;
      var shift = -5;
      var valueText = Math.abs(ribMaster[t][n-1].distance - ribMaster[t][n].distance);
      var angleText = angleTextValue;
      if (found) {
          if (ribMaster[t][n-1].side == 'down') {shift = -shift+10;}
          if (angleText > 89 || angleText < -89) {
            angleText-=180;
            if (ribMaster[t][n-1].side == 'down') {shift = -5;}
            else shift = -shift+10;
          }



          sizeText[n] = document.createElementNS('http://www.w3.org/2000/svg', 'text');
          var startText = qSVG.middle(ribMaster[t][n-1].coords.x, ribMaster[t][n-1].coords.y, ribMaster[t][n].coords.x, ribMaster[t][n].coords.y); //Guarda las coordenadas X e Y
          sizeText[n].setAttributeNS(null, 'x', startText.x);
          sizeText[n].setAttributeNS(null, 'y', (startText.y)+shift);
          sizeText[n].setAttributeNS(null, 'text-anchor', 'middle');
          sizeText[n].setAttributeNS(null, 'font-family', 'roboto');
          sizeText[n].setAttributeNS(null, 'stroke', '#ffffff');
          sizeText[n].textContent = valueText.toFixed(2);
          if (sizeText[n].textContent < 1) {
            sizeText[n].setAttributeNS(null, 'font-size', '0.8em');
            sizeText[n].textContent = sizeText[n].textContent.substring(1, sizeText[n].textContent.length);
          }  
          else sizeText[n].setAttributeNS(null, 'font-size', '1em');
         
		  sizeText[n].setAttributeNS(null, 'stroke-width', '0.27px');
          sizeText[n].setAttributeNS(null, 'fill', '#666666');
          sizeText[n].setAttribute("transform", "rotate("+angleText+" "+startText.x+","+(startText.y)+")");
		 
		  console.log($(sizeText[n]));
		  
          //$('#boxRib').append(sizeText[n]);  <<< COMENTO ESTA LÍNEA PARA QUE CUANDO ME PONGA ENCIMA DE UN MURO (PARA EDITARLO), NO ME MUESTRE LOS M2 INTERIORES Y EXTERIORES
      }
    }
  }
}

function rib(shift = 5) {
  // return false;  
	//Aquí entra siempre para recalcular los muros
	
  var ribMaster = [];
  ribMaster.push([]);
  ribMaster.push([]);
  var inter;
  var distance;
  var cross;
  for (var i in WALLS) {
    if (WALLS[i].equations.base) {
      ribMaster[0].push([]);
      ribMaster[0][i].push({wallIndex: i, crossEdge: i, side : 'up', coords: WALLS[i].coords[0], distance: 0});
      ribMaster[1].push([]);
      ribMaster[1][i].push({wallIndex: i, crossEdge: i, side : 'down', coords: WALLS[i].coords[1], distance: 0});
      for (var p in WALLS) {
        if (i != p && WALLS[p].equations.base) {
          cross = qSVG.intersectionOfEquations(WALLS[i].equations.base, WALLS[p].equations.base, "object");
          if (qSVG.btwn(cross.x, WALLS[i].start.x, WALLS[i].end.x, 'round') && qSVG.btwn(cross.y, WALLS[i].start.y, WALLS[i].end.y, 'round')) {

            inter = qSVG.intersectionOfEquations(WALLS[i].equations.up, WALLS[p].equations.up, "object");
            if (qSVG.btwn(inter.x, WALLS[i].coords[0].x, WALLS[i].coords[3].x, 'round') && qSVG.btwn(inter.y, WALLS[i].coords[0].y, WALLS[i].coords[3].y, 'round') && qSVG.btwn(inter.x, WALLS[p].coords[0].x, WALLS[p].coords[3].x, 'round') && qSVG.btwn(inter.y, WALLS[p].coords[0].y, WALLS[p].coords[3].y, 'round')){
              distance = qSVG.measure(WALLS[i].coords[0], inter) / meter;
              ribMaster[0][i].push({wallIndex: i, crossEdge: p, side : 'up', coords: inter, distance: distance.toFixed(2)});
            }

            inter = qSVG.intersectionOfEquations(WALLS[i].equations.up, WALLS[p].equations.down, "object");
            if (qSVG.btwn(inter.x, WALLS[i].coords[0].x, WALLS[i].coords[3].x, 'round') && qSVG.btwn(inter.y, WALLS[i].coords[0].y, WALLS[i].coords[3].y, 'round') && qSVG.btwn(inter.x, WALLS[p].coords[1].x, WALLS[p].coords[2].x, 'round') && qSVG.btwn(inter.y, WALLS[p].coords[1].y, WALLS[p].coords[2].y, 'round')){
              distance = qSVG.measure(WALLS[i].coords[0], inter) / meter;
              ribMaster[0][i].push({wallIndex: i, crossEdge: p, side : 'up', coords: inter, distance: distance.toFixed(2)});
            }

            inter = qSVG.intersectionOfEquations(WALLS[i].equations.down, WALLS[p].equations.up, "object");
            if (qSVG.btwn(inter.x, WALLS[i].coords[1].x, WALLS[i].coords[2].x, 'round') && qSVG.btwn(inter.y, WALLS[i].coords[1].y, WALLS[i].coords[2].y, 'round') && qSVG.btwn(inter.x, WALLS[p].coords[0].x, WALLS[p].coords[3].x, 'round') && qSVG.btwn(inter.y, WALLS[p].coords[0].y, WALLS[p].coords[3].y, 'round')){
              distance = qSVG.measure(WALLS[i].coords[1], inter) / meter;
              ribMaster[1][i].push({wallIndex: i, crossEdge: p, side : 'down', coords: inter, distance: distance.toFixed(2)});
            }

            inter = qSVG.intersectionOfEquations(WALLS[i].equations.down, WALLS[p].equations.down, "object");
            if (qSVG.btwn(inter.x, WALLS[i].coords[1].x, WALLS[i].coords[2].x, 'round') && qSVG.btwn(inter.y, WALLS[i].coords[1].y, WALLS[i].coords[2].y, 'round') && qSVG.btwn(inter.x, WALLS[p].coords[1].x, WALLS[p].coords[2].x, 'round') && qSVG.btwn(inter.y, WALLS[p].coords[1].y, WALLS[p].coords[2].y, 'round')){
              distance = qSVG.measure(WALLS[i].coords[1], inter) / meter;
              ribMaster[1][i].push({wallIndex: i, crossEdge: p, side : 'down', coords: inter, distance: distance.toFixed(2)});
            }
          }
        }
      }
      distance = qSVG.measure(WALLS[i].coords[0], WALLS[i].coords[3]) / meter;
      ribMaster[0][i].push({wallIndex: i, crossEdge: i, side : 'up', coords: WALLS[i].coords[3], distance: distance.toFixed(2)});
      distance = qSVG.measure(WALLS[i].coords[1], WALLS[i].coords[2]) / meter;
      ribMaster[1][i].push({wallIndex: i, crossEdge: i, side : 'down', coords: WALLS[i].coords[2], distance: distance.toFixed(2)});
    }
  }

  for (var a in ribMaster[0]) {
    ribMaster[0][a].sort(function(a,b) {
      return (a.distance - b.distance).toFixed(2);
    });
  }
  for (var a in ribMaster[1]) {
    ribMaster[1][a].sort(function(a,b) {
      return (a.distance - b.distance).toFixed(2);
    });
  }

  var sizeText = [];
  if (shift == 5) $('#boxRib').empty();
  for (var t in ribMaster) {
	  $('#listado_muros').empty();
    for (var a in ribMaster[t]) {
      for (var n = 1; n < ribMaster[t][a].length; n++) {

		 // ribMaster[t][a].length devuelve el número de muros (paredes) que encuentra
        if (ribMaster[t][a][n-1].wallIndex == ribMaster[t][a][n].wallIndex) {
          var edge = ribMaster[t][a][n].wallIndex;
		  contador_muro=parseInt(edge)+1; //Guardo el número de la iteracción actual. Para saber si va a pintar el texto del muro1, del 2, del 3...
		   
          var found = true;
          var valueText = Math.abs(ribMaster[t][a][n-1].distance - ribMaster[t][a][n].distance);
          // CLEAR TOO LITTLE VALUE
			
		  /*if (ribMaster[t][a][n-1].side == "down") 
			 var valorDown = valueText;
			
		  if (ribMaster[t][a][n-1].side == "up") 
			 var valorUp = valueText;*/
			
			
		   /*if (valorDown > valorUp)
			   valueText = valorDown;
		   else if (valorUp > valorDown)
			   valueText = valorUp;
			  
		   console.log(valorDown+" VS "+valorUp+" = "+valueText);*/
			
          if (valueText < 0.15) {
            found = false;
          }
          // CLEAR (thick) BETWEEN CROSS EDGE
          if (found && ribMaster[t][a][n-1].crossEdge == ribMaster[t][a][n].crossEdge &&  ribMaster[t][a][n].crossEdge != ribMaster[t][a][n].wallIndex){
            found= false;
          }
          // CLEAR START INTO EDGE
          if (found && ribMaster[t][a].length > 2 && n==1) {
            var polygon = [];
            for (var pp = 0; pp < 4; pp++) {
              polygon.push({x: WALLS[ribMaster[t][a][n].crossEdge].coords[pp].x, y: WALLS[ribMaster[t][a][n].crossEdge].coords[pp].y}); // FOR Z
            }
            if (qSVG.rayCasting(ribMaster[t][a][0].coords, polygon)) {
              found = false;
            }
          }
          // CLEAR END INTO EDGE
          if (found && ribMaster[t][a].length > 2 && n == ribMaster[t][a].length-1){
            var polygon = [];
            for (var pp = 0; pp < 4; pp++) {
              polygon.push({x: WALLS[ribMaster[t][a][n-1].crossEdge].coords[pp].x, y: WALLS[ribMaster[t][a][n-1].crossEdge].coords[pp].y}); // FOR Z
            }
            if (qSVG.rayCasting(ribMaster[t][a][ribMaster[t][a].length-1].coords, polygon)) {
              found = false;
            }
          }

          if (found) {
              var angleText = WALLS[ribMaster[t][a][n].wallIndex].angle*(180/Math.PI);
              var shiftValue = -shift;
			  //Si el side es "UP" es la medida INTERIOR. Antes estos IFS estaban en "DOWN". Ahora como los "DOWN" los he ocultado (no me interesan las medidas exteriores), cambio estos ifs por "UP" para que su posición sea POR FUERA del muro y no tape los dibujos que ponga dentro
			  
              if (ribMaster[t][a][n-1].side == 'down') {shiftValue = -shiftValue+10;}
              if (angleText > 90 || angleText < -89) {
                angleText-=180;
                if (ribMaster[t][a][n-1].side == 'down') {shiftValue = -shift;}
                else shiftValue = -shiftValue+10;
              }
			  
			  /*if (ribMaster[t][a][n-1].side == 'up') {shiftValue = -shiftValue+10;}
              if (angleText > 90 || angleText < -89) {
                angleText-=180;
                if (ribMaster[t][a][n-1].side == 'up') {shiftValue = -shift;}
                else shiftValue = -shiftValue+10;
              }*/
			  
			  console.log("Que valor llega: "+valueText+" y haciendo fixed "+valueText.toFixed(2));
              sizeText[n] = document.createElementNS('http://www.w3.org/2000/svg', 'text');
              var startText = qSVG.middle(ribMaster[t][a][n-1].coords.x, ribMaster[t][a][n-1].coords.y, ribMaster[t][a][n].coords.x, ribMaster[t][a][n].coords.y);
              sizeText[n].setAttributeNS(null, 'x', startText.x);
              sizeText[n].setAttributeNS(null, 'y', (startText.y)+(shiftValue));
              sizeText[n].setAttributeNS(null, 'text-anchor', 'middle');
              sizeText[n].setAttributeNS(null, 'font-family', 'roboto');
              sizeText[n].setAttributeNS(null, 'stroke', '#ffffff');
			  sizeText[n].textContent = valueText.toFixed(2);
              
			  console.log("SIZE TEXT !!!"+sizeText[n].textContent);
			  if (sizeText[n].textContent < 1) {
                sizeText[n].setAttributeNS(null, 'font-size', '0.73em');
                //sizeText[n].textContent = sizeText[n].textContent.substring(1, sizeText[n].textContent.length);
              }
              else sizeText[n].setAttributeNS(null, 'font-size', '0.9em');
              sizeText[n].setAttributeNS(null, 'stroke-width', '0.2px');
			  sizeText[n].setAttributeNS(null, 'class', 'texto'+contador_muro); //La primera coincidencia se corresponde con el INTERIOR y la segunda, con el EXTERIOR
              sizeText[n].setAttributeNS(null, 'fill', 'white'); //ANTES: #555555
              sizeText[n].setAttribute("transform", "rotate("+angleText+" "+startText.x+","+(startText.y)+")");
			  
			  //Side down es la medida en metros cuadrados del exterior. Por lo tanto si es "down", le pongo un display none para que no se muestre, ya que sólo nos interesa la medida del interior.
			     
			  var letras_abecedario=["A", "B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","W","X","Y","Z"];
			   
			  sizeText[n].textContent = sizeText[n].textContent+" - ["+letras_abecedario[contador_muro-1]+"]";
			  if (ribMaster[t][a][n-1].side == "down") 
				sizeText[n].setAttributeNS(null, 'style', 'display:none;');  
			   
			  //console.log("El valor de wallWidth es "+$("#wallWidthScale").text());
			 
			  //contador_muro tiene el número de muro que es (1,2,3,4,5...)
              $('#boxRib').append(sizeText[n]); //<< comentar esto para que no se vean los m2 de cada pared
			   $('#listado_muros').append("<span class='info_muro'><span class='nombre_pared'>Pared "+letras_abecedario[contador_muro-1]+"</span> <span class='valor_pared'>"+valueText.toFixed(2).substring(0,valueText.toFixed(2).length -1)+"</span>m</span> "); 
          }
        }
      }
    }
  }
}

function cursor(tool) {
  if (tool == 'grab') tool = "url('https://wiki.openmrs.org/s/en_GB/7502/b9217199c27dd617c8d51f6186067d7767c5001b/_/images/icons/emoticons/add.png') 8 8, auto";
  if (tool == 'scissor') tool = "url('https://maxcdn.icons8.com/windows10/PNG/64/Hands/hand_scissors-64.png'), auto";
  if (tool == 'trash') tool = "url('https://cdn4.iconfinder.com/data/icons/common-toolbar/36/Cancel-32.png'), auto";
  if (tool == 'validation') tool = "url('https://images.fatguymedia.com/wp-content/uploads/2015/09/check.png'), auto";
  $('#lin').css('cursor',tool);
}

function fullscreen() {
    // go full-screen
    var i = document.body;
  if (i.requestFullscreen) {
  	i.requestFullscreen();
  } else if (i.webkitRequestFullscreen) {
  	i.webkitRequestFullscreen();
  } else if (i.mozRequestFullScreen) {
  	i.mozRequestFullScreen();
  } else if (i.msRequestFullscreen) {
  	i.msRequestFullscreen();
  }
}

function outFullscreen() {
  if(document.exitFullscreen) {
    document.exitFullscreen();
  } else if(document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if(document.webkitExitFullscreen) {
    document.webkitExitFullscreen();
  }
}

document.addEventListener("fullscreenchange", function() {
  if (
	!document.fullscreenElement &&
	!document.webkitFullscreenElement &&
	!document.mozFullScreenElement &&
	!document.msFullscreenElement) {
  $('#nofull_mode').display='none';$('#full_mode').show();
  }
});

function raz_button() {
    $('#rect_mode').removeClass('btn-success');
    $('#rect_mode').addClass('btn-default');
    $('#select_mode').removeClass('btn-success');
    $('#select_mode').addClass('btn-default');
    $('#line_mode').removeClass('btn-success');
    $('#line_mode').addClass('btn-default');
    $('#partition_mode').removeClass('btn-success');
    $('#partition_mode').addClass('btn-default');
    $('#door_mode').removeClass('btn-success');
    $('#door_mode').addClass('btn-default');
    $('#node_mode').removeClass('btn-success');
    $('#node_mode').addClass('btn-default');
    $('#text_mode').removeClass('btn-success');
    $('#text_mode').addClass('btn-default');
    $('#room_mode').removeClass('btn-success');
    $('#room_mode').addClass('btn-default');
    $('#distance_mode').removeClass('btn-success');
    $('#distance_mode').addClass('btn-default');
    $('#object_mode').removeClass('btn-success');
    $('#object_mode').addClass('btn-default');
    $('#stair_mode').removeClass('btn-success');
    $('#stair_mode').addClass('btn-default');
}

function fonc_button(modesetting ,option) {
  save();

  $('.sub').hide();
    raz_button();
    if (option != 'simpleStair') {
      $('#' + modesetting).removeClass('btn-default');
      $('#' + modesetting).addClass('btn-success');

    }
    mode = modesetting;
    modeOption = option;

    if (typeof(lineIntersectionP) != 'undefined') {
        lineIntersectionP.remove();
        delete lineIntersectionP;
    }
}


$('#distance_mode').click(function() {
  $('#lin').css('cursor', 'crosshair');
  $('#boxinfo').html('Add a measurement');
  fonc_button('distance_mode');
});

$('#room_mode').click(function() {
    $('#lin').css('cursor', 'pointer');
    $('#boxinfo').html('Configuración cocina');
    fonc_button('room_mode');
});

$('#select_mode').click(function() {
  $('#boxinfo').html('Modo "selección"');
  if (typeof(binder) != 'undefined') {
      binder.remove();
      delete binder;
  }

    fonc_button('select_mode');
});

$('#line_mode').click(function() {
    $('#lin').css('cursor', 'crosshair');
    $('#boxinfo').html('Creación de muro(s)');
    multi = 0;
    action = 0;
    // snap = calcul_snap(event, grid_snap);
    //
    // pox = snap.x;
    // poy = snap.y;
    fonc_button('line_mode');
});

$('#partition_mode').click(function() {
    $('#lin').css('cursor', 'crosshair');
    $('#boxinfo').html('Creación de partición(es)');
    multi = 0;
    fonc_button('partition_mode');
});

$('#rect_mode').click(function() {
    $('#lin').css('cursor', 'crosshair');
    $('#boxinfo').html('Creación de pieza(s)');
    fonc_button('rect_mode');
});

$('.door').click(function() {
    $('#lin').css('cursor', 'crosshair');
    $('#boxinfo').html('Agregar una puerta / ventana');
    $('#door_list').hide(200);
    fonc_button('door_mode', this.id);
});

$('.window').click(function() {
    $('#lin').css('cursor', 'crosshair');
    $('#boxinfo').html('Agregar ventana');
    $('#door_list').hide(200);
    $('#window_list').hide(200);
    fonc_button('door_mode', this.id);
});

$('.object').click(function() {
    cursor('move');
    $('#boxinfo').html('Agregar un objeto');
    fonc_button('object_mode', this.id);
});

$('#stair_mode').click(function() {
    cursor('move');
    $('#boxinfo').html('Agregar una escalera');
    fonc_button('object_mode', 'simpleStair');
});

$('#node_mode').click(function() {
    $('#boxinfo').html('Cortar una pared<br/><span style=\"font-size:0.7em\">Atención : Cortar la pared de una habitación puede cancelar su configuración</span>');
    fonc_button('node_mode');
});

$('#text_mode').click(function() {
    $('#boxinfo').html('Agregar texto<br/><span style=\"font-size:0.7em\">Mueva el cursor a la ubicación deseada, luego escriba su texto.</span>');
    fonc_button('text_mode');
});

$('#grid_mode').click(function() {
    if (grid_snap == 'on') {
        grid_snap = 'off';
        $('#boxinfo').html('Ayuda cuadrícula desactivada');
        $('#grid_mode').removeClass('btn-success');
        $('#grid_mode').addClass('btn-warning');
        $('#grid_mode').html('GRID OFF');
        $('#boxgrid').css('opacity', '0.5');
    } else {
        grid_snap = 'on';
        $('#boxinfo').html('Ayuda cuadrícula activada');
        $('#grid_mode').removeClass('btn-warning');
        $('#grid_mode').addClass('btn-success');
        $('#grid_mode').html('GRID ON <i class="fa fa-th" aria-hidden="true"></i>');
        $('#boxgrid').css('opacity', '1');
    }
});

//  RETURN PATH(s) ARRAY FOR OBJECT + PROPERTY params => bindBox (false = open sideTool), move, resize, rotate
function carpentryCalc(classObj, typeObj, sizeObj, thickObj, dividerObj = 10) {
  var construc = [];
  construc.params = {};
  construc.params.bindBox = false;
  construc.params.move = false;
  construc.params.resize = false;
  construc.params.resizeLimit = {};
  construc.params.resizeLimit.width = {min: false, max: false};
  construc.params.resizeLimit.height = {min: false, max: false};
  construc.params.rotate = false;

  if (classObj == 'socle') {
    construc.push({'path':"M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+(-sizeObj/2)+","+thickObj/2+" L "+sizeObj/2+","+thickObj/2+" L "+sizeObj/2+","+(-thickObj/2)+" Z", 'fill': "#5cba79", 'stroke': "#5cba79", 'strokeDashArray': ''});
  }
  if (classObj == 'doorWindow') {
    if (typeObj == 'simple') {
      construc.push({'path':"M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+(-sizeObj/2)+","+thickObj/2+" L "+sizeObj/2+","+thickObj/2+" L "+sizeObj/2+","+(-thickObj/2)+" Z", 'fill': "#ccc", 'stroke': "none", 'strokeDashArray': ''});
      construc.push({'path': "M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+(-sizeObj/2)+","+(-sizeObj-thickObj/2)+"  A"+sizeObj+","+sizeObj+" 0 0,1 "+sizeObj/2+","+(-thickObj/2), 'fill': "none", 'stroke': colorWall, 'strokeDashArray': ''});
      construc.params.resize = true;
      construc.params.resizeLimit.width = {min:40, max:120};
    }
    if (typeObj == 'double') {
      construc.push({'path':"M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+(-sizeObj/2)+","+thickObj/2+" L "+sizeObj/2+","+thickObj/2+" L "+sizeObj/2+","+(-thickObj/2)+" Z", 'fill': "#ccc", 'stroke': "none", 'strokeDashArray': ''});
      construc.push({'path': "M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+(-sizeObj/2)+","+(-sizeObj/2-thickObj/2)+"  A"+sizeObj/2+","+sizeObj/2+" 0 0,1 0,"+(-thickObj/2), 'fill': "none", 'stroke': colorWall, 'strokeDashArray': ''});
      construc.push({'path': "M "+(sizeObj/2)+","+(-thickObj/2)+" L "+(sizeObj/2)+","+(-sizeObj/2-thickObj/2)+"  A"+sizeObj/2+","+sizeObj/2+" 0 0,0 0,"+(-thickObj/2), 'fill': "none", 'stroke': colorWall, 'strokeDashArray': ''});
      construc.params.resize = true;
      construc.params.resizeLimit.width = {min:40, max:160};
    }
    if (typeObj == 'pocket') {
      construc.push({'path':"M "+(-sizeObj/2)+","+(-(thickObj/2)-4)+" L "+(-sizeObj/2)+","+thickObj/2+" L "+sizeObj/2+","+thickObj/2+" L "+sizeObj/2+","+(-(thickObj/2)-4)+" Z", 'fill': "#ccc", 'stroke': "none", 'strokeDashArray': 'none'});
      construc.push({'path':"M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+(-sizeObj/2)+","+thickObj/2+" M "+(sizeObj/2)+","+(thickObj/2)+" L "+(sizeObj/2)+","+(-thickObj/2), 'fill': "none", 'stroke': "#494646", 'strokeDashArray': '5 5'});
      construc.push({'path':"M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+(-sizeObj/2)+","+(-thickObj/2-5)+" L "+(+sizeObj/2)+","+(-thickObj/2-5)+" L "+(+sizeObj/2)+","+(-thickObj/2)+" Z", 'fill': "url(#hatch)", 'stroke': "#494646", 'strokeDashArray': ''});
      construc.params.resize = true;
      construc.params.resizeLimit.width = {min:60, max:200};
    }
    if (typeObj == 'aperture' || typeObj == 'puerta_abatible' || typeObj == 'puerta_corredera_encastrada' || typeObj == 'colocacion_puerta_aluminio' || typeObj == 'colocacion_ventana_aluminio' || typeObj == 'colocacion_balconera_aluminio') {
      construc.push({'path':"M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+(-sizeObj/2)+","+thickObj/2+" L "+sizeObj/2+","+thickObj/2+" L "+sizeObj/2+","+(-thickObj/2)+" Z", 'fill': "#ccc", 'stroke': "#494646", 'strokeDashArray': '5,5'});
      construc.push({'path':"M "+(-sizeObj/2)+","+(-(thickObj/2))+" L "+(-sizeObj/2)+","+thickObj/2+" L "+((-sizeObj/2)+5)+","+thickObj/2+" L "+((-sizeObj/2)+5)+","+(-(thickObj/2))+" Z", 'fill': "none", 'stroke': "#494646", 'strokeDashArray': 'none'});
      construc.push({'path':"M "+((sizeObj/2)-5)+","+(-(thickObj/2))+" L "+((sizeObj/2)-5)+","+thickObj/2+" L "+(sizeObj/2)+","+thickObj/2+" L "+(sizeObj/2)+","+(-(thickObj/2))+" Z", 'fill': "none", 'stroke': "#494646", 'strokeDashArray': 'none'});
      construc.params.resize = true;
      construc.params.resizeLimit.width = {min:40, max:500};
		
    }
    if (typeObj == 'fix') {
      construc.push({'path':"M "+(-sizeObj/2)+",-2 L "+(-sizeObj/2)+",2 L "+sizeObj/2+",2 L "+sizeObj/2+",-2 Z", 'fill': "#ccc", 'stroke': "none", 'strokeDashArray': ''});
      construc.push({'path':"M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+(-sizeObj/2)+","+thickObj/2+" M "+sizeObj/2+","+thickObj/2+" L "+sizeObj/2+","+(-thickObj/2), 'fill': "none", 'stroke': "#ccc", 'strokeDashArray': ''});
      construc.params.resize = true;
      construc.params.resizeLimit.width = {min:30, max:300};
    }
    if (typeObj == 'flap') {
      construc.push({'path':"M "+(-sizeObj/2)+",-2 L "+(-sizeObj/2)+",2 L "+sizeObj/2+",2 L "+sizeObj/2+",-2 Z", 'fill': "#ccc", 'stroke': "none", 'strokeDashArray': ''});
      construc.push({'path':"M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+(-sizeObj/2)+","+thickObj/2+" M "+sizeObj/2+","+thickObj/2+" L "+sizeObj/2+","+(-thickObj/2), 'fill': "none", 'stroke': "#ccc", 'strokeDashArray': ''});
      construc.push({'path': "M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+((-sizeObj/2)+((sizeObj)*0.866))+","+((-sizeObj/2)-(thickObj/2))+"  A"+sizeObj+","+sizeObj+" 0 0,1 "+sizeObj/2+","+(-thickObj/2), 'fill': "none", 'stroke': colorWall, 'strokeDashArray': ''});
      construc.params.resize = true;
      construc.params.resizeLimit.width = {min:20, max:100};
    }
    if (typeObj == 'twin') {
      construc.push({'path':"M "+(-sizeObj/2)+",-2 L "+(-sizeObj/2)+",2 L "+sizeObj/2+",2 L "+sizeObj/2+",-2 Z", 'fill': "#ccc", 'stroke': "none", 'strokeDashArray': ''});
      construc.push({'path':"M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+(-sizeObj/2)+","+thickObj/2+" M "+sizeObj/2+","+thickObj/2+" L "+sizeObj/2+","+(-thickObj/2), 'fill': "none", 'stroke': "#ccc", 'strokeDashArray': ''});
      construc.push({'path': "M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+((-sizeObj/2)+((sizeObj/2)*0.866))+","+(-sizeObj/4-thickObj/2)+"  A"+sizeObj/2+","+sizeObj/2+" 0 0,1 0,"+(-thickObj/2), 'fill': "none", 'stroke': colorWall, 'strokeDashArray': ''});
      construc.push({'path': "M "+(sizeObj/2)+","+(-thickObj/2)+" L "+((sizeObj/2)+((-sizeObj/2)*0.866))+","+(-sizeObj/4-thickObj/2)+"  A"+sizeObj/2+","+sizeObj/2+" 0 0,0 0,"+(-thickObj/2), 'fill': "none", 'stroke': colorWall, 'strokeDashArray': ''});
      construc.params.resize = true;
      construc.params.resizeLimit.width = {min:40, max:200};
    }
    if (typeObj == 'bay') {
      construc.push({'path':"M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+(-sizeObj/2)+","+thickObj/2+" M "+sizeObj/2+","+thickObj/2+" L "+sizeObj/2+","+(-thickObj/2), 'fill': "none", 'stroke': "#ccc", 'strokeDashArray': ''});
      construc.push({'path':"M "+(-sizeObj/2)+",-2 L "+(-sizeObj/2)+",0 L 2,0 L 2,2 L 3,2 L 3,-2 Z", 'fill': "#ccc", 'stroke': "none", 'strokeDashArray': ''});
      construc.push({'path':"M -2,1 L -2,3 L "+sizeObj/2+",3 L "+sizeObj/2+",1 L -1,1 L -1,-1 L -2,-1 Z", 'fill': "#ccc", 'stroke': "none", 'strokeDashArray': ''});
      construc.params.resize = true;
      construc.params.resizeLimit.width = {min:60, max:300};
    }
  }

  if (classObj == 'measure') {
    construc.params.bindBox = true;
    construc.push({'path':"M-"+(sizeObj/2)+",0 l10,-10 l0,8 l"+(sizeObj-20)+",0 l0,-8 l10,10 l-10,10 l0,-8 l-"+(sizeObj-20)+",0 l0,8 Z", 'fill': "#729eeb", 'stroke': "none", 'strokeDashArray': ''});
    }

  if (classObj == 'boundingBox') {
    construc.push({'path':"M"+(-sizeObj/2-10)+","+(-thickObj/2-10)+" L"+(sizeObj/2+10)+","+(-thickObj/2-10)+" L"+(sizeObj/2+10)+","+(thickObj/2+10)+" L"+(-sizeObj/2-10)+","+(thickObj/2+10)+" Z", 'fill':'none', 'stroke':"#aaa", 'strokeDashArray': ''});

    // construc.push({'path':"M"+dividerObj[0].x+","+dividerObj[0].y+" L"+dividerObj[1].x+","+dividerObj[1].y+" L"+dividerObj[2].x+","+dividerObj[2].y+" L"+dividerObj[3].x+","+dividerObj[3].y+" Z", 'fill':'none', 'stroke':"#000", 'strokeDashArray': ''});
  }

  //typeObj = color  dividerObj = text
  if (classObj == 'text') {
    construc.params.bindBox = true;
    construc.params.move = true;
    construc.params.rotate = true;
    construc.push({'text': dividerObj.text, 'x': '0', 'y':'0', 'fill': typeObj, 'stroke': typeObj, 'fontSize': dividerObj.size+'px',"strokeWidth": "0px"});
  }

  if (classObj == 'stair') {
    construc.params.bindBox = true;
    construc.params.move = true;
    construc.params.resize = true;
    construc.params.rotate = true;
    construc.params.width = 60;
    construc.params.height = 180;
    if (typeObj == 'simpleStair') {
      construc.push({'path':"M "+(-sizeObj/2)+","+(-thickObj/2)+" L "+(-sizeObj/2)+","+thickObj/2+" L "+sizeObj/2+","+thickObj/2+" L "+sizeObj/2+","+(-thickObj/2)+" Z", 'fill': "#fff", 'stroke': "#000", 'strokeDashArray': ''});

      var heightStep = thickObj / (dividerObj);
      for (var i =1; i < dividerObj+1; i++) {
        construc.push({'path':"M "+(-sizeObj/2)+","+((-thickObj/2)+(i*heightStep))+" L "+(sizeObj/2)+","+((-thickObj/2)+(i*heightStep)), 'fill': "none", 'stroke': "#000", 'strokeDashArray': 'none'});
      }
      construc.params.resizeLimit.width = {min:40, max:200};
      construc.params.resizeLimit.height = {min:40, max:400};
    }

  }

  if (classObj == 'energy') {
    construc.params.bindBox = true;
    construc.params.move = true;
    construc.params.resize = false;
    construc.params.rotate = false;
    if (typeObj == 'gtl') {
		
		construc.push({'path': "M59.823 85.688 C 58.996 86.869,58.854 329.894,59.680 330.720 C 60.661 331.701,345.017 331.383,346.000 330.400 C 346.796 329.604,346.800 329.067,346.800 208.659 L 346.800 87.718 345.884 86.359 L 344.968 85.000 202.707 84.899 L 60.446 84.799 59.823 85.688 M345.187 86.775 C 345.471 87.306,345.570 125.698,345.501 208.875 L 345.400 330.200 202.600 330.200 L 59.800 330.200 59.699 208.875 C 59.630 125.698,59.729 87.306,60.013 86.775 C 60.667 85.554,344.533 85.554,345.187 86.775 M64.623 90.489 C 63.602 91.946,63.679 325.068,64.700 325.843 C 65.938 326.783,339.619 326.641,340.763 325.700 L 341.614 325.000 341.507 208.142 C 341.402 93.868,341.383 91.265,340.638 90.442 L 339.876 89.600 202.561 89.600 L 65.245 89.600 64.623 90.489 M340.336 91.819 C 341.020 93.321,341.005 324.435,340.320 325.120 C 339.621 325.819,65.579 325.819,64.880 325.120 C 64.055 324.295,64.196 92.869,65.023 91.689 L 65.645 90.800 202.758 90.800 L 339.872 90.800 340.336 91.819 M140.500 98.796 L 139.200 99.588 139.200 111.200 L 139.200 122.812 140.500 123.604 C 142.459 124.799,235.459 124.861,236.538 123.669 C 237.599 122.496,237.535 99.628,236.469 98.662 C 235.220 97.532,142.360 97.661,140.500 98.796 M279.274 98.583 C 277.981 98.896,276.914 99.431,276.551 99.949 C 276.223 100.417,275.717 100.800,275.426 100.800 C 274.375 100.800,271.891 104.416,271.344 106.744 C 268.615 118.337,276.526 126.552,287.850 123.883 C 289.927 123.393,291.834 122.217,293.494 120.400 C 293.997 119.850,294.740 119.040,295.146 118.600 C 296.359 117.285,296.971 114.803,296.971 111.200 C 296.971 105.869,296.206 104.324,291.458 100.066 C 289.419 98.237,283.619 97.531,279.274 98.583 M236.386 99.574 C 236.642 100.053,236.800 104.484,236.800 111.200 C 236.800 117.916,236.642 122.347,236.386 122.826 C 235.880 123.771,143.473 124.072,141.419 123.136 L 140.400 122.672 140.400 111.197 L 140.400 99.722 141.300 99.288 C 143.186 98.378,235.895 98.657,236.386 99.574 M289.205 99.603 C 289.676 99.855,290.388 100.362,290.788 100.730 C 291.189 101.099,291.940 101.780,292.458 102.244 C 295.644 105.098,296.158 106.342,296.158 111.200 C 296.158 115.940,295.680 117.170,292.800 119.840 C 290.238 122.216,289.331 122.791,287.549 123.174 C 283.718 123.995,278.553 123.397,277.000 121.952 C 275.975 120.999,274.201 119.225,273.248 118.200 C 269.981 114.688,272.334 101.200,276.214 101.200 C 276.483 101.200,276.949 100.836,277.251 100.391 C 278.260 98.904,286.842 98.338,289.205 99.603 M146.142 103.077 C 144.144 103.468,143.972 104.170,144.090 111.442 L 144.200 118.200 145.600 118.899 C 147.822 120.009,230.732 119.980,231.738 118.869 C 232.782 117.714,232.722 104.416,231.669 103.462 C 230.978 102.837,149.249 102.469,146.142 103.077 M281.200 103.277 C 275.683 104.835,273.861 112.934,278.101 117.049 C 285.814 124.535,296.887 113.546,289.746 105.492 C 287.762 103.253,284.383 102.378,281.200 103.277 M231.586 104.374 C 232.129 105.388,232.129 117.012,231.586 118.026 C 231.006 119.110,147.631 119.257,146.089 118.177 C 145.234 117.578,145.200 117.313,145.200 111.200 C 145.200 105.087,145.234 104.822,146.089 104.223 C 147.631 103.143,231.006 103.290,231.586 104.374 M285.617 104.000 C 288.494 104.000,291.200 107.489,291.200 111.200 C 291.200 119.875,278.816 121.605,276.803 113.211 C 275.619 108.278,279.521 102.860,283.533 103.866 C 283.826 103.940,284.764 104.000,285.617 104.000 M81.200 134.606 C 75.698 138.290,73.489 143.536,75.600 147.906 C 76.040 148.816,76.400 149.736,76.400 149.950 C 76.400 150.690,78.489 152.816,80.581 154.205 L 82.683 155.600 203.255 155.600 L 323.827 155.600 325.988 154.208 C 329.800 151.752,330.961 150.141,331.374 146.737 C 331.827 143.003,331.293 139.881,329.953 138.412 C 329.319 137.718,328.800 137.009,328.800 136.835 C 328.800 136.662,327.693 135.863,326.340 135.060 L 323.880 133.600 203.240 133.634 L 82.600 133.669 81.200 134.606 M325.357 135.568 C 330.541 138.098,332.860 146.283,329.444 149.993 C 328.934 150.547,328.416 151.291,328.292 151.647 C 328.167 152.003,326.861 152.858,325.388 153.547 L 322.710 154.800 202.855 154.791 C 84.523 154.782,82.987 154.772,82.000 154.000 C 81.450 153.570,80.796 153.214,80.547 153.209 C 79.761 153.193,77.318 150.171,76.784 148.552 C 75.000 143.153,76.921 137.914,81.600 135.419 L 83.400 134.459 203.200 134.439 L 323.000 134.418 325.357 135.568 M83.055 139.492 C 82.194 140.105,81.083 141.448,80.524 142.550 L 79.528 144.516 80.604 146.644 C 81.197 147.814,82.023 148.880,82.441 149.013 C 82.858 149.145,83.200 149.393,83.200 149.563 C 83.200 150.775,85.637 150.800,203.753 150.800 L 322.269 150.800 324.142 149.341 C 325.214 148.505,326.113 147.437,326.244 146.841 C 326.371 146.268,326.557 145.494,326.658 145.120 C 326.898 144.229,326.105 141.314,325.485 140.808 C 325.218 140.590,324.434 139.959,323.742 139.406 L 322.485 138.400 203.538 138.400 L 84.590 138.400 83.055 139.492 M323.957 140.743 C 326.158 142.645,326.575 146.265,324.757 147.692 C 324.231 148.105,323.440 148.748,323.000 149.121 C 322.252 149.756,314.471 149.807,203.875 149.902 L 85.549 150.004 83.743 148.946 C 80.309 146.933,80.174 142.406,83.484 140.239 L 85.000 139.247 203.600 139.235 L 322.200 139.224 323.957 140.743 M87.062 171.931 C 86.009 173.095,86.046 301.081,87.100 302.362 L 87.800 303.212 203.957 303.106 L 320.114 303.000 320.957 301.871 L 321.800 300.741 321.800 237.071 C 321.800 175.596,321.774 173.362,321.054 172.300 L 320.308 171.200 204.016 171.200 C 91.862 171.200,87.700 171.226,87.062 171.931 M320.320 172.880 C 320.958 173.518,321.023 300.036,320.386 301.226 C 319.978 301.989,318.247 302.000,203.850 302.000 L 87.728 302.000 87.264 300.981 C 86.641 299.614,86.592 174.336,87.214 173.174 C 87.728 172.214,319.362 171.922,320.320 172.880 M91.846 176.986 C 90.820 178.552,90.870 211.461,91.900 212.243 C 92.942 213.034,315.058 213.034,316.100 212.243 C 316.747 211.752,316.800 210.434,316.800 194.726 L 316.800 177.739 315.874 176.870 L 314.948 176.000 203.720 176.000 L 92.492 176.000 91.846 176.986 M315.790 178.380 C 316.595 179.937,316.716 210.724,315.920 211.520 C 315.221 212.219,92.779 212.219,92.080 211.520 C 91.431 210.871,91.393 180.312,92.039 178.460 L 92.478 177.200 203.829 177.200 L 315.179 177.200 315.790 178.380 M91.862 217.531 C 90.835 218.666,90.858 251.097,91.886 252.838 L 92.572 254.000 203.704 254.000 L 314.836 254.000 315.818 253.018 L 316.800 252.036 316.800 235.028 L 316.800 218.021 315.620 217.410 C 313.616 216.374,92.801 216.494,91.862 217.531 M315.700 218.157 C 316.879 219.052,316.762 249.969,315.573 251.638 L 314.746 252.800 203.612 252.800 L 92.478 252.800 92.039 251.540 C 91.393 249.688,91.431 218.729,92.080 218.080 C 92.825 217.335,314.718 217.412,315.700 218.157 M91.823 258.489 C 90.895 259.813,90.884 295.428,91.810 297.220 L 92.421 298.400 203.628 298.400 L 314.836 298.400 315.818 297.418 L 316.800 296.436 316.800 277.907 C 316.800 261.784,316.719 259.263,316.177 258.489 L 315.555 257.600 204.000 257.600 L 92.445 257.600 91.823 258.489 M315.754 259.786 C 316.323 260.655,316.400 262.800,316.400 277.812 C 316.400 294.759,316.308 296.047,315.040 296.894 C 314.798 297.056,264.623 297.191,203.539 297.194 L 92.478 297.200 92.039 295.940 C 91.409 294.133,91.432 261.206,92.064 259.819 L 92.528 258.800 203.818 258.800 L 315.108 258.800 315.754 259.786", 'fill': "#7c7c7c", 'stroke': "none", 'strokeDashArray': ''});
		construc.push({'path': "M60.013 86.775 C 59.729 87.306,59.630 125.698,59.699 208.875 L 59.800 330.200 202.600 330.200 L 345.400 330.200 345.501 208.875 C 345.570 125.698,345.471 87.306,345.187 86.775 C 344.533 85.554,60.667 85.554,60.013 86.775 M344.800 208.601 L 344.800 330.001 202.500 329.901 L 60.200 329.800 60.098 209.000 C 60.041 142.560,60.081 87.975,60.185 87.700 C 60.336 87.301,89.185 87.200,202.587 87.200 L 344.800 87.200 344.800 208.601 M64.262 89.131 C 63.265 90.233,63.236 326.175,64.233 326.557 C 64.581 326.691,127.016 326.800,202.979 326.800 L 341.092 326.800 342.146 325.971 L 343.200 325.142 343.200 208.755 C 343.200 79.455,343.413 90.198,340.825 88.813 C 339.218 87.953,65.043 88.269,64.262 89.131 M340.638 90.442 C 341.383 91.265,341.402 93.868,341.507 208.142 L 341.614 325.000 340.763 325.700 C 339.619 326.641,65.938 326.783,64.700 325.843 C 63.679 325.068,63.602 91.946,64.623 90.489 L 65.245 89.600 202.561 89.600 L 339.876 89.600 340.638 90.442 M141.300 99.288 L 140.400 99.722 140.400 111.197 L 140.400 122.672 141.419 123.136 C 143.473 124.072,235.880 123.771,236.386 122.826 C 236.642 122.347,236.800 117.916,236.800 111.200 C 236.800 104.484,236.642 100.053,236.386 99.574 C 235.895 98.657,143.186 98.378,141.300 99.288 M279.600 99.208 C 278.554 99.425,277.570 99.921,277.251 100.391 C 276.949 100.836,276.483 101.200,276.214 101.200 C 272.334 101.200,269.981 114.688,273.248 118.200 C 274.201 119.225,275.975 120.999,277.000 121.952 C 279.497 124.274,288.073 124.039,290.868 121.572 C 295.804 117.215,296.158 116.522,296.158 111.200 C 296.158 106.342,295.644 105.098,292.458 102.244 C 291.940 101.780,291.189 101.099,290.788 100.730 C 289.014 99.098,283.650 98.368,279.600 99.208 M236.200 111.200 L 236.200 122.600 189.600 122.710 C 163.970 122.770,142.595 122.722,142.100 122.602 L 141.200 122.385 141.200 111.226 C 141.200 102.673,141.317 100.019,141.700 99.864 C 141.975 99.753,163.350 99.693,189.200 99.731 L 236.200 99.800 236.200 111.200 M288.638 100.443 C 289.057 100.906,290.071 101.628,290.892 102.046 C 291.712 102.465,292.683 103.391,293.048 104.104 C 293.414 104.817,294.137 105.909,294.656 106.531 C 296.051 108.202,296.062 114.174,294.674 115.869 C 294.165 116.491,293.353 117.654,292.870 118.453 C 292.387 119.253,291.410 120.145,290.696 120.438 C 289.983 120.730,289.072 121.381,288.671 121.885 C 287.457 123.408,280.780 123.253,278.579 121.650 C 277.710 121.018,276.610 120.381,276.133 120.234 C 275.657 120.087,275.086 119.449,274.865 118.816 C 274.645 118.182,274.045 117.245,273.532 116.732 C 272.664 115.864,272.600 115.484,272.600 111.200 C 272.600 106.916,272.664 106.536,273.532 105.668 C 274.045 105.155,274.645 104.218,274.865 103.584 C 275.086 102.951,275.657 102.313,276.133 102.166 C 276.610 102.019,277.710 101.382,278.579 100.750 C 280.709 99.199,287.330 98.997,288.638 100.443 M145.200 102.036 C 142.818 103.454,142.800 103.523,142.800 111.200 C 142.800 118.638,142.847 118.848,144.789 120.141 C 145.692 120.743,149.516 120.800,188.656 120.800 L 231.535 120.800 232.367 119.453 C 233.758 117.202,233.624 104.810,232.186 102.693 L 231.171 101.200 188.886 101.201 C 146.752 101.203,146.595 101.206,145.200 102.036 M281.923 101.934 C 281.635 102.338,280.775 102.791,280.012 102.942 C 278.053 103.328,275.600 106.102,275.600 107.931 C 275.600 108.362,275.330 108.818,275.000 108.945 C 274.576 109.107,274.400 109.769,274.400 111.200 C 274.400 112.631,274.576 113.293,275.000 113.455 C 275.330 113.582,275.600 114.038,275.600 114.469 C 275.600 116.564,278.636 119.600,280.731 119.600 C 281.162 119.600,281.618 119.870,281.745 120.200 C 281.896 120.594,282.520 120.800,283.559 120.800 C 284.434 120.800,285.412 120.531,285.743 120.200 C 286.073 119.870,286.766 119.600,287.282 119.600 C 288.448 119.600,290.000 118.554,290.000 117.767 C 290.000 117.444,290.440 117.013,290.978 116.808 C 291.702 116.533,292.019 116.041,292.196 114.918 C 292.328 114.083,292.637 112.723,292.883 111.896 C 293.211 110.796,293.212 110.151,292.889 109.496 C 292.646 109.003,292.329 108.004,292.186 107.276 C 292.011 106.383,291.613 105.833,290.963 105.586 C 290.433 105.385,290.000 104.956,290.000 104.633 C 290.000 103.801,288.423 102.800,287.111 102.800 C 286.500 102.800,286.000 102.628,286.000 102.419 C 286.000 102.097,283.608 101.209,282.723 101.202 C 282.570 101.201,282.210 101.530,281.923 101.934 M231.669 103.462 C 232.722 104.416,232.782 117.714,231.738 118.869 C 230.732 119.980,147.822 120.009,145.600 118.899 L 144.200 118.200 144.090 111.442 C 143.972 104.170,144.144 103.468,146.142 103.077 C 149.249 102.469,230.978 102.837,231.669 103.462 M287.746 103.694 C 288.590 104.128,290.753 106.476,291.486 107.753 C 292.110 108.841,292.107 113.079,291.482 114.477 C 288.325 121.532,277.766 120.763,275.988 113.349 C 274.321 106.403,281.522 100.490,287.746 103.694 M81.600 135.419 C 76.921 137.914,75.000 143.153,76.784 148.552 C 77.318 150.171,79.761 153.193,80.547 153.209 C 80.796 153.214,81.450 153.570,82.000 154.000 C 82.987 154.772,84.523 154.782,202.855 154.791 L 322.710 154.800 325.388 153.547 C 326.861 152.858,328.167 152.003,328.292 151.647 C 328.416 151.291,328.934 150.547,329.444 149.993 C 332.860 146.283,330.541 138.098,325.357 135.568 L 323.000 134.418 203.200 134.439 L 83.400 134.459 81.600 135.419 M325.000 136.532 C 326.934 136.933,327.424 137.192,327.522 137.867 C 327.588 138.327,328.173 139.298,328.822 140.024 C 330.593 142.008,330.582 146.758,328.800 149.000 C 328.140 149.831,327.600 150.833,327.600 151.228 C 327.600 153.293,331.772 153.230,202.000 153.110 C 73.428 152.992,79.964 153.103,79.441 151.021 C 79.313 150.512,78.874 150.008,78.465 149.901 C 76.748 149.452,76.729 139.521,78.445 139.072 C 78.855 138.965,79.364 138.420,79.577 137.860 C 79.866 137.100,80.347 136.779,81.482 136.589 C 82.317 136.449,83.180 136.273,83.400 136.199 C 84.725 135.750,322.808 136.078,325.000 136.532 M83.145 137.866 C 82.289 138.095,79.323 141.624,78.775 143.066 C 77.963 145.200,78.744 146.948,82.067 150.434 C 83.208 151.631,84.064 151.639,205.231 151.518 L 323.461 151.400 324.908 150.200 C 325.808 149.454,326.529 148.395,326.815 147.400 C 327.068 146.520,327.548 145.494,327.882 145.119 C 328.428 144.507,328.405 144.332,327.644 143.366 C 327.180 142.775,326.800 141.957,326.800 141.547 C 326.800 141.137,326.163 140.126,325.384 139.301 L 323.969 137.800 203.884 137.745 C 137.838 137.715,83.505 137.770,83.145 137.866 M323.742 139.406 C 324.434 139.959,325.218 140.590,325.485 140.808 C 326.105 141.314,326.898 144.229,326.658 145.120 C 326.557 145.494,326.371 146.268,326.244 146.841 C 326.113 147.437,325.214 148.505,324.142 149.341 L 322.269 150.800 203.753 150.800 C 85.637 150.800,83.200 150.775,83.200 149.563 C 83.200 149.393,82.858 149.145,82.441 149.013 C 82.023 148.880,81.197 147.814,80.604 146.644 L 79.528 144.516 80.524 142.550 C 81.083 141.448,82.194 140.105,83.055 139.492 L 84.590 138.400 203.538 138.400 L 322.485 138.400 323.742 139.406 M87.214 173.174 C 86.592 174.336,86.641 299.614,87.264 300.981 L 87.728 302.000 203.850 302.000 C 318.247 302.000,319.978 301.989,320.386 301.226 C 321.023 300.036,320.958 173.518,320.320 172.880 C 319.362 171.922,87.728 172.214,87.214 173.174 M320.200 237.200 L 320.200 300.600 204.024 300.701 C 111.347 300.781,87.784 300.700,87.530 300.301 C 87.147 299.698,87.085 174.248,87.467 173.866 C 87.614 173.719,140.039 173.644,203.967 173.699 L 320.200 173.800 320.200 237.200 M91.362 175.642 C 90.270 176.847,89.943 211.486,91.013 212.556 C 92.040 213.583,315.499 213.541,317.238 212.514 L 318.400 211.828 318.400 194.871 L 318.400 177.915 317.166 176.358 L 315.933 174.800 204.028 174.800 L 92.124 174.800 91.362 175.642 M315.874 176.870 L 316.800 177.739 316.800 194.726 C 316.800 210.434,316.747 211.752,316.100 212.243 C 315.058 213.034,92.942 213.034,91.900 212.243 C 90.870 211.461,90.820 178.552,91.846 176.986 L 92.492 176.000 203.720 176.000 L 314.948 176.000 315.874 176.870 M91.292 217.021 L 90.400 217.645 90.400 234.836 C 90.400 248.942,90.504 252.275,90.980 253.413 L 91.559 254.800 203.975 254.800 L 316.390 254.800 317.395 253.208 L 318.400 251.616 318.400 234.897 L 318.400 218.178 317.500 217.389 C 316.242 216.287,92.859 215.923,91.292 217.021 M315.620 217.410 L 316.800 218.021 316.800 235.028 L 316.800 252.036 315.818 253.018 L 314.836 254.000 203.704 254.000 L 92.572 254.000 91.886 252.838 C 90.858 251.097,90.835 218.666,91.862 217.531 C 92.801 216.494,313.616 216.374,315.620 217.410 M91.725 256.714 C 90.529 257.475,90.400 259.526,90.400 277.839 C 90.400 293.165,90.502 296.669,90.980 297.813 L 91.559 299.200 203.975 299.200 L 316.390 299.200 317.395 297.608 L 318.400 296.016 318.400 277.770 C 318.400 258.067,318.419 258.248,316.219 256.706 C 315.664 256.317,92.338 256.325,91.725 256.714 M316.177 258.489 C 316.719 259.263,316.800 261.784,316.800 277.907 L 316.800 296.436 315.818 297.418 L 314.836 298.400 203.628 298.400 L 92.421 298.400 91.810 297.220 C 90.884 295.428,90.895 259.813,91.823 258.489 L 92.445 257.600 204.000 257.600 L 315.555 257.600 316.177 258.489", 'fill': "#3c3c3c", 'stroke': "none", 'strokeDashArray': ''});
		construc.push({'path': "M60.185 87.700 C 60.081 87.975,60.041 142.560,60.098 209.000 L 60.200 329.800 202.500 329.901 L 344.800 330.001 344.800 208.601 L 344.800 87.200 202.587 87.200 C 89.185 87.200,60.336 87.301,60.185 87.700 M340.825 88.813 C 343.413 90.198,343.200 79.455,343.200 208.755 L 343.200 325.142 342.146 325.971 L 341.092 326.800 202.979 326.800 C 127.016 326.800,64.581 326.691,64.233 326.557 C 63.236 326.175,63.265 90.233,64.262 89.131 C 65.043 88.269,339.218 87.953,340.825 88.813 M141.700 99.864 C 141.317 100.019,141.200 102.673,141.200 111.226 L 141.200 122.385 142.100 122.602 C 142.595 122.722,163.970 122.770,189.600 122.710 L 236.200 122.600 236.200 111.200 L 236.200 99.800 189.200 99.731 C 163.350 99.693,141.975 99.753,141.700 99.864 M278.579 100.750 C 277.710 101.382,276.610 102.019,276.133 102.166 C 275.657 102.313,275.086 102.951,274.865 103.584 C 274.645 104.218,274.045 105.155,273.532 105.668 C 272.664 106.536,272.600 106.916,272.600 111.200 C 272.600 115.484,272.664 115.864,273.532 116.732 C 274.045 117.245,274.645 118.182,274.865 118.816 C 275.086 119.449,275.657 120.087,276.133 120.234 C 276.610 120.381,277.710 121.018,278.579 121.650 C 280.780 123.253,287.457 123.408,288.671 121.885 C 289.072 121.381,289.983 120.730,290.696 120.438 C 291.410 120.145,292.387 119.253,292.870 118.453 C 293.353 117.654,294.165 116.491,294.674 115.869 C 296.062 114.174,296.051 108.202,294.656 106.531 C 294.137 105.909,293.414 104.817,293.048 104.104 C 292.683 103.391,291.712 102.465,290.892 102.046 C 290.071 101.628,289.057 100.906,288.638 100.443 C 287.330 98.997,280.709 99.199,278.579 100.750 M232.186 102.693 C 233.624 104.810,233.758 117.202,232.367 119.453 L 231.535 120.800 188.656 120.800 C 149.516 120.800,145.692 120.743,144.789 120.141 C 142.847 118.848,142.800 118.638,142.800 111.200 C 142.800 99.972,137.126 101.203,188.886 101.201 L 231.171 101.200 232.186 102.693 M284.500 101.621 C 285.325 101.850,286.000 102.209,286.000 102.419 C 286.000 102.628,286.500 102.800,287.111 102.800 C 288.423 102.800,290.000 103.801,290.000 104.633 C 290.000 104.956,290.433 105.385,290.963 105.586 C 291.613 105.833,292.011 106.383,292.186 107.276 C 292.329 108.004,292.646 109.003,292.889 109.496 C 293.212 110.151,293.211 110.796,292.883 111.896 C 292.637 112.723,292.328 114.083,292.196 114.918 C 292.019 116.041,291.702 116.533,290.978 116.808 C 290.440 117.013,290.000 117.444,290.000 117.767 C 290.000 118.554,288.448 119.600,287.282 119.600 C 286.766 119.600,286.073 119.870,285.743 120.200 C 285.412 120.531,284.434 120.800,283.559 120.800 C 282.520 120.800,281.896 120.594,281.745 120.200 C 281.618 119.870,281.162 119.600,280.731 119.600 C 278.636 119.600,275.600 116.564,275.600 114.469 C 275.600 114.038,275.330 113.582,275.000 113.455 C 274.576 113.293,274.400 112.631,274.400 111.200 C 274.400 109.769,274.576 109.107,275.000 108.945 C 275.330 108.818,275.600 108.362,275.600 107.931 C 275.600 106.102,278.053 103.328,280.012 102.942 C 280.775 102.791,281.635 102.338,281.923 101.934 C 282.532 101.078,282.541 101.077,284.500 101.621 M83.400 136.199 C 83.180 136.273,82.317 136.449,81.482 136.589 C 80.347 136.779,79.866 137.100,79.577 137.860 C 79.364 138.420,78.855 138.965,78.445 139.072 C 76.729 139.521,76.748 149.452,78.465 149.901 C 78.874 150.008,79.313 150.512,79.441 151.021 C 79.964 153.103,73.428 152.992,202.000 153.110 C 331.772 153.230,327.600 153.293,327.600 151.228 C 327.600 150.833,328.140 149.831,328.800 149.000 C 330.582 146.758,330.593 142.008,328.822 140.024 C 328.173 139.298,327.588 138.327,327.522 137.867 C 327.249 135.991,330.205 136.034,203.200 136.049 C 137.530 136.057,83.620 136.124,83.400 136.199 M325.384 139.301 C 326.163 140.126,326.800 141.137,326.800 141.547 C 326.800 141.957,327.180 142.775,327.644 143.366 C 328.405 144.332,328.428 144.507,327.882 145.119 C 327.548 145.494,327.068 146.520,326.815 147.400 C 326.529 148.395,325.808 149.454,324.908 150.200 L 323.461 151.400 205.231 151.518 C 84.064 151.639,83.208 151.631,82.067 150.434 C 78.744 146.948,77.963 145.200,78.775 143.066 C 79.323 141.624,82.289 138.095,83.145 137.866 C 83.505 137.770,137.838 137.715,203.884 137.745 L 323.969 137.800 325.384 139.301 M87.467 173.866 C 87.085 174.248,87.147 299.698,87.530 300.301 C 87.784 300.700,111.347 300.781,204.024 300.701 L 320.200 300.600 320.200 237.200 L 320.200 173.800 203.967 173.699 C 140.039 173.644,87.614 173.719,87.467 173.866 M317.166 176.358 L 318.400 177.915 318.400 194.871 L 318.400 211.828 317.238 212.514 C 315.499 213.541,92.040 213.583,91.013 212.556 C 89.943 211.486,90.270 176.847,91.362 175.642 L 92.124 174.800 204.028 174.800 L 315.933 174.800 317.166 176.358 M317.500 217.389 L 318.400 218.178 318.400 234.897 L 318.400 251.616 317.395 253.208 L 316.390 254.800 203.975 254.800 L 91.559 254.800 90.980 253.413 C 90.504 252.275,90.400 248.942,90.400 234.836 L 90.400 217.645 91.292 217.021 C 92.859 215.923,316.242 216.287,317.500 217.389 M316.219 256.706 C 318.419 258.248,318.400 258.067,318.400 277.770 L 318.400 296.016 317.395 297.608 L 316.390 299.200 203.975 299.200 L 91.559 299.200 90.980 297.813 C 90.502 296.669,90.400 293.165,90.400 277.839 C 90.400 259.526,90.529 257.475,91.725 256.714 C 92.338 256.325,315.664 256.317,316.219 256.706", 'fill': "#040404", 'stroke': "none", 'strokeDashArray': ''});
		construc.push({'path': "M0.000 200.000 L 0.000 400.000 200.000 400.000 L 400.000 400.000 400.000 200.000 L 400.000 0.000 200.000 0.000 L 0.000 0.000 0.000 200.000 M346.000 84.114 C 348.157 85.869,348.000 76.080,348.000 208.598 L 348.000 330.072 347.100 330.823 C 345.657 332.027,59.455 332.024,58.811 330.820 C 58.109 329.508,58.444 85.111,59.149 84.261 C 59.870 83.393,344.934 83.246,346.000 84.114 M65.385 92.500 C 65.281 92.775,65.241 145.200,65.298 209.000 L 65.400 325.000 202.600 325.000 L 339.800 325.000 339.901 208.500 L 340.001 92.000 202.788 92.000 C 93.385 92.000,65.536 92.101,65.385 92.500 M236.964 97.631 L 238.000 98.861 238.000 111.200 L 238.000 123.539 236.964 124.769 L 235.929 126.000 189.125 126.000 C 138.723 126.000,141.076 126.090,138.700 124.071 C 137.618 123.151,137.629 99.260,138.712 98.280 C 140.825 96.367,139.061 96.432,189.064 96.416 L 235.929 96.400 236.964 97.631 M286.296 97.200 C 287.116 97.640,288.277 98.000,288.875 98.000 C 290.352 98.000,291.937 98.771,292.207 99.621 C 292.329 100.006,292.869 100.431,293.408 100.566 C 294.002 100.715,294.485 101.198,294.634 101.792 C 294.769 102.331,295.232 102.883,295.663 103.020 C 296.617 103.323,297.200 104.742,297.200 106.764 C 297.200 107.768,297.469 108.519,298.000 109.000 C 298.525 109.475,298.800 110.232,298.800 111.200 C 298.800 112.168,298.525 112.925,298.000 113.400 C 297.486 113.866,297.198 114.637,297.195 115.562 C 297.186 117.724,296.831 118.648,295.797 119.202 C 295.282 119.477,294.755 120.127,294.624 120.645 C 294.484 121.203,293.988 121.688,293.408 121.834 C 292.869 121.969,292.329 122.394,292.207 122.779 C 291.937 123.629,290.352 124.400,288.875 124.400 C 288.277 124.400,287.116 124.760,286.296 125.200 C 284.507 126.159,283.398 126.203,281.818 125.379 C 281.168 125.040,279.835 124.652,278.857 124.518 C 276.855 124.244,275.591 123.289,271.818 119.200 C 271.261 118.597,270.804 117.478,270.666 116.382 C 270.541 115.382,270.160 114.032,269.821 113.382 C 269.005 111.817,269.041 110.834,270.000 108.400 C 270.440 107.284,270.800 105.848,270.800 105.210 C 270.800 104.479,271.244 103.563,272.000 102.736 C 272.660 102.013,273.200 101.294,273.200 101.138 C 273.200 100.982,273.539 100.746,273.953 100.615 C 274.368 100.483,275.266 99.841,275.950 99.188 C 276.688 98.482,277.641 97.991,278.296 97.978 C 278.903 97.965,280.210 97.615,281.200 97.200 C 283.528 96.223,284.473 96.223,286.296 97.200 M146.400 111.200 L 146.400 117.600 188.800 117.600 L 231.200 117.600 231.200 111.200 L 231.200 104.800 188.800 104.800 L 146.400 104.800 146.400 111.200 M280.070 105.806 C 279.818 106.359,279.159 107.018,278.606 107.270 C 277.644 107.708,277.600 107.880,277.600 111.200 C 277.600 114.520,277.644 114.692,278.606 115.130 C 279.159 115.382,279.818 116.041,280.070 116.594 C 280.883 118.378,288.000 117.938,288.000 116.103 C 288.000 115.909,288.540 115.232,289.200 114.600 C 290.255 113.589,290.400 113.178,290.400 111.200 C 290.400 109.222,290.255 108.811,289.200 107.800 C 288.540 107.168,288.000 106.491,288.000 106.297 C 288.000 104.462,280.883 104.022,280.070 105.806 M323.774 132.772 C 325.015 132.975,326.003 133.410,326.434 133.942 C 326.811 134.408,327.605 134.974,328.198 135.199 C 328.792 135.425,329.371 135.967,329.485 136.405 C 329.600 136.842,329.839 137.200,330.018 137.200 C 330.853 137.200,331.543 138.585,331.796 140.770 C 331.949 142.086,332.328 143.374,332.637 143.631 C 333.361 144.232,333.353 144.975,332.616 145.587 C 332.294 145.854,331.910 147.148,331.761 148.462 C 331.553 150.306,331.288 150.986,330.607 151.432 C 330.121 151.751,329.519 152.459,329.270 153.006 C 329.021 153.553,328.505 154.000,328.124 154.000 C 327.742 154.000,327.035 154.495,326.553 155.100 L 325.676 156.200 203.938 156.300 C 88.603 156.396,82.134 156.364,80.948 155.700 C 77.661 153.861,75.600 151.718,75.600 150.138 C 75.600 149.862,75.150 149.186,74.600 148.636 C 73.112 147.149,73.108 142.151,74.593 140.742 C 75.139 140.224,75.589 139.493,75.593 139.119 C 75.606 137.802,76.552 136.372,77.969 135.525 C 78.756 135.055,79.811 134.302,80.314 133.852 C 80.817 133.402,82.077 132.915,83.114 132.770 C 85.863 132.386,321.435 132.388,323.774 132.772 M83.747 141.285 C 81.199 142.106,81.585 146.938,84.270 147.845 C 86.601 148.633,322.070 148.490,322.860 147.700 C 323.135 147.425,323.660 147.200,324.028 147.200 C 324.786 147.200,325.220 145.341,324.916 143.400 C 324.471 140.567,335.324 140.795,203.369 140.841 C 124.952 140.868,84.577 141.018,83.747 141.285 M320.986 170.250 C 321.344 170.387,322.079 171.371,322.619 172.437 L 323.600 174.373 323.591 237.087 C 323.581 306.460,323.747 301.931,321.154 303.747 C 320.207 304.410,89.750 304.804,87.296 304.147 C 85.794 303.744,85.800 304.007,85.800 236.468 C 85.800 172.258,85.813 171.126,86.576 170.568 C 87.386 169.975,319.451 169.661,320.986 170.250 M92.400 195.000 L 92.400 211.600 203.800 211.600 L 315.200 211.600 315.200 195.000 L 315.200 178.400 203.800 178.400 L 92.400 178.400 92.400 195.000 M92.400 234.800 L 92.400 251.200 203.800 251.200 L 315.200 251.200 315.200 234.800 L 315.200 218.400 203.800 218.400 L 92.400 218.400 92.400 234.800 M92.400 278.001 L 92.400 296.001 203.700 295.901 L 315.000 295.800 315.104 277.900 L 315.208 260.000 203.804 260.000 L 92.400 260.000 92.400 278.001", 'fill': "#fcfcfc", 'stroke': "none", 'strokeDashArray': ''});
		construc.push({'path': "M59.149 84.261 C 58.444 85.111,58.109 329.508,58.811 330.820 C 59.455 332.024,345.657 332.027,347.100 330.823 L 348.000 330.072 348.000 208.598 C 348.000 76.080,348.157 85.869,346.000 84.114 C 344.934 83.246,59.870 83.393,59.149 84.261 M345.884 86.359 L 346.800 87.718 346.800 208.659 C 346.800 329.067,346.796 329.604,346.000 330.400 C 345.017 331.383,60.661 331.701,59.680 330.720 C 58.854 329.894,58.996 86.869,59.823 85.688 L 60.446 84.799 202.707 84.899 L 344.968 85.000 345.884 86.359 M65.023 91.689 C 64.196 92.869,64.055 324.295,64.880 325.120 C 65.579 325.819,339.621 325.819,340.320 325.120 C 341.005 324.435,341.020 93.321,340.336 91.819 L 339.872 90.800 202.758 90.800 L 65.645 90.800 65.023 91.689 M339.901 208.500 L 339.800 325.000 202.600 325.000 L 65.400 325.000 65.298 209.000 C 65.241 145.200,65.281 92.775,65.385 92.500 C 65.536 92.101,93.385 92.000,202.788 92.000 L 340.001 92.000 339.901 208.500 M140.812 97.033 C 137.847 98.320,138.000 97.546,138.000 111.200 C 138.000 124.866,137.813 123.941,140.860 125.333 C 142.197 125.944,146.281 126.000,189.125 126.000 L 235.929 126.000 236.964 124.769 L 238.000 123.539 238.000 111.200 L 238.000 98.861 236.964 97.631 L 235.929 96.400 189.064 96.416 C 148.240 96.429,142.021 96.509,140.812 97.033 M281.200 97.200 C 280.210 97.615,278.903 97.965,278.296 97.978 C 277.641 97.991,276.688 98.482,275.950 99.188 C 275.266 99.841,274.368 100.483,273.953 100.615 C 273.539 100.746,273.200 100.982,273.200 101.138 C 273.200 101.294,272.660 102.013,272.000 102.736 C 271.244 103.563,270.800 104.479,270.800 105.210 C 270.800 105.848,270.440 107.284,270.000 108.400 C 269.041 110.834,269.005 111.817,269.821 113.382 C 270.160 114.032,270.541 115.382,270.666 116.382 C 270.804 117.478,271.261 118.597,271.818 119.200 C 275.591 123.289,276.855 124.244,278.857 124.518 C 279.835 124.652,281.168 125.040,281.818 125.379 C 283.398 126.203,284.507 126.159,286.296 125.200 C 287.116 124.760,288.277 124.400,288.875 124.400 C 290.352 124.400,291.937 123.629,292.207 122.779 C 292.329 122.394,292.869 121.969,293.408 121.834 C 293.988 121.688,294.484 121.203,294.624 120.645 C 294.755 120.127,295.282 119.477,295.797 119.202 C 296.831 118.648,297.186 117.724,297.195 115.562 C 297.198 114.637,297.486 113.866,298.000 113.400 C 298.525 112.925,298.800 112.168,298.800 111.200 C 298.800 110.232,298.525 109.475,298.000 109.000 C 297.469 108.519,297.200 107.768,297.200 106.764 C 297.200 104.742,296.617 103.323,295.663 103.020 C 295.232 102.883,294.769 102.331,294.634 101.792 C 294.485 101.198,294.002 100.715,293.408 100.566 C 292.869 100.431,292.329 100.006,292.207 99.621 C 291.937 98.771,290.352 98.000,288.875 98.000 C 288.277 98.000,287.116 97.640,286.296 97.200 C 284.473 96.223,283.528 96.223,281.200 97.200 M236.469 98.662 C 237.535 99.628,237.599 122.496,236.538 123.669 C 235.459 124.861,142.459 124.799,140.500 123.604 L 139.200 122.812 139.200 111.200 L 139.200 99.588 140.500 98.796 C 142.360 97.661,235.220 97.532,236.469 98.662 M288.108 98.580 C 290.568 99.168,292.010 100.223,295.040 103.650 C 297.630 106.581,297.696 115.836,295.146 118.600 C 294.740 119.040,293.997 119.850,293.494 120.400 C 285.370 129.291,270.770 123.294,270.806 111.080 C 270.820 106.622,273.435 100.800,275.426 100.800 C 275.717 100.800,276.223 100.417,276.551 99.949 C 277.743 98.247,283.742 97.537,288.108 98.580 M146.089 104.223 C 145.234 104.822,145.200 105.087,145.200 111.200 C 145.200 117.313,145.234 117.578,146.089 118.177 C 147.631 119.257,231.006 119.110,231.586 118.026 C 232.129 117.012,232.129 105.388,231.586 104.374 C 231.006 103.290,147.631 103.143,146.089 104.223 M281.741 103.889 C 278.393 104.303,275.827 109.146,276.803 113.211 C 278.816 121.605,291.200 119.875,291.200 111.200 C 291.200 107.489,288.494 104.000,285.617 104.000 C 284.764 104.000,283.826 103.940,283.533 103.866 C 283.240 103.793,282.433 103.803,281.741 103.889 M231.200 111.200 L 231.200 117.600 188.800 117.600 L 146.400 117.600 146.400 111.200 L 146.400 104.800 188.800 104.800 L 231.200 104.800 231.200 111.200 M287.429 105.371 C 287.743 105.686,288.000 106.102,288.000 106.297 C 288.000 106.491,288.540 107.168,289.200 107.800 C 290.255 108.811,290.400 109.222,290.400 111.200 C 290.400 113.178,290.255 113.589,289.200 114.600 C 288.540 115.232,288.000 115.909,288.000 116.103 C 288.000 117.938,280.883 118.378,280.070 116.594 C 279.818 116.041,279.159 115.382,278.606 115.130 C 277.644 114.692,277.600 114.520,277.600 111.200 C 277.600 107.880,277.644 107.708,278.606 107.270 C 279.159 107.018,279.818 106.359,280.070 105.806 C 280.623 104.592,286.314 104.256,287.429 105.371 M83.114 132.770 C 82.077 132.915,80.817 133.402,80.314 133.852 C 79.811 134.302,78.756 135.055,77.969 135.525 C 76.552 136.372,75.606 137.802,75.593 139.119 C 75.589 139.493,75.139 140.224,74.593 140.742 C 73.108 142.151,73.112 147.149,74.600 148.636 C 75.150 149.186,75.600 149.862,75.600 150.138 C 75.600 151.718,77.661 153.861,80.948 155.700 C 82.134 156.364,88.603 156.396,203.938 156.300 L 325.676 156.200 326.553 155.100 C 327.035 154.495,327.742 154.000,328.124 154.000 C 328.505 154.000,329.021 153.553,329.270 153.006 C 329.519 152.459,330.121 151.751,330.607 151.432 C 331.288 150.986,331.553 150.306,331.761 148.462 C 331.910 147.148,332.294 145.854,332.616 145.587 C 333.353 144.975,333.361 144.232,332.637 143.631 C 332.328 143.374,331.949 142.086,331.796 140.770 C 331.543 138.585,330.853 137.200,330.018 137.200 C 329.839 137.200,329.600 136.842,329.485 136.405 C 329.371 135.967,328.792 135.425,328.198 135.199 C 327.605 134.974,326.811 134.408,326.434 133.942 C 326.003 133.410,325.015 132.975,323.774 132.772 C 321.435 132.388,85.863 132.386,83.114 132.770 M326.340 135.060 C 327.693 135.863,328.800 136.662,328.800 136.835 C 328.800 137.009,329.319 137.718,329.953 138.412 C 331.293 139.881,331.827 143.003,331.374 146.737 C 330.961 150.141,329.800 151.752,325.988 154.208 L 323.827 155.600 203.255 155.600 L 82.683 155.600 80.581 154.205 C 78.489 152.816,76.400 150.690,76.400 149.950 C 76.400 149.736,76.040 148.816,75.600 147.906 C 73.489 143.536,75.698 138.290,81.200 134.606 L 82.600 133.669 203.240 133.634 L 323.880 133.600 326.340 135.060 M83.484 140.239 C 80.174 142.406,80.309 146.933,83.743 148.946 L 85.549 150.004 203.875 149.902 C 314.471 149.807,322.252 149.756,323.000 149.121 C 323.440 148.748,324.231 148.105,324.757 147.692 C 326.575 146.265,326.158 142.645,323.957 140.743 L 322.200 139.224 203.600 139.235 L 85.000 139.247 83.484 140.239 M323.233 141.500 C 324.366 142.031,324.773 142.490,324.916 143.400 C 325.220 145.341,324.786 147.200,324.028 147.200 C 323.660 147.200,323.135 147.425,322.860 147.700 C 322.070 148.490,86.601 148.633,84.270 147.845 C 81.585 146.938,81.199 142.106,83.747 141.285 C 86.297 140.464,321.470 140.675,323.233 141.500 M86.576 170.568 C 85.813 171.126,85.800 172.258,85.800 236.468 C 85.800 304.007,85.794 303.744,87.296 304.147 C 89.750 304.804,320.207 304.410,321.154 303.747 C 323.747 301.931,323.581 306.460,323.591 237.087 L 323.600 174.373 322.619 172.437 C 322.079 171.371,321.344 170.387,320.986 170.250 C 319.451 169.661,87.386 169.975,86.576 170.568 M321.054 172.300 C 321.774 173.362,321.800 175.596,321.800 237.071 L 321.800 300.741 320.957 301.871 L 320.114 303.000 203.957 303.106 L 87.800 303.212 87.100 302.362 C 86.046 301.081,86.009 173.095,87.062 171.931 C 87.700 171.226,91.862 171.200,204.016 171.200 L 320.308 171.200 321.054 172.300 M92.039 178.460 C 91.393 180.312,91.431 210.871,92.080 211.520 C 92.779 212.219,315.221 212.219,315.920 211.520 C 316.716 210.724,316.595 179.937,315.790 178.380 L 315.179 177.200 203.829 177.200 L 92.478 177.200 92.039 178.460 M315.200 195.000 L 315.200 211.600 203.800 211.600 L 92.400 211.600 92.400 195.000 L 92.400 178.400 203.800 178.400 L 315.200 178.400 315.200 195.000 M92.080 218.080 C 91.431 218.729,91.393 249.688,92.039 251.540 L 92.478 252.800 203.612 252.800 L 314.746 252.800 315.573 251.638 C 316.762 249.969,316.879 219.052,315.700 218.157 C 314.718 217.412,92.825 217.335,92.080 218.080 M315.200 234.800 L 315.200 251.200 203.800 251.200 L 92.400 251.200 92.400 234.800 L 92.400 218.400 203.800 218.400 L 315.200 218.400 315.200 234.800 M92.064 259.819 C 91.432 261.206,91.409 294.133,92.039 295.940 L 92.478 297.200 203.539 297.194 C 264.623 297.191,314.798 297.056,315.040 296.894 C 316.308 296.047,316.400 294.759,316.400 277.812 C 316.400 262.800,316.323 260.655,315.754 259.786 L 315.108 258.800 203.818 258.800 L 92.528 258.800 92.064 259.819 M315.104 277.900 L 315.000 295.800 203.700 295.901 L 92.400 296.001 92.400 278.001 L 92.400 260.000 203.804 260.000 L 315.208 260.000 315.104 277.900", 'fill': "#bcbcbc", 'stroke': "none", 'strokeDashArray': ''});
      construc.params.width = 150;
      construc.params.height = 150;
      construc.family = 'stick';
    } 
	  
	if (typeObj == 'puntos_electricos_extras')
	{
	
		construc.push({'path': "M0 0L0 1L35 1L35 36L36 36L36 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		construc.push({'path': "M0 1L0 36L35 36L35 1L0 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		construc.push({'path': "M3 4L3 33L33 33L33 4L3 4z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		construc.push({'path': "M6 6L16 18L16 19L6 31L18 23.0556L30 31L20 19L20 18L30 6L18 13.9444L6 6z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		
      	construc.params.width = 15;
		construc.params.height = 15;
      	construc.params.rotate = true;
		
	}
	  
	if (typeObj == 'bajo1' || typeObj == 'horno' || typeObj == 'vitro_induccion' || typeObj == 'placa_gas' || typeObj == 'micro' || typeObj == 'frigo' || typeObj == 'lavavajillas' || typeObj == 'lavadora' || typeObj == 'secadora' || typeObj == 'fregadero' || typeObj == 'termo_electrico' || typeObj == 'calentador_gas' || typeObj == 'caldera_gas')
	{
		/*
      construc.push({'path': "M0 0L0 41L41 41L41 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj});
		
		construc.push({'path': "M1 1L1 40L40 40L40 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj});
		
		construc.push({'path': "M5 33L6 38L7 37L5 33z", 'stroke': "", 'strokeDashArray': typeObj});
		construc.push({'path': "M6 33L7 34L6 33z", 'stroke': "", 'strokeDashArray': typeObj});
		construc.push({'path': "M9 33L9 38L11 38L11 33L9 33z", 'stroke': "", 'strokeDashArray': typeObj});
		construc.push({'path': "M13 33L14 34L13 33z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M14 33L14 38L15 38L14 33z", 'stroke': "", 'strokeDashArray': ''});
		
		construc.push({'path': "M15 33L16 34L15 33z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M25 33L24 35L26 35L25 33z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M26 33L27 34L26 33M29 33L29 34L29 37L29 38C31.6816 36.2278 31.6816 34.7722 29 33z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M33 33L34 34L33 33z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M34 33L34 38L35 38L34 33z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M35 33L36 34L35 33z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M9 34L9 37L11 37L11 34L9 34z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M14 34L14 37L15 37L14 34z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M19 34L19 38L20 38L22 35L19 34z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M28 34L27 37L28 34z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M29 34L29 37L31 37L31 34L29 34z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M34 34L34 37L35 37L34 34z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M6 35L7 36L6 35z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M20.3333 35.6667L20.6667 36.3333L20.3333 35.6667M24 35L27 38L27 37C25.0399 36.3466 24.446 36 27 36L24 35z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M5 36L6 37L5 36z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M25.6667 36.3333L26.3333 36.6667L25.6667 36.3333z", 'stroke': "", 'strokeDashArray': ''});
		
		construc.push({'path': "M6 37L7 38L6 37z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M13 37L14 38L13 37M15 37L16 38L15 37z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M21 37L22 38L21 37z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M27.6667 37.3333L28.3333 37.6667L27.6667 37.3333z", 'stroke': "", 'strokeDashArray': ''});
		construc.push({'path': "M33 37L34 38L33 37M35 37L36 38L35 37z", 'stroke': "", 'strokeDashArray': ''});
		*/
		
		construc.push({'path': "M0 0L0 41L41 41L41 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		construc.push({'path': "M1 1L1 40L40 40L40 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
      construc.params.width = 15;
      construc.params.height = 15;
      construc.params.rotate = true;
	 
	}
	if (typeObj == 'bajo2')
	{

      construc.push({'path': "M0 0L0 41L30 41L30 0L0 0z ", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		
	  construc.push({'path': "M2 2L2 39L28 39L28 2L2 2z ", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
	  construc.params.width = 15;
      construc.params.height = 15;
      construc.params.rotate = true;
		
      //construc.family = 'stick';
	
	}
	if (typeObj == 'bajo3')
	{

      construc.push({'path': "M0 0L0 41L30 41L30 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		
	  construc.push({'path': "M1 1L1 40L29 40L29 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
		

      construc.params.width = 30;
      construc.params.height = 41;
      construc.params.rotate = true;
	
	}  
	if (typeObj == 'bajo4')
	{

      construc.push({'path': "M0 0L0 41L27 41L27 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		
	  construc.push({'path': "M1 1L1 40L26 40L26 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
		

      construc.params.width = 15;
      construc.params.height = 15;
      construc.params.rotate = true;
	
	} 
	if (typeObj == 'bajo5')
	{

      construc.push({'path': "M0 0L0 41L20 41L20 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		
	  construc.push({'path': "M1 1L1 40L19 40L19 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
		

      construc.params.width = 15;
      construc.params.height = 15;
      construc.params.rotate = true;
	
	} 
	if (typeObj == 'bajo6')
	{

      construc.push({'path': "M0 0L0 41L14 41L14 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		
	  construc.push({'path': "M1 1L1 40L13 40L13 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
		
	  construc.params.width = 15;
      construc.params.height = 15;
      /*construc.params.width = 30;
      construc.params.height = 41;*/
      construc.params.rotate = true;
	
	} 	 
	  
	if (typeObj == 'alto1')
	{
		//376 * 600
		construc.push({'path': "M0 0L0 27L41 27L41 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		construc.push({'path': "M1 1L1 26L40 26L40 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
      construc.params.width = 15;
      construc.params.height = 15;
      construc.params.rotate = true;
	
	}    
	
	if (typeObj == 'alto2')
	{
		//376 * 500
		construc.push({'path': "M0 0L0 27L34 27L34 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		construc.push({'path': "M1 1L1 26L33 26L33 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
      construc.params.width = 15;
      construc.params.height = 15;
      construc.params.rotate = true;
	
	}  
	  
	if (typeObj == 'alto3')
	{
		//376 * 400
		construc.push({'path': "M0 0L0 27L27 27L27 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		construc.push({'path': "M1 1L1 26L26 26L26 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
      construc.params.width = 15;
      construc.params.height = 15;
      construc.params.rotate = true;
	
	}    
	if (typeObj == 'alto4')
	{
		//376 * 300
		construc.push({'path': "M0 0L0 27L21 27L21 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		construc.push({'path': "M1 1L1 26L20 26L20 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
      construc.params.width = 15;
      construc.params.height = 15;
      construc.params.rotate = true;
	
	}    
	if (typeObj == 'alto5')
	{
		//376 * 200
		construc.push({'path': "M0 0L0 27L14 27L14 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		construc.push({'path': "M1 1L1 26L13 26L13 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
      construc.params.width = 15;
      construc.params.height = 15;
      construc.params.rotate = true;
	
	} 
	  
	  
	if (typeObj == 'horno1')
	{

		construc.push({'path': "M 76.25 2.5 L 3.75 2.5 C 3.058594 2.5 2.5 3.058594 2.5 3.75 L 2.5 76.25 C 2.5 76.941406 3.058594 77.5 3.75 77.5 L 76.25 77.5 C 76.941406 77.5 77.5 76.941406 77.5 76.25 L 77.5 3.75 C 77.5 3.058594 76.941406 2.5 76.25 2.5 Z M 75 75 L 5 75 L 5 20 L 75 20 Z M 75 17.5 L 5 17.5 L 5 5 L 75 5 Z M 75 17.5", 'stroke': "", 'strokeDashArray': ''});
		
      construc.push({'path': "M 30 15 L 50 15 C 50.691406 15 51.25 14.441406 51.25 13.75 L 51.25 8.75 C 51.25 8.058594 50.691406 7.5 50 7.5 L 30 7.5 C 29.308594 7.5 28.75 8.058594 28.75 8.75 L 28.75 13.75 C 28.75 14.441406 29.308594 15 30 15 Z M 31.25 10 L 48.75 10 L 48.75 12.5 L 31.25 12.5 Z M 31.25 10 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 12.5 15 C 14.570312 15 16.25 13.320312 16.25 11.25 C 16.25 9.179688 14.570312 7.5 12.5 7.5 C 10.429688 7.5 8.75 9.179688 8.75 11.25 C 8.753906 13.320312 10.429688 14.996094 12.5 15 Z M 12.5 10 C 13.191406 10 13.75 10.558594 13.75 11.25 C 13.75 11.941406 13.191406 12.5 12.5 12.5 C 11.808594 12.5 11.25 11.941406 11.25 11.25 C 11.25 10.558594 11.808594 10 12.5 10 Z M 12.5 10 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 22.5 15 C 24.570312 15 26.25 13.320312 26.25 11.25 C 26.25 9.179688 24.570312 7.5 22.5 7.5 C 20.429688 7.5 18.75 9.179688 18.75 11.25 C 18.753906 13.320312 20.429688 14.996094 22.5 15 Z M 22.5 10 C 23.191406 10 23.75 10.558594 23.75 11.25 C 23.75 11.941406 23.191406 12.5 22.5 12.5 C 21.808594 12.5 21.25 11.941406 21.25 11.25 C 21.25 10.558594 21.808594 10 22.5 10 Z M 22.5 10 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 57.5 15 C 59.570312 15 61.25 13.320312 61.25 11.25 C 61.25 9.179688 59.570312 7.5 57.5 7.5 C 55.429688 7.5 53.75 9.179688 53.75 11.25 C 53.753906 13.320312 55.429688 14.996094 57.5 15 Z M 57.5 10 C 58.191406 10 58.75 10.558594 58.75 11.25 C 58.75 11.941406 58.191406 12.5 57.5 12.5 C 56.808594 12.5 56.25 11.941406 56.25 11.25 C 56.25 10.558594 56.808594 10 57.5 10 Z M 57.5 10 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 67.5 15 C 69.570312 15 71.25 13.320312 71.25 11.25 C 71.25 9.179688 69.570312 7.5 67.5 7.5 C 65.429688 7.5 63.75 9.179688 63.75 11.25 C 63.753906 13.320312 65.429688 14.996094 67.5 15 Z M 67.5 10 C 68.191406 10 68.75 10.558594 68.75 11.25 C 68.75 11.941406 68.191406 12.5 67.5 12.5 C 66.808594 12.5 66.25 11.941406 66.25 11.25 C 66.25 10.558594 66.808594 10 67.5 10 Z M 67.5 10", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 66.25 32.5 L 13.75 32.5 C 13.058594 32.5 12.5 33.058594 12.5 33.75 L 12.5 66.25 C 12.5 66.941406 13.058594 67.5 13.75 67.5 L 66.25 67.5 C 66.941406 67.5 67.5 66.941406 67.5 66.25 L 67.5 33.75 C 67.5 33.058594 66.941406 32.5 66.25 32.5 Z M 65 65 L 15 65 L 15 35 L 65 35 Z M 65 65", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 18.75 62.5 L 61.25 62.5 C 61.941406 62.5 62.5 61.941406 62.5 61.25 C 62.5 60.558594 61.941406 60 61.25 60 L 18.75 60 C 18.058594 60 17.5 60.558594 17.5 61.25 C 17.5 61.941406 18.058594 62.5 18.75 62.5 Z M 18.75 62.5 ", 'stroke': "", 'strokeDashArray': ''});
	  construc.push({'path': "M 10 25 L 70 25 C 70.691406 25 71.25 24.441406 71.25 23.75 C 71.25 23.058594 70.691406 22.5 70 22.5 L 10 22.5 C 9.308594 22.5 8.75 23.058594 8.75 23.75 C 8.75 24.441406 9.308594 25 10 25 Z M 10 25 ", 'stroke': "", 'strokeDashArray': ''});
		
      construc.params.width = 80;
      construc.params.height = 80;
      construc.params.rotate = true;
	
	}   
	 
	if (typeObj == 'horno2')
	{

		construc.push({'path': "M 78.828125 18.75 C 79.476562 18.75 80 18.226562 80 17.578125 L 80 1.171875 C 80 0.523438 79.476562 0 78.828125 0 L 1.171875 0 C 0.523438 0 0 0.523438 0 1.171875 L 0 17.578125 C 0 18.226562 0.523438 18.75 1.171875 18.75 L 2.34375 18.75 L 2.34375 21.09375 L 1.171875 21.09375 C 0.523438 21.09375 0 21.617188 0 22.265625 L 0 74.140625 C 0 74.789062 0.523438 75.3125 1.171875 75.3125 L 4.6875 75.3125 L 4.6875 78.828125 C 4.6875 79.476562 5.210938 80 5.859375 80 L 10.546875 80 C 11.195312 80 11.71875 79.476562 11.71875 78.828125 L 11.71875 75.3125 L 68.28125 75.3125 L 68.28125 78.828125 C 68.28125 79.476562 68.804688 80 69.453125 80 L 74.140625 80 C 74.789062 80 75.3125 79.476562 75.3125 78.828125 L 75.3125 75.3125 L 78.828125 75.3125 C 79.476562 75.3125 80 74.789062 80 74.140625 L 80 22.265625 C 80 21.617188 79.476562 21.09375 78.828125 21.09375 L 77.65625 21.09375 L 77.65625 18.75 Z M 2.34375 2.34375 L 77.65625 2.34375 L 77.65625 16.40625 L 2.34375 16.40625 Z M 77.65625 23.4375 L 77.65625 63.59375 L 2.34375 63.59375 L 2.34375 23.4375 Z M 9.375 77.65625 L 7.03125 77.65625 L 7.03125 75.3125 L 9.375 75.3125 Z M 72.96875 77.65625 L 70.625 77.65625 L 70.625 75.3125 L 72.96875 75.3125 Z M 2.34375 72.96875 L 2.34375 65.9375 L 77.65625 65.9375 L 77.65625 72.96875 Z M 75.3125 21.09375 L 4.6875 21.09375 L 4.6875 18.75 L 75.3125 18.75 Z M 75.3125 21.09375 ", 'stroke': "", 'strokeDashArray': ''});
		
      construc.push({'path': "M 58.90625 14.0625 C 61.492188 14.0625 63.59375 11.960938 63.59375 9.375 C 63.59375 6.789062 61.492188 4.6875 58.90625 4.6875 C 56.320312 4.6875 54.21875 6.789062 54.21875 9.375 C 54.21875 11.960938 56.320312 14.0625 58.90625 14.0625 Z M 58.90625 7.03125 C 60.199219 7.03125 61.25 8.082031 61.25 9.375 C 61.25 10.667969 60.199219 11.71875 58.90625 11.71875 C 57.613281 11.71875 56.5625 10.667969 56.5625 9.375 C 56.5625 8.082031 57.613281 7.03125 58.90625 7.03125 Z M 58.90625 7.03125 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 21.09375 14.0625 C 23.679688 14.0625 25.78125 11.960938 25.78125 9.375 C 25.78125 6.789062 23.679688 4.6875 21.09375 4.6875 C 18.507812 4.6875 16.40625 6.789062 16.40625 9.375 C 16.40625 11.960938 18.507812 14.0625 21.09375 14.0625 Z M 21.09375 7.03125 C 22.386719 7.03125 23.4375 8.082031 23.4375 9.375 C 23.4375 10.667969 22.386719 11.71875 21.09375 11.71875 C 19.800781 11.71875 18.75 10.667969 18.75 9.375 C 18.75 8.082031 19.800781 7.03125 21.09375 7.03125 Z M 21.09375 7.03125 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 10.546875 61.25 L 69.453125 61.25 C 70.101562 61.25 70.625 60.726562 70.625 60.078125 L 70.625 36.328125 C 70.625 35.679688 70.101562 35.15625 69.453125 35.15625 L 10.546875 35.15625 C 9.898438 35.15625 9.375 35.679688 9.375 36.328125 L 9.375 45.859375 C 9.375 46.507812 9.898438 47.03125 10.546875 47.03125 C 11.195312 47.03125 11.71875 46.507812 11.71875 45.859375 L 11.71875 37.5 L 68.28125 37.5 L 68.28125 58.90625 L 11.71875 58.90625 L 11.71875 50.546875 C 11.71875 49.898438 11.195312 49.375 10.546875 49.375 C 9.898438 49.375 9.375 49.898438 9.375 50.546875 L 9.375 60.078125 C 9.375 60.726562 9.898438 61.25 10.546875 61.25 Z M 10.546875 61.25 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 12.890625 32.8125 L 67.109375 32.8125 C 69.046875 32.8125 70.625 31.234375 70.625 29.296875 C 70.625 27.359375 69.046875 25.78125 67.109375 25.78125 L 12.890625 25.78125 C 10.953125 25.78125 9.375 27.359375 9.375 29.296875 C 9.375 31.234375 10.953125 32.8125 12.890625 32.8125 Z M 12.890625 28.125 L 67.109375 28.125 C 67.753906 28.125 68.28125 28.652344 68.28125 29.296875 C 68.28125 29.941406 67.753906 30.46875 67.109375 30.46875 L 12.890625 30.46875 C 12.246094 30.46875 11.71875 29.941406 11.71875 29.296875 C 11.71875 28.652344 12.246094 28.125 12.890625 28.125 Z M 12.890625 28.125 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 29.296875 14.0625 L 50.703125 14.0625 C 51.351562 14.0625 51.875 13.539062 51.875 12.890625 L 51.875 5.859375 C 51.875 5.210938 51.351562 4.6875 50.703125 4.6875 L 29.296875 4.6875 C 28.648438 4.6875 28.125 5.210938 28.125 5.859375 L 28.125 12.890625 C 28.125 13.539062 28.648438 14.0625 29.296875 14.0625 Z M 30.46875 7.03125 L 49.53125 7.03125 L 49.53125 11.71875 L 30.46875 11.71875 Z M 30.46875 7.03125 ", 'stroke': "", 'strokeDashArray': ''});
		
	  
      construc.params.width = 80;
      construc.params.height = 80;
      construc.params.rotate = true;
	
	}   
	 
	if (typeObj == 'horno3')
	{

		construc.push({'path': "M 15.707031 28.804688 L 64.207031 28.804688 C 65.230469 28.804688 65.972656 27.96875 65.972656 27.039062 C 65.972656 26.109375 65.136719 25.273438 64.207031 25.273438 L 15.707031 25.273438 C 14.683594 25.273438 13.941406 26.109375 13.941406 27.039062 C 13.941406 27.96875 14.777344 28.804688 15.707031 28.804688 Z M 15.707031 28.804688 ", 'stroke': "", 'strokeDashArray': ''});
		
      construc.push({'path': "M 74.523438 0 L 5.488281 0 C 4.648438 0 4.09375 0.652344 4.09375 1.394531 L 4.09375 78.605469 C 4 79.347656 4.648438 80 5.488281 80 L 74.523438 80 C 75.359375 80 75.917969 79.347656 75.917969 78.605469 L 75.917969 1.394531 C 75.917969 0.558594 75.265625 0 74.523438 0 Z M 73.035156 77.210938 L 6.878906 77.210938 L 6.878906 18.398438 L 73.035156 18.398438 Z M 73.035156 15.515625 L 6.878906 15.515625 L 6.878906 2.789062 L 73.035156 2.789062 Z M 73.035156 15.515625 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 60.585938 35.308594 L 19.609375 35.308594 C 18.773438 35.308594 18.214844 35.957031 18.214844 36.703125 L 18.214844 64.113281 C 18.214844 64.949219 18.867188 65.503906 19.609375 65.503906 L 60.585938 65.503906 C 61.421875 65.503906 61.980469 64.855469 61.980469 64.113281 L 61.980469 36.703125 C 62.070312 35.957031 61.421875 35.308594 60.585938 35.308594 Z M 59.191406 62.71875 L 21.003906 62.71875 L 21.003906 60.765625 L 59.191406 60.765625 Z M 59.191406 57.980469 L 21.003906 57.980469 L 21.003906 38.1875 L 59.191406 38.1875 Z M 59.191406 57.980469 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 30.851562 10.59375 C 30.851562 11.773438 29.894531 12.730469 28.714844 12.730469 C 27.535156 12.730469 26.578125 11.773438 26.578125 10.59375 C 26.578125 9.410156 27.535156 8.457031 28.714844 8.457031 C 29.894531 8.457031 30.851562 9.410156 30.851562 10.59375 Z M 30.851562 10.59375 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 38.101562 10.59375 C 38.101562 11.773438 37.144531 12.730469 35.960938 12.730469 C 34.78125 12.730469 33.824219 11.773438 33.824219 10.59375 C 33.824219 9.410156 34.78125 8.457031 35.960938 8.457031 C 37.144531 8.457031 38.101562 9.410156 38.101562 10.59375 Z M 38.101562 10.59375 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 45.347656 10.59375 C 45.347656 11.773438 44.390625 12.730469 43.210938 12.730469 C 42.03125 12.730469 41.074219 11.773438 41.074219 10.59375 C 41.074219 9.410156 42.03125 8.457031 43.210938 8.457031 C 44.390625 8.457031 45.347656 9.410156 45.347656 10.59375 Z M 45.347656 10.59375 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 52.59375 10.59375 C 52.59375 11.773438 51.636719 12.730469 50.457031 12.730469 C 49.277344 12.730469 48.320312 11.773438 48.320312 10.59375 C 48.320312 9.410156 49.277344 8.457031 50.457031 8.457031 C 51.636719 8.457031 52.59375 9.410156 52.59375 10.59375 Z M 52.59375 10.59375 ", 'stroke': "", 'strokeDashArray': ''});	
	  
      construc.params.width = 80;
      construc.params.height = 80;
      construc.params.rotate = true;
	
	}    
	
	if (typeObj =='placa1')
	{

		construc.push({'path': "M 77.648438 76.375 L 2.351562 76.375 C 1.054688 76.375 0 75.324219 0 74.023438 L 0 5.976562 C 0 4.675781 1.054688 3.625 2.351562 3.625 L 77.648438 3.625 C 78.945312 3.625 80 4.675781 80 5.976562 L 80 74.023438 C 80 75.324219 78.945312 76.375 77.648438 76.375 Z M 4.707031 71.671875 L 75.292969 71.671875 L 75.292969 8.328125 L 4.707031 8.328125 Z M 4.707031 71.671875", 'stroke': "", 'strokeDashArray': ''});
		
      construc.push({'path': "M 26.09375 47.707031 C 15.714844 47.707031 7.269531 39.261719 7.269531 28.882812 C 7.269531 18.503906 15.714844 10.058594 26.09375 10.058594 C 36.472656 10.058594 44.917969 18.503906 44.917969 28.882812 C 44.917969 39.261719 36.472656 47.707031 26.09375 47.707031 Z M 26.09375 14.765625 C 18.308594 14.765625 11.976562 21.097656 11.976562 28.882812 C 11.976562 36.667969 18.308594 43 26.09375 43 C 33.878906 43 40.210938 36.667969 40.210938 28.882812 C 40.210938 21.097656 33.878906 14.765625 26.09375 14.765625 Z M 26.09375 14.765625 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 26.09375 41.0625 C 19.378906 41.0625 13.914062 35.597656 13.914062 28.882812 C 13.914062 22.167969 19.378906 16.703125 26.09375 16.703125 C 32.808594 16.703125 38.273438 22.167969 38.273438 28.882812 C 38.273438 35.597656 32.808594 41.0625 26.09375 41.0625 Z M 26.09375 21.410156 C 21.972656 21.410156 18.621094 24.761719 18.621094 28.882812 C 18.621094 33.003906 21.972656 36.355469 26.09375 36.355469 C 30.214844 36.355469 33.570312 33.003906 33.570312 28.882812 C 33.570312 24.761719 30.214844 21.410156 26.09375 21.410156 Z M 26.09375 21.410156 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 60.425781 34.421875 C 53.707031 34.421875 48.246094 28.957031 48.246094 22.238281 C 48.246094 15.523438 53.707031 10.058594 60.425781 10.058594 C 67.140625 10.058594 72.605469 15.523438 72.605469 22.238281 C 72.605469 28.957031 67.140625 34.421875 60.425781 34.421875 Z M 60.425781 14.765625 C 56.304688 14.765625 52.949219 18.117188 52.949219 22.238281 C 52.949219 26.359375 56.304688 29.714844 60.425781 29.714844 C 64.546875 29.714844 67.898438 26.359375 67.898438 22.238281 C 67.898438 18.117188 64.546875 14.765625 60.425781 14.765625 Z M 60.425781 14.765625 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 57.230469 70.527344 C 48.753906 70.527344 41.859375 63.632812 41.859375 55.15625 C 41.859375 46.679688 48.753906 39.785156 57.230469 39.785156 C 65.707031 39.785156 72.605469 46.679688 72.605469 55.15625 C 72.605469 63.632812 65.707031 70.527344 57.230469 70.527344 Z M 57.230469 44.488281 C 51.351562 44.488281 46.566406 49.273438 46.566406 55.15625 C 46.566406 61.039062 51.351562 65.824219 57.230469 65.824219 C 63.113281 65.824219 67.898438 61.039062 67.898438 55.15625 C 67.898438 49.273438 63.113281 44.488281 57.230469 44.488281 Z M 57.230469 44.488281 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 57.230469 64.171875 C 52.261719 64.171875 48.214844 60.128906 48.214844 55.15625 C 48.214844 50.183594 52.261719 46.140625 57.230469 46.140625 C 62.203125 46.140625 66.25 50.183594 66.25 55.15625 C 66.25 60.128906 62.203125 64.171875 57.230469 64.171875 Z M 57.230469 50.847656 C 54.855469 50.847656 52.921875 52.78125 52.921875 55.15625 C 52.921875 57.53125 54.855469 59.464844 57.230469 59.464844 C 59.609375 59.464844 61.542969 57.53125 61.542969 55.15625 C 61.542969 52.78125 59.609375 50.847656 57.230469 50.847656 Z M 57.230469 50.847656 ", 'stroke': "", 'strokeDashArray': ''});
		
	  construc.push({'path': "M 14.066406 67.496094 L 11.191406 67.496094 C 9.894531 67.496094 8.839844 66.441406 8.839844 65.144531 C 8.839844 63.84375 9.894531 62.789062 11.191406 62.789062 L 14.066406 62.789062 C 15.363281 62.789062 16.417969 63.84375 16.417969 65.144531 C 16.417969 66.441406 15.363281 67.496094 14.066406 67.496094 Z M 14.066406 67.496094 ", 'stroke': "", 'strokeDashArray': ''});	
	  
		
		construc.push({'path': "M 20.808594 67.496094 L 20.605469 67.496094 C 19.304688 67.496094 18.25 66.441406 18.25 65.144531 C 18.25 63.84375 19.304688 62.789062 20.605469 62.789062 L 20.808594 62.789062 C 22.109375 62.789062 23.164062 63.84375 23.164062 65.144531 C 23.164062 66.441406 22.109375 67.496094 20.808594 67.496094 Z M 20.808594 67.496094 ", 'stroke': "", 'strokeDashArray': ''});	
		construc.push({'path': "M 28.078125 67.496094 L 27.871094 67.496094 C 26.574219 67.496094 25.519531 66.441406 25.519531 65.144531 C 25.519531 63.84375 26.574219 62.789062 27.871094 62.789062 L 28.078125 62.789062 C 29.378906 62.789062 30.429688 63.84375 30.429688 65.144531 C 30.429688 66.441406 29.378906 67.496094 28.078125 67.496094 Z M 28.078125 67.496094 ", 'stroke': "", 'strokeDashArray': ''});	
		construc.push({'path': "M 35.347656 67.496094 L 35.140625 67.496094 C 33.839844 67.496094 32.785156 66.441406 32.785156 65.144531 C 32.785156 63.84375 33.839844 62.789062 35.140625 62.789062 L 35.347656 62.789062 C 36.644531 62.789062 37.699219 63.84375 37.699219 65.144531 C 37.699219 66.441406 36.644531 67.496094 35.347656 67.496094 Z M 35.347656 67.496094 ", 'stroke': "", 'strokeDashArray': ''});	
	
      construc.params.width = 80;
      construc.params.height = 80;
      construc.params.rotate = true;
	
	}   
	  
    if (typeObj == 'switch') {
      construc.push({'path': qSVG.circlePath(0, 0, 16), 'fill': "#fff", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': qSVG.circlePath(-2, 4, 5), 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m 0,0 5,-9", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.params.width = 36;
      construc.params.height = 36;
      construc.family = 'stick';

    }
    if (typeObj == 'doubleSwitch') {
      construc.push({'path': qSVG.circlePath(0, 0, 16), 'fill': "#fff", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': qSVG.circlePath(0,0, 4), 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m 2,-3 5,-8 3,2", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m -2,3 -5,8 -3,-2", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.params.width = 36;
      construc.params.height = 36;
      construc.family = 'stick';
    }
    if (typeObj == 'dimmer') {
      construc.push({'path': qSVG.circlePath(0, 0, 16), 'fill': "#fff", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': qSVG.circlePath(-2, 4, 5), 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m 0,0 5,-9", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "M -2,-6 L 10,-4 L-2,-2 Z", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.params.width = 36;
      construc.params.height = 36;
      construc.family = 'stick';
    }
    if (typeObj == 'plug') {
      construc.push({'path':qSVG.circlePath(0, 0, 16), 'fill': "#fff", 'stroke': "#000", 'strokeDashArray': ''});
      construc.push({'path': "M 10,-6 a 10,10 0 0 1 -5,8 10,10 0 0 1 -10,0 10,10 0 0 1 -5,-8", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m 0,3 v 7", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m -10,4 h 20", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.params.width = 36;
      construc.params.height = 36;
      construc.family = 'stick';
    }
    if (typeObj == 'plug20') {
      construc.push({'path':qSVG.circlePath(0, 0, 16), 'fill': "#fff", 'stroke': "#000", 'strokeDashArray': ''});
      construc.push({'path': "M 10,-6 a 10,10 0 0 1 -5,8 10,10 0 0 1 -10,0 10,10 0 0 1 -5,-8", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m 0,3 v 7", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m -10,4 h 20", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'text': "20A", 'x': '0', 'y':'-5', 'fill': "#333333", 'stroke': "none", 'fontSize': '0.65em',"strokeWidth": "0.4px"});
      construc.params.width = 36;
      construc.params.height = 36;
      construc.family = 'stick';
    }
    if (typeObj == 'plug32') {
      construc.push({'path':qSVG.circlePath(0, 0, 16), 'fill': "#fff", 'stroke': "#000", 'strokeDashArray': ''});
      construc.push({'path': "M 10,-6 a 10,10 0 0 1 -5,8 10,10 0 0 1 -10,0 10,10 0 0 1 -5,-8", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m 0,3 v 7", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m -10,4 h 20", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'text': "32A", 'x': '0', 'y':'-5', 'fill': "#333333", 'stroke': "none", 'fontSize': '0.65em',"strokeWidth": "0.4px"});
      construc.params.width = 36;
      construc.params.height = 36;
      construc.family = 'stick';
    }
    if (typeObj == 'roofLight') {
      construc.push({'path':qSVG.circlePath(0, 0, 16), 'fill': "#fff", 'stroke': "#000", 'strokeDashArray': ''});
      construc.push({'path': "M -8,-8 L 8,8 M -8,8 L 8,-8", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.params.width = 36;
      construc.params.height = 36;
      construc.family = 'free';
    }
    if (typeObj == 'wallLight') {
      construc.push({'path':qSVG.circlePath(0, 0, 16), 'fill': "#fff", 'stroke': "#000", 'strokeDashArray': ''});
      construc.push({'path': "M -8,-8 L 8,8 M -8,8 L 8,-8", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "M -10,10 L 10,10", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.params.width = 36;
      construc.params.height = 36;
      construc.family = 'stick';
    }
    if (typeObj == 'www') {
      construc.push({'path': "m -20,-20 l 40,0 l0,40 l-40,0 Z", 'fill': "#fff", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'text': "@", 'x': '0', 'y':'4', 'fill': "#333333", 'stroke': "none", 'fontSize': '1.2em',"strokeWidth": "0.4px"});
      construc.params.width = 40;
      construc.params.height = 40;
      construc.family = 'free';
    }
    if (typeObj == 'rj45') {
      construc.push({'path':qSVG.circlePath(0, 0, 16), 'fill': "#fff", 'stroke': "#000", 'strokeDashArray': ''});
      construc.push({'path': "m-10,5 l0,-10 m20,0 l0,10", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m 0,5 v 7", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m -10,5 h 20", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'text': "RJ45", 'x': '0', 'y':'-5', 'fill': "#333333", 'stroke': "none", 'fontSize': '0.5em',"strokeWidth": "0.4px"});
      construc.params.width = 36;
      construc.params.height = 36;
      construc.family = 'stick';
    }
    if (typeObj == 'tv') {
      construc.push({'path':qSVG.circlePath(0, 0, 16), 'fill': "#fff", 'stroke': "#000", 'strokeDashArray': ''});
      construc.push({'path': "m-10,5 l0-10 m20,0 l0,10", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m-7,-5 l0,7 l14,0 l0,-7", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m 0,5 v 7", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m -10,5 h 20", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'text': "TV", 'x': '0', 'y':'-5', 'fill': "#333333", 'stroke': "none", 'fontSize': '0.5em',"strokeWidth": "0.4px"});
      construc.params.width = 36;
      construc.params.height = 36;
      construc.family = 'stick';
    }

    if (typeObj == 'heater') {
      construc.push({'path':qSVG.circlePath(0, 0, 16), 'fill': "#fff", 'stroke': "#000", 'strokeDashArray': ''});
      construc.push({'path': "m-15,-4 l30,0", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m-14,-8 l28,0", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m-11,-12 l22,0", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m-16,0 l32,0", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m-15,4 l30,0", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m-14,8 l28,0", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "m-11,12 l22,0", 'fill': "none", 'stroke': "#333", 'strokeDashArray': ''});
      construc.params.width = 36;
      construc.params.height = 36;
      construc.family = 'stick';
    }
    if (typeObj == 'radiator') {
      construc.push({'path': "m -20,-10 l 40,0 l0,20 l-40,0 Z", 'fill': "#fff", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "M -15,-10 L -15,10", 'fill': "#fff", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "M -10,-10 L -10,10", 'fill': "#fff", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "M -5,-10 L -5,10", 'fill': "#fff", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "M -0,-10 L -0,10", 'fill': "#fff", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "M 5,-10 L 5,10", 'fill': "#fff", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "M 10,-10 L 10,10", 'fill': "#fff", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'path': "M 15,-10 L 15,10", 'fill': "#fff", 'stroke': "#333", 'strokeDashArray': ''});
      construc.params.width = 40;
      construc.params.height = 20;
      construc.family = 'stick';

    }
  }

  if (classObj == 'furniture') {
    construc.params.bindBox = true;
    construc.params.move = true;
    construc.params.resize = true;
    construc.params.rotate = true;
  }

  return construc;
}

setTimeout(function(){ $("#mensaje_inicio").hide("slow");}, 7000);
