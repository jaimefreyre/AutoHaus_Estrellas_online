
    function MaysPrimera(string){
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

    var datosTabla;

    preguntas2 = 
    [
        'Trato del Personal' ,
        'Organizacion del concesionario' ,
        'Asesoramiento recibido' ,
        'Satisfaccion General' ,
        'Atencion y explicacion de los tramites administrativos y sus tiempos' ,
        'Prueba de manejo',
        'Contacto Postventa',
        'Nivel de explicaciones y condiciones tecnicas y limpieza' ,
        'Volveria'
    ];
    preguntas = ["A","B","c","D","E","F","G","H","I","J"];

    $('#act').hide();
    $('#tavla').hide();
    //$('#fechasaelegir').hide();
    $('#Sfechas').hide();
    function vertabla(){
        $('#tavla').fadeToggle();
    }    

    function mTdd(valor, categoria, hasta, desde){
        
        $('#contenidotabla').empty();
        
        if(hasta > valor.length){
            var FINAL = valor.length;
            var FINAL2 = valor.length;
        }
        else{
            var FINAL = hasta + 25;
            var FINAL2 = hasta - 25;  
        }

        if(desde <= 0){
            var BAJOS = 0;
            var BAJOS2 = 0;
        }
        else{
            var BAJOS = desde + 25;
            var BAJOS2 = desde - 25;
        }


        valor.forEach(function(el, key){
            console.log(key, el);
            if ( (key < hasta) && (key > desde) ){
                $('#contenidotabla').append('<tr><td>'+el.ID+'</td><td>'+el.NOMBRE+'</td><td>'+el.TELEFONO+'</td><td>'+el.EMAIL+'</td><td>'+el.PATENTE+'</td><td><img class="img-responsive" style="width:100px;height:auto;" src="http://apptablets0km.com/Haus/'+el.FOTO+'"> </td><td>'+el[categoria]+'</td><td>'+el.J+'</td></tr>');    
            }
        })
        $('#contenidotabla').append('<tr><td></td><td></td><td></td><td></td><td></td><td></td><td><a onclick="mTdd(datosTabla, \''+categoria+'\', '+FINAL2+', '+BAJOS2+');"><i class="pe-7s-angle-left-circle paginaciones"></i></a></td><td><a onclick="mTdd(datosTabla, \''+categoria+'\', '+FINAL+', '+BAJOS+');"><i class="pe-7s-angle-right-circle paginaciones"></i></a></td></tr>');
    }

    function pregunta(unod, asdes, fc1, fc2){
    
        $('#pie').remove();
        $('#barras').remove();
        $('#chartPreferences').append('<canvas width="500" height="500" id="pie"></canvas>');
        $('#chartActivity').append('<canvas id="barras"></canvas>');
        $('#pie').css('margin-top', '-38px');
        $('#barras').css('margin-top', '-38px');
        $('#contenidotabla').empty();


        var ctx = document.getElementById("pie").getContext("2d");
        var ctx2 = document.getElementById("barras").getContext("2d");

        if (unod && fc1 && fc2) {
            var ursl = "api.php?selector=adc&cat=" + unod + "&fc1="+ fc1 +"&fc2=" + fc2;
            var ursl2 = "api.php?selector=adc2&cat=" + unod + "&fc1="+ fc1 +"&fc2=" + fc2;
       		console.log(ursl)
        }
        else{
            var ursl = "api.php?selector=adc&cat=" + unod;
            var ursl2 = "api.php?selector=adc2&cat=" + unod;
       		console.log(ursl)
        }

        

        $.ajax({
            url: ursl2,
            type: "GET",
            cache: false,
            contentType: false,
            success: function(datos){
               var datosObjeto = JSON.parse(datos);
               var oj = {};
               datosTabla = datosObjeto;
               console.log(datosObjeto);
               mTdd(datosObjeto, unod, 25, 0);      
            }
        })
    

        $.ajax({
            url: ursl,
            type: "GET",
            cache: false,
            contentType: false,
            success: function(datos){
            	console.log(ursl)
                var datosObjeto = JSON.parse(datos);
                var oj = {};
                datosObjeto.forEach(function(el){
                    if (!oj[el[unod]]){
                        oj[el[unod]] = [];
                        oj[el[unod]].push(el[unod]);
                    }
                    else{
                        oj[el[unod]].push(el[unod])
                    }
                });
                console.log(oj)                
                
                texto = MaysPrimera(unod);
                console.log(unod)

                $('#pietitulo').text(texto);
                $('#piecopete').text(asdes);

                $('#barrast').text(texto);
                $('#barrasc').text(asdes);

                var labels = [];
                var labels2 = [];
                var series = [];

                var labelsNoNull = [];
                var labels2NoNull = [];
                var seriesNoNull = [];

                //Contador de promedo de estrellas
                var totalVotos = 0;
                var realEstrellas = 0;
                var funcionReal = false;

                var i = 0;
                for (key in oj) {
                    if(key){    
                        if(key == "null") {
                            labels.push('No Completado');
                            labels2.push('No Completado - '+ oj[key].length + ' Votos');
                            series.push(oj[key].length);
                        }
                        else if( (key == "si") || (key == "no") ){
                            labels.push(key);
                            labels2.push(key + ' ' +  oj[key].length + ' Votos');
                            series.push(oj[key].length);
                            labelsNoNull.push(key);
                            labels2NoNull.push(key + ' ' +  oj[key].length + ' Votos');
                            seriesNoNull.push(oj[key].length);
                        }
                        else{
                            funcionReal = true;
                            labels.push(key);
                            labels2.push(key + ' Estrellas  - ' +  oj[key].length + ' Votos');
                            series.push(oj[key].length);
                            labelsNoNull.push(key);
                            labels2NoNull.push(key + ' Estrellas  - ' +  oj[key].length + ' Votos');
                            seriesNoNull.push(oj[key].length);
                            totalVotos += oj[key].length; 
                            realEstrellas += key * oj[key].length;   
                        }
                    }
                    i++;
                }
                series.push(0);
                

                if(funcionReal){
                    var idealEstrellas = totalVotos * 5;
                    var promerdioEstrellas = (realEstrellas * 5) / idealEstrellas;
                    console.log(promerdioEstrellas);
                    $('#pietitulo').text(promerdioEstrellas);
                    $('#barrast').text(promerdioEstrellas);
                }
                console.log('Labels')
                console.log(labels)
                console.log('Labels2')
                console.log(labels2)
                console.log('Series')
                console.log(series)

                var data = {
                    labels: labels2NoNull,
                    datasets: [{
                        label: asdes,
                        data: seriesNoNull,
                        backgroundColor: [
                            'rgba(255, 99, 132, 2)',
                            'rgba(255, 206, 86, 2)',
                            'rgba(54, 162, 235, 2)',
                            'rgba(75, 192, 192, 2)',
                            'rgba(153, 102, 255, 2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ]
                    }]
                };


                var data2 = {
                    labels: labels2,
                    datasets: [{
                        label: asdes,
                        data: series,
                        backgroundColor: [
                            'rgba(255, 99, 132, 2)',
                            'rgba(255, 206, 86, 2)',
                            'rgba(54, 162, 235, 2)',
                            'rgba(75, 192, 192, 2)',
                            'rgba(153, 102, 255, 2)'
                        ],
                        borderColor: [
                            'rgba(255,99,132,1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ]
                    }]
                };
                
                    var myChart = new Chart(ctx, {
                        type: 'pie',
                        data: data,
                        animation:{
                            animateScale:true
                        }
                });

                    var myChart = new Chart(ctx2, {
                        type: 'bar',
                        data: data2,
                        options : {
                                scales: {
                                    xAxes: [{
                                        gridLines: {
                                            offsetGridLines: true
                                        }
                                    }]
                                }
                            },
                        animation:{
                            animateScale:true
                        }
                });                          
            }
        
        });

    }

    function ad(asesor, fc1, fc2){

        console.log(asesor);
        console.log(fc1)
        console.log(fc2)
        $('#SHH').empty();
        $('#controldefunciones').empty();
        //$('#bfecha').empty();
        pregunta('compra');
        for (key in preguntas){
            texto = MaysPrimera(preguntas2[key]);
            texto1 = MaysPrimera(preguntas[key]);
            $('#SHH').append('<li><a href="#" class="lonki" onclick="pregunta(\''+ texto1 +'\', \''+ texto +'\');">'+texto1+'</a></li>');
            $('#controldefunciones').append('<li><a href="#" class="dropdown-toggle lonki" data-toggle="dropdown" onclick="pregunta(\''+ texto1 +'\', \''+ texto +'\');">'+texto1+' <br></a></li>')
            console.log(texto1);
        }
        //$('#bfecha').append('<label>Confirmar</label><button type="submit" onclick="ad(\'noseasigno\', $(\'#fc1\').val(), $(\'#fc2\').val());" class="btn btn-info btn-fill pull-right">Asignar Fechas</button>'); 
    };

    function activ(val){
        $('.dfd').removeClass('active');
        val.classList.add("active");
    }

    ad();
    pregunta('A');


        $(document).ready(function(){
          
            $.notify({
                icon: 'pe-7s-gift',
                message: "Bienvenido <b>Elija en el lateral el filtro por Vendedor</b> y en el panel principal las distantas preguntas"

            },{
                type: 'info',
                timer: 4000
            });

        });


        $('#settingh').hide();
        var objSet = {};
        var respuesta = {};
        respuesta.asesores = [];
        $.ajax({
            url: 'http://apptablets0km.com/Haus/hausConfiguracion.php',
            type: "GET",
            cache: false,
            contentType: false,
            success: function(datos){
                console.log(datos);
                objSet = JSON.parse(datos);
                objSet.asesores.forEach(function(element, key) {
                    $("#info").append('<div class="input-group"><input type="text" class="form-control" placeholder="vendedores" id="asesor'+ key +'" value="'+element+'"><span class="input-group-btn danger"><button id="NuevoVendedor" onclick="borrarasesor(\''+key+'\')" class="btn btn-danger" type="button">-</button></span></div>');
                    console.log(element);
                    $("#menuPL").append('<li id="'+element+'" class="dfd" onclick="activ(this)"><a href="#" onclick="ad(\''+element+'\'); $(\'#fc1\').val(\' \'); $(\'#fc2\').val(\' \');"><i class="pe-7s-add-user"></i><p>'+element+'</p></a></li>');

                    console.log(element);
                });
                $("#info").append('<div class="input-group"><input type="text" class="form-control" placeholder="vendedores" id="nasesor" value=""><span class="input-group-btn success"><button id="NuevoVendedor" onclick="nuevoasesor()" class="btn btn-success" type="button">+</button></span></div>');
            }
        })

        $('#act').on('click', function(event){
            //event.preventDefault();
            objSet.asesores.forEach(function(element, key) {
                respuesta.asesores.push( $('#asesor'+key).val() ); 
            })
            console.log(respuesta)
            console.log(JSON.stringify(respuesta))
            /* Act on the event */

            $.ajax({
                url: 'http://apptablets0km.com/Haus/hausConfiguracion.php?fun=N',
                type: 'POST',
                data: JSON.stringify(respuesta),
                cache: false,
                contentType: false,
                success: function(datos){
                    console.log(datos);
                }
            });
            $('#act').hide();
            location.reload();
        });


        
         function nuevoasesor(){
            console.log('se hixo click en NuevoAsesor')
            if ($('#nasesor').val()){
                objSet.asesores.push( $('#nasesor').val() );
                $("#info").empty();
                objSet.asesores.forEach(function(element, key) {
                    $("#info").append('<div class="input-group"><input type="text" class="form-control" placeholder="vendedores" id="asesor'+ key +'" value="'+element+'"><span class="input-group-btn danger"><button id="NuevoVendedor" onclick="borrarasesor(\''+key+'\')" class="btn btn-danger" type="button">-</button></span></div>');
                    console.log(element);
                });
                $("#info").append('<div class="input-group"><input type="text" class="form-control" placeholder="vendedores" id="nasesor" value=""><span class="input-group-btn success"><button id="NuevoVendedor" onclick="nuevoasesor()" class="btn btn-success" type="button">+</button></span></div>');
                $('#act').show();
            }
        };
        function borrarasesor(cc){
            console.log('se hixo click en BorrarAsesor')
            if (cc){
                cc = parseInt(cc);
                objSet.asesores.splice(cc, 1);
                $("#info").empty();
                objSet.asesores.forEach(function(element, key) {
                    $("#info").append('<div class="input-group"><input type="text" class="form-control" placeholder="vendedores" id="asesor'+ key +'" value="'+element+'"><span class="input-group-btn danger"><button id="NuevoVendedor" onclick="borrarasesor(\''+key+'\')" class="btn btn-danger" type="button">-</button></span></div>');
                    console.log(element);
                });
                $("#info").append('<div class="input-group"><input type="text" class="form-control" placeholder="vendedores" id="nasesor" value=""><span class="input-group-btn success"><button id="NuevoVendedor" onclick="nuevoasesor()" class="btn btn-success" type="button">+</button></span></div>');
                $('#act').show();
            }
        };





