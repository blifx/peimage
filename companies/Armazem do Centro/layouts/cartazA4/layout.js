var marginTop;

/**
 * define as configuracoes do tema do layout
 */
function setConfLayout(confLayout){

    $("#price2").css({
        "font-size": "145px"
    });

    $("#title-img, #descr-img").css("color", confLayout["f-title-color"]);

    $("#price-desc").css({
        "background-color" : confLayout["f-desc-color"],
        "color" : confLayout["f-desc-font-color"]
    });

    $("#container-price").css("border-color", confLayout["f-price1-color-border"]);
    
    $("#price1, #price-off").css("color", confLayout["f-price1-color"]);
    $("#price2, #price-on, #und").css("color", confLayout["f-price2-color"]);
    $("#tachado").css("background", confLayout["f-strikethrough-color"]);

    var pathCSS = encodeURI(__DIR_LAYOUT.substr(0, __DIR_LAYOUT .indexOf("campaigns")) + "/layouts/" + getParamURL("layout") + "/img/");

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
            "font-size": "69px",
            "line-height": "60px"
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
            "top" : "460px",
            "font-size" : "23px"
        });
        $("#title-img").css("font-size", "30px");
        
        setImageProductLayout(data);
        
    } else {
        $("#description-product").css({
            "top" : "375px",
            "font-size" : "35px"
        });
        $("#title-img").css("font-size", "35px");
        $("#img-product").attr("src",  __INIT_IMG_TRANSPARENT_CAPTURE);
    }

    $("#title-img").html(data["f-title-img"]);
    $("#descr-img").html(data["f-descr-img"]);

    var price1 = data["f-price1"];
    var price2 = data["f-price2"];

    if(price1 != "" && price2 == "" || price2 == "0,00"){
        price2 = price1;
        price1 = "";
    }

    var lenP1 = price1.length;
    var lenP2 = price2.length;

    if(price1 != ""){
        $("#price1").html("R$" + price1);
        $("#tachado").show();
    } else {
        $("#tachado").hide();
        $("#price1").html("");
    }

    $("#price2").html(price2);

    if(lenP1 > 0){
        $("#price-off, #container-price").show();
        $("#img-center").css({
            height: "215px"
        });

        $("#img-product").css({
            "max-width": "305px",
            "max-height": "220px"
        });
        if(existFileImg){
            $("#description-product").css({
                top: "460px"
            });
        }
        if(lenP1 == 7){
            $("#price1").css("font-size", "105px");
        } else {
            $("#price1").css("font-size", "110px");
        }
        
    } else {
        $("#price-off, #container-price").hide();
        $("#img-center").css({
            height: "315px"
        });
        
        $("#img-product").css({
            "max-width": "355px",
            "max-height": "300px"
        });

        if(existFileImg){
            $("#description-product").css({
                top: "560px"
            });
        }
    }

    if(lenP2 > 0){
        $("#price-on, #und").show();
    } else {
        $("#price-on, #und").hide();
    }

    if(lenP2 <= 4){
        $("#und").css("left", "500px");
    } else if(lenP2 == 6){
        $("#und").css("left", "525px");
    }  else if(lenP2 == 7){
        $("#price2").css({
            "font-size": "145px"
        });
        $("#und").css("left", "540px");
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

    setMarginTop(marginTop);

}

if($('#f-height-img').length){
    $(document).on('input change', '#f-height-img', function() {
        setMarginTop(this.value);
    });
}

function setMarginTop(value){
    value = parseInt(value);
    let top = 233, height, maxHeight;

    if($("#container-price").is(":visible")){
        height = 215;
        maxHeight = 220;
        value *= 1.69;
    } else {
        height = 315;
        maxHeight = 300;
    }
    $("#img-center").css({
        "top" : (top + value) + "px",
        "height" : (height - value) + "px"
    });
    $("#img-product").css("max-height", (maxHeight - value) + "px");
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
    "selecao-arquivo" : __HTTP_HOST + "images/model_layout/bola.jpg",
    "f-title-img" : "Bola de futebol Nike",
    "f-descr-img" : "Uso profissional",
    "f-price1" : "28,90",
    "f-price2" : "",
    "f-obs-img" : ""
},
{
    "selecao-arquivo" : __HTTP_HOST + "images/model_layout/conj_copos.jfif",
    "f-title-img" : "Copos de vidro",
    "f-descr-img" : "Conjunto 6 copos",
    "f-price1" : "28,90",
    "f-price2" : "18,90",
    "f-obs-img" : "** Apenas 10 unidades **"
},
{
    "selecao-arquivo" : __HTTP_HOST + "images/model_layout/faqueiro.jfif",
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