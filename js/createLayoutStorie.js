    //margin existente entre a imagem 
    var __MARGIN_IMAGE_THEME = 20;
    var __WIDTH;
    var __HEIGHT;
    var __SCALE;
    var __FUNC_MANAGE_LAYOUT;
    var __INIT_IMG_TRANSPARENT_CAPTURE = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=";
    var __MAX_HEIGHT_MINIATURE = 280;
    var __MAX_WIDTH_MINIATURE = 200;
    var __SELECTOR_FORM = "input[type='text'], select, textarea, input[type='range'], input[type='date'], input[type='time'], input[type='color']";
    //utilizado para o redimencionamento da imagem que deve conter o tamanho maximo INICIAL da imagem
    var __MAX_WIDTH_IMG_PRODUCT = parseInt($("#img-product").css("max-width").replace("px", ""));
    var __MAX_HEIGHT_IMG_PRODUCT = parseInt($("#img-product").css("max-height").replace("px", ""));
    var __FLAG = {
        loadListTab : false,
        modeEdit: "", //armazena o valor do uid do elemento se estiver em modo de edicao, senao vazio
        urlBlobImageProduct: "",
        scrollTopList: 0
    };

    function getDataForm(){
        var values = {};
        values["file-name"] = $("#file-name").text() != "Carregar imagem" ? $("#file-name").text() : "";
        values["selecao-arquivo"] = __FLAG.urlBlobImageProduct;
        $("#form-layout")
            .find(__SELECTOR_FORM)
            .each(function(i, val){
                values[ $(val).attr("id") ] = $(val).val();
        });
        return values;
    }

    function setDataConfCapture(){
        if(__TYPE_LAYOUT == "edit") setConfCapture(getDataForm())
    }

    function setDataConfLayout(){
        setConfLayout(__TYPE_LAYOUT == "edit" ? __LAYOUT_FEATURE : getDataForm())
    }

    //define a acao padrao para o tipo de layout
    __FUNC_MANAGE_LAYOUT = __TYPE_LAYOUT == "config" 
        ? setDataConfLayout
        : setDataConfCapture;

    $("#form-layout").validate(
        __TYPE_LAYOUT == "config"
            ? __VALIDATION_FORM_CONF
            : __VALIDATION_FORM_CAPTURE
    );

    //se for tela de configuracao nao exibimos lista
    if(__TYPE_LAYOUT == "config"){
        $("#scroll-form").css({
            "margin-top": "10px",
            "height": "calc(100% - 50px)"
        });
    } else {
        $(".tab").css("display", "flex");
    }

    function loadConfigForm(){
        if(__LAYOUT_FEATURE != ""){
            $.each(__LAYOUT_FEATURE, function(key, val){
                if($("#"+key).length) $("#"+key).val(val);
            });
        }
    }

    //bloqueia botao direito da imagem de captura
    document.getElementById("content-img-generate")
        .addEventListener('contextmenu', event => event.preventDefault());

    $('body').loadingModal({
        text: 'Carregando...',
        animation: 'threeBounce',
        backgroundColor: 'black'
    });

    var loadingInterval = setInterval(() => {
        if(document.getElementById("img-capture").complete){
            loadConfigForm();
            setDataConfLayout();
            if(__TYPE_LAYOUT == "edit"){
                //no layout de configuracao queremos manter
                //a estrutura padrao de configuracao do layout
                setDataConfCapture();
            } else {
                for(var i in __MODELS_LAYOUT){
                    $("#model-layout").append("<option value="+i+">Modelo "+(parseInt(i)+1)+"</option>");
                }
                $("#model-layout").change(function(){
                    setConfCapture(__MODELS_LAYOUT[this.value]);
                });
                setConfCapture(__MODELS_LAYOUT[0]);
            }
    
            $("#capture").show();//sem estar visivel nao eh possivel obter dados do tamanho
            __WIDTH = $("#img-capture").width();
            __HEIGHT = $("#img-capture").height();
            $("#capture").css({
                'max-width': __WIDTH,
                'max-height': __HEIGHT
            });
            adjustScreen();
            if($("#img-product").attr("src") == "")
                $("#img-product").attr("src", __INIT_IMG_TRANSPARENT_CAPTURE);
            loadStatusTest();
            $('body').loadingModal('hide');
            clearInterval(loadingInterval);
        }
    }, 250);

    window.addEventListener('resize', adjustScreen);

    function adjustScreen(){

        const imgWidth = 720;
        const imgHeight = 1280;
        
        // Obtenha a largura e altura do contêiner #content-img-generate
        const containerWidth = $("#content-img-generate").width();
        const containerHeight = $("#content-img-generate").height();
        
        // Margens superior e inferior desejadas
        const marginTop = 50;
        const marginBottom = 0;
        
        // Determine a escala com base nas dimensões do contêiner e adicione as margens
        const scaleWidth = (containerWidth - 40) / imgWidth; // Descontando as margens da largura do contêiner
        const scaleHeight = (containerHeight - marginTop - marginBottom) / imgHeight;
        
        // Use a menor escala entre a largura e a altura
        const scale = Math.min(scaleWidth, scaleHeight);
        
        // Calcule as dimensões redimensionadas da imagem
        const scaledWidth = (imgWidth-350) * scale;
        const scaledHeight = imgHeight * scale;
        
        // Calcule as posições de translação para centralizar a imagem
        const translateX = (containerWidth - scaledWidth) / 2;
        const translateY = (containerHeight - scaledHeight) / 2;
        
        // Aplica os estilos CSS
        $("#capture").css({
            "transform": "scale(" + scale + ") translate(" + translateX + "px, " + translateY + "px)",
            "transform-origin": "top left",
        });
        
        

    }

    $("#tema").change(function(){
        $("#img-capture").attr("src", __DIR_LAYOUT + this.value);
    });

    function setBlockedEvtClick(el, evt, block){
        if(block === false) {
            $(el).attr("blocked-evt", "false");
            return;
        }
        if($(el).attr("blocked-evt") == "false"){
            $(el).attr("blocked-evt", "true");
            return false;
        }
        if($(el).attr("blocked-evt") == "true"){
            evt.preventDefault();  
            evt.stopPropagation();
            return true;
        }
    }

    function loadStatusTest(){
        var status = parseInt($("#tema option:selected").attr("status_teste"));
        $("#status-test img").attr("src", "../images/" + (status ? "close.png" : "checked.png") );
        $("#status-test .buttons-tool-text").html(status ? "Desativar layout" : "Ativar layout");
        $("#status-test").show();
    }

    if($("#save-config").length)
        $("#save-config").click(saveConfigLayout);

    function saveConfigLayout(){
        if(!$("#form-layout").valid()){
            alert("Existem campos inválidos no formulário, verifique.");
            return;
        }
    
        var inputs = $("#form-layout").find("select, textarea, input").not("select[name='tema']");
        var values = {};
        inputs.each(function() {
            values[$(this).attr("id")] = $(this).val();
        });
        $.ajax({
            type: "POST",
            url: "../src/actionCreateLayoutStorie.php",
            data: {
                "act" : "saveConfigLayout",
                "data" : JSON.stringify(values),
                "idlayout" : getParamURL("idlayout"),
                "campanha" : getParamURL("campanha")
            },
            success: function(response){
                alert(response == "1" 
                    ? "Configuração do layout salva com sucesso."
                    : "Houve um erro ao salvar configuração."
                );
            },
            dataType: "text"
          });
    }

    $("#status-test").click(function(){
        var status = !eval($("#tema option:selected").attr("status_teste"));
        $.ajax({
            type: "post",
            url: "../src/actionCreateLayoutStorie.php",
            data:{
                act: "status",
                status: status,
                tema: $("#tema option:selected").attr("uid")
            },
            timeout:5000,
            dataType:'text'
        })
        .done(function(response){
            if(response == '1'){
                $("#tema option:selected").attr("status_teste", status);
                $("#status-test img").attr("src", "../images/" + (status ? "close.png" : "checked.png") );
                $("#status-test .buttons-tool-text").html(status ? "Desativar layout" : "Ativar layout");
                alert(status ? "Layout ativado com sucesso" : "Layout desativado com sucesso");
            } else {
                alert("Houve um erro ao salvar os dados.");
            }
        })
        .fail(function(){
            alert("Verifique sua conexão com a internet ou tente novamente mais tarde.");
        });
    });
    
    $("input, textarea").keyup(__FUNC_MANAGE_LAYOUT);
    $("select, input[type='date'], input[type='time'], input[type='color']").change(__FUNC_MANAGE_LAYOUT);

    $("#download").click(function(e){

        if($("#form-layout").valid()){

            $("#capture").css({top:'', left:''});

            if(setBlockedEvtClick(this, e)) return;

            var timeout = setTimeout(function(){
                $('body').loadingModal("destroy");
                $('body').loadingModal({
                    text: 'Processando download...',
                    animation: 'threeBounce',
                    backgroundColor: 'black'
                });
                $('body').loadingModal('show');
            }, 1000);

            domtoimage.toBlob(document.getElementById('capture'), {
                style:{
                    position: 'absolute',
                    top: 0,
                    left: 0,
                    margin: 0,
                    transform: 'scale(1, 1) translateY(0) translateX(0)'
                }
            })
            .then(function (blob){
                saveStatistic("d");
                clearTimeout(timeout);
                $('body').loadingModal('hide');
                saveAs(blob, 'peimage.png');
            }).catch(e => {
                console.log(e);
            }).finally(()=>{
                setBlockedEvtClick(this, e, false);
            });

        } else {
            alert("Verifique a validação dos campos do formulário");
        }
    });

    function saveStatistic(act, themes){
        if(!themes)
            themes = $("#tema").length ? $("#tema option:selected").attr("uid") : '';
        $.get("actionDownloads.php", {
            acao: act,
            tema: themes,
            layout: __ID_LAYOUT
        });
    }

    $("#post-fb").click(function(){
        if($("#form-layout").valid()){
            if(__AUTH_TOKEN_FB == ''){
                if(confirm("Deseja configurar sua conta do Facebook agora?\nVocê será encaminhado para a página de configuração.")){
                    window.location = "../src/actionRedeSocial.php?redirect="+window.location.href;
                }
                return;
            }
            if(!confirm("Tem certeza que deseja postar no Facebook?")){
                return;
            }
            $('body').loadingModal("destroy");
            $('body').loadingModal({
                text: 'Enviando postagem para o Facebook...', 
                animation: 'threeBounce',
                backgroundColor: 'black'
            });
            $('body').loadingModal('show');
            generateImageCanvas("postFacebook", "toBlob");
        } else {
            alert("Verifique a validação dos campos do formulário");
        }
    });

    $("#print-page").click(function(e){
        if($("#form-layout").valid()){
            if(setBlockedEvtClick(this, e)) return;
            generateImageCanvas("printWithStatistic", "toPng", this, e);
        } else {
            alert("Verifique a validação dos campos do formulário");
        }
    });
 
    $("#reset-form").click(function(){
        $('select#tema').prop('selectedIndex', 0).trigger("change");

        $("input[type=file]").val("").trigger("change");
        $("#content-form form").get(0).reset();
        if($("body").width() > 768){
            $("#content-form").get(0).scrollTo(0, 0);
        } else {
            $("body").get(0).scrollTo(0, 0);
        }
        $("#form-layout").validate("normalizeRules");
        //se esta no modo de edicao e nao esta na tab da lista
        if(__FLAG.modeEdit && $(".tab-selected").attr("id") != "tab-list"){
            $("#save-list").hide();
            $("#add-list").show();
        }
        __FUNC_MANAGE_LAYOUT();
    });

    $("#ctrl-img span").click(function(){
        $("input[type=file]").val("").trigger("change");
    });

    $("#ctrl-img img").click(function(){
        $("input[type=file]").trigger("click");
    });

    // Declare db instance
    var db = new Dexie("peimage");

    // Define Database Schema
    db.version(1).stores({
        layouts: "++id, id_layout, id_campaign, id_theme, attribute, image_product, miniature"
    });

    // Open Database
    db.open();

    //remove todos layouts de campanhas que foram deletadas
    //desta forma mantemos apenas registros validos
    function removeCampaignDisabled(){
        db.transaction('rw', db.layouts, ()=>{
            db.layouts.filter(function(el) {
                if(el.id_campaign != "")
                    return !(__IDS_ACTIVE_CAMPAIGN.includes(el.id_campaign));
                return false;
            }).delete();
        }).then(()=>{
            setCounterList();
        });
    }

    removeCampaignDisabled();

    function setCounterList(){
        db.layouts
            .where({id_layout:__ID_LAYOUT, id_campaign:__ID_CAMPAIGN})
            .count()
            .then((count) => {
                if(count > 0)
                    $("#counter-list").text("("+count+")").show();
                else
                    $("#counter-list").text("").show();
        });
    }

    function setTabSelected(el){
        $(el).addClass("tab-selected");
        $(".tab .tab-selected").not(el).removeClass("tab-selected");
    }

    $("#tab-form").click(function(){
        setTabSelected(this);
        __FLAG.scrollTopList = $("#scroll-form").scrollTop();
        $("#list-gallery, .button-list").hide();
        $("#buttons").css("display", "flex");
        if(__FLAG.modeEdit){
            $("#form-layout, .button-form").show();
            $("#add-list").hide();
        } else {
            $("#form-layout, .button-form").show();
            $("#save-list").hide();
        }
        $("#tema").trigger("change");
        setConfCapture(getDataForm());
    });

    $("#tab-list").click(function(){
        setTabSelected(this);
        $("#list-gallery, .button-list").show();
        $("#form-layout, .button-form").hide();
        $("#scroll-form").scrollTop(__FLAG.scrollTopList);
        $("#list-gallery").css("display", "table");
        $("#buttons").css("display", "flex");
        $("#msg-null-list").hide();
        if(!__FLAG[loadListTab]){
            __FLAG[loadListTab] = true;
            loadListTab();
        } else {
            refreshConfigTabList(true);
        }        
    });

    function b64toBlob(dataURI) {
        var byteString = atob(dataURI.split(',')[1]);
        var ab = new ArrayBuffer(byteString.length);
        var ia = new Uint8Array(ab);
    
        for (var i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }
        return new Blob([ab], { type: 'image/jpeg' });
    }

    function addFormToList(miniatureDataUrl){
        var insert;
        db.transaction('rw', db.layouts, function() {
            //transforma a imagem do layout em blob
            insert = db.layouts.add({
                id_layout: __ID_LAYOUT,
                id_campaign :__ID_CAMPAIGN,
                id_theme : parseInt($("#tema option:selected").attr("uid")),
                attribute: JSON.stringify(getDataForm()),
                image_product: b64toBlob($("#img-product").attr("src")), //TODO diminuir imagem para ocupar menos espaço
                miniature: b64toBlob(miniatureDataUrl)
            });
        }).then(() => {            
            var img = $("<img>").attr({
                "src" : miniatureDataUrl,
                "uid": insert._value
            });
            $(img).click(function(){
                setSelectedAndViewMiniatureByID(insert._value);
            });
            $("#list-gallery").prepend(img);
            setCounterList();
            $("#reset-form").trigger("click");
        })
        .catch(function(err) {
            console.error(err.stack || err);
        });
    }

    function resetLayout(){
        var fields = {
            "file-name" : ""
        };
        $(__SELECTOR_FORM, "#form-layout").each((i, val) => {
            fields[ $(val).attr("id") ] = "";
        });
        setConfCapture(fields);
    }

    function setSelectedMiniatureByID(id){
        $(".list-selected-img").removeClass("list-selected-img");
        $("#list-gallery img[uid='"+id+"']").addClass("list-selected-img");
    }

    function setSelectedAndViewMiniatureByID(id){
        setSelectedMiniatureByID(id);
        viewLayoutByID(id);
    }

    function viewLayoutByID(id){
       db.layouts.where(":id").equals(id).first(function(layout){
            let json = JSON.parse(layout.attribute);
            json['selecao-arquivo'] = URL.createObjectURL(layout.image_product);//convert blob to url
            $("#img-capture").attr("src", __DIR_LAYOUT + json.tema);
            setConfCapture(json);
        });
    }

    function loadListTab(){
        db.layouts
            .where({id_layout:__ID_LAYOUT, id_campaign:__ID_CAMPAIGN})
            .filter(function(el) {
                //se foi adicionado a lista antes do carregamento nao deve trazer o elemento
                //visto que ele jah foi inserido
                return $("#list-gallery img[uid='"+el.id+"']").length == 0;
            })
            .each(function (layout) {
                var img = new Image();
                img.src = URL.createObjectURL(layout.miniature);//convert blob to url
                $(img).attr("uid", layout.id);
                $(img).click(function(){
                    setSelectedAndViewMiniatureByID(layout.id)
                });
                $("#list-gallery").append(img);
        }).then(()=>{
            refreshConfigTabList(true);
        }).catch(function (error) {
            console.error(error);
        });
    }

    function refreshConfigTabList(toView){
        if(!$("#list-gallery img").length){
            $("#list-gallery").css("display", "flex");
            $("#msg-null-list").show();
            $("#buttons").hide();
            return;
        } else if(!$(".list-selected-img").length){
            $("#list-gallery img").first().addClass("list-selected-img");
        }
        if(toView)
            viewLayoutByID(parseInt($(".list-selected-img").attr("uid")));
    }

    $("#add-list").click(function(e){
        if($("#form-layout").validate("isValidAll")){
            if(setBlockedEvtClick(this, e)) return;
            generateMiniature()
            .then((dataUrl) => {
                addFormToList(dataUrl);
            }).finally(()=>{
                setBlockedEvtClick(this, e, false);
            });
        } else {
            alert("Existem campos inválidos no formulário, verifique.");
        }
    });

    /**
     * retorna uma promise
     */
    function generateMiniature(){
        var scale = __HEIGHT >= __WIDTH
            ? __MAX_HEIGHT_MINIATURE / __HEIGHT
            : __MAX_WIDTH_MINIATURE / __WIDTH;
        //save to blob
        var node = document.getElementById('capture');
        return domtoimage.toJpeg(node, {
            style:{
                position: 'absolute',
                top: '0',
                left: '0',
                transform: 'scale(1)',
                zoom: scale,
            },
            quality: 0.95,
            width: $("#capture").width() * scale,
            height: $("#capture").height() * scale
        });
    }

    function getIDselected(){
        return parseInt($(".list-selected-img").attr("uid"));
    }

    function setImageProductLayout(data){
        const file = data["selecao-arquivo"];
        if(file.indexOf("../") == 0){
            let objImg = new Image();
            objImg.src = file;
            objImg.onload = function(){
                $("#img-product").attr("src", removeImageBlanks(objImg));
                objImg.onload = null;
            }
        } else {
            //imagem url blob ou base64 processada 
            $("#img-product").attr("src", file);
        }
    }

    function existImageProduct(data){
        return data["file-name"] != "" && data["selecao-arquivo"];
    }

    $("#save-list").click((e) => {
        if($("#form-layout").validate("isValidAll")){
            if(setBlockedEvtClick(this, e)) return;
            if($(".list-selected-img").length){
                generateMiniature().then((dataURI)=>{
                    updateImage(dataURI);
                }).finally(()=>{
                    setBlockedEvtClick(this, e, false);
                });
            }
        } else {
            alert("Existem campos inválidos no formulário, verifique.");
        }
    });

    function updateImage(miniatureDataUrl){
        //remove antiga miniatura
        var uidSelected = __FLAG.modeEdit;
        //$("#list-gallery img[uid='"+uidSelected+"']").remove();
        db.transaction('rw', db.layouts, function() {
            layout = {
                id_layout: __ID_LAYOUT,
                id_campaign: __ID_CAMPAIGN,
                id_theme: parseInt($("#tema option:selected").attr("uid")),
                attribute: JSON.stringify(getDataForm()),
                miniature: b64toBlob(miniatureDataUrl)
            };
            //transforma a imagem do layout em blob
            if($("#img-product").attr("src").indexOf("blob:../") == -1){
                layout.image_product = b64toBlob($("#img-product").attr("src")); //TODO diminuir imagem para ocupar menos espaço
            }
            db.layouts.update(uidSelected, layout);

        }).then(() => {
            $("#add-list").show();
            $("#save-list").hide();
            $("#list-gallery img[uid='"+uidSelected+"']").attr("src", miniatureDataUrl);
            setSelectedMiniatureByID(uidSelected);
            $("#reset-form").trigger("click");
            __FLAG.modeEdit = "";
        })
        .catch(function(err) {
            console.error(err.stack || err);
        });
    }

    function getThemeLayout(layout){
        return __DIR_LAYOUT + JSON.parse(layout.attribute).tema;
    }

    $("#edit-layout-list").click(() => {
        if($(".list-selected-img").length){
            let uidSelected = getIDselected();
            db.layouts
            .where(":id")
            .equals(uidSelected)
            .first((layout) => {
                __FLAG.modeEdit = uidSelected;
                let json = JSON.parse(layout.attribute);
                __FLAG.urlBlobImageProduct = URL.createObjectURL(layout.image_product); //convert blob to url
                json['selecao-arquivo'] = __FLAG.urlBlobImageProduct;
                $("#img-capture").attr("src", getThemeLayout(layout));
                setConfCapture(json);
                for(var i in json){
                    if(i == "selecao-arquivo")
                        continue;
                    else if(i == "file-name")
                        setInputFile(json[i]);
                    document.getElementById(i).value = json[i];
                }
                $("#form-layout").validate("normalizeRules");
                $("#tab-form").trigger("click");
            });
        }
    });

    $("#remove-layout-list").click(() => {
        const func = ()=> {
            $("#reset-form").trigger("click");
            removeItemListByID(getIDselected(), true);
        }
        //se esta tentando excluir o layout que foi selecionado para edicao
        if(__FLAG.modeEdit == getIDselected()){
            if(confirm("Esse layout está sendo editado, tem certeza que deseja remové-lo?")){
                func();
                __FLAG.modeEdit = ""; 
            }
        } else {
            func();
        }
    });

    $("#erase-all-layout-list").click(() => {
        const func = () => {
            db.transaction('rw', db.layouts, function() {
                db.layouts.clear();
            }).then(()=>{
                $("#list-gallery img").remove();
                $("#tab-list").trigger("click");
                setCounterList();
                resetLayout();
                if(__FLAG.modeEdit != "")
                    __FLAG.modeEdit = ""
            })
            .catch(() =>{
                alert("Ops! Ocorreu um erro, se o problema persistir entre em contato o suporte técnico.");
            });
        };

        //se esta tentando excluir o layout que foi selecionado para edicao
        if(__FLAG.modeEdit != ""){
            if(confirm("Um item da lista está em modo de edição, tem certeza que deseja continuar?")){
                $("#reset-form").trigger("click");
                func();
            }
        } else if(confirm("Tem certeza que deseja remover todos itens da lista?")){
            func();
        }
    });

    $("#print-all-list").click(()=>{
        processList("print");
    });

    $("#download-all-list").click(()=>{
        processList("zip");
    });

    function generateImageCanvas(func, method, el, evt){
        var node = document.getElementById('capture');
        domtoimage[method](node, {
            style:{
                position: 'absolute',
                top: '0',
                left: '0',
                display: 'block',
                width: '100%',
                height: '100%',
                transform: 'scale(1, 1)'
            }
        })
        .then(function (dataUrl) {
            window[func](dataUrl);
        }).finally(()=>{
            if(el)
                setBlockedEvtClick(el, evt, false);
        })
    }

    function printWithStatistic(dataURL){
        print([dataURL]);
        saveStatistic("p");
    }

    function print(list){
        var newWin = window.frames["printf"];
        newWin.document.write(
            '<head>'
            +'<style>'
            +'@page{margin: 0;};' 
            +'section{width:100vw; height: 100vh; page-break-after: always;}'
            + 'body{margin:0;padding:0;line-height:1em;}'
            +'</style>'
            +'</head><body onload="window.print()">'
            +'</body>'
        );
        var imgs = list;
        for(var i in imgs){
            var img = $("<img/>").attr("src", imgs[i]);
            $(img).css({
                "transform" : "scale(1)  translateX(0) translateY(0)",
                "width" : "100%",
                "heigth" : "100%"
            });
            $('#printf').contents().find("body").append( $("<section>").append(img) );
        }
        newWin.document.close();
    }

    function startProgressBar(){
        $("#progress").css("display", "flex");
        setProgressBar(0)
    }

    function closeProgressBar(){
        $("#progress").hide();
    }

    function setProgressBar(total, printed){
        var percent = total > 0 ? Math.round( (printed/total) * 100) : 0;
        $("#text-progress-bar").html(percent + "%");
        $("#color-progress-bar").css('width', percent + "%");
    }

    //remove o elemento da lista baseado no seu id
    //alem disso ele seleciona de forma automatica o novo
    //elemento que deve estar selecionado anterior ou proximo
    function selectNextElementRemoved(id){
        const get = (act) => $(
                $("#list-gallery img[uid='"+id+"']")[act](), "#list-gallery"
            ).not("#msg-null-list");

        let selected = get("prev");
        if(selected == undefined) selected = get("next");
        if(selected != undefined) $(selected).addClass("list-selected-img");

        $("#list-gallery img[uid='"+id+"']").remove();
    }

    //aceita o id do elemento ou um array com os ids
    //toView indica se deseja carregar o proximo layout (se existir)
    //para visualizacao do usuario. Em alguns casos a remocao nao pode ser visualizada
    //como na lista de impressao que pode bugar a geracao da lista
    function removeItemListByID(id, toView){
        if(typeof id == "number"){
            db.layouts
                .where(':id')
                .equals(parseInt(id))
                .delete()
                .then(() => {
                    setCounterList();
                });
            selectNextElementRemoved(id);
        } else { //array
            for(var i in id){
                db.layouts
                    .where(':id')
                    .equals(parseInt(id[i]))
                    .delete()
                    .then(() => {
                        setCounterList();
                    });
                selectNextElementRemoved(id);
            }
        }
        refreshConfigTabList(toView);
    }

   function processList(method) {
        var listDB = [], removedLayout = [];
        db.layouts
            .where({id_layout:__ID_LAYOUT, id_campaign:__ID_CAMPAIGN})
            .each((layout) => {
                //verifica se o tema existe no select (ou ele pode ter sido excluido)
                if($("#tema").length && !$("#tema option[uid='"+layout.id_theme+"']").length){
                    removedLayout.push(layout.id);
                } else {
                    let json = JSON.parse(layout.attribute);
                    json._id_theme = layout.id_theme;
                    json['selecao-arquivo'] = URL.createObjectURL(layout.image_product);//convert blob to url
                    listDB.push(json);
                }
        }).then(() => {
            if(removedLayout.length){
                removeItemListByID(removedLayout, false);
                alert("Devido a exclusão de algum tema pelo administrador, alguns itens foram removidos automaticamente da lista.");
            }
            startProgressBar();
            recursiveCapture({
                list: listDB,
                count: 0,
                total: listDB.length,
                themes: [],
                method: method == "print" ? Array() : new JSZip()
            });
        }).catch(function (error) {
            console.error(error);
        });
    }

    function recursiveCapture(o){
        var img = $("#img-product")[0],
            imgCapture = $("#img-capture")[0],
            layout;

        if(o.list.length > 0) {
            layout = o.list.shift()
        } else { //fim da chamada recursiva
            //isso eh necessario para parar onload
            // se a imagem nao existir mais e nao entrar num loop infinito
            img.onload = null; 
            imgCapture.onload = null;
            closeProgressBar();

            if(Array.isArray(o.method)){

                print(o.method)

                if(o.themes.length)
                    saveStatistic("printList", JSON.stringify(o.themes));
            } else {
                $('body').loadingModal("destroy");
                $('body').loadingModal({
                    text: 'Processando arquivo ZIP...',
                    animation: 'threeBounce',
                    backgroundColor: 'black'
                });
                $('body').loadingModal('show');

                o.method.generateAsync({type:"blob"})
                .then(function(content) {
                    saveAs(content, "peimage.zip");
                    $('body').loadingModal('hide');
                });

                if(o.themes.length)
                    saveStatistic("downloadList", JSON.stringify(o.themes));
            }
            
            viewLayoutByID(parseInt($(".list-selected-img").attr("uid")));
            return;
        }

        imgCapture.src = __DIR_LAYOUT + layout.tema;
        imgCapture.onload = () => {
            $("#img-product").attr("src", "");
            setConfCapture(layout);
            img.onload = () => {
                domtoimage.toBlob($("#capture")[0], {
                    style:{
                        position: 'absolute',
                        top: '0',
                        left: '0',
                        width: '100%',
                        height: '100%',
                        transform: 'scale(1, 1)',
                        background:'gray'
                    }
                }).then( (dataUrl) => {

                    Array.isArray(o.method) 
                        ? o.method.push(URL.createObjectURL(dataUrl))
                        : o.method.file("imagem"+(o.count+1)+".png", dataUrl, {binary: true})
                    
                    if(layout._id_theme)
                        o.themes.push(layout._id_theme);

                    setProgressBar(o.total, ++o.count);
                    recursiveCapture(o);
                });
            };
        }
    }

    // Post a BASE64 Encoded PNG Image to facebook
    function postFacebook(blob) {
        var fd = new FormData();
        fd.append("access_token", __AUTH_TOKEN_FB);
        fd.append("source", blob);
        fd.append("message", $("#f-post-fb").val());
        try {
            $.ajax({
                url: "https://graph.facebook.com/me/photos?access_token=" + __AUTH_TOKEN_FB,
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                cache: false,
                success: function() {
                    saveStatistic("f");
                    $('body').loadingModal('text', 'Imagem postada com sucesso!');
                    setTimeout(function(){
                        $('body').loadingModal('hide');
                    }, 1000);
                },
                error: function(shr) {
                    var error = shr.responseJSON.error;
                    var msgError = {
                        80001: 'Houve muitas chamadas para a conta desta página. Espere um pouco e tente novamente. Para mais informações, consulte https://developers.facebook.com/docs/graph-api/overview/rate-limiting.',
                        100: 'Ops, houve um erro. Verifique se suas configurações de rede sociais são válidas.',
                        200: 'Erro de permissão: Suas permissões de acesso são insuficientes.',
                        2010: 'As chamadas de fotos foram temporariamente desativadas para este aplicativo',
                        190: 'Sua sessão no Facebook pode ter expirado. Tente reconfigurar novamente sua conta do Peimage associada ao Facebook',
                        368: 'A ação tentada foi considerada abusiva ou não é permitida',
                    };
                    if(error){
                        $('body').loadingModal('hide');
                        if(msgError[ error.code ]){
                            alert(msgError[ error.code ]);
                        } else {
                            alert("Ops, ocorreu um erro. Caso você continue com problemas ao tentar novamente entre em contato com nosso suporte");
                        }
                    }
                }
            });

        } catch (e) {
            console.log(e);
        }
    }

    /*
        Source: http://jsfiddle.net/ruisoftware/ddZfV/7/
        Updated by: Mohammad M. AlBanna
        Website: MBanna.info 
        Facebook: FB.com/MBanna.info
    */
    function previewFile(){
        var img    = document.getElementById('img-product');
        var file   = document.querySelector('input[type=file]').files[0];
        var reader = new FileReader();

        if(file && file.size > 1000000){
            $('body').loadingModal("destroy");
            $('body').loadingModal({
                text: 'Carregando imagem...',
                animation: 'threeBounce',
                backgroundColor: 'black'
            });
            $('body').loadingModal('show');
        }
        reader.onloadend = function(){
            var myImage = new Image();
            myImage.crossOrigin = "Anonymous";

            myImage.onload = function(){
                img.src = removeImageBlanks(myImage); //Will return cropped image data
                img.onload = function(){
                    __FLAG.urlBlobImageProduct = img.src = resizeImage(img, file.type);
                    __FUNC_MANAGE_LAYOUT();
                    //essencial para o evento nao entrar em loop se a imagem nao estiver carregada
                    img.onload = null;
                }
                $('body').loadingModal('hide');
            }
            myImage.src = reader.result;
        }

        if(file){
            reader.readAsDataURL(file);
            setInputFile(file.name);
        } else {
            //imagem 1x1px transparente (utilizada para nao dar erro na lib de captura do js)
            //que nao funciona com uma imagem invalida
            img.src = __INIT_IMG_TRANSPARENT_CAPTURE;
            __FLAG.urlBlobImageProduct = __INIT_IMG_TRANSPARENT_CAPTURE;
            setInputFile();
            __FUNC_MANAGE_LAYOUT();
        }
    }

    function resizeImage(img, typeFile){
        var canvas = document.createElement("canvas");
        var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0);

        var width = img.naturalWidth;
        var height = img.naturalHeight;

        if (width > height && width > __MAX_WIDTH_IMG_PRODUCT) {
            height *= __MAX_WIDTH_IMG_PRODUCT / width;
            width = __MAX_WIDTH_IMG_PRODUCT;
        } else if (height > __MAX_HEIGHT_IMG_PRODUCT) {
            width *= __MAX_HEIGHT_IMG_PRODUCT / height;
            height = __MAX_HEIGHT_IMG_PRODUCT;
        }
        canvas.width = width - 2;
        canvas.height = height - 2;
        var ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0, width, height);

        return canvas.toDataURL(typeFile);
    }

    function setInputFile(filename){
        if(filename){
            $("#file-name").text(filename);
            $("#file-name").css("color", "#676767");
            $("#ctrl-img img").hide();
            $("#ctrl-img span").show();
        } else {
            $("#file-name").text("Carregar imagem");
            $("#file-name").css("color", "#bfccdc");
            $("#ctrl-img img").show();
            $("#ctrl-img span").hide();
        }
    }

    function removeImageBlanks(imageObject) {
        imgWidth = imageObject.width;
        imgHeight = imageObject.height;
        var canvas = document.createElement('canvas');
        canvas.setAttribute("width", imgWidth);
        canvas.setAttribute("height", imgHeight);
        var context = canvas.getContext('2d');
        context.drawImage(imageObject, 0, 0);

        var imageData = context.getImageData(0, 0, imgWidth, imgHeight),
        data = imageData.data,
        getRBG = function(x, y) {
            var offset = imgWidth * y + x;
            return {
                red:     data[offset * 4],
                green:   data[offset * 4 + 1],
                blue:    data[offset * 4 + 2],
                opacity: data[offset * 4 + 3]
            };
        },
        isWhite = function (rgb) {
            // many images contain noise, as the white is not a pure #fff white
            //return rgb.red > 200 && rgb.green > 200 && rgb.blue > 200;
            return rgb.red > 245 && rgb.green > 245 && rgb.blue > 245;
        },
        scanY = function (fromTop) {
            var offset = fromTop ? 1 : -1;

            // loop through each row
            for(var y = fromTop ? 0 : imgHeight - 1; fromTop ? (y < imgHeight) : (y > -1); y += offset) {

                // loop through each column
                for(var x = 0; x < imgWidth; x++) {
                    var rgb = getRBG(x, y);
                    if (!isWhite(rgb)) {
                        if (fromTop) {
                            return y;
                        } else {
                            return Math.min(y + 1, imgHeight);
                        }
                    }
                }
            }
            return null; // all image is white
        },
        scanX = function (fromLeft) {
            var offset = fromLeft? 1 : -1;

            // loop through each column
            for(var x = fromLeft ? 0 : imgWidth - 1; fromLeft ? (x < imgWidth) : (x > -1); x += offset) {

                // loop through each row
                for(var y = 0; y < imgHeight; y++) {
                    var rgb = getRBG(x, y);
                    if (!isWhite(rgb)) {
                        if (fromLeft) {
                            return x;
                        } else {
                            return Math.min(x + 1, imgWidth);
                        }
                    }      
                }
            }
            return null; // all image is white
        };

        var cropTop = scanY(true),
            cropBottom = scanY(false),
            cropLeft = scanX(true),
            cropRight = scanX(false),
            cropWidth = cropRight - cropLeft,
            cropHeight = cropBottom - cropTop;

        canvas.setAttribute("width", cropWidth+2);
        canvas.setAttribute("height", cropHeight+2);
        // finally crop the guy
        canvas.getContext("2d").drawImage(imageObject,
            cropLeft, cropTop, cropWidth, cropHeight,//cropLeft-1, cropTop, cropWidth+2, cropHeight,
            0, 0, cropWidth+2, cropHeight);

        return canvas.toDataURL();
    }