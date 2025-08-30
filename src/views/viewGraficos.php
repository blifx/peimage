<?php
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    include('../config.php');

    $options = array();
    $sql = "
        SELECT
            DISTINCT(idlayouts),
            fkcampanhas,
            campanhas.nome AS nomeCampanha,
            layouts.nome AS nomeLayout
        FROM layouts
            INNER JOIN layouts_empresa ON layouts_empresa.fklayouts = idlayouts 
            LEFT JOIN layouts_campanha ON layouts_campanha.fklayouts   = idlayouts
            LEFT JOIN campanhas        ON idcampanhas = layouts_campanha.fkcampanhas
        WHERE 
            (layouts_empresa.fkempresas = '1' OR layouts_empresa.fkempresas = '$idcompanie')
            AND (fkcampanhas IS NULL AND status_campanha = 0)
            OR (campanhas.fkempresas = '$idcompanie' AND status_campanha = 1) 
            AND campanhas.desativacao IS NOT TRUE
            AND CURDATE() BETWEEN dt_inicio AND dt_encerramento
        ORDER BY fkcampanhas DESC ,nomeLayout ASC 
    ";

    $result = $DataBase->query($sql);
    while($row = mysqli_fetch_array($result)){
        $options[ $row["fkcampanhas"] ][] = array(
            "nameCampaign" => $row["nomeCampanha"],
            "idLayout"     => $row["idlayouts"],
            "nameLayout"   => $row["nomeLayout"]
        );
    }
?>

<!DOCTYPE html>
<html lang="pt-br" >
    <head>
        <meta charset="UTF-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        
        <title>Peimage - Gráficos</title>
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/utils.js"></script>
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/Chart.bundle.min.js"></script>

        <style>

            #content, body {
                background-color: #98d5f4;
            }

            form {
                margin-top: 20px;
                margin-bottom: 10px;
                background: #98d5f4;
                max-width: 1131px;
                width: 100%;
            }

            label {
                display: inline-block;
                margin-top: 0;
                font-size: 17px;
            }

            input, textarea, select {
                width: 173px;
                font-size: 12.8px;
            }

            .form-inline {
                width: 152.4px!important;
                display: inline-block;
            }

            #btn-lupa{
                height: 50px;
                display: inline-block;
            }

            #lupa{
                position: relative;
                top: 16px;
                background: #006064;
                width: 194px;
                height: 40px;
                text-align: center;
            }

            #lupa:hover{
                background: #4dc0fb;
                cursor: pointer;
            }

            #lupa img{
                width: 30px;
                padding: 5px;
            }

            @media only screen and (max-width: 1148px) {
                #btn-lupa{
                    margin-bottom: 10px;
                }
                #lupa{
                    width: 152px;                
                }
            }

            @media only screen and (max-width: 600px) {
                .form-inline {
                    display: initial;
                }
                #btn-lupa{
                    width: 100%;
                    margin-bottom: 10px;
                }
                #lupa{
                    width: 100%;
                }
            }

            .page-inner {
                display: none;
                position: relative;
                max-width: 1100px;
                margin: 0 auto;
                padding: 20px 15px 40px 15px;
                background: white;
                border: 1px solid #b3b3b3;
            }

            #fixed{
                position: fixed;
                bottom: 0;
                left: 0;
                width: 100%;
                z-index: 10;
                display: flex;
            }
            #canvas{
                margin:0 auto;
                background: white;
                touch-action: none;
            }

        </style>

        <script>
        $(function(){

        var optionSelect = <?=json_encode($options)?>;
        var colorFill = [];
        var colorBorder = [];
        var conf = {
            type:"horizontalBar",
            data:{
                labels:[],//nome das unidades
                datasets:[{
                    label: '',
                    data:[],//numero da utilizacao das propagadas
                    fill:false,
                    backgroundColor:"#98d5f4",
                    borderColor:"#00bcd4",
                    borderWidth:1,
                    barPercentage: 0.5,
                    barThickness: 6,
                    maxBarThickness: 8,
                    minBarLength: 2,
                }]
            },
            options:{
                legend: {
                    labels :{
                        fontColor:"#676767",
                        fontFamily:"Comic Sans MS",
                    },
                    onClick: (e) => e.stopPropagation()
                },
                scales: {
                    yAxes: [{
                        ticks:{
                            display:true,
                            fontColor:"#676767",
                            fontFamily:"Comic Sans MS",
                            fontSize:12
                        }
                    }]
                }
            }
        };

        var chart = new Chart(document.getElementById("chart"), conf);
        /*

        function printScale(){
            var image = document.getElementById('chart'),
            canvas = document.getElementById('canvas'),
            context = canvas.getContext('2d');
            context.clearRect(0, 0, canvas.width, canvas.height);
            context.restore();// Restore the transform

            context.drawImage(
                image,//imagem a ser recortada
                0,//inicio recorte X
                image.height-30, // inicio recorte eixo Y

                canvas.width + 118, //largura do recorte lateral apos eixo X
                30, // altura do recorte apos eixo Y

                0, 0, // visao do usuario sobre o recorte X/Y

                canvas.width,//largura do recorte
                30 //altura do recorte
            );

        }

        //tamanho do scroll
        function paintScale(){
            if($(document).width() > 700){
                if (($(window).innerHeight() + $(window).scrollTop()) >= $(document).outerHeight() - 60) {
                    document.getElementById("fixed").style.display = "none";
                } else {
                    document.getElementById("fixed").style.display = "flex";
                    document.getElementById("canvas").width = document.getElementById("chart").style.width.replace("px", "");
                    printScale();                
                }
            } else {
                $("#fixed").hide();
            }
        };
        //OBS
        //se futuramente der problema neste trecho podemos simplesmente
        //ocultar a barra quando houver zoom ou janela for minimizada e maximizada
        //(se isso for possivel detectar via js)
        window.onresize = function(event) {
            paintScale();
        };

        window.onscroll = function(ev) {
            paintScale();
        };
        */
            
        //$("#ini, #fim").attr("disabled", "disabled");

        $("#origem").change(function(){
            if(this.value == "1"){//agencia
                $("#categoria").val("");
                $("#categoria").attr("disabled", "disabled");
            } else {
                $("#categoria").removeAttr("disabled");
            }
            setCampaign();
        });

        $("#periodo").change(function(){
            if(this.value == "1"){
                $("#ini, #fim").val("");
                $("#ini, #fim").attr("disabled", "disabled");
            } else if(this.value == "0"){
                $("#ini, #fim").removeAttr("disabled");
            } 
        });

        $("#campanha").change(function(){
            loadSelectLayouts();
        });

        function loadSelectLayouts(){
            $("#layout option").remove();

            $("#layout").append("<option value='all'>todos materiais</option>");
            //somente se origem agencia exibimos outros materiais
            if($("#origem").val() == "1"){
                $("#layout").append("<option value='other'>outros materiais</option>");
            }

            if($("#campanha").val() == "all"){
                setDistinctLayout();
            } else {
                let val = $("#campanha").val()
                if(val == "null") val = "";
                setLayoutByID(val);
            }
        }

        function setCampaign(){
            $("#campanha option").remove();
            if($("#origem").val() == "0"){
                $("#campanha").append("<option value='all'>todas campanhas</option>");
                $("#campanha").append("<option value='null'>sem campanha</option>");
            }else{
                $("#campanha").append("<option value='all'>todas campanhas</option>"); 
            }
            for(let i in optionSelect){
                let options = optionSelect[i];
                if(options[0].nameCampaign != null)
                    $("#campanha").append("<option value='"+i+"'>"+options[0].nameCampaign+"</option>"); 
            }
            loadSelectLayouts();
        }

        function setLayoutByID(id){
            for(let i in optionSelect){
                let options = optionSelect[i];
                if(i == id){
                    for(let j in options){
                        $("#layout").append("<option value='"+options[j].idLayout+"'>"+options[j].nameLayout+"</option>");
                    }
                }
            }
        }

        function getDistictLayoutsByCampaign(){
            var distinctLayout = {};
            for(let i in optionSelect){
                let options = optionSelect[i];
                if(i != ""){
                    for(let j in options){
                        distinctLayout[options[j].idLayout] =  options[j].nameLayout;
                    }
                }
            }
            return distinctLayout;
        }

        function setDistinctLayout(){
            let distinctLayout = getDistictLayoutsByCampaign();
            for(let i in distinctLayout){
                $("#layout").append("<option value='"+i+"'>"+distinctLayout[i]+"</option>");

            }
        }

        function getSum(total, num) {
            return parseInt(total) + parseInt(num);
        }

        setCampaign();
      
        $("#btn-lupa").click(function(){
            $(".page-inner").show();
            document.getElementById("fixed").style.display = "none";
            
            $.ajax({
                type: "get",
                url: <?= "'{$__HTTP_HOST}/src/actionGraficos.php'" ?> ,
                data: $("form").serialize(),
                dataType:'JSON'
            }).done(function(result){

                if(result){

                    console.log("TOTAL " + result[1].reduce(getSum, 0));

                    conf.options.animation = {
                        onComplete: function(e) {
                            //paintScale(); TODO
                            this.options.animation.onComplete = null;
                        }
                    };

                    chart.destroy();
                    var length = result[0].length;
                    if($(document).width() <= 700){//ao alterar essa resolucao alterar metodo paintScale

                        $("#fixed").hide();

                        var heigth;
                        //tratamento de resolucao de tela para dados diferentes
                        if(length == 1){
                            heigth = 70;
                        } else if(length <=  4){
                            heigth = 50;
                        } else {
                            heigth = 40;
                        }
                        $("#chart").attr("height", (result[0].length * heigth) + "px");

                    } else {
                        var heigth = result[0].length >=  4 ? 10 : 30;
                        $("#chart").attr("height", (result[0].length * heigth) + "px");
                    }

                    conf.data.labels = result[0];
                    conf.data.datasets[0].data = result[1];

                    if($("#origem").val() == 0){

                        conf.data.datasets[0].backgroundColor = "#98d5f4";
                        conf.data.datasets[0].borderColor = "#00bcd4";

                        conf.data.datasets[0].label = 'Número de materiais gerados por unidade';
                        conf.options.scales.xAxes[0].ticks = {
                            fontColor:"#676767",
                            fontFamily:"Comic Sans MS",
                            fontSize:12,
                            autoSkip: true,
                            beginAtZero: true
                        };

                        conf.options.tooltips = {
                            callbacks: {
                                label: function(t, d) {
                                    return "Materiais criados:" + t.value;
                                }
                            }
                        };

                    } else {

                        conf.data.datasets[0].backgroundColor = "#ffe0e6";
                        conf.data.datasets[0].borderColor = "#ff6384";

                        conf.data.datasets[0].label = 'Porcentagem de utilização dos materiais';
                        conf.options.scales.xAxes[0].ticks = {
                            beginAtZero: true,
                            steps: 10,
                            stepValue: 10,
                            max: 100,
                            callback: function(label, index, labels) {
                                return label+'%';
                            }
                        };

                        conf.options.tooltips = {
                            callbacks: {
                                label: function(t, d) {
                                    return t.value + "%";
                                }
                            }
                        };

                    }

                    chart = new Chart(document.getElementById("chart"), conf);
                }
            });
        });

        $("#btn-lupa").trigger("click");

    });

        </script>

    </head>
    <body>
        <?php menu($logo, $imageMenu); ?>            
        <div id="content">
            <form>

                <div class="form-inline">
                    <label>Origem</label>
                    <select id="origem" name="origem">
                        <option value="0">Peimage</option>
                        <option value="1">Agência/equipe</option>
                    </select>
                </div>

                <div class="form-inline">
                    <label>Campanha</label>
                    <select id="campanha" name="campanha">
                    </select>
                </div>

                <div class="form-inline">
                    <label>Material</label>
                        <select id="layout" name="layout">
                        </select>
                    </select>
                </div>

<!--                 <div class="form-inline">
                    <label>Categoria</label>
                    <select id="categoria" name="categoria">
                        <option value="">Geral</option>
                        <option value="P">Impressão</option>
                        <option value="F">Rede social</option>
                        <option value="D">Download</option>
                    </select>
                </div> -->

                <div class="form-inline">
                    <label>Período</label>
                    <select id="periodo" name="periodo">
                        <option value="0">Escolher data</option>
                        <option value="1">Mês atual</option>
                    </select>
                </div>

                <div class="form-inline">
                    <label>Início</label>
                    <input id="ini" name="ini" type="date">
                </div>

                <div class="form-inline">
                    <label>Fim</label>
                    <input id="fim" name="fim" type="date">
                </div>

                <div id="btn-lupa">
                    <div id="lupa">
                        <img src="<?=$__HTTP_HOST;?>/images/lupa.png" />
                    </div>
                </div>  

            </form>

            <div class="page-inner">
                <canvas id="chart" class="chartjs" width="undefined" height="undefined"></canvas>
            </div>
            
            <div id="fixed">
                <canvas id="canvas" width="800px" height="30px"></canvas>
            </div>

        </div>

    </body>
</html>