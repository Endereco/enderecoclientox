/**
 * Endereco SDK.
 *
 * @author Ilja Weber <ilja.weber@mobilemjo.de>
 * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
 * {@link https://endereco.de}
 */
function NameCheck(config) {

    if (!document.querySelector(config.inputSelector)) {
        return null;
    }

    var $self  = this;
    this.inputElement = document.querySelector(config.inputSelector);
    this.salutationElement = document.querySelector(config.salutationElement);
    this.mapping = config.mapping;
    this.config = config;
    this.gender = 'X';
    this.requestBody = {
        "jsonrpc": "2.0",
        "id": 1,
        "method": "nameCheck",
        "params": {
            "name": ""
        }
    }

    this.connector = new XMLHttpRequest();

    //// Functions
    this.checkSalutation = function() {

        if ('' === $self.salutationElement.value) {
            event = new Event('endereco.clean');
            $self.inputElement.dispatchEvent(event);
            return;
        }

        if ('M' === $self.gender) {
            if($self.mapping[$self.gender] !== $self.salutationElement.value) {
                event = new Event('endereco.check');
                $self.inputElement.dispatchEvent(event);
            } else {
                event = new Event('endereco.valid');
                $self.inputElement.dispatchEvent(event);
            }
        } else if ('F' === $self.gender) {
            if($self.mapping[$self.gender] !== $self.salutationElement.value) {
                event = new Event('endereco.check');
                $self.inputElement.dispatchEvent(event);
            } else {
                event = new Event('endereco.valid');
                $self.inputElement.dispatchEvent(event);
            }
        } else if ('N' === $self.gender) {
            event = new Event('endereco.valid');
            $self.inputElement.dispatchEvent(event);
        } else {
            event = new Event('endereco.clean');
            $self.inputElement.dispatchEvent(event);
        }
    }

    // Check if the browser is chrome
    this.isChrome = function() {
        return /chrom(e|ium)/.test( navigator.userAgent.toLowerCase( ) );
    }


    //// DOM modifications

    // Set mark
    this.inputElement.setAttribute('data-service', 'nameCheck');
    this.inputElement.setAttribute('data-status', 'instantiated');

    // Disable browser autocomplete
    if (this.isChrome()) {
        this.inputElement.setAttribute('autocomplete', 'autocomplete_' + Math.random().toString(36).substring(2) + Date.now());
    } else {
        this.inputElement.setAttribute('autocomplete', 'off' );
    }

    this.recheck = function() {
        $self.requestBody.params.name = $self.inputElement.value;

        if(undefined !== $self.inputElement.getAttribute('data-tid') && null !== $self.inputElement.getAttribute('data-tid')) {
            tid = $self.inputElement.getAttribute('data-tid');
        } else {
            tid = 'not_set';
        }
        $self.connector.abort();
        $self.inputElement.setAttribute('data-status', 'loading');
        $self.connector.open('POST', $self.config.endpoint, true);
        $self.connector.setRequestHeader("Content-type", "application/json");
        $self.connector.setRequestHeader("X-Auth-Key", $self.config.apiKey);
        $self.connector.setRequestHeader("X-Transaction-Id", tid);
        $self.connector.setRequestHeader("X-Transaction-Referer", window.location.href);

        $self.connector.send(JSON.stringify($self.requestBody));
    }

    //// Rendering
    this.inputElement.addEventListener('change', function() {
        $this = this;


        value = $this.value.trim();
        var result = [],
            separators = [' ', '-', '–', '_', '.'],
            upperCase = true;

        for(var i = 0; i < value.length; i++)
        {
            result.push(upperCase ? value[i].toUpperCase() : value[i]);
            upperCase = false;
            if(separators.indexOf(value[i]) >= 0)
                upperCase = true;
        }

        result = result.join('');
        newName = result.replace(/\s{2,}/g, ' ').trim();

        $this.value = newName;

        $self.recheck();
    });

    this.salutationElement.addEventListener('change', function() {
        $self.recheck();
    })


    // On data receive
    this.connector.onreadystatechange = function() {
        if(4 === $self.connector.readyState) {
            if ($self.connector.responseText && '' !== $self.connector.responseText) {
                $data = JSON.parse($self.connector.responseText);
                $self.gender = $data.result.gender;
                $self.checkSalutation();
            }
        }

    }
}
