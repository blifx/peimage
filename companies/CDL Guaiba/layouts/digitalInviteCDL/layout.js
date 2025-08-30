/**
 * define as configuracoes do tema do layout
 */
function setConfLayout(confLayout){

    $("#type-invite").css("background", confLayout['type-invite-bgcolor']);
    $("#type-invite").css("color", confLayout['type-invite-color']);

    $("#title-event").css("color", confLayout['title-event-color']);
    $("#title-event-line1").css("color", confLayout['title-event-line1-color']);
    $("#title-event-line2").css("color", confLayout['title-event-line2-color']);

    $("#date-day-week").css("color", confLayout['date-day-week-color']);
    $("#date-calendar, #date-hour").css("color", confLayout['date-calendar-color']);
    $("#container-address").css("color", confLayout['container-address-color']);
    $("#container-description-evt").css("color", confLayout['container-description-evt-color']);
    $("#container-date").css("color", confLayout['container-date-color']);
    

    $("#icon-tel a").attr("href", "tel:" + confLayout['icon-tel-href']);
    $("#icon-email a").attr("href", "mailto:" + confLayout['icon-email-href']);
    $("#icon-local a").attr("href", confLayout['icon-local-href']);
    $("#icon-face a").attr("href", confLayout['icon-face-href']);
    $("#icon-whatsapp a").attr("href", "https://api.whatsapp.com/send?phone=" + confLayout['icon-whatsapp-href']);

    $(".touch-img").css("fill", confLayout['touch-img-color']);

    $("#join").css("color", confLayout['join-color']);
    $(".icons svg").css("fill", confLayout['icons-color']);

}

/**
 * define os valores dos campos do layout
 */
async function setConfCapture(data){

    if(!data || !Object.keys(data).length) return;
    
    if(data["mode"]){
        if(data["mode"] == "print"){
            $("#container-icons, img#touch-img").hide();
            $("#join").show();
            $("#container-description-evt").css("top", "1750px");
        } else {
            $("#container-icons, img#touch-img, #join").show();
            $("#join").hide();
            $("#container-description-evt").css("top","1695px");
        }
    } else {
        $("#container-icons, img#touch-img, #join").hide();
    }

    //titulo do convite
    $("#type-invite").html(data["title-invite"].toUpperCase());
    if(data["title-invite"]){
        $("#type-invite").show();
    } else {
        $("#type-invite").hide();
    }

    //titulo do tema
    $("#title-event-line1").html(data["title-theme"].toUpperCase());
    if(data["title-event-line1"] != ""){
        $("#title-event-line1").show();
    } else {
        $("#title-event-line1").hide();
    }

    //subtitulo
    $("#title-event-line2").html(data["subtitle-theme"].toUpperCase());
    if(data["title-event-line2"] != ""){
        $("#title-event-line2").show();
    } else {
        $("#title-event-line2").hide();
    }

    if(data["title-theme"] || data["subtitle-theme"]){
        $("#title-event").show();
    } else {
        $("#title-event").hide();
    }

    if(data["date"] != ""){
        //data do evento
        let dateEvt = new Date(data["date"] + " 00:00");
        var options = { year: 'numeric', month: '2-digit', day: '2-digit' };
        $("#date-calendar").html(dateEvt.toLocaleDateString('pt-BR', options));

        //dia da semana do evento
        let dayWeek = [
            "domingo", "segunda-feira", "terça-feira", 
            "quarta-feira", "quinta-feira", "sexta-feira", "sábado",
        ];
        $("#date-day-week").html( dayWeek[dateEvt.getDay()].toUpperCase() );
    } else {
        $("#date-calendar, #date-day-week").html("");
    }

    //hora de inicio e fim
    let time = "";
    if(data['time-start']){
        time = "INÍCIO "+ data['time-start'] + "H";
    }
    if(data['time-end']){
        if(data['time-start'])
            time = data['time-start'] + "H ÀS ";
        time += data['time-end'] +"H";
    }
    $("#date-hour").html(time);

    //endereco do local
    $("#address-local").html(data["local"].toUpperCase());
    
    //rua e numero do endereco
    let numberAddress = "";
    if(data["number-address"]){
        if(data["street"])
            numberAddress += ", ";
        numberAddress += data["number-address"];
        if(data["address-complement"])
            numberAddress += ", " + data["address-complement"];
    }
    $("#address-street").html( (data["street"] + numberAddress).toUpperCase() );


    //bairro
    if(data["neighborhood"]){
        $("#address-neighborhood").html(data["neighborhood"].toUpperCase());
    } else {
        $("#address-neighborhood").html("");
    }

    //cidade e estado
    let address = data["city"];
 
    if(data["state"]){
        if(data["city"])
            address += " - " + data["state"];
        else 
            address += data["state"];
    }

    $("#address-city").html(address.toUpperCase());

    //icone de localizacao
    $("#icon-local").attr("href", data["link-address"]);

    //descricao do convite
    $("#description-evt").html(data["description-invite"]);

    //alinhamento da descricao
    $("#description-evt").css("text-align", data["align"]);

}

var __MODELS_LAYOUT = [{ 
    mode: "digital",
    'title-invite': "Convite",
    'title-theme': "Transformações da nossa realidade",
    'subtitle-theme': "Ampliando seus horizontes inovando seus conceitos",
    date: "2021-10-10",
    'time-start': "10:30",
    'time-end': "12:00",
    local: "CDL",
    street: "Rua Sergipe",
    'number-address': "55",
    'address-complement': "esquina",
    neighborhood: "parque 35",
    city: "guaíba",
    state: 'RS',
    'description-invite': "O mundo mudou. A forma com que as pessoas se relacionam mudou. E a gente precisa se adaptar, principalmente quando se trata de nossos negócios. Nós queremos montar um grupo forte de mulheres participativas que seja unido, que se fortaleça e vire referência no varejo. Aquele velho ditado de que “sozinhos vamos mais rápido. Juntos vamos mais longe”  serve para bem definir nosso objetivo. Queremos reunir as melhores empresárias para pautas relevantes e que vão elevar a prática do empreendedorismo ao que tem de melhor nos dias de hoje. Esta vai ser a primeira reunião, e uma das mais importantes! Por isso, contamos com sua presença VIP.",
    align: "justify"
}];

var __VALIDATION_FORM_CAPTURE = {
    rules:{
        'title-theme':{
            required:true
        },
        'subtitle-theme':{
            required:true
        },
        'date':{
            required:true
        },
        'time-start':{
            required:true
        },
        'local':{
            required:true
        },
        'street':{
            required:true
        },
        'number-address':{
            required:true
        },
        'neighborhood':{
            required:true
        },
        'city':{
            required:true
        },
        'state':{
            required:true
        },
        'link-address':{
            required:true,
            url:true
        },
        'description-invite':{
            required:true
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

/*
// Simple example, see optional options for more configuration.
const pickr = Pickr.create({
    el: '#p-type-invite-color',
    theme: 'monolith', // classic or 'monolith', or 'nano'
    components: {
        // Main components
        preview: true,
        opacity: true,
        hue: true,
        // Input / output Options
        interaction: {
            input: true,
            save: true
        },
    },
    strings: {
        save: 'Salvar'
     }
}).on('save', (color, instance) => {
    instance.hide();
    $("#type-invite-color").val( color.toHEXA().toString() );

    var e = $.Event('keypress');
    e.which = 65; // Character 'A'
    $("#type-invite-color").trigger(e);
});
*/