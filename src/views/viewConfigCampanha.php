<?php
    $logo = '../images/logoPeimage.png';
    $imageMenu = '../images/menu.png';
    $dirCompanie = '../companies/'.$companie.'/';
    list($largura, $altura) = getimagesize($dirCompanie.'logo.png');
    include('../config.php');
?>

<!DOCTYPE html>
<html lang="pt-br" >
    <head>
        <meta charset="UTF-8">
        <meta name="format-detection" content="telephone=no">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="viewport" content="initial-scale=1, width=device-width, viewport-fit=cover">
        
        <title>Peimage - Campanhas</title>
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/style.css">
        <link rel="stylesheet" href="<?=$__HTTP_HOST;?>/css/menu.css">
        <link rel="icon" href="<?=$__HTTP_HOST;?>/images/favicon.png" />
        <script type="text/javascript" src="<?=$__HTTP_HOST;?>/js/jquery-3.3.1.min.js"></script>

<script>
    $(function(){   

        var __HTTP_HOST = "<?=$__HTTP_HOST?>";

        function loadSelecteOptions(){
            $.ajax({
                type: "get",
                url: __HTTP_HOST + "/src/actionConfigCampanha.php",
                data:{
                    act: "selecaoLayout",
                    idcampanha: $('#idcampanha').val(),
                    idlayout: $("#layout option:selected").val()
                },
                timeout:6000,
                dataType:'json'
            })
            .done(function(json){
                for(var i in json){
                    $('#cor1').val(json[i].cor1);
                    $('#cor2').val(json[i].cor2);
                    $('#cor3').val(json[i].cor3);
                    $('#fklayouts_campanha').val(json[i].fklayouts_campanha);
                }   
            })
            .fail(function(){
                alert("Ops, algo deu errado, tente novamente mais tarde.");
            });
        }

        loadSelecteOptions();
    
        $("#layout").change(function(){
            if($("#layout option:selected").val() != ""){
                loadSelecteOptions();
            } else {
                $('#cor1,#cor2,#cor3').val("");
            }
        });

        $("#waterform").submit(function(e){
            e.preventDefault();

            if($("#layout option:selected").val() != ""){

                $.ajax({
                    type: "get",
                    url: __HTTP_HOST + "/src/actionConfigCampanha.php",
                    data:{
                        act:"coresUpdate",
                        fklayouts_campanha: $('#fklayouts_campanha').val(),
                        cor1: $("#cor1").val(),
                        cor2: $("#cor2").val(),
                        cor3: $("#cor3").val()
                    },
                    timeout:6000,
                    dataType:'text'
                })
                .done(function(response){
                    if(response == "1"){
                        alert("Dados atualizados com sucesso.");
                    } else {
                        alert("Houve um erro ao atualizar os dados.");
                    }
                })
                .fail(function(){
                    alert("Ops, algo deu errado, tente novamente mais tarde.");
                });

            } else {
                $('#cor1,#cor2,#cor3').val("");
            }
        });

    });

</script>

    </head>
    <body>
        <?php menu($logo, $imageMenu); ?>
        <header>
        <div id="logoCompany">
            <img src="<?=$dirCompanie;?>logo.png" style="max-width:<?=$largura;?>px" />
        </div>
        </header>
        <div id="content">
            <div class="fish" id="fish"></div>
      
            <form id="waterform" method="post" action="actionConfigCampanha.php" enctype="multipart/form-data" >

            <?php
                if(mysqli_num_rows($queryLayouts) == 0){
                    echo "
                        <div style='text-align:center; margin-top:30px;'>
                            <label>Nenhum layout cadastrado para esta campanha.</label> <br/>
                            <a href='actionCrudCampanha.php'>Adicionar novo layout</a>
                        </div>
                    ";
                } else {
            ?>

            <label>Campanha</label>
            <input type="readonly" value="<?php echo ucwords($row['nome']) ?>" placeholder="Digite o nome da campanha" maxlength="50"/>
            <input type="hidden" id="idcampanha" value="<?php echo $_POST['idcampanha'] ?>" />
            <input type="hidden" id="fklayouts_campanha" value="" />

                <label for="Estilo">Seleção de layouts</label><br/>
                <select id="layout" name="idlayout" required="required">
                    <?php
                        while($rowlayouts=mysqli_fetch_array($queryLayouts)){                     
                            echo '<option value="'.$rowlayouts['idlayouts'].'">'.ucwords($rowlayouts['nome']).'</option>';
                        }
                    ?>
                </select><br/>
                <label>Cor Título/Descrição</label>
                <input type="text" id="cor1" name="cor1" placeholder="ex: #FFFFFF" maxlength="7"/><br/>
                <label>Cor Preço</label>
                <input type="text" id="cor2" name="cor2" placeholder="ex: #FFFFFF" maxlength="7"/><br/>
                <label>Cor Promoção</label>
                <input type="text" id="cor3" name="cor3" placeholder="ex: #FFFFFF" maxlength="7"/><br/>
                <input type="submit" value="Atualizar" >

            <?php
                }
            ?>

            </form>
        </div>
    </body>
</html>