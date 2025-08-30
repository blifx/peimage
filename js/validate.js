/**
* Função para validação de campos de um formulário.
* @author César Peteffi <peteffi@gmail.com>
* @version 0.5
*/
//TODO ignorar campos ou tipo de campos HIDDEN
(function($){
    
    var $fn = {
        
        //TODO : Add REGEX to function execute wrapper
        required : /\S/, //Valida se um campo está vazio
        alfNum : /[a-zA-Z]|[0-9]/, //Valida se o campo possui apenas letras válidas
        text : /^[a-zA-ZàáÁÇçéÉíÍóÓúÚãõâÂêÊîÎôÔûÛäëïöüÄËÏÖÜ0-9\(\) \-\(%)\,\.]+$/, //Valida se o campo possui valores alfanumericos, vírgulas (outros caracteres usados num campo de observacao)
        letter : /^[a-zA-ZàáÁÇçéÉíÍóÓúÚãõâÂêÊîÎôÔûÛäëïöüÄËÏÖÜ ]+$/, //Valida se o campo possui apenas letras válidas
        numeric : /^[+-]?((\d+|\d{1,3}(\.\d{3})+)(\,\d*)?|\,\d+)$/,//Valida números inteiros e float
        float : /^\d+(\,\d{1,2})?$/, //valida somente números decimais(float)
        money:  /[0-9]{0,10}[,]{1,1}[0-9]{0,2}$/, //valida somente números decimais(float)
        integer : /^\d+$/, //Verifica se o campo possui apenas números inteiros
        date : /^((0[1-9]|[12]\d)\/(0[1-9]|1[0-2])|30\/(0[13-9]|1[0-2])|31\/(0[13578]|1[02]))\/\d{4}$/, //Verfica se a data é válida e está no formato DD/MM/AAAA
        email : /^[\w-]+(\.[\w-]+)*@(([\w-]{2,63}\.)+[A-Za-z]{2,6}|\[\d{1,3}(\.\d{1,3}){3}\])$/, //Verifica se o e-mail digitado é válido
        phone : /\(\d{2}\)\d{8,9}$/, //Valida um telefone juntamente com o seu DDD. Ex: (51) 30553432 | (51)305534320
        cep : /[0-9]{5}\-[0-9]{3}$/, //Valida o cep no formato 92500-000
        twoWords : /^[^\s]+\s[^\s]+$/,//Campo deve conter duas palavras Ex: Cesar Peteffi
        fileName : /[a-zA-Z0-9_]$/,
        monthDay : /^([1-9]|[12][0-9]|3[01])$/,
        colorHex : /^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/, //validacao de cores em hexadecimal com # na frente
        url: /(https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|www\.[a-zA-Z0-9][a-zA-Z0-9-]+[a-zA-Z0-9]\.[^\s]{2,}|https?:\/\/(?:www\.|(?!www))[a-zA-Z0-9]+\.[^\s]{2,}|www\.[a-zA-Z0-9]+\.[^\s]{2,})$/,
        
        cnpj : function(cnpj) { //valida o CNPJ digitado
            if (! /\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/.test(cnpj) ) {  // valida o formato do cnpj
                return false;
            }
            var valida = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2], dig1 = 0, dig2 = 0;
            cnpj = cnpj.toString().replace(/\.|\-|\//g, "");
            var digito = new Number(cnpj.charAt(12)+cnpj.charAt(13));
            for (var i = 0; i < valida.length; i++) {
                dig1 += ( i > 0 ? (cnpj.charAt(i-1)*valida[i]) : 0 );
                dig2 += cnpj.charAt(i)*valida[i];
            }
            dig1 = (((dig1%11)<2) ? 0 : (11-(dig1%11)));
            dig2 = (((dig2%11)<2) ? 0 : (11-(dig2%11)));
            if ( ( (dig1*10)+dig2) != digito ) {
                return false;
            }
            return true;
        },

        cpf : function(value) { //valida o CPF digitado
            if (! /\d{3}\.\d{3}\.\d{3}\-\d{2}$/.test(value) ) return false; // valida se o cpf está no formato correto
            value = value.replace(/\.|\-/g, "");
            var str = '', t, d, c;
            for(var i = 0; i <= 9; i++){//valida valores repetidos de 0 a 9. Ex: 999999999
                for(var j = 0; j < 11; j++){
                    str += i+'';
                }
                if(str == value){
                    return false;
                }
                str = '';
            }
            // Retorna falso se o cpf for nulo
            for (t = 9; t < 11; t++) {
                for (d = 0, c = 0; c < t; c++) {
                    d += value[c] * ((t + 1) - c);
                }
                d = ((10 * d) % 11) % 10;
                if (value[c] != d) {
                    return false;
                }
            }
            return true;
        },

        maxLength : function(value, param) {
            return value.length <= param ;
        },

        minLength : function(value, param) {
            return value.length >= param;
        },

        //Verifica se a data inicial é maior que a final. Deve ser utiliza na data final
        compareDate : function(value, param, id, self) { 
            self._inverseModify(id, param);
            var d1 = value.split("/"),
                d2 = $(param).val().split("/");
            //duas datas precisam ser preenchidas
            if(d1.length + d2.length == 6){
                d1 = new Date(d1[2], d1[1]-1, d1[0]);
                d2 = new Date(d2[2], d2[1]-1, d2[0]);
                return d1 >= d2;
            }
            return true;
        },

        //compara o valor entre dois campos. Se o campo 1 eh maior que o campo 2
        greater : function(value, param, id, self) { 
            self._inverseModify(id, param);
            return parseInt($(param).val().replace(/[^0-9.]/g, "")) > parseInt(value.replace(/[^0-9.]/g, ""));
        },

        equal : function(value, param, id, self) {
            self._inverseModify(id, param);
            return value === $(param).val();
        },
        
        notEqual : function(value, param, id, self) {
            return !$fn.equal(value, param, id, self);
        },

        //TODO poderia utilizar o cache do ajax? ver documentacao JQUERY
        remote : function(value, param, id, self){//param = noCache - true para ignorar cache de valor anterior
            var aux = self.ajaxRemote[id], p = $.extend(true, {}, param);
            
            //TODO como melhoria poderia existir um array com todos valores jah validados
            //se cache estiver desabilitado para nao haver
            if(aux.oldVal === value && aux.request && !p.noCache){
                aux.request.abort();
                return aux.valid;
            }
            if(aux.request) aux.request.abort();

            if(typeof p.data == 'function') {
                p.data = p.data();
            //data sendo um array funciona somente para campos que possuem
            //o id definido e que suportem val() como retorno de seu valor
            } else if($.isArray(p.data)){
                var tmp = p.data;
                p.data = {};
                for(var i in tmp) {
                    p.data[ tmp[i] ] = $('#' + tmp[i]).val();
                }
            }
            if(typeof p.data == 'object'){
                //data pode ser uma funcao ou os (filhos) seus valores
                for(var i in p.data) {
                    if(p.data[i] == undefined)
                        delete p.data[i];
                    else if (typeof p.data[i] == 'function')
                        if(p.data[i]() == undefined) 
                            delete p.data[i];
                }
            }
            
            if(!p.data) p.data = {};
            p.data[id] = value;
            
            //para request funcionar adequadamente
            //verificar se tipo de retorno do server eh no formato JSON
            //ou conforme configuracao do dateType
            aux.request = $.ajax(
                $.extend(true, {
                    dataType: "json",
                    type:'POST',
                    success: function( response ) {
                        //funcao de callback pode ser utilizada para 
                        //algum processamento extra e deve retornar true ou false
                        var cbk = self.opts.rules[id].remote.callback;
                        if(typeof cbk == 'function')
                            response = cbk(response);
                        if(response === true || response === "true"){
                            self._getLabel(id).remove();
                            aux.valid = true;
                            aux.request = undefined;
                        } else {
                            self._addLabelError(id, 'remote');
                            aux.valid = false;
                        }
                        aux.oldVal = value;
                    }
            }, p));
            return true;
        }
    };
    
    Plugin.prototype = {
        
        _inverseModify : function(id, param){ //used for fields that have pending another value for validation
            var self = this;
            $(param).bind("blur", function(){
                self.isValid(id);
            });
        },
        
        _getLabel : function(id){
            return $("label[for='"+id+"'].error");
        },

        _getMsgError : function(id, elem, param){
            var char = " " + String.fromCharCode(parseInt('21b3;', 16));
            if(this.opts.messages != undefined && this.opts.messages[id] != undefined && (elem in this.opts.messages[id]) ) {
                return char + this.opts.messages[id][elem];
            }
            if(param != undefined){
                return char + $.fn.validate.defaults[elem].replace("*", param);
            }
            return char + $.fn.validate.defaults[elem];
        },

        _addLabelError : function(id, type, param){
            if(this._getLabel(id).length){
                this._getLabel(id).text(this._getMsgError(id, type, param));
            } else {
                //se elemento eh um objeto do plugin inputToken
                if(id.indexOf("token-input") != -1){
                    $('#'+id).closest("ul").after('<label for="'+id+'" class="error">'+this._getMsgError(id, type, param)+'</label>');
                } else {
                    $("#"+id).css("border", "1px solid #e48b8b");
                    $('#'+id).after('<label for="'+id+'" class="error">'+this._getMsgError(id, type, param)+'</label>');
                }
            }
        },

        _checkError : function(id, func, val, param) {
            if(val != '' && val != null) {
                if(!this.test(func, val, param, id)){
                    this._addLabelError(id, func, param);
                    return true;
                }
            } else if(func == 'required'){
                this._addLabelError(id, func);
                return true;
            }
            this._getLabel(id).remove();
            $("#"+id).css("border", "");
            return false;
        },

        _addEvents : function(id, self){
            if(self.opts.rules[id]['remote']){
                self.ajaxRemote[id] = {//flag ajax remote
                    oldVal:'',
                    valid:false,
                    request:undefined
                };
            }
            //obj for type plugin tokenInput
            if(id.indexOf("token-input") != -1){
                $("#"+id).bind("DOMSubtreeModified", function(){
                    self.isValid(id);
                });
                return;
            }
            $('#'+id).on("change.Validate", function(){
                $('#'+id).off("change.Validate");
                self.isValid(id);
                $('#'+id).on("change.Validate keyup.Validate", function(){
                    self.isValid(id);
                });
            });
        },

        _init : function(self){
            $.each(this.opts.rules, function(id){ //add events
                self._addEvents(id, self);
            });
            this.$el.bind(
                self.$el.is("form") ? 'submit' : 'click keydown',
                function(){
                    return self.isValidAll();
                }
            );
        },

        isValid : function(id){
            var value, i = invalid = 0, self = this;
            $.each(this.opts.rules[id], function(key, elem){
                //tratamento diferenciado para campos do plugin tokenInput
                value = id.indexOf("token-input") != -1 
                    ? $("#"+id).parents("ul").find("p").html()
                    : $('#'+id).val();
                if($.isArray(elem)){
                    for(i in elem){
                        if(self._checkError(id, elem[i], value)){
                            invalid++;
                            return false;
                        }
                    }
                } else {
                    if(self._checkError(id, key, value, elem)){
                        invalid++;
                        return false;
                    }
                }
            });
            return invalid == 0;
        },

        isValidAll : function(){
            var i, invalid = 0, ids = Object.keys(this.opts.rules);
            for(i in ids){
                if(!this.isValid(ids[i])) { //check all error and create labels
                    invalid++;
                    $("#"+ids[i]).trigger("change");
                }
            };
            return invalid == 0;
        },
        
        test : function(func, val, param, id){
            return typeof $fn[func] == 'function' ? $fn[func](val, param, id, this) : $fn[func].test(val);
        },
        
        add : function(obj){
            if(obj.rules != undefined) {
                $.extend(true, this.opts, obj);
                var keys = Object.keys(obj.rules);
                for(i in keys){
                    this._addEvents(keys[i], this);
                }
            }
        },
        
        remove : function(name){
            if(typeof name == "object"){
                var self = this;
                $.each(this.opts.rules, function(id){
                    self.remove(id);
                });
                $(this[0]).removeData($(this).attr("id"));
                return true;
            } else if(this.opts.rules[name] != undefined){
                delete this.opts.rules[name];
                delete this.opts.messages[name];
                this._getLabel(name).remove();
                $('#'+name).off("change.Validate keyup.Validate");
                return true;
            }
            return false;
        },
        
        normalize : function(id){
            this._getLabel(id).remove();
            $("#"+id).css("border", "2px solid #98d5f4");
        },
        
        normalizeRules : function(){
            var self = this;
            $.each(this.opts.rules, function(id){
                self._getLabel(id).remove();
                $("#"+id).css("border", "2px solid #98d5f4");
            });
        }
        
    };
    
    function Plugin(_this, options) {
        this.$el = $(_this);
        this.opts = options;
        this.ajaxRemote = {}; //flag ajax 
        this._init(this);
    }
    
    $.fn.validate = function(options) {
        if(!this[0]){
            return;
        } else if(typeof options == 'object' && Object.keys($.data(this[0])).length == 0){
            $.data(this[0], $(this).attr("id"), new Plugin(this, options));
        } else if (typeof options == 'string' && options[0] !== "_"){
            var instance = $.data(this[0], $(this).attr("id"));
            return instance[options].apply(instance, Array.prototype.slice.call(arguments, 1));
        }
    };
    
    $.fn.valid = function() {
        var instance = $.data(this[0], $(this).attr("id"));
        return instance ? instance['isValidAll']() : false;
    };
    
    $.fn.testRegex = function(func) {
        return $fn[func].test($(this).val());
    };
    
    $.fn.validate.defaults = {
        required    : "Este campo não pode ficar vazio.",
        letter      : "Entre somente com letras de a-z.",
        numeric     : "Entre somente com valores númerico.",
        integer     : "Digite somente números inteiros.",
        float       : "Entre com um valor decimal válido.",    
        date        : "Entre com uma data no formato dd/mm/aaaa.",
        email       : "Entre com um e-mail válido!",
        phone       : "Digite o número do telefone no formato: (00)000000000.",
        fileName    : "Nome do arquivo contém caracteres inválidos.",
        cep         : "Digite o CEP no formato: 00000-000",
        compareDate : "A data inicial não pode ser maior do que data final.",
        greater     : "Valor final deve ser menor que o inicial.",
        equal       : "O campo precisa ser igual ao solicitado.",
        cpf         : "CPF inválido, verifique.",
        cnpj        : "CNPJ inválido, verifique.",
        alfNum      : "Tecle apenas valores alfanuméricos.",
        text        : "Permitido somente valores de 0-9, a-z, vírgulas e pontos.",
        minLength   : "Este campo deve ter no mínimo * caracteres.",
        maxLength   : "Este campo não deve conter mais de # caracteres.",
        remote      : 'Valor inválido ou já utilizado.',
        twoWords    : 'Digite apenas duas palavras',
        monthDay    : 'Digite um dia do mês de 1 até 31',
        colorHex    : 'Digite uma cor hexadecimal válida. Ex: #ffffff',
        money       : 'Digite um valor monetário separado por vírgula. Ex: 9,99',
        url         : 'URL inserida é inválida, verifique.'
    };
    
})( jQuery );