function instrucciones(paso) {
    if (paso == "paso1") {
        alertify.alert("<p>Dibuja la tabiquería del estado actual de tu cocina, con la ubicación de las puertas y ventanas de la misma. A continuación define el mobiliario actual de la estancia. Para preparar tu oferta, nos ayudará conocer el tipo y ubicación de tus instalaciones actuales. Si consideras necesario añadir alguna observación aprovecha el último punto para ello.Si necesitas más información en cada punto podrás encontrar una explicación del mismo.</p>");
    } else if (paso == "paso11") {
    alertify.alert("<p><b>Dibuja la tabiquería del estado actual de tu cocina</b>, con la ubicación de las puertas y ventanas de la misma.También podrás seleccionar entre los distintos tipos de apertura de ventanas y puertas. Haz doble clic en cada una de ellas para definir sus dimensiones.<br/><br/>Recuerda definir la altura actual de suelo a techo de tu cocina. Si en tu cocina hay dos alturas diferentes, una viga o un falseado a una altura inferior, en este paso indica únicamente la altura mayor de suelo a techo y en el último paso “1.4 Indica observaciones” podrás añadir un cuadro de texto indicando la situación en concreto así como las diferentes alturas. Ej.Tengo una viga que atraviesa la cocina en horizontal, en ese punto la altura de suelo a techo es de 2.22m.</p>");
    } else if (paso == "paso12") {
    alertify.alert("<p>Define la distribución de mobiliario y electrodomésticos actual de tú cocina.</p>");
    } else if (paso == "paso13") {
    alertify.alert("<p>Para preparar tu oferta, nos ayudará conocer el tipo y ubicación de tus instalaciones actuales. Para ello selecciona entre las diferentes simbologías y arrástralas hasta dejarlas ubicada en el plano. No será necesario que definas las instalaciones de tus electrodomésticos puesto que ya han quedado definidas en el paso anterior.</p>");
    } else if (paso == "paso14") {
    alertify.alert("<p>Indica las observaciones que consideres necesarias para la reforma de tu cocina y que no hayan sido definidas en los pasos anteriores.</p><p>Ej.1: No existe falso techo en mi cocina actual.<br/> Ej.2 Tengo una viga que atraviesa la cocina en horizontal, en ese punto</p>");
    }
    else if (paso == "puntos_electricos_extras") {
        alertify.alert("Selecciona a través de la barra la cantidad de puntos eléctricos extras. Los puntos eléctricos extras son todos aquellos que no están asociados a un electrodoméstico fijo (horno, nevera, microondas…), es decir, aquellos que queremos tener disponibles para nuestro uso diario. También deberemos contemplar el número de interruptores asociados al encendido de la iluminación. Ej: 4 enchufes de servicio + 2 interruptores de iluminación = 6 puntos eléctricos extras.");
    } else if (paso == "puntos_luz_techo") {
        alertify.alert("Selecciona a través de la barra la cantidad puntos de luz en el techo que quieras para la iluminación de tu cocina.");
    } else if (paso == "linea_25a_16a") {
        alertify.alert("Selecciona a través de la barra los metros lineales desde el cuadro eléctrico de tu vivienda hasta la cocina. La línea de 25A y 16A solo es necesaria si la instalación eléctrica de la vivienda es muy antigua y deseas cambiar todo el cableado desde el cuadro eléctrico hasta la cocina. La línea de 25A también será necesaria si en tú cuadro eléctrico no tienes un automático independiente que ponga 25C, sucederá si actualmente tienes un horno de gas o la instalación eléctrica es muy antigua.");
    } else if (paso == "cuadro_electrico_vivienda") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto un cuadro eléctrico nuevo completo para tu vivienda.");
    } else if (paso == "horno") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para el horno. <br/>Con esta selección únicamente se valorará la instalación eléctrica necesaria para el mismo, el electrodoméstico y su instalación no están incluidos.");
    } else if (paso == "vitro_induccion") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para la vitrcerámica. <br/>Con esta selección únicamente se valorará la instalación eléctrica necesaria para la misma, el electrodoméstico y su instalación no están incluidos.");
    } else if (paso == "placa_gas") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para la placa de gas <br/>Con esta selección únicamente se valorará la instalación eléctrica necesaria para la misma y la instalación de la placa de gas, el electrodoméstico no está incluido.");
    } else if (paso == "micro") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para el microondas <br/>Con esta selección únicamente se valorará la instalación eléctrica necesaria para el mismo, el electrodoméstico y su instalación no están incluidos.");
    } else if (paso == "frigo") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para el frigorífico. <br/>Con esta selección únicamente se valorará la instalación eléctrica necesaria para el mismo, el electrodoméstico y su instalación no están incluidos.");
    } else if (paso == "lavavajillas") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para el lavavajillas. <br/>Con esta selección únicamente se valorará la instalación eléctrica y de fontanería necesaria para el mismo, el electrodoméstico y su instalación no están incluidos.");
    } else if (paso == "lavadora") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para la lavadora. <br/>Con esta selección únicamente se valorará la instalación eléctrica y de fontanería necesaria para la misma, el electrodoméstico y su instalación no están incluidos.");
    } else if (paso == "secadora") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para la secadora. <br/>Con esta selección únicamente se valorará la instalación eléctrica necesaria para la misma el electrodoméstico y su instalación no están incluidos.");
    } else if (paso == "campana") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para la campana extractora. <br/>Con esta selección únicamente se valorará la instalación eléctrica necesaria para la misma y el tubo de extracción nuevo, el electrodoméstico y su instalación no están incluidos.");
    } else if (paso == "fregadero") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para el fregadero.<br/> Con esta selección únicamente se valorará la instalación de fontanería necesaria para el mismo, el fregadero y su instalación no están incluidos.");
    } else if (paso == "lavadero") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para el lavadero.<br/> Con esta selección únicamente se valorará la instalación de fontanería necesaria para el mismo, el lavadero y su instalación no están incluidos.");
    } else if (paso == "termo_electrico") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para el termo eléctrico.<br/>Con esta selección únicamente se valorará la instalación eléctrica y de fontanería necesaria para el mismo, el electrodoméstico no está incluido.");
    } else if (paso == "calentador_gas") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para el calentador de gas.<br/>Con esta selección únicamente se valorará la instalación eléctrica y de fontanería necesaria para el mismo, así como el tubo de extracción de humos, el electrodoméstico no está incluido.");
    } else if (paso == "caldera_gas") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para la caldera de gas.<br/>Con esta selección únicamente se valorará la instalación eléctrica y de fontanería necesaria para la misma, así como el tubo de extracción de humos, el electrodoméstico no está incluido.");
    } else if (paso == "rehubicar_contador_agua") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para la reubicación del contador de agua.");
    } else if (paso == "radiador_calefaccion") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para un radiador de agua. <br/> Con esta selección únicamente se valorará la instalación de fontanería necesaria para el mismo y su montaje, el radiador no está incluido.");
    } else if (paso == "llaves_corte") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para las llaves de corte de agua de la cocina");
    } else if (paso == "television") {
        alertify.alert("Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la instalación necesaria para la televisión");
    } else if (paso == "paso21") {
        alertify.alert("<p><b>Si se mantiene la geometría de tu cocina</b> y no vas a modificar ningún tabique, dibuja la tabiquería, igual que en el paso 1.</p><p><b>En el caso de que estés pensando en aumentar o disminuir la superficie de tú cocina</b>, en definitiva, si vas a tirar tabiques o realizar tabiques nuevas, deberás:</p><ol><li>Dibujar el plano del estado actual de la cocina. Ojo! En esta ocasión deberás definir los tabiques nuevos y los tabiques a demoler, para ello, tendrás que dibujar de manera independiente cada tramo de tabique que se mantiene, se demuele o se realiza nuevo. Ej: Si del tabique “A” de 3m de largo, vas a demoler únicamente la mitad, deberás dibujar 1,5m y clicar para dibujar en la misma dirección el siguiente tramo de 1,5m.</li><li>Seleccionar haciendo doble clic encima de cada tabique a demoler o a hacer nuevo y definir la tipología de tabique que corresponda.</li></ol><p><b>Tanto si se modifica la geometría de la cocina como si se mantiene</b>, podrás seleccionar entre los distintos tipos de apertura de ventanas y puertas y ubicarlos en el plano. Haz doble clic en cada una de ellas para definir sus dimensiones.</p><p>Recuerda definir la altura actual de suelo a techo de tu cocina. Si en tu cocina hay dos alturas diferentes, una viga o un falseado a una altura inferior, en este paso indica únicamente la altura mayor de suelo a techo y en el último paso “2.4 Indica observaciones” podrás añadir un cuadro de texto indicando la situación en concreto así como las diferentes alturas. Ej.Tengo una viga que atraviesa la cocina en horizontal, en ese punto la altura de suelo a techo es de 2.22m.</p>");
    } else if (paso == "paso22") {
        alertify.alert("<p>Define la distribución de mobiliario y electrodomésticos que quieres en tu cocina reformada.</p>");
    } else if (paso == "paso23") {
        alertify.alert("<p>Añade las instalaciones necesarias para tu cocina reformada</p>");
    } else if (paso == "picado_desescombro_tabiqueria") {
        alertify.alert("<p>Marca aquellos tabiques que quieras demoler. Verás que salen preseleccionados aquellos tabiques que has marcado en rojo en el plano como tabiques a demoler</p>");
    } else if (paso == "picado_desescombro_alicatado") {
        alertify.alert("<p>Marca aquellos tabiques el los que quieras picar el alicatado actual. Podrás seleccionar la demolición de alicatado de todos los tabiques en un solo clic o definir de manera independiente por tabique si la demolición del alicatado es completa o parcial. En el último caso, podrás indicar la cantidad de metros a picar.</p>");
    } else if (paso == "picado_desescombro_solado") {
        alertify.alert("<p>Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto el picado de suelo existente de tu cocina.</p>");
    } else if (paso == "picado_desescombro_falso_techo") {
        alertify.alert("<p>Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto el picado de falso techo existente de tu cocina</p>");
    } else if (paso == "picado_desescombro_rodapie") {
        alertify.alert("<p>Marca aquellos tabiques el los que quieras picar el rodapie actual. Podrás seleccionar el picado de rodapie de todos los tabiques en un solo clic o definir de manera independiente por tabique si el picado de rodapié es completo o parcial. En el último caso, podrás indicar la cantidad de metros lineales que quieres picar.</p>");
    } else if (paso == "desmontaje_mueble_cocina") {
        alertify.alert("<p>Selecciona a través de la barra la cantidad de los metros lineales de mobiliario que quieres eliminar de tu cocina. Nos encargaremos de desmontarlos y de la gestión de los mismos hasta un punto limpio autorizado</p>");
    } else if (paso == "alicatado_paredes") {
        alertify.alert("<p>Marca aquellos tabiques el los que quieras colocar alicatado nuevo. Podrás seleccionar la colocación de alicatado de todos los tabiques en un solo clic o definir de manera independiente por tabique si la colocación del alicatado es completa o parcial. En el último caso, podrás indicar la cantidad de metros a colocar. En este paso únicamente se está contemplando la mano de obra de la colocación del solado, el material se elegirá en el último paso de materiales</p>");
    } else if (paso == "enlucido_paredes") {
        alertify.alert("<p>Marca aquellos tabiques el los que quieras enlucir. Podrás seleccionar el enlucido de todos los tabiques en un solo clic o definir de manera independiente por tabique si el enlucido del tabique es completo o parcial. En el último caso, podrás indicar la cantidad de metros a enlucir.</p>");
    } else if (paso == "colocacion_solado") {
        alertify.alert("<p>Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la colocación de solado nuevo. En este paso únicamente se está contemplando la mano de obra de la colocación del solado, el material se elegirá en el último paso de materiales.</p>");
    } else if (paso == "colocacion_zocalo") {
        alertify.alert("<p>Marca aquellos tabiques el los que quieras colocar zócalo nuevo. Podrás seleccionar la colocación de zócalo de todos los tabiques en un solo clic o definir de manera independiente por tabique si la colocación de zócalo es completa o parcial. En el último caso, podrás indicar la cantidad de metros lineales de zócalo que quieres colocar.</p>");
    } else if (paso == "falso_techo") {
        alertify.alert("<p>Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la ejecución de un falso techo nuevo para tu cocina</p>");
    } else if (paso == "hacer_tabique") {
        alertify.alert("<p>Marca aquellos tabiques que quieras hacer nuevos. Verás que salen preseleccionados aquellos tabiques que has marcado en verde en el plano como tabiques a hacer.</p>");
    } else if (paso == "pintura_paredes") {
        alertify.alert("<p>Marca aquellos tabiques que quieras pintar. Podrás seleccionar la pintura de todos los tabiques en un solo clic o definir de manera independiente por tabiques si la pintura de esa pared es completa o parcial. En el último caso podrás indicar la cantidad de metros a pintar</p>");
    } else if (paso == "pintura_techo") {
        alertify.alert("<p>Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la pintura de el techo de tú cocina.</p>");
    } else if (paso == "trasdosado_yeso") {
        alertify.alert("<p>Selecciona a través de la barra la cantidad de los metros lineales de trasdosado de yeso laminado que necesites.</p>");
    } else if (paso == "anulacion_gas") {
        alertify.alert("<p>Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la anulación de un punto de gas. Tendrás que seleccionar esta partida si ahora tienes una placa de gas y quieres poner una vitrocerámica eléctrica o si cambias el calentador de gas por un termo eléctrico</p>");
    } else if (paso == "instalacion_gas") {
        alertify.alert("<p>Selecciona a través de la barra la cantidad de los metros lineales de instalación de gas necesaria. Tendrás que contemplar la distancia desde la ubicación actual del contador de gas hasta la ubicación de la placa de gas y/o calentador.</p>");
    } else if (paso == "rehubicar_contador_gas") {
        alertify.alert("<p>Selecciona a través de la barra la cantidad de los metros lineales necesarios para trasladar el contador de gas desde la posición actual a la nueva ubicación.</p>");
    } else if (paso == "puerta_abatible") {
        alertify.alert("<p>Selecciona a través de la barra la cantidad de puertas de paso abatibles que quieras cambiar en tu cocina. Al seleccionarla se valorará el suministro e instalación de una puerta de paso abatible de 72cm o 82cm de ancho. Cualquier ancho de puerta diferente deberá ser valorado a parte. El acabado de puerta lo seleccionarás en el último paso.</p>");
    } else if (paso == "desmontaje_montaje_tapetas") {
        alertify.alert("<p>Selecciona a través de la barra el número de tapetas de puerta que hay que montar y desmontar en tú cocina. Habrán tantos desmontajes y montajes de tapetas como número de puertas de paso interior tenga tú cocina. Este trabajo siempre será necesario si se cambia el alicatado de tú cocina.</p>");
    } else if (paso == "puerta_corredera_encastrada") {
        alertify.alert("<p>Selecciona a través de la barra la cantidad de puertas de paso correderas encastradas que quieras cambiar en tu cocina. Al seleccionarla se valorará el suministro e instalación de una puerta de paso corredera encastrada de 72cm o 82cm de ancho. Cualquier ancho de puerta diferente deberá ser valorado a parte. El acabado de puerta lo seleccionarás en el último paso.</p>");
    } else if (paso == "puerta_corredera_guia") {
        alertify.alert("<p>Selecciona a través de la barra la cantidad de puertas de paso correderas con guía exterior que quieras cambiar en tu cocina. Al seleccionarla se valorará el suministro e instalación de una puerta de paso corredera con guía exterior de 72cm o 82cm de ancho. Cualquier ancho de puerta diferente deberá ser valorado a parte. El acabado de puerta lo seleccionarás en el último paso.</p>");
    } else if (paso == "ajuste_cepillado_puerta_paso") {
        alertify.alert("<p>Selecciona a través de la barra la cantidad de puertas de paso que necesiten ser cepilladas. Este trabajo únicamente será necesario si el pavimento nuevo se coloca encima del actual (sin realizar el picado del pavimento actual).</p>");
    } else if (paso == "pasaplatos") {
        alertify.alert("<p>Haciendo clic sobre esta imagen, se activará el chec de selección para contemplar en tu presupuesto la apertura de hueco en un tabique de tú cocina para la colocación de un pasaplatos de medida máxima 100x100cm.</p>");
    } else if (paso == "colocacion_puerta_aluminio") {
        alertify.alert("<p>Selecciona  a través de la barra el número de puertas de aluminio que haya que desmontar y montar.</p>");
    } else if (paso == "colocacion_ventana_aluminio") {
        alertify.alert("<p>Selecciona  a través de la barra el número de ventanas de aluminio que haya que desmontar y montar.</p>");
    } else if (paso == "colocacion_balconera_aluminio") {
        alertify.alert("<p>Selecciona  a través de la barra el número de balconeras de aluminio que haya que desmontar y montar.</p>");
    }
}