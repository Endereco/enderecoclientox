/**
 * Endereco SDK.
 *
 * @author Ilja Weber <ilja.weber@mobilemjo.de>
 * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
 * {@link https://endereco.de}
 */
function Accounting(config) {
    var $self  = this;
    this.groups = config.groups;
    this.config = config;
    this.connector = new XMLHttpRequest();
    this.globalTimeout = undefined;
    this.generateTID = function(groupName) {
        prename = $self.randomNumber + '_' + groupName + '_' + $self.hashCode(window.location.href);
        return btoa($self.caesarCipher(prename, 5));
    }
    this.randomNumber = Math.random().toString(36).substring(2) + Date.now();
    this.hasAnyChanged = false;
    this.requestBody = {
        "jsonrpc": "2.0",
        "id": 1,
        "method": "doAccounting"
    }

    this.caesarCipher = function(string, offset) {
        string = string.toLowerCase();
        var result = '';
        var charcode = 0;
        for (var i = 0; i < string.length; i++) {
            charcode = (string[i].charCodeAt()) + offset;
            result += String.fromCharCode(charcode);
        }
        return result;
    }

    this.hashCode = function(string) {
        var hash = 0, i, chr;
        if (0 === string.length) {
            return hash;
        }
        for (i = 0; i < string.length; i++) {
            chr   = string.charCodeAt(i);
            hash  = ((hash << 5) - hash) + chr;
            hash |= 0;
        }
        return hash;
    }

    // For each field in each group generate tid
    this.groups.forEach( function(group){
        tid = $self.generateTID(group.name);
        group.invoiceable = false;

        if ('' === group.formSelector || undefined === group.formSelector) {
            formElement = undefined;
        } else {
            formElement = document.querySelector(group.formSelector);
        }

        if(undefined !== formElement && null !== formElement) {
            formElement.addEventListener('submit', function(e) {
                if (group.invoiceable && group.validationFunction(formElement) === true) {
                    e.preventDefault();
                    $self.connector.open('POST', $self.config.endpoint, true);
                    $self.connector.setRequestHeader("Content-type", "application/json");
                    $self.connector.setRequestHeader("X-Auth-Key", $self.config.apiKey);
                    $self.connector.setRequestHeader("X-Transaction-Id", tid);
                    $self.connector.setRequestHeader("X-Transaction-Referer", window.location.href);
                    $self.connector.send(JSON.stringify($self.requestBody));
                    group.invoiceable = false;

                    if (undefined !== $self.globalTimeout) {
                        clearTimeout($self.globalTimeout);
                    }

                    $self.globalTimeout = setTimeout(function() {
                        if(group.validationFunction(formElement) === true) {
                            formElement.submit();
                        }
                    }, 1000);
                }
            });
        }

        group.fieldsSelectors.forEach( function(selector){
            if (document.querySelector(selector)) {
                element = document.querySelector(selector);
                element.setAttribute('data-tid', tid);
                element.addEventListener('change', function() {
                    group.invoiceable = true;
                });
            }
        });
    });
}
