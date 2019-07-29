/**
 * AddressCheck Client.
 *
 * @author Ilja Weber <ilja@endereco.de>
 * @copyright 2019 mobilemojo – Apps & eCommerce UG (haftungsbeschränkt) & Co. KG
 * {@link https://endereco.de}
 */
function AddressCheck(config) {

    // Includes polyfill for IE
    if (!Array.prototype.includes) {
        Object.defineProperty(Array.prototype, "includes", {
            enumerable: false,
            value: function(obj) {
                var newArr = this.filter(function(el) {
                    return el == obj;
                });
                return newArr.length > 0;
            }
        });
    }

    /**
     * Combine object, IE 11 compatible.
     */
    this.mergeObjects = function(objects) {
        return objects.reduce(function (r, o) {
            Object.keys(o).forEach(function (k) {
                r[k] = o[k];
            });
            return r;
        }, {})
    };

    var $self  = this;
    this.requestBody = {
        "jsonrpc": "2.0",
        "id": 1,
        "method": "addressCheck",
        "params": {
            "street": "",
            "houseNumber": "",
            "postCode": "",
            "cityName": "",
            "country": "de",
            "language": "de",
        }
    };
    this.defaultConfig = {
        'checkOnBlur': true,
        'useWatcher': true,
        'tid': 'not_set',
        'defaultCountry': 'de'
    };
    this.fieldsAreSet = false;
    this.dirty = false;
    this.config = $self.mergeObjects([this.defaultConfig, config]);
    this.connector = new XMLHttpRequest();

    /**
     * Helper function to create events, thats are compatible with ie 11.
     *
     * @param eventName
     * @returns {Event}
     */
    this.createEvent = function(eventName) {
        var event;
        if(typeof(Event) === 'function') {
            event = new Event(eventName);
        }else{
            event = document.createEvent('Event');
            event.initEvent(eventName, true, true);
        }
        return event;
    };

    /**
     * Helper function to update existing config, overwriting existing fields.
     *
     * @param newConfig
     */
    this.updateConfig = function(newConfig) {
        $self.config = $self.mergeObjects([$self.config, newConfig]);
    }

    /**
     * Checks if fields are set.
     */
    this.checkIfFieldsAreSet = function() {
        var areFieldsSet = false;
        if(
            (null !== document.querySelector($self.config.streetSelector))
            && (null !== document.querySelector($self.config.houseNumberSelector))
            && (null !== document.querySelector($self.config.postCodeSelector))
            && (null !== document.querySelector($self.config.cityNameSelector))
            && (null !== document.querySelector($self.config.countrySelector))
        ) {
            areFieldsSet = true;
        }

        if (!$self.fieldsAreSet && areFieldsSet) {

            // Fields are now set. Mark addresscheck as dirty to trigger reinitiation.
            $self.dirty = true;
            $self.fieldsAreSet = true;
        } else if($self.fieldsAreSet && !areFieldsSet) {

            // Fields have been removed.
            $self.fieldsAreSet = false;
        }
    }

    this.init = function() {

        try {
            $self.streetElement = document.querySelector($self.config.streetSelector);
            $self.houseNumberElement = document.querySelector($self.config.houseNumberSelector);
            $self.postCodeElement = document.querySelector($self.config.postCodeSelector);
            $self.cityNameElement = document.querySelector($self.config.cityNameSelector);
            $self.countryElement = document.querySelector($self.config.countrySelector);
            $self.timeOut = undefined;
            $self.overlay = undefined;
            $self.predictions = [];
            $self.anyChange = false;
            $self.activeIndex = -1;
        } catch(e) {
            console.log('Could not initiate AddressCheck because of error:', e);
            return;
        }

        // Generate TID if accounting service is set.
        if (window.accounting && ('not_set' === $self.config.tid)) {
            $self.config.tid = window.accounting.generateTID();
        }

        $self.streetElement.addEventListener('change', function() {
            $self.anyChange = true;
        });

        $self.houseNumberElement.addEventListener('change', function() {
            $self.anyChange = true;
        });

        $self.postCodeElement.addEventListener('change', function() {
            $self.anyChange = true;
        });

        $self.cityNameElement.addEventListener('change', function() {
            $self.anyChange = true;
        });

        $self.countryElement.addEventListener('change', function() {
            $self.anyChange = true;
        });


        $self.streetElement.addEventListener('blur', function() {
            if ($self.config.checkOnBlur){
                $self.checkAddress().then( function($data) {
                    $self.predictions = $data.result.predictions;

                    if ($data.result.status.includes('A1000') && !$data.result.status.includes('A1100')) {
                        $self.markSuccess();
                    }
                    if ($data.result.predictions.length > 1 || $data.result.status.includes('A1100')) {
                        $self.renderVariants();
                    }
                }, function($data){});
            }
        });

        $self.houseNumberElement.addEventListener('blur', function() {
            if ($self.config.checkOnBlur){
                $self.checkAddress().then( function($data) {
                    $self.predictions = $data.result.predictions;

                    if ($data.result.status.includes('A1000') && !$data.result.status.includes('A1100')) {
                        $self.markSuccess();
                    }
                    if ($data.result.predictions.length > 1 || $data.result.status.includes('A1100')) {
                        $self.renderVariants();
                    }
                }, function($data){});
            }

            if ('' === this.value) {
                var event = $self.createEvent('endereco.clean');
                $self.houseNumberElement.dispatchEvent(event);
            }
        });

        $self.postCodeElement.addEventListener('blur', function() {
            if ($self.config.checkOnBlur){
                $self.checkAddress().then( function($data) {
                    $self.predictions = $data.result.predictions;

                    if ($data.result.status.includes('A1000') && !$data.result.status.includes('A1100')) {
                        $self.markSuccess();
                    }
                    if ($data.result.predictions.length > 1 || $data.result.status.includes('A1100')) {
                        $self.renderVariants();
                    }
                }, function($data){});
            }
        });

        $self.cityNameElement.addEventListener('blur', function() {
            if ($self.config.checkOnBlur){
                $self.checkAddress().then( function($data) {
                    $self.predictions = $data.result.predictions;

                    if ($data.result.status.includes('A1000') && !$data.result.status.includes('A1100')) {
                        $self.markSuccess();
                    }
                    if ($data.result.predictions.length > 1 || $data.result.status.includes('A1100')) {
                        $self.renderVariants();
                    }
                }, function($data){});
            }
        });

        $self.countryElement.addEventListener('blur', function() {
            if ($self.config.checkOnBlur){
                $self.checkAddress().then( function($data) {
                    $self.predictions = $data.result.predictions;

                    if ($data.result.status.includes('A1000') && !$data.result.status.includes('A1100')) {
                        $self.markSuccess();
                    }
                    if ($data.result.predictions.length > 1 || $data.result.status.includes('A1100')) {
                        $self.renderVariants();
                    }
                }, function($data){});
            }

            if ('' === this.value) {
                var event = $self.createEvent('endereco.clean');
                $self.countryElement.dispatchEvent(event);
            }
        });

        $self.streetElement.addEventListener('focus', function() {
            $self.connector.abort();
        });

        $self.houseNumberElement.addEventListener('focus', function() {
            $self.connector.abort();
        });

        $self.postCodeElement.addEventListener('focus', function() {
            $self.connector.abort();
        });

        $self.cityNameElement.addEventListener('focus', function() {
            $self.connector.abort();
        });

        $self.countryElement.addEventListener('focus', function() {
            $self.connector.abort();
        });

        $self.dirty = false;
        console.log('AddressCheck initiated');
    }


    this.isAnyFocused = function() {
        var streetFocused = (document.activeElement === $self.streetElement);
        var houseNumberFocused = (document.activeElement === $self.houseNumberElement);
        var postCodeFocused = (document.activeElement === $self.postCodeElement);
        var cityNameFocused = (document.activeElement === $self.cityNameElement);
        var countryFocused = (document.activeElement === $self.countryElement);
        return streetFocused || houseNumberFocused || postCodeFocused || cityNameFocused || countryFocused;
    }

    this.isAnyEmpty = function() {
        var streetEmpty = ('' === $self.streetElement.value.trim());
        var houseNumberEmpty = ('' === $self.houseNumberElement.value.trim());
        var postCodeEmpty = ('' === $self.postCodeElement.value.trim());
        var cityNameEmpty = ('' === $self.cityNameElement.value.trim());

        return streetEmpty || houseNumberEmpty || postCodeEmpty || cityNameEmpty;
    }

    this.removeOverlay = function() {
        if (undefined !== $self.overlay) {
            $self.overlay.parentElement.removeChild($self.overlay);
            $self.overlay = undefined;
        }
    }

    /**
     * Send endereco.valid events to
     */
    this.markSuccess = function() {
        // Mark all fields as valid, because its selected
        var event = $self.createEvent('endereco.valid');
        $self.streetElement.dispatchEvent(event);
        $self.houseNumberElement.dispatchEvent(event);
        $self.postCodeElement.dispatchEvent(event);
        $self.cityNameElement.dispatchEvent(event);
        if ('' !== $self.countryElement.value) {
            $self.countryElement.dispatchEvent(event);
        }
    };

    /**
     * Send endereco.valid events to
     */
    this.markNeutral = function() {
        // Clean all markings.
        var event = $self.createEvent('endereco.clean');
        $self.streetElement.dispatchEvent(event);
        $self.houseNumberElement.dispatchEvent(event);
        $self.postCodeElement.dispatchEvent(event);
        $self.cityNameElement.dispatchEvent(event);
        $self.countryElement.dispatchEvent(event);
    };

    // Reads the values from address fields and sends them to api. Returns promise.
    this.checkAddress = function(force) {
        if(force === undefined) {
            force = false;
        }
        return new Promise(function(resolve, reject) {
            var $data = {};
            if ((!$self.isAnyFocused() && !$self.isAnyEmpty()) || force) {
                $self.connector.onreadystatechange = function() {
                    if(4 === $self.connector.readyState) {
                        $data = {};
                        if ($self.connector.responseText && '' !== $self.connector.responseText) {
                            try {
                                $data = JSON.parse($self.connector.responseText);
                            } catch(e) {
                                console.log('Parsing error', e);
                                reject($data);
                            }

                            if ($data.error || !$data.result) {
                                reject($data);
                            }
                            resolve($data);
                        }  else {
                            reject($data);
                        }
                    }
                };

                $self.anyChange = false;
                $self.requestBody.params.street = $self.streetElement.value.trim();
                $self.requestBody.params.houseNumber = $self.houseNumberElement.value.trim();
                $self.requestBody.params.postCode = $self.postCodeElement.value.trim();
                $self.requestBody.params.cityName = $self.cityNameElement.value.trim();
                $self.requestBody.params.country = $self.countryElement.options[$self.countryElement.selectedIndex].getAttribute('data-code');

                if ('' === $self.requestBody.params.country) {
                    $self.requestBody.params.country = $self.config.defaultCountry;
                }

                // Fallback.
                if ('' === $self.requestBody.params.country || undefined === $self.requestBody.params.country) {
                    $self.requestBody.params.country = $self.countryElement.options[$self.countryElement.selectedIndex].value;
                }
                $self.connector.open('POST', $self.config.endpoint, true);
                $self.connector.setRequestHeader("Content-type", "application/json");
                $self.connector.setRequestHeader("X-Auth-Key", $self.config.apiKey);
                $self.connector.setRequestHeader("X-Transaction-Id", $self.config.tid);
                $self.connector.setRequestHeader("X-Transaction-Referer", window.location.href);

                $self.connector.send(JSON.stringify($self.requestBody));
            } else {
                reject({});
            }
        });
    }

    this.renderVariants = function() {
        var overlay_element;

        /**
         * TODO: remove in future version
         *
         * This code checks if the fields have been emptied while the remote server is processing the request. Oxid Shop does such things.
         * In future version remote server should return original input.
         */
        if($self.isAnyEmpty()) {
            return;
        }

        overlay_element = document.getElementById('endereco-acresscheck-overlay');
        if(overlay_element) {
            overlay_element.parentElement.removeChild(overlay_element);
        }

        // Create overlay
        overlay_element = document.createElement('div');
        $self.overlay = overlay_element;
        overlay_element.id = 'endereco-acresscheck-overlay';
        overlay_element.style.position = 'fixed';
        overlay_element.style.padding = '0';
        overlay_element.style.top = '0';
        overlay_element.style.left = '0';
        overlay_element.style.width = '100%';
        overlay_element.style.height = '100%';
        overlay_element.style.zIndex = '90000';
        overlay_element.style.display = 'flex';
        overlay_element.style.justifyContent = 'center';
        overlay_element.style.alignItems = 'center';
        overlay_element.style.backgroundColor = 'rgba(0, 0, 0, 0.25)';

        // Window
        window_element = document.createElement('div');
        window_element.style.width = '100%';
        window_element.style.maxWidth = '480px';
        window_element.style.backgroundColor = '#fff';
        window_element.style.border = '1px solid #ccc';
        window_element.style.borderRadius = '4px';
        window_element.style.overflow = 'hidden';
        overlay_element.appendChild(window_element);

        // Window header
        window_header_element = document.createElement('div');
        window_header_element.style.width = '100%';
        window_header_element.style.padding = '8px 16px';
        window_header_element.style.color =  $self.config.colors.primaryColorText;
        window_header_element.style.display = 'flex';
        window_header_element.style.fontSize = '16px';
        window_header_element.style.lineHeight = '24px';
        window_header_element.style.justifyContent = 'space-between';
        window_header_element.style.backgroundColor = $self.config.colors.primaryColor;
        window_element.appendChild(window_header_element);

        // Header Title
        window_header_element.appendChild(document.createTextNode($self.config.texts.addressCheckHead));

        // Close button
        close_element = document.createElement('span');
        close_element.appendChild(document.createTextNode('✖'));
        close_element.style.cursor = 'pointer';
        close_element.addEventListener('click', function() {
            $self.removeOverlay();
        });
        window_header_element.appendChild(close_element);

        // Window body
        window_body_element = document.createElement('div');
        window_body_element.style.width = '100%';
        window_body_element.style.padding = '8px 16px';
        window_body_element.style.backgroundColor = '#fff';
        window_element.appendChild(window_body_element);

        headline1_element = document.createElement('p');
        headline1_element.style.margin = '15px 0 5px';
        headline1_element.appendChild(document.createTextNode($self.config.texts.addressCheckArea1));
        window_body_element.appendChild(headline1_element);

        // Create default choice
        default_label_element = document.createElement('label');
        default_label_element.style.fontWeight = '700';
        default_label_element.style.width = '100%';
        default_label_element.style.display = 'inline-block';
        default_label_element.setAttribute('data-offset', '-1');
        default_label_element.addEventListener('click', function() {
            $self.activeIndex = -1;
        });

        default_cb_element = document.createElement('input');
        default_cb_element.setAttribute('type', 'radio');
        default_cb_element.setAttribute('name', 'endereco-radio');
        default_cb_element.checked = true;
        default_cb_element.style.marginRight = '10px';
        default_label_element.appendChild(default_cb_element);
        var address = $self.postCodeElement.value.trim() +
            ' ' +
            $self.cityNameElement.value.trim() +
            ' ' +
            $self.streetElement.value.trim() +
            ' ' +
            $self.houseNumberElement.value.trim();
        default_label_element.appendChild(document.createTextNode(address));
        window_body_element.appendChild(default_label_element);

        headline2_element = document.createElement('p');
        headline2_element.style.margin = '15px 0 5px';
        headline2_element.appendChild(document.createTextNode($self.config.texts.addressCheckArea2));
        window_body_element.appendChild(headline2_element);

        // Create variants choice
        var counter = 0;
        $self.predictions.forEach(function(prediction) {
            default_label_element = document.createElement('label');
            default_label_element.style.fontWeight = '700';
            default_label_element.style.width = '100%';
            default_label_element.style.display = 'inline-block';
            default_label_element.setAttribute('data-offset', counter);
            default_label_element.addEventListener('click', function() {
                $self.activeIndex = this.getAttribute('data-offset');
            });

            default_cb_element = document.createElement('input');
            default_cb_element.setAttribute('type', 'radio');
            default_cb_element.setAttribute('name', 'endereco-radio');
            default_cb_element.style.marginRight = '10px';
            default_label_element.appendChild(default_cb_element);
            var address = prediction.postCode +
                ' ' +
                prediction.cityName +
                ' ' +
                prediction.street +
                ' ' +
                prediction.houseNumber;
            default_label_element.appendChild(document.createTextNode(address));
            window_body_element.appendChild(default_label_element);
            counter++;
        });

        // Window footer
        window_footer_element = document.createElement('div');
        window_footer_element.style.width = '100%';
        window_footer_element.style.padding = '8px 16px';
        window_footer_element.style.display = 'flex';
        window_footer_element.style.justifyContent = 'flex-end';
        window_footer_element.style.backgroundColor = '#fff';
        window_element.appendChild(window_footer_element);

        // Submit
        submit_element = document.createElement('button');
        submit_element.setAttribute('class', 'endereco-submit-btn')
        submit_element.appendChild(document.createTextNode($self.config.texts.addressCheckButton));
        // Default button style
        submit_element.style.color = $self.config.colors.primaryColorText;
        submit_element.style.backgroundColor = $self.config.colors.primaryColor;
        submit_element.style.border = '1px solid ' + $self.config.colors.primaryColorHover;
        submit_element.style.padding = '6px 12px';
        submit_element.style.fontSize = '14px';
        submit_element.style.borderRadius = '4px';
        submit_element.style.textAlign = 'center';

        submit_element.addEventListener('mouseover', function() {
            this.style.backgroundColor = $self.config.colors.primaryColorHover;
        });

        submit_element.addEventListener('mouseout', function() {
            this.style.backgroundColor = $self.config.colors.primaryColor;
        });

        submit_element.addEventListener('click', function() {

            $self.markSuccess();
            if(0 <= $self.activeIndex && undefined !== $self.predictions[$self.activeIndex]) {
                $self.streetElement.value = $self.predictions[$self.activeIndex].street;
                $self.houseNumberElement.value = $self.predictions[$self.activeIndex].houseNumber;
                $self.postCodeElement.value = $self.predictions[$self.activeIndex].postCode;
                $self.cityNameElement.value = $self.predictions[$self.activeIndex].cityName;
            }
            $self.activeIndex = -1;
            $self.removeOverlay();
        });

        window_footer_element.appendChild(submit_element);

        document.body.appendChild(overlay_element);
    }


    // Service loop.
    setInterval( function() {

        if ($self.config.useWatcher) {
            $self.checkIfFieldsAreSet();
        }

        if ($self.dirty) {
            $self.init();
        }
    }, 300);
}
