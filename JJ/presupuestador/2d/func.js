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
	console.log("Viewbox es: OriginX "+originX_viewbox+" / Origin Y: "+originY_viewbox+" / Width Viewbox" +width_viewbox+" / Height Viewbox: "+height_viewbox);
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
	console.log("This devuelve");
  console.log(this);
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
	var elemento_eliminado=binder.obj.type;
	console.log("Has eliminado el item "+elemento_eliminado);
	
	
  binder.obj.graph.remove();
  binder.graph.remove();
  OBJDATA.splice(OBJDATA.indexOf(binder.obj), 1);
  $('#objBoundingBox').hide(100);
  $('#panel').show(200);
  fonc_button('select_mode');
  $('#boxinfo').html('Objeto eliminado');
  delete binder;
  rib();
	
  if (elemento_eliminado == "horno" || elemento_eliminado == "vitro_induccion" || elemento_eliminado == "vitro_induccion" || elemento_eliminado == "placa_gas" || elemento_eliminado == "micro" || elemento_eliminado == "frigo" || elemento_eliminado == "lavavajillas" || elemento_eliminado == "lavadora" || elemento_eliminado == "secadora" || elemento_eliminado == "campana" || elemento_eliminado == "fregadero" || elemento_eliminado == "lavadero" || elemento_eliminado == "termo_electrico" || elemento_eliminado == "calentador_gas" || elemento_eliminado == "caldera_gas" || elemento_eliminado == "escobero" || elemento_eliminado == "frigo_americano" || elemento_eliminado == "gas_horno" || elemento_eliminado == "vitro_horno")
  {
    $("#"+elemento_eliminado+" + form + img").remove();
	$("#"+elemento_eliminado).trigger("click");
  }
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

//Para calcular el height de cada ventana se tiene en cuenta el valor "height min"
//Revisar engine.js 
document.getElementById('doorWindowHeight').addEventListener("input", function() {
  var sliderValue = this.value;
  var objTarget = binder.obj;
  console.log("OBJ Target!");
  console.log(objTarget);
  binder.obj.params.resizeLimit.height.min = sliderValue;
  alert("El alto de la ventana ahora va a ser de "+sliderValue);
});

document.getElementById('doorWindowWidth').addEventListener("input", function() {
  var sliderValue = this.value;
  var objTarget = binder.obj;
  console.log("OBJ Target!");
  console.log(objTarget);
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
  if (textToMake != "" && textToMake != "Tu observación") {
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
  document.getElementById('labelBox').textContent = "Tu observación";
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
		console.log("Viewbox1 es: OriginX "+originX_viewbox+" / Origin Y: "+originY_viewbox+" / Width Viewbox" +width_viewbox+" / Height Viewbox: "+height_viewbox);
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
		  
          $('#boxRib').append(sizeText[n]);  /*<<< COMENTO ESTA LÍNEA PARA QUE CUANDO ME PONGA ENCIMA DE UN MURO (PARA EDITARLO), NO ME MUESTRE LOS M2 INTERIORES Y EXTERIORES*/
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
      /*
	  ESTO RECALCULA DISTANCIAS HACIENDO INCORRECTO LOS CÁLCULOS DE LOS MUROS
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
		*/
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
		 // ribMaster[t][a][n-1].distance=0; 
		 // ribMaster[t][a][n].distance=0; 
			
			console.log("OJO! comparo distancias "+ribMaster[t][a][n-1].distance+" VS "+ribMaster[t][a][n].distance);
			
			if (ribMaster[t][a][n-1].distance == 0.02)
				ribMaster[t][a][n-1].distance=0;
			
			if (ribMaster[t][a][n].distance == 0.02)
				ribMaster[t][a][n].distance=0;
			
          var valueText = Math.abs(ribMaster[t][a][n-1].distance - ribMaster[t][a][n].distance);
			
			//valueText = 0;
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
			  alert("Found!");
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
			  console.log("SI! Found");
			  
			  //Hace la rotación del texto para que se pueda leer bien
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
			  
			  //alert(ribMaster[t][a][n-1].coords.y);
			  
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
			  console.log("Antes del none");
			  
			  if (ribMaster[t][a][n-1].side == "down") 
				sizeText[n].setAttributeNS(null, 'style', 'display:none;');  
			   
			  //console.log("El valor de wallWidth es "+$("#wallWidthScale").text());
			 
			  //contador_muro tiene el número de muro que es (1,2,3,4,5...)
              $('#boxRib').append(sizeText[n]); //<< comentar esto para que no se vean los m2 de cada pared
			   $('#listado_muros').append("<span class='info_muro'><span class='nombre_pared'>Pared "+letras_abecedario[contador_muro-1]+"</span> <span class='valor_pared'>"+valueText.toFixed(2)+" </span>m</span> "); 
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
  //Añadido para evitar errores cuando un muro está seleccionado
  if (typeof(binder) != 'undefined' && typeof binder !== 'undefined') {
      binder.remove();
      delete binder;
  }

    fonc_button('select_mode');
});

$('#select_mode').on('touchstart', function () {
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

$("line_mode").on('touchstart', function () {
    $('#lin').css('cursor', 'crosshair');
    $('#boxinfo').html('Creacia de muro(s)');
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

$(".door").on('touchstart', function () {
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


$('.window').on('touchstart', function () {
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

$('.object').on('touchstart', function () {
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
	  construc.params.resizeLimit.height = {min:1, max:10};	
    }
	  
	 if (typeObj == 'test') {
        construc.push({'path':"M "+(-sizeObj/2)+","+(-thickObj/2)+
            " L "+(sizeObj/2)+","+(-thickObj/2)+
            " L "+(sizeObj/2)+","+(thickObj/2)+
            " L "+(-sizeObj/2)+","+(+thickObj/2)+
        " Z", 'fill': "white", 'stroke': "white", 'strokeDashArray': 'none'});
        
        construc.push({'path':"M "+(-sizeObj/2)+","+(thickObj/2)+
            " L "+(-sizeObj/2)+","+(-thickObj/2)+
            " L "+(-sizeObj/2+5)+","+(-thickObj/2)+
            " L "+(-sizeObj/2+5)+","+(thickObj/2)+
        " Z", 'fill': "white", 'stroke': "#494646", 'strokeDashArray': 'none'});
        
        construc.push({'path':"M "+(-sizeObj/2+5)+","+(-thickObj/2)+
            " L "+(-sizeObj/2+5)+","+(-thickObj/2)+
            " L "+(sizeObj/2-5)+","+(-thickObj/2)+
            " L "+(sizeObj/2-5)+","+(-thickObj/2+5)+
            " L "+(-sizeObj/2+5)+","+(-thickObj/2+5)+
        " Z", 'fill': "#494646", 'stroke': "#494646", 'strokeDashArray': 'none'});
        
        construc.push({'path':"M "+(sizeObj/2)+","+(thickObj/2)+
           
            " L "+(sizeObj/2)+","+(-thickObj/2)+
            " L "+(sizeObj/2-5)+","+(-thickObj/2)+
            " L "+(sizeObj/2-5)+","+(thickObj/2)+
        " Z", 'fill': "white", 'stroke': "#494646", 'strokeDashArray': 'none'});
        
        construc.push({'path':"M "+(-sizeObj/2+5)+","+(thickObj/2)+
            " L "+(sizeObj/2-5)+","+(thickObj/2)+
        " Z", 'stroke': "black", 'strokeDashArray': '3,3,3,3'});
      
      construc.params.resize = true;
      construc.params.resizeLimit.width = {min:40, max:500};

    }
	
	  
	if (typeObj == "puerta-servicio")
	{
		
		construc.push({'path': "M10 210 l0 -200 990 0 990 0 -2 198 -3 197 -132 3 c-86 2 -133 -1 -133 -8 0 -5 14 -10 30 -10 l30 0 0 -125 0 -125 -780 0 -780 0 0 125 0 125 25 0 c14 0 25 5 25 10 0 6 -50 10 -130 10 l-130 0 0 -200z m190 -5 l0 -185 -85 0 -85 0 0 185 0 185 85 0 85 0 0 -185z m1770 0 l0 -185 -85 0 -85 0 0 185 0 185 85 0 85 0 0 -185z", 'fill': "#ccc",'stroke': "#494646", 'strokeDashArray': "5,5"});
		construc.push({'path': "M330 400 c0 -5 14 -10 30 -10 17 0 30 5 30 10 0 6 -13 10 -30 10 -16 0 -30 -4 -30 -10z", 'fill': "#ccc",'stroke': "#494646", 'strokeDashArray': "5,5"});
		construc.push({'path': "M450 400 c0 -5 11 -10 24 -10 14 0 28 5 31 10 4 6 -7 10 -24 10 -17 0 -31 -4 -31 -10z", 'fill': "#ccc",'stroke': "#494646", 'strokeDashArray': "5,5"});
		construc.push({'path': "M570 400 c0 -5 11 -10 25 -10 14 0 25 5 25 10 0 6 -11 10 -25 10 -14 0 -25 -4 -25 -10z", 'fill': "#ccc",'stroke': "#494646", 'strokeDashArray': "5,5"});
		construc.push({'path': "M680 400 c0 -5 14 -10 30 -10 17 0 30 5 30 10 0 6 -13 10 -30 10 -16 0 -30 -4 -30 -10z", 'fill': "#ccc",'stroke': "#494646", 'strokeDashArray': "5,5"});
		construc.push({'path': "M800 400 c0 -5 11 -10 25 -10 14 0 25 5 25 10 0 6 -11 10 -25 10 -14 0 -25 -4 -25 -10z", 'fill': "#ccc",'stroke': "#494646", 'strokeDashArray': "5,5"});
		construc.push({'path': "M910 400 c0 -5 14 -10 30 -10 17 0 30 5 30 10 0 6 -13 10 -30 10 -16 0 -30 -4 -30 -10z", 'fill': "#ccc",'stroke': "#494646", 'strokeDashArray': "5,5"});
		construc.push({'path': "M1030 400 c0 -5 11 -10 25 -10 14 0 25 5 25 10 0 6 -11 10 -25 10 -14 0 -25 -4 -25 -10z", 'fill': "#ccc",'stroke': "#494646", 'strokeDashArray': "5,5"});
		construc.push({'path': "M1140 400 c0 -5 14 -10 30 -10 17 0 30 5 30 10 0 6 -13 10 -30 10 -16 0 -30 -4 -30 -10z", 'fill': "#ccc",'stroke': "#494646", 'strokeDashArray': "5,5"});
		construc.push({'path': "M1260 400 c0 -5 11 -10 25 -10 14 0 25 5 25 10 0 6 -11 10 -25 10 -14 0 -25 -4 -25 -10z", 'fill': "#ccc",'stroke': "#494646", 'strokeDashArray': "5,5"});
		construc.push({'path': "M1375 400 c3 -5 17 -10 31 -10 13 0 24 5 24 10 0 6 -14 10 -31 10 -17 0 -28 -4 -24 -10z", 'fill': "#ccc",'stroke': "#494646", 'strokeDashArray': "5,5"});
		construc.push({'path': "M1490 400 c0 -5 11 -10 24 -10 14 0 28 5 31 10 4 6 -7 10 -24 10 -17 0 -31 -4 -31 -10z", 'fill': "#ccc",'stroke': "#494646", 'strokeDashArray': "5,5"});
		construc.push({'path': "M1610 400 c0 -5 11 -10 25 -10 14 0 25 5 25 10 0 6 -11 10 -25 10 -14 0 -25 -4 -25 -10z", 'fill': "#ccc",'stroke': "#494646", 'strokeDashArray': "5,5"});
		
		
		
      	construc.params.resize = true;
      	construc.params.resizeLimit.width = {min:40, max:500};
	  	construc.params.resizeLimit.height = {min:1, max:10};	
		
		
		
		
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
    construc.push({'path':"M"+(-sizeObj/2-10)+","+(-thickObj/2-10)+" L"+(sizeObj/2+10)+","+(-thickObj/2-10)+" L"+(sizeObj/2+10)+","+(thickObj/2+10)+" L"+(-sizeObj/2-10)+","+(thickObj/2+10)+" Z", 'fill':'none', 'stroke':"#aaa", 'strokeDashArray': 'boundingbox'});

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
		
		construc.push({'path': "m -20,-20 l 40,0 l0,40 l-40,0 Z", 'fill': "#fff", 'stroke': "#333", 'strokeDashArray': ''});
      construc.push({'text': "GTL", 'x': '0', 'y':'5', 'fill': "#333333", 'stroke': "none", 'fontSize': '0.9em',"strokeWidth": "0.4px"});
      construc.params.width = 40;
      construc.params.height = 40;
      construc.family = 'stick';
		
    } 
	  
	if (typeObj == 'puntos_electricos_extras')
	{
	
		construc.push({'path': "M0 0L0 25L25 25L25 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillrojo"});
		construc.push({'path': "M1 1L1 24L24 24L24 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		construc.push({'path': "M11 6L11 11L6 11L6 13L11 13L11 19L13 19L13 13L19 13L19 11L13 11L13 6L11 6z", 'stroke': "", 'strokeDashArray': typeObj+" fillrojo"});
		
      	construc.params.width = 15;
		construc.params.height = 15;
      	construc.params.rotate = true;
		
	}
	  
	if (typeObj == 'puntos_luz_techo')
	{
		
		construc.push({'path': "M0 0L0 25L25 25L25 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillrojo"});
		construc.push({'path': "M1 1L1 24L24 24L24 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		construc.push({'path': "M4 5L4 19L21 19L21 5L4 5z", 'stroke': "", 'strokeDashArray': typeObj+" fillrojo"});
		construc.push({'path': "M5 6L5 18L20 18L20 6L5 6z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
      	construc.params.width = 15;
		construc.params.height = 15;
      	construc.params.rotate = true;
		
		
		
	}
	  
	/*
	typeObj == 'bajo1' || typeObj == 'horno' || typeObj == 'vitro_induccion' || typeObj == 'placa_gas' || typeObj == 'micro' || typeObj == 'frigo' || typeObj == 'lavavajillas' || typeObj == 'lavadora' || typeObj == 'secadora' || typeObj == 'fregadero' || typeObj == 'termo_electrico' || typeObj == 'calentador_gas' || typeObj == 'caldera_gas'
	*/
	  
	 
	if (typeObj == 'placa_gas')
	{
		
	  construc.push({'path': "M0 0L0 380L379 380L379 94L379 24C379 19.1866 381.455 4.24219 377.397 1.02777C372.569 -2.79547 357.034 0 351 0L279 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
	  construc.push({'path': "M378 0L379 42L379 122L379 380L380 380L380 95L380 24C380 18.1667 382.556 3.98083 378 0M5 4L5 376L375 376L375 4L5 4z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
	  construc.push({'path': "M42 20.4398C10.478 25.515 19 68.1797 19 91L19 276L19 322C19 331.362 18.329 340.844 23.8503 348.999C37.9079 369.762 78.4345 362 100 362L257 362C281.713 362 310.837 366.215 335 360.985C367.665 353.916 361 317.571 361 292L361 103C361 82.4689 367.777 47.0121 354.097 30.0903C346.125 20.2281 334.583 20 323 20L276 20L120 20C94.8879 20 66.78 16.4501 42 20.4398z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
	  construc.push({'path': "M43 24.5178C14.0874 30.6862 23 73.2093 23 95L23 276L23 319C23 329.453 22.2499 339.036 28.7531 347.96C33.5628 354.559 41.404 356.223 49 357.41C66.6589 360.168 86.1321 358 104 358L260 358C284.183 358 313.567 362.497 337 356.073C364.876 348.432 357 308.971 357 287L357 104L357 59C357 50.5962 357.081 40.9492 351.606 34.0046C343.77 24.0641 332.499 24 321 24L275 24L118 24C94.4612 24 65.9986 19.6111 43 24.5178z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
	  construc.push({'path': "M100 32L100 54C74.8038 55.0986 53.5227 76.8118 53 102L30 102L30 112L53 112C54.984 136.931 75.602 155.755 100 159L100 182C113.813 181.989 110 169.886 110 159C129.092 154.511 142.299 146.41 152.819 129.424C155.596 124.94 155.132 117.217 158.738 113.603C166.95 105.375 179.986 119.773 180 102L158 102C155.961 76.384 135.513 56.0164 110 54C110 43.2343 113.562 32.0105 100 32M270 32L270 54C243.241 54.5524 224.261 76.7469 221 102C215.571 102 206.236 100.183 201.318 102.603C198.572 103.955 198.23 109.092 200.603 110.972C204.739 114.25 216.87 112 222 112C222.501 136.276 246.179 157.418 270 159L270 182L279 182L279 159C302.968 155.826 324.925 136.978 326 112C337.002 112 349.989 116.047 350 102L326 102C325.79 76.6046 304.36 55.1057 279 54L279 32L270 32z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
	  construc.push({'path': "M57 102L100 102L100 58C77.2378 59.8592 58.0002 79.0577 57 102M110 58L110 102L154 102C148.487 78.6158 134.851 61.2094 110 58M225 102L270 102L270 58C244.618 59.1067 230.526 79.5785 225 102M279 58L279 102L322 102C321.524 79.0866 301.485 59.8365 279 58M57 112C60.1901 135.691 77.4124 149.617 100 154L100 112L57 112M110 112L110 154C125.772 151.028 138.853 144.493 147.121 130C150.147 124.696 150.328 117.666 154 113C142.537 108.19 122.48 112 110 112M226 112C226.966 134.152 248.835 152.316 270 154L270 112L226 112M279 112L279 154C300.904 151.05 320.021 134.699 322 112L279 112z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
	  construc.push({'path': "M53 272L30 272L30 281L53 281C54.9438 305.425 75.0266 326.482 100 327C100 331.197 97.5709 359.517 108.397 350.972C112.567 347.681 110 331.994 110 327C134.656 326.796 154.951 304.612 158 281L180 281L180 272L158 272C157.648 254.941 145.905 236.618 130.996 228.313C125.9 225.475 115.378 225.201 111.603 221.397C106.911 216.669 114.827 199.815 104.054 201.167C95.3413 202.261 103.637 217.664 97.6821 221.836C91.8244 225.939 82.5691 226.3 76.0895 230.198C61.9316 238.715 53.0447 255.79 53 272M270 201L270 222C243.742 225.336 223.118 245.198 221 272L199 272L199 281C204.414 281 215.052 278.958 219.683 282.028C223.934 284.846 224.317 295.446 226.904 299.961C235.856 315.583 251.765 326.95 270 327C270 330.831 267.747 358.534 277.397 350.971C281.565 347.705 279 331.975 279 327C303.031 326.501 325.481 305.367 326 281L350 281L350 272C344.484 272 333.093 274.177 328.434 270.972C325.512 268.962 325.857 264.093 325.1 261C323.646 255.053 320.775 248.977 317.211 244C311.545 236.087 303.93 230.018 295 226.231C291.1 224.578 282.463 224.112 280.028 220.566C277.055 216.237 279 206.102 279 201L270 201z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
	  construc.push({'path': "M269 226C246.141 233.231 228.306 246.401 225 272L270 272C270 258.997 274.01 237.939 269 226M279 226L279 272L322 272C321.791 246.699 301.317 231.776 279 226M57 272L100 272L100 227C77.1624 227.486 57.4616 249.753 57 272M110 227L110 272L154 272C152.559 250.339 132.3 227.187 110 227M57 281C59.911 302.6 77.4697 322.018 100 323L100 281L57 281M110 281L110 323C125.664 322.666 139.291 312.428 146.687 299C149.611 293.69 150.344 286.641 154 282C142.537 277.19 122.48 281 110 281M226 281C226.944 302.648 248.729 322.559 270 323L270 281L226 281M279 281L279 323C300.825 322.048 320.234 302.621 322 281L279 281z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		
		
		
      construc.params.width = 35;
      construc.params.height = 35;
      construc.params.rotate = true;
		
	}
	  
	if (typeObj == 'termo_electrico')
	{
	  
	 
	  construc.push({'path': "M26 24L26 263L382 263L382 24L26 24z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
	  construc.push({'path': "M30 28L30 259L378 259L378 28L30 28z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
	  construc.push({'path': "M139 109C133.965 109.678 128.503 110.744 124 113.188C120.36 115.164 117.11 117.83 114.468 121.015C95.2695 144.163 123.428 159.761 123.4 182C123.38 197.041 95.9807 212.333 113.044 226.1C115.512 228.092 118.152 229.647 121 231C112.84 243.376 136.409 256.737 140 247L152 251L143 244L145 239L156 242L148 235L150 229C143.312 225.096 126.199 212.915 124 227C99.1585 215.196 126.82 200.681 126.821 182C126.822 161.321 101.946 145.159 117.684 125.015C119.744 122.377 122.206 120.095 125.001 118.249C129.214 115.466 134.204 114.361 139 113L139 179C139 187.373 136.618 200.15 140.009 207.91C144.196 217.49 157.604 217.492 164.671 223.638C170.025 228.295 169.026 236.674 171 243L243 243C244.964 236.705 244.058 229.013 249.109 224.214C256.515 217.177 269.665 217.469 274.146 206.999C278.439 196.969 276 182.698 276 172L276 98C276 87.685 279.123 71.1513 273.772 62.0008C268.001 52.1338 254.536 46.808 244 44.1273C220.578 38.1679 190.144 37.8256 167 45.0255C158.188 47.7667 147.217 52.4699 141.434 60.0401C138.183 64.2956 139 69.9612 139 75L139 109z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
	  construc.push({'path': "M202 43.4244C183.447 45.8604 158.553 46.2093 145.433 62.1844C141.485 66.9914 143 75.1877 143 81L143 127L143 182C143 189.038 141.095 199.417 143.858 205.981C147.422 214.45 160.303 214.611 166.907 219.649C173.358 224.571 170.089 235.286 175.318 238.682C179.508 241.404 187.235 240 192 240C205.927 240 221.201 241.781 234.985 239.811C243.477 238.597 240.195 226.798 245.479 221.329C251.569 215.028 262.554 215.452 268.15 208.701C276.926 198.112 272 171.957 272 159L272 95C272 86.5106 274.327 73.8809 270.91 66.0008C268.143 59.6187 261.046 55.3316 255 52.4892C240.09 45.4798 218.414 41.2692 202 43.4244z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
	  construc.push({'path': "M202 70.4645C180.135 74.4081 169.683 103.292 183.533 120.985C190.257 129.574 203.641 132.404 214 130.674C252.714 124.21 240.64 63.4953 202 70.4645z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
	  construc.push({'path': "M201 127L201 102L192 102L207 74C177.1 76.6104 171.497 118.485 201 127M212 74L212 99L221 99L206 127C210.363 127 214.899 127.402 219 125.633C246.01 113.977 234.757 81.42 212 74M122 239L136 247L145 231C131.3 224.604 127.187 222.84 122 239z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});	
		
		
		
      construc.params.width = 35;
      construc.params.height = 35;
      construc.params.rotate = true;
	}
	  
	if (typeObj == "caldera_gas")
	{
		
	  construc.push({'path': "M29 24L29 263L385 263L385 24L29 24z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
	  construc.push({'path': "M33 28L33 259L381 259L381 28L33 28z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
	  construc.push({'path': "M215 40.4244C195.453 42.9984 169.588 42.3398 156.109 60.0934C149.794 68.4102 153 85.0463 153 95L153 175C153 184.651 150.126 200.187 155.164 208.829C160.182 217.435 171.665 216.948 178.671 222.699C184.672 227.626 181.115 238.311 186.434 241.972C190.573 244.821 200.151 243 205 243C220.984 243 239.203 245.466 254.956 242.852C262.864 241.54 259.565 228.388 264.475 223.419C270.726 217.092 281.798 217.877 287.736 210.482C291.274 206.076 290.991 198.375 291 193L291 157L291 92C291 83.0573 292.961 70.24 288.821 62C285.765 55.9183 278.771 52.3409 273 49.3202C257.144 41.0203 232.702 38.0933 215 40.4244z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
	  construc.push({'path': "M216 43.4244C197.73 45.8303 171.847 46.7904 159.434 63.0401C155.576 68.0898 157 76.0184 157 82L157 126L157 179C157 187.096 155.376 197.295 158.264 204.995C161.665 214.061 174.28 213.715 180.981 219.278C186.865 224.162 185.29 235.416 190.318 238.682C194.508 241.404 202.234 240 207 240C220.942 240 236.194 241.758 249.995 239.811C258.87 238.559 255.953 226.678 261.189 221.055C267.214 214.585 277.71 215.127 283.57 208.725C293.044 198.377 288 170.998 288 158L288 94C288 85.2677 289.906 73.05 285.822 65.0008C282.809 59.0648 275.721 55.5698 270 52.7809C254.865 45.4031 232.803 41.2116 216 43.4244z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
	  construc.push({'path': "M216 70.5177C176.936 78.8671 190.574 138.194 230 130.66C269.425 123.126 254.331 62.325 216 70.5177z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
	  construc.push({'path': "M216 127L216 126C198.765 120.136 207.949 101.681 213.691 91C215.27 88.0617 216.717 80.5241 220.228 79.4468C224.923 78.0058 231.937 85.7472 234.25 89.0039C243.845 102.512 243.578 113.275 234 126C242.722 120.544 249.659 111.776 249.659 101C249.659 83.4557 231.666 70.0038 215 75.2207C191.414 82.6033 189.728 122.242 216 127M227 101C226.602 105.523 224.545 114.006 219 109C215.716 115.824 218.47 120.228 220 127L227 127C229.611 116.849 234.955 111.488 229 101L227 101M231 126L232 127L231 126z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});	
		
		
		
      construc.params.width = 35;
      construc.params.height = 35;
      construc.params.rotate = true;
		
	}
	  
	if (typeObj == "campana")
	{
		
	
	   construc.push({'path': "M0 0L0 239L357 239L357 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
	   construc.push({'path': "M4 4L4 230L29 200L83.439 131L106.4 102.09L120.436 84L121 59L121 4L4 4M125 4L125 83L233 83L233 4L125 4M237 4L237 60L237.738 86L250.35 102.09L274 132.015L352 231L353 231L353 4L237 4M7 235L350 235C342.889 222.779 332.98 213.123 324.428 202C305.02 176.756 284.939 152.057 265.211 127C257.421 117.107 249.792 107.107 241.404 97.7145C238.73 94.7216 236.616 89.2184 232.812 87.6034C226.308 84.8424 215.019 87 208 87L151 87C143.777 87 130.58 84.4669 124.171 88.0278C111.483 95.0762 103.032 114.042 93.7855 124.83C74.6094 147.204 56.8081 170.881 38.5965 194C28.1154 207.305 14.7447 219.829 7 235M0 239L0 240L357 240L325 239L252 239L0 239z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});	
		
		
		
       construc.params.width = 35;
       construc.params.height = 35;
       construc.params.rotate = true;
		
	}
	
	if (typeObj == "fregadero")
 	{
		construc.push({'path': "M0 0L0 378L378 378L378 377L1 377L1 110L1 33L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});	
		construc.push({'path': "M1 0L1 377L378 377L378 94L378 24C378 19.1866 380.455 4.24216 376.397 1.02777C371.71 -2.68451 356.846 0 351 0L279 0L1 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});	
		construc.push({'path': "M377 0L378 1L377 0M5 4L5 373L374 373L374 4L5 4z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});	
		construc.push({'path': "M185 14.5332C166.483 19.0112 174.752 46.99 193 42.2901C211.773 37.4549 203.476 10.065 185 14.5332z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});	
		construc.push({'path': "M186.004 18.6566C173.005 22.6107 179.349 41.8614 191.996 38.1813C205.311 34.3068 198.758 14.777 186.004 18.6566z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});	
		construc.push({'path': "M45 50.4398C15.3047 55.2209 20 88.717 20 111L20 279C20 297.558 13.9108 329.34 25.5571 345C40.8952 365.623 79.4848 358 102 358L256 358C280.829 358 309.712 362.039 334 356.789C363.286 350.458 358 318.809 358 296L358 125C358 106.517 364.037 74.9305 350.811 60.0146C334.898 42.0686 294.758 50 273 50L121 50C96.5267 50 69.1506 46.5515 45 50.4398z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M46 54.4645C18.0415 59.5072 24 94.1093 24 115L24 279C24 296.849 18.0262 328.096 29.5324 342.996C43.9791 361.704 84.1365 354 105 354L257 354C281.368 354 310.234 358.213 334 352.475C360.665 346.036 354 311.412 354 291L354 125C354 107.13 359.941 76.3416 346.787 62.0934C339.37 54.0589 329.101 54 319 54L271 54L120 54C96.3766 54 69.2344 50.2739 46 54.4645z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		
		
		
       construc.params.width = 35;
       construc.params.height = 35;
       construc.params.rotate = true;
	}
	  
	if (typeObj == "frigo")
	{
		
		construc.push({'path': "M0 0L0 375L376 375L376 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M4 4L4 371L372 371L372 4L4 4z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M179 97C171.001 92.4437 162.07 81.7711 153.039 79.8758C148.479 78.9185 142.999 86.6151 145.658 90.5355C152.812 101.082 173.686 103.885 178.397 116.04C180.353 121.088 179 128.648 179 134L179 172C167.462 165.259 155.716 158.741 144 152.306C138.996 149.557 131.363 146.887 127.589 142.529C122.035 136.117 123.707 119.157 122.834 111C122.531 108.167 122.845 101.923 120.397 100.032C117.715 97.9593 112.132 99.8655 109 100L112 135C105.187 130.982 90.9515 118.419 83.1049 118.708C78.6836 118.872 73.8853 129.867 76.0463 133.471C79.953 139.986 96.0934 146.109 103 149C95.2651 153.515 81.3753 156.784 75.6188 163.637C72.6395 167.184 76.4067 175.056 81.0432 174.894C93.5723 174.453 106.263 156.724 119 158.912C137.293 162.055 153.074 180.306 170 187L170 188C153.035 194.174 136.853 211.801 119 214.616C106.319 216.615 93.5338 199.657 81.0432 198.677C76.1995 198.298 72.222 206.458 75.6073 210.034C81.5041 216.263 95.1107 220.715 103 224C95.8709 228.363 80.4106 233.371 76.0432 240.529C73.3999 244.862 78.8877 254.832 84.0401 254.458C93.0334 253.806 104.866 243.102 112 238C109.886 246.881 107.624 260.904 109.148 269.941C109.897 274.383 117.082 275.591 120.397 272.972C123.024 270.897 122.766 264.065 122.975 261C123.682 250.651 125.555 240.363 126 230C142.903 226.132 164.892 211.075 179 201L179 239C179 244.079 180.255 251.166 178.397 255.96C173.686 268.115 152.812 270.918 145.658 281.465C142.999 285.385 148.479 293.081 153.039 292.124C161.972 290.249 171.05 279.529 179 275L179 309L197 309L197 275C204.524 279.644 214.184 290.727 222.907 292.289C227.606 293.13 231.853 284.993 229.353 281.325C222.276 270.944 202.26 268.017 197.603 255.961C195.749 251.16 197 244.084 197 239L197 202L235 222.999L248.973 231.415L251.086 245L254 274L265.397 272.972L266.424 263L264 239C271.69 242.597 283.013 254.995 291.79 254.407C296.443 254.096 301.205 243.248 298.357 239.61C292.895 232.633 279.598 228.439 272 224C279.991 220.673 294.488 216.426 300.381 210.034C303.417 206.742 299.359 198.238 294.895 198.539C282.368 199.381 269.699 216.326 257 214.644C238.54 212.197 222.798 193.235 205 188L205 187C222.5 180.947 238.291 161.614 257 158.862C269.644 157.002 282.397 174.452 294.957 174.894C299.593 175.056 303.361 167.184 300.381 163.637C294.427 156.55 279.987 153.662 272 149C279.528 145.866 293.23 140.845 298.378 134.39C301.152 130.913 296.283 120.012 291.892 119.531C284.617 118.734 270.223 131.191 264 135L267 100C263.843 99.8644 258.316 97.9703 255.6 100.032C252.654 102.267 253.177 108.736 252.914 112C252.312 119.493 253.41 136.691 248.397 142.505C244.53 146.99 236.175 149.955 231 152.769C219.578 158.98 208.198 165.396 197 172L197 134C197 128.643 195.651 121.094 197.603 116.039C202.26 103.983 222.276 101.056 229.353 90.6752C231.853 87.0074 227.606 78.8703 222.907 79.7114C214.184 81.2727 204.524 92.3563 197 97C197 87.166 200.728 68.1197 196.397 59.3179C194.654 55.7759 182.361 55.6576 180.028 58.6034C178.088 61.0522 179 66.0896 179 69L179 97z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		
		
       construc.params.width = 35;
       construc.params.height = 35;
       construc.params.rotate = true;
		
	}
	  
	if (typeObj == "micro")
	{
		
		construc.push({'path': "M0 0L0 239L356 239L356 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M4 4L4 235L352 235L352 4L4 4z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M59 50.4282C47.285 52.1103 38.4019 58.0425 33.3241 69C29.1962 77.9075 31 89.4083 31 99C31 123.123 21.9313 167.378 44.2863 183.441C58.6871 193.788 85.2658 189 102 189L205 189C222.408 189 241.937 191.45 259 187.711C269.323 185.448 277.773 177.785 281.532 168C285.13 158.634 284 147.823 284 138C284 113.948 292.677 70.6186 269 55.4429C253.085 45.242 227.158 50 209 50L110 50C93.3979 50 75.4359 48.0683 59 50.4282z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M60 54.4282C23.4148 59.6812 35 115.454 35 142C35 155.792 33.7502 169.906 46.0895 179.362C59.6354 189.743 85.9618 185 102 185L205 185C222.314 185 242.07 187.583 259 183.468C268.916 181.058 276.429 171.564 278.761 162C280.96 152.982 280 143.215 280 134C280 111.015 287.943 72.0176 265 57.8148C250.771 49.0062 224.163 54 208 54L110 54C93.72 54 76.1174 52.1141 60 54.4282z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M317 73.5085C298.873 76.1056 303.466 103.364 321 100.656C338.09 98.0164 334.746 70.9659 317 73.5085M70 89C72.8627 98.7262 91.999 102.828 101 103.946C117.18 105.956 132.866 104.392 148 97.9854C163.923 91.245 175.837 81.3344 194 80.0895C205.717 79.2863 217.034 81.6931 228 85.6952C233.162 87.5793 237.536 91.2057 243 92C240.487 77.1387 210.18 77 199 77C168.88 77 148.977 97.155 120 100.714C100.973 103.05 87.4267 91.2793 70 89z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M315.043 77.7423C304.049 82.1754 311.121 100.257 321.96 95.9753C333.586 91.3825 326.86 72.9773 315.043 77.7423z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M70 118C73.0112 128.231 94.5098 132.88 104 132.996C117.747 133.165 130.931 133.492 144 128.575C161.484 121.996 174.387 110.434 194 109.09C212.906 107.794 225.706 117.665 243 121C240.649 107.094 209.979 105.001 199 105C170.831 104.998 152.507 124.623 126 128.725C113.634 130.639 101.916 129.614 90 125.645C83.3205 123.42 76.9538 118.91 70 118M317 126.508C299.014 129.114 303.55 156.351 321 153.656C338.144 151.008 334.442 123.982 317 126.508z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M318.001 130.718C305.269 131.966 308.148 151.08 319.996 149.362C331.633 147.674 330.056 129.535 318.001 130.718z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M71 146C70.1722 151.555 75.593 153.152 80 155.218C91.0944 160.42 101.99 161 114 161C126.19 161 136.555 160.224 148 155.546C162.894 149.459 174.394 140.327 191 138.286C211.166 135.808 224.635 146.459 243 150C242.04 144.321 236.887 142.396 232 140.287C220.521 135.334 208.369 133.98 196 134C169.381 134.043 150.33 153.092 125 157.536C104.974 161.05 89.0045 152.552 71 146z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});

       construc.params.width = 35;
       construc.params.height = 35;
       construc.params.rotate = true;
		
	}
	  
	if (typeObj == 'lavavajillas_bajo')
	{
		
		construc.push({'path': "M0 1895 l0 -1885 1885 0 1885 0 -2 1882 -3 1883 -1882 3 -1883 2 0 -1885z m3730 0 l0 -1845 -1845 0 -1845 0 0 1845 0 1845 1845 0 1845 0 0 -1845z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"})
		
		construc.push({'path': "M962 2733 c-5 -10 -31 -76 -57 -148 -119 -324 -230 -611 -242 -623 -7 -7 -13 -18 -13 -24 0 -12 -124 -346 -151 -404 -74 -164 -29 -401 103 -540 70 -75 201 -140 309 -154 273 -37 531 143 578 404 25 135 14 194 -83 451 -37 99 -84 223 -103 275 -20 52 -39 97 -43 100 -6 5 -95 236 -207 540 -50 135 -71 163 -91 123z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"})
		
		construc.push({'path': "M1930 2363 c0 -351 16 -507 61 -601 28 -57 111 -142 167 -171 50 -26 144 -51 189 -51 l33 0 0 -213 c0 -208 -1 -214 -25 -264 -31 -62 -94 -122 -167 -159 -44 -23 -69 -28 -150 -32 -87 -4 -98 -6 -98 -23 0 -26 76 -35 164 -20 128 22 242 105 298 219 22 45 23 56 23 292 l0 245 -80 5 c-94 7 -170 38 -234 96 -109 98 -131 199 -138 637 l-5 317 541 0 541 0 0 -295 c0 -190 -4 -295 -10 -295 -5 0 -10 -12 -10 -27 -1 -60 -31 -195 -54 -241 -30 -60 -111 -136 -173 -163 -28 -13 -82 -24 -128 -28 l-80 -6 0 -255 0 -256 35 -58 c42 -70 123 -138 200 -167 98 -37 270 -35 258 4 -3 8 -37 14 -104 17 -79 4 -111 11 -156 32 -71 33 -142 103 -174 171 -23 50 -24 61 -24 258 l0 206 67 6 c122 12 251 93 311 196 14 25 29 48 33 51 12 9 27 75 41 175 8 64 13 208 13 405 l0 305 -582 3 -583 2 0 -317z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"})
		
		/*construc.push({'path': "M0 0L0 377L377 377L377 94L377 24C377 19.1866 379.455 4.24219 375.397 1.02777C370.71 -2.68451 355.846 0 350 0L278 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladolava"});
		construc.push({'path': "M376 0L377 1L376 0M4 4L4 373L373 373L373 4L4 4z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escaladolava"});
		construc.push({'path': "M97.3634 104.176C94.0105 105.869 92.7903 112.782 91.5764 116C87.1824 127.65 83.1916 139.422 78.6011 151C70.8028 170.669 63.0967 190.229 55.5756 210C51.49 220.74 46.0787 231.217 46.0787 243C46.0787 281.463 87.8537 306.351 122 289.135C177.336 261.236 133.823 192.764 118.95 153C114.088 140.002 109.32 126.982 104.424 114C103.532 111.637 101.425 102.125 97.3634 104.176M193 110C193 148.505 180.542 223.841 238 224C238 249.227 243.537 281.542 212 290.073C206.234 291.632 199.917 291 194 291L194 295C213.901 297.515 235.63 290.304 241.956 269C244.342 260.965 243 251.312 243 243C243 236.686 244.484 228.217 242.682 222.148C241.2 217.157 232.018 219.268 228 218.239C218.756 215.871 210.355 209.985 205.108 202C199.609 193.632 198.698 181.748 197.914 172C196.368 152.755 197 133.328 197 114L305 114C305 140.34 310.702 177.362 296.647 201C291.723 209.282 283.291 215.639 274 218.076C268.814 219.436 259.713 216.825 259.059 224.019C257.864 237.149 255.83 258.521 260.108 271C266.332 289.154 290.88 301.646 309 294L309 292C300.661 289.535 292.313 291.78 284 288.123C257.563 276.496 263 247.602 263 224C268.451 223.996 273.794 223.701 279 221.899C311.177 210.762 309.797 173.959 309.997 145.996C310.059 137.332 310.004 128.665 310 120C309.999 117.383 310.75 112.891 308.397 111.028C303.012 106.763 284.786 110 278 110L193 110z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladolava"});
		construc.push({'path': "M0 377L0 378L377 378L344 377L267 377L0 377z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escaladolava"});
		*/
       construc.params.width = 35;
       construc.params.height = 35;
       construc.params.rotate = true;
		
	}
	  
	if (typeObj == 'lavadora_bajo')
	{
		
		construc.push({'path': "M205 3938 c-3 -7 -4 -839 -3 -1848 l3 -1835 1858 -3 1857 -2 -2 1847 -3 1848 -1853 3 c-1481 2 -1854 0 -1857 -10z m3655 -1838 l0 -1810 -1810 0 -1810 0 0 1810 0 1810 1810 0 1810 0 0 -1810z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1147 2933 c-3 -4 -103 -264 -222 -578 -119 -314 -225 -589 -236 -612 -10 -23 -23 -72 -28 -109 -54 -380 313 -678 678 -549 208 73 343 284 328 512 -6 77 -21 120 -245 710 -227 596 -255 659 -275 626z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2130 2655 c-203 -102 -370 -189 -370 -195 0 -5 46 -102 102 -215 83 -165 107 -205 123 -205 11 0 62 23 114 50 51 28 95 50 97 50 2 0 4 -245 4 -545 l0 -545 558 2 557 3 3 543 c1 298 5 542 9 542 3 0 48 -22 99 -50 51 -27 101 -50 111 -50 15 0 43 48 121 205 56 113 102 210 102 215 0 6 -167 93 -370 195 l-370 185 -50 -34 c-72 -49 -113 -61 -215 -61 -76 0 -99 5 -147 27 -31 14 -65 36 -75 47 -9 12 -21 21 -25 21 -4 0 -174 -83 -378 -185z m409 99 c58 -38 124 -54 221 -54 98 0 163 16 223 56 l41 27 338 -169 c186 -93 338 -170 338 -170 0 -1 -38 -82 -85 -179 l-85 -177 -116 62 c-65 33 -123 59 -131 56 -11 -4 -13 -107 -13 -561 l0 -555 -510 0 -510 0 0 554 c0 384 -3 557 -11 561 -6 4 -63 -20 -128 -53 l-117 -61 -87 176 c-49 96 -87 177 -85 178 7 7 664 334 671 334 4 1 25 -11 46 -25z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M893 3 c15 -2 37 -2 50 0 12 2 0 4 -28 4 -27 0 -38 -2 -22 -4z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1223 3 c15 -2 37 -2 50 0 12 2 0 4 -28 4 -27 0 -38 -2 -22 -4z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1543 3 c15 -2 37 -2 50 0 12 2 0 4 -28 4 -27 0 -38 -2 -22 -4z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1873 3 c15 -2 37 -2 50 0 12 2 0 4 -28 4 -27 0 -38 -2 -22 -4z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2203 3 c15 -2 37 -2 50 0 12 2 0 4 -28 4 -27 0 -38 -2 -22 -4z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2533 3 c15 -2 37 -2 50 0 12 2 0 4 -28 4 -27 0 -38 -2 -22 -4z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2863 3 c15 -2 37 -2 50 0 12 2 0 4 -28 4 -27 0 -38 -2 -22 -4z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M3183 3 c15 -2 37 -2 50 0 12 2 0 4 -28 4 -27 0 -38 -2 -22 -4z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		/*construc.push({'path': "M0 0L0 283L0 353C0 358.833 -2.55563 373.019 2 377C-3.64934 353.271 1 323.405 1 299L1 138L1 46C1 31.3544 -1.39777 14.2715 2 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escaladolava"});
		construc.push({'path': "M380 377L380 118L380 39L379 0C348.634 1.95502 317.45 0 287 0L101 0L29 0C22.9658 0 7.43064 -2.79547 2.60339 1.02777C-1.04579 3.91797 1 15.7655 1 20L1 74L1 295L1 356C1 360.345 -1.26208 374.143 3.3179 376.397C10.6009 379.98 25.9014 377 34 377L110 377L380 377z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladolava"});
		construc.push({'path': "M377 0L378 1L377 0M379 0L380 1L379 0M5 4L5 373L374 373L374 4L5 4z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escaladolava"});
		construc.push({'path': "M98.3642 104.176C94.946 105.91 93.5513 113.669 92.3187 117L78.9498 153C72.073 171.446 64.6584 189.69 57.3989 208C52.9741 219.16 46.9304 230.675 47.2593 243C48.259 280.465 87.1422 306.642 122 289.627C178.692 261.956 135.007 193.387 119.95 153C115.101 139.995 110.359 126.971 105.424 114C104.529 111.646 102.424 102.117 98.3642 104.176M205 184L205 295L290 295C295.521 295 314.372 297.942 317.972 293.397C322.127 288.151 319 270.598 319 264L319 184C324.485 186.284 335.776 196.642 341.657 194.353C344.943 193.075 345.899 187.857 347.262 185C351.27 176.594 355.625 168.348 359.752 160C361.3 156.87 363.883 152.883 360.667 149.966C355.622 145.391 347.073 142.79 341 139.753C329.208 133.857 318.094 126.853 306 121.576C300.881 119.342 294.613 114.357 289 113.916C283.971 113.521 278.707 119.263 274 120.899C261.776 125.149 245.857 122.882 237 113C217.334 117.671 198.015 131.769 180 140.753C175.195 143.15 163.668 146.444 161.133 151.39C159.598 154.384 162.459 158.402 163.753 161C167.907 169.338 172.132 177.641 176.244 186C177.561 188.677 178.813 193.937 182.225 194.578C189.186 195.885 198.993 186.804 205 184z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladolava"});
		construc.push({'path': "M166 153L183 189C187.353 187.214 204.756 176.16 208.397 178.828C212.92 182.143 210 201.694 210 207L210 291L314 291L314 207C314 201.62 311.065 182.234 315.603 178.817C319.491 175.891 335.626 187.179 340 189L357 153L316.09 132.691L290 119.771L277 124.907L256 126.91L233 119.771L207.91 132.691L166 153z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladolava"});
		*/
       construc.params.width = 35;
       construc.params.height = 35;
       construc.params.rotate = true;
		
	}
	  
	if (typeObj == "horno")
	{
		
		construc.push({'path': "M0 0L0 376L376 376L376 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M4 5L4 186L372 186L372 5L4 5z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M94 11.6528C76.1051 17.2439 85.0852 44.2076 102.996 38.6667C120.129 33.3665 111.36 6.22888 94 11.6528M183 11.5332C165.222 15.8545 173.003 43.5789 191 39.0571C210.016 34.2792 201.55 7.02411 183 11.5332M272 11.6528C254.105 17.2439 263.085 44.2076 280.996 38.6667C298.293 33.3157 289.421 6.20959 272 11.6528z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M96.0008 15.588C83.2763 18.8807 88.2326 38.0222 100.996 34.5656C112.793 31.3707 107.953 12.4951 96.0008 15.588M184.015 15.6566C171.034 19.6729 178.16 38.1599 190.985 34.5663C203.778 30.9817 196.32 11.8493 184.015 15.6566M274.001 15.588C261.276 18.8805 266.233 38.022 278.996 34.5656C291.108 31.2858 286.105 12.4559 274.001 15.588z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M53 47.4645C43.7764 49.1275 35.1173 54.5536 30.6736 63C25.7953 72.2724 27 82.8971 27 93C27 115.598 19.499 150.939 44 163.19C52.8858 167.633 63.3407 167 73 167L120 167L258 167C279.244 167 305.525 171.135 326 164.957C335.206 162.179 342.577 154.896 346.073 146C349.673 136.841 349 126.635 349 117C349 94.899 354.489 60.0761 329 49.4784C319.98 45.7283 309.543 47 300 47L247 47L117 47C96.5368 47 73.1319 43.8348 53 47.4645z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M54 51.4676C44.033 53.3479 36.8911 59.8682 32.9012 69C29.4987 76.7876 31 86.6811 31 95C31 115.787 23.9595 148.828 47 159.673C55.5624 163.703 65.7847 163 75 163L121 163L259 163C279.146 163 305.756 167.498 325 160.892C332.375 158.36 339.029 152.285 341.881 145C345.109 136.756 345 127.69 345 119C345 98.2575 350.838 62.2997 326 53.0941C316.649 49.6284 305.797 51 296 51L243 51L116 51C96.2517 51 73.4002 47.8076 54 51.4676z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M72 82C73.6551 86.9868 78.4595 85.9997 83 86L116 86L255 86L291 86C295.848 86 302.185 87.4682 304 82L72 82M72 105L72 109L304 109L304 105L72 105M72 130C73.6551 134.987 78.4595 134 83 134L116 134L255 134L291 134C295.848 134 302.185 135.468 304 130L72 130z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M4 190L4 372L372 372L372 190L4 190z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M53 208.465C42.6172 210.337 33.1708 217.077 29.0941 227C25.3545 236.103 27 247.349 27 257L27 309C27 323.671 26.6915 336.863 40 346.362C55.1304 357.161 82.3616 352 100 352L213 352C230.28 352 251.185 355.184 268 351.1C277.954 348.683 286.675 341.756 290.289 332C293.827 322.452 293 311.985 293 302C293 277.014 302.51 228.754 278 212.969C262.1 202.729 234.151 208 216 208L107 208C89.6981 208 70.0279 205.394 53 208.465z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M54 212.468C44.1191 214.332 35.3955 221.413 32.108 231C29.3421 239.066 31 249.563 31 258L31 310C31 322.514 30.6944 334.167 42.0039 342.363C56.8482 353.12 83.5851 348 101 348L213 348C229.716 348 250.835 351.445 267 347.073C276.072 344.618 283.799 337.978 286.892 329C289.917 320.219 289 310.127 289 301L289 251C289 237.637 287.602 223.862 275 216.214C259.406 206.75 231.653 212 214 212L107 212C90.0834 212 70.6246 209.331 54 212.468z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M330 231.729C310.95 232.285 312.247 261.879 331 260.891C349.472 259.918 348.536 231.188 330 231.729M67 252C92.6758 261.344 114.41 268.481 142 260.573C162.351 254.739 177.147 241.258 199 239.17C209.266 238.189 221.379 239.723 230.91 243.759C237.606 246.594 243.553 251.505 251 252C249.189 241.537 226.785 237.217 218 236C201.883 233.767 185.201 235.134 170.001 241.204C150.86 248.847 137.921 259.999 116 260C102.09 260.001 89.5759 257.357 77 251.245C73.0852 249.342 68.7772 246.702 67 252z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M326.043 236.858C314.415 241.833 322.148 260.783 333.985 255.987C346.214 251.032 338.422 231.562 326.043 236.858z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M67 282C92.6758 291.344 114.41 298.481 142 290.573C160.828 285.176 174.709 272.14 195 270.17C206.882 269.016 218.699 270.19 230 274.004C237.028 276.375 243.692 280.86 251 282C249.358 271.936 228.511 268.405 220 266.804C203.182 263.641 184.82 265.935 169 272.204C150.347 279.594 137.155 289.999 116 290C102.09 290.001 89.5759 287.357 77 281.245C73.0852 279.342 68.7772 276.702 67 282M329 287.638C310.125 289.311 313.244 318.93 332 316.811C350.137 314.762 347.454 286.003 329 287.638z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M326.043 292.858C314.526 297.786 322.197 316.763 333.985 311.987C346.195 307.039 338.46 287.545 326.043 292.858z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M67 313C93.2348 322.547 115.934 329.903 144 320.971C162.216 315.175 175.249 302.081 195 300.17C207.015 299.007 219.662 299.931 230.961 304.373C237.778 307.053 243.627 311.85 251 313C249.227 302.125 228.985 298.494 220 296.804C202.824 293.574 183.005 295.714 167.015 302.876C149.37 310.779 137.688 320.967 117 321C102.706 321.023 89.9434 318.535 77 312.245C73.0852 310.342 68.7772 307.702 67 313z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "vitro_induccion")
	{
		
		construc.push({'path': "M0 0L0 377L376 377L376 94L376 24C376 19.1866 378.455 4.24219 374.397 1.02777C369.71 -2.68451 354.846 0 349 0L277 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M375 0L376 1L375 0M4 4L4 373L372 373L372 4L4 4z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M41 20.4676C10.7293 26.1783 19 67.8353 19 90L19 274L19 320C19 328.816 18.2171 337.429 23.6381 344.999C38.4814 365.728 77.8701 358 100 358L255 358C279.743 358 308.863 362.182 333 356.572C363.847 349.401 357 310.794 357 287L357 102C357 81.3118 363.47 47.2359 349.61 30.0146C341.62 20.0877 330.62 20 319 20L273 20L117 20C92.8474 20 64.717 15.9933 41 20.4676z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M42 24.5293C14.2597 30.8972 23 73.0692 23 94L23 274L23 318C23 326.753 22.1619 335.501 27.6381 342.985C41.321 361.685 81.7947 354 102 354L257 354C280.831 354 309.882 358.471 333 352.237C360.486 344.825 353 304.324 353 283L353 103C353 83.4814 359.467 49.2672 346.468 33.0401C339.042 23.7708 328.758 24 318 24L272 24L116 24C92.9899 24 64.4016 19.387 42 24.5293z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M94 53.4645C40.3585 63.1189 37.674 143.207 91 155.764C97.9938 157.411 105.918 157.659 113 156.384C120.923 154.958 129.432 151.77 136 147.062C161.281 128.939 162.025 88.5717 140.946 67.0401C129.369 55.2141 110.073 50.5717 94 53.4645M262 53.4391C207.874 61.9588 205.344 140.772 257 155.254C264.267 157.291 272.535 157.736 280 156.561C332.936 148.229 338.703 70.1656 287 54.9128C279.157 52.5992 270.09 52.1656 262 53.4391M97 220.439C89.0779 221.676 81.8611 224.365 75 228.508C47.3332 245.217 43.6717 288.523 67.1844 310.74C79.5022 322.379 97.7212 326.46 114 323.715C168.032 314.601 169.466 232.781 116 221.453C109.787 220.137 103.313 219.453 97 220.439M265 220.428C257.107 221.559 248.701 223.743 242 228.22C195.581 259.234 225.864 332.053 280 323.866C334.2 315.669 338.118 235.411 285 221.896C278.424 220.223 271.753 219.461 265 220.428z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		
		
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "frigo_americano")
	{
	
		construc.push({'path': "M0 0L0 368L490 368L490 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M4 4L4 364L183 364L183 4L4 4M187 4L187 364L486 364L486 4L187 4z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M326 96C318.077 91.4865 309.012 80.5587 300.04 78.8511C295.036 77.8986 290.922 85.8028 293.622 89.6999C300.734 99.9671 320.795 103.167 325.397 115.04C327.255 119.834 326 126.921 326 132L326 170C314.471 163.201 302.637 156.896 291 150.281C286.233 147.571 279.03 145.069 275.6 140.671C270.624 134.292 271.688 118.858 271 111C270.733 107.95 271.047 101.076 268.397 99.0316C265.711 96.9605 260.134 98.8654 257 99L260 133C254.229 129.194 238.216 116.03 231.213 117.816C227.173 118.847 222.701 128.732 225.619 132.096C230.631 137.872 244.779 144.699 252 147L252 148C244.568 150.141 229.659 155.637 224.619 161.637C221.639 165.184 225.407 173.056 230.043 172.894C242.501 172.456 254.246 154.981 267 156.862C284.112 159.385 299.388 177.743 316 183L316 185C299.252 189.926 284.154 208.245 267 210.64C254.218 212.426 242.492 195.371 230.105 194.539C225.641 194.238 221.583 202.742 224.619 206.034C229.874 211.734 243.629 216.877 251 219L251 221C243.828 224.006 230.635 229.816 225.619 235.789C222.414 239.604 227.486 248.978 232.093 249.469C240.297 250.344 252.645 238.434 260 235L257.424 259L258.603 267.972L270 269L272.831 240L275.013 227.379L291 217.231L326 198L326 234C326 239.079 327.255 246.166 325.397 250.96C320.795 262.833 300.734 266.033 293.622 276.3C290.922 280.197 295.036 288.101 300.04 287.149C309.012 285.441 318.077 274.513 326 270L326 303L343 303L343 270C350.578 274.676 360.215 285.485 368.96 287.149C373.348 287.984 378.972 280.329 376.339 276.515C369.089 266.014 348.34 263.183 343.603 250.96C341.745 246.166 343 239.079 343 234L343 198L379 217.769L393.976 227.379L396.166 240L399 269L410.397 267.972L411.576 259L409 235C416.715 238.324 428.52 249.531 436.896 249.289C441.708 249.149 446.325 239.302 443.381 235.529C438.001 228.635 425.301 224.816 418 220C425.794 216.755 439.637 212.265 445.381 206.034C448.417 202.742 444.359 194.238 439.895 194.539C427.386 195.38 414.724 212.417 402 210.64C384.901 208.252 369.787 189.845 353 185L353 183C369.845 178.045 384.804 159.397 402 156.862C414.717 154.987 427.379 172.452 439.957 172.894C444.593 173.056 448.36 165.184 445.381 161.637C439.625 154.784 425.735 151.515 418 147C425.162 143.914 438.543 138.668 443.381 132.471C446.156 128.916 442.264 119.188 437.787 118.426C430.175 117.131 415.444 129.199 409 133L412 99C408.859 98.8651 403.298 96.9636 400.603 99.0316C397.832 101.157 398.189 107.866 397.975 111C397.45 118.686 398.232 134.477 393.4 140.671C389.807 145.278 382.047 148.025 377 150.769C365.578 156.98 354.198 163.396 343 170L343 132C343 126.921 341.745 119.834 343.603 115.04C348.34 102.817 369.089 99.9858 376.339 89.4854C378.972 85.6715 373.349 78.0158 368.96 78.8511C360.215 80.5154 350.578 91.3239 343 96L343 69C343 66.0897 343.912 61.0522 341.972 58.6034C339.411 55.369 327.593 55.854 326.318 60.1481C323.276 70.3938 326 85.2973 326 96z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "vitro_horno")
	{
		
		construc.push({'path': "M0 0L0 377L376 377L376 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M376 0L376 377L0 377L0 394L52 394L54.3179 386.028L68 385L103 385L271 385L310 385L326.852 385.603L330 394L377 394L377 115L377 35L376 0M4 4L4 372L372 372L372 4L4 4z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M41 20.4676C10.8327 26.1588 19 67.9311 19 90L19 273L19 319C19 328.096 18.2895 337.151 23.8002 344.999C38.3576 365.731 78.0619 358 100 358L256 358C280.281 358 309.34 362.335 333 356.764C364.191 349.419 357 312.231 357 288L357 102C357 81.6425 363.709 46.8939 350.239 30.0903C342.095 19.9303 330.813 20 319 20L273 20L117 20C92.8474 20 64.717 15.9933 41 20.4676z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M42 24.5293C14.3629 30.8735 23 73.1814 23 94L23 274L23 318C23 326.913 22.2297 335.387 27.7894 342.985C41.4527 361.658 81.8147 354 102 354L257 354C281.16 354 310.597 358.526 334 352.073C361.055 344.614 353 304.097 353 283L353 103L353 59C353 50.35 353.259 41.2063 347.606 34.0038C339.524 23.7043 328.881 24 317 24L272 24L116 24C92.9899 24 64.4016 19.387 42 24.5293z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M94 53.4645C39.7387 63.2305 38.5689 142.207 91 155.622C97.8882 157.384 105.969 157.779 113 156.536C120.574 155.198 128.653 152.328 135 147.945C180.744 116.359 146.86 43.9508 94 53.4645M262 53.4637C254.627 54.7669 247.218 57.3308 241 61.5201C194.896 92.582 227.533 166.007 281 156.384C288.136 155.1 295.016 152.339 301 148.227C346.499 116.963 316.722 43.791 262 53.4637M97 220.439C88.9574 221.695 81.9475 224.464 75 228.66C48.2164 244.835 43.9155 285.244 65.3002 307.896C78.0055 321.354 96.0098 326.749 114 323.715C167.99 314.609 169.77 232.462 116 221.45C109.764 220.173 103.333 219.45 97 220.439M265 220.428C257.092 221.564 248.698 223.897 242 228.363C210.51 249.356 212.505 297.69 244.17 317.64C254.92 324.414 268.772 325.613 281 323.83C289.104 322.649 295.746 318.908 302.09 313.988C342.674 282.514 319.272 212.636 265 220.428M52 394L330 394L328.397 386.028L315 385L279 385L111 385L71 385L54.3179 385.603L52 394z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "gas_horno")  
	{
	
		construc.push({'path': "M0 0L0 402L378 402L378 0L377 0L377 377L1 377L1 110L1 33L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M1 0L1 377L377 377L377 0L1 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M5 4L5 372L373 372L373 4L5 4z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M42 20.5293C12.1104 27.3906 20 68.4582 20 91L20 272L20 317C20 326.227 19.374 335.958 24.7608 343.985C39.3498 365.726 78.4757 358 101 358L259 358C282.979 358 312.842 362.755 336 356.254C365.716 347.911 358 309.588 358 286L358 101C358 81.0059 364.643 46.5121 351.319 30.0401C343.147 19.9362 331.812 20 320 20L275 20L117 20L67 20C59.0225 20 49.8028 18.7382 42 20.5293z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M44 24.5185C15.834 30.6293 24 72.0191 24 93L24 272L24 317C24 325.515 23.4925 334.655 28.6489 341.999C42.5648 361.82 82.99 354 104 354L257 354C281.368 354 310.234 358.213 334 352.475C362.053 345.701 354 305.339 354 284L354 103L354 59C354 50.2433 354.331 41.2768 348.61 34.0008C340.479 23.6599 329.975 24 318 24L273 24L118 24C94.8199 24 66.6312 19.6086 44 24.5185z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M101 32L101 53C75.5655 53.5279 54.0782 75.9526 53 101C47.5712 101 38.2359 99.1832 33.3179 101.603C30.5716 102.955 30.2303 108.092 32.6034 109.972C36.596 113.136 48.0603 111 53 111C56.1506 135.397 75.7253 155.898 101 157L101 180L110 180L110 157C135.267 154.936 153.791 135.845 157 111C162.13 111 174.261 113.25 178.397 109.972C181.18 107.766 180.183 102.307 176.852 101.318C171.051 99.5957 163.04 101 157 101C155.92 75.9052 135.339 54.1048 110 53L110 32L101 32M268 32L268 53C249.973 53.786 234.573 64.2712 226.32 80C223.842 84.724 222.867 97.1853 218.682 99.9722C214.239 102.931 204.19 101 199 101C199.01 114.562 210.234 111 221 111C221.536 136.144 244.022 155.092 268 157C268 162.13 265.75 174.261 269.028 178.397C271.234 181.18 276.693 180.183 277.682 176.852C279.404 171.051 278 163.04 278 157C301.502 153.965 323.465 136.115 324 111C334.886 111 346.989 114.813 347 101C341.688 101 330.931 103.061 326.434 99.9722C322.248 97.0977 321.259 84.7691 318.691 80C310.422 64.6451 295.636 54.4404 278 53L278 32L268 32z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M57 101L101 101L101 57C78.085 58.8236 58.8725 78.0746 57 101M110 57L110 101L153 101C151.071 77.3855 133.06 59.9781 110 57M225 101L268 101L268 57C245.419 58.8444 225.48 77.8839 225 101M278 57L278 101L321 101C315.137 78.3495 302.949 60.3624 278 57M57 111C61.6688 133.56 77.8296 150.008 101 153L101 111L57 111M110 111L110 153C133.367 148.466 148.122 134.572 153 111L110 111M225 111C226.858 133.751 246.246 150.071 268 153L268 111L225 111M278 111L278 153C299.157 148.633 318.128 133.92 320 111L278 111z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M101 199C101 204.102 102.945 214.237 99.9722 218.566C97.0801 222.778 84.7838 223.701 80 226.312C63.8025 235.156 53.3875 250.326 53 269L31 269C31.0446 281.627 43.2533 278 53 278C54.9516 301.894 76.766 323.799 101 324C101 327.766 98.8043 354.489 108.397 346.971C112.467 343.782 110 328.835 110 324C134.232 323.497 155.051 301.856 157 278C166.857 278 179.955 281.844 180 269L157 269C156.631 251.193 146.753 234.758 131 226.324C126.173 223.74 113.931 223.062 111.028 218.683C108.073 214.227 110 204.2 110 199L101 199M199 269L199 278L221 278C221.497 301.947 244.204 323.8 268 324C268 330.332 266.513 338.772 268.318 344.852C269.307 348.183 274.766 349.18 276.972 346.397C280.362 342.119 278 329.32 278 324C301.234 323.505 323.519 301.183 324 278L347 278L347 269C341.688 269 330.931 271.061 326.434 267.972C322.605 265.343 322.644 256.189 321.25 252C318.824 244.711 313.692 238.18 307.999 233.13C303.214 228.884 297.021 225.455 291 223.345C287.751 222.206 282.057 221.902 279.603 219.4C274.975 214.682 282.602 199.117 273 199.117C263.349 199.117 271.113 214.605 266.397 219.258C264.036 221.588 259.062 221.676 256 222.671C249.602 224.751 243.113 227.743 238 232.188C231.503 237.837 226.237 244.782 223.519 253C222.197 256.998 222.234 265.453 218.566 267.972C214.237 270.945 204.102 269 199 269z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M100 224C77.8645 231.014 58.1284 243.119 57 269L101 269C101 256.258 104.91 235.701 100 224M267 224C241.762 232.56 230.475 242.718 224 269L268 269C268 256.258 271.91 235.701 267 224M110 225L110 269L153 269C151.193 246.297 133.92 225.51 110 225M278 225L278 269L321 269C315.592 247.048 303.621 226.117 278 225M57 278C60.9954 298.591 78.5303 319.534 101 320L101 278L57 278M110 278L110 320C132.649 319.013 148.967 298.786 153 278L110 278M225 278C225.968 299.193 247.017 319.085 268 320L268 278L225 278M278 278L278 320C298.517 318.324 319.047 298.844 320 278L278 278z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M327 385L222 385L149 385L68 385C58.9115 385 49.809 382.384 50.0046 393.999C50.0338 395.732 49.8784 397.945 51.0278 399.397C53.3675 402.351 60.6845 401 64 401L103 401L259 401L307 401C311.513 401 321.706 402.895 325.397 399.972C328.607 397.43 327 388.674 327 385z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M0 0L0 402L378 402L378 0L377 0L377 377L1 377L1 110L1 33L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
	

		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "caldera" || typeObj == "despensa")
	{
		
		construc.push({'path': "M0 0L0 239L356 239L356 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
	    construc.push({'path': "M4 4L4 235L352 235L352 4L4 4z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});

		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "escobero")
	{
		
		construc.push({'path': "M0 0L0 376L376 376L376 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M4 5L4 372L372 372L372 5L4 5z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		construc.push({'path': "M182.185 14.7423C173.9 18.3651 177 34.8139 177 42L177 125L177 207C177 217.76 180.02 233.855 176.4 244C172.859 253.927 162.71 263.586 157.425 273C147.747 290.239 142.061 311.305 140.965 331C140.621 337.163 137.783 346.878 140.742 352.682C143.128 357.361 157.484 355 162 355L211 355C216.643 355 226.562 356.916 231.682 354.397C236.395 352.077 233.982 338.248 233.424 334C230.862 314.495 227.746 296.016 219.219 278C213.839 266.632 200.198 254.715 197.317 243C193.367 226.934 197 205.572 197 189L197 72C197 55.915 199.304 37.879 196.786 22.0008C195.697 15.1322 188.513 11.9753 182.185 14.7423z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escalado"});
		construc.push({'path': "M181 244L193 244L193 71L193 30C192.993 25.7129 193.203 18.1999 187 18.3765C180.832 18.5522 181.007 25.5707 181 30L181 71L181 244M144 351L166 351C166 326.371 167.322 302.606 175 279L177 279L172.424 307L170 351C177.094 351 196.711 354.46 202.258 349.972C206.1 346.863 204.147 334.349 203.576 330C202.263 320.006 202.009 309.935 199.996 300C198.61 293.157 195.492 285.956 197 279C201.427 284.802 202.405 291.97 203.8 299C206.934 314.786 210.776 335.14 207 351L230 351C230 322.608 224.501 293.431 209.316 269C205.257 262.471 199.383 249.459 190.999 248.148C177.124 245.979 171.005 258.658 164.8 269C149.876 293.874 144 322.24 144 351z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco escalado"});
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	 
	if (typeObj == "placa-gas80")
	{
		
		construc.push({'path': "M1951 3562 c-1402 -1 -1928 -5 -1938 -13 -18 -16 -20 -3508 -1 -3527 17 -17 4699 -17 4716 0 18 18 17 3527 -1 3533 -20 8 -739 10 -2776 7z m1927 -101 c14 -67 74 -165 125 -203 49 -38 111 -67 167 -79 39 -8 50 -15 50 -30 0 -18 -8 -19 -119 -19 -87 0 -122 -4 -130 -13 -6 -8 -8 -17 -4 -20 3 -4 62 -7 129 -7 l123 0 3 -122 c3 -101 6 -123 18 -123 12 0 15 22 18 123 l3 122 123 0 c67 0 126 3 129 7 4 3 2 12 -4 20 -8 9 -43 13 -130 13 -111 0 -119 1 -119 19 0 15 11 22 52 30 82 18 135 46 191 103 56 57 94 126 106 192 6 40 8 41 49 44 l42 3 0 -1735 0 -1736 -2325 0 -2325 0 0 1735 0 1735 1908 0 1908 0 12 -59z m692 32 c0 -82 -101 -212 -198 -255 -73 -33 -190 -31 -263 3 -104 49 -176 139 -195 242 l-6 37 331 0 331 0 0 -27z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M977 3264 c-4 -4 -7 -49 -7 -101 l0 -93 -29 0 c-89 0 -245 -80 -317 -163 -50 -58 -103 -171 -116 -250 l-11 -66 -101 -3 c-82 -2 -101 -6 -101 -18 0 -12 19 -16 101 -18 l102 -3 11 -57 c25 -128 106 -250 213 -321 62 -42 168 -81 219 -81 l28 0 3 -107 c2 -88 6 -108 18 -108 12 0 16 20 18 108 l3 107 33 0 c56 0 160 38 224 81 107 71 188 193 213 321 l11 57 97 3 c77 2 96 6 96 18 0 12 -19 16 -96 18 l-96 3 -11 66 c-13 79 -66 192 -116 250 -74 85 -228 163 -322 163 l-33 0 -3 97 c-3 89 -12 116 -31 97z m-7 -454 l0 -220 -215 0 c-245 0 -227 -8 -200 93 31 119 99 215 196 278 53 34 147 68 192 68 l27 1 0 -220z m159 201 c154 -48 264 -166 306 -328 27 -102 45 -93 -205 -93 l-220 0 0 220 0 220 29 0 c16 0 57 -9 90 -19z m-159 -671 l0 -210 -24 0 c-13 0 -52 9 -85 19 -152 47 -264 167 -306 328 -8 31 -15 61 -15 65 0 4 97 8 215 8 l215 0 0 -210z m480 202 c0 -4 -7 -34 -15 -65 -31 -119 -99 -215 -196 -278 -54 -34 -154 -69 -200 -69 l-29 0 0 210 0 210 220 0 c121 0 220 -4 220 -8z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M3737 3264 c-4 -4 -7 -49 -7 -101 l0 -93 -28 0 c-87 0 -216 -62 -297 -144 -75 -74 -123 -167 -138 -265 l-11 -70 -101 -3 c-81 -2 -100 -6 -100 -18 0 -12 19 -16 101 -18 l101 -3 11 -61 c28 -150 127 -280 266 -349 53 -26 101 -42 138 -46 l57 -6 3 -106 c2 -86 6 -106 18 -106 12 0 16 20 18 106 l3 106 52 6 c202 21 385 201 416 407 l6 45 100 5 c80 4 100 8 100 20 0 12 -19 16 -97 18 l-97 3 -6 37 c-9 57 -35 143 -58 187 -26 51 -128 158 -181 189 -56 33 -157 66 -200 66 l-35 0 -3 97 c-3 89 -12 116 -31 97z m-7 -454 l0 -220 -215 0 -215 0 0 29 c0 41 33 142 63 193 32 55 121 139 178 168 50 26 121 48 162 49 l27 1 0 -220z m162 199 c154 -52 280 -191 303 -335 3 -22 8 -49 11 -61 l4 -23 -220 0 -220 0 0 220 0 220 30 0 c17 0 58 -9 92 -21z m-162 -670 l0 -212 -52 6 c-29 4 -84 22 -123 41 -116 58 -198 153 -235 275 -34 110 -52 101 195 101 l215 0 0 -211z m467 159 c-13 -106 -98 -234 -197 -298 -55 -35 -155 -70 -201 -70 l-29 0 0 210 0 210 216 0 217 0 -6 -52z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2245 2236 c-132 -42 -234 -130 -293 -253 -36 -77 -37 -80 -37 -198 0 -114 2 -123 32 -188 42 -89 92 -148 165 -197 143 -96 328 -106 483 -28 55 29 150 122 185 183 75 132 79 310 9 447 -28 54 -122 153 -177 185 -100 59 -266 81 -367 49z m217 -27 c221 -47 374 -265 339 -485 -29 -188 -174 -334 -363 -366 -176 -29 -371 72 -450 234 -160 327 120 692 474 617z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2311 2088 c-5 -13 -17 -44 -26 -70 -9 -26 -35 -75 -57 -110 -66 -101 -100 -183 -100 -236 0 -109 49 -188 130 -213 59 -17 67 -5 37 55 -14 27 -25 60 -25 72 0 24 39 114 50 114 3 0 11 -13 17 -30 6 -16 16 -30 23 -30 16 0 49 79 56 134 6 43 8 45 24 31 9 -8 27 -36 41 -62 40 -79 26 -197 -30 -247 -46 -42 -3 -63 62 -30 98 49 137 135 117 257 -25 151 -116 283 -251 365 -46 28 -57 28 -68 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M982 1678 c-7 -7 -12 -46 -12 -98 l0 -85 -67 -13 c-202 -39 -364 -206 -396 -411 l-11 -70 -101 -3 c-81 -2 -100 -6 -100 -18 0 -12 19 -16 101 -18 l101 -3 17 -67 c25 -101 63 -170 132 -240 72 -72 176 -127 264 -139 l55 -8 5 -110 c4 -89 8 -110 20 -110 12 0 16 20 18 107 3 119 -2 111 83 123 78 10 184 68 253 138 69 69 107 138 132 240 l17 67 92 0 c65 0 96 4 104 13 18 23 2 27 -98 27 l-97 0 -11 71 c-23 148 -129 298 -255 362 -61 31 -148 57 -190 57 l-28 0 0 94 c0 95 -6 116 -28 94z m-12 -453 l0 -225 -215 0 -215 0 0 23 c0 39 28 135 56 190 61 120 229 233 352 236 l22 1 0 -225z m183 198 c103 -40 195 -122 243 -215 26 -51 54 -147 54 -185 l0 -23 -220 0 -220 0 0 226 0 227 51 -7 c28 -4 70 -14 92 -23z m-183 -669 l0 -207 -51 6 c-107 13 -231 94 -301 195 -30 44 -60 119 -71 180 l-6 32 214 0 215 0 0 -206z m473 174 c-36 -194 -189 -347 -375 -376 l-58 -9 0 209 0 208 220 0 220 0 -7 -32z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M3737 1683 c-4 -3 -7 -48 -7 -98 l0 -92 -51 -7 c-212 -28 -394 -215 -416 -427 l-6 -59 -102 0 c-106 0 -122 -4 -104 -27 8 -9 40 -13 109 -13 l97 0 12 -59 c37 -187 197 -349 379 -383 32 -6 63 -12 70 -14 9 -2 12 -34 12 -114 0 -103 1 -110 20 -110 19 0 20 7 20 109 0 122 -6 114 82 126 73 10 183 70 248 135 68 68 128 180 137 257 l6 52 101 3 c82 2 101 6 101 18 0 12 -19 16 -97 18 l-97 3 -6 47 c-28 207 -164 366 -364 426 -30 9 -67 16 -83 16 l-28 0 0 89 c0 62 -4 92 -13 100 -8 6 -17 8 -20 4z m-7 -458 l0 -225 -215 0 -215 0 0 34 c0 89 65 221 144 294 74 68 184 119 264 121 l22 1 0 -225z m136 211 c170 -45 306 -193 332 -361 6 -33 8 -63 5 -67 -2 -5 -101 -8 -219 -8 l-214 0 0 225 0 225 23 0 c12 0 45 -6 73 -14z m-136 -681 l0 -205 -28 0 c-16 0 -53 7 -83 16 -141 42 -254 155 -299 301 -11 36 -20 71 -20 79 0 12 38 14 215 14 l215 0 0 -205z m466 158 c-22 -167 -202 -343 -369 -360 l-57 -6 0 207 0 206 216 0 217 0 -7 -47z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2161 654 c-39 -32 -43 -92 -10 -125 l20 -20 -32 -36 c-26 -30 -30 -42 -25 -71 7 -43 29 -68 73 -83 100 -33 201 57 159 140 -9 17 -25 35 -36 41 -18 10 -18 11 6 35 33 33 33 87 -1 120 -35 36 -111 35 -154 -1z m117 -27 c29 -23 1 -97 -37 -97 -34 0 -62 30 -59 63 5 49 54 66 96 34z m-10 -157 c26 -16 32 -26 32 -54 0 -38 -28 -66 -65 -66 -64 0 -89 79 -39 119 32 26 31 26 72 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2454 662 c-77 -61 -82 -254 -9 -322 34 -32 102 -35 135 -5 42 38 54 75 54 165 0 92 -15 135 -56 164 -30 21 -97 20 -124 -2z m108 -53 c25 -34 28 -171 4 -217 -29 -56 -88 -47 -107 16 -17 59 -8 185 16 212 25 27 62 23 87 -11z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		
			
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
	}  
	  
	if (typeObj == "electricidad-enchufeservicio")
	{
		
		construc.push({'path': "M10 1012 c0 -545 4 -993 8 -996 17 -10 205 15 288 39 268 78 501 277 619 528 45 95 82 228 91 322 l7 75 93 0 94 0 0 -350 c0 -312 2 -351 16 -357 9 -3 20 0 25 8 5 8 9 168 9 357 l0 342 324 0 c178 0 331 3 340 6 21 8 21 30 0 38 -9 3 -161 6 -340 6 l-324 0 -2 348 c-3 339 -3 347 -23 347 -20 0 -20 -8 -23 -347 l-2 -348 -94 0 -93 0 -7 80 c-14 174 -98 377 -214 520 -174 215 -432 351 -694 367 l-98 6 0 -991z m250 917 c184 -43 391 -175 511 -327 76 -97 152 -251 181 -367 31 -125 31 -342 -1 -460 -73 -271 -264 -503 -516 -625 -83 -40 -220 -78 -310 -86 l-75 -7 0 953 0 953 63 -7 c34 -4 100 -16 147 -27z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladomitad"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	 
	if (typeObj == "electricidad-toma25a")
	{
		
		construc.push({'path': "M15 2001 c-6 -6 -9 -385 -7 -1002 l2 -992 84 6 c362 28 677 244 831 570 51 108 83 219 92 325 l6 72 93 0 94 0 2 -352 c3 -345 3 -353 23 -353 20 0 20 8 23 353 l2 352 155 0 155 0 0 -255 c0 -225 2 -256 16 -262 9 -3 20 0 25 8 5 8 9 125 9 262 l0 247 149 0 c111 0 151 3 160 13 24 29 -9 37 -161 37 l-148 0 0 248 c0 136 -4 253 -9 261 -5 8 -16 11 -25 8 -14 -6 -16 -37 -16 -262 l0 -255 -155 0 -155 0 0 344 c0 273 -3 346 -13 355 -34 27 -37 -6 -37 -356 l0 -343 -94 0 -93 0 -6 78 c-26 327 -241 641 -543 791 -105 52 -189 79 -304 96 -112 17 -143 18 -155 6z m237 -66 c375 -98 648 -390 713 -764 73 -415 -138 -827 -522 -1020 -85 -42 -222 -81 -316 -88 l-77 -6 0 953 0 953 73 -6 c39 -4 98 -13 129 -22z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladomitad"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "electricidad-interruptor")
	{
		
		construc.push({'path': "M426 1544 c-97 -23 -188 -78 -265 -159 -141 -149 -189 -337 -134 -535 48 -178 212 -336 399 -385 75 -19 193 -19 268 0 140 37 290 150 351 267 l28 54 374 -144 c206 -79 376 -142 379 -139 16 16 184 471 179 485 -12 31 -33 -11 -114 -222 -44 -114 -83 -211 -86 -214 -5 -5 -693 255 -708 268 -5 4 -3 27 4 51 20 72 16 213 -9 294 -56 182 -220 337 -404 380 -78 18 -184 18 -262 -1z m254 -35 c182 -42 341 -203 385 -391 49 -209 -42 -429 -229 -550 -164 -106 -389 -106 -552 0 -282 184 -323 565 -87 801 70 69 142 112 230 136 58 16 192 18 253 4z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladomitad"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "electricidad-cuadrogeneral")
	{
		
		construc.push({'path': "M257 1994 c-4 -4 -7 -155 -7 -336 l0 -328 -113 0 c-75 0 -117 -4 -125 -12 -18 -18 -17 -402 1 -417 10 -8 279 -12 953 -13 l939 -3 5 -438 c3 -281 9 -437 15 -437 6 0 12 156 15 437 l5 438 945 5 945 5 0 215 0 215 -122 3 -123 3 -2 332 c-3 287 -5 332 -18 332 -13 0 -15 -45 -18 -332 l-2 -333 -395 0 -395 0 0 335 c0 291 -2 335 -15 335 -13 0 -15 -44 -15 -335 l0 -335 -395 0 -395 0 0 335 c0 291 -2 335 -15 335 -13 0 -15 -44 -15 -335 l0 -335 -395 0 -395 0 -2 333 c-3 287 -5 332 -18 332 -13 0 -15 -45 -18 -332 l-2 -333 -395 0 -395 0 -2 332 c-3 316 -7 356 -31 332z m3543 -889 l0 -185 -1880 0 -1880 0 0 185 0 185 1880 0 1880 0 0 -185z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladomitad"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	
	if (typeObj == "electricidad-lamparapared")
	{
		
		construc.push({'path': "M1770 1424 c-242 -30 -498 -130 -683 -267 -113 -83 -253 -228 -327 -338 -147 -221 -220 -431 -245 -706 l-7 -73 -246 -2 c-212 -3 -247 -5 -247 -18 0 -13 218 -15 1905 -15 1687 0 1905 2 1905 15 0 13 -36 15 -251 18 l-251 2 -6 90 c-24 334 -167 641 -411 886 -201 201 -433 327 -704 384 -94 20 -349 34 -432 24z m405 -59 c237 -50 446 -150 625 -300 32 -27 58 -55 57 -61 -1 -7 -212 -224 -469 -483 l-467 -471 -470 472 c-258 260 -470 478 -472 483 -5 16 136 129 235 187 162 97 346 163 526 188 95 13 341 5 435 -15z m-685 -937 l384 -388 -663 0 -663 0 7 78 c26 304 148 596 336 805 l52 59 82 -84 c45 -45 254 -257 465 -470z m1452 498 c195 -229 314 -512 335 -796 l6 -90 -658 0 -657 0 458 464 c253 256 464 465 469 465 6 0 27 -19 47 -43z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "electricidad-cajaelectrica")
	{
		
		
		construc.push({'path': "M12 1378 c-17 -17 -17 -729 0 -746 9 -9 446 -12 1904 -12 1041 0 1899 3 1908 6 14 5 16 48 16 379 0 331 -2 374 -16 379 -9 3 -867 6 -1908 6 -1458 0 -1895 -3 -1904 -12z m3573 -34 c-20 -8 -1638 -314 -1663 -314 -29 0 -1654 309 -1661 315 -2 3 747 5 1665 4 918 0 1665 -2 1659 -5z m-2646 -173 c464 -89 848 -161 854 -161 41 0 -95 -27 -843 -170 -465 -88 -857 -163 -872 -166 l-28 -6 0 337 0 337 23 -5 c12 -3 402 -78 866 -166z m2861 -166 c0 -184 -3 -335 -6 -335 -11 0 -1749 332 -1751 334 -3 2 1722 334 1745 335 9 1 12 -72 12 -334z m-1042 -181 c449 -85 819 -157 821 -160 2 -2 -745 -3 -1660 -3 -915 1 -1655 4 -1644 7 50 13 1613 310 1638 311 15 1 395 -69 845 -155z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
	}
	  
	  
	if (typeObj == "electricidad-downlightled")
	{
		 
		construc.push({'path': "M854 1995 c-210 -32 -386 -120 -544 -272 -136 -129 -228 -286 -278 -473 -21 -82 -25 -116 -25 -245 0 -129 4 -163 25 -245 51 -189 143 -346 283 -478 219 -208 502 -305 791 -273 421 48 764 345 870 756 37 143 38 336 0 480 -101 394 -426 689 -826 750 -112 18 -186 18 -296 0z m391 -50 c124 -31 256 -96 358 -175 42 -34 77 -64 77 -68 0 -4 -152 -159 -338 -345 l-337 -337 -340 341 -340 340 40 36 c237 210 567 288 880 208z m-597 -1282 l-337 -337 -25 24 c-36 33 -117 153 -154 225 -45 90 -81 216 -94 327 -31 259 60 546 234 744 l31 36 341 -341 341 -341 -337 -337z m1131 926 c78 -102 135 -220 167 -345 22 -84 26 -121 26 -239 0 -170 -27 -289 -97 -430 -41 -82 -156 -245 -173 -245 -4 0 -158 151 -342 335 l-335 335 339 339 c187 187 343 338 347 335 4 -2 35 -41 68 -85z m-105 -1290 c-2 -4 -41 -35 -85 -68 -299 -226 -700 -261 -1029 -90 -83 43 -209 134 -217 156 -4 10 107 128 328 349 l334 334 337 -337 c185 -185 335 -340 332 -344z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "electricidad-tomatelevision")
	{
		
		
		construc.push({'path': "M515 1488 c-3 -7 -4 -229 -3 -493 l3 -480 493 -3 492 -2 0 495 0 495 -490 0 c-383 0 -492 -3 -495 -12z m965 -483 l0 -475 -470 0 -470 0 0 475 0 475 470 0 470 0 0 -475z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.push({'path': "M612 1158 c3 -21 9 -23 66 -26 l62 -3 0 -179 0 -180 30 0 30 0 0 180 0 180 60 0 c57 0 60 1 60 25 l0 25 -156 0 -155 0 3 -22z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.push({'path': "M1074 1108 c12 -40 42 -133 67 -205 l43 -133 32 0 c25 0 34 6 43 28 23 59 131 365 131 373 0 5 -13 9 -29 9 -28 0 -30 -2 -82 -165 -30 -90 -56 -164 -59 -164 -3 -1 -28 72 -55 162 l-50 162 -32 3 -32 3 23 -73z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	if (typeObj == "electricidad-tomadatos")
	{
		
		 
		construc.push({'path': "M510 1005 l0 -495 490 0 490 0 0 495 0 495 -490 0 -490 0 0 -495z m960 0 l0 -475 -470 0 -470 0 0 475 0 475 470 0 470 0 0 -475z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.push({'path': "M668 1183 l-28 -4 0 -205 0 -204 83 0 c146 0 221 45 246 146 48 189 -78 301 -301 267z m189 -69 c46 -34 65 -80 59 -148 -7 -95 -58 -142 -161 -153 l-55 -6 0 168 0 167 65 -4 c44 -3 74 -10 92 -24z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.push({'path': "M1130 1155 c0 -24 3 -25 60 -25 l60 0 0 -180 0 -180 30 0 30 0 0 180 0 180 60 0 c57 0 60 1 60 25 l0 25 -150 0 -150 0 0 -25z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "electricidad-lampara")
	{
		
		construc.push({'path': "M560 1437 c0 -7 95 -107 210 -222 l210 -210 -211 -211 c-166 -166 -210 -216 -205 -230 6 -15 48 23 224 199 l217 217 217 -217 c172 -171 221 -214 230 -205 10 10 -34 59 -205 230 l-217 217 215 215 c118 118 215 218 215 222 0 32 -63 -20 -245 -202 l-210 -210 -210 210 c-115 115 -215 210 -222 210 -7 0 -13 -6 -13 -13z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "electricidad-tomatelefono")
	{
		
		
		construc.push({'path': "M510 1005 l0 -495 493 2 492 3 0 490 0 490 -492 3 -493 2 0 -495z m960 0 l0 -475 -467 2 -468 3 -3 460 c-1 253 0 466 3 473 3 9 107 12 470 12 l465 0 0 -475z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.push({'path': "M650 1155 c0 -24 3 -25 60 -25 l60 0 0 -180 0 -180 30 0 30 0 0 180 0 179 63 3 c56 3 62 5 65 26 l3 22 -155 0 -156 0 0 -25z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.push({'path': "M1130 975 l0 -205 25 0 c25 0 25 1 25 90 l0 89 78 3 c71 3 77 5 80 25 3 21 -1 22 -75 25 l-78 3 0 65 0 65 83 3 c74 3 82 5 82 22 0 19 -7 20 -110 20 l-110 0 0 -205z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	  
	if (typeObj == "electricidad-tubofluorescente")
	{
		
		construc.push({'path': "M377 1323 c-4 -3 -7 -71 -7 -149 l0 -144 -177 -2 c-150 -3 -178 -5 -178 -18 0 -13 28 -15 177 -18 l177 -2 3 -148 3 -147 2520 0 2520 0 3 147 3 148 177 2 c149 3 177 5 177 18 0 13 -28 15 -177 18 l-177 2 -3 148 -3 147 -2516 3 c-1384 1 -2519 -1 -2522 -5z m5011 -315 l2 -288 -2490 0 -2490 0 0 290 0 290 2488 -2 2487 -3 3 -287z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});

		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	
	if (typeObj == "electricidad-telefonillo")  
	{
		construc.push({'path': "M515 1678 c-3 -7 -4 -312 -3 -678 l3 -665 490 0 490 0 0 675 0 675 -488 3 c-385 2 -489 0 -492 -10z m965 -668 l0 -650 -470 0 -470 0 0 650 0 650 470 0 470 0 0 -650z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.push({'path': "M822 1550 c-121 -80 -126 -87 -119 -203 4 -78 14 -122 67 -281 96 -293 185 -463 310 -597 45 -48 47 -49 106 -48 86 0 201 23 224 44 66 60 -59 365 -150 365 -14 0 -49 -16 -79 -35 l-53 -35 -19 22 c-39 44 -140 281 -163 379 -5 25 -3 27 56 40 69 14 108 44 108 82 0 46 -20 131 -44 182 -28 62 -104 145 -133 145 -11 0 -61 -27 -111 -60z m132 24 c18 -7 65 -73 97 -137 15 -29 22 -62 23 -111 1 -68 0 -71 -27 -84 -16 -8 -50 -17 -75 -21 -43 -6 -47 -8 -50 -37 -6 -66 122 -375 178 -429 l28 -27 45 31 c78 53 92 55 127 18 38 -40 75 -114 95 -191 20 -79 13 -103 -35 -116 -34 -9 -165 -29 -197 -30 -44 -1 -182 183 -259 345 -53 113 -151 402 -174 512 -16 77 -7 143 23 170 36 33 158 113 172 113 8 0 20 -3 29 -6z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	  
	if (typeObj == "fontaneria-aguafria")  
	{
		construc.push({'path': "M1035 2366 c-291 -49 -516 -172 -712 -388 -113 -124 -214 -313 -260 -485 -25 -90 -27 -113 -27 -293 0 -180 2 -203 27 -293 31 -118 106 -279 177 -381 57 -83 185 -214 275 -281 68 -51 231 -135 320 -164 233 -76 507 -76 740 0 89 29 252 113 320 164 90 67 218 198 275 281 71 102 146 263 177 381 25 90 27 113 27 293 0 180 -2 203 -27 293 -31 118 -106 279 -177 381 -57 83 -185 214 -275 281 -68 51 -231 135 -320 164 -162 53 -388 72 -540 47z m295 -37 c474 -58 850 -383 976 -844 26 -92 28 -114 28 -285 0 -171 -2 -193 -28 -285 -93 -338 -335 -622 -646 -756 -295 -127 -615 -127 -910 0 -311 134 -553 418 -646 756 -41 149 -41 421 0 570 151 550 678 913 1226 844z", 'stroke': "", 'strokeDashArray': typeObj+" fillazul escaladomitad"});
		
		construc.push({'path': "M1193 2018 c-6 -7 -28 -60 -49 -118 -73 -202 -267 -559 -363 -669 -64 -74 -111 -208 -111 -318 0 -256 177 -476 425 -528 88 -18 132 -18 220 0 248 52 425 272 425 528 0 110 -47 245 -110 317 -96 109 -290 467 -364 670 -42 116 -56 139 -73 118z", 'stroke': "", 'strokeDashArray': typeObj+" fillazul escaladomitad"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	
	if (typeObj == "fontaneria-aguafriacaliente")  
	{
		construc.push({'path': "M1009 2350 c-165 -30 -385 -124 -510 -219 -183 -139 -330 -344 -405 -563 -76 -226 -76 -510 0 -736 75 -219 222 -424 405 -563 90 -69 286 -163 406 -196 94 -26 112 -28 295 -27 179 0 203 2 293 26 413 112 731 434 835 845 l18 72 27 -97 c118 -423 462 -744 892 -833 123 -26 337 -26 460 0 362 75 660 309 820 644 325 679 -78 1484 -820 1638 -123 26 -337 26 -460 0 -430 -89 -774 -410 -892 -833 l-27 -97 -18 72 c-104 411 -425 735 -835 844 -83 22 -123 26 -268 29 -93 1 -191 -1 -216 -6z m473 -63 c388 -102 700 -414 805 -802 24 -92 27 -116 27 -285 0 -168 -3 -194 -26 -282 -106 -390 -415 -700 -803 -805 -91 -25 -116 -27 -285 -27 -172 -1 -192 1 -284 27 -425 118 -741 456 -821 880 -19 103 -19 311 0 414 87 461 453 818 924 903 25 5 118 7 206 6 133 -3 176 -8 257 -29z m2233 14 c645 -135 1040 -781 860 -1406 -182 -634 -854 -973 -1477 -745 -465 170 -772 664 -720 1158 52 495 404 888 892 992 118 26 325 26 445 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladomitad"});
		
		construc.push({'path': "M1180 1998 c-5 -13 -30 -77 -56 -143 -88 -227 -258 -531 -357 -640 -27 -29 -64 -112 -82 -180 -91 -354 227 -703 591 -647 289 45 494 322 446 604 -13 78 -66 203 -100 234 -76 72 -287 461 -365 673 -23 63 -48 116 -55 119 -6 2 -16 -7 -22 -20z", 'stroke': "", 'strokeDashArray': typeObj+" fillrojo escaladomitad"});
		
		construc.push({'path': "M3483 2008 c-6 -7 -28 -60 -49 -118 -73 -201 -273 -567 -359 -660 -31 -33 -79 -132 -94 -195 -17 -69 -15 -200 5 -265 56 -191 209 -335 399 -375 88 -18 132 -18 220 0 190 40 343 184 399 374 20 67 21 207 2 276 -15 56 -70 170 -87 181 -6 4 -47 61 -91 128 -94 142 -218 388 -272 536 -42 116 -56 139 -73 118z", 'stroke': "", 'strokeDashArray': typeObj+" fillazul escaladomitad"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}  
	  
	if (typeObj == "fontaneria-contadoragua")  
	{
		construc.push({'path': "M1090 1790 l0 -570 -542 -2 c-535 -3 -543 -3 -543 -23 0 -20 8 -20 543 -23 l542 -2 0 -565 0 -565 1835 0 1835 0 0 565 0 565 533 0 c541 0 563 1 550 36 -4 12 -95 14 -544 14 l-539 0 0 570 0 570 -1835 0 -1835 0 0 -570z m3630 -590 l0 -1120 -1795 0 -1795 0 0 1120 0 1120 1795 0 1795 0 0 -1120z", 'stroke': "", 'strokeDashArray': typeObj+" fillazul escaladomitad"});
		
		construc.push({'path': "M2830 2078 c-5 -13 -26 -68 -46 -123 -89 -245 -243 -535 -374 -709 -80 -106 -120 -224 -120 -360 0 -164 56 -303 170 -416 137 -137 337 -195 520 -151 250 60 439 302 440 562 0 128 -37 234 -128 368 -170 249 -291 483 -382 741 -39 109 -61 133 -80 88z", 'stroke': "", 'strokeDashArray': typeObj+" fillazul escaladomitad"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}   
	  
	if (typeObj == "fontaneria-llaves")  
	{
		construc.push({'path': "M365 1974 c-336 -459 -346 -474 -339 -485 3 -5 147 -9 320 -9 l314 0 0 -723 c0 -398 3 -727 7 -730 3 -4 12 -2 20 4 11 9 13 141 13 730 l0 719 312 2 c210 2 312 6 315 14 2 6 -139 204 -312 440 -237 322 -321 430 -338 431 -18 2 -70 -63 -312 -393z", 'stroke': "", 'strokeDashArray': typeObj+" fillrojo escaladomitad"});
		
		construc.push({'path': "M2016 1939 c-186 -252 -315 -437 -312 -445 4 -12 59 -14 316 -14 l310 0 0 -719 c0 -589 2 -721 13 -730 8 -6 17 -8 20 -4 4 3 7 332 7 730 l0 723 312 2 c269 3 313 5 315 18 5 23 -619 864 -643 868 -16 2 -84 -84 -338 -429z", 'stroke': "", 'strokeDashArray': typeObj+" fillazul escaladomitad"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	} 
	  
	if (typeObj == "gas-contador")
	{
		construc.push({'path': "M1092 2328 c-9 -9 -12 -146 -12 -560 l0 -548 -534 0 c-444 0 -535 -2 -539 -14 -13 -34 9 -36 545 -36 l528 0 0 -544 c0 -445 2 -546 14 -555 10 -8 497 -10 1837 -9 l1824 3 3 553 2 552 533 0 c292 0 538 4 546 9 8 5 11 16 8 25 -6 14 -60 16 -547 16 l-540 0 -2 558 -3 557 -1825 3 c-1412 1 -1829 -1 -1838 -10z m3628 -1128 l0 -1090 -1795 0 -1795 0 0 1090 0 1090 1795 0 1795 0 0 -1090z", 'stroke': "", 'strokeDashArray': typeObj+" fillnaranja escaladomitad"});
		
		construc.push({'path': "M2771 2028 c-5 -13 -28 -83 -51 -155 -51 -159 -80 -218 -191 -388 -164 -250 -181 -283 -217 -420 -29 -110 -36 -196 -23 -288 28 -200 154 -353 336 -409 110 -33 134 -20 87 45 -16 23 -43 70 -61 104 -29 58 -31 70 -31 167 l0 105 51 107 c28 59 53 122 56 141 3 18 9 36 14 38 14 10 72 -88 85 -143 17 -74 27 -81 59 -46 65 70 108 234 117 449 l3 60 44 -40 c24 -22 54 -56 67 -75 13 -19 35 -51 47 -70 13 -19 42 -78 65 -130 35 -83 41 -108 47 -197 13 -192 -26 -318 -134 -433 -88 -94 -82 -117 24 -93 98 23 180 66 243 130 120 122 153 207 155 408 2 108 -2 135 -37 280 -51 212 -108 323 -257 500 -88 105 -261 253 -354 304 -22 12 -58 33 -80 46 -49 30 -53 30 -64 3z", 'stroke': "", 'strokeDashArray': typeObj+" fillnaranja escaladomitad"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	  
	if (typeObj == "gas-llave")
	{
		construc.push({'path': "M346 1930 c-257 -350 -315 -434 -305 -446 9 -11 65 -14 315 -14 l304 0 2 -712 c3 -626 5 -713 18 -713 13 0 15 87 18 713 l2 712 304 0 c244 0 306 3 315 14 9 10 -55 103 -304 442 -178 242 -324 430 -333 432 -13 2 -102 -111 -336 -428z", 'stroke': "", 'strokeDashArray': typeObj+" fillnaranja escaladomitad"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	  
	if (typeObj == "gas-rejilla")
	{
		construc.push({'path': "M30 1200 l0 -210 1383 2 1382 3 0 205 0 205 -1382 3 -1383 2 0 -210z m485 0 l170 -170 -125 0 -125 0 -170 170 -170 170 125 0 125 0 170 -170z m300 0 l170 -170 -125 0 -125 0 -170 170 -170 170 125 0 125 0 170 -170z m300 0 l170 -170 -120 0 -120 0 -170 170 -170 170 120 0 120 0 170 -170z m310 0 l170 -170 -125 0 -125 0 -170 170 -170 170 125 0 125 0 170 -170z m300 0 l170 -170 -120 0 -120 0 -170 170 -170 170 120 0 120 0 170 -170z m310 0 l170 -170 -125 0 -125 0 -170 170 -170 170 125 0 125 0 170 -170z m300 0 l170 -170 -125 0 -125 0 -170 170 -170 170 125 0 125 0 170 -170z m283 27 c112 -113 142 -149 142 -170 l0 -27 -98 0 -97 0 -170 170 -170 170 126 0 125 0 142 -143z m142 33 c0 -60 -3 -110 -8 -110 -4 0 -57 50 -117 110 l-110 110 118 0 117 0 0 -110z m-2507 -228 l-116 -3 -34 33 -33 32 0 120 0 121 150 -150 150 -150 -117 -3z", 'stroke': "", 'strokeDashArray': typeObj+" fillnaranja escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	  
	if (typeObj == "climatizacion-radiadoragua")
	{
		
		construc.push({'path': "M2291 1784 c-101 -21 -204 -75 -275 -144 l-63 -60 -976 0 -977 0 0 -380 0 -380 976 0 976 0 56 -51 c65 -57 152 -108 232 -135 86 -29 262 -26 358 5 83 27 167 78 232 139 l43 42 115 0 114 0 62 -57 c217 -204 567 -203 793 1 l61 56 981 0 981 0 0 380 0 380 -979 0 -980 0 -57 55 c-101 96 -271 165 -403 165 -145 -1 -300 -62 -405 -161 l-64 -59 -107 0 -107 0 -66 61 c-139 130 -335 184 -521 143z m233 -39 c147 -31 264 -109 346 -231 74 -111 93 -184 89 -337 -4 -122 -4 -125 -46 -208 -72 -142 -166 -230 -311 -286 -59 -24 -81 -27 -187 -27 -103 0 -129 4 -185 25 -268 102 -419 377 -355 648 37 154 149 297 286 365 126 62 238 78 363 51z m1189 -10 c225 -68 380 -265 394 -500 10 -164 -43 -303 -161 -421 -190 -190 -473 -217 -698 -67 -159 105 -238 257 -238 458 0 146 42 267 119 344 12 12 21 25 21 30 0 15 120 102 177 128 114 53 269 64 386 28z m-2973 -535 l0 -340 -350 0 -350 0 0 340 0 340 350 0 350 0 0 -340z m750 0 l0 -340 -355 0 -355 0 0 340 0 340 355 0 355 0 0 -340z m395 270 c-50 -99 -68 -185 -62 -295 5 -101 32 -194 77 -267 l29 -48 -199 0 -200 0 0 340 0 340 195 0 195 0 -35 -70z m1085 13 c0 -31 -2 -54 -4 -52 -2 2 -15 28 -30 57 l-26 52 30 0 c30 0 30 0 30 -57z m90 53 c0 -2 -11 -24 -25 -47 l-25 -44 0 48 c0 44 2 47 25 47 14 0 25 -2 25 -4z m1390 -336 l0 -340 -201 0 c-110 0 -199 3 -197 8 77 152 98 223 98 330 0 95 -23 192 -64 275 l-34 67 199 0 199 0 0 -340z m750 0 l0 -340 -355 0 -355 0 0 340 0 340 355 0 355 0 0 -340z m740 0 l0 -340 -350 0 -350 0 0 340 0 340 350 0 350 0 0 -340z m-2970 -280 l0 -60 -34 0 -33 0 31 60 c17 33 32 60 34 60 1 0 2 -27 2 -60z m73 -12 l26 -48 -30 0 c-28 0 -29 1 -29 52 0 28 1 49 3 47 2 -2 15 -25 30 -51z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		
		construc.push({'path': "M2365 1538 c-44 -110 -81 -177 -146 -273 -64 -94 -79 -133 -79 -207 0 -149 128 -278 275 -278 93 0 204 69 247 153 47 92 31 225 -35 299 -57 64 -119 183 -197 376 -5 12 -14 22 -18 22 -5 0 -26 -42 -47 -92z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M2365 1538 c-44 -110 -81 -177 -146 -273 -64 -94 -79 -133 -79 -207 0 -149 128 -278 275 -278 93 0 204 69 247 153 47 92 31 225 -35 299 -57 64 -119 183 -197 376 -5 12 -14 22 -18 22 -5 0 -26 -42 -47 -92z", 'stroke': "", 'strokeDashArray': typeObj+" fillrojo escaladogeneral"});
		
		construc.push({'path': "M3544 1613 c-41 -119 -124 -281 -187 -364 -78 -103 -95 -183 -60 -285 33 -98 154 -184 257 -184 148 0 276 128 276 278 0 75 -15 114 -79 207 -56 80 -112 189 -151 290 -28 72 -45 90 -56 58z", 'stroke': "", 'strokeDashArray': typeObj+" fillazul escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	  
	if (typeObj == "climatizacion-radiadorelectrico")  
	{
		
		construc.push({'path': "M2883 1790 c-115 -21 -239 -87 -318 -169 l-39 -41 -1251 0 c-960 0 -1254 -3 -1263 -12 -17 -17 -17 -719 0 -736 9 -9 304 -12 1265 -12 l1253 0 40 -40 c218 -218 589 -225 809 -15 l58 55 1264 2 1264 3 0 375 0 375 -1259 3 -1259 2 -56 53 c-67 64 -129 101 -220 133 -78 27 -209 38 -288 24z m271 -60 c260 -81 428 -365 372 -630 -36 -173 -141 -311 -293 -388 -85 -42 -188 -66 -262 -60 l-42 3 161 260 c95 153 159 268 158 280 -3 18 -12 20 -85 23 l-83 3 0 254 c0 142 -4 256 -9 259 -5 4 -15 4 -23 1 -20 -9 -343 -526 -343 -550 0 -18 7 -20 83 -23 l82 -3 0 -249 0 -249 -42 13 c-73 23 -97 34 -156 75 -100 68 -172 163 -213 282 -30 86 -33 248 -5 329 47 136 113 227 221 299 147 98 311 123 479 71z m-2414 -530 l0 -340 -350 0 -350 0 0 340 0 340 350 0 350 0 0 -340z m750 0 l0 -340 -350 0 -350 0 0 340 0 340 350 0 350 0 0 -340z m730 0 l0 -340 -345 0 -345 0 0 340 0 340 345 0 345 0 0 -340z m244 288 c-94 -186 -98 -369 -10 -544 l42 -84 -113 0 -113 0 0 340 0 340 110 0 110 0 -26 -52z m1246 -288 l0 -340 -119 0 -119 0 39 78 c99 194 90 362 -29 595 -2 4 48 7 112 7 l116 0 0 -340z m740 0 l0 -340 -350 0 -350 0 0 340 0 340 350 0 350 0 0 -340z m740 0 l0 -340 -350 0 -350 0 0 340 0 340 350 0 350 0 0 -340z m740 0 l0 -340 -350 0 -350 0 0 340 0 340 350 0 350 0 0 -340z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	  
	if (typeObj == "climatizacion-rejilla")
	{
		
		construc.push({'path': "M2 1203 l3 -238 1569 -3 c1164 -1 1572 1 1583 9 11 10 13 56 11 238 l-3 226 -1583 3 -1582 2 2 -237z m548 2 l195 -195 -140 0 -140 0 -195 195 -195 195 140 0 140 0 195 -195z m350 0 l195 -195 -140 0 -140 0 -195 195 -195 195 140 0 140 0 195 -195z m350 0 l195 -195 -145 0 -145 0 -187 187 c-104 103 -188 191 -188 195 0 5 62 8 138 8 l137 0 195 -195z m349 0 l196 -195 -145 0 -145 0 -187 187 c-104 103 -188 191 -188 195 0 5 62 8 137 8 l137 0 195 -195z m341 0 l195 -195 -140 0 -140 0 -187 187 c-104 103 -188 191 -188 195 0 5 60 8 133 8 l132 0 195 -195z m350 0 l195 -195 -140 0 -140 0 -195 195 -195 195 140 0 140 0 195 -195z m350 0 l195 -195 -140 0 -140 0 -195 195 -195 195 140 0 140 0 195 -195z m313 29 c123 -126 163 -173 165 -195 l3 -29 -113 0 -113 0 -187 187 c-104 103 -188 191 -188 195 0 5 61 8 135 8 l135 0 163 -166z m167 31 l0 -135 -122 126 c-68 69 -124 130 -126 135 -2 5 51 9 122 9 l126 0 0 -135z m-2867 -253 l-136 -3 -34 33 -33 32 0 140 0 141 170 -170 170 -170 -137 -3z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "climatizacion-aire")
	{
		
		construc.push({'path': "M256 2265 c-97 -20 -172 -78 -216 -168 l-31 -63 0 -837 0 -838 24 -52 c29 -63 92 -128 155 -159 l47 -23 2755 0 2755 0 53 29 c60 34 111 85 144 148 l23 43 3 838 2 839 -26 57 c-32 72 -92 132 -165 166 l-56 25 -2708 3 c-1856 1 -2724 -1 -2759 -8z m5524 -66 c64 -33 112 -86 137 -152 8 -24 12 -251 12 -852 l1 -820 -24 -50 c-29 -64 -77 -112 -141 -141 l-50 -24 -2721 0 c-3017 0 -2769 -6 -2852 66 -23 19 -52 58 -67 87 l-25 53 0 827 c-1 789 0 830 18 870 27 62 75 112 134 141 l52 26 2731 0 2732 0 63 -31z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M1340 1732 c0 -10 18 -36 40 -57 l40 -39 0 -146 c0 -81 3 -149 6 -153 3 -3 12 -3 20 0 11 4 14 35 14 151 l0 146 47 48 c37 37 44 51 35 60 -9 9 -20 4 -50 -25 -21 -20 -42 -37 -48 -37 -6 0 -25 16 -44 35 -37 38 -60 45 -60 17z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M2890 1738 c0 -6 18 -33 40 -59 l40 -48 0 -139 c0 -105 3 -142 13 -151 8 -6 17 -8 20 -4 4 3 7 72 7 153 l0 146 45 44 c44 43 57 70 33 70 -7 0 -31 -18 -53 -40 l-41 -40 -39 40 c-39 40 -65 51 -65 28z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M4445 1740 c-4 -6 12 -31 34 -57 l41 -46 0 -142 c0 -107 3 -145 13 -154 8 -6 17 -8 20 -4 4 3 7 71 7 150 l0 144 45 48 c25 26 45 53 45 60 0 22 -25 11 -65 -29 l-41 -40 -39 40 c-41 42 -50 46 -60 30z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M1843 1572 c-7 -4 -18 -34 -25 -66 l-13 -59 -122 -76 c-81 -50 -123 -82 -123 -93 0 -10 5 -18 10 -18 6 0 66 34 133 76 l122 76 60 -10 c47 -8 63 -7 74 4 12 11 11 15 -13 24 -15 5 -37 10 -49 10 -43 0 -51 13 -38 64 12 49 4 80 -16 68z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M3392 1568 c-5 -7 -16 -38 -24 -68 l-13 -55 -110 -68 c-129 -80 -144 -92 -128 -108 9 -9 40 6 126 59 63 39 121 74 129 77 9 4 42 2 74 -4 41 -8 61 -8 68 0 16 15 -20 39 -58 39 -52 0 -58 9 -44 68 12 55 2 86 -20 60z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M4116 1562 c-2 -4 1 -29 7 -55 5 -26 8 -49 5 -52 -3 -3 -27 -11 -54 -18 -47 -12 -67 -30 -42 -40 8 -2 39 0 70 5 l55 10 122 -76 c68 -42 127 -76 132 -76 5 0 9 8 9 18 0 13 -37 42 -120 93 -128 78 -121 70 -144 172 -6 25 -29 37 -40 19z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M2554 1546 c-3 -9 -1 -36 5 -61 6 -24 11 -46 11 -48 0 -2 -25 -9 -55 -16 -34 -8 -55 -18 -55 -26 0 -23 14 -25 74 -11 l57 14 132 -73 c72 -41 135 -71 139 -69 24 15 -5 40 -121 104 l-130 71 -12 55 c-13 60 -34 88 -45 60z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M1003 1508 c3 -24 9 -51 12 -59 5 -12 -6 -18 -49 -28 -52 -12 -79 -34 -52 -44 7 -3 38 1 68 8 l56 13 133 -74 c73 -40 137 -71 141 -68 24 15 -4 39 -122 103 -138 76 -136 75 -152 166 -2 11 -12 21 -22 23 -17 4 -18 -1 -13 -40z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M4944 1523 c-3 -15 -9 -41 -13 -58 -6 -25 -23 -39 -116 -91 -134 -75 -164 -98 -149 -113 7 -8 48 9 145 63 l135 75 58 -15 c44 -11 62 -12 70 -4 16 16 -14 36 -65 44 l-41 7 6 37 c12 69 11 76 -6 80 -12 2 -19 -5 -24 -25z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M1573 1133 c-31 -11 -5 -33 112 -102 69 -40 128 -77 131 -83 4 -6 12 -34 18 -62 8 -33 17 -51 26 -51 15 0 18 27 9 89 -4 28 -1 31 40 43 54 15 69 29 54 44 -8 8 -26 6 -66 -7 l-55 -17 -54 30 c-29 17 -87 51 -128 75 -41 25 -81 43 -87 41z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M3123 1133 c-30 -11 -5 -33 117 -103 l129 -75 12 -53 c13 -57 35 -85 49 -63 4 7 2 35 -5 62 -7 27 -10 51 -7 52 4 2 28 10 54 17 47 12 68 34 43 44 -8 3 -38 -2 -69 -11 l-55 -15 -108 62 c-59 35 -117 69 -128 76 -11 6 -26 10 -32 7z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M4274 1063 l-129 -75 -59 17 c-41 11 -62 13 -70 5 -14 -14 2 -28 55 -43 42 -13 44 -15 40 -48 -8 -70 -6 -84 9 -84 10 0 20 20 30 59 l15 60 124 72 c68 40 128 79 133 87 20 37 -29 20 -148 -50z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M1173 1051 l-122 -79 -57 14 c-42 12 -60 12 -68 4 -15 -16 14 -36 64 -44 22 -3 40 -10 40 -14 0 -4 -5 -26 -10 -50 -12 -48 -1 -83 17 -60 6 7 17 37 25 65 13 52 13 52 136 132 109 72 148 111 109 111 -6 0 -67 -36 -134 -79z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M2725 1052 l-120 -79 -59 14 c-37 8 -63 10 -69 4 -16 -16 1 -28 54 -41 l51 -12 -8 -37 c-11 -58 -10 -75 7 -79 13 -2 20 11 30 55 l14 58 122 80 c78 51 122 86 123 98 0 9 -6 17 -12 17 -7 0 -67 -36 -133 -78z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M4667 1123 c-15 -15 -2 -27 117 -104 l124 -80 12 -52 c14 -57 27 -80 42 -71 9 6 4 78 -8 109 -3 7 15 16 50 24 58 13 75 26 59 42 -7 7 -32 5 -71 -4 l-61 -14 -121 78 c-123 80 -131 84 -143 72z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M1427 1044 c-4 -4 -7 -71 -7 -149 l0 -141 -40 -39 c-39 -38 -53 -75 -28 -75 7 0 29 16 49 36 l37 37 47 -38 c35 -29 49 -35 57 -27 9 9 1 24 -35 60 l-46 47 -3 144 c-3 135 -10 166 -31 145z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M2977 1044 c-4 -4 -7 -74 -7 -155 l0 -147 -40 -36 c-39 -35 -52 -66 -28 -66 7 0 29 16 49 36 l37 36 30 -20 c16 -12 35 -28 42 -37 15 -18 40 -20 40 -2 0 7 -20 33 -45 57 l-44 44 -3 145 c-3 135 -10 166 -31 145z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.push({'path': "M4527 1044 c-4 -4 -7 -73 -7 -153 l0 -145 -42 -43 c-33 -34 -39 -46 -30 -55 9 -9 20 -4 50 25 21 20 42 37 48 37 6 0 25 -16 44 -35 19 -19 40 -35 47 -35 27 0 12 34 -32 72 l-44 39 -3 146 c-3 137 -9 168 -31 147z", 'stroke': "", 'strokeDashArray': typeObj+" fillmorado escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	  
	if (typeObj == "electricidad-halogenoled")
	{
		
		construc.push({'path': "M887 1466 c-84 -25 -155 -67 -216 -130 -187 -196 -187 -466 1 -662 98 -102 225 -151 367 -141 303 21 510 322 421 610 -42 136 -155 257 -287 307 -73 28 -216 36 -286 16z m254 -35 c56 -18 169 -84 169 -100 0 -3 -68 -74 -150 -156 l-150 -150 -154 154 -155 155 32 24 c45 33 120 71 164 81 68 16 177 12 244 -8z m-303 -578 c-171 -171 -161 -168 -215 -75 -93 158 -79 368 33 501 l27 33 154 -154 153 -153 -152 -152z m536 404 c101 -147 101 -357 0 -504 l-37 -54 -154 153 -153 153 152 152 c84 84 153 153 154 153 1 0 18 -24 38 -53z m-209 -427 l150 -151 -25 -20 c-94 -74 -188 -104 -313 -96 -75 4 -99 10 -161 40 -40 20 -81 46 -91 57 -19 21 -18 22 130 170 83 83 152 150 155 150 3 0 73 -68 155 -150z", 'stroke': "", 'strokeDashArray': typeObj+" fillverde escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
	}
	  
	if (typeObj == "placa-gas60")
	{
		
		construc.push({'path': "M1366 3562 c-969 -1 -1343 -5 -1353 -13 -18 -16 -20 -3508 -1 -3527 17 -17 3529 -17 3546 0 19 19 17 3511 -2 3527 -17 14 -422 17 -2190 13z m1337 -81 c7 -54 47 -138 90 -187 42 -48 134 -99 205 -115 41 -8 52 -15 52 -30 0 -18 -8 -19 -119 -19 -93 0 -121 -3 -131 -15 -18 -21 -4 -24 130 -27 l115 -3 5 -120 c4 -98 8 -120 20 -120 12 0 15 22 18 123 l3 122 123 0 c67 0 126 3 129 7 4 3 2 12 -4 20 -8 9 -43 13 -130 13 -109 0 -119 2 -119 19 0 14 14 22 67 35 145 35 261 156 280 291 6 44 6 45 44 45 l39 0 0 -1735 0 -1735 -1740 0 -1740 0 0 1735 0 1735 1329 0 1328 0 6 -39z m693 -2 c-27 -167 -215 -296 -381 -262 -79 17 -124 41 -181 98 -35 34 -58 69 -72 108 -40 106 -70 97 309 97 l332 0 -7 -41z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M985 3269 c-2 -8 -6 -54 -7 -103 l-3 -90 -67 -12 c-195 -36 -376 -223 -395 -408 l-6 -56 -97 0 c-69 0 -101 -4 -109 -13 -18 -23 -2 -27 101 -27 70 0 100 -4 102 -12 2 -7 8 -38 14 -70 17 -93 58 -166 136 -244 78 -78 151 -119 244 -136 32 -6 63 -12 70 -14 8 -2 12 -32 12 -102 0 -103 4 -119 27 -101 9 8 13 40 13 110 l0 99 35 0 c50 0 148 35 209 74 111 72 197 198 220 325 l12 66 90 3 c108 3 121 6 104 27 -9 11 -35 15 -105 15 l-92 0 -7 60 c-15 133 -129 291 -257 355 -60 31 -139 55 -181 55 l-28 0 0 94 c0 71 -4 97 -15 106 -12 10 -16 10 -20 -1z m-5 -454 l0 -215 -216 0 -217 0 6 53 c8 68 66 184 120 240 71 72 198 136 275 137 l32 0 0 -215z m218 170 c41 -21 93 -57 122 -85 59 -60 118 -175 127 -247 l6 -53 -217 0 -216 0 0 216 0 217 53 -6 c29 -4 84 -22 125 -42z m-220 -642 l2 -213 -30 0 c-47 0 -148 38 -207 77 -50 33 -98 84 -136 144 -23 39 -57 143 -57 179 l0 30 213 -2 212 -3 3 -212z m469 166 c-13 -106 -90 -230 -185 -296 -62 -44 -162 -83 -212 -83 l-30 0 0 215 0 215 216 0 217 0 -6 -51z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2567 3274 c-4 -4 -7 -52 -7 -106 l0 -98 -28 0 c-90 0 -232 -70 -308 -152 -76 -83 -134 -208 -134 -290 l0 -28 -99 0 c-70 0 -102 -4 -110 -13 -18 -23 -2 -27 106 -27 l103 0 0 -28 c0 -42 28 -130 62 -194 63 -120 225 -232 352 -245 l56 -6 0 -102 c0 -106 4 -122 27 -104 9 8 13 40 13 110 l0 99 33 0 c90 0 202 54 290 139 85 82 138 188 149 296 l3 30 100 5 c80 4 100 8 100 20 0 12 -19 16 -102 18 l-103 3 0 33 c0 50 -33 149 -69 205 -74 115 -222 213 -342 227 l-58 7 -3 100 c-3 93 -11 120 -31 101z m-7 -459 l0 -215 -215 0 -215 0 0 23 c0 39 27 123 56 176 67 124 220 225 347 230 l27 1 0 -215z m215 171 c90 -45 134 -82 180 -152 40 -60 75 -156 75 -205 l0 -29 -215 0 -215 0 0 216 0 217 53 -6 c28 -4 83 -22 122 -41z m-215 -642 l0 -217 -52 6 c-73 9 -188 68 -248 127 -58 59 -117 173 -126 248 l-7 52 217 0 216 0 0 -216z m467 168 c-14 -118 -89 -238 -192 -307 -61 -40 -157 -75 -206 -75 l-29 0 0 215 0 215 216 0 217 0 -6 -48z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
		construc.push({'path': "M1648 2231 c-82 -27 -135 -61 -199 -127 -138 -146 -168 -346 -78 -531 33 -67 141 -174 210 -206 238 -112 514 -17 624 215 76 161 62 339 -39 476 -53 72 -104 113 -193 154 -60 29 -79 33 -168 35 -77 2 -113 -1 -157 -16z m292 -40 c351 -133 375 -622 38 -792 -257 -130 -571 33 -617 321 -35 217 108 431 324 487 68 17 187 10 255 -16z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
			
		construc.push({'path': "M1720 2084 c-6 -14 -10 -31 -10 -37 0 -20 -47 -115 -74 -150 -39 -51 -86 -160 -92 -213 -4 -27 -1 -69 6 -94 15 -57 84 -126 135 -136 52 -9 61 6 31 51 -31 44 -34 96 -10 155 18 44 35 48 44 10 15 -63 65 -2 76 92 4 32 9 58 12 58 9 0 33 -35 57 -85 39 -79 30 -161 -25 -231 -36 -44 -28 -60 23 -50 56 10 100 46 130 105 31 62 33 104 12 204 -25 121 -108 237 -219 309 -70 45 -83 47 -96 12z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M987 1693 c-4 -3 -7 -50 -7 -103 l0 -96 -65 -11 c-153 -26 -286 -126 -356 -267 -26 -54 -42 -101 -46 -139 l-6 -57 -97 0 c-69 0 -101 -4 -109 -13 -22 -27 9 -37 111 -37 l98 0 0 -28 c0 -87 62 -212 147 -296 78 -77 154 -114 296 -141 l27 -5 0 -99 c0 -102 4 -118 27 -100 9 8 13 39 13 105 l0 94 28 5 c92 20 122 29 170 50 61 28 158 117 201 184 34 54 71 157 71 201 l0 30 94 0 c65 0 97 4 105 13 21 26 -9 37 -106 37 l-93 0 0 28 c0 16 -7 53 -16 83 -55 185 -205 320 -389 352 l-65 11 0 92 c0 64 -4 95 -13 103 -8 6 -17 8 -20 4z m-7 -458 l0 -215 -216 0 -217 0 6 53 c13 111 110 253 214 314 51 30 146 62 186 62 l27 1 0 -215z m149 196 c84 -26 137 -60 199 -125 61 -64 108 -158 118 -233 l7 -53 -217 0 -216 0 0 215 0 215 24 0 c13 0 51 -8 85 -19z m-149 -671 l0 -210 -35 0 c-49 0 -139 33 -202 75 -97 64 -174 187 -190 301 l-6 44 217 0 216 0 0 -210z m470 185 c0 -43 -39 -146 -77 -203 -66 -98 -192 -178 -300 -189 l-53 -6 0 212 0 211 215 0 215 0 0 -25z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2567 1693 c-4 -3 -7 -50 -7 -103 l0 -96 -66 -11 c-131 -23 -253 -104 -326 -217 -40 -62 -78 -168 -78 -217 l0 -29 -99 0 c-70 0 -102 -4 -110 -13 -21 -27 9 -37 109 -37 l95 0 13 -67 c35 -186 196 -350 377 -384 33 -7 66 -13 73 -15 8 -2 12 -32 12 -102 0 -103 4 -119 27 -101 9 8 13 39 13 105 l0 94 28 5 c179 35 292 105 372 232 34 53 70 159 70 204 l0 29 94 0 c65 0 97 4 105 13 21 26 -9 37 -106 37 l-93 0 0 35 c0 90 -70 225 -157 307 -74 68 -206 128 -285 128 l-28 0 0 94 c0 66 -4 97 -13 105 -8 6 -17 8 -20 4z m-7 -458 l0 -215 -215 0 -215 0 0 23 c0 32 28 124 52 171 27 52 99 128 159 167 53 34 147 68 192 68 l27 1 0 -215z m153 195 c163 -50 295 -202 314 -359 l6 -51 -217 0 -216 0 0 215 0 215 24 0 c13 0 53 -9 89 -20z m-153 -670 l0 -210 -33 0 c-81 0 -227 75 -288 149 -42 51 -97 167 -105 224 l-6 47 216 0 216 0 0 -210z m470 182 c0 -42 -35 -138 -71 -194 -64 -100 -194 -184 -302 -195 l-57 -6 0 212 0 211 215 0 215 0 0 -28z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1635 666 c-69 -31 -115 -110 -115 -198 0 -101 65 -169 147 -153 118 22 137 195 25 235 -37 13 -45 12 -77 -3 -47 -22 -48 -2 -2 47 24 25 46 37 75 42 32 5 42 11 42 25 0 15 -7 19 -32 19 -18 -1 -46 -7 -63 -14z m49 -167 c21 -16 26 -29 26 -64 0 -35 -5 -48 -27 -64 -41 -33 -96 -7 -108 50 -9 40 2 67 33 84 36 19 45 19 76 -6z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1850 652 c-66 -67 -67 -230 -2 -303 36 -40 86 -47 130 -19 44 27 65 79 65 165 1 128 -36 185 -120 185 -36 0 -50 -6 -73 -28z m116 -33 c15 -16 20 -40 22 -103 4 -91 -6 -128 -41 -151 -43 -28 -77 6 -92 92 -20 125 50 229 111 162z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
	}  
	  
	if (typeObj == "placa-gas40")
	{
		
		construc.push({'path': "M770 3560 l-765 -5 0 -1770 0 -1770 1179 -3 c863 -1 1182 1 1192 9 20 16 21 3527 1 3534 -20 8 -782 10 -1607 5z m754 -81 c23 -141 148 -268 296 -300 39 -8 50 -15 50 -30 0 -17 -10 -19 -122 -21 -101 -3 -123 -6 -123 -18 0 -12 21 -15 122 -18 l122 -3 3 -122 c3 -101 6 -122 18 -122 12 0 15 21 18 122 l3 122 127 3 c105 3 127 6 127 18 0 12 -22 15 -127 18 -118 2 -128 4 -128 21 0 15 12 22 52 30 162 35 264 141 302 314 6 24 11 27 46 27 l40 0 0 -1735 0 -1735 -1155 0 -1155 0 0 1735 0 1735 739 0 738 0 7 -41z m694 -1 c-15 -70 -46 -123 -99 -173 -72 -67 -126 -89 -224 -90 -71 0 -88 4 -147 33 -97 47 -166 136 -183 235 l-7 37 335 0 335 0 -10 -42z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1185 3269 c-2 -8 -6 -54 -7 -103 l-3 -90 -67 -12 c-198 -37 -378 -225 -395 -414 l-6 -60 -102 0 c-106 0 -122 -4 -104 -27 8 -9 40 -13 109 -13 l97 0 6 -52 c13 -110 108 -256 213 -329 54 -37 133 -68 197 -77 l52 -7 5 -105 c4 -84 8 -105 20 -105 12 0 16 20 18 108 l3 107 37 0 c50 0 159 40 213 78 55 38 119 105 152 159 32 51 67 152 67 192 l0 30 103 3 c83 2 102 6 102 18 0 12 -19 16 -101 18 l-101 3 -6 60 c-17 192 -215 393 -407 415 l-60 7 0 92 c0 70 -4 96 -15 105 -12 10 -16 10 -20 -1z m-5 -459 l0 -220 -216 0 -217 0 6 57 c8 73 63 187 120 246 71 72 198 136 275 137 l32 0 0 -220z m218 175 c41 -21 93 -57 122 -85 62 -63 119 -176 127 -253 l6 -57 -217 0 -216 0 0 221 0 222 53 -6 c29 -4 84 -22 125 -42z m-218 -645 l0 -210 -30 0 c-49 0 -148 38 -210 80 -91 62 -172 189 -186 293 l-7 47 217 0 216 0 0 -210z m466 163 c-7 -56 -62 -172 -105 -224 -60 -72 -210 -149 -291 -149 l-30 0 0 210 0 210 216 0 217 0 -7 -47z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1187 1683 c-4 -3 -7 -47 -7 -98 l0 -91 -65 -11 c-153 -26 -286 -126 -355 -267 -29 -57 -43 -101 -48 -146 l-7 -65 -95 -3 c-114 -3 -127 -6 -110 -27 9 -11 36 -15 109 -15 l96 0 11 -58 c16 -83 60 -169 117 -230 28 -28 54 -52 58 -52 17 0 9 37 -11 55 -37 34 -93 127 -112 187 -32 106 -49 98 197 98 l215 0 0 -110 c0 -103 1 -110 20 -110 19 0 20 7 20 110 l0 110 215 0 c246 0 229 8 197 -98 -20 -62 -74 -151 -117 -192 -24 -23 -34 -60 -16 -60 5 0 34 27 64 60 63 67 105 148 121 232 l10 57 101 3 c81 2 100 6 100 18 0 12 -20 16 -100 20 l-100 5 -7 65 c-15 139 -128 299 -256 364 -58 29 -146 56 -184 56 l-28 0 0 89 c0 62 -4 92 -13 100 -8 6 -17 8 -20 4z m-9 -455 l-3 -223 -214 -3 -214 -2 6 61 c11 119 104 261 214 326 51 30 146 62 186 62 l27 1 -2 -222z m153 202 c124 -38 217 -117 275 -236 24 -48 37 -91 41 -133 l6 -61 -217 0 -216 0 0 225 0 225 24 0 c13 0 52 -9 87 -20z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
		construc.push({'path': "M1008 568 c-43 -62 -78 -123 -78 -135 0 -22 3 -23 80 -23 l80 0 0 -45 c0 -41 2 -45 25 -45 23 0 25 4 25 45 0 41 2 45 25 45 20 0 25 5 25 25 0 20 -5 25 -25 25 l-25 0 0 110 0 110 -27 0 c-24 -1 -39 -16 -105 -112z m82 -33 l0 -75 -50 0 c-27 0 -50 2 -50 5 0 3 20 33 45 67 25 34 45 66 45 70 0 4 2 8 5 8 3 0 5 -34 5 -75z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
			
		construc.push({'path': "M1277 660 c-41 -32 -60 -98 -55 -183 5 -82 25 -125 68 -151 57 -33 121 -9 151 57 40 90 17 256 -40 287 -33 17 -96 12 -124 -10z m115 -60 c36 -71 17 -214 -32 -240 -63 -34 -112 95 -80 212 22 77 81 92 112 28z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
	}   
	  
	if (typeObj == "placa-gas-horno")
	{
		
		construc.push({'path': "M11 4016 c-8 -10 -10 -478 -9 -1772 l3 -1759 1775 0 1775 0 0 1770 0 1770 -1766 3 c-1479 2 -1768 0 -1778 -12z m1933 -42 c3 -9 6 -22 6 -29 0 -8 9 -39 21 -70 40 -108 165 -211 280 -230 29 -5 39 -11 39 -26 0 -18 -8 -19 -119 -19 -87 0 -122 -4 -130 -13 -6 -8 -8 -17 -4 -20 3 -4 62 -7 130 -7 l123 0 0 -54 c0 -53 -1 -56 -55 -107 -70 -66 -133 -187 -142 -272 l-6 -57 -96 0 c-101 0 -131 -10 -110 -37 8 -9 40 -13 110 -13 l99 0 0 -29 c0 -45 36 -151 70 -204 67 -106 208 -205 315 -222 93 -15 85 -4 85 -114 0 -102 4 -118 27 -100 9 8 13 39 13 105 l0 94 28 5 c77 15 122 28 170 50 61 28 170 129 206 189 31 53 66 157 66 196 l0 30 93 0 c97 0 127 11 106 37 -8 9 -40 13 -105 13 l-94 0 0 28 c0 16 -7 53 -16 83 -54 183 -206 321 -388 352 l-66 11 0 92 c0 51 -4 95 -9 98 -5 4 11 35 35 71 29 45 47 85 56 127 l13 62 6 -46 c20 -140 136 -260 289 -300 l65 -17 -126 0 c-69 -1 -129 -4 -132 -8 -4 -3 -2 -12 4 -20 8 -9 43 -13 130 -13 112 0 119 -1 119 -20 0 -19 -7 -20 -119 -20 -87 0 -122 -4 -130 -13 -6 -8 -8 -17 -4 -20 3 -4 62 -7 129 -7 l123 0 3 -97 c2 -79 6 -98 18 -98 12 0 16 19 18 98 l3 97 123 0 c67 0 126 3 129 7 4 3 2 12 -4 20 -8 9 -43 13 -130 13 -112 0 -119 1 -119 20 0 19 7 20 119 20 87 0 122 4 130 13 6 8 8 17 4 20 -3 4 -63 7 -132 8 -121 1 -124 2 -76 14 126 31 215 98 265 199 18 35 34 82 37 105 6 40 7 41 44 41 l39 0 0 -1735 0 -1735 -1740 0 -1740 0 0 1735 0 1735 949 0 c856 0 949 -2 955 -16z m702 -21 c-18 -100 -93 -195 -194 -244 -71 -35 -196 -34 -273 2 -32 15 -75 45 -97 67 -41 41 -86 125 -96 180 l-5 32 335 0 336 0 -6 -37z m754 17 c0 -41 -43 -131 -86 -179 -26 -29 -69 -62 -102 -78 -49 -24 -69 -28 -142 -28 -72 0 -93 4 -141 27 -99 49 -174 145 -186 238 l-6 40 332 0 c322 0 331 -1 331 -20z m-840 -310 l0 -60 -115 0 c-103 0 -115 2 -115 18 0 13 17 21 72 34 39 10 88 29 107 42 20 14 39 25 44 25 4 1 7 -26 7 -59z m-6 -109 c3 -5 -17 -12 -45 -15 -44 -6 -86 -19 -161 -51 -15 -6 -18 -2 -18 27 0 19 3 38 7 41 10 10 211 8 217 -2z m6 -266 l0 -215 -216 0 -217 0 6 53 c8 65 64 179 114 232 l38 40 5 -40 c3 -27 10 -40 20 -40 11 0 16 14 18 58 3 55 4 58 43 77 43 22 131 48 167 49 l22 1 0 -215z m135 200 c154 -40 280 -166 321 -320 8 -27 14 -60 14 -72 l0 -23 -215 0 -215 0 0 215 c0 245 -9 227 95 200z m-135 -676 l0 -212 -57 6 c-108 11 -238 95 -303 197 -33 52 -70 154 -70 196 l0 24 215 0 215 0 0 -211z m470 186 c0 -43 -39 -146 -77 -203 -65 -97 -182 -172 -298 -190 l-55 -9 0 214 0 213 215 0 215 0 0 -25z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M977 3744 c-4 -4 -7 -51 -7 -104 l0 -96 -64 -11 c-198 -34 -365 -200 -399 -397 l-11 -66 -97 0 c-68 0 -100 -4 -108 -13 -21 -27 9 -37 109 -37 l95 0 12 -60 c25 -133 108 -254 225 -330 50 -33 111 -54 210 -75 l27 -5 3 -103 c2 -83 6 -102 18 -102 12 0 16 19 18 102 3 113 -2 106 84 118 73 10 183 70 248 135 68 68 126 178 138 260 l7 55 100 5 c92 5 100 7 100 25 0 18 -8 20 -100 25 l-100 5 -7 50 c-29 203 -196 372 -403 408 l-64 11 -3 100 c-3 92 -11 119 -31 100z m-7 -459 l0 -215 -215 0 c-245 0 -227 -9 -200 95 39 149 167 279 315 319 30 8 65 15 78 15 l22 1 0 -215z m153 195 c109 -34 196 -102 261 -203 26 -41 56 -135 56 -174 l0 -33 -215 0 -215 0 0 215 0 215 24 0 c13 0 53 -9 89 -20z m-153 -674 l0 -213 -47 8 c-180 29 -323 158 -369 334 -25 92 -42 85 201 85 l215 0 0 -214z m467 162 c-21 -170 -190 -338 -369 -366 l-58 -9 0 214 0 213 216 0 217 0 -6 -52z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1663 2705 c-79 -22 -131 -51 -196 -114 -100 -95 -147 -202 -147 -336 0 -189 105 -348 285 -432 55 -26 70 -28 180 -28 118 0 121 1 198 37 157 75 256 219 265 386 3 48 -1 109 -8 141 -25 113 -106 227 -210 293 -99 63 -249 85 -367 53z m198 -25 c333 -62 471 -467 245 -717 -244 -269 -684 -135 -748 227 -30 175 70 369 234 449 96 47 173 59 269 41z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1720 2554 c-6 -14 -10 -31 -10 -37 0 -19 -47 -115 -74 -150 -13 -17 -41 -66 -60 -107 -28 -58 -36 -86 -36 -130 1 -62 19 -121 47 -152 41 -46 143 -77 143 -44 0 8 -4 17 -10 21 -5 3 -17 29 -26 58 -16 51 -16 54 6 105 12 29 26 52 30 52 5 0 13 -13 19 -30 5 -16 16 -30 24 -30 19 0 47 69 54 132 5 45 7 47 23 33 9 -8 27 -36 41 -62 42 -83 28 -194 -30 -247 -24 -21 -27 -42 -8 -49 17 -6 105 28 129 50 54 49 75 133 58 233 -23 138 -109 264 -237 346 -63 41 -71 42 -83 8z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M977 2163 c-4 -3 -7 -50 -7 -103 l0 -96 -62 -12 c-204 -38 -370 -205 -402 -404 l-10 -68 -102 0 c-105 0 -121 -4 -103 -27 8 -9 39 -13 108 -13 l96 0 13 -66 c26 -135 131 -279 252 -343 48 -26 162 -60 202 -61 4 0 9 -46 10 -102 2 -84 6 -103 18 -103 12 0 16 19 18 101 l3 102 61 11 c202 35 378 210 405 401 l8 55 100 5 c80 4 100 8 100 20 0 12 -19 16 -97 18 -108 3 -101 -2 -113 85 -3 26 -24 83 -46 126 -68 137 -198 235 -349 262 l-70 12 0 92 c0 65 -4 96 -13 104 -8 6 -17 8 -20 4z m-7 -463 l0 -220 -216 0 -217 0 7 51 c24 178 162 331 341 375 93 23 85 42 85 -206z m135 205 c169 -45 315 -206 332 -368 l6 -57 -217 0 -216 0 0 220 c0 251 -9 232 95 205z m-135 -681 l0 -216 -32 7 c-128 25 -227 79 -291 157 -46 56 -94 159 -102 221 l-7 47 216 0 216 0 0 -216z m467 165 c-22 -181 -188 -340 -389 -374 l-38 -6 0 216 0 215 216 0 217 0 -6 -51z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2567 2163 c-4 -3 -7 -50 -7 -103 l0 -97 -67 -12 c-200 -37 -358 -192 -394 -387 -7 -32 -13 -65 -15 -71 -2 -9 -32 -13 -102 -13 -103 0 -119 -4 -101 -27 8 -9 40 -13 110 -13 l99 0 0 -29 c0 -51 39 -157 81 -219 72 -110 191 -187 324 -212 l64 -12 3 -102 c2 -82 6 -101 18 -101 12 0 16 19 18 101 l3 102 66 12 c132 25 261 113 333 226 34 54 70 160 70 205 l0 28 103 3 c83 2 102 6 102 18 0 12 -20 16 -100 20 l-100 5 -7 47 c-30 213 -190 380 -400 419 l-68 12 0 93 c0 64 -4 95 -13 103 -8 6 -17 8 -20 4z m-9 -460 l-3 -218 -214 -3 -214 -2 6 57 c17 165 167 327 342 369 94 23 86 42 83 -203z m179 187 c94 -33 182 -107 236 -201 29 -50 57 -139 57 -181 l0 -28 -215 0 -215 0 0 221 0 221 43 -7 c23 -4 65 -15 94 -25z m-177 -659 c0 -116 -3 -212 -8 -215 -15 -9 -107 15 -167 43 -74 35 -142 94 -185 161 -33 52 -70 154 -70 196 l0 24 215 0 215 0 0 -209z m470 186 c0 -37 -29 -128 -57 -175 -69 -120 -191 -202 -335 -227 l-38 -6 0 216 0 215 215 0 215 0 0 -23z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1635 1131 c-77 -35 -115 -102 -115 -199 0 -116 89 -184 179 -138 37 20 51 39 61 81 22 97 -54 171 -143 140 -32 -11 -37 -11 -37 2 0 27 67 81 110 88 30 5 40 11 40 26 0 25 -41 25 -95 0z m59 -173 c24 -34 20 -85 -9 -113 -37 -38 -76 -32 -100 16 -33 63 -5 119 59 119 25 0 39 -7 50 -22z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1850 1122 c-16 -16 -34 -49 -40 -73 -15 -56 -8 -164 14 -207 22 -42 72 -67 118 -58 66 12 98 74 98 188 0 117 -40 178 -118 178 -35 0 -49 -6 -72 -28z m122 -52 c31 -60 22 -191 -14 -230 -59 -63 -123 44 -104 174 15 95 83 128 118 56z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M504 349 c-3 -6 -2 -15 3 -20 5 -5 531 -8 1309 -7 1147 3 1299 5 1299 18 0 13 -152 15 -1302 18 -932 1 -1304 -1 -1309 -9z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M900 155 c-40 -47 -75 -85 -79 -85 -4 0 -39 36 -76 80 -43 51 -75 80 -86 78 -19 -3 -169 -177 -169 -195 0 -33 41 -6 100 67 36 44 68 80 71 80 3 0 38 -38 78 -85 41 -47 77 -85 82 -85 5 0 41 38 81 85 39 47 74 85 77 84 3 0 39 -39 79 -85 41 -46 77 -84 81 -84 4 0 41 39 81 86 l74 87 30 -34 c17 -19 52 -58 77 -87 29 -34 51 -51 60 -47 8 4 43 42 79 86 36 43 67 79 70 79 3 0 38 -38 78 -85 41 -47 78 -85 82 -85 5 0 41 38 81 85 39 47 73 85 75 85 1 0 35 -38 75 -85 39 -47 75 -85 80 -85 4 0 40 37 80 82 40 46 75 84 79 86 3 1 38 -36 78 -83 40 -47 76 -85 81 -85 5 0 41 38 81 85 40 47 75 85 79 85 3 -1 37 -39 76 -85 38 -47 73 -85 77 -85 4 0 24 19 46 42 21 24 56 63 78 87 l40 43 73 -86 c40 -47 77 -86 81 -86 4 0 10 7 14 15 6 17 -147 205 -168 205 -10 0 -97 -90 -156 -163 -3 -4 -37 31 -76 78 -38 47 -76 85 -85 85 -9 0 -46 -36 -84 -80 -38 -44 -72 -80 -76 -80 -5 0 -38 36 -75 80 -37 44 -74 80 -83 79 -9 0 -47 -36 -84 -80 -38 -43 -72 -79 -75 -79 -4 0 -38 36 -75 80 -38 44 -74 80 -82 80 -7 0 -43 -36 -80 -80 -37 -44 -70 -80 -75 -80 -4 0 -39 36 -76 80 -38 44 -76 80 -85 80 -8 0 -46 -38 -85 -85 -52 -63 -72 -81 -80 -72 -6 7 -41 47 -79 90 l-69 79 -41 -44 c-22 -23 -57 -63 -78 -88 l-37 -45 -38 40 c-20 22 -53 59 -73 81 -20 23 -41 44 -47 48 -5 3 -42 -32 -82 -79z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
	}  
	  
	  
	  
	if (typeObj == "placa-electrica80")
	{
		
		construc.push({'path': "M12 3548 c-17 -17 -17 -3519 0 -3536 17 -17 4699 -17 4716 0 17 17 17 3519 0 3536 -17 17 -4699 17 -4716 0z m3862 -45 c2 -10 8 -34 11 -53 26 -127 163 -255 296 -276 33 -6 39 -10 39 -30 0 -24 0 -24 -119 -24 -87 0 -122 -4 -130 -13 -6 -8 -8 -17 -4 -20 3 -4 62 -7 130 -7 l123 0 0 -113 c0 -117 9 -148 37 -126 9 8 13 43 13 125 l0 114 118 0 c65 0 122 3 125 7 4 3 2 12 -4 20 -8 9 -42 13 -125 13 -113 0 -114 0 -114 24 0 20 6 25 44 30 66 10 158 60 206 112 48 52 87 130 96 191 6 42 7 43 45 43 l39 0 0 -1740 0 -1740 -2325 0 -2325 0 0 1740 0 1740 1909 0 c1810 0 1910 -1 1915 -17z m706 -3 c0 -41 -43 -131 -85 -177 -23 -27 -67 -62 -97 -78 -48 -27 -61 -30 -148 -30 -81 0 -103 4 -145 24 -93 46 -166 140 -184 236 l-8 45 333 0 c325 0 334 -1 334 -20z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M871 3054 c-85 -23 -165 -71 -231 -140 -185 -193 -185 -485 0 -678 198 -207 512 -207 710 0 188 195 187 484 -2 680 -125 130 -309 183 -477 138z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M3643 3056 c-246 -60 -414 -311 -373 -555 68 -402 553 -559 838 -273 98 98 142 209 142 353 0 314 -300 549 -607 475z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2229 2251 c-139 -45 -244 -135 -306 -267 -33 -70 -37 -86 -41 -183 -4 -90 -1 -116 18 -171 31 -91 61 -138 133 -207 102 -98 201 -137 342 -136 277 3 487 215 487 493 0 224 -149 418 -367 476 -70 19 -198 17 -266 -5z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M876 1469 c-72 -17 -167 -72 -227 -130 -189 -187 -197 -487 -19 -683 193 -210 510 -218 711 -17 198 198 198 505 0 700 -62 60 -154 112 -231 130 -54 13 -180 12 -234 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M3619 1461 c-89 -29 -156 -71 -219 -137 -105 -113 -152 -257 -131 -402 52 -353 438 -538 745 -358 68 40 153 137 193 222 32 67 37 87 41 173 5 106 -9 174 -53 261 -54 106 -172 203 -293 240 -82 25 -205 26 -283 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2184 670 c-55 -22 -72 -103 -31 -144 l24 -24 -29 -23 c-19 -15 -31 -37 -35 -60 -17 -112 179 -152 232 -48 21 40 12 82 -25 113 l-29 24 25 23 c17 16 24 33 24 60 0 68 -81 109 -156 79z m87 -40 c26 -14 25 -64 -2 -89 -33 -31 -89 0 -89 50 0 42 47 62 91 39z m-8 -161 c12 -7 25 -17 29 -23 13 -19 9 -64 -8 -80 -20 -21 -73 -20 -96 1 -26 23 -24 78 4 97 27 19 42 20 71 5z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2456 659 c-45 -36 -60 -76 -60 -164 0 -149 74 -222 173 -170 88 45 94 283 8 335 -42 26 -88 25 -121 -1z m93 -36 c43 -35 46 -209 5 -254 -27 -30 -61 -24 -84 14 -38 61 -22 232 22 250 23 10 36 7 57 -10z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		

        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
	}
	  
	if (typeObj == "fregadero80")
	{
		
		construc.push({'path': "M12 3548 c-17 -17 -17 -3519 0 -3536 19 -19 4701 -17 4717 2 8 10 10 482 9 1777 l-3 1764 -2355 3 c-1824 1 -2359 -1 -2368 -10z m4686 -1765 l-3 -1738 -2322 -3 -2323 -2 0 1740 0 1740 2325 0 2325 0 -2 -1737z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M2325 3416 c-87 -39 -114 -143 -55 -210 40 -45 86 -61 138 -47 87 24 128 123 82 198 -36 60 -107 86 -165 59z m118 -67 c33 -36 35 -76 6 -113 -30 -38 -64 -49 -105 -36 -83 28 -86 146 -4 179 36 15 71 5 103 -30z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M397 3089 c-83 -22 -162 -94 -193 -175 -18 -47 -19 -96 -19 -1274 0 -1178 1 -1227 19 -1274 24 -63 77 -121 140 -154 l51 -27 1960 -3 c2210 -3 2026 -9 2118 76 96 90 88 -40 88 1382 0 1202 -1 1253 -19 1293 -23 51 -106 130 -153 146 -26 8 -548 12 -2002 14 -1082 1 -1977 -1 -1990 -4z m3990 -56 c47 -22 101 -77 119 -120 12 -28 14 -231 14 -1274 0 -1388 6 -1273 -72 -1351 -73 -73 81 -68 -2093 -66 l-1950 3 -40 21 c-55 30 -94 70 -119 124 -21 45 -21 46 -21 1265 0 1008 2 1227 14 1259 25 71 103 140 174 155 15 3 908 5 1983 4 1816 -3 1958 -4 1991 -20z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1850 1800 c-215 -38 -374 -214 -388 -431 -8 -136 32 -249 125 -349 178 -193 470 -198 665 -12 55 52 118 154 118 191 1 9 16 -17 35 -57 140 -298 527 -363 755 -126 259 269 123 704 -244 780 -204 43 -416 -64 -509 -256 l-33 -69 -14 37 c-52 145 -200 265 -360 291 -72 12 -85 12 -150 1z m264 -74 c172 -84 270 -271 239 -452 -25 -142 -117 -266 -242 -326 -57 -28 -80 -33 -163 -36 -147 -6 -248 35 -343 140 -210 234 -110 599 193 699 44 15 78 18 150 15 82 -3 101 -7 166 -40z m890 6 c224 -105 318 -363 211 -579 -45 -92 -114 -161 -202 -205 -65 -32 -72 -33 -183 -33 -108 0 -119 2 -181 31 -221 105 -314 353 -214 572 51 111 144 194 262 233 90 30 220 22 307 -19z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1899 1623 c-18 -57 -81 -179 -133 -257 -67 -103 -73 -173 -22 -261 77 -131 270 -135 360 -7 25 35 31 55 34 110 3 74 4 72 -86 214 -29 46 -67 118 -84 161 -18 42 -37 77 -44 77 -7 0 -18 -17 -25 -37z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2804 1643 c-20 -56 -63 -146 -98 -203 -101 -165 -116 -221 -77 -305 38 -84 107 -129 196 -129 129 0 215 87 215 216 0 57 -7 74 -84 194 -28 42 -65 113 -83 158 -32 80 -57 105 -69 69z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2206 680 c-74 -22 -102 -102 -52 -149 l23 -22 -35 -35 c-30 -30 -34 -39 -29 -71 8 -44 29 -69 74 -84 100 -33 201 57 159 140 -9 17 -25 35 -36 41 -18 10 -18 11 6 35 33 33 33 87 -1 120 -13 14 -31 25 -39 25 -8 0 -20 2 -28 4 -7 2 -26 0 -42 -4z m62 -46 c39 -27 19 -104 -27 -104 -55 0 -82 74 -39 104 12 9 27 16 33 16 6 0 21 -7 33 -16z m0 -164 c26 -16 32 -26 32 -54 0 -25 -7 -39 -22 -50 -48 -34 -108 -7 -108 47 0 37 7 49 35 65 26 15 25 15 63 -8z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2480 677 c-70 -24 -108 -150 -77 -258 22 -73 55 -104 112 -104 47 0 76 19 103 70 23 43 22 189 -1 232 -30 56 -81 79 -137 60z m66 -45 c38 -25 51 -181 20 -240 -28 -55 -88 -44 -107 18 -17 57 -8 184 15 209 19 21 51 27 72 13z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
	}  
	  
	  
	if (typeObj == "fregadero60")
	{
		
		construc.push({'path': "M7 3553 c-4 -3 -7 -799 -7 -1768 0 -1356 3 -1764 12 -1773 17 -17 3529 -17 3546 0 17 17 17 3519 0 3536 -9 9 -418 12 -1778 12 -972 0 -1770 -3 -1773 -7z m3513 -1773 l0 -1740 -1737 2 -1738 3 -3 1738 -2 1737 1740 0 1740 0 0 -1740z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M1730 3422 c-134 -67 -88 -252 64 -252 43 0 53 4 87 39 35 34 39 44 39 87 0 61 -25 105 -73 127 -45 22 -73 21 -117 -1z m128 -57 c52 -61 11 -155 -68 -155 -71 0 -116 66 -90 131 26 62 113 75 158 24z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M375 3083 c-55 -17 -129 -83 -163 -147 l-27 -51 0 -1245 0 -1245 27 -51 c15 -28 47 -69 72 -91 89 -78 -15 -73 1500 -73 1493 0 1411 -3 1498 63 27 21 55 56 75 96 l33 63 0 1237 0 1238 -31 61 c-33 67 -72 105 -136 134 -40 18 -101 18 -1423 21 -1072 1 -1392 -1 -1425 -10z m2827 -46 c53 -22 99 -68 124 -122 l24 -50 0 -1225 0 -1225 -24 -50 c-23 -52 -63 -92 -120 -123 -29 -16 -129 -17 -1391 -20 -954 -2 -1373 1 -1404 8 -66 16 -123 61 -156 122 l-30 53 0 1235 0 1235 31 55 c33 58 109 116 163 122 14 2 639 2 1388 1 1125 -2 1369 -5 1395 -16z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1243 1795 c-237 -52 -405 -294 -365 -528 35 -203 192 -359 392 -390 142 -22 294 27 394 127 55 55 100 124 111 169 4 15 10 27 14 27 3 0 19 -30 35 -65 55 -123 185 -225 324 -254 316 -66 608 214 554 532 -44 252 -287 428 -533 387 -148 -25 -294 -134 -349 -263 -14 -31 -27 -57 -30 -57 -3 0 -16 26 -30 57 -32 75 -123 171 -199 212 -61 32 -170 61 -226 60 -16 0 -58 -7 -92 -14z m218 -41 c139 -41 247 -147 291 -288 31 -96 21 -224 -22 -313 -43 -88 -116 -160 -205 -204 -67 -33 -74 -34 -185 -34 -111 0 -118 1 -185 34 -89 44 -162 116 -205 205 -68 137 -50 316 43 443 104 141 299 207 468 157z m912 -4 c87 -27 173 -92 225 -170 58 -86 75 -151 70 -264 -5 -117 -41 -201 -122 -282 -81 -81 -165 -117 -282 -122 -111 -5 -175 11 -262 67 -77 51 -144 139 -172 228 -103 335 208 646 543 543z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1318 1633 c-36 -90 -91 -197 -131 -255 -59 -86 -74 -139 -57 -209 22 -92 118 -169 210 -169 94 0 189 79 211 173 15 69 2 116 -57 202 -40 58 -96 166 -132 258 -7 15 -16 27 -22 27 -6 0 -15 -12 -22 -27z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2192 1583 c-17 -43 -50 -107 -71 -143 -82 -134 -94 -162 -95 -220 0 -67 27 -125 79 -168 91 -74 202 -68 286 17 90 89 91 193 4 306 -31 41 -96 166 -133 258 -6 15 -18 27 -25 27 -7 0 -27 -35 -45 -77z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1894 679 c-57 -16 -93 -82 -94 -174 0 -105 43 -181 110 -191 46 -7 96 25 117 74 19 45 22 163 5 213 -22 63 -77 94 -138 78z m72 -60 c16 -18 19 -37 19 -121 0 -96 -1 -101 -27 -123 -48 -42 -87 -11 -103 82 -20 125 50 229 111 162z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1635 666 c-69 -31 -115 -110 -115 -198 0 -100 66 -169 147 -153 110 20 138 189 39 230 -44 19 -64 19 -98 1 -25 -13 -28 -13 -28 1 0 29 65 82 109 89 31 5 41 11 41 25 0 15 -7 19 -32 19 -18 -1 -46 -7 -63 -14z m49 -167 c21 -16 26 -29 26 -63 0 -49 -24 -78 -65 -78 -75 0 -101 124 -32 152 33 13 42 12 71 -11z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
	}  
	  
	if (typeObj == "fregadero40")
	{
		
		construc.push({'path': "M7 3553 c-4 -3 -7 -799 -7 -1768 0 -1356 3 -1764 12 -1773 19 -19 2351 -17 2367 2 8 10 10 482 9 1777 l-3 1764 -1186 3 c-652 1 -1189 -1 -1192 -5z m2343 -1773 l0 -1740 -1153 2 -1152 3 -3 1738 -2 1737 1155 0 1155 0 0 -1740z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M1160 3419 c-121 -48 -113 -226 11 -259 53 -15 99 1 139 46 57 65 35 165 -45 204 -45 22 -67 24 -105 9z m85 -43 c39 -17 55 -42 55 -86 0 -44 -16 -69 -53 -85 -62 -26 -122 9 -133 76 -6 38 21 84 60 99 29 12 32 12 71 -4z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M372 3082 c-32 -10 -62 -30 -103 -71 -96 -97 -89 13 -89 -1372 0 -1384 -7 -1272 90 -1371 93 -93 43 -88 930 -88 846 0 828 -1 911 63 23 17 56 57 73 87 l31 55 0 1255 0 1255 -22 41 c-35 66 -70 101 -127 129 l-52 26 -798 2 c-639 2 -807 -1 -844 -11z m1677 -55 c52 -27 105 -91 121 -145 14 -51 14 -2433 0 -2484 -16 -56 -69 -119 -125 -147 l-49 -26 -796 0 c-766 0 -796 1 -834 19 -50 25 -97 72 -122 122 -18 38 -19 75 -22 1249 -2 833 1 1223 8 1253 22 88 98 164 181 181 17 3 382 5 812 4 l781 -2 45 -24z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M667 1800 c-27 -5 -81 -24 -122 -43 -290 -138 -354 -519 -126 -748 187 -187 478 -184 661 6 35 37 72 89 89 125 l29 61 32 -66 c20 -42 54 -89 90 -125 280 -280 751 -110 796 288 32 288 -249 550 -537 502 -148 -25 -294 -134 -349 -263 -14 -31 -28 -57 -31 -57 -3 0 -16 25 -29 56 -30 74 -122 172 -199 213 -61 32 -171 61 -226 60 -16 -1 -52 -5 -78 -9z m266 -73 c92 -45 159 -112 204 -204 46 -94 56 -213 25 -309 -38 -122 -127 -221 -247 -276 -43 -20 -66 -23 -165 -23 -109 0 -119 2 -182 32 -158 75 -250 220 -249 395 0 135 62 260 166 339 88 66 169 91 283 86 82 -4 101 -8 165 -40z m849 22 c192 -64 307 -233 296 -433 -9 -145 -71 -256 -187 -333 -86 -59 -152 -76 -265 -71 -76 3 -102 9 -159 35 -89 42 -168 121 -210 210 -30 64 -32 74 -32 183 0 98 4 122 23 165 97 210 326 314 534 244z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M724 1623 c-40 -98 -69 -153 -120 -230 -75 -113 -86 -154 -63 -238 16 -56 91 -129 149 -145 90 -25 197 19 244 99 48 83 39 156 -33 276 -58 94 -103 185 -120 238 -7 20 -19 37 -27 37 -8 0 -22 -17 -30 -37z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1628 1633 c-43 -103 -91 -197 -130 -253 -70 -102 -81 -150 -53 -231 29 -82 122 -149 206 -149 73 0 154 51 189 120 44 86 35 151 -36 254 -44 64 -111 194 -132 256 -14 37 -29 38 -44 3z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1326 679 c-66 -18 -96 -74 -96 -181 1 -126 54 -199 135 -184 70 13 105 79 105 195 0 121 -61 193 -144 170z m70 -64 c23 -35 30 -149 12 -200 -25 -75 -85 -78 -115 -7 -20 47 -13 170 11 206 23 35 69 36 92 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1016 568 c-108 -153 -108 -148 -2 -148 l86 0 0 -50 c0 -47 2 -50 25 -50 23 0 25 3 25 50 0 47 2 50 25 50 18 0 25 5 25 20 0 15 -7 20 -25 20 l-25 0 0 110 0 110 -28 0 c-24 0 -38 -15 -106 -112z m84 -33 l0 -75 -55 0 -55 0 53 75 c28 41 53 74 55 75 1 0 2 -34 2 -75z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"}); 
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
	}  
	  
	if (typeObj == "mueble-bajo80")
	{
		
		construc.push({'path': "M17 3553 c-4 -3 -7 -797 -7 -1763 0 -1352 3 -1759 12 -1768 19 -19 4691 -17 4707 2 8 10 10 480 9 1772 l-3 1759 -2356 3 c-1296 1 -2359 -1 -2362 -5z m4681 -1765 l-3 -1733 -2322 -3 -2323 -2 0 1735 0 1735 2325 0 2325 0 -2 -1732z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M2159 661 c-38 -38 -40 -88 -5 -120 l25 -23 -29 -24 c-76 -64 -22 -174 86 -174 43 0 95 30 111 66 19 39 11 77 -23 111 l-25 25 20 22 c30 32 28 90 -4 121 -19 20 -34 25 -75 25 -44 0 -56 -5 -81 -29z m119 -23 c28 -28 1 -98 -37 -98 -30 0 -61 30 -61 59 0 35 17 51 55 51 17 0 36 -5 43 -12z m-10 -158 c26 -16 32 -26 32 -54 0 -38 -28 -66 -65 -66 -64 0 -89 79 -39 119 32 26 31 26 72 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2456 669 c-54 -43 -76 -129 -56 -224 17 -81 54 -120 113 -120 83 0 121 58 121 185 0 92 -15 135 -56 164 -32 23 -90 20 -122 -5z m107 -51 c26 -35 28 -168 3 -215 -29 -57 -84 -52 -105 8 -19 55 -14 169 9 207 25 41 63 41 93 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
			
	}  

	if (typeObj == "mueble-bajo60")
	{
		
		construc.push({'path': "M15 3558 c-3 -7 -4 -807 -3 -1778 l3 -1765 1775 0 1775 0 0 1775 0 1775 -1773 3 c-1413 2 -1774 0 -1777 -10z m3515 -1768 l0 -1740 -1740 0 -1740 0 0 1740 0 1740 1740 0 1740 0 0 -1740z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M1706 675 c-75 -27 -136 -116 -136 -199 0 -43 23 -100 50 -128 23 -23 37 -28 77 -28 78 0 123 47 123 131 0 57 -50 109 -107 109 -21 0 -49 -7 -61 -16 -27 -19 -28 -9 -2 33 22 37 50 54 100 63 26 4 35 10 35 25 0 25 -28 29 -79 10z m43 -181 c12 -15 21 -39 21 -54 0 -40 -35 -80 -70 -80 -61 0 -98 109 -48 144 34 24 73 20 97 -10z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1928 675 c-45 -25 -70 -87 -70 -169 0 -80 12 -119 50 -158 37 -40 102 -39 142 0 64 64 68 237 7 308 -28 32 -90 41 -129 19z m87 -49 c54 -54 39 -247 -21 -262 -13 -3 -31 -3 -39 0 -51 19 -62 211 -15 261 29 31 45 31 75 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
			
	}  	  
	 
	if (typeObj == "mueble-bajo40")
	{
		
		construc.push({'path': "M5 3558 c-3 -7 -4 -807 -3 -1778 l3 -1765 1190 0 1190 0 3 1764 c1 1295 -1 1767 -9 1777 -16 20 -2367 21 -2374 2z m2345 -1768 l0 -1740 -1155 0 -1155 0 0 1740 0 1740 1155 0 1155 0 0 -1740z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M1288 675 c-83 -46 -94 -265 -15 -331 60 -51 154 -17 177 64 14 53 12 167 -4 206 -28 67 -97 94 -158 61z m92 -50 c18 -19 24 -39 27 -92 9 -118 -23 -184 -82 -169 -65 16 -75 227 -12 271 29 21 40 19 67 -10z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1000 563 c-44 -64 -80 -122 -80 -130 0 -10 21 -13 84 -13 l85 0 3 -47 c3 -41 6 -48 26 -51 20 -3 22 0 22 47 0 48 2 51 25 51 18 0 25 5 25 20 0 15 -7 20 -25 20 l-25 0 0 110 0 110 -30 0 c-26 0 -38 -12 -110 -117z m90 -23 l0 -80 -55 0 -54 0 52 79 c29 44 53 80 55 80 1 1 2 -35 2 -79z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
			
	}    
	if (typeObj == "mueble-bajo30")
	{
		
		construc.push({'path': "M5 3558 c-3 -7 -4 -807 -3 -1778 l3 -1765 895 0 895 0 0 1775 0 1775 -893 3 c-709 2 -894 0 -897 -10z m1755 -1768 l0 -1740 -860 0 -860 0 0 1740 0 1740 860 0 860 0 0 -1740z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M688 678 c-16 -5 -28 -17 -28 -27 0 -25 11 -33 26 -20 19 16 79 15 98 0 39 -32 5 -91 -52 -91 -25 0 -32 -4 -32 -19 0 -14 10 -21 38 -26 50 -9 72 -31 72 -71 0 -57 -66 -80 -141 -49 -11 4 -18 0 -22 -15 -7 -29 32 -43 106 -38 45 3 63 10 83 30 36 36 42 95 14 131 -12 15 -29 27 -38 27 -12 0 -10 6 10 28 34 36 39 56 26 92 -18 52 -90 74 -160 48z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M975 657 c-51 -51 -69 -150 -44 -241 27 -96 119 -128 184 -63 55 55 69 189 29 269 -37 73 -115 89 -169 35z m95 -17 c26 -14 40 -63 40 -139 0 -87 -23 -136 -64 -136 -49 0 -71 41 -70 133 0 116 37 172 94 142z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
			
	}   
	if (typeObj == "reducida80")
	{
		
		construc.push({'path': "M11 2216 c-8 -10 -10 -307 -9 -1107 l3 -1094 2370 0 2370 0 3 1094 c1 800 -1 1097 -9 1107 -17 21 -4711 21 -4728 0z m4699 -1096 l0 -1070 -2335 0 -2335 0 0 1063 c0 585 3 1067 7 1070 3 4 1054 7 2335 7 l2328 0 0 -1070z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M2165 657 c-42 -42 -45 -74 -11 -114 l24 -28 -29 -33 c-46 -52 -37 -117 21 -147 58 -30 155 -11 180 34 20 38 12 91 -18 121 l-28 28 23 26 c29 35 29 78 0 112 -18 21 -35 28 -75 32 -49 4 -54 2 -87 -31z m117 -24 c26 -23 22 -58 -8 -82 -24 -19 -28 -19 -55 -6 -16 9 -32 27 -35 41 -13 51 56 85 98 47z m3 -168 c48 -47 22 -105 -46 -105 -28 0 -42 6 -53 22 -21 30 -20 50 5 82 26 33 62 34 94 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2457 660 c-38 -33 -57 -85 -57 -156 0 -113 46 -184 118 -184 79 0 125 68 125 185 0 78 -17 128 -54 160 -42 35 -89 33 -132 -5z m93 -20 c41 -22 56 -173 22 -240 -36 -72 -103 -39 -118 58 -9 62 10 152 37 175 24 20 33 21 59 7z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
			
	}   
	if (typeObj == "reducida60")
	{
		
		construc.push({'path': "M12 2198 c-19 -19 -17 -2171 2 -2187 10 -8 483 -10 1782 -9 l1769 3 0 1100 0 1100 -1770 3 c-1369 1 -1774 -1 -1783 -10z m3518 -1093 l0 -1065 -1745 0 -1745 0 0 1065 0 1065 1745 0 1745 0 0 -1065z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M1647 666 c-52 -19 -76 -42 -103 -101 -60 -126 -4 -255 109 -255 31 0 46 7 72 33 58 58 59 135 4 181 -33 28 -105 36 -127 14 -21 -21 -25 0 -7 29 26 39 43 51 93 64 30 8 42 16 42 30 0 23 -28 24 -83 5z m45 -173 c65 -75 -23 -192 -90 -120 -33 35 -38 77 -12 110 26 32 78 37 102 10z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1866 659 c-45 -36 -60 -76 -60 -164 0 -88 15 -128 60 -164 52 -41 124 -18 159 50 41 78 23 236 -31 278 -35 28 -93 27 -128 0z m98 -38 c38 -42 38 -210 0 -252 -27 -30 -61 -24 -84 14 -38 61 -22 232 22 250 26 10 45 7 62 -12z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
			
	}  
	if (typeObj == "reducida40")
	{
		
		construc.push({'path': "M7 2203 c-4 -3 -7 -496 -7 -1093 0 -904 2 -1089 14 -1099 10 -8 329 -10 1192 -9 l1179 3 0 1100 0 1100 -1186 3 c-652 1 -1189 -1 -1192 -5z m2343 -1098 l0 -1065 -1155 0 -1155 0 0 1065 0 1065 1155 0 1155 0 0 -1065z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M1088 663 c-51 -60 -159 -226 -154 -239 4 -10 25 -14 85 -14 l80 0 3 -47 c3 -41 6 -48 26 -51 20 -3 22 0 22 47 0 48 2 51 25 51 18 0 25 5 25 20 0 15 -7 20 -25 20 l-25 0 0 115 c0 114 0 115 -23 115 -13 0 -31 -8 -39 -17z m12 -133 l0 -80 -55 0 -55 0 52 79 c29 44 54 80 56 80 1 1 2 -35 2 -79z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1300 667 c-88 -43 -94 -281 -9 -341 59 -41 144 -4 167 72 16 53 15 165 -2 206 -27 66 -95 93 -156 63z m89 -46 c24 -24 36 -94 28 -166 -6 -62 -23 -94 -55 -101 -44 -12 -82 50 -82 133 0 120 55 188 109 134z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
			
	} 
	if (typeObj == "reducida30")
	{
		
		construc.push({'path': "M7 2203 c-4 -3 -7 -495 -7 -1093 0 -831 3 -1089 12 -1098 17 -17 1769 -17 1786 0 17 17 17 2169 0 2186 -9 9 -222 12 -898 12 -488 0 -890 -3 -893 -7z m1753 -1098 l0 -1065 -860 0 -860 0 0 1065 0 1065 860 0 860 0 0 -1065z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M688 668 c-27 -9 -37 -31 -20 -42 5 -3 25 0 45 6 52 16 87 -1 87 -41 0 -35 -31 -61 -72 -61 -21 0 -28 -5 -28 -20 0 -15 7 -20 25 -20 39 0 84 -27 91 -55 14 -56 -55 -100 -119 -76 -40 15 -47 14 -47 -9 0 -25 35 -40 91 -40 111 0 169 101 99 172 l-30 30 25 30 c33 39 32 73 -4 109 -24 23 -38 29 -73 28 -24 0 -55 -5 -70 -11z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M986 659 c-45 -36 -60 -76 -60 -164 0 -88 15 -128 60 -164 83 -65 184 25 184 165 0 62 -27 140 -57 163 -34 28 -92 27 -127 0z m98 -38 c38 -42 38 -210 0 -252 -27 -30 -61 -24 -84 14 -38 61 -22 232 22 250 26 10 45 7 62 -12z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
			
	}  
	  
	if (typeObj == "esquinero88")
	{
		
		construc.push({'path': "M15 5198 c-3 -7 -4 -1176 -3 -2598 l3 -2585 1775 0 1775 0 3 817 2 818 818 2 817 3 3 1764 c1 1295 -1 1767 -9 1777 -16 20 -5177 21 -5184 2z m5155 -1768 l0 -1740 -817 -2 -818 -3 -3 -817 -2 -818 -1740 0 -1740 0 0 2560 0 2560 2560 0 2560 0 0 -1740z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M2725 2171 c-58 -24 -79 -102 -37 -143 l21 -21 -29 -34 c-41 -46 -40 -85 4 -129 29 -29 41 -34 80 -34 84 0 128 38 128 108 0 28 -7 43 -29 63 l-30 26 24 27 c32 38 30 80 -6 117 -31 30 -81 38 -126 20z m89 -47 c24 -23 19 -60 -10 -83 -24 -19 -28 -19 -54 -6 -37 19 -46 49 -26 80 19 29 66 34 90 9z m0 -165 c49 -38 24 -109 -38 -109 -37 0 -49 7 -64 37 -13 23 -8 48 16 76 20 23 53 22 86 -4z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M3005 2171 c-58 -24 -79 -102 -37 -143 l21 -21 -29 -34 c-41 -46 -40 -85 4 -129 29 -29 41 -34 80 -34 62 0 104 23 122 66 18 43 10 77 -26 107 l-27 23 23 28 c15 17 24 40 24 61 0 63 -84 105 -155 76z m89 -47 c46 -45 -9 -118 -66 -88 -34 17 -41 61 -16 92 15 17 63 15 82 -4z m0 -165 c49 -38 24 -109 -38 -109 -37 0 -49 7 -64 37 -13 23 -8 48 16 76 20 23 53 22 86 -4z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
			
	}   
	  
	if (typeObj == "esquinero128b")
	{
		
		construc.push({'path': "M12 4028 c-19 -19 -17 -3991 2 -4007 10 -8 1001 -10 3772 -9 l3759 3 3 1764 c1 1295 -1 1767 -9 1777 -10 12 -337 14 -1990 14 l-1979 0 0 223 c0 160 -3 226 -12 235 -17 17 -3529 17 -3546 0z m3508 -251 c0 -160 3 -226 12 -235 9 -9 466 -12 1995 -12 l1983 0 0 -1740 0 -1740 -3730 0 -3730 0 0 1975 0 1975 1735 0 1735 0 0 -223z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M5782 3235 c-37 -16 -42 -53 -7 -47 88 16 103 14 121 -13 28 -43 6 -93 -82 -184 -103 -108 -101 -112 39 -109 104 3 112 4 112 23 0 18 -8 20 -74 23 l-73 3 56 59 c91 95 109 164 58 221 -34 38 -98 48 -150 24z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M6078 3235 c-52 -29 -64 -92 -26 -140 19 -25 20 -28 5 -37 -27 -15 -49 -66 -42 -98 11 -49 58 -80 121 -80 45 0 59 5 84 28 20 17 33 40 37 64 5 33 2 41 -29 72 l-34 34 23 20 c32 29 32 90 -1 121 -31 30 -100 37 -138 16z m93 -35 c29 -16 26 -75 -5 -95 -38 -25 -86 4 -86 52 0 44 47 66 91 43z m-8 -161 c29 -16 37 -28 37 -61 0 -35 -24 -58 -62 -58 -62 0 -91 67 -48 110 23 23 42 25 73 9z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M5523 3219 c-50 -32 -43 -70 8 -43 l28 14 3 -152 c3 -150 3 -153 26 -156 l22 -3 0 180 0 181 -27 0 c-16 0 -43 -10 -60 -21z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
			
	}   
	  
	if (typeObj == "esquinero128a")
	{
		
		construc.push({'path': "M4002 4028 c-9 -9 -12 -75 -12 -235 l0 -223 -1987 -2 -1988 -3 0 -1775 0 -1775 3765 0 3765 0 0 2010 0 2010 -1765 3 c-1365 1 -1769 -1 -1778 -10z m3508 -2003 l0 -1975 -3730 0 -3730 0 0 1740 0 1740 1987 2 1988 3 3 233 2 232 1740 0 1740 0 0 -1975z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M2044 3236 c-38 -17 -46 -27 -34 -46 8 -12 13 -13 30 -2 28 17 85 15 104 -4 22 -22 20 -73 -5 -114 -12 -19 -51 -63 -87 -97 -90 -86 -84 -94 60 -91 105 3 113 4 113 23 0 18 -8 20 -73 23 l-73 3 52 57 c70 77 95 133 80 182 -6 20 -20 45 -31 55 -25 23 -97 29 -136 11z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2345 3241 c-30 -13 -54 -44 -61 -77 -4 -24 0 -37 20 -61 l26 -31 -30 -30 c-48 -49 -39 -116 20 -147 58 -30 155 -11 180 34 20 38 12 91 -18 121 l-28 28 23 26 c50 58 13 135 -67 142 -25 2 -54 0 -65 -5z m89 -47 c27 -26 21 -64 -16 -92 -14 -11 -22 -11 -46 2 -46 24 -53 55 -22 86 24 24 63 26 84 4z m0 -165 c50 -39 24 -109 -41 -109 -38 0 -73 29 -73 60 0 26 43 70 68 70 11 0 31 -9 46 -21z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1783 3223 c-23 -12 -33 -24 -33 -40 0 -27 7 -28 34 -8 11 8 23 15 28 15 4 0 8 -70 8 -156 l0 -155 23 3 c22 3 22 5 25 181 l2 177 -27 -1 c-16 0 -43 -8 -60 -16z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
			
	}   
	  
	  
	if (typeObj == "mueble-bajo20")
	{
		
		construc.push({'path': "M5 3558 c-3 -7 -4 -807 -3 -1778 l3 -1765 600 0 600 0 0 1775 0 1775 -598 3 c-473 2 -599 0 -602 -10z m1165 -1768 l0 -1740 -565 0 -565 0 0 1740 0 1740 565 0 565 0 0 -1740z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		construc.push({'path': "M393 676 c-33 -15 -43 -39 -22 -52 6 -3 16 -1 22 5 16 16 92 14 107 -4 19 -23 14 -81 -11 -117 -13 -18 -52 -63 -88 -101 -44 -46 -61 -71 -54 -78 6 -6 54 -9 119 -7 101 3 109 4 109 23 0 18 -8 20 -73 23 l-73 3 54 58 c92 100 109 173 53 229 -30 30 -97 38 -143 18z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M705 681 c-72 -30 -104 -153 -70 -269 19 -64 53 -92 109 -92 47 0 76 20 102 70 25 47 25 182 1 227 -33 62 -87 86 -142 64z m75 -51 c27 -27 33 -57 29 -149 -4 -86 -23 -121 -64 -121 -31 0 -52 28 -65 84 -29 128 36 250 100 186z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
			
	}
	  
	if (typeObj == "mueble-alto-campana60")
	{
		
		construc.push({'path': "M11 2386 c-8 -10 -10 -329 -9 -1192 l3 -1179 1780 0 1780 0 3 1179 c1 863 -1 1182 -9 1192 -17 21 -3531 21 -3548 0z m1199 -429 l0 -403 -576 -724 c-316 -399 -579 -729 -585 -734 -5 -6 -9 416 -9 1127 l0 1137 585 0 585 0 0 -403z m205 361 c11 -64 47 -137 94 -190 47 -53 145 -106 210 -115 l41 -6 0 -78 0 -79 -126 0 c-114 0 -125 -2 -122 -17 3 -16 18 -18 126 -21 l122 -3 0 -58 c0 -37 5 -63 13 -70 21 -17 27 -3 27 65 l0 63 127 3 c112 3 128 5 131 21 3 15 -8 17 -127 17 l-131 0 0 79 0 78 45 6 c68 7 167 60 216 115 47 53 84 127 94 190 l7 42 79 0 79 0 0 -400 0 -400 -535 0 -535 0 0 400 0 400 79 0 79 0 7 -42z m701 5 c-17 -97 -92 -194 -188 -245 -37 -20 -58 -23 -143 -23 -85 0 -106 3 -143 23 -96 51 -171 148 -188 245 l-6 37 337 0 337 0 -6 -37z m1414 -1100 c0 -708 -4 -1133 -9 -1127 -6 5 -269 335 -585 734 l-576 724 0 403 0 403 585 0 585 0 0 -1137z m-613 -435 l582 -733 -860 -3 c-473 -1 -1245 -1 -1714 0 l-854 3 582 733 582 732 550 0 550 0 582 -732z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1708 680 c-45 -13 -87 -49 -109 -92 -64 -124 -10 -268 99 -268 113 0 166 151 78 222 -26 22 -94 23 -124 2 -20 -14 -22 -14 -22 2 0 31 71 91 118 99 32 5 42 11 42 26 0 21 -31 24 -82 9z m38 -181 c28 -31 25 -96 -5 -120 -13 -10 -33 -19 -45 -19 -29 0 -62 36 -70 76 -15 67 74 114 120 63z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1905 657 c-72 -72 -68 -249 6 -312 53 -44 133 -25 165 38 22 42 29 150 14 206 -27 101 -119 134 -185 68z m109 -26 c43 -47 44 -199 2 -248 -31 -36 -72 -26 -92 22 -16 40 -19 151 -4 192 20 53 63 68 94 34z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	
	if (typeObj == "mueble-alto-esquina60")
	{
		
		
		construc.push({'path': "M5 3558 c-3 -7 -4 -807 -3 -1778 l3 -1765 1095 -3 1095 -2 683 683 682 682 -2 1095 -3 1095 -1773 3 c-1413 2 -1774 0 -1777 -10z m3515 -1100 l0 -1073 -667 -667 -668 -668 -1072 0 -1073 0 0 1740 0 1740 1740 0 1740 0 0 -1072z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1605 704 c-87 -32 -134 -108 -135 -217 0 -97 30 -147 101 -167 134 -39 226 144 118 235 -35 29 -88 33 -131 11 -36 -19 -36 -4 -2 42 28 36 77 62 119 62 20 0 25 5 25 25 0 21 -5 25 -27 24 -16 0 -46 -7 -68 -15z m28 -175 c45 -20 59 -77 32 -129 -30 -57 -104 -49 -131 15 -20 49 -18 63 15 96 32 32 47 35 84 18z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1830 682 c-49 -49 -67 -126 -52 -220 16 -97 59 -146 128 -146 77 0 124 64 132 178 5 91 -11 151 -53 193 -27 27 -41 33 -75 33 -36 0 -48 -6 -80 -38z m132 -52 c24 -47 25 -178 2 -226 -16 -34 -50 -52 -78 -41 -60 23 -76 216 -24 282 30 39 77 32 100 -15z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "mueble-alto20")
	{
		
		construc.push({'path': "M5 2388 c-3 -7 -4 -544 -3 -1193 l3 -1180 657 -3 658 -2 0 1195 0 1195 -655 0 c-515 0 -657 -3 -660 -12z m1275 -1183 l0 -1155 -615 0 -615 0 0 1155 0 1155 615 0 615 0 0 -1155z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladomini"});
		construc.push({'path': "M425 724 c-39 -22 -38 -19 -30 -43 6 -20 8 -20 35 -6 40 21 93 19 113 -3 23 -25 21 -80 -4 -122 -12 -19 -52 -65 -90 -103 -38 -38 -69 -78 -69 -88 0 -18 7 -19 123 -17 118 3 122 4 125 26 3 21 1 22 -84 22 l-87 0 71 74 c77 81 99 129 88 188 -10 53 -46 81 -108 85 -36 2 -63 -2 -83 -13z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladomini"});
		construc.push({'path': "M735 707 c-79 -79 -74 -279 10 -345 52 -41 130 -24 167 37 31 49 38 192 13 257 -33 87 -128 113 -190 51z m99 -18 c36 -17 51 -63 50 -154 -1 -123 -41 -179 -100 -140 -35 22 -46 58 -46 145 -1 80 16 130 49 149 22 13 18 13 47 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladomini"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "mueble-alto-campana30")
	{
	
		
		construc.push({'path': "M5 2388 c-3 -7 -4 -544 -3 -1193 l3 -1180 973 -3 972 -2 0 1195 0 1195 -970 0 c-767 0 -972 -3 -975 -12z m1905 -1183 l0 -1155 -935 0 -935 0 0 1155 0 1155 935 0 935 0 0 -1155z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladomini"});
		
		construc.push({'path': "M738 725 c-19 -11 -25 -20 -21 -35 4 -15 10 -19 22 -14 36 16 98 16 114 -1 38 -37 10 -86 -54 -94 -35 -5 -44 -10 -44 -26 0 -16 9 -21 42 -26 54 -7 83 -33 83 -74 0 -45 -29 -68 -84 -68 -24 1 -53 6 -64 12 -17 9 -22 8 -27 -10 -10 -30 7 -42 69 -47 72 -6 123 12 147 52 30 49 25 92 -15 132 l-33 33 23 22 c46 43 38 116 -17 144 -36 19 -106 19 -141 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladomini"});
		
		construc.push({'path': "M1065 718 c-42 -33 -65 -92 -65 -172 0 -90 16 -140 57 -176 67 -59 164 -24 191 68 19 62 15 180 -7 229 -32 70 -119 96 -176 51z m98 -38 c73 -58 46 -300 -33 -300 -78 0 -105 235 -35 298 32 27 36 27 68 2z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladomini"});
		
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	if (typeObj == "mueble-alto-campana40")
	{
		
		
		construc.push({'path': "M0 1205 l0 -1195 1293 2 1292 3 0 1190 0 1190 -1292 3 -1293 2 0 -1195z m2540 0 l0 -1155 -1250 0 -1250 0 0 1155 0 1155 1250 0 1250 0 0 -1155z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladomini"});
		
		construc.push({'path': "M1157 708 c-84 -114 -157 -225 -157 -240 0 -16 11 -18 89 -18 l90 0 3 -52 c3 -49 5 -53 28 -53 23 0 25 4 28 53 3 48 5 52 28 52 21 0 25 4 22 23 -2 14 -11 23 -25 25 -21 3 -22 8 -25 120 l-3 117 -27 3 c-20 2 -32 -5 -51 -30z m20 -205 c-3 -2 -28 -3 -56 -1 l-51 3 52 76 53 76 3 -75 c2 -41 1 -76 -1 -79z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladomini"});
		
		construc.push({'path': "M1389 717 c-41 -27 -68 -96 -69 -177 0 -77 17 -129 55 -167 38 -38 85 -44 136 -17 95 49 99 303 7 368 -32 23 -89 20 -129 -7z m100 -36 c61 -61 47 -275 -19 -296 -28 -9 -60 12 -76 50 -18 44 -18 166 0 209 23 55 62 70 95 37z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladomini"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "mueble-alto-campana90")
	{
		
		construc.push({'path': "M12 2378 c-19 -19 -17 -2351 2 -2367 10 -8 712 -10 2662 -9 l2649 3 0 1190 0 1190 -2650 3 c-2054 1 -2654 -1 -2663 -10z m2018 -496 c0 -351 3 -471 12 -480 17 -17 1239 -17 1256 0 9 9 12 129 12 480 l0 468 990 0 990 0 0 -1155 0 -1155 -2625 0 -2625 0 0 1155 0 1155 995 0 995 0 0 -468z m270 438 c0 -55 40 -139 95 -198 57 -62 121 -99 200 -117 l50 -11 3 -72 3 -72 -119 0 c-122 0 -154 -9 -131 -37 8 -9 44 -13 130 -13 l119 0 0 -63 c0 -69 6 -83 27 -66 8 7 13 33 13 70 l0 59 118 0 c122 0 154 9 131 37 -8 9 -44 13 -130 13 l-119 0 0 74 0 73 45 6 c142 20 279 155 303 300 l8 42 112 3 112 3 0 -461 0 -460 -600 0 -600 0 0 460 0 460 115 0 115 0 0 -30z m697 -10 c-12 -94 -89 -195 -182 -241 -43 -20 -64 -24 -145 -24 -79 0 -103 4 -143 24 -94 47 -172 148 -184 241 l-6 40 333 0 333 0 -6 -40z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M2466 659 c-114 -90 -28 -267 100 -205 38 18 40 16 19 -24 -21 -40 -59 -67 -105 -75 -31 -5 -40 -11 -40 -27 0 -18 5 -20 45 -16 102 12 166 93 167 211 0 104 -39 157 -118 157 -27 0 -51 -7 -68 -21z m113 -45 c12 -15 21 -41 21 -60 0 -79 -103 -100 -131 -26 -31 81 59 151 110 86z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M2762 668 c-38 -19 -64 -74 -70 -146 -9 -128 37 -212 116 -212 82 0 126 69 126 195 -1 136 -77 208 -172 163z m100 -68 c22 -43 24 -156 4 -205 -10 -23 -24 -37 -42 -41 -56 -14 -95 80 -79 190 15 96 82 128 117 56z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "mueble-alto-campana80")
	{
	
		construc.push({'path': "M12 2388 c-19 -19 -17 -2351 2 -2367 10 -8 637 -10 2372 -9 l2359 3 0 1190 0 1190 -2360 3 c-1828 1 -2364 -1 -2373 -10z m1730 -505 l3 -478 624 -3 c452 -1 628 1 637 9 12 9 14 97 14 480 l0 469 845 0 845 0 0 -1155 0 -1155 -2335 0 -2335 0 0 1155 0 1155 850 0 850 0 2 -477z m272 433 c10 -66 60 -158 112 -206 51 -47 136 -89 195 -97 l39 -6 0 -78 0 -79 -123 0 c-68 0 -127 -3 -130 -7 -4 -3 -2 -12 4 -20 8 -9 43 -13 130 -13 l119 0 0 -59 c0 -37 5 -63 13 -70 21 -17 27 -3 27 66 l0 63 119 0 c87 0 122 4 130 13 6 8 8 17 4 20 -3 4 -62 7 -130 7 l-123 0 0 80 0 80 33 0 c44 1 137 40 187 80 59 46 106 123 127 202 l17 68 108 0 108 0 0 -460 0 -460 -600 0 -600 0 0 460 0 460 114 0 114 0 6 -44z m706 36 c0 -5 -7 -33 -16 -62 -31 -104 -105 -184 -204 -221 -73 -28 -194 -23 -258 10 -95 49 -170 147 -188 244 l-6 37 336 0 c185 0 336 -4 336 -8z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M2228 674 c-53 -28 -65 -96 -24 -135 l24 -23 -29 -27 c-22 -20 -29 -36 -29 -64 0 -74 48 -111 134 -102 98 9 140 104 75 170 -18 18 -27 33 -20 35 21 7 43 62 36 93 -14 61 -101 89 -167 53z m109 -50 c15 -24 15 -29 2 -53 -8 -14 -25 -27 -37 -29 -33 -5 -72 24 -72 53 0 56 75 77 107 29z m-2 -159 c30 -29 32 -58 5 -85 -41 -41 -120 -14 -120 41 0 63 70 90 115 44z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M2511 674 c-54 -38 -78 -169 -49 -266 23 -76 108 -113 167 -72 53 37 78 168 51 266 -21 74 -111 113 -169 72z m97 -45 c51 -54 37 -247 -19 -264 -51 -16 -80 23 -87 116 -9 130 49 210 106 148z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	  
	if (typeObj == "mueble-alto-calentador-gas")
	{
		
		construc.push({'path': "M11 2376 c-8 -10 -10 -329 -9 -1192 l3 -1179 1775 0 1775 0 3 1179 c1 863 -1 1182 -9 1192 -17 21 -3521 21 -3538 0z m263 -43 c2 -10 8 -34 11 -53 26 -130 164 -260 296 -277 33 -5 39 -9 39 -29 0 -24 -1 -24 -113 -24 -117 0 -148 -9 -126 -37 8 -9 43 -13 125 -13 l114 0 0 -108 c0 -112 10 -143 37 -121 9 8 13 42 13 120 l0 109 103 0 102 0 0 -122 c0 -118 1 -126 33 -192 39 -83 87 -144 147 -187 l45 -32 0 -389 c0 -307 3 -396 14 -422 19 -46 76 -89 165 -124 88 -35 111 -60 118 -128 4 -34 13 -58 31 -76 l26 -28 328 0 329 0 24 25 c20 20 25 34 25 78 0 67 24 95 109 126 86 31 152 79 176 126 19 38 20 63 23 427 l3 387 33 21 c67 41 141 137 172 221 96 266 -68 562 -344 620 -68 14 -180 7 -241 -14 -35 -12 -55 -14 -105 -5 -74 12 -341 12 -412 0 -37 -6 -61 -5 -90 6 -109 39 -273 22 -379 -38 -62 -35 -154 -130 -184 -188 l-21 -42 -115 0 c-114 0 -115 0 -115 24 0 20 6 24 43 29 142 20 267 141 302 292 l12 50 1246 3 1247 2 0 -1155 0 -1155 -1740 0 -1740 0 0 1155 0 1155 114 0 c101 0 115 -2 120 -17z m702 -24 c-15 -95 -91 -195 -182 -240 -42 -21 -63 -24 -149 -24 -112 0 -151 14 -225 81 -47 42 -100 144 -100 191 l0 33 331 0 332 0 -7 -41z m429 -110 c233 -43 393 -260 358 -487 -48 -307 -386 -468 -652 -309 -148 89 -234 274 -203 439 33 178 164 316 335 353 79 17 91 17 162 4z m967 -15 c119 -39 234 -150 275 -267 27 -78 24 -224 -6 -300 -62 -156 -208 -263 -376 -274 -225 -16 -421 143 -456 370 -14 87 7 194 51 272 35 61 116 139 181 174 95 50 223 60 331 25z m-424 -10 l32 -5 -60 -55 c-43 -41 -71 -78 -100 -136 -22 -44 -40 -74 -40 -66 0 37 -64 139 -124 196 -57 55 -62 63 -43 67 50 11 261 11 335 -1z m-41 -729 c124 -125 326 -173 479 -115 14 6 30 10 35 10 16 0 7 -727 -10 -767 -14 -36 -77 -77 -173 -113 -35 -13 -69 -34 -87 -56 -26 -29 -31 -43 -31 -87 0 -29 -5 -58 -12 -65 -9 -9 -96 -12 -330 -12 -360 0 -330 -8 -343 88 -9 68 -47 108 -136 141 -87 32 -136 67 -148 103 -7 20 -11 165 -11 403 l0 372 57 -19 c106 -36 241 -25 347 28 l50 25 -47 -50 c-68 -73 -90 -128 -91 -226 0 -102 25 -162 97 -233 71 -70 132 -95 227 -96 130 0 240 68 301 186 33 64 38 185 10 259 -36 94 -118 172 -213 200 -63 19 -164 12 -222 -14 l-53 -25 61 62 c41 41 71 83 91 127 l30 65 32 -67 c20 -41 55 -89 90 -124z m0 -74 c62 -31 105 -73 138 -133 26 -46 29 -64 30 -133 0 -68 -4 -88 -27 -131 -58 -110 -165 -170 -287 -162 -111 8 -193 63 -242 163 -29 60 -31 71 -27 142 5 78 24 131 65 178 32 37 92 77 135 91 60 19 162 12 215 -15z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1318 2083 c-45 -109 -93 -203 -130 -256 -60 -86 -71 -116 -66 -186 14 -202 275 -270 393 -103 27 40 30 51 30 121 0 77 0 78 -51 152 -54 78 -99 163 -129 242 -22 60 -32 66 -47 30z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M2222 2089 c-46 -118 -97 -219 -148 -287 -60 -79 -69 -157 -28 -240 42 -84 141 -135 226 -117 120 26 185 113 176 235 -3 48 -11 69 -45 117 -52 75 -106 175 -128 238 -10 28 -24 56 -31 64 -11 12 -15 11 -22 -10z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1666 669 c-134 -31 -200 -215 -115 -322 28 -37 88 -52 131 -34 51 22 71 51 76 112 4 52 3 56 -31 90 -39 39 -78 45 -127 20 -35 -18 -37 -13 -10 30 22 36 73 65 115 65 21 0 26 4 23 22 -4 26 -12 28 -62 17z m19 -184 c40 -39 26 -119 -22 -131 -55 -14 -93 21 -93 84 0 32 8 45 35 60 31 18 54 14 80 -13z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1885 670 c-27 -11 -61 -49 -74 -83 -18 -47 -13 -166 9 -215 46 -101 171 -85 209 27 18 54 13 160 -9 209 -26 57 -83 84 -135 62z m82 -67 c14 -21 18 -48 18 -113 0 -107 -18 -143 -68 -138 -48 5 -69 52 -65 148 4 92 23 130 68 130 21 0 35 -8 47 -27z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1730 1315 c0 -8 -27 -67 -61 -131 -52 -100 -61 -125 -62 -173 -2 -64 23 -110 73 -136 58 -30 88 -13 55 31 -17 23 -19 50 -4 93 11 32 12 32 26 11 20 -29 38 -12 53 51 10 41 15 48 25 37 16 -16 35 -74 35 -103 0 -12 -11 -44 -26 -70 -14 -26 -23 -54 -20 -62 8 -21 74 9 115 53 33 36 33 37 29 118 -5 92 -26 141 -86 208 -64 70 -152 113 -152 73z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	 
	if (typeObj == "torre-escobero80")  
	{
		
		
		construc.push({'path': "M12 3548 c-17 -17 -17 -3519 0 -3536 17 -17 4709 -17 4726 0 17 17 17 3519 0 3536 -17 17 -4709 17 -4726 0z m4688 -1768 l0 -1740 -2325 0 -2325 0 0 1740 0 1740 2325 0 2325 0 0 -1740z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2316 3399 l-26 -31 0 -1060 0 -1060 -60 -79 c-123 -163 -201 -324 -250 -514 -41 -161 -62 -412 -36 -453 5 -9 106 -12 426 -12 230 0 425 3 434 6 13 5 16 25 16 119 0 312 -117 639 -316 883 l-44 54 0 1066 1 1065 -22 23 c-34 36 -90 33 -123 -7z m101 -23 c4 -8 7 -490 5 -1070 l-2 -1056 -45 0 -45 0 0 1054 c0 945 2 1056 16 1070 19 20 60 21 71 2z m75 -2229 c186 -247 288 -540 288 -829 l0 -88 -399 0 -399 0 -6 26 c-12 45 14 272 43 387 48 187 131 356 253 515 l40 52 67 0 66 0 47 -63z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2213 673 c-32 -6 -73 -59 -73 -93 0 -16 11 -41 24 -56 l23 -28 -28 -24 c-38 -32 -41 -97 -6 -130 79 -74 217 -28 217 72 0 14 -13 40 -30 59 -29 33 -29 34 -10 53 11 10 22 33 26 50 12 61 -65 114 -143 97z m77 -53 c26 -26 25 -43 -3 -76 -18 -20 -29 -25 -45 -20 -53 17 -70 73 -30 100 30 21 54 20 78 -4z m-7 -160 c47 -37 43 -91 -9 -110 -26 -10 -73 2 -86 23 -16 26 -8 66 18 86 33 26 45 26 77 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2495 670 c-27 -11 -61 -49 -74 -83 -18 -47 -13 -166 9 -215 46 -101 171 -85 209 27 18 54 13 160 -9 209 -26 57 -83 84 -135 62z m82 -67 c14 -21 18 -48 18 -113 0 -107 -18 -143 -68 -138 -48 5 -69 52 -65 148 4 92 23 130 68 130 21 0 35 -8 47 -27z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
		
	}
	  
	if (typeObj == "torre-escobero60")  
	{
	
		construc.push({'path': "M12 3548 c-17 -17 -17 -3519 0 -3536 19 -19 3531 -17 3547 2 8 10 10 482 9 1777 l-3 1764 -1770 3 c-1369 1 -1774 -1 -1783 -10z m3518 -1768 l0 -1740 -1740 0 -1740 0 0 1740 0 1740 1740 0 1740 0 0 -1740z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1728 3416 c-49 -37 -48 -13 -48 -1132 l0 -1046 -65 -86 c-121 -161 -220 -386 -260 -592 -23 -118 -32 -334 -15 -355 11 -13 68 -15 441 -15 331 0 430 3 436 13 13 20 6 235 -12 336 -40 234 -150 480 -289 646 l-41 50 -5 1073 -5 1074 -28 24 c-31 27 -81 31 -109 10z m86 -42 c15 -14 16 -121 14 -1067 l-3 -1052 -50 0 -50 0 0 1051 c0 1131 -2 1084 51 1084 12 0 30 -7 38 -16z m107 -2264 c111 -154 193 -338 235 -525 8 -38 18 -134 21 -212 l6 -143 -408 0 -408 0 6 121 c17 308 122 590 305 817 l34 43 70 -3 71 -3 68 -95z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1667 666 c-94 -25 -155 -122 -145 -228 6 -59 31 -96 81 -121 115 -57 221 98 134 198 -28 33 -84 43 -126 22 -36 -18 -38 -13 -11 31 20 33 71 62 110 62 15 0 20 7 20 25 0 28 2 28 -63 11z m24 -175 c18 -14 24 -29 24 -59 0 -52 -26 -82 -71 -82 -41 0 -68 35 -68 88 0 62 66 93 115 53z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1881 663 c-52 -27 -76 -82 -76 -173 1 -95 24 -147 78 -174 34 -16 42 -17 75 -4 48 18 79 66 88 136 20 157 -65 267 -165 215z m95 -65 c21 -41 24 -160 5 -206 -23 -55 -80 -55 -109 -1 -20 38 -12 191 12 218 30 33 72 28 92 -11z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
	}
	  
	
	if (typeObj == "torre-despensa80")
	{
		
		construc.push({'path': "M12 3548 c-19 -19 -17 -3521 2 -3537 10 -8 635 -10 2367 -9 l2354 3 0 1775 0 1775 -2355 3 c-1824 1 -2359 -1 -2368 -10z m4688 -1768 l0 -1740 -2325 0 -2325 0 0 1740 0 1740 2325 0 2325 0 0 -1740z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1776 3263 c-3 -3 -6 -269 -6 -590 0 -512 -2 -583 -15 -583 -8 0 -15 1 -16 3 0 1 -22 221 -48 490 -26 268 -51 490 -55 494 -27 28 -25 -38 18 -486 25 -259 46 -478 46 -487 0 -11 -8 -14 -27 -12 l-28 3 -125 572 c-69 315 -131 578 -137 584 -10 10 -14 9 -18 -2 -3 -8 51 -271 120 -584 69 -313 125 -571 125 -572 0 -2 -11 -3 -24 -3 -21 0 -27 8 -40 53 -151 528 -279 964 -287 972 -35 35 -14 -54 117 -505 79 -272 144 -501 144 -507 0 -8 -14 -13 -39 -13 l-39 0 -103 366 c-57 201 -109 373 -115 383 -36 48 -16 -47 79 -382 99 -349 103 -366 83 -369 -18 -3 -21 -11 -24 -60 -2 -48 -8 -62 -32 -87 l-30 -29 0 -537 c0 -599 -1 -593 65 -621 28 -11 75 -14 220 -12 252 4 245 21 -10 28 -186 5 -196 6 -217 28 l-23 23 -3 531 c-2 465 -1 533 13 554 l15 24 262 2 c198 2 262 6 266 16 3 9 -50 12 -242 12 l-246 0 0 50 0 50 248 2 c156 2 247 7 247 13 0 6 -21 11 -47 13 l-48 3 0 584 c0 321 -4 586 -9 589 -4 3 -11 3 -15 -1z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1923 2456 c-35 -32 -37 -35 -41 -118 -5 -104 7 -148 55 -187 l35 -29 -62 -692 c-38 -425 -59 -708 -54 -734 15 -91 76 -158 148 -160 47 -2 40 17 -15 37 -56 21 -86 57 -97 119 -6 30 10 256 53 733 l61 690 385 3 385 2 63 -720 c68 -773 68 -751 17 -799 -12 -12 -42 -27 -65 -34 -49 -14 -58 -31 -19 -35 30 -4 94 26 120 55 31 34 50 94 44 137 -14 98 -126 1399 -120 1407 3 5 11 9 19 9 7 0 25 14 39 31 25 29 26 37 26 141 l0 110 -34 34 -34 34 -436 0 -436 0 -37 -34z m913 -19 c25 -22 26 -27 26 -126 0 -159 41 -145 -450 -149 -224 -1 -417 0 -429 3 -12 3 -32 15 -43 27 -17 19 -20 35 -20 118 0 99 6 117 45 138 14 8 153 11 432 12 l412 0 27 -23z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2905 1960 c-17 -27 16 -30 304 -30 218 0 300 -3 309 -12 7 -7 12 -42 12 -88 0 -115 18 -109 -321 -112 -181 -2 -284 -7 -284 -13 0 -6 98 -11 268 -13 l267 -2 0 -433 c0 -237 -4 -436 -8 -442 -27 -37 -44 -40 -246 -45 -260 -6 -270 -24 -16 -28 207 -3 246 3 284 49 l26 31 0 429 0 429 31 28 c31 28 32 30 32 121 0 82 -3 95 -23 116 l-23 25 -303 0 c-191 0 -305 -4 -309 -10z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2084 1801 c-43 -26 -50 -56 -64 -267 -14 -201 -11 -218 43 -258 27 -20 40 -21 326 -21 325 0 328 1 368 61 15 24 15 42 4 222 -8 124 -18 207 -27 224 -30 57 -34 58 -339 58 -258 0 -282 -2 -311 -19z m583 -21 c7 0 20 -11 28 -24 21 -31 50 -388 35 -417 -26 -47 -37 -49 -340 -49 -307 0 -320 2 -339 54 -8 21 13 361 24 397 14 44 48 47 592 39z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2157 1614 c-21 -21 14 -24 231 -22 152 2 236 7 235 13 -3 11 -455 20 -466 9z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2115 1450 c-3 -5 0 -12 7 -15 25 -10 318 0 321 10 3 14 -319 19 -328 5z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2522 1448 c3 -9 25 -13 66 -13 85 0 84 19 -1 23 -53 2 -68 0 -65 -10z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1445 1676 l-25 -25 0 -256 0 -256 25 -25 c24 -24 25 -24 191 -22 118 2 169 7 171 15 3 9 -40 12 -162 15 -151 3 -168 5 -181 22 -19 27 -21 473 -1 500 11 15 34 17 202 19 161 2 190 4 190 17 0 13 -29 15 -193 18 l-192 2 -25 -24z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M3107 1523 c-128 -3 -168 -6 -164 -16 3 -9 52 -13 183 -15 98 -1 182 -6 187 -11 12 -12 10 -422 -3 -435 -7 -7 -73 -12 -171 -14 -118 -3 -159 -7 -156 -15 2 -8 52 -13 166 -15 160 -2 162 -2 186 22 l25 25 0 216 c0 216 0 216 -25 240 -13 14 -32 24 -42 23 -10 -1 -94 -4 -186 -5z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2198 704 c-54 -29 -65 -98 -24 -139 25 -25 25 -25 5 -36 -27 -14 -51 -72 -43 -103 3 -13 17 -35 31 -48 21 -19 35 -23 90 -23 60 0 67 2 94 33 42 47 37 102 -15 145 -19 15 -19 18 -5 27 9 5 22 23 29 40 34 82 -74 152 -162 104z m102 -39 c20 -24 15 -67 -9 -86 -51 -42 -122 39 -75 85 20 20 68 21 84 1z m-1 -164 c30 -23 33 -77 6 -97 -26 -19 -75 -17 -97 3 -39 35 -8 113 45 113 12 0 33 -9 46 -19z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2490 707 c-43 -22 -72 -88 -72 -166 -1 -123 43 -191 124 -191 75 0 118 72 118 195 -1 133 -79 208 -170 162z m88 -52 c41 -52 39 -194 -3 -242 -30 -36 -71 -26 -91 22 -16 39 -19 151 -5 188 23 59 67 73 99 32z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	  
	if (typeObj == "torre-despensa60")
	{
		
		construc.push({'path': "M7 3553 c-4 -3 -7 -799 -7 -1768 0 -1356 3 -1764 12 -1773 19 -19 3531 -17 3547 2 8 10 10 482 9 1777 l-3 1764 -1776 3 c-976 1 -1779 -1 -1782 -5z m3523 -1773 l0 -1740 -1745 0 -1745 0 0 1740 0 1740 1745 0 1745 0 0 -1740z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M776 3252 c-3 -5 50 -266 119 -578 69 -313 125 -572 125 -576 0 -5 -10 -8 -23 -8 -21 0 -31 28 -172 515 -100 348 -153 515 -162 515 -7 0 -13 -8 -13 -17 0 -10 65 -241 144 -513 l143 -495 -35 -3 c-19 -2 -36 -1 -39 2 -3 2 -52 168 -110 368 -58 200 -110 369 -116 376 -6 8 -14 9 -19 4 -6 -6 29 -144 90 -353 127 -436 118 -395 93 -402 -18 -4 -21 -13 -21 -57 0 -46 -4 -55 -35 -84 l-35 -33 0 -537 c0 -600 -1 -594 65 -622 28 -11 75 -14 220 -12 250 4 250 21 0 28 -192 5 -226 11 -239 46 -3 8 -6 258 -6 554 0 435 3 540 13 549 9 7 102 12 272 13 196 2 259 6 263 16 3 9 -50 12 -242 12 l-246 0 0 50 0 50 245 2 c153 2 246 7 248 13 1 6 -17 11 -40 13 l-43 3 -2 582 c-3 510 -5 582 -18 582 -13 0 -15 -73 -18 -582 -2 -485 -4 -583 -16 -583 -18 0 -17 -4 -67 525 -23 248 -46 454 -50 459 -28 31 -26 -34 16 -469 25 -253 45 -472 45 -487 0 -23 -4 -28 -25 -28 -19 0 -26 7 -32 28 -3 15 -61 276 -128 581 -67 305 -126 556 -132 558 -6 2 -14 0 -17 -5z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1334 2456 l-34 -34 0 -110 c0 -104 1 -112 26 -141 14 -17 32 -31 40 -31 9 0 14 -11 14 -30 0 -16 -27 -332 -59 -702 -59 -668 -62 -732 -33 -784 30 -56 128 -110 161 -89 17 10 13 25 -6 25 -9 0 -35 9 -58 20 -55 27 -85 80 -85 151 0 51 103 1258 115 1347 l6 42 385 0 c347 0 384 -2 384 -16 0 -38 121 -1370 125 -1383 10 -27 -16 -90 -49 -119 -19 -16 -50 -32 -69 -36 -41 -8 -56 -23 -33 -32 52 -20 154 45 176 110 8 26 -2 177 -49 712 -33 373 -63 699 -66 724 -4 42 -3 46 24 62 54 30 64 57 63 175 l0 107 -36 33 -36 33 -436 0 -436 0 -34 -34z m899 -8 c40 -21 46 -39 47 -139 0 -108 -13 -133 -72 -144 -18 -3 -212 -5 -431 -3 l-399 3 -24 28 c-22 25 -24 37 -24 118 0 87 1 92 29 120 l29 29 412 0 c294 0 418 -3 433 -12z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2315 1960 c-17 -27 15 -30 307 -30 238 1 303 -2 309 -12 12 -18 11 -160 -1 -178 -8 -13 -56 -16 -300 -20 -181 -3 -291 -9 -293 -15 -1 -6 93 -11 265 -13 l268 -2 2 -426 c3 -443 2 -461 -39 -480 -10 -4 -108 -11 -218 -14 -270 -7 -264 -25 9 -25 159 0 209 3 230 15 56 29 56 32 56 499 0 422 0 430 20 436 32 10 45 53 44 135 -1 41 -2 80 -3 87 -1 7 -11 21 -23 33 -21 19 -34 20 -324 20 -191 0 -305 -4 -309 -10z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1485 1787 c-38 -38 -39 -44 -55 -280 -11 -147 -10 -160 7 -190 34 -58 52 -62 333 -65 310 -4 333 -1 378 44 l35 35 -8 152 c-4 84 -9 177 -10 208 -3 63 -22 100 -61 117 -17 8 -115 12 -305 12 l-281 0 -33 -33z m614 -17 c26 -13 27 -19 41 -231 12 -193 8 -218 -37 -238 -16 -7 -121 -11 -309 -11 l-285 0 -24 25 c-29 28 -31 53 -15 269 11 147 20 178 51 192 29 13 554 8 578 -6z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1565 1610 c-3 -6 0 -12 7 -15 26 -10 458 0 458 10 0 14 -456 19 -465 5z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1532 1448 c6 -16 317 -19 321 -3 1 6 -59 11 -161 13 -129 2 -163 0 -160 -10z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1935 1450 c-3 -5 0 -13 8 -16 23 -9 122 0 122 11 0 14 -122 19 -130 5z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M862 1677 c-21 -23 -22 -29 -22 -281 l0 -257 25 -25 c24 -24 26 -24 190 -22 218 4 224 21 9 28 -116 4 -166 9 -178 19 -14 12 -16 43 -16 256 0 198 3 245 14 254 10 8 74 13 198 14 155 2 183 4 183 17 0 13 -29 15 -191 18 -188 2 -190 2 -212 -21z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2517 1523 c-128 -3 -168 -6 -164 -16 3 -9 52 -13 182 -15 111 -1 184 -7 192 -13 10 -9 13 -58 13 -214 0 -176 -2 -204 -17 -216 -11 -10 -60 -15 -170 -19 -208 -7 -206 -24 4 -28 155 -2 162 -2 188 20 l26 23 0 220 0 220 -26 22 c-14 13 -34 22 -43 21 -9 -1 -93 -4 -185 -5z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1715 721 c-96 -24 -147 -87 -153 -190 -7 -116 35 -174 124 -174 93 0 146 99 101 191 -23 48 -101 67 -145 36 -31 -22 -35 -14 -12 24 24 39 75 72 113 72 22 0 27 4 27 25 0 26 -5 28 -55 16z m9 -182 c31 -24 36 -81 10 -117 -37 -54 -124 -10 -124 64 0 35 37 74 70 74 10 0 29 -9 44 -21z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		 
		construc.push({'path': "M1912 710 c-45 -28 -72 -89 -72 -166 0 -73 14 -120 48 -156 32 -35 71 -43 116 -24 52 22 75 77 76 179 0 94 -17 139 -62 167 -42 25 -64 25 -106 0z m93 -50 c14 -16 20 -41 22 -103 5 -104 -14 -150 -64 -155 -27 -3 -34 2 -50 30 -24 45 -24 170 0 216 21 38 63 44 92 12z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		 
		
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	 
	if (typeObj == "torre-despensa40")
	{
		
		
		
		construc.push({'path': "M5 3548 c-3 -7 -4 -807 -3 -1778 l3 -1765 1181 -3 c986 -2 1183 0 1193 12 8 10 10 478 9 1777 l-3 1764 -1188 3 c-945 2 -1189 0 -1192 -10z m2345 -1768 l0 -1740 -1155 0 -1155 0 0 1740 0 1740 1155 0 1155 0 0 -1740z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M542 3258 c-9 -9 -12 -165 -12 -590 0 -507 -2 -578 -15 -578 -8 0 -15 6 -15 13 0 59 -94 964 -101 972 -6 5 -12 5 -18 0 -7 -8 59 -759 83 -942 5 -42 5 -43 -23 -43 -22 0 -30 6 -34 23 -3 12 -60 272 -127 577 -67 305 -126 559 -131 565 -32 33 -18 -54 97 -574 68 -311 124 -571 124 -578 0 -7 -11 -13 -25 -13 -17 0 -26 7 -30 23 -4 12 -54 190 -113 396 -95 334 -132 434 -132 359 0 -12 47 -189 105 -391 58 -203 105 -373 105 -378 0 -6 -17 -9 -37 -7 l-37 3 -53 184 c-52 184 -65 214 -82 196 -5 -6 11 -78 39 -173 66 -224 63 -209 40 -215 -17 -4 -20 -14 -20 -65 0 -52 -3 -62 -20 -67 -49 -16 -50 -26 -50 -593 l0 -529 23 -34 c37 -55 52 -59 265 -59 164 0 192 2 192 15 0 13 -27 15 -179 15 -192 0 -232 7 -250 46 -17 38 -16 1090 2 1101 6 4 129 10 271 13 195 4 260 8 264 18 3 9 -50 12 -243 12 l-246 0 3 48 3 47 248 3 c192 2 248 5 244 15 -2 6 -22 13 -45 15 l-42 3 0 584 c0 321 -4 586 -8 589 -5 3 -14 0 -20 -6z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M715 2481 c-49 -20 -60 -47 -63 -156 -4 -116 8 -154 58 -180 25 -13 28 -19 24 -47 -11 -84 -116 -1301 -116 -1358 -1 -75 23 -132 72 -173 32 -27 89 -43 116 -33 24 9 9 22 -40 35 -57 14 -102 64 -111 124 -4 26 17 316 54 729 34 377 61 688 61 692 0 3 173 6 384 6 l384 0 6 -52 c3 -29 31 -336 61 -683 30 -346 58 -646 61 -667 8 -54 -24 -110 -79 -137 -24 -12 -51 -21 -60 -21 -21 0 -22 -19 -1 -27 47 -18 154 59 170 122 3 14 -23 350 -58 748 l-64 722 28 15 c52 29 61 53 61 169 0 63 -5 116 -12 129 -27 51 -38 52 -493 51 -233 0 -432 -4 -443 -8z m896 -50 c16 -19 19 -40 19 -122 0 -107 -11 -131 -62 -144 -13 -3 -206 -4 -430 -3 l-407 3 -23 23 c-21 20 -23 32 -23 123 0 98 1 101 28 125 l29 25 425 -3 425 -3 19 -24z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1665 1960 c-17 -27 15 -30 306 -30 164 1 304 -2 309 -5 15 -9 13 -182 -2 -192 -7 -4 -142 -10 -301 -13 -375 -7 -386 -23 -20 -30 l268 -5 3 -415 c1 -228 0 -425 -3 -437 -12 -50 -44 -58 -254 -63 -143 -4 -195 -8 -199 -17 -6 -20 376 -18 423 1 68 29 66 16 65 500 0 304 3 436 10 436 6 0 22 11 35 25 23 22 25 32 25 115 0 83 -2 93 -25 115 l-24 25 -305 0 c-192 0 -307 -4 -311 -10z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M834 1786 c-19 -19 -34 -45 -34 -57 -1 -13 -7 -100 -14 -192 -14 -173 -13 -196 11 -234 31 -47 73 -53 361 -53 398 1 390 -6 367 299 -8 105 -19 200 -25 210 -5 11 -22 29 -36 40 -26 20 -38 21 -311 21 l-285 0 -34 -34z m622 -29 c22 -26 25 -51 40 -302 6 -101 5 -112 -14 -135 l-20 -25 -291 -3 c-313 -3 -341 1 -356 49 -4 12 -1 105 6 208 12 179 13 187 38 211 l26 25 275 -2 275 -2 21 -24z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M917 1614 c-19 -20 25 -24 239 -24 184 0 235 3 232 13 -4 9 -61 13 -234 15 -127 1 -233 -1 -237 -4z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M883 1448 c3 -10 44 -13 162 -13 118 0 159 3 163 13 3 9 -34 12 -163 12 -129 0 -166 -3 -162 -12z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1285 1450 c-9 -15 17 -21 75 -18 32 2 55 8 58 16 5 15 -123 17 -133 2z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M206 1669 l-27 -32 3 -249 3 -250 28 -24 c28 -24 31 -24 193 -22 218 4 223 21 8 28 -116 4 -166 9 -178 19 -14 12 -16 43 -16 255 0 132 4 247 9 254 6 10 54 14 197 15 160 2 189 4 189 17 0 13 -29 15 -191 18 l-192 2 -26 -31z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1872 1520 c-222 -7 -213 -24 15 -28 109 -1 182 -7 190 -13 10 -9 13 -58 13 -214 0 -176 -2 -204 -16 -216 -12 -10 -62 -15 -173 -19 -210 -7 -206 -24 6 -28 156 -2 162 -2 188 20 l27 23 0 220 0 220 -27 22 c-14 13 -34 22 -43 21 -9 -1 -90 -5 -180 -8z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1255 720 c-56 -23 -87 -86 -87 -182 0 -90 28 -153 77 -174 99 -41 174 52 163 204 -6 84 -29 129 -73 148 -38 16 -51 16 -80 4z m82 -67 c25 -38 25 -175 0 -221 -16 -28 -23 -33 -50 -30 -48 5 -69 52 -65 148 4 92 23 130 68 130 21 0 35 -8 47 -27z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M951 604 c-45 -63 -81 -122 -81 -130 0 -11 18 -14 85 -14 l85 0 0 -50 c0 -47 2 -50 25 -50 23 0 25 3 25 50 0 47 2 50 25 50 18 0 25 5 25 20 0 15 -7 20 -25 20 l-25 0 0 110 0 110 -29 0 c-26 0 -38 -13 -110 -116z m89 -24 l0 -80 -55 0 -55 0 52 79 c29 44 54 80 56 80 1 1 2 -35 2 -79z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	  
	if (typeObj == "torre-reducida80")
	{
		
		
		construc.push({'path': "M12 2208 c-17 -17 -17 -2179 0 -2196 17 -17 4709 -17 4726 0 17 17 17 2179 0 2196 -17 17 -4709 17 -4726 0z m4688 -1103 l0 -1065 -2325 0 -2325 0 0 1065 0 1065 2325 0 2325 0 0 -1065z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2178 664 c-53 -28 -63 -85 -24 -131 l24 -27 -29 -27 c-22 -20 -29 -36 -29 -64 0 -74 48 -111 134 -102 98 9 140 104 75 170 -18 18 -27 33 -20 35 16 5 41 56 41 82 0 12 -13 35 -29 51 -24 23 -38 29 -73 29 -24 -1 -55 -7 -70 -16z m109 -50 c15 -24 15 -29 2 -53 -8 -14 -25 -27 -37 -29 -33 -5 -72 24 -72 53 0 56 75 77 107 29z m-2 -159 c30 -29 32 -58 5 -85 -41 -41 -120 -12 -120 45 0 32 33 65 65 65 14 0 37 -11 50 -25z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2461 664 c-81 -57 -81 -281 0 -338 30 -21 88 -21 118 0 38 27 61 90 61 172 0 83 -16 129 -55 160 -33 26 -91 29 -124 6z m97 -45 c51 -54 37 -247 -19 -264 -52 -17 -89 42 -89 141 0 114 57 179 108 123z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	  
	if (typeObj == "torre-reducida60")
	{
		
		construc.push({'path': "M12 2198 c-19 -19 -17 -2171 2 -2187 10 -8 483 -10 1782 -9 l1769 3 0 1100 0 1100 -1770 3 c-1369 1 -1774 -1 -1783 -10z m3518 -1093 l0 -1065 -1740 0 -1740 0 0 1065 0 1065 1740 0 1740 0 0 -1065z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1640 664 c-67 -29 -107 -88 -117 -175 -17 -142 109 -233 203 -146 31 28 37 41 41 83 8 94 -60 150 -148 120 -44 -16 -45 -15 -22 25 18 29 84 69 116 69 10 0 17 8 17 20 0 25 -38 26 -90 4z m47 -162 c23 -15 34 -63 22 -99 -18 -55 -61 -68 -103 -30 -56 50 -32 137 37 137 18 0 37 -4 44 -8z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1866 659 c-58 -46 -80 -146 -52 -241 30 -104 110 -139 179 -78 74 64 77 241 7 312 -36 35 -94 38 -134 7z m106 -50 c22 -29 29 -125 15 -192 -15 -73 -86 -86 -113 -21 -22 52 -18 172 6 212 25 41 63 41 92 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	  
	if (typeObj == "torre-reducida40")  
	{
		construc.push({'path': "M7 2203 c-4 -3 -7 -496 -7 -1093 0 -904 2 -1089 14 -1099 10 -8 329 -10 1192 -9 l1179 3 0 1100 0 1100 -1186 3 c-652 1 -1189 -1 -1192 -5z m2343 -1098 l0 -1065 -1155 0 -1155 0 0 1065 0 1065 1155 0 1155 0 0 -1065z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1011 568 c-44 -62 -80 -123 -81 -135 0 -22 4 -23 80 -23 l80 0 0 -45 c0 -41 2 -45 25 -45 23 0 25 4 25 45 0 41 2 45 25 45 20 0 25 5 25 25 0 20 -5 25 -25 25 l-25 0 0 110 0 110 -25 0 c-20 0 -39 -21 -104 -112z m76 -105 c-3 -2 -25 -3 -51 -1 l-45 3 47 69 47 68 3 -67 c2 -37 1 -69 -1 -72z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1289 665 c-43 -23 -64 -79 -64 -170 0 -124 41 -185 126 -185 46 0 93 51 108 118 14 66 14 78 0 144 -21 94 -94 134 -170 93z m97 -46 c23 -26 32 -152 15 -211 -15 -50 -49 -68 -85 -45 -51 34 -57 206 -9 259 22 24 55 23 79 -3z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
	}
	if (typeObj == "torre-escobero40")
	{
		
		
		construc.push({'path': "M7 3553 c-4 -3 -7 -799 -7 -1768 0 -1472 2 -1764 14 -1774 10 -8 329 -10 1192 -9 l1179 3 0 1775 0 1775 -1186 3 c-652 1 -1189 -1 -1192 -5z m2343 -1773 l0 -1740 -1155 0 -1155 0 0 1740 0 1740 1155 0 1155 0 0 -1740z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1132 3408 c-11 -13 -25 -36 -31 -51 -8 -19 -11 -359 -11 -1077 l0 -1049 -29 -33 c-133 -154 -247 -400 -292 -631 -26 -133 -37 -341 -19 -362 11 -13 67 -15 435 -15 367 0 424 2 435 15 19 23 6 276 -20 390 -52 231 -147 430 -283 598 l-47 57 0 1067 1 1066 -22 23 c-30 32 -87 33 -117 2z m90 -31 c11 -11 13 -205 10 -1070 l-2 -1057 -45 0 -45 0 0 1051 c0 705 3 1057 10 1070 12 22 52 25 72 6z m59 -2204 c83 -95 193 -295 238 -433 39 -120 61 -244 68 -377 l6 -133 -408 0 -408 0 7 117 c18 302 105 551 272 776 l64 87 64 0 c61 0 65 -2 97 -37z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1293 661 c-43 -27 -65 -72 -70 -146 -12 -146 65 -241 161 -201 42 18 65 54 78 126 28 160 -67 284 -169 221z m93 -52 c24 -27 32 -180 12 -218 -29 -54 -86 -54 -109 1 -15 36 -18 137 -6 180 16 58 67 76 103 37z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1011 562 c-41 -58 -77 -117 -79 -129 -4 -22 -2 -23 76 -23 l81 0 3 -47 c3 -41 6 -48 25 -51 20 -3 22 2 25 45 3 41 6 48 26 51 32 5 30 42 -3 42 l-25 0 0 110 0 110 -27 0 c-24 -1 -39 -16 -102 -108z m79 -37 l0 -75 -50 0 c-27 0 -50 2 -50 5 0 3 20 33 45 67 25 34 45 66 45 70 0 4 2 8 5 8 3 0 5 -34 5 -75z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
	
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "torre-frigorifico")
	{
	
		construc.push({'path': "M5 3548 c-3 -7 -4 -807 -3 -1778 l3 -1765 1780 0 1780 0 0 1775 0 1775 -1778 3 c-1417 2 -1779 0 -1782 -10z m1418 -67 c6 -51 46 -137 82 -179 44 -52 123 -100 197 -119 l68 -17 0 -73 0 -72 -127 -3 c-106 -3 -128 -6 -128 -18 0 -12 22 -15 127 -18 l127 -3 3 -67 c2 -52 6 -67 18 -67 12 0 16 15 18 67 l3 67 122 3 c101 3 122 6 122 18 0 12 -22 15 -122 18 l-123 3 0 73 0 73 54 12 c151 34 270 153 295 295 l7 41 682 3 682 2 -2 -1742 -3 -1743 -1740 0 -1740 0 -3 1743 -2 1742 689 0 688 0 6 -39z m694 0 c-12 -92 -98 -200 -195 -244 -36 -16 -66 -21 -132 -21 -74 0 -93 4 -143 29 -94 47 -168 142 -183 234 l-7 41 333 0 333 0 -6 -39z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1725 2778 c-3 -7 -6 -75 -7 -150 l-3 -138 -100 70 c-55 38 -105 70 -111 70 -14 0 -57 -77 -50 -89 3 -5 64 -50 136 -101 l130 -91 0 -215 0 -214 -52 29 c-29 16 -116 64 -193 106 -77 42 -143 79 -147 83 -3 4 -11 66 -17 137 -18 209 -13 195 -72 195 -31 0 -51 -5 -54 -12 -3 -7 1 -66 8 -130 8 -65 11 -118 8 -118 -2 0 -48 25 -102 55 -53 30 -104 55 -112 55 -18 0 -71 -86 -64 -105 3 -7 51 -37 106 -66 56 -29 101 -56 101 -59 0 -3 -45 -28 -101 -55 -55 -28 -104 -57 -109 -65 -8 -15 13 -69 33 -81 5 -4 62 18 126 48 64 30 130 61 146 68 29 13 37 9 228 -95 l198 -108 -196 -107 -196 -107 -52 22 c-29 13 -96 45 -151 72 -54 27 -102 46 -106 41 -5 -4 -15 -25 -24 -45 -19 -48 -15 -52 108 -108 53 -24 96 -47 96 -50 0 -4 -47 -33 -105 -64 -58 -32 -105 -62 -105 -68 0 -19 53 -108 64 -108 6 1 58 27 116 60 57 32 105 58 106 57 0 -1 -5 -56 -12 -122 -15 -137 -12 -145 57 -145 45 0 43 -6 60 196 l12 142 136 76 c75 41 164 91 199 111 l62 35 -2 -212 -3 -212 -130 -93 c-71 -51 -131 -99 -133 -106 -1 -6 10 -27 26 -46 l28 -34 107 72 106 71 3 -127 3 -128 60 0 60 0 3 128 3 127 106 -71 107 -72 28 32 c16 18 28 40 26 49 -2 9 -62 57 -133 107 l-130 91 -3 212 -2 212 58 -32 c32 -18 121 -69 199 -112 l141 -80 12 -115 c23 -227 20 -216 60 -219 66 -5 71 7 59 136 -5 62 -9 117 -7 121 2 5 46 -16 98 -45 52 -30 101 -54 108 -54 15 0 74 89 67 101 -3 4 -50 34 -105 66 -55 31 -100 60 -100 63 0 4 43 26 96 50 123 56 127 60 108 108 -9 20 -19 41 -24 45 -4 5 -47 -11 -96 -36 -49 -24 -117 -57 -151 -72 l-62 -27 -174 96 c-95 53 -181 102 -191 109 -14 10 5 24 136 97 84 46 171 94 193 107 l41 22 144 -68 c80 -37 150 -66 156 -64 18 7 46 74 35 87 -5 6 -55 33 -110 61 -56 27 -101 52 -101 55 0 4 44 30 98 60 53 29 100 57 104 63 9 15 -44 107 -63 107 -9 0 -59 -25 -110 -55 -52 -31 -95 -51 -97 -45 -2 5 1 58 7 116 13 126 9 137 -53 132 l-41 -3 -12 -105 c-7 -58 -16 -132 -20 -164 l-8 -59 -135 -74 c-74 -41 -163 -89 -197 -108 l-63 -35 0 214 0 214 135 94 c82 57 135 100 135 110 0 17 -46 78 -59 78 -4 0 -52 -31 -107 -70 l-99 -70 -5 148 -5 147 -58 3 c-40 2 -59 -1 -62 -10z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1658 660 c-105 -31 -165 -167 -123 -276 51 -134 235 -99 235 46 0 65 -43 109 -105 110 -22 0 -51 -7 -63 -16 -20 -14 -22 -14 -22 2 0 31 71 91 118 99 32 5 42 11 42 26 0 21 -31 24 -82 9z m38 -181 c28 -31 25 -96 -5 -120 -13 -10 -33 -19 -45 -19 -29 0 -62 36 -70 76 -15 67 74 114 120 63z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1855 637 c-73 -73 -68 -249 8 -313 26 -22 38 -25 76 -21 73 8 111 70 111 182 0 115 -46 185 -120 185 -34 0 -48 -6 -75 -33z m113 -32 c41 -52 39 -194 -3 -242 -30 -36 -71 -26 -91 22 -16 40 -19 151 -4 192 21 56 66 69 98 28z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "torre-horno")  
	{
	
		construc.push({'path': "M11 3546 c-8 -10 -10 -482 -9 -1777 l3 -1764 1780 0 1780 0 3 1764 c1 1295 -1 1767 -9 1777 -17 21 -3531 21 -3548 0z m1411 -73 c24 -145 159 -277 305 -299 l43 -6 0 -74 0 -74 -124 0 c-97 0 -126 -3 -136 -15 -18 -21 -4 -24 135 -27 l120 -3 3 -57 3 -58 -630 0 c-612 0 -632 -1 -685 -21 -70 -26 -139 -92 -174 -167 l-27 -57 0 -1005 c0 -946 1 -1008 18 -1057 24 -70 93 -145 165 -180 l57 -28 475 0 c416 0 475 2 475 15 0 13 -61 16 -470 20 -452 5 -472 6 -516 26 -58 27 -110 79 -140 140 l-24 49 0 1005 0 1005 28 57 c16 32 46 73 69 92 81 70 -5 66 1393 66 1407 0 1313 5 1398 -70 26 -23 53 -60 66 -89 l21 -51 0 -1011 c0 -967 -1 -1013 -19 -1053 -24 -55 -82 -113 -140 -140 -44 -20 -61 -21 -513 -24 -391 -2 -468 -5 -478 -17 -10 -12 -9 -16 2 -20 8 -3 226 -5 484 -3 465 3 469 3 519 26 65 30 139 103 165 163 20 48 20 58 20 1071 l0 1023 -30 62 c-37 74 -92 125 -167 153 -52 19 -77 20 -678 20 l-625 0 0 60 0 60 118 0 c65 0 122 3 125 7 4 3 2 12 -4 20 -8 9 -42 13 -125 13 l-114 0 0 74 0 74 44 6 c66 10 158 60 206 112 47 51 89 136 97 195 l6 39 683 0 684 0 0 -1740 0 -1740 -1745 0 -1745 0 0 1740 0 1740 687 -2 687 -3 8 -42z m694 6 c-15 -92 -92 -191 -185 -236 -49 -24 -68 -28 -146 -28 -79 0 -97 4 -143 28 -97 51 -167 144 -179 237 l-6 40 333 0 333 0 -7 -41z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M885 3311 c-87 -38 -106 -165 -34 -225 56 -48 131 -47 181 1 86 82 38 221 -79 229 -26 2 -57 0 -68 -5z m105 -46 c17 -9 33 -28 39 -48 38 -114 -122 -179 -174 -71 -40 86 48 164 135 119z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2563 3301 c-45 -28 -66 -65 -66 -116 0 -156 220 -184 264 -34 34 111 -100 212 -198 150z m122 -37 c55 -36 51 -130 -6 -159 -90 -47 -177 41 -129 130 23 44 91 58 135 29z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M687 2313 c-4 -3 -2 -12 4 -20 17 -20 2171 -20 2188 0 6 8 8 17 4 20 -8 9 -2188 9 -2196 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M690 1595 c-10 -12 -10 -16 1 -20 8 -3 504 -4 1104 -3 961 3 1090 5 1090 18 0 13 -129 15 -1091 18 -958 2 -1093 0 -1104 -13z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M692 878 c-8 -8 -9 -15 -1 -25 9 -11 208 -13 1093 -13 1110 0 1125 0 1095 37 -16 18 -2168 20 -2187 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1635 651 c-96 -43 -143 -174 -101 -276 43 -103 191 -95 227 12 32 99 -54 187 -147 148 -39 -16 -40 -15 -18 26 15 30 80 68 117 69 10 0 17 8 17 20 0 26 -40 27 -95 1z m57 -168 c23 -20 25 -95 3 -117 -49 -49 -125 -5 -125 73 0 50 82 80 122 44z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1852 641 c-71 -72 -69 -236 4 -309 31 -31 39 -34 75 -29 69 9 105 57 115 155 8 76 -16 162 -52 191 -41 33 -105 29 -142 -8z m114 -32 c15 -16 20 -40 23 -105 3 -91 -9 -138 -41 -155 -62 -33 -111 72 -88 192 16 85 63 115 106 68z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	if (typeObj == "torre-horno-micro")
	{
		
		construc.push({'path': "M12 3548 c-17 -17 -17 -3519 0 -3536 17 -17 3529 -17 3546 0 17 17 17 3519 0 3536 -17 17 -3529 17 -3546 0z m1031 -67 c8 -59 50 -144 97 -195 48 -52 140 -102 206 -112 38 -5 44 -10 44 -30 0 -24 0 -24 -119 -24 -87 0 -122 -4 -130 -13 -6 -8 -8 -17 -4 -20 3 -4 62 -7 129 -7 l123 0 3 -117 c2 -97 6 -118 18 -118 12 0 16 21 18 118 l3 117 123 0 c67 0 126 3 129 7 4 3 2 12 -4 20 -8 9 -43 13 -130 13 -118 0 -119 0 -119 24 0 20 6 24 43 29 67 9 132 42 188 94 61 57 93 110 113 183 13 52 14 54 21 25 36 -158 156 -277 305 -302 37 -7 22 -9 -80 -13 -102 -4 -125 -8 -125 -20 0 -12 22 -15 123 -18 122 -3 122 -3 122 -27 0 -24 0 -24 -122 -27 -101 -3 -123 -6 -123 -18 0 -12 21 -15 122 -18 l122 -3 3 -92 c2 -74 6 -92 18 -92 12 0 16 18 18 92 l3 92 127 3 c105 3 127 6 127 18 0 12 -22 15 -127 18 l-128 3 0 24 0 24 128 3 c105 3 127 6 127 18 0 12 -23 16 -130 20 -109 4 -122 6 -79 13 145 21 272 145 305 297 l11 50 494 0 494 0 0 -860 0 -860 -1745 0 -1745 0 0 860 0 860 499 0 498 0 6 -39z m693 -13 c-17 -71 -39 -112 -90 -162 -69 -70 -124 -91 -236 -91 -87 0 -100 3 -148 30 -70 38 -136 112 -161 181 -39 103 -69 94 313 94 l334 0 -12 -52z m758 20 c-3 -18 -19 -61 -35 -95 -94 -197 -353 -245 -518 -97 -52 47 -95 122 -107 187 l-6 37 336 0 336 0 -6 -32z m1036 -2588 l0 -860 -1745 0 -1745 0 0 860 0 860 1745 0 1745 0 0 -860z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M874 3431 c-35 -21 -64 -75 -64 -118 0 -96 114 -163 201 -118 90 47 90 193 0 240 -40 20 -99 19 -137 -4z m137 -50 c76 -76 -17 -202 -112 -151 -10 6 -26 25 -35 42 -50 96 70 186 147 109z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2574 3441 c-30 -13 -71 -66 -79 -101 -14 -66 40 -146 108 -157 47 -7 79 1 116 33 89 75 41 222 -76 230 -26 2 -57 0 -69 -5z m99 -42 c45 -21 63 -85 37 -134 -35 -66 -145 -55 -169 18 -28 84 51 153 132 116z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M484 3099 c-49 -14 -125 -69 -161 -117 -59 -77 -66 -119 -71 -402 -5 -345 11 -423 112 -518 100 -95 -25 -87 1431 -87 l1280 0 57 28 c33 16 76 49 102 78 74 83 77 100 77 469 -1 320 -1 323 -25 376 -33 71 -102 137 -172 163 -50 19 -77 21 -313 21 -217 0 -261 -2 -271 -15 -10 -12 -10 -16 1 -20 8 -2 133 -6 279 -7 260 -3 266 -4 313 -28 56 -28 102 -76 128 -134 17 -37 19 -71 19 -361 0 -315 -1 -321 -24 -370 -28 -60 -74 -107 -135 -138 l-46 -22 -1275 0 -1275 0 -57 28 c-61 30 -95 64 -131 131 -21 39 -22 54 -25 344 -3 343 1 377 63 450 20 23 58 54 83 70 l47 27 265 3 c146 1 271 5 279 7 11 4 11 8 1 20 -10 13 -53 15 -269 14 -141 0 -270 -5 -287 -10z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M687 2773 c-4 -3 -2 -12 4 -20 17 -20 2171 -20 2188 0 6 8 8 17 4 20 -8 9 -2188 9 -2196 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M687 2553 c-4 -3 -2 -12 4 -20 17 -20 2171 -20 2188 0 6 8 8 17 4 20 -8 9 -2188 9 -2196 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M691 2327 c-6 -8 -8 -17 -4 -20 8 -9 2188 -9 2196 0 4 3 2 12 -4 20 -17 20 -2171 20 -2188 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M512 1588 c-57 -10 -111 -40 -158 -90 -96 -100 -104 -144 -104 -597 0 -299 3 -374 16 -424 31 -120 85 -190 183 -236 l56 -26 1020 0 1020 0 67 33 c72 35 115 79 149 151 20 43 21 59 21 506 l0 462 -25 49 c-14 27 -47 70 -74 95 -91 85 -11 79 -1135 82 -548 1 -1014 -1 -1036 -5z m2086 -64 c56 -28 92 -64 123 -126 20 -38 20 -58 20 -494 l0 -455 -28 -51 c-34 -63 -95 -112 -165 -133 -78 -23 -1968 -23 -2046 0 -69 21 -129 69 -166 135 l-31 55 0 450 0 450 29 53 c17 30 47 67 67 83 78 62 10 58 1125 59 l1020 0 52 -26z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1775 1316 c-86 -20 -221 -74 -254 -102 -38 -32 -141 -79 -216 -99 -33 -9 -107 -19 -165 -22 -130 -7 -240 13 -355 64 -103 45 -125 50 -125 29 0 -20 133 -85 225 -111 94 -26 275 -31 376 -11 108 22 214 65 287 115 32 23 99 55 152 73 90 31 102 32 245 33 165 0 235 -15 359 -76 67 -33 89 -36 84 -12 -4 22 -88 65 -193 99 -68 23 -102 27 -220 30 -94 2 -160 -1 -200 -10z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1802 1029 c-76 -13 -168 -45 -242 -86 -206 -114 -281 -136 -460 -136 -145 0 -235 20 -347 77 -43 21 -74 31 -82 26 -23 -13 -2 -31 83 -70 127 -59 200 -74 351 -74 189 1 238 17 505 154 111 58 191 75 345 74 149 0 215 -14 342 -74 81 -38 93 -39 93 -13 0 27 -182 101 -304 122 -70 13 -208 12 -284 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1629 700 c-92 -49 -136 -176 -95 -275 41 -97 182 -96 223 2 42 102 -44 200 -140 159 -31 -13 -37 -13 -37 -1 0 28 69 85 110 91 30 5 40 11 40 25 0 26 -52 25 -101 -1z m64 -168 c11 -10 17 -30 17 -58 0 -34 -5 -47 -26 -63 -33 -26 -45 -26 -77 -1 -48 38 -47 109 1 135 29 15 57 11 85 -13z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1851 691 c-71 -76 -68 -236 5 -309 31 -31 39 -34 77 -29 55 7 91 48 106 116 14 65 14 77 0 143 -16 74 -52 108 -114 108 -39 0 -52 -5 -74 -29z m115 -32 c23 -26 32 -152 15 -210 -20 -65 -77 -76 -105 -21 -33 64 -27 192 11 234 22 24 56 23 79 -3z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2164 709 c-9 -15 2 -23 61 -44 28 -9 70 -28 94 -41 50 -27 71 -30 71 -10 0 21 -34 42 -122 76 -86 33 -94 35 -104 19z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M662 613 c5 -27 139 -89 243 -114 113 -26 268 -28 375 -4 89 21 110 30 110 52 0 11 -6 14 -22 10 -132 -30 -177 -37 -268 -37 -126 0 -242 25 -346 75 -82 40 -97 42 -92 18z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M3085 1350 c-67 -27 -97 -132 -55 -198 53 -84 176 -79 230 10 53 87 -13 199 -115 197 -22 0 -49 -4 -60 -9z m118 -50 c71 -56 25 -170 -68 -170 -41 0 -85 50 -85 97 0 21 6 45 13 54 33 42 99 51 140 19z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M3073 810 c-87 -53 -82 -189 8 -236 78 -40 184 15 196 103 15 112 -108 192 -204 133z m123 -35 c28 -19 48 -69 40 -101 -10 -40 -53 -74 -93 -74 -49 0 -93 45 -93 95 0 73 88 121 146 80z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	
	if (typeObj == "mueble-alto-termoelectrico")
	{
	
		construc.push({'path': "M12 2378 c-17 -17 -17 -2349 0 -2366 17 -17 3529 -17 3546 0 17 17 17 2349 0 2366 -17 17 -3529 17 -3546 0z m272 -72 c10 -66 60 -158 112 -206 51 -47 136 -89 195 -97 33 -5 39 -9 39 -29 0 -24 -1 -24 -119 -24 -87 0 -122 -4 -130 -13 -6 -8 -8 -17 -4 -20 3 -4 62 -7 130 -7 l123 0 0 -114 c0 -83 4 -117 13 -125 8 -6 17 -8 20 -4 4 3 7 60 7 125 l0 118 103 0 102 0 0 -128 0 -128 39 -79 c30 -61 36 -80 25 -83 -8 -3 -37 -28 -66 -58 -65 -66 -88 -133 -81 -238 4 -59 11 -82 42 -134 71 -119 98 -188 99 -250 1 -63 -13 -97 -89 -210 -53 -79 -71 -132 -58 -169 5 -15 34 -47 64 -72 30 -24 53 -49 51 -55 -11 -33 -4 -86 14 -106 40 -44 175 -108 175 -82 0 4 4 13 9 20 7 11 16 10 49 -7 42 -21 72 -27 72 -13 0 15 -16 30 -50 47 -19 10 -36 19 -38 20 -2 2 4 17 12 33 l16 31 45 -25 c24 -14 49 -23 54 -19 17 10 1 34 -38 56 -32 18 -37 25 -33 49 4 26 -2 32 -53 62 -95 56 -103 59 -130 52 -14 -4 -36 -19 -47 -35 -12 -16 -27 -29 -33 -29 -22 0 -105 81 -105 103 0 11 19 52 43 90 23 38 52 85 64 105 13 21 30 60 39 87 23 72 7 139 -72 293 -54 106 -64 133 -64 176 0 101 46 194 113 230 l34 19 56 -44 55 -44 4 -405 c3 -368 5 -408 21 -433 22 -34 81 -72 172 -109 94 -39 105 -52 112 -127 5 -55 10 -65 38 -87 l32 -24 307 0 c265 0 311 2 339 16 43 22 47 30 47 91 0 59 31 106 76 117 14 4 59 23 100 43 130 64 134 79 134 553 0 224 4 360 10 360 5 0 39 28 75 61 190 178 204 465 32 655 -120 133 -313 188 -478 137 -30 -9 -56 -16 -59 -16 -3 1 -65 6 -137 13 -101 9 -164 9 -262 0 -110 -10 -137 -9 -188 4 -115 30 -244 16 -348 -36 -56 -29 -152 -124 -187 -185 l-30 -53 -114 0 c-113 0 -114 0 -114 24 0 20 6 24 46 30 143 19 263 130 301 278 l17 68 1248 0 1248 0 0 -1155 0 -1155 -1745 0 -1745 0 0 1155 0 1155 119 0 119 0 6 -44z m706 36 c0 -5 -7 -33 -16 -62 -31 -104 -105 -184 -204 -221 -73 -28 -194 -23 -258 10 -95 49 -170 147 -188 244 l-6 37 336 0 c185 0 336 -4 336 -8z m431 -143 c117 -25 233 -108 292 -210 84 -142 71 -340 -31 -474 -232 -306 -709 -187 -774 193 -49 290 225 553 513 491z m900 1 c129 -24 245 -114 306 -237 32 -65 37 -86 41 -162 7 -145 -34 -248 -137 -344 -211 -198 -553 -133 -682 129 -29 59 -34 79 -37 165 -3 73 0 110 13 151 68 211 280 338 496 298z m-359 -26 c14 -4 5 -17 -42 -61 -42 -39 -71 -77 -96 -129 l-37 -73 -28 59 c-34 73 -80 132 -133 171 -45 33 -40 37 49 42 68 4 261 -2 287 -9z m-143 -599 c55 -118 178 -222 300 -255 63 -17 197 -14 250 4 24 9 47 16 52 16 12 0 12 -679 0 -716 -5 -16 -12 -41 -15 -56 -8 -33 -52 -63 -151 -103 -38 -15 -78 -35 -89 -44 -25 -21 -46 -73 -46 -111 0 -17 -5 -40 -10 -51 -10 -18 -25 -19 -329 -19 -243 0 -321 3 -328 13 -6 6 -13 36 -16 66 -9 73 -45 110 -148 151 -43 18 -95 47 -116 65 l-38 33 -3 392 c-3 375 -2 392 15 385 103 -43 229 -49 335 -16 120 38 227 136 279 255 13 31 25 56 26 56 0 0 15 -29 32 -65z m-722 -1229 l53 -29 -42 -79 c-23 -43 -46 -78 -51 -78 -17 0 -98 52 -112 73 -12 17 -12 25 1 55 8 20 26 51 40 69 27 36 27 36 111 -11z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1319 2084 c-46 -109 -93 -200 -130 -255 -24 -35 -50 -77 -56 -93 -22 -49 -16 -118 15 -177 75 -145 272 -156 367 -21 27 40 30 51 30 120 l0 77 -59 88 c-32 49 -77 130 -98 180 -22 51 -44 96 -48 101 -5 5 -14 -3 -21 -20z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M2223 2093 c-30 -86 -74 -176 -124 -253 -61 -92 -79 -133 -79 -180 0 -51 23 -103 62 -146 123 -134 339 -66 373 117 10 52 -10 112 -61 186 -52 75 -95 158 -125 238 -21 57 -35 68 -46 38z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1726 1351 c-53 -82 -96 -156 -96 -165 0 -19 17 -30 25 -16 3 5 19 10 35 10 l29 0 3 -157 c3 -130 6 -158 17 -158 8 0 59 69 113 153 95 149 119 203 81 187 -10 -4 -30 -10 -45 -13 l-27 -4 -3 153 c-4 205 -7 205 -132 10z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1631 695 c-78 -25 -134 -97 -146 -191 -18 -135 75 -233 183 -192 49 18 82 69 82 124 0 60 -14 91 -52 114 -39 24 -78 25 -118 5 -27 -14 -30 -14 -30 0 0 31 64 87 115 100 38 9 50 17 50 31 0 24 -27 27 -84 9z m40 -192 c42 -36 24 -136 -25 -149 -59 -15 -106 27 -106 94 0 28 29 65 60 74 20 6 52 -2 71 -19z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1890 703 c-24 -9 -60 -45 -78 -78 -12 -21 -16 -56 -16 -120 0 -74 4 -98 22 -133 23 -42 67 -72 108 -72 34 0 82 32 103 71 32 56 38 175 14 244 -26 73 -92 110 -153 88z m78 -64 c55 -58 37 -270 -23 -285 -39 -10 -62 4 -79 47 -30 74 -14 225 27 251 22 14 56 8 75 -13z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
	}
	  
	  
	if (typeObj == "mueble-alto-microondas")
	{
		
		construc.push({'path': "M12 2378 c-17 -17 -17 -2349 0 -2366 17 -17 3529 -17 3546 0 17 17 17 2349 0 2366 -17 17 -3529 17 -3546 0z m272 -72 c10 -66 60 -158 112 -206 51 -47 136 -89 195 -97 33 -5 39 -9 39 -29 0 -24 -1 -24 -119 -24 -87 0 -122 -4 -130 -13 -6 -8 -8 -17 -4 -20 3 -4 62 -7 130 -7 67 0 123 -4 123 -9 0 -4 -26 -14 -58 -20 -106 -21 -204 -105 -239 -205 -16 -46 -18 -94 -18 -486 l0 -435 26 -55 c51 -110 130 -169 249 -190 42 -7 201 -10 450 -8 334 3 385 5 385 18 0 13 -56 16 -425 20 -407 5 -427 6 -471 26 -66 31 -123 86 -150 147 l-24 52 0 435 c0 432 0 435 23 481 42 86 131 153 212 161 l35 3 3 -80 c3 -76 14 -111 33 -99 5 3 9 43 9 90 l0 84 938 2 c515 0 951 0 967 -1 44 -3 130 -48 160 -83 14 -17 35 -48 46 -70 19 -38 20 -58 20 -489 0 -417 -2 -452 -19 -492 -25 -57 -76 -105 -142 -136 -52 -24 -66 -26 -275 -31 -187 -4 -220 -7 -220 -20 0 -13 32 -15 225 -15 l225 0 62 29 c72 33 135 95 165 162 18 43 19 68 19 504 l0 458 -24 48 c-33 65 -91 121 -154 151 l-52 24 -970 -1 c-863 0 -971 1 -971 15 0 13 20 15 123 15 68 0 127 3 130 7 4 3 2 12 -4 20 -8 9 -43 13 -130 13 -118 0 -119 0 -119 24 0 20 6 24 46 30 143 19 263 130 301 278 l17 68 1248 0 1248 0 0 -1155 0 -1155 -1745 0 -1745 0 0 1155 0 1155 119 0 119 0 6 -44z m700 7 c-19 -107 -108 -214 -209 -252 -79 -30 -197 -26 -263 8 -95 49 -170 147 -188 244 l-6 37 336 0 337 0 -7 -37z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});

		construc.push({'path': "M3109 1611 c-35 -34 -39 -44 -39 -87 0 -129 138 -191 227 -101 90 89 28 227 -101 227 -43 0 -53 -4 -87 -39z m162 -30 c61 -62 14 -161 -76 -161 -42 0 -85 50 -85 98 0 86 99 125 161 63z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1806 1600 c-72 -18 -123 -41 -308 -136 -100 -52 -203 -75 -333 -76 -147 0 -237 20 -373 85 -44 21 -66 27 -73 20 -17 -17 27 -50 113 -83 128 -49 201 -63 333 -63 179 1 234 18 495 154 115 59 233 83 383 76 132 -5 215 -26 319 -78 64 -32 88 -36 88 -14 0 18 -110 75 -205 105 -102 33 -328 38 -439 10z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		
		construc.push({'path': "M1920 1334 c-84 -10 -211 -48 -280 -84 -248 -129 -282 -140 -455 -147 -142 -6 -248 15 -373 72 -42 20 -82 33 -89 31 -26 -10 1 -35 75 -69 131 -60 189 -71 357 -72 206 0 232 7 506 150 202 105 476 105 695 0 82 -40 97 -42 92 -17 -4 23 -136 87 -231 111 -75 20 -232 33 -297 25z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M3133 1100 c-57 -34 -81 -119 -50 -180 32 -63 130 -89 193 -51 35 21 64 75 64 118 0 99 -121 166 -207 113z m123 -38 c33 -26 47 -60 40 -98 -14 -70 -97 -97 -155 -48 -87 73 27 218 115 146z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1855 1035 c-113 -21 -263 -82 -294 -119 -7 -8 -45 -28 -86 -45 -220 -92 -463 -86 -672 16 -51 25 -77 33 -84 26 -26 -26 109 -94 256 -129 92 -23 276 -23 368 0 88 21 210 72 247 103 38 32 139 76 225 99 51 13 104 18 195 17 145 0 238 -21 352 -78 52 -27 74 -33 82 -25 28 29 -135 106 -283 134 -99 19 -209 19 -306 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1715 675 c-5 -2 -27 -6 -48 -10 -80 -13 -147 -110 -147 -211 0 -70 49 -139 105 -150 126 -23 201 160 93 226 -40 24 -69 25 -108 5 -35 -18 -37 -12 -11 31 20 32 74 64 110 64 12 0 24 7 28 16 6 17 -6 33 -22 29z m-28 -180 c27 -19 37 -63 23 -101 -14 -35 -26 -44 -66 -44 -36 0 -51 14 -64 60 -20 69 50 125 107 85z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		construc.push({'path': "M1882 664 c-51 -26 -75 -83 -75 -174 0 -91 19 -142 65 -170 90 -57 178 29 178 174 0 134 -79 214 -168 170z m95 -66 c12 -23 17 -56 17 -108 0 -94 -21 -140 -63 -140 -51 0 -66 30 -66 134 0 109 16 146 65 146 23 0 33 -7 47 -32z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue escaladogeneral"});
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
			
	}  
	  
	  
	if (typeObj == "placa-electrica60")
	{
		
		construc.push({'path': "M12 3548 c-17 -17 -17 -3519 0 -3536 17 -17 3529 -17 3546 0 17 17 17 3519 0 3536 -17 17 -3529 17 -3546 0z m2691 -73 c9 -65 58 -154 112 -204 52 -48 136 -90 196 -98 33 -5 39 -9 39 -29 0 -24 -1 -24 -119 -24 -93 0 -121 -3 -131 -15 -18 -21 -4 -24 130 -27 l115 -3 3 -110 c3 -129 6 -143 27 -125 12 10 15 38 15 126 l0 114 123 0 c68 0 127 3 130 7 4 3 2 12 -4 20 -8 9 -43 13 -130 13 -118 0 -119 0 -119 24 0 20 6 24 39 29 21 2 66 17 100 32 109 49 211 187 211 285 0 28 2 30 40 30 l40 0 0 -1740 0 -1740 -1740 0 -1740 0 0 1740 0 1740 1329 0 1328 0 6 -45z m694 5 c-12 -93 -82 -186 -179 -237 -47 -25 -63 -28 -148 -28 -84 0 -101 3 -147 28 -94 49 -164 141 -179 236 l-7 41 333 0 333 0 -6 -40z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M873 3045 c-80 -22 -145 -59 -211 -119 -198 -184 -204 -504 -12 -696 192 -192 495 -194 688 -3 160 158 192 402 78 598 -33 56 -132 148 -194 179 -108 55 -240 70 -349 41z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2463 3045 c-120 -33 -223 -109 -293 -217 -54 -82 -73 -164 -68 -285 3 -88 7 -106 41 -176 92 -195 307 -311 511 -278 336 55 515 408 361 710 -98 195 -341 302 -552 246z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M883 1466 c-126 -31 -261 -134 -316 -241 -75 -150 -76 -327 -1 -464 205 -377 757 -328 894 79 29 86 30 210 2 297 -77 242 -334 388 -579 329z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2468 1464 c-118 -28 -231 -109 -297 -213 -54 -85 -73 -162 -69 -281 3 -96 6 -111 40 -182 60 -126 155 -213 284 -259 82 -30 235 -31 315 -2 201 74 329 253 329 462 0 137 -47 250 -144 347 -122 121 -291 169 -458 128z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1645 665 c-167 -59 -167 -355 1 -355 111 0 164 151 77 220 -28 22 -91 27 -124 10 -23 -13 -24 -6 -2 30 17 30 58 55 106 65 18 4 27 12 27 25 0 24 -27 26 -85 5z m49 -177 c23 -32 20 -94 -4 -118 -47 -47 -120 -3 -120 71 0 59 92 94 124 47z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1855 647 c-72 -72 -75 -239 -5 -309 57 -57 152 -25 181 60 18 53 16 170 -4 209 -41 78 -116 96 -172 40z m95 -17 c26 -14 40 -63 40 -139 0 -87 -23 -136 -64 -136 -49 0 -71 41 -70 133 0 116 37 172 94 142z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
				

        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
	}  
	 
	if (typeObj == "placa-electrica40")
	{
		
		construc.push({'path': "M11 3546 c-8 -10 -10 -482 -9 -1777 l3 -1764 1179 -3 c863 -1 1182 1 1192 9 19 16 21 3518 2 3537 -19 19 -2351 17 -2367 -2z m1513 -70 c10 -66 60 -158 112 -206 52 -48 130 -87 191 -96 37 -5 43 -10 43 -30 0 -24 0 -24 -119 -24 -87 0 -122 -4 -130 -13 -6 -8 -8 -17 -4 -20 3 -4 62 -7 129 -7 l123 0 3 -117 c2 -97 6 -118 18 -118 12 0 16 21 18 118 l3 117 123 0 c67 0 126 3 129 7 4 3 2 12 -4 20 -8 9 -43 13 -130 13 -118 0 -119 0 -119 24 0 20 6 24 43 29 135 19 276 148 302 277 13 69 14 70 56 70 l39 0 0 -1740 0 -1740 -1155 0 -1155 0 0 1740 0 1740 739 0 739 0 6 -44z m695 -1 c-18 -96 -91 -190 -184 -236 -42 -20 -64 -24 -145 -24 -87 0 -100 3 -148 30 -70 38 -136 112 -161 181 -39 103 -69 94 313 94 l333 0 -8 -45z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1063 2975 c-121 -34 -213 -110 -264 -219 -146 -313 157 -655 483 -545 114 38 188 106 242 219 28 58 31 74 30 155 -1 145 -56 253 -167 329 -98 67 -222 90 -324 61z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1038 1701 c-72 -23 -113 -49 -164 -103 -85 -89 -120 -187 -111 -305 21 -282 319 -452 574 -328 189 93 273 330 184 520 -87 187 -290 277 -483 216z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1226 649 c-40 -34 -56 -79 -56 -154 0 -113 46 -185 118 -185 81 0 122 63 122 185 0 86 -15 132 -55 163 -40 32 -87 29 -129 -9z m94 -19 c26 -14 40 -63 40 -137 0 -81 -20 -130 -56 -139 -56 -14 -93 71 -79 181 7 56 35 105 61 105 9 0 24 -4 34 -10z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M956 561 c-42 -60 -76 -119 -76 -130 0 -20 6 -21 79 -21 l80 0 3 -47 c3 -41 6 -48 26 -51 20 -3 22 0 22 47 0 48 2 51 25 51 18 0 25 5 25 20 0 15 -7 20 -25 20 l-25 0 0 110 0 110 -29 0 c-24 0 -38 -14 -105 -109z m84 -36 l0 -75 -50 0 c-27 0 -50 3 -50 7 0 7 92 143 97 143 2 0 3 -34 3 -75z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
				

        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
	}  
	if (typeObj == "placa-electrica-horno60")
	{
		
		construc.push({'path': "M11 4016 c-8 -10 -10 -479 -9 -1777 l3 -1764 1775 0 1775 0 0 1775 0 1775 -1766 3 c-1479 2 -1768 0 -1778 -12z m1938 -76 c32 -147 160 -274 300 -296 35 -6 41 -10 41 -30 0 -24 0 -24 -119 -24 -87 0 -122 -4 -130 -13 -6 -8 -8 -17 -4 -20 3 -4 62 -7 130 -7 l123 0 0 -46 c0 -44 -4 -51 -58 -104 -266 -264 -168 -703 184 -831 87 -32 246 -32 329 1 355 137 449 571 181 828 -92 89 -210 142 -315 142 -35 0 -42 3 -33 12 8 8 9 15 1 25 -8 9 -44 13 -130 13 -119 0 -119 0 -119 24 0 20 6 24 48 30 142 19 259 127 303 280 12 40 18 52 18 34 2 -54 42 -138 93 -194 58 -62 143 -110 216 -122 37 -6 21 -8 -83 -12 -107 -4 -130 -8 -130 -20 0 -12 22 -15 128 -18 l127 -3 0 -24 0 -24 -127 -3 c-106 -3 -128 -6 -128 -18 0 -12 22 -15 128 -18 l127 -3 0 -93 c0 -97 4 -113 27 -95 9 8 13 38 13 100 l0 88 123 3 c100 3 122 6 122 18 0 12 -22 15 -122 18 -123 3 -123 3 -123 27 0 24 0 24 123 27 100 3 122 6 122 18 0 12 -23 16 -125 20 -89 4 -113 7 -83 11 62 10 146 52 196 98 53 49 105 142 113 205 7 46 7 46 45 46 l39 0 0 -1740 0 -1740 -1740 0 -1740 0 0 1740 0 1740 949 0 949 0 11 -50z m697 13 c-19 -108 -109 -214 -214 -253 -74 -28 -186 -24 -253 8 -97 47 -175 148 -193 250 l-5 32 335 0 336 0 -6 -37z m750 -4 c-15 -93 -87 -188 -181 -237 -44 -24 -61 -27 -145 -27 -81 0 -103 4 -145 25 -94 46 -170 146 -182 240 l-6 40 333 0 333 0 -7 -41z m-910 -415 c-38 -9 -86 -24 -107 -35 -21 -10 -41 -19 -44 -19 -7 0 -6 55 2 63 3 4 54 7 112 6 l106 -1 -69 -14z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M840 3517 c-134 -45 -237 -137 -296 -262 -137 -288 27 -626 338 -700 341 -80 662 216 608 561 -29 187 -168 349 -348 404 -90 28 -216 27 -302 -3z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M867 1945 c-241 -66 -404 -309 -367 -547 33 -215 170 -369 377 -423 191 -50 407 30 524 193 74 105 108 245 89 368 -31 196 -178 358 -371 409 -66 18 -187 18 -252 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M2453 1945 c-83 -23 -152 -63 -219 -127 -207 -199 -206 -523 3 -718 74 -69 137 -104 225 -125 417 -98 756 335 562 717 -36 71 -132 169 -203 207 -111 59 -253 77 -368 46z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1647 1135 c-81 -28 -126 -100 -127 -198 0 -98 47 -157 126 -157 109 0 163 152 77 220 -31 24 -99 27 -130 5 -20 -14 -21 -13 -16 5 10 37 58 79 107 91 34 8 46 16 46 30 0 23 -28 24 -83 4z m43 -175 c43 -43 13 -140 -44 -140 -61 0 -101 95 -57 139 27 27 75 27 101 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M1872 1138 c-88 -43 -98 -273 -15 -338 34 -27 92 -26 128 2 40 31 55 77 55 163 0 42 -6 90 -14 109 -27 65 -94 93 -154 64z m78 -38 c26 -14 40 -63 40 -137 0 -80 -20 -130 -55 -139 -64 -16 -107 106 -75 215 17 61 49 83 90 61z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		construc.push({'path': "M504 349 c-3 -6 -2 -15 3 -20 5 -5 531 -8 1309 -7 1147 3 1299 5 1299 18 0 13 -152 15 -1302 18 -932 1 -1304 -1 -1309 -9z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});

		
		construc.push({'path': "M602 136 c-45 -52 -82 -102 -82 -110 0 -34 31 -13 100 69 40 47 73 85 75 85 2 0 35 -38 74 -85 40 -47 77 -85 84 -85 7 0 38 32 71 70 96 114 82 112 162 15 38 -47 74 -85 81 -85 7 0 44 38 84 85 39 47 72 85 73 85 1 0 35 -38 75 -85 41 -47 79 -85 85 -85 6 0 43 38 81 85 39 46 73 83 76 82 3 -1 38 -39 78 -84 40 -46 76 -83 81 -83 6 0 42 38 82 85 49 59 75 82 83 75 6 -5 40 -43 75 -85 36 -41 70 -75 76 -75 7 0 44 38 83 85 40 47 73 85 75 85 1 0 35 -38 75 -85 40 -47 78 -85 85 -85 10 0 62 57 137 152 16 21 17 20 55 -23 22 -24 58 -64 82 -89 l42 -45 38 40 c20 22 55 62 78 89 l40 49 74 -87 c71 -83 100 -103 100 -70 0 20 -158 204 -175 204 -7 0 -45 -38 -84 -85 l-72 -85 -75 85 c-42 47 -81 85 -87 85 -10 0 -77 -74 -138 -152 -15 -19 -18 -17 -90 66 -41 47 -79 86 -86 86 -7 0 -44 -39 -84 -86 -58 -68 -74 -83 -84 -72 -6 7 -40 46 -75 86 -34 39 -68 72 -75 72 -7 0 -44 -38 -83 -85 l-70 -85 -74 84 c-40 46 -80 85 -88 85 -8 1 -46 -37 -84 -84 -39 -47 -71 -85 -72 -85 -1 0 -34 38 -75 85 -40 47 -78 85 -85 85 -7 0 -45 -38 -84 -85 l-72 -85 -69 83 c-39 45 -76 83 -83 85 -10 2 -87 -77 -156 -161 -4 -4 -40 30 -80 78 -40 47 -77 85 -84 85 -6 0 -49 -42 -94 -94z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro escaladogeneral"});
		
		
        construc.params.width = 35;
        construc.params.height = 35;
        construc.params.rotate = true;
		
		
	}   
	  
	if (typeObj == 'bajo1' || typeObj == 'secadora' || typeObj == 'calentador_gas' || typeObj == 'lavadero')
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
		
      construc.params.width = 35;
      construc.params.height = 35;
      construc.params.rotate = true;
	 
	}
	if (typeObj == 'test2')
	{
		construc.push({'path': "M0 0L0 415L415 415L415 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		construc.push({'path': "M20 23L20 399L396 399L396 23L20 23z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		construc.push({'path': "M24 28L24 209L392 209L392 28L24 28z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		construc.push({'path': "M114 34.6528C96.1051 40.2439 105.085 67.2076 122.996 61.6667C140.129 56.3665 131.36 29.2289 114 34.6528M203 34.5332C185.222 38.8545 193.003 66.5789 211 62.0571C230.016 57.2792 221.55 30.0241 203 34.5332M292 34.6528C274.105 40.2439 283.085 67.2076 300.996 61.6667C318.293 56.3157 309.421 29.2096 292 34.6528z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		construc.push({'path': "M116.001 38.588C103.276 41.8807 108.233 61.0222 120.996 57.5656C132.793 54.3707 127.953 35.4951 116.001 38.588M204.015 38.6566C191.034 42.6729 198.16 61.1599 210.985 57.5663C223.778 53.9817 216.32 34.8493 204.015 38.6566M294.001 38.588C281.276 41.8805 286.233 61.022 298.996 57.5656C311.108 54.2858 306.105 35.4558 294.001 38.588z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		construc.push({'path': "M73 70.4645C63.7765 72.1275 55.1173 77.5536 50.6736 86C45.7953 95.2724 47 105.897 47 116C47 138.598 39.499 173.939 64 186.19C72.8858 190.633 83.3407 190 93 190L140 190L278 190C299.244 190 325.525 194.135 346 187.957C355.206 185.179 362.577 177.896 366.073 169C369.673 159.841 369 149.635 369 140C369 117.899 374.489 83.0761 349 72.4784C339.98 68.7283 329.543 70 320 70L267 70L137 70C116.537 70 93.1319 66.8348 73 70.4645z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		construc.push({'path': "M74 74.4676C64.033 76.3479 56.8911 82.8683 52.9012 92C49.4987 99.7876 51 109.681 51 118C51 138.787 43.9595 171.828 67 182.673C75.5624 186.703 85.7847 186 95 186L141 186L279 186C299.146 186 325.756 190.498 345 183.892C352.375 181.36 359.029 175.285 361.881 168C365.109 159.756 365 150.69 365 142C365 121.257 370.838 85.2997 346 76.0941C336.649 72.6284 325.797 74 316 74L263 74L136 74C116.252 74 93.4002 70.8076 74 74.4676z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		construc.push({'path': "M92 105C93.6551 109.987 98.4595 109 103 109L136 109L275 109L311 109C315.848 109 322.185 110.468 324 105L92 105M92 128L92 132L324 132L324 128L92 128M92 153C93.6551 157.987 98.4596 157 103 157L136 157L275 157L311 157C315.848 157 322.185 158.468 324 153L92 153z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		construc.push({'path': "M24 213L24 395L392 395L392 213L24 213z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		construc.push({'path': "M73 231.465C62.6172 233.337 53.1708 240.077 49.0941 250C45.3545 259.103 47 270.349 47 280L47 332C47 346.671 46.6915 359.863 60 369.362C75.1304 380.161 102.362 375 120 375L233 375C250.28 375 271.185 378.184 288 374.1C297.954 371.683 306.675 364.756 310.289 355C313.827 345.452 313 334.985 313 325C313 300.014 322.51 251.754 298 235.969C282.1 225.729 254.151 231 236 231L127 231C109.698 231 90.0279 228.394 73 231.465z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		construc.push({'path': "M74 235.468C64.1191 237.332 55.3955 244.413 52.108 254C49.3421 262.066 51 272.563 51 281L51 333C51 345.514 50.6944 357.167 62.0039 365.363C76.8482 376.12 103.585 371 121 371L233 371C249.716 371 270.835 374.445 287 370.073C296.072 367.618 303.799 360.978 306.892 352C309.917 343.219 309 333.127 309 324L309 274C309 260.637 307.602 246.862 295 239.214C279.406 229.75 251.653 235 234 235L127 235C110.083 235 90.6246 232.331 74 235.468z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		construc.push({'path': "M350 254.729C330.95 255.285 332.247 284.879 351 283.891C369.472 282.918 368.536 254.188 350 254.729M87 275C112.676 284.344 134.41 291.481 162 283.573C182.351 277.739 197.147 264.258 219 262.17C229.266 261.189 241.379 262.723 250.91 266.759C257.606 269.594 263.553 274.505 271 275C269.189 264.537 246.785 260.217 238 259C221.883 256.767 205.201 258.134 190.001 264.204C170.86 271.847 157.921 282.999 136 283C122.09 283.001 109.576 280.357 97 274.245C93.0852 272.342 88.7772 269.702 87 275z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		construc.push({'path': "M346.043 259.858C334.415 264.833 342.148 283.783 353.985 278.987C366.214 274.032 358.422 254.562 346.043 259.858z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		construc.push({'path': "M87 305C112.676 314.344 134.41 321.481 162 313.573C180.828 308.176 194.709 295.14 215 293.17C226.882 292.016 238.699 293.19 250 297.004C257.028 299.375 263.692 303.86 271 305C269.358 294.936 248.511 291.405 240 289.804C223.182 286.641 204.82 288.935 189 295.204C170.347 302.594 157.155 312.999 136 313C122.09 313.001 109.576 310.357 97 304.245C93.0852 302.342 88.7772 299.702 87 305M349 310.638C330.125 312.311 333.244 341.93 352 339.811C370.137 337.762 367.454 309.003 349 310.638z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		construc.push({'path': "M346.043 315.858C334.526 320.786 342.197 339.763 353.985 334.987C366.195 330.039 358.46 310.545 346.043 315.858z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		construc.push({'path': "M87 336C113.235 345.547 135.934 352.903 164 343.971C182.216 338.175 195.249 325.081 215 323.17C227.015 322.007 239.662 322.931 250.961 327.373C257.778 330.053 263.627 334.85 271 336C269.227 325.125 248.985 321.494 240 319.804C222.824 316.574 203.005 318.714 187.015 325.876C169.37 333.779 157.688 343.967 137 344C122.706 344.023 109.943 341.535 97 335.245C93.0852 333.342 88.7772 330.702 87 336z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		
		
      	construc.params.width = 15;
		construc.params.height = 15;
      	construc.params.rotate = true;
	}
	
	  if (typeObj == 'test')
	{

      construc.push({'path': "M0 0L0 83L1 83L1 1L83 1L57 0L0 0z ", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
	  construc.push({'path': "M1 1L1 2L82 2L57 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M82 1L82 82L1 82L1 83L83 83L83 26L82 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
	  construc.push({'path': "M1 2L1 82L82 82L82 2L1 2z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M7 5L7 6C23.3201 2.97017 41.423 5 58 5C66.0582 5 72.7879 3.8409 78 11C79.621 2.95844 67.9965 4 63 4C45.9063 4 23.3727 0.160469 7 5z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
	  construc.push({'path': "M9 5L9 6L74 6L53 5L9 5z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M6 6L7 7L6 6z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
	  construc.push({'path': "M7.43364 7.02778C4.41394 9.10613 5.0053 13.8305 5 17L5 42C5 49.8594 1.47913 69.3794 6.74228 75.5664C10.1286 79.5471 18.3644 78 23 78L59 78C63.5719 78 70.7095 79.3046 74.7716 76.821C81.8414 72.4984 78 48.4589 78 41C78 33.403 81.433 14.2956 76.3966 8.3179C73.1958 4.51881 65.4055 6 61 6L23 6C18.7883 6 11.0574 4.53365 7.43364 7.02778z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
	  construc.push({'path': "M5 7L6 8L5 7z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
	  construc.push({'path': "M4 8L4 57C4 61.9009 2.10091 71.5928 6 75L5 42L6 8L4 8z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M21 11L21 12L25 12L21 11z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M58 11L58 12L62 12L58 11z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"})
	  construc.push({'path': "M78 11L77 77L78 77L79 31L78 11z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
	  construc.push({'path': "M19.0039 12.7431C5.22019 18.0147 14.0118 38.9812 27.9568 32.9907C40.2911 27.6922 31.555 7.94276 19.0039 12.7431z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
	  construc.push({'path': "M26 12L27 13L26 12z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
	  construc.push({'path': "M56.0046 12.7431C42.2864 18.0069 51.1657 39.0616 64.9568 33.142C77.369 27.8142 68.6845 7.87769 56.0046 12.7431z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
	  construc.push({'path': "M63 12L64 13L63 12z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});		
	  construc.push({'path': "M15 14L16 15L15 14z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M30 14L31 15L30 14z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M52 14L53 15L52 14z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M67 14L68 15L67 14z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M14 15L15 16L14 15z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
	  construc.push({'path': "M31 15L32 16L31 15z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M51 15L52 16L51 15z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M68 15L69 16L68 15z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M69 16L70 17L69 16z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M12 18L13 19L12 18z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
	  construc.push({'path': "M33.3333 18.6667L33.6667 19.3333L33.3333 18.6667z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
	  construc.push({'path': "M49.3333 18.6667L49.6667 19.3333L49.3333 18.6667z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
	  construc.push({'path': "M70 18L71 19L70 18z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M11 20L11 25L12 25L11 20z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M71 20L71 26L72 26L71 20z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M34 21L34 25L35 25L34 21z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
	  construc.push({'path': "M48 21L48 25L49 25L48 21z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});		
	  construc.push({'path': "M12 27L13 28L12 27z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});		
	  construc.push({'path': "M33 27L34 28L33 27z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});		
	  construc.push({'path': "M49 27L50 28L49 27M70 27L71 28L70 27z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});		
	  construc.push({'path': "M13 29L14 30L13 29z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});		
	  construc.push({'path': "M32 29L33 30L32 29z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});		
	  construc.push({'path': "M50 29L51 30L50 29z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});		
	  construc.push({'path': "M69 29L70 30L69 29z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M16 32L17 33L16 32z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});		
	  construc.push({'path': "M29 32L30 33L29 32z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});		
	  construc.push({'path': "M53 32L54 33L53 32z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});		
	  construc.push({'path': "M66 32L67 33L66 32z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});		
	  construc.push({'path': "M27 33L28 34L27 33z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M55 33L56 34L55 33z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});		
		
	  construc.push({'path': "M20 34L20 35L25 35L20 34z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});	
	  construc.push({'path': "M57 34L57 35L63 35L57 34z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});	
	  construc.push({'path': "M21 48L21 49L25 49L21 48z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});	
	  construc.push({'path': "M58 48L58 49L62 49L58 48z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});	
	  construc.push({'path': "M19.0039 49.7423C5.20551 55.0646 14.2387 76.0154 27.9066 69.9907C40.2002 64.5719 31.6392 44.8686 19.0039 49.7423z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});	
	  construc.push({'path': "M56.0046 49.7423C42.9411 54.7976 50.7241 74.8968 63.9846 70.2971C77.3428 65.6634 69.278 44.6057 56.0046 49.7423z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});	
	  construc.push({'path': "M16 50L17 51L16 50z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});	
	  construc.push({'path': "M66 50L67 51L66 50z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});	
	  construc.push({'path': "M15 51L16 52L15 51z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});	
	  construc.push({'path': "M30 51L31 52L30 51z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});	
	  construc.push({'path': "M52 51L53 52L52 51M67 51L68 52L67 51z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});	
	  construc.push({'path': "M14 52L15 53L14 52z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});	
	  construc.push({'path': "M31 52L32 53L31 52z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});	
	  construc.push({'path': "M51 52L52 53L51 52z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});	
	  construc.push({'path': "M68 52L69 53L68 52z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});	
	  
	  construc.push({'path': "M13 53L14 54L13 53z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M69 53L70 54L69 53z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
	  construc.push({'path': "M12 55L13 56L12 55z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});		
	  construc.push({'path': "M33.3333 55.6667L33.6667 56.3333L33.3333 55.6667z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});		
	  construc.push({'path': "M49.3333 55.6667L49.6667 56.3333L49.3333 55.6667z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
	  construc.push({'path': "M70 55L71 56L70 55z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});	
		
		//BORRAR
	  construc.push({'path': "M5 75L6 76L5 75z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
	  construc.push({'path': "M6 76L7 77L6 76z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});	
	  construc.push({'path': "M76 76L77 77L76 76z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});	
		
	  construc.params.width = 35;
      construc.params.height = 35;
      construc.params.rotate = true;
		
      //construc.family = 'stick';
	
	}
	if (typeObj == 'bajo2')
	{

      construc.push({'path': "M0 0L0 41L30 41L30 0L0 0z ", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		
	  construc.push({'path': "M2 2L2 39L28 39L28 2L2 2z ", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
	  construc.params.width = 35;
      construc.params.height = 35;
      construc.params.rotate = true;
		
      //construc.family = 'stick';
	
	}
	if (typeObj == 'bajo3')
	{

      construc.push({'path': "M0 0L0 41L30 41L30 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		
	  construc.push({'path': "M1 1L1 40L29 40L29 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
		

      construc.params.width = 35;
      construc.params.height = 35;
      construc.params.rotate = true;
	
	}  
	if (typeObj == 'bajo4')
	{

      construc.push({'path': "M0 0L0 41L27 41L27 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		
	  construc.push({'path': "M1 1L1 40L26 40L26 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
		

      construc.params.width = 35;
      construc.params.height = 35;
      construc.params.rotate = true;
	
	} 
	if (typeObj == 'bajo5')
	{

      construc.push({'path': "M0 0L0 41L20 41L20 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		
	  construc.push({'path': "M1 1L1 40L19 40L19 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
		

      construc.params.width = 35;
      construc.params.height = 35;
      construc.params.rotate = true;
	
	} 
	if (typeObj == 'bajo6')
	{

      construc.push({'path': "M0 0L0 41L14 41L14 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillnegro"});
		
	  construc.push({'path': "M1 1L1 40L13 40L13 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
		
	  construc.params.width = 35;
      construc.params.height = 35;
      /*construc.params.width = 30;
      construc.params.height = 41;*/
      construc.params.rotate = true;
	
	} 	 
	  
	if (typeObj == 'alto1')
	{
		//376 * 600
		construc.push({'path': "M0 0L0 27L41 27L41 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue"});
		construc.push({'path': "M1 1L1 26L40 26L40 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
      construc.params.width = 35;
      construc.params.height = 35;
      construc.params.rotate = true;
	
	}    
	
	if (typeObj == 'alto2')
	{
		//376 * 500
		construc.push({'path': "M0 0L0 27L34 27L34 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue"});
		construc.push({'path': "M1 1L1 26L33 26L33 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
      construc.params.width = 35;
      construc.params.height = 35;
      construc.params.rotate = true;
	
	}  
	  
	if (typeObj == 'alto3')
	{
		//376 * 400
		construc.push({'path': "M0 0L0 27L27 27L27 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue"});
		construc.push({'path': "M1 1L1 26L26 26L26 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
      construc.params.width = 35;
      construc.params.height = 35;
      construc.params.rotate = true;
	
	}    
	if (typeObj == 'alto4')
	{
		//376 * 300
		construc.push({'path': "M0 0L0 27L21 27L21 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue"});
		construc.push({'path': "M1 1L1 26L20 26L20 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
      construc.params.width = 35;
      construc.params.height = 35;
      construc.params.rotate = true;
	
	}    
	if (typeObj == 'alto5')
	{
		//376 * 200
		construc.push({'path': "M0 0L0 27L14 27L14 0L0 0z", 'stroke': "", 'strokeDashArray': typeObj+" fillblue"});
		construc.push({'path': "M1 1L1 26L13 26L13 1L1 1z", 'stroke': "", 'strokeDashArray': typeObj+" fillblanco"});
		
      construc.params.width = 35;
      construc.params.height = 35;
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
