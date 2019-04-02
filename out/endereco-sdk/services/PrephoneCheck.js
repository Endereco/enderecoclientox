/**
 * Endereco SDK.
 *
 * @author Ilja Weber <ilja.weber@mobilemjo.de>
 * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
 * {@link https://endereco.de}
 */
function PrephoneCheck(config) {

    if (!document.querySelector(config.inputSelector)) {
        return null;
    }

    var $self  = this;
    this.inputElement = document.querySelector(config.inputSelector);
    this.config = config;
    this.format = config.format;
    this.gender = 'X';
    this.requestBody = {
        "jsonrpc": "2.0",
        "id": 1,
        "method": "prephoneCheck",
        "params": {
            "prephoneNumber": "",
            "format": 8
        }
    }

    this.connector = new XMLHttpRequest();

    //// Functions

    // Check if the browser is chrome
    this.isChrome = function() {
        return /chrom(e|ium)/.test( navigator.userAgent.toLowerCase( ) );
    }


    //// DOM modifications

    // Set mark
    this.inputElement.setAttribute('data-service', 'prephoneCheck');
    this.inputElement.setAttribute('data-status', 'instantiated');

    // Disable browser autocomplete
    if (this.isChrome()) {
        this.inputElement.setAttribute('autocomplete', 'autocomplete_' + Math.random().toString(36).substring(2) + Date.now());
    } else {
        this.inputElement.setAttribute('autocomplete', 'off' );
    }

    //// Rendering
    this.inputElement.addEventListener('change', function() {
        $this = this;

        if ('' === $this.value.trim()) {
            event = new Event('endereco.clean');
            $self.inputElement.dispatchEvent(event);
            return;
        }

        $self.requestBody.params.prephoneNumber = $this.value.trim();
        $self.requestBody.params.format = $self.format;

        if(undefined !== this.getAttribute('data-tid') && null !== this.getAttribute('data-tid')) {
            tid = this.getAttribute('data-tid');
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
    });

    // On data receive
    this.connector.onreadystatechange = function() {
        if(4 === $self.connector.readyState) {
            if ($self.connector.responseText && '' !== $self.connector.responseText) {
                $data = JSON.parse($self.connector.responseText);
                if ($data.result.status.includes('A1000')) {
                    $self.inputElement.value = $data.result.prephoneNumber;
                    event = new Event('endereco.valid');
                    $self.inputElement.dispatchEvent(event);
                }
            }
        }

    }
}
