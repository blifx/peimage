var marginTop;
var MAX_IMAGE_WIDTH=750;
var MAX_IMAGE_HEIGTH=475;
var SIZE_LAYOUT_WIDHT=1080;
var SIZE_LAYOUT_HEIGTH=960;

$('#f-height-conteudo').val(100);
setTopContent(100);
$('#f-left-right-conteudo').val(160);
setLeftRightContent(160);

/**
 * define as configuracoes do tema do layout
 */
function setConfLayout(confLayout){

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
            "font-size" : "23px"
        });
        $("#title-img").css("font-size", "35px");
        
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

    $("#description-product").css({top: "635px"});
    $("#price-off, #price1, #und").hide();
    $("#price-on, #price2, #und").hide();

    $("#img-bottom").css({top: "684px"});
    if(lenP1>0 && lenP2>0){
        $("#img-bottom").css({top: "725px"});
    }

    if(lenP2 > 0){
        $("#price-on, #price2, #und").show();
        $("#price1").css("font-size", "40px");
        if(lenP2 == 4){
            $("#und").css("left", "630px");
            $("#price-on").css("left", "382px");
            $("#price-desc").css("left", "675px");
        } else if(lenP2 == 5){
            $("#und").css("left", "658px");
            $("#price-on").css("left", "350px");
            $("#price-desc").css("left", "710px");
        } else if(lenP2 == 6){
            $("#und").css("left", "683px");
            $("#price-on").css("left", "325px");
            $("#price-desc").css("left", "740px");
        }  else if(lenP2 == 7){
            $("#price-on").css("left", "304px");
            $("#price2").css({"font-size": "100px"});
            $("#und").css("left", "707px");
            $("#price-desc").css("left", "766px");
        }

        if(lenP1 > 0){
            $("#price-off,#price1,#container-price").show();
            if(lenP1 == 4){
                $("#price-off").css("left", "477px");
                $("#tachado").css("width", "129px");
                $("#tachado").css("left", "416px");
            } else if(lenP1 == 5){
                $("#price-off").css("left", "469px");
                $("#tachado").css("width", "150px");
                $("#tachado").css("left", "464px");
            } else if(lenP1 == 6){
                $("#price-off").css("left", "457px");
                $("#tachado").css("width", "171px");
                $("#tachado").css("left", "454px");
            }  else if(lenP1 == 7){
                $("#price-off").css("left", "449px");
                $("#tachado").css("width", "192px");
                $("#tachado").css("left", "444px");
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

     $("#descr-img").css({
        "margin-left" : CenterText($('#descr-img').width()) + "px",
    }); 

    $("#title-img").css({
        "margin-left" : CenterText($('#title-img').width()) + "px",
    });  

    $("#price1").css({
        "margin-left" : CenterText($('#price1').width())-26 + "px",
    }); 

    $("#price2").css({
        "margin-left" : CenterText($('#price2').width()) + "px",
    }); 

}

if($('#f-height-img').length){
    $(document).on('input change', '#f-height-img', function() {
        setMarginTop(this.value);
        CenterImage();
    });
}

if($('#f-height-conteudo').length){
    $(document).on('input change', '#f-height-conteudo', function() {
        setTopContent(this.value);

    });
}

if($('#f-left-right-conteudo').length){
    $(document).on('input change', '#f-left-right-conteudo', function() {
        setLeftRightContent(this.value);
    });
}

$('#img-product').on('load', function() {
    CenterImage();
});

function setMarginTop(value){
    value = parseInt(value);
    let top = 100, height, maxHeight;
    height = MAX_IMAGE_HEIGTH;
    maxHeight = MAX_IMAGE_WIDTH;
    

    if($("#container-price").is(":visible")){
        height = MAX_IMAGE_HEIGTH;
        maxHeight = MAX_IMAGE_HEIGTH;
        value *= 1.69;
    } else {
        height = MAX_IMAGE_HEIGTH;
        maxHeight = MAX_IMAGE_HEIGTH;
    }
    $("#img-center").css({
        "top" : (top + value) + "px",
        "height" : (height - value) + "px"
    }); 
    
    $("#img-product").css("max-height", (maxHeight - value) + "px");
}

function CenterImage(){
    imgWidth = parseInt($('#img-product').width());
    var metade=(SIZE_LAYOUT_WIDHT/2)-(imgWidth/2);
    $("#img-center").css({
        "left" : metade + "px",
    }); 
}

function CenterText(sizeText){
    sizeText = parseInt(sizeText);
    let calc =(SIZE_LAYOUT_WIDHT/2)-(sizeText/2);
    return calc
}

function setTopContent(value){
    value = parseInt(value);
    let top = 100;
    $("#content-img").css({
        "top" : (top + value) + "px",
    }); 
}

function setLeftRightContent(value){
    value = parseInt(value);
    let left = -160;
    $("#content-img").css({
        "left" : (left + value) + "px",
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
        'selecao-arquivo':{
            required:true,
        },
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