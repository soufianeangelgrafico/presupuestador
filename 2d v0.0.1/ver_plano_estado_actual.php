<?php
session_start();

$sesion=$_GET["sesion"];

// Check connection
if ($mysqli -> connect_errno) {
  echo "Fallo al conectar con la base de datos: " . $mysqli -> connect_error;
  exit();
}

?>

<html lang="es">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Rehubik</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
	<link rel="stylesheet" href="js/OwlCarousel/dist/assets/owl.carousel.css">
	<link rel="stylesheet" href="js/OwlCarousel/dist/assets/owl.theme.default.css">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	
</head>

<body style="background:#d6d6d6;margin:0;padding:0; ">
	
  <svg id="lin" viewBox="0 0 1100 700"  preserveAspectRatio="xMidYMin slice" xmlns="http://www.w3.org/2000/svg" style="z-index:2;margin:0;padding:0;width:100vw;height:100vh;position:absolute;top:0;left:0;right:0;bottom:0">

    <defs>
      <linearGradient id="gradientRed" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#e65d5e" stop-opacity="1"/>
        <stop offset="100%" stop-color="#e33b3c" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientYellow" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#FDEB71" stop-opacity="1"/>
        <stop offset="100%" stop-color="#F8D800" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientGreen" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#c0f7d9" stop-opacity="1"/>
        <stop offset="100%" stop-color="#6ce8a3" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientSky" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#c4e0f4" stop-opacity="1"/>
        <stop offset="100%" stop-color="#87c8f7" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientOrange" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#f9ad67" stop-opacity="1"/>
        <stop offset="100%" stop-color="#f97f00" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientWhite" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#ffffff" stop-opacity="1"/>
        <stop offset="100%" stop-color="#f0f0f0" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientGrey" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#666" stop-opacity="1"/>
        <stop offset="100%" stop-color="#aaa" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientBlue" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#4f72a6" stop-opacity="1"/>
        <stop offset="100%" stop-color="#365987" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientPurple" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#E2B0FF" stop-opacity="1"/>
        <stop offset="100%" stop-color="#9F44D3" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientPink" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#f6c4dd" stop-opacity="1"/>
        <stop offset="100%" stop-color="#f699c7" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientBlack" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#3c3b3b" stop-opacity="1"/>
        <stop offset="100%" stop-color="#000000" stop-opacity="1"/>
      </linearGradient>
      <linearGradient id="gradientNeutral" x1="0%" y1="0%" x2="100%" y2="100%" spreadMethod="pad">
        <stop offset="0%"   stop-color="#dbc6a0" stop-opacity="1"/>
        <stop offset="100%" stop-color="#c69d56" stop-opacity="1"/>
      </linearGradient>

      <pattern id="grass" patternUnits="userSpaceOnUse" width="256" height="256">
        <image xlink:href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRWh5nEP_Trwo96CJjev6lnKe0_dRdA63RJFaoc3-msedgxveJd" x="0" y="0" width="256" height="256" />
      </pattern>
      <pattern id="wood" patternUnits="userSpaceOnUse" width="32" height="256">
        <image xlink:href="https://orig00.deviantart.net/e1f2/f/2015/164/8/b/old_oak_planks___seamless_texture_by_rls0812-d8x6htl.jpg" x="0" y="0" width="256" height="256" />
      </pattern>
      <pattern id="tiles" patternUnits="userSpaceOnUse" width="25" height="25">
        <image xlink:href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQrkoI2Eiw8ya3J_swhfpZdi_ug2sONsI6TxEd1xN5af3DX9J3R" x="0" y="0" width="256" height="256" />
      </pattern>
      <pattern id="granite" patternUnits="userSpaceOnUse" width="256" height="256">
        <image xlink:href="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9_nEMhnWVV47lxEn5T_HWxvFwkujFTuw6Ff26dRTl4rDaE8AdEQ" x="0" y="0" width="256" height="256" />
      </pattern>
      <pattern id="smallGrid" width="60" height="60" patternUnits="userSpaceOnUse">
        <path d="M 60 0 L 0 0 0 60" fill="none" stroke="#777" stroke-width="0.25"/>
      </pattern>
      <pattern id="grid" width="180" height="180" patternUnits="userSpaceOnUse">
        <rect width="180" height="180" fill="url(#smallGrid)"/>
        <path d="M 200 10 L 200 0 L 190 0 M 0 10 L 0 0 L 10 0 M 0 190 L 0 200 L 10 200 M 190 200 L 200 200 L 200 190" fill="none" stroke="#999" stroke-width="0.8"/>
      </pattern>
      <pattern id="hatch" width="5" height="5" patternTransform="rotate(50 0 0)" patternUnits="userSpaceOnUse" >
        <path d="M 0 0 L 0 5 M 10 0 L 10 10 Z" style="stroke:#666;stroke-width:5;" />
      </pattern>
    </defs>
    <g id="boxgrid">
      <rect width="8000" height="5000" x="-3500" y="-2000" fill="url(#grid)" />
    </g>
    <g id="boxpath"></g>
    <g id="boxSurface"></g>
    <g id="boxRoom"></g>
    <g id="boxwall"></g>
    <g id="boxcarpentry"></g>
    <g id="boxEnergy"></g>
    <g id="boxFurniture"></g>
    <g id="boxbind"></g>
    <g id="boxArea"></g>
    <g id="boxRib"></g>
    <g id="boxScale"></g>
    <g id="boxText"></g>
    <g id="boxDebug"></g>
  </svg>

  <div id="areaValue"></div>

  <div id="reportTools" class="leftBox" style="width:500px;overflow-y: scroll;overflow-x: hidden">
    <h2><i class="fa fa-calculator" aria-hidden="true"></i> Report plan.</h2>
    <br/><br/>
    <h2 class="toHide" id="reportTotalSurface" style="display:none"></h2>
    <h2 class="toHide" id="reportNumberSurface" style="display:none"></h2>
    <hr/>
    <section id="reportRooms" class="toHide" style="display:none">
    </section>
    <button class="btn btn-info fully" style="margin-top:50px" onclick="$('#reportTools').hide('500', function(){$('#panel').show(300);});mode = 'select_mode';"><i class="fa fa-2x fa-backward" aria-hidden="true" ></i></button>
  </div>

  <div id="wallTools" class="leftBox">
    <h2 id="titleWallTools">Modifica la pared</h2>
    <hr/>
    <section id="rangeThick">
      <p>Editando: <span id="wallWidthScale"></span>  <span id="wallWidthVal"></span></span></p>
      <input type="text" id="wallWidth" />
    </section>
    <ul class="list-unstyled">
 
    <br/>
    <li><button class="btn btn-danger halfy" id="wallTrash"><i class="fa fa-2x fa-trash-o" aria-hidden="true"></i></button>
    <button class="btn btn-info halfy pull-right" onclick="fonc_button('select_mode');$('#boxinfo').html('Modo selección');$('#wallTools').hide('300');$('#panel').show('300');"><i class="fa fa-2x fa-backward" aria-hidden="true" ></i></button></li>
    </ul>
  </div>
  
  <!-- divs vacios -->
  <div style="display:none" id="objBoundingBox" class="leftBox"></div>
  <div style="display:none" id="objTools" class="leftBox"></div>
  <div style="display:none" id="bboxTrash"></div>
  <div style="display:none" id="doorWindowWidth"></div>
  <div style="display:none" id="objToolsHinge"></div>
  <div style="display:none" id="applySurface"></div>
  <div style="display:none" id="resetRoomTools"></div>
  <div style="display:none" id="roomTools" class="leftBox"></div>
  <div style="display:none" id="bboxStepsAdd"></div>
  <div style="display:none" id="bboxStepsMinus"></div>
  <div style="display:none" id="bboxWidth"></div>
  <div style="display:none" id="bboxHeight"></div>
  <div style="display:none" id="bboxRotation"></div>
  <div style="display:none" id="redo"></div>
  <div style="display:none" id="undo"></div>
  <div style="display:none" id="panel"></div>
  <div style="display:none" id="sizePolice"></div>

<!-- fin divs vacios -->

  <div id="moveBox" style="position:absolute;right:-150px;top:10px;color:#08d;background:transparent;z-index:2;text-align:center;transition-duration: 0.2s;transition-timing-function: ease-in;">
    <p style="margin:0px 0 0 0;font-size:11px;display:none"><img src="https://cdn4.iconfinder.com/data/icons/mathematics-doodle-3/48/102-128.png" width="20" /> Rehubic</p>
    <div class="pull-right" style="margin:10px">
    <p style="margin:0"><button class="btn btn-xs btn-info zoom" data-zoom="zoomtop" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-arrow-up" aria-hidden="true"></i></button></p>
    <p style="margin:0">
      <button class="btn btn-xs btn-info zoom" data-zoom="zoomleft" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
      <button class="btn btn-xs btn-default zoom" data-zoom="zoomreset" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-bullseye" aria-hidden="true"></i></button>
      <button class="btn btn-xs btn-info zoom" data-zoom="zoomright" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
    </p>
    <p style="margin:0"><button class="btn btn-xs btn-info zoom" data-zoom="zoombottom" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-arrow-down" aria-hidden="true"></i></button></p>
    </div>
  </div>

  <div id="zoomBox" style="position:absolute;z-index:100;right:-150px;bottom:20px;text-align:center;background:transparent;padding:0px;color:#fff;transition-duration: 0.2s;transition-timing-function: ease-in;">
    <div class="pull-right" style="margin-right:10px">
      <button class="btn btn btn-default zoom" data-zoom="zoomin" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-plus" aria-hidden="true"></i></button>
      <button class="btn btn btn-default zoom" data-zoom="zoomout" style="box-shadow:2px 2px 3px #ccc;"><i class="fa fa-minus" aria-hidden="true"></i></button>
    </div>
    <div style="clear:both"></div>
      <div id="scaleVal"  class="pull-right"  style="box-shadow:2px 2px 3px #ccc;width:60px;height:20px;background:#4b79aa;border-radius:4px;margin-right:10px">
        1m
      </div>

      <div style="clear:both"></div>
  </div>
</body>
  <script src="jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
  <script>
	/*!
	 * jQuery UI Touch Punch 0.2.3
	 *
	 * Copyright 2011â€“2014, Dave Furfero
	 * Dual licensed under the MIT or GPL Version 2 licenses.
	 *
	 * Depends:
	 *  jquery.ui.widget.js
	 *  jquery.ui.mouse.js
	 */
	!function(a){function f(a,b){if(!(a.originalEvent.touches.length>1)){a.preventDefault();var c=a.originalEvent.changedTouches[0],d=document.createEvent("MouseEvents");d.initMouseEvent(b,!0,!0,window,1,c.screenX,c.screenY,c.clientX,c.clientY,!1,!1,!1,!1,0,null),a.target.dispatchEvent(d)}}if(a.support.touch="ontouchend"in document,a.support.touch){var e,b=a.ui.mouse.prototype,c=b._mouseInit,d=b._mouseDestroy;b._touchStart=function(a){var b=this;!e&&b._mouseCapture(a.originalEvent.changedTouches[0])&&(e=!0,b._touchMoved=!1,f(a,"mouseover"),f(a,"mousemove"),f(a,"mousedown"))},b._touchMove=function(a){e&&(this._touchMoved=!0,f(a,"mousemove"))},b._touchEnd=function(a){e&&(f(a,"mouseup"),f(a,"mouseout"),this._touchMoved||f(a,"click"),e=!1)},b._mouseInit=function(){var b=this;b.element.bind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),c.call(b)},b._mouseDestroy=function(){var b=this;b.element.unbind({touchstart:a.proxy(b,"_touchStart"),touchmove:a.proxy(b,"_touchMove"),touchend:a.proxy(b,"_touchEnd")}),d.call(b)}}}(jQuery);

  </script>
  <script src="bootstrap.min.js"></script>
  <script src="mousewheel.js"></script>
  <script src="func.js"></script>
  <script src="qSVG.js"></script>
  <script src="editor.js"></script>
  <script src="engine.js"></script>
  <script src="js/OwlCarousel/dist/owl.carousel.min.js"></script>
<!-- alertify -->
<script>
!function(t,k){"use strict";var e,E=t.document;e=function(){var m,s,a,o,r,n={},l={},c=!1,v=27,g=32,f=[];return l=E.location.href.includes("mis_datos.php")?{buttons:{holder:'<nav class="alertify-buttons">{{buttons}}</nav>',submit:'<button type="submit" class="alertify-button alertify-button-ok" id="alertify-ok" />{{ok}}</button>',ok:'<a href="#" class="alertify-button alertify-button-ok" id="alertify-ok">{{ok}}</a>',cancel:'<a href="#" class="alertify-button alertify-button-cancel" id="alertify-cancel">{{cancel}}</a>'},input:'<input type="password" class="alertify-text" id="alertify-text">',message:'<p class="alertify-message">{{message}}</p>',log:'<article class="alertify-log{{class}}">{{message}}</article>'}:{buttons:{holder:'<nav class="alertify-buttons">{{buttons}}</nav>',submit:'<button type="submit" class="alertify-button alertify-button-ok" id="alertify-ok" />{{ok}}</button>',ok:'<a href="#" class="alertify-button alertify-button-ok" id="alertify-ok">{{ok}}</a>',cancel:'<a href="#" class="alertify-button alertify-button-cancel" id="alertify-cancel">{{cancel}}</a>'},input:'<input type="text" class="alertify-text" id="alertify-text">',message:'<p class="alertify-message">{{message}}</p>',log:'<article class="alertify-log{{class}}">{{message}}</article>'},m=function(t){return E.getElementById(t)},{alert:function(t,e){return n.dialog(t,"alert",e),this},confirm:function(t,e){return n.dialog(t,"confirm",e),this},extend:(n={labels:{ok:"Aceptar",cancel:"Cancelar"},delay:8e3,addListeners:function(e){var i,n,a,s,o,r=m("alertify-resetFocus"),l=m("alertify-ok")||k,c=m("alertify-cancel")||k,f=m("alertify-text")||k,u=m("alertify-form")||k,d=void 0!==l,y=void 0!==c,b=void 0!==f,p="",h=this;i=function(t){void 0!==t.preventDefault&&t.preventDefault(),a(t),void 0!==f&&(p=f.value),"function"==typeof e&&e(!0,p)},n=function(t){void 0!==t.preventDefault&&t.preventDefault(),a(t),"function"==typeof e&&e(!1)},a=function(t){h.hide(),h.unbind(E.body,"keyup",s),h.unbind(r,"focus",o),b&&h.unbind(u,"submit",i),d&&h.unbind(l,"click",i),y&&h.unbind(c,"click",n)},s=function(t){var e=t.keyCode;e!==g||b||i(t),e===v&&y&&n(t)},o=function(t){b?f.focus():y?c.focus():l.focus()},this.bind(r,"focus",o),d&&this.bind(l,"click",i),y&&this.bind(c,"click",n),this.bind(E.body,"keyup",s),b&&this.bind(u,"submit",i),t.setTimeout(function(){f?(f.focus(),f.select()):l.focus()},50)},bind:function(t,e,i){"function"==typeof t.addEventListener?t.addEventListener(e,i,!1):t.attachEvent&&t.attachEvent("on"+e,i)},build:function(t){var e="",i=t.type,n=t.message;switch(e+='<div class="alertify-dialog">',"prompt"===i&&(e+='<form id="alertify-form">'),e+='<article class="alertify-inner">',e+=l.message.replace("{{message}}",n),"prompt"===i&&(e+=l.input),e+=l.buttons.holder,e+="</article>","prompt"===i&&(e+="</form>"),e+='<a id="alertify-resetFocus" class="alertify-resetFocus" href="#">Reset Focus</a>',e+="</div>",i){case"confirm":e=(e=e.replace("{{buttons}}",l.buttons.ok+l.buttons.cancel)).replace("{{ok}}",this.labels.ok).replace("{{cancel}}",this.labels.cancel);break;case"prompt":e=(e=e.replace("{{buttons}}",l.buttons.submit+l.buttons.cancel)).replace("{{ok}}",this.labels.ok).replace("{{cancel}}",this.labels.cancel);break;case"alert":e=(e=e.replace("{{buttons}}",l.buttons.ok)).replace("{{ok}}",this.labels.ok)}return o.className="alertify alertify-show alertify-"+i,a.className="alertify-cover",e},close:function(t,e){var i=e&&!isNaN(e)?+e:this.delay;this.bind(t,"click",function(){r.removeChild(t)}),setTimeout(function(){void 0!==t&&t.parentNode===r&&r.removeChild(t)},i)},dialog:function(t,e,i,n){s=E.activeElement;var a=function(){o&&null!==o.scrollTop||a()};if("string"!=typeof t)throw new Error("message must be a string");if("string"!=typeof e)throw new Error("type must be a string");if(void 0!==i&&"function"!=typeof i)throw new Error("fn must be a function");return"function"==typeof this.init&&(this.init(),a()),f.push({type:e,message:t,callback:i,placeholder:n}),c||this.setup(),this},extend:function(i){return function(t,e){this.log(t,i,e)}},hide:function(){f.splice(0,1),0<f.length?this.setup():(c=!1,o.className="alertify alertify-hide alertify-hidden",a.className="alertify-cover alertify-hidden",s.focus())},init:function(){E.createElement("nav"),E.createElement("article"),E.createElement("section"),(a=E.createElement("div")).setAttribute("id","alertify-cover"),a.className="alertify-cover alertify-hidden",E.body.appendChild(a),(o=E.createElement("section")).setAttribute("id","alertify"),o.className="alertify alertify-hidden",E.body.appendChild(o),(r=E.createElement("section")).setAttribute("id","alertify-logs"),r.className="alertify-logs",E.body.appendChild(r),E.body.setAttribute("tabindex","0"),delete this.init},log:function(t,e,i){var n=function(){r&&null!==r.scrollTop||n()};return"function"==typeof this.init&&(this.init(),n()),this.notify(t,e,i),this},notify:function(t,e,i){var n=E.createElement("article");n.className="alertify-log"+("string"==typeof e&&""!==e?" alertify-log-"+e:""),n.innerHTML=t,r.insertBefore(n,r.firstChild),setTimeout(function(){n.className=n.className+" alertify-log-show"},50),this.close(n,i)},set:function(t){var e;if("object"!=typeof t&&t instanceof Array)throw new Error("args must be an object");for(e in t)t.hasOwnProperty(e)&&(this[e]=t[e])},setup:function(){var t=f[0];c=!0,o.innerHTML=this.build(t),"string"==typeof t.placeholder&&(m("alertify-text").value=t.placeholder),this.addListeners(t.callback)},unbind:function(t,e,i){"function"==typeof t.removeEventListener?t.removeEventListener(e,i,!1):t.detachEvent&&t.detachEvent("on"+e,i)}}).extend,init:n.init,log:function(t,e,i){return n.log(t,e,i),this},prompt:function(t,e,i){return n.dialog(t,"prompt",e,i),this},success:function(t,e){return n.log(t,"success",e),this},error:function(t,e){return n.log(t,"error",e),this},set:function(t){n.set(t)},labels:n.labels}},"function"==typeof define?define([],function(){return new e}):void 0===t.alertify&&(t.alertify=new e)}(this);
</script>
 <script>
	
 //Recupero el mapa de un usuario
  if (localStorage.getItem('history')) localStorage.removeItem('history');
	  
  var sesion="<?php echo $_GET["sesion"];?>";
  $.ajax({
		 type: "POST",
		 dataType: 'json', 
		 async:false,
		 url: "ajax/sacar_dibujo2d_estado_actual.php",
		 data: {sesion:sesion},
		 success:function(mensaje){	
			 HISTORY.push(mensaje);
			 console.log("RESPUESTA MENSAJE:");
			 console.log(mensaje);
			 HISTORY[0] = JSON.stringify(HISTORY[0]);
			 localStorage.setItem('history', JSON.stringify(HISTORY));
			 load(0);
			 save();
		 }

 });
	 
 $.ajax({
				 type: "POST",
				 dataType: 'json', 
				 async:false,
				 url: "ajax/sacar_boxcarpentry_estado_actual.php",
				 data: {sesion:sesion},
				 success:function(respuesta){	
					 console.log("Mensaje!");
					 console.log(respuesta.mensaje);
					 $("#boxcarpentry").html(respuesta.mensaje);
				 }

		 });	 

 $.ajax({
				 type: "POST",
				 dataType: 'json', 
				 async:false,
				 url: "ajax/sacar_boxenergy_estado_actual.php",
				 data: {sesion:sesion},
				 success:function(respuesta){	
					 console.log("Box Energy Estado actual");
					 console.log(respuesta.mensaje);
					 $("#boxEnergy").html(respuesta.mensaje);
				 }

		 });	 

	 
 $.ajax({
				 type: "POST",
				 dataType: 'json', 
				 async:false,
				 url: "ajax/sacar_observaciones_estado_actual.php",
				 data: {sesion:sesion},
				 success:function(respuesta){	
					 console.log("Observaciones Estado actual");
					 console.log(respuesta.mensaje);
					 $("#boxEnergy").html(respuesta.mensaje);
				 }

		 });	 
	 
	 
$( document ).ready(function() {	 
  
	
  setTimeout(function(){ 
  
   //$('svg').removeAttr('viewBox');
   //$('svg').each(function () { $(this)[0].setAttribute('viewBox', '973 -171 380 646') });
  
  }, 4000);	
  
	
});

</script>
</html>
