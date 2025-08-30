var __HTTP_HOST = window.location.protocol + "//" + window.location.hostname + "/"; 

$(function() {

    $.ajaxSetup({ cache: true });
    $.getScript('https://connect.facebook.net/pt_BR/sdk.js', function(){

        FB.init({
            appId   : '376199693057711',
            cookie  : true,
            xfbml   : true,
            version : 'v4.0'
        });


        var errorAlbum = {
            321:	'O álbum selecionado para sua postagem atingiu seu limite máximo de imagens e está cheio. Selecione outro álbum em suas configurações.',
            200:	'Erro de permissão: Suas permissões de acesso são insuficientes.',
            2010:	'As chamadas de fotos foram temporariamente desativadas para o Peimage.',
            100:	'Ops, houve um erro. Verifique se suas configurações de rede sociais são válidas.',
            120:	'ID do álbum inválido, isso pode ter sido ocasionado devido a exclusão do álbum. Configure novamente sua conta do Facebook no Peimage.',
            368:	'A ação tentada foi considerada abusiva ou não é permitida.',
            220:	'O álbum que você está tentando utilizar não é válido para postagens ou foi excluído.',
            80001:  'Houve muitas chamadas para esta conta da página. Espere um pouco e tente mais tarde novamente. Para mais informações, consulte https://developers.facebook.com/docs/graph-api/overview/rate-limiting.',
        };

        function redirectConf(){
            window.location = __HTTP_HOST + "src/actionRedeSocial.php?redirect="+window.location.href;
        }

        $("#post-photo-fb-button").click(function(){

            if(__DATA_FB.token == ''){
                if(confirm("Deseja configurar sua conta do Facebook agora?\nVocê será encaminhado para a página de configuração.")){
                    redirectConf();
                }
                return;
            }

            $('body').loadingModal({
                text: 'Enviando postagem para o Facebook...',
                animation: 'threeBounce',
                backgroundColor: 'black'
            });

            var options = {
                caption: $("#message-fb").val(),
                url: __HTTP_HOST + encodeURI($("#img-print").attr("src").substr(2)),
                access_token : __DATA_FB.token
            };
            
            FB.api(
                "/me/photos", 
                "post", 
                options, 
                function(response){
                    if(response && response.id && response.post_id){

                        var usuario = getParamURL('usuario');
                        var tema = getParamURL('tema');
                        var layout = getParamURL('idlayout');
                        $.get( "actionDownloads.php", { acao: "f", usuario: usuario, tema: tema, layout: layout} );

                        $('body').loadingModal('text', 'Imagem postada com sucesso!');
                        setTimeout(function(){
                            $('body').loadingModal('hide');
                        }, 1000);
                        $("#desc-post").html("<span style='font-size:20px; color:green'>&#10004;</span>Imagem postada com sucesso.");
                        $("#desc-post").css({
                            'display': 'block',
                            'border': 'solid 3px #98d4f3',
                            'border-radius': '10px',
                            'margin-bottom': '10px',
                            'text-align': 'center',
                        });
                        $("#post-photo-fb-button, #message-fb").hide();



                    } else {
                        $('body').loadingModal('hide');
                        if(response.error && response.error.code){

                            if(response.error.code == 190){//token invalid
                                saveInvalidToken();
                            } else if(errorAlbum[response.error.code] != undefined){
                                alert(errorAlbum[response.error.code]);
                            } else {
                                alert("Ocorreu algum erro, tente novamente mais tarde.\nPor favor, se o erro persistir tente reconfigurar sua conta do Peimage associada ao Facebook.");
                            }

                        }
                    }
                }
            );

/*            
            var options = {
                caption: $("#message-fb").val(),
                url: __HTTP_HOST + encodeURI($("#img-print").attr("src").substr(2)),
                access_token : __DATA_FB.token
            };
            
            FB.api(
                "/me/photos", 
                "post", 
                options, 
                function(response){

                    if(response && response.id && response.post_id){

                        saveStatistic();

                        $('body').loadingModal('text', 'Imagem postada com sucesso!');
                        setTimeout(function(){
                            $('body').loadingModal('hide');
                        }, 1000);
                        $("#desc-post").html("<span style='font-size:20px; color:green'>&#10004;</span>Imagem postada com sucesso.");
                        $("#desc-post").css({
                            'display': 'block',
                            'border': 'solid 3px #98d4f3',
                            'border-radius': '10px',
                            'margin-bottom': '10px',
                            'text-align': 'center',
                        });
                        $("#post-photo-fb-button, #message-fb").hide();

                    } else {
                        $('body').loadingModal('hide');
                        if(response.error && response.error.code){

                            if(response.error.code == 190){//token invalid
                                saveInvalidToken();
                            } else if(errorAlbum[response.error.code] != undefined){
                                alert(errorAlbum[response.error.code]);
                            } else {
                                alert("Ocorreu algum erro, tente novamente mais tarde.\nPor favor, se o erro persistir tente reconfigurar sua conta do Peimage associada ao Facebook.");
                            }

                        }
                    }
                }
            );
*/
        });

        function getParamURL(pName){
            var url = new URL(window.location.href);
            return url.searchParams.get(pName);
        }

        function saveStatistic(){
            $.ajax({
                type: "post",
                url: __HTTP_HOST + "src/actionRedeSocial.php",
                data: {
                    act: "saveStatistic",
                    fk_tema: getParamURL("tema")
                },
            });
        }

        function saveInvalidToken(){
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
                if(json.result){
                    if(confirm('Ops, sua sessão do Facebook expirou! Você precisa reconfigurar sua conta novamente para continuar. Deseja reconfigurar sua conta agora?')){
                        redirectConf();
                    }
                } else {
                    alert("Sua sessão do Facebook expirou, por favor reconfigure novamente sua conta!");
                }
            })
            .fail(function(){
                alert("Sua sessão do Facebook expirou, por favor reconfigure novamente sua conta!");
            });
        }

        if(__DATA_FB.token != ''){
            $("#desc-post, #message-fb").show();
        }

    });

});