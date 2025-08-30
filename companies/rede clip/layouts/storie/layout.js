var marginTop;

/**
 * define as configuracoes do tema do layout
 */
function setConfLayout(confLayout){
    //Configuração inicial dos inputs ranges horizontal/vertical
    $('#f-height-conteudo').val(100);
    setTopContent(100);

    $("#price2").css({
        "font-size": "100px"
    });

    $("#title-img, #descr-img").css("color", confLayout["f-title-color"]);

    $("#price-desc").css({
        "background-color" : confLayout["f-desc-color"],
        "color" : confLayout["f-desc-font-color"]
    });

    $("#container-price").css("border-color", confLayout["f-price1-color-border"]);
    
    $("#price1").css("color", confLayout["f-price1-color"]);
    $("#price2").css("color", confLayout["f-price2-color"]);
    $("#tachado").css("background", confLayout["f-strikethrough-color"]);

    var pathCSS = encodeURI(__DIR_LAYOUT.substr(0, __DIR_LAYOUT .indexOf("campaigns")) + "/layouts/" + getParamURL("layout") + "/img/");


    //se layout campanha super feirão de utilidades
    if(getParamURL("campanha") == "75666"){
        $("#price-desc").css({
            "width": "120px",
            "height": "118px",
            "text-align": "center",
            "background": "none",
            "position": "absolute",
            "top": "231px",
            "left": "445px",
            "font-weight": "bold",
            "background-image": "url("+pathCSS+"utili-desc.png)",
            "background-repeat": "no-repeat"
        });
        
        $("#desc").css({
            "font-size": "25px",
            "height": "36px",
            "padding-top": "30px"
        });
        
        $("#num-perc-desc").css({
            "font-size": "30px",
            "line-height": "60px",
            "padding-top": "10px"
        });
        
        $("#percent").css({
            "font-size": "28px",
            "margin-right": "10px",
            "padding-top": "19px",
        });
        $("#desc").html("Desc.");
    }

    //se layout campanha natal
    if(getParamURL("campanha") == "44"){
        $("#price-desc").css({
            "width": "120px",
            "height": "118px",
            "text-align": "center",
            "background": "none",
            "position": "absolute",
            "top": "231px",
            "left": "461px",
            "font-weight": "bold",
            "background-image": "url("+pathCSS+"desconto_natal.jpg)",
            "background-repeat": "no-repeat"
        });
        
        $("#desc").css({
            "font-size": "25px",
            "height": "36px",
            "padding-top": "15px"
        });
        
        $("#num-perc-desc").css({
            "font-size": "45px",
            "line-height": "40px"
        });
        
        $("#percent").css({
            "font-size": "28px",
            "padding-top": "9px"
        });
        $("#desc").html("Desc.");
    }
    if(getParamURL("campanha") == "57"){
        $("#price-desc").css({
            "width": "128px",
            "height": "128px",
            "text-align": "center",
            "background": "none",
            "position": "absolute",
            "top": "231px",
            "left": "461px",
            "font-weight": "bold",
            "background-image": "url("+pathCSS+"desconto_volta_aulas.png)",
            "background-repeat": "no-repeat"
        });
        
        $("#desc").css({
            "font-size": "25px",
            "height": "36px",
            "padding-top": "24px"
        });
        
        $("#num-perc-desc").css({
            "font-size": "69px",
            "line-height": "60px"
        });

        $("#center-desc").css({
            "padding-left": "0px",
            "padding-top": "8px"
        });
        
        $("#percent").css({
            "font-size": "28px",
            "padding-top": "12px"
        });
        $("#desc").html("DESC.");
    }

    //se layout campanha natal
    if(getParamURL("campanha") == "62"){
        $("#price-desc").css({
            "width": "120px",
            "height": "118px",
            "text-align": "center",
            "background": "none",
            "position": "absolute",
            "top": "231px",
            "left": "461px",
            "font-weight": "bold",
            "background-image": "url("+pathCSS+"desconto_torra_brinquedos.png)",
            "background-repeat": "no-repeat"
        });
        
        $("#desc").css({
            "font-size": "25px",
            "height": "36px",
            "padding-top": "15px"
        });
        
        $("#num-perc-desc").css({
            "font-size": "69px",
            "line-height": "60px"
        });
        
        $("#percent").css({
            "font-size": "28px",
            "padding-top": "9px"
        });
        $("#desc").html("Desc.");
    }
    
    //se layout campanha pascoa
    if(getParamURL("campanha") == "64"){
        $("#price-desc").css({
            "width": "133px",
            "height": "150px",
            "text-align": "center",
            "background": "none",
            "position": "absolute",
            "top": "231px",
            "left": "461px",
            "font-weight": "bold",
            "background-image": "url("+pathCSS+"desconto_pascoa.png)",
            "background-repeat": "no-repeat"
        });
        
        $("#desc").css({
            'font-size': '25px',
            'height': '36px',
            'padding-top': '43px',
            'zoom': 0.7,
            'padding-left': '14px',
        });
        
        $("#num-perc-desc").css({
            "font-size": "72px",
            "line-height": "60px"
        });
        
        $("#percent").css({
            "font-size": "28px",
            "padding-top": "9px"
        });

        $("#center-desc").css({
            'padding-left': '28px',
            'margin': '0 auto',
            'display': 'inline-flex',
            'zoom': '0.7',
            'padding-top': '21px'
        });
    }


    $("#desc").html("Desc.");
    marginTop = confLayout["f-height-img"];
    setMarginTop(marginTop);

}

/**
 * define os valores dos campos do layout
 */
async function setConfCapture(data){

    var existFileImg = existImageProduct(data);

    if(existFileImg){
        $("#description-product").css({
            "top" : "845px",
            "font-size" : "23px"
        });
        $("#title-img").css("font-size", "35px");
        
        setImageProductLayout(data);
        
    } else {
        $("#description-product").css({
            "top" : "805px",
            "font-size" : "35px"
        });
        $("#title-img").css("font-size", "35px");
        $("#img-product").attr("src",  __INIT_IMG_TRANSPARENT_CAPTURE);
    }

    $("#title-img").html(data["f-title-img"]);
    $("#descr-img").html(data["f-descr-img"]);

    if($("#f-precif").val() != ""){
        $("#und").text($("#f-precif").val());
    }else{
        $("#und").text("CADA");
    }

    var price1 = data["f-price1"];
    var price2 = data["f-price2"];

    if(price1 != "" && price2 == "" || price2 == "0,00"){
        price2 = price1;
        price1 = "";
    }

    var lenP1 = price1.length;
    var lenP2 = price2.length;

    if(price1 != ""){
        $("#price1").html(price1);
        $("#tachado").show();
    } else {
        $("#tachado").hide();
        $("#price1").html("");
    }

    $("#price2").html(price2);

    if(existFileImg){
        $("#description-product").css({top: "825px"});
/*         $("#img-product").css({
            "max-width": "750px",
            "max-height": "475px"
        }); */
    }

    if($("#descr-img").text() != ""){
        $("#description-product").css("top", "805px");
    }
    
    $("#price-off, #price1, #und").hide();
    $("#price-on, #price2, #und").hide();

    $("#img-bottom").css({top: "845px"});
if(lenP1>0 && lenP2>0){
    $("#img-bottom").css({top: "890px"});
}

    if(lenP2 > 0){
        $("#price-on, #price2, #und").show();
        $("#price1").css("font-size", "40px");
        if(lenP2 == 4){
            $("#und").css("left", "462px");
            $("#price-on").css("left", "191px");
        } else if(lenP2 == 5){
            $("#und").css("left", "488px");
            $("#price-on").css("left", "170px");
        } else if(lenP2 == 6){
            $("#und").css("left", "510px");
            $("#price-on").css("left", "150px");
        }  else if(lenP2 == 7){
            $("#price-on").css("left", "123px");
            $("#price2").css({"font-size": "100px"});
            $("#und").css("left", "538px");
            $("#price-desc").css("left", "522px");
        }

        if(lenP1 > 0){
            $("#price-off,#price1,#container-price").show();
            if(lenP1 == 4){
                $("#price-off").css("left", "294px");
                $("#tachado").css("width", "129px");
                $("#tachado").css("left", "293px");
            } else if(lenP1 == 5){
                $("#price-off").css("left", "284px");
                $("#tachado").css("width", "150px");
                $("#tachado").css("left", "283px");
            } else if(lenP1 == 6){
                $("#price-off").css("left", "274px");
                $("#tachado").css("width", "171px");
                $("#tachado").css("left", "272px");
            }  else if(lenP1 == 7){
                $("#price-off").css("left", "264px");
                $("#tachado").css("width", "192px");
                $("#tachado").css("left", "262px");
            } 
            
        } 


    }
    if(lenP2 == 0 || $("#price2").text() == "0,00"){
        $("#price-on, #price2, #und").hide();
    }

    var p1 = parseFloat(price1.replace(",", ".")); 
    var p2 = parseFloat(price2.replace(",", "."));
    var desc = parseInt( ( (p1 - p2) / p1 ) * 100 );
    if(desc > 0 && desc != 100){
        $("#price-desc").show();
        $("#num-perc-desc").html(desc);
    } else {
        $("#price-desc").hide();
    }

    $("#obs-img").html(data["f-obs-img"]);

    if($('#f-height-conteudo').length){
        $(document).on('input change', '#f-height-conteudo', function() {
            setTopContent(this.value);
    
        });
    }

}

if($('#f-height-img').length){
    $(document).on('input change', '#f-height-img', function() {
        setMarginTop(this.value);
    });
}

function setMarginTop(value){
    value = parseInt(value);
    let top = 270, height, maxHeight;
    height = 475;
    maxHeight = 475;
    if($("#container-price").is(":visible")){
        height = height;
        maxHeight = maxHeight;
        value *= 1.69;
    } else {
        height = height;
        maxHeight = maxHeight;
    }
    $("#img-center").css({
        "top" : (top + value) + "px",
        "height" : (height - value) + "px"
    }); 
    $("#img-product").css("max-height", (maxHeight - value) + "px");
}


function setTopContent(value){
    value = parseInt(value);
    let top = -100;
    $("#content-img").css({
        "top" : (top + value) + "px",
    }); 
}


//validacao monetaria funciona apenas no browser padrao
var nua = navigator.userAgent;
if(nua.indexOf('Android') == -1 && nua.indexOf('Chrome') != -1){
    $("#f-price1, #f-price2").maskMoney({
        thousands:"",
        decimal:",",
        allowEmpty:true,
    });
}

var __MODELS_LAYOUT = [{
    "selecao-arquivo" : "../images/model_layout/bola.jpg",
    "f-title-img" : "Bola de futebol Nike",
    "f-descr-img" : "Uso profissional",
    "f-price1" : "28,90",
    "f-price2" : "",
    "f-obs-img" : ""
},
{
    "selecao-arquivo" : "../images/model_layout/conj_copos.jfif",
    "f-title-img" : "Copos de vidro",
    "f-descr-img" : "Conjunto 6 copos",
    "f-price1" : "28,90",
    "f-price2" : "18,90",
    "f-obs-img" : "** Apenas 10 unidades **"
},
{
    "selecao-arquivo" : "../images/model_layout/faqueiro.jfif",
    "f-title-img" : "Kit Faqueiro",
    "f-descr-img" : "Inox 42 Peças Casita",
    "f-price1" : "129,90",
    "f-price2" : "112,90",
    "f-obs-img" : "** 1 conjunto de faqueiro com maleta em madeira. **"
}];

var __VALIDATION_FORM_CAPTURE = {
    rules:{
        'f-title-img':{
            required:true,
            minLength:3,
            maxLength:42,
        },
        'f-price1':{
            required:true,
            money:true
        },
        'f-price2':{
            money:true,
            greater:"#f-price1"
        }
    },
    messages:{
        'f-price2':{
            greater:'Preço promocional deve ser menor que o preço normal'
        }
    }
};

var __VALIDATION_FORM_CONF = {
    rules:{
        'f-title-color': {
            colorHex:true
        },
        'f-desc-color': {
            colorHex:true
        },
        'f-desc-font-color': {
            colorHex:true
        },
        'f-price1-color': {
            colorHex:true
        },
        'f-price1-color-border': {
            colorHex:true
        },
        'f-price2-color': {
            colorHex:true
        },
        'f-strikethrough-color': {
            colorHex:true
        }
    }
};