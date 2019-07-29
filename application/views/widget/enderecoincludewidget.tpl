[{assign var="sitepath" value=$oViewConf->getBaseDir()}]

[{capture assign="serviceConfiguration"}]
    var colorTheme = {
        'primaryColor': '[{$enderecocstrs.sPRIMARYCOLOR}]',
        'primaryColorHover': '[{$enderecocstrs.sPRIMARYCOLORHOVER}]',
        'primaryColorText': '[{$enderecocstrs.sPRIMARYCOLORTEXT}]',
        'secondaryColor': '[{$enderecocstrs.sSECONDARYCOLOR}]',
        'secondaryColorHover': '[{$enderecocstrs.sSECONDARYCOLORHOVER}]',
        'secondaryColorText': '[{$enderecocstrs.sSECONDARYCOLORTEXT}]',
        'warningColor': '[{$enderecocstrs.sWARNINGCOLOR}]',
        'warningColorHover': '[{$enderecocstrs.sWARNINGCOLORHOVER}]',
        'warningColorText': '[{$enderecocstrs.sWARNINGCOLORTEXT}]',
        'successColor': '[{$enderecocstrs.sSUCCESSCOLOR}]',
        'successColorHover': '[{$enderecocstrs.sSUCCESSCOLORHOVER}]',
        'successColorText': '[{$enderecocstrs.sSUCCESSCOLORTEXT}]'
    };

    var texts = {
        'addressCheckHead': '[{oxmultilang ident="ENDERECOCLIENTOX_ADDRESSCHECK_HEAD"}]',
        'addressCheckButton': '[{oxmultilang ident="ENDERECOCLIENTOX_ADDRESSCHECK_BTN"}]',
        'addressCheckArea1': '[{oxmultilang ident="ENDERECOCLIENTOX_ADDRESSCHECK_AREA1"}]',
        'addressCheckArea2': '[{oxmultilang ident="ENDERECOCLIENTOX_ADDRESSCHECK_AREA2"}]',
    };

    document.addEventListener('DOMContentLoaded', function() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if(4 === xhr.readyState) {
                if ('connection_ok' === xhr.responseText) {
                    console.log('Connection to endereco service service ok. Can init services.');
                    initAccounting();
                    [{if $enderecocstrs.bEMAILCHECK == 1}]initEmailCheck();[{/if}]
                    [{if $enderecocstrs.bNAMECHECK == 1}]initNameCheck();[{/if}]
                    initCountryAutocomplete();
                    [{if $enderecocstrs.bPOSTCODEAUTOCOMPLETE == 1}]initPostCodeAutocomplete();[{/if}]
                    [{if $enderecocstrs.bCITYNAMEAUTOCOMPLETE == 1}]initCityNameAutocomplete();[{/if}]
                    [{if $enderecocstrs.bSTREETAUTOCOMPLETE == 1}]initStreetAutocomplete();[{/if}]
                    [{if $enderecocstrs.bADDRESSCHECK == 1}]initAddressCheck();[{/if}]
                    [{if $enderecocstrs.bPREPHONECHECK == 1}]initPrephoneCheck();[{/if}]
                    [{if $enderecocstrs.bSTATUSINDICATOR == 1}]initStatusIndicator();[{/if}]
                } else {
                    console.log('No connection to endereco service server. Don\'t init services.')
                }
            }
        };
        xhr.open('GET', '[{$sitepath}]?cl=enderecoconnectioncontroller', true);
        xhr.send();
    });

    /**
     * Wrapper function to initiate country autocomplete services.
     */
    function initCountryAutocomplete() {
        new CountryAutocomplete({
            'countrySelector': 'select[name="invadr[oxuser__oxcountryid]"]',
            'countryEndpoint': "[{$sitepath}]?cl=enderecocountrycontroller",
        });

        new CountryAutocomplete({
            'countrySelector': 'select[name="deladr[oxaddress__oxcountryid]"]',
            'countryEndpoint': "[{$sitepath}]?cl=enderecocountrycontroller",
        });
    }

    /**
     * Wrapper function to initiate email check.
     */
    function initEmailCheck() {
        // Register emailCheck for invoice address
        window.invEmailCheck = new EmailCheck({
            'inputSelector': '#userLoginName',
            'endpoint': "[{$sitepath}]?cl=enderecocontroller"
        });

        // Register emailCheck for invoice address
        window.invEmailCheck2 = new EmailCheck({
            'inputSelector': 'input[name="invadr[oxuser__oxusername]"]',
            'endpoint': "[{$sitepath}]?cl=enderecocontroller"
        });
    }

    /**
     * Wrapper function for name check service.
     */
    function initNameCheck() {
        // Register nameCheck for invoice address
        // Fix for flow.
        [{if $oViewConf->getActiveTheme() == 'flow' }]
            window.invNameCheck = new NameCheck({
                'inputSelector': 'input[name="invadr[oxuser__oxfname]"]',
                'salutationElement': 'select[name="invadr[oxuser__oxsal]"]',
                'endpoint': "[{$sitepath}]?cl=enderecocontroller",
                'mapping': {
                    'M': 'MR',
                    'F': 'MRS',
                    'N': '',
                    'X': ''
                },
                'colors' : colorTheme
            });
            // Bootstrap jquery change is not triggering change event properly, so we fix it here
            $('select[name="invadr[oxuser__oxsal]"]').change(function() {
                window.invNameCheck.checkSalutation().then( function($data) {
                    window.invNameCheck.resetStatus($data);
                });
            });

            // Register nameCheck for delivery address
            window.delNameCheck = new NameCheck({
                'inputSelector': 'input[name="deladr[oxaddress__oxfname]"]',
                'salutationElement': 'select[name="deladr[oxaddress__oxsal]"]',
                'endpoint': "[{$sitepath}]?cl=enderecocontroller",
                'mapping': {
                    'M': 'MR',
                    'F': 'MRS',
                    'N': '',
                    'X': ''
                },
                'colors' : colorTheme
            });
            // Bootstrap jquery change is not triggering change event properly, so we fix it here
            $('select[name="deladr[oxaddress__oxsal]"]').change(function() {
                window.delNameCheck.checkSalutation().then( function($data) {
                    window.delNameCheck.resetStatus($data);
                });
            });
        [{else}]
            window.invNameCheck = new NameCheck({
                'inputSelector': 'input[name="invadr[oxuser__oxfname]"]',
                'salutationElement': 'select[name="invadr[oxuser__oxsal]"]',
                'endpoint': "[{$sitepath}]?cl=enderecocontroller",
                'mapping': {
                    'M': 'MR',
                    'F': 'MRS',
                    'N': '',
                    'X': ''
                },
                'colors' : colorTheme
            });

            // Register nameCheck for delivery address
            window.delNameCheck = new NameCheck({
                'inputSelector': 'input[name="deladr[oxaddress__oxfname]"]',
                'salutationElement': 'select[name="deladr[oxaddress__oxsal]"]',
                'endpoint': "[{$sitepath}]?cl=enderecocontroller",
                'mapping': {
                    'M': 'MR',
                    'F': 'MRS',
                    'N': '',
                    'X': ''
                },
                'colors' : colorTheme
            });
        [{/if}]
    }

    /**
     * Wrapper function for postcode autocomplete services.
     */
    function initPostCodeAutocomplete() {
        // Register postCodeAutocomplete for invoice address
        window.invPostCodeAutocomplete = new PostCodeAutocomplete({
            'inputSelector': 'input[name="invadr[oxuser__oxzip]"]',
            'secondaryInputSelectors': {
                'cityName': 'input[name="invadr[oxuser__oxcity]"]',
                'country': 'select[name="invadr[oxuser__oxcountryid]"]'
            },
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'colors' : colorTheme
        });

        // Register postCodeAutocomplete for del address
        window.delPostCodeAutocomplete = new PostCodeAutocomplete({
            'inputSelector': 'input[name="deladr[oxaddress__oxzip]"]',
            'secondaryInputSelectors': {
                'cityName': 'input[name="deladr[oxaddress__oxcity]"]',
                'country': 'select[name="deladr[oxaddress__oxcountryid]"]'
            },
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'colors' : colorTheme
        });
    }

    /**
     * Wrapper function for city name autocomplete services.
     */
    function initCityNameAutocomplete() {
        // Register cityNameAutocomplete for invoice address
        window.invCityNameAutocomplete = new CityNameAutocomplete({
            'inputSelector': 'input[name="invadr[oxuser__oxcity]"]',
            'secondaryInputSelectors': {
                'postCode': 'input[name="invadr[oxuser__oxzip]"]',
                'country': 'select[name="invadr[oxuser__oxcountryid]"]'
            },
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'colors' : colorTheme
        });

        // Register cityNameAutocomplete for del address
        window.delCityNameAutocomplete = new CityNameAutocomplete({
            'inputSelector': 'input[name="deladr[oxaddress__oxcity]"]',
            'secondaryInputSelectors': {
                'postCode': 'input[name="deladr[oxaddress__oxzip]"]',
                'country': 'select[name="deladr[oxaddress__oxcountryid]"]'
            },
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'colors' : colorTheme
        });
    }

    /**
     * Wrapper function for street autocomplete services.
     */
    function initStreetAutocomplete() {
        // Register streetAutocomplete for invoice address
        window.invStreetAutocomplete = new StreetAutocomplete({
            'inputSelector': 'input[name="invadr[oxuser__oxstreet]"]',
            'secondaryInputSelectors': {
                'postCode': 'input[name="invadr[oxuser__oxzip]"]',
                'cityName': 'input[name="invadr[oxuser__oxcity]"]',
                'country': 'select[name="invadr[oxuser__oxcountryid]"]'
            },
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'colors' : colorTheme
        });

        // Register streetAutocomplete for del address
        window.delStreetAutocomplete = new StreetAutocomplete({
            'inputSelector': 'input[name="deladr[oxaddress__oxstreet]"]',
            'secondaryInputSelectors': {
                'postCode': 'input[name="deladr[oxaddress__oxzip]"]',
                'cityName': 'input[name="deladr[oxaddress__oxcity]"]',
                'country': 'select[name="deladr[oxaddress__oxcountryid]"]'
            },
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'colors' : colorTheme
        });
    }

    /**
     * Wrapper for address check services.
     */
    function initAddressCheck() {
        // Register addressCheck for invoice address
        window.invAddressCheck = new AddressCheck({
            'streetSelector': 'input[name="invadr[oxuser__oxstreet]"]',
            'houseNumberSelector': 'input[name="invadr[oxuser__oxstreetnr]"]',
            'postCodeSelector': 'input[name="invadr[oxuser__oxzip]"]',
            'cityNameSelector': 'input[name="invadr[oxuser__oxcity]"]',
            'countrySelector': 'select[name="invadr[oxuser__oxcountryid]"]',
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'colors' : colorTheme,
            'texts': texts
        });

        // Register addressCheck for invoice address
        window.delAddressCheck = new AddressCheck({
            'streetSelector': 'input[name="deladr[oxaddress__oxstreet]"]',
            'houseNumberSelector': 'input[name="deladr[oxaddress__oxstreetnr]"]',
            'postCodeSelector': 'input[name="deladr[oxaddress__oxzip]"]',
            'cityNameSelector': 'input[name="deladr[oxaddress__oxcity]"]',
            'countrySelector': 'select[name="deladr[oxaddress__oxcountryid]"]',
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'colors' : colorTheme,
            'texts': texts
        });
    }

    /**
     * Wrapper for prephonecheck
     */
    function initPrephoneCheck() {
        // Register prephoneCheck 1
        window.invPrephoneCheck = new PrephoneCheck({
            'inputSelector': 'input[name="invadr[oxuser__oxfon]"]',
            'format': [{$enderecocstrs.sPHONEFORMAT}],
            'endpoint': "[{$sitepath}]?cl=enderecocontroller"
        });

        // Register prephoneCheck 1
        window.delPrephoneCheck = new PrephoneCheck({
            'inputSelector': 'input[name="deladr[oxaddress__oxfon]"]',
            'format': [{$enderecocstrs.sPHONEFORMAT}],
            'endpoint': "[{$sitepath}]?cl=enderecocontroller"
        });

        // Register prephoneCheck 2
        window.invPrephoneCheck2 = new PrephoneCheck({
            'inputSelector': 'input[name="invadr[oxuser__oxfax]"]',
            'format': [{$enderecocstrs.sPHONEFORMAT}],
            'endpoint': "[{$sitepath}]?cl=enderecocontroller"
        });

        // Register prephoneCheck 2
        window.delPrephoneCheck2 = new PrephoneCheck({
            'inputSelector': 'input[name="deladr[oxaddress__oxfax]"]',
            'format': [{$enderecocstrs.sPHONEFORMAT}],
            'endpoint': "[{$sitepath}]?cl=enderecocontroller"
        });

        // Register prephoneCheck 3
        window.invPrephoneCheck3 = new PrephoneCheck({
            'inputSelector': 'input[name="invadr[oxuser__oxmobfon]"]',
            'format': [{$enderecocstrs.sPHONEFORMAT}],
            'endpoint': "[{$sitepath}]?cl=enderecocontroller"
        });

        // Register prephoneCheck 4
        window.invPrephoneCheck4 = new PrephoneCheck({
            'inputSelector': 'input[name="invadr[oxuser__oxprivfon]"]',
            'format': [{$enderecocstrs.sPHONEFORMAT}],
            'endpoint': "[{$sitepath}]?cl=enderecocontroller"
        });
    }

    /**
     * Wrapper function for status indicator initialization.
     */
    function initStatusIndicator() {
        [{if $oViewConf->getActiveTheme() == 'flow' }]
            // Register emailCheck Status indicator for invoice address
            setTimeout(function() {
                window.invNameCheckStatusIndicator = new StatusIndicator({
                    'inputSelector': 'input[name="invadr[oxuser__oxfname]"]',
                    'displaySelector': 'button[data-id="invadr_oxuser__oxfname"]',
                    'colors' : colorTheme,
                    'showIcons': true
                });
            }, 500);

            // Register emailCheck Status indicator for invoice address
            setTimeout(function() {
                window.delNameCheckStatusIndicator = new StatusIndicator({
                    'inputSelector': 'input[name="deladr[oxaddress__oxfname]"]',
                    'displaySelector': 'button[data-id="deladr_oxaddress__oxsal"]',
                    'colors' : colorTheme,
                    'showIcons': true
                });
            }, 500);
        [{else}]
            // Register emailCheck Status indicator for invoice address
            setTimeout(function() {
                window.invNameCheckStatusIndicator = new StatusIndicator({
                    'inputSelector': 'input[name="invadr[oxuser__oxfname]"]',
                    'displaySelector': 'select[name="invadr[oxuser__oxsal]"]',
                    'colors' : colorTheme,
                    'showIcons': true
                });
            }, 500);

            // Register emailCheck Status indicator for invoice address
            setTimeout(function() {
                window.delNameCheckStatusIndicator = new StatusIndicator({
                    'inputSelector': 'input[name="deladr[oxaddress__oxfname]"]',
                    'displaySelector': 'select[name="deladr[oxaddress__oxsal]"]',
                    'colors' : colorTheme,
                    'showIcons': true
                });
            }, 500);
        [{/if}]

        // Register emailCheck Status indicator for invoice address
        window.invEmailCheckStatusIndicator = new StatusIndicator({
            'inputSelector': '#userLoginName',
            'displaySelector': '#userLoginName',
            'colors' : colorTheme,
            'showIcons': true
        });

        // Register emailCheck Status indicator for invoice address
        window.invEmailCheckStatusIndicator2 = new StatusIndicator({
            'inputSelector': 'input[name="invadr[oxuser__oxusername]"]',
            'displaySelector': 'input[name="invadr[oxuser__oxusername]"]',
            'colors' : colorTheme,
            'showIcons': true
        });

        // Register emailCheck Status indicator for invoice address
        setTimeout(function() {
            window.invPrephoneCheck1StatusIndicator = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxfon]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxfon]"]',
                'colors' : colorTheme,
                'showIcons': true
            });
        }, 500);

        // Register emailCheck Status indicator for del address
        setTimeout(function() {
            window.invPrephoneCheck1StatusIndicator = new StatusIndicator({
                'inputSelector': 'input[name="deladr[oxaddress__oxfon]"]',
                'displaySelector': 'input[name="deladr[oxaddress__oxfon]"]',
                'colors' : colorTheme,
                'showIcons': true
            });
        }, 500);

        // Register emailCheck Status indicator for invoice address
        setTimeout(function() {
            window.invPrephoneCheck2StatusIndicator = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxfax]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxfax]"]',
                'colors' : colorTheme,
                'showIcons': true
            });
        }, 500);

        // Register emailCheck Status indicator for invoice address
        setTimeout(function() {
            window.delPrephoneCheck2StatusIndicator = new StatusIndicator({
                'inputSelector': 'input[name="deladr[oxaddress__oxfax]"]',
                'displaySelector': 'input[name="deladr[oxaddress__oxfax]"]',
                'colors' : colorTheme,
                'showIcons': true
            });
        }, 500);

        setTimeout(function() {
            window.invPrephoneCheck3StatusIndicator = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxmobfon]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxmobfon]"]',
                'colors' : colorTheme,
                'showIcons': true
            });
        }, 500);

        setTimeout(function() {
            window.invPrephoneCheck4StatusIndicator = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxprivfon]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxprivfon]"]',
                'colors' : colorTheme,
                'showIcons': true
            });
        }, 500);

        // Register postCodeAutocomplete Status indicator for invoice address
        setTimeout(function() {
            window.invPostCodeAutocompleteStatusIndicator = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxzip]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxzip]"]',
                'colors' : colorTheme,
                'showIcons': true
            });
        }, 500);

        // Register postCodeAutocomplete Status indicator for del address
        setTimeout(function() {
            window.delPostCodeAutocompleteStatusIndicator = new StatusIndicator({
                'inputSelector': 'input[name="deladr[oxaddress__oxzip]"]',
                'displaySelector': 'input[name="deladr[oxaddress__oxzip]"]',
                'colors' : colorTheme,
                'showIcons': true
            });
        }, 500);

        // Register postCodeAutocomplete Status indicator for invoice address
        setTimeout(function() {
            window.invCityNameAutocompleteStatusIndicator = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxcity]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxcity]"]',
                'colors' : colorTheme,
                'showIcons': true
            });
        }, 500);

        // Register postCodeAutocomplete Status indicator for del address
        setTimeout(function() {
            window.delCityNameAutocompleteStatusIndicator = new StatusIndicator({
                'inputSelector': 'input[name="deladr[oxaddress__oxcity]"]',
                'displaySelector': 'input[name="deladr[oxaddress__oxcity]"]',
                'colors' : colorTheme,
                'showIcons': true
            });
        }, 500);

        // Register postCodeAutocomplete Status indicator for invoice address
        setTimeout(function() {
            window.invStreetAutocompleteStatusIndicator = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxstreet]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxstreet]"]',
                'colors' : colorTheme,
                'showIcons': true
            });
        }, 500);

        // Register postCodeAutocomplete Status indicator for del address
        setTimeout(function() {
            window.delStreetAutocompleteStatusIndicator = new StatusIndicator({
                'inputSelector': 'input[name="deladr[oxaddress__oxstreet]"]',
                'displaySelector': 'input[name="deladr[oxaddress__oxstreet]"]',
                'colors' : colorTheme,
                'showIcons': true
            });
        }, 500);

        // Register house number Status indicator for invoice address
        setTimeout(function() {
            window.invHouseNumberStatusIndicator = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxstreetnr]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxstreetnr]"]',
                'colors' : colorTheme,
                'showIcons': true
            });
        }, 500);

        // Register house number Status indicator for invoice address
        setTimeout(function() {
            window.delHouseNumberStatusIndicator = new StatusIndicator({
                'inputSelector': 'input[name="deladr[oxaddress__oxstreetnr]"]',
                'displaySelector': 'input[name="deladr[oxaddress__oxstreetnr]"]',
                'colors' : colorTheme,
                'showIcons': true
            });
        }, 500);

        [{if $oViewConf->getActiveTheme() == 'flow' }]
            // Register house number Status indicator for invoice address
            setTimeout(function() {
                window.invCountryStatusIndicator = new StatusIndicator({
                    'inputSelector': 'select[name="invadr[oxuser__oxcountryid]"]',
                    'displaySelector': 'button[data-id="invCountrySelect"]',
                    'colors' : colorTheme,
                    'showIcons': true
                });
            }, 500);

            // Register house number Status indicator for invoice address
            setTimeout(function() {
                window.delCountryStatusIndicator = new StatusIndicator({
                    'inputSelector': 'select[name="deladr[oxaddress__oxcountryid]"]',
                    'displaySelector': 'button[data-id="delCountrySelect"]',
                    'colors' : colorTheme,
                    'showIcons': true
                });
            }, 500);
        [{else}]
            // Register house number Status indicator for invoice address
            setTimeout(function() {
                window.invCountryStatusIndicator = new StatusIndicator({
                    'inputSelector': 'select[name="invadr[oxuser__oxcountryid]"]',
                    'displaySelector': 'select[name="invadr[oxuser__oxcountryid]"]',
                    'colors' : colorTheme,
                    'showIcons': true
                });
            }, 500);

            // Register house number Status indicator for invoice address
            setTimeout(function() {
                window.delCountryStatusIndicator = new StatusIndicator({
                    'inputSelector': 'select[name="deladr[oxaddress__oxcountryid]"]',
                    'displaySelector': 'select[name="deladr[oxaddress__oxcountryid]"]',
                    'colors' : colorTheme,
                    'showIcons': true
                });
            }, 500);
        [{/if}]
    }

    /**
     * Accounting
     */
    function initAccounting() {
        // Register accounting service
        window.accounting = new Accounting({
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'groups': [
                {
                    'name': 'email',
                    'formSelector': '',
                    'fieldsSelectors': [
                        '#userLoginName',
                        'input[name="invadr[oxuser__oxusername]"]'
                    ],
                    'validationFunction': function(form) {
                        if (document.querySelectorAll('.alert-danger, .text-danger').length > 0) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                },
                {
                    'name': 'name_inv',
                    'formSelector': '',
                    'fieldsSelectors': [
                        'input[name="invadr[oxuser__oxfname]"]',
                        'select[name="invadr[oxuser__oxsal]"]'
                    ],
                    'validationFunction': function(form) {
                        if (document.querySelectorAll('.alert-danger, .text-danger').length > 0) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                },
                {
                    'name': 'phone_inv',
                    'formSelector': '',
                    'fieldsSelectors': [
                        'input[name="invadr[oxuser__oxfon]"]',
                        'input[name="invadr[oxuser__oxfax]"]',
                        'input[name="invadr[oxuser__oxmobfon]"]',
                        'input[name="invadr[oxuser__oxprivfon]"]'
                    ],
                    'validationFunction': function(form) {
                        if (document.querySelectorAll('.alert-danger, .text-danger').length > 0) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                },
                {
                    'name': 'addr_inv',
                    'formSelector': '',
                    'fieldsSelectors': [
                        'select[name="invadr[oxuser__oxcountryid]"]',
                        'input[name="invadr[oxuser__oxcity]"]',
                        'input[name="invadr[oxuser__oxzip]"]',
                        'input[name="invadr[oxuser__oxstreet]"]',
                        'input[name="invadr[oxuser__oxstreetnr]"]'
                    ],
                    'validationFunction': function(form) {
                        if (document.querySelectorAll('.alert-danger, .text-danger').length > 0) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                },
                {
                    'name': 'name_del',
                    'formSelector': '',
                    'fieldsSelectors': [
                        'input[name="deladr[oxaddress__oxfname]"]',
                        'select[name="deladr[oxaddress__oxsal]"]'
                    ],
                    'validationFunction': function(form) {
                        if (document.querySelectorAll('.alert-danger, .text-danger').length > 0) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                },
                {
                    'name': 'addr_del',
                    'formSelector': '',
                    'fieldsSelectors': [
                        'select[name="deladr[oxaddress__oxcountryid]"]',
                        'input[name="deladr[oxaddress__oxcity]"]',
                        'input[name="deladr[oxaddress__oxzip]"]',
                        'input[name="deladr[oxaddress__oxstreet]"]',
                        'input[name="deladr[oxaddress__oxstreetnr]"]'
                    ],
                    'validationFunction': function(form) {
                        if (document.querySelectorAll('.alert-danger, .text-danger').length > 0) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                },
                {
                    'name': 'phone_del',
                    'formSelector': '',
                    'fieldsSelectors': [
                        'input[name="deladr[oxaddress__oxfon]"]',
                        'input[name="deladr[oxaddress__oxfax]"]'
                    ],
                    'validationFunction': function(form) {
                        if (document.querySelectorAll('.alert-danger, .text-danger').length > 0) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                }
            ]
        });
    }
[{/capture}]
[{oxscript add=$serviceConfiguration}]
