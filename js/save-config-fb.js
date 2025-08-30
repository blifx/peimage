//TODO botao invalidar token de acesso DELETE me/permissions
//TODO criar album de acordo com campanha
    
    var __HTTP_HOST = window.location.protocol + "//" + window.location.hostname+"/"; 

    $(function() {

		$.ajaxSetup({ cache: true });
		$.getScript('https://connect.facebook.net/pt_BR/sdk.js', function(){

			var errorAccount = {
				200: 'Sua conta não possui permissões suficientes para usar o app do Peimage no Facebook.',
				100: 'Ops, ocorreu algum erro. Tente novamente!', //'Parâmetro inválido',
				190: 'Token de acesso inválido. Por favor, configure sua conta do Facebook novamente...',
				80001:	'Houve muitas chamadas para esta conta. Espere um pouco e tente novamente mais tarde. Para mais informações, consulte https://developers.facebook.com/docs/graph-api/overview/rate-limiting.'
            };
            
            //flag indica se nao existe nenhum album, ou os albuns existentes sao invalidos 
            //por ex. album de Foto de perfil
            var saveInit = false, flagInvalidAlbum = false, flagFocus = true;

			FB.init({
				appId   : '376199693057711',
				cookie  : true,
				xfbml   : true,
				version : 'v4.0'
            });
            
            function setModeLogin(){
                $("#fb-login-button").show();
                $("#fb-logout-button, #config-fb").hide();
                $('body').loadingModal('hide');
                saveInit = true;
            }

			function loadPages(){

                FB.api('/me/accounts', function(response) {

                    if (! response || response.error ) {
                        setModeLogin();
                        alert(errorAccount[response.error.code]);
                        return;
                    } else if(response.data && response.data.length == 0){
                        setModeLogin();
                        alert("Verifique se você configurou corretamente suas permissões de acesso.");
                        return;
                    }

                    var data = response.data;
                    for(var i in data){
                        var idPage = data[i].id;
                        if(__DATA_FB.pages[idPage] == undefined)
                            __DATA_FB.pages[idPage] = {};

                        __DATA_FB.pages[idPage].name = data[i].name;
                        __DATA_FB.pages[idPage].token = data[i].access_token;
                        __DATA_FB.pages[idPage].permission = data[i].tasks;

                        //https://developers.facebook.com/docs/pages/access-tokens/
                        if(data[i].tasks.indexOf("CREATE_CONTENT") == -1){
                            setModeLogin();
                            alert("Você precisa ser administrador ou editor da página " + data[i].name + " para poder continuar.");
                            return;
                        } else {
                            $("#fb-logout-button, #config-fb").show();
                        }

                    }
                    var pages = __DATA_FB.pages;
                    if(pages != undefined && Object.keys(pages).length > 0){

                        $("#pages-manage-fb option[value!='']").remove();
                        for(var id in pages){
                            $("#pages-manage-fb").append(
                                $("<option token="+pages[id].token+" page-id='"+id+"'>"+pages[id].name+"</option>")
                            );
                        }

                        //carrega as configuracoes atuais se forem validas
                        if(__DATA_FB.id_page != '' && $("#pages-manage-fb option[page-id='"+__DATA_FB.id_page+"']").length){
                            $("#pages-manage-fb option[page-id='"+__DATA_FB.id_page+"']").attr('selected', 'selected').change();
                        } else {
                            $('#pages-manage-fb').val($('#pages-manage-fb option').eq(1).val()).change();
                        }
                    }
                    $('body').loadingModal('hide');
                });
            }
/*
            function loadAlbunsByPage(idPage){
                FB.api('/'+idPage+'/albums?fields=can_upload,name', function(response) {

                    if (! response || response.error ) {
                        alert("Ocorreu algum erro ao carregar seus dados do Facebook, por favor, tente novamente mais tarde.");
                        return;
                    }

                    var data = response.data;
                    __DATA_FB.pages[idPage].albuns = {};
                    
                    $("#albuns-page-fb option[value!='']").remove();
                    for(var i in data){
                        if(data[i].can_upload){
                            __DATA_FB.pages[idPage].albuns.id_album = data[i].id;
                            __DATA_FB.pages[idPage].albuns.name_album = data[i].name;
                            $("#albuns-page-fb").append(
                                $("<option value='"+data[i].id+"'>"+data[i].name+"</option>")
                            );
                        }
                    }

                    if(Object.keys(__DATA_FB.pages[idPage].albuns).length == 0){
                        flagInvalidAlbum = true;
                        flagFocus = false;
                        $("#save-config").hide();
                        $('body').loadingModal('hide');
                        $("#msg-error").html("<span style='color:red; font-size:20px'>&#x2716;</span>"+
                            "Página selecionada não possui nenhum álbum disponível ou válido. Crie um novo álbum no Facebook antes de continuar.").show();
                        return;
                    } else {
                        $("#msg-error").html("<span style='font-size:20px; color:green'>&#10004;</span>"+
                            "Álbum encontrado.").fadeOut(2000);
                        $("#save-config").show();
                    }

                    //carrega as configuracoes atuais se forem validas
                    if(__DATA_FB.id_album != '' && $("#albuns-page-fb option[value='"+__DATA_FB.id_album+"']").length){
                        $("#albuns-page-fb option[value='"+__DATA_FB.id_album+"']").attr('selected', 'selected');
                    } else { 
                        $("#albuns-page-fb option:contains(Fotos da linha do tempo)").attr('selected', 'selected');
                    }

                    $('body').loadingModal('hide');
                    if(saveInit){
                        saveInit = false;
                        saveConfig(null, false);
                    }

                });
            }

            $(window).focus(function(){
                if(flagInvalidAlbum && flagFocus){
                    loadAlbunsByPage($("#pages-manage-fb option:selected").attr("page-id"));
                    flagFocus = false;
                }
            });

            $(window).blur(function(){
                flagFocus = true;
            });
*/
			function updateStatusAccount(response){
                //connected
                //A pessoa está logada no Facebook e se conectou à sua página da web.
                //se jah conectado nao realiza a chamada novamente
				if (response.status === 'connected') {

                    __DATA_FB.userId = response.authResponse.userID;

                    //usuario logado eh diferente da config do Peimage
                    //entao usuario esta usando uma conta diferente da configurada
                    //pro usuario
                    if(__DATA_FB.session_user != '' 
                        && __DATA_FB.session_user != __DATA_FB.userId){
                            __DATA_FB.session_user = __DATA_FB.userId;
                        setModeLogin();
                        return;
                    }
					
                    //verifica se o usuario marcou corretamente as permissoes de acesso
                    FB.api('/me/permissions', function(response){
                        var count = 0;
                        for (i = 0; i < response.data.length; i++){ 
                            if ( (response.data[i].permission == 'manage_pages' 
                                || response.data[i].permission == 'publish_pages')
                                && response.data[i].status == 'declined') {
                                count++;
                            }
                        }
                        if(count > 0){
                            setModeLogin();
                            alert("Verifique se todas páginas configuradas possuem as permissões corretas para utilizar o app do Peimage:\n-Gerenciar suas Páginas\n-Publicar como as Páginas que você gerencia.");
                            return;
                        }
                        $("#fb-login-button").hide();
                        loadPages();
                    });

                //not_authorized
                //A pessoa está logada no Facebook, mas não entrou na sua página.
				} else if (response.status === 'not_authorized') {
                    setModeLogin();

				} else if(response.status === 'unknown'){
                    //unknown
                    //A pessoa não está logada no Facebook, então você não sabe se 
                    //eles fizeram login na sua página da web. Ou FB.logout () 
                    //foi chamado antes e, portanto, não pode se conectar ao Facebook.
                    setModeLogin();
                }
                __DATA_FB.stateFB = response.status;
			}

            FB.getLoginStatus(function(response){
                if(__DATA_FB.id_album == ''){
                    setModeLogin();
                    return;
                }
                $('body').loadingModal("destroy");
                $('body').loadingModal({
                    text: 'Carregando dados do Facebook...',
                    animation: 'threeBounce',
                    backgroundColor: 'black'
                });
                updateStatusAccount(response);
            });

			FB.Event.subscribe('auth.logout', function(response){
                updateStatusAccount(response);
            });

            $("#fb-login-button").click(function(){
				FB.login(function(response){
					updateStatusAccount(response);
				}, {scope: 'manage_pages, publish_pages'});
            });

			$("#fb-logout-button").click(function(){
                $('body').loadingModal("destroy");
                $('body').loadingModal({
                    text: 'Enviando solicitação...',
                    animation: 'threeBounce',
                    backgroundColor: 'black'
                });
                $('body').loadingModal('show');
                
                var fnError = function(){
                    alert("Ocorreu um erro. Por favor, tente novamente mais tarde!");
                    $('body').loadingModal('hide');
                }

                FB.api('/me/permissions', 'delete', function(response){
                    if(response.success){

                        $.ajax({
                            type: "post",
                            url: __HTTP_HOST + "src/actionRedeSocial.php",
                            data:{
                                act:"invalidToken"
                            },
                            timeout:5000,
                            dataType:'JSON'
                        })
                        .done(function(json){
                            if(json.result) {
                                $('body').loadingModal('text', 'Usuário desconectado com sucesso!');
                                setTimeout(function(){
                                    setModeLogin();
                                }, 2000);
                            }
                            else {
                                fnError();
                            }
                        })
                        .fail(function(){
                            fnError();
                        });
                        
                    } else {
                        fnError();
                    }
                });
            });
            
            $("#save-config").click(function(){
                let href = window.location.href;
                let indexOf = href.indexOf("redirect");
                if(indexOf != -1){
                    saveConfig( href.substring( indexOf + 9, href.length), true);
                } else {
                    saveConfig(null, true);
                }
            });

            function saveConfig(href, btn){
                var page = $("#pages-manage-fb option:selected"),
                    album = $("#albuns-page-fb option:selected");

                $.ajax({
                    type: "post",
                    url: __HTTP_HOST + "src/actionRedeSocial.php",
                    data: {
                        act: "changeToken",
                        userID: __DATA_FB.userId,
                        idPage: page.attr("page-id"),
                        namePage: page.text(),
                        token: page.attr("token"),
                        //idAlbum: album.val(),
                        //nameAlbum: album.text()
                    },
                    timeout:5000,
                    dataType:'JSON'
                })
                .done(function(json){
                    //se o clique for no botao exibe as mensagens
                    if(btn){
                        if(json.result && !href){
                            alert("Dados atualizados com sucesso!");
                        } else if(json.result && href) {
                            alert("Dados atualizados com sucesso! Você será redirecionado automaticamente para sua página anterior...");
                            window.location = href
                        } else {
                            alert("Ocorreu um erro. Por favor, tente novamente mais tarde!");
                        }
                    }
                })
                .fail(function(){
                    alert("Ocorreu um erro. Por favor, tente novamente mais tarde!");
                });
            }
/*
            $("#pages-manage-fb").change(function(){
                var selected = $("#pages-manage-fb option:selected");
                loadAlbunsByPage(selected.attr("page-id"));
            });
*/
		});

});
