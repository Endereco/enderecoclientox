[{assign var="sitepath" value=$oViewConf->getBaseDir()}]

<script>
    var connectionListener;

    function initConfigs() {
        if (undefined === window.enderecoGlobal) {
            window.enderecoGlobal = {};
        }

        window.enderecoGlobal.colorsStatusIndicator = {
            'warningColor': '[{$enderecocstrs.sWARNINGCOLOR}]',
            'successColor': '[{$enderecocstrs.sSUCCESSCOLOR}]',
        };

        window.enderecoGlobal.colorsAddressCheck = {
            'primaryColor': '[{$enderecocstrs.sADDRESSSERVCOLOR31}]',
            'primaryColorHover': '[{$enderecocstrs.sADDRESSSERVCOLOR32}]',
            'primaryColorText': '#fff',
        };

        window.enderecoGlobal.colorsInputAssistant = {
            'secondaryColor': '[{$enderecocstrs.sADDRESSSERVCOLOR2}]',
        };

        [{assign var="addressCheckHeadText" value="ENDERECOCLIENTOX_ADDRESSCHECK_HEAD"|oxmultilangassign}]
        [{assign var="addressCheckButtonText" value="ENDERECOCLIENTOX_ADDRESSCHECK_BTN"|oxmultilangassign}]
        [{assign var="addressCheckArea1Text" value="ENDERECOCLIENTOX_ADDRESSCHECK_AREA1"|oxmultilangassign}]
        [{assign var="addressCheckArea2Text" value="ENDERECOCLIENTOX_ADDRESSCHECK_AREA2"|oxmultilangassign}]

        window.enderecoGlobal.texts = {
            'addressCheckHead': '[{$addressCheckHeadText|escape:quotes}]',
            'addressCheckButton': '[{$addressCheckButtonText|escape:quotes}]',
            'addressCheckArea1': '[{$addressCheckArea1Text|escape:quotes}]',
            'addressCheckArea2': '[{$addressCheckArea2Text|escape:quotes}]'
        };
    }

    function enSetCookie(name,value,days) {
        var expires = "";
        if (days) {
            var date = new Date();
            date.setTime(date.getTime() + (days*24*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    }
    function enGetCookie(name) {
        var nameEQ = name + "=";
        var ca = document.cookie.split(';');
        for(var i=0;i < ca.length;i++) {
            var c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        return null;
    }

    function checkConnection() {
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if(4 === xhr.readyState) {
                if ('connection_ok' === xhr.responseText) {
                    console.log('Connection to endereco service server is working.');
                    window.enderecoGlobal.connection = true;
                } else {
                    console.log('No connection to endereco service server.');
                    window.enderecoGlobal.connection = false;
                }
            }
        };
        xhr.open('GET', '[{$sitepath}]?cl=enderecoconnectioncontroller', true);
        xhr.send();
    }

    function initiateAddressServices() {
        var serviceGroupInv = [], serviceGroupDel= [];

        window.enderecoGlobal.countryAutocompleteInv = new CountryAutocomplete({
            'countrySelector': 'select[name="invadr[oxuser__oxcountryid]"]',
            'countryEndpoint': "[{$sitepath}]?cl=enderecocountrycontroller",
        });
        window.enderecoGlobal.countryAutocompleteInv.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        window.enderecoGlobal.countryAutocompleteDel = new CountryAutocomplete({
            'countrySelector': 'select[name="deladr[oxaddress__oxcountryid]"]',
            'countryEndpoint': "[{$sitepath}]?cl=enderecocountrycontroller",
        });
        window.enderecoGlobal.countryAutocompleteDel.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        window.enderecoGlobal.addressCheckInv = new AddressCheck({
            'streetSelector': 'input[name="invadr[oxuser__oxstreet]"]',
            'houseNumberSelector': 'input[name="invadr[oxuser__oxstreetnr]"]',
            'postCodeSelector': 'input[name="invadr[oxuser__oxzip]"]',
            'cityNameSelector': 'input[name="invadr[oxuser__oxcity]"]',
            'countrySelector': 'select[name="invadr[oxuser__oxcountryid]"]',
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'colors' : window.enderecoGlobal.colorsAddressCheck,
            'texts': window.enderecoGlobal.texts
        });
        window.enderecoGlobal.addressCheckInv.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        window.enderecoGlobal.addressCheckDel = new AddressCheck({
            'streetSelector': 'input[name="deladr[oxaddress__oxstreet]"]',
            'houseNumberSelector': 'input[name="deladr[oxaddress__oxstreetnr]"]',
            'postCodeSelector': 'input[name="deladr[oxaddress__oxzip]"]',
            'cityNameSelector': 'input[name="deladr[oxaddress__oxcity]"]',
            'countrySelector': 'select[name="deladr[oxaddress__oxcountryid]"]',
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'colors' : window.enderecoGlobal.colorsAddressCheck,
            'texts': window.enderecoGlobal.texts
        });
        window.enderecoGlobal.addressCheckDel.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        // Register postCodeAutocomplete for invoice address
        window.enderecoGlobal.postCodeAutocompleteInv = new PostCodeAutocomplete({
            'inputSelector': 'input[name="invadr[oxuser__oxzip]"]',
            'secondaryInputSelectors': {
                'cityName': 'input[name="invadr[oxuser__oxcity]"]',
                'country': 'select[name="invadr[oxuser__oxcountryid]"]'
            },
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'serviceGroup': serviceGroupInv,
            'colors' : window.enderecoGlobal.colorsInputAssistant
        });
        serviceGroupInv.push(window.enderecoGlobal.postCodeAutocompleteInv);
        window.enderecoGlobal.postCodeAutocompleteInv.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        // Register postCodeAutocomplete for del address
        window.enderecoGlobal.postCodeAutocompleteDel = new PostCodeAutocomplete({
            'inputSelector': 'input[name="deladr[oxaddress__oxzip]"]',
            'secondaryInputSelectors': {
                'cityName': 'input[name="deladr[oxaddress__oxcity]"]',
                'country': 'select[name="deladr[oxaddress__oxcountryid]"]'
            },
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'serviceGroup': serviceGroupDel,
            'colors' : window.enderecoGlobal.colorsInputAssistant
        });
        serviceGroupDel.push(window.enderecoGlobal.postCodeAutocompleteDel);
        window.enderecoGlobal.postCodeAutocompleteDel.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        // Register cityNameAutocomplete for invoice address
        window.enderecoGlobal.cityNameAutocompleteInv = new CityNameAutocomplete({
            'inputSelector': 'input[name="invadr[oxuser__oxcity]"]',
            'secondaryInputSelectors': {
                'postCode': 'input[name="invadr[oxuser__oxzip]"]',
                'country': 'select[name="invadr[oxuser__oxcountryid]"]'
            },
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'serviceGroup': serviceGroupInv,
            'colors' : window.enderecoGlobal.colorsInputAssistant
        });
        serviceGroupInv.push(window.enderecoGlobal.cityNameAutocompleteInv);
        window.enderecoGlobal.cityNameAutocompleteInv.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        // Register cityNameAutocomplete for del address
        window.enderecoGlobal.cityNameAutocompleteDel = new CityNameAutocomplete({
            'inputSelector': 'input[name="deladr[oxaddress__oxcity]"]',
            'secondaryInputSelectors': {
                'postCode': 'input[name="deladr[oxaddress__oxzip]"]',
                'country': 'select[name="deladr[oxaddress__oxcountryid]"]'
            },
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'serviceGroup': serviceGroupDel,
            'colors' : window.enderecoGlobal.colorsInputAssistant
        });
        serviceGroupDel.push(window.enderecoGlobal.cityNameAutocompleteDel);
        window.enderecoGlobal.cityNameAutocompleteDel.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        // Register streetAutocomplete for invoice address
        window.enderecoGlobal.streetAutocompleteInv = new StreetAutocomplete({
            'inputSelector': 'input[name="invadr[oxuser__oxstreet]"]',
            'secondaryInputSelectors': {
                'postCode': 'input[name="invadr[oxuser__oxzip]"]',
                'cityName': 'input[name="invadr[oxuser__oxcity]"]',
                'country': 'select[name="invadr[oxuser__oxcountryid]"]'
            },
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'serviceGroup': serviceGroupInv,
            'colors' : window.enderecoGlobal.colorsInputAssistant
        });
        serviceGroupInv.push(window.enderecoGlobal.streetAutocompleteInv);
        window.enderecoGlobal.streetAutocompleteInv.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        // Register streetAutocomplete for del address
        window.enderecoGlobal.streetAutocompleteDel = new StreetAutocomplete({
            'inputSelector': 'input[name="deladr[oxaddress__oxstreet]"]',
            'secondaryInputSelectors': {
                'postCode': 'input[name="deladr[oxaddress__oxzip]"]',
                'cityName': 'input[name="deladr[oxaddress__oxcity]"]',
                'country': 'select[name="deladr[oxaddress__oxcountryid]"]'
            },
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'serviceGroup': serviceGroupDel,
            'colors' : window.enderecoGlobal.colorsInputAssistant
        });
        serviceGroupDel.push(window.enderecoGlobal.streetAutocompleteDel);
        window.enderecoGlobal.streetAutocompleteDel.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        [{if $enderecocstrs.bADDRESSALWAYSCHECK == 1}]

        if (!enGetCookie('enderecoAdressChecked')) {
            var alwaysCheckInterval1 = setInterval( function() {
                if (window.enderecoGlobal.countryAutocompleteInv.ready) {
                    window.enderecoGlobal.addressCheckInv.startCheckProcess();
                    enSetCookie('enderecoAdressChecked', 1, 30);
                    clearInterval(alwaysCheckInterval1);
                }
            }, 200);

            var alwaysCheckInterval2 = setInterval( function() {
                if (window.enderecoGlobal.countryAutocompleteDel.ready) {
                    window.enderecoGlobal.addressCheckDel.startCheckProcess();
                    enSetCookie('enderecoAdressChecked', 1, 30);
                    clearInterval(alwaysCheckInterval2);
                }
            }, 200);
        }

        [{/if}]

        console.log(serviceGroupInv, serviceGroupDel);
    }

    function initiateEmailServices() {
        // Register emailCheck for invoice address
        window.enderecoGlobal.emailCheckAccount = new EmailCheck({
            'inputSelector': '#userLoginName',
            'endpoint': "[{$sitepath}]?cl=enderecocontroller"
        });
        window.enderecoGlobal.emailCheckAccount.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        // Register emailCheck for invoice address
        window.enderecoGlobal.emailCheckInv = new EmailCheck({
            'inputSelector': 'input[name="invadr[oxuser__oxusername]"]',
            'endpoint': "[{$sitepath}]?cl=enderecocontroller"
        });
        window.enderecoGlobal.emailCheckInv.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );
    }

    function initiateNameServices() {
        // Register nameCheck for invoice address
        // Fix for flow.
        [{if $oViewConf->getActiveTheme() == 'flow' }]
        window.enderecoGlobal.nameCheckInv = new NameCheck({
            'inputSelector': 'input[name="invadr[oxuser__oxfname]"]',
            'salutationElement': 'select[name="invadr[oxuser__oxsal]"]',
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'mapping': {
                'M': 'MR',
                'F': 'MRS',
                'N': '',
                'X': ''
            },
            'colors' : window.enderecoGlobal.colorTheme
        });
        // Bootstrap jquery change is not triggering change event properly, so we fix it here
        $('select[name="invadr[oxuser__oxsal]"]').change(function() {
            window.enderecoGlobal.nameCheckInv.checkSalutation().then( function($data) {
                window.enderecoGlobal.nameCheckInv.resetStatus($data);
            });
        });

        // Register nameCheck for delivery address
        window.enderecoGlobal.nameCheckDel = new NameCheck({
            'inputSelector': 'input[name="deladr[oxaddress__oxfname]"]',
            'salutationElement': 'select[name="deladr[oxaddress__oxsal]"]',
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'mapping': {
                'M': 'MR',
                'F': 'MRS',
                'N': '',
                'X': ''
            },
            'colors' : window.enderecoGlobal.colorTheme
        });
        // Bootstrap jquery change is not triggering change event properly, so we fix it here
        $('select[name="deladr[oxaddress__oxsal]"]').change(function() {
            window.enderecoGlobal.nameCheckDel.checkSalutation().then( function($data) {
                window.enderecoGlobal.nameCheckDel.resetStatus($data);
            });
        });
        [{else}]
        window.enderecoGlobal.nameCheckInv = new NameCheck({
            'inputSelector': 'input[name="invadr[oxuser__oxfname]"]',
            'salutationElement': 'select[name="invadr[oxuser__oxsal]"]',
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'mapping': {
                'M': 'MR',
                'F': 'MRS',
                'N': '',
                'X': ''
            },
            'colors' : window.enderecoGlobal.colorTheme
        });

        // Register nameCheck for delivery address
        window.enderecoGlobal.nameCheckDel = new NameCheck({
            'inputSelector': 'input[name="deladr[oxaddress__oxfname]"]',
            'salutationElement': 'select[name="deladr[oxaddress__oxsal]"]',
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'mapping': {
                'M': 'MR',
                'F': 'MRS',
                'N': '',
                'X': ''
            },
            'colors' : window.enderecoGlobal.colorTheme
        });
        [{/if}]

        window.enderecoGlobal.nameCheckInv.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );
        window.enderecoGlobal.nameCheckDel.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );
    }

    function initiatePhoneServices() {
        var serviceGroupInv = [], serviceGroupDel= [];

        // Register prephoneCheck 1
        window.enderecoGlobal.prephoneCheckInvFon = new PrephoneCheck({
            'inputSelector': 'input[name="invadr[oxuser__oxfon]"]',
            'format': [{$enderecocstrs.sPHONEFORMAT}],
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'serviceGroup': serviceGroupInv
        });
        serviceGroupInv.push(window.enderecoGlobal.prephoneCheckInvFon);
        window.enderecoGlobal.prephoneCheckInvFon.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        // Register prephoneCheck 2
        window.enderecoGlobal.prephoneCheckInvFax = new PrephoneCheck({
            'inputSelector': 'input[name="invadr[oxuser__oxfax]"]',
            'format': [{$enderecocstrs.sPHONEFORMAT}],
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'serviceGroup': serviceGroupInv
        });
        serviceGroupInv.push(window.enderecoGlobal.prephoneCheckInvFax);
        window.enderecoGlobal.prephoneCheckInvFax.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        // Register prephoneCheck 3
        window.enderecoGlobal.prephoneCheckInvMob = new PrephoneCheck({
            'inputSelector': 'input[name="invadr[oxuser__oxmobfon]"]',
            'format': [{$enderecocstrs.sPHONEFORMAT}],
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'serviceGroup': serviceGroupInv
        });
        serviceGroupInv.push(window.enderecoGlobal.prephoneCheckInvMob);
        window.enderecoGlobal.prephoneCheckInvMob.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        // Register prephoneCheck 4
        window.enderecoGlobal.prephoneCheckInvPriv = new PrephoneCheck({
            'inputSelector': 'input[name="invadr[oxuser__oxprivfon]"]',
            'format': [{$enderecocstrs.sPHONEFORMAT}],
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'serviceGroup': serviceGroupInv
        });
        serviceGroupInv.push(window.enderecoGlobal.prephoneCheckInvPriv);
        window.enderecoGlobal.prephoneCheckInvPriv.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        // Register prephoneCheck 1
        window.enderecoGlobal.prephoneCheckDelFon = new PrephoneCheck({
            'inputSelector': 'input[name="deladr[oxaddress__oxfon]"]',
            'format': [{$enderecocstrs.sPHONEFORMAT}],
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'serviceGroup': serviceGroupDel
        });
        serviceGroupDel.push(window.enderecoGlobal.prephoneCheckDelFon);
        window.enderecoGlobal.prephoneCheckDelFon.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );

        // Register prephoneCheck 2
        window.enderecoGlobal.prephoneCheckDelFax = new PrephoneCheck({
            'inputSelector': 'input[name="deladr[oxaddress__oxfax]"]',
            'format': [{$enderecocstrs.sPHONEFORMAT}],
            'endpoint': "[{$sitepath}]?cl=enderecocontroller",
            'serviceGroup': serviceGroupDel
        });
        serviceGroupDel.push(window.enderecoGlobal.prephoneCheckDelFax);
        window.enderecoGlobal.prephoneCheckDelFax.updateConfig(
            {
                'referer': window.enderecoGlobal.referer
            }
        );
    }

    function initiateStatusIndicator() {
        [{if $oViewConf->getActiveTheme() == 'flow' }]
        // Register emailCheck Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.nameCheckStatusIndicatorInv = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxfname]"]',
                'displaySelector': 'button[data-id="invadr_oxuser__oxfname"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register emailCheck Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.nameCheckStatusIndicatorDel = new StatusIndicator({
                'inputSelector': 'input[name="deladr[oxaddress__oxfname]"]',
                'displaySelector': 'button[data-id="deladr_oxaddress__oxsal"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);
        [{else}]
        // Register emailCheck Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.nameCheckStatusIndicatorInv = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxfname]"]',
                'displaySelector': 'select[name="invadr[oxuser__oxsal]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register emailCheck Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.nameCheckStatusIndicatorDel = new StatusIndicator({
                'inputSelector': 'input[name="deladr[oxaddress__oxfname]"]',
                'displaySelector': 'select[name="deladr[oxaddress__oxsal]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);
        [{/if}]

        // Register emailCheck Status indicator for invoice address
        window.enderecoGlobal.emailCheckStatusIndicatorInv = new StatusIndicator({
            'inputSelector': '#userLoginName',
            'displaySelector': '#userLoginName',
            'colors' : window.enderecoGlobal.colorsStatusIndicator,
            'showIcons': true
        });

        // Register emailCheck Status indicator for invoice address
        window.enderecoGlobal.emailCheckStatusIndicatorInv2 = new StatusIndicator({
            'inputSelector': 'input[name="invadr[oxuser__oxusername]"]',
            'displaySelector': 'input[name="invadr[oxuser__oxusername]"]',
            'colors' : window.enderecoGlobal.colorsStatusIndicator,
            'showIcons': true
        });

        // Register emailCheck Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.prephoneCheck1StatusIndicatorInv = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxfon]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxfon]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register emailCheck Status indicator for del address
        setTimeout(function() {
            window.enderecoGlobal.prephoneCheck1StatusIndicatorDel = new StatusIndicator({
                'inputSelector': 'input[name="deladr[oxaddress__oxfon]"]',
                'displaySelector': 'input[name="deladr[oxaddress__oxfon]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register emailCheck Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.prephoneCheckStatusIndicatorInv2 = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxfax]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxfax]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register emailCheck Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.prephoneCheckStatusIndicatorDel2 = new StatusIndicator({
                'inputSelector': 'input[name="deladr[oxaddress__oxfax]"]',
                'displaySelector': 'input[name="deladr[oxaddress__oxfax]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        setTimeout(function() {
            window.enderecoGlobal.prephoneCheckStatusIndicatorInv3 = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxmobfon]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxmobfon]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        setTimeout(function() {
            window.enderecoGlobal.prephoneCheckStatusIndicatorInv4 = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxprivfon]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxprivfon]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register postCodeAutocomplete Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.postCodeAutocompleteStatusIndicatorInv = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxzip]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxzip]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register postCodeAutocomplete Status indicator for del address
        setTimeout(function() {
            window.enderecoGlobal.postCodeAutocompleteStatusIndicatorDel = new StatusIndicator({
                'inputSelector': 'input[name="deladr[oxaddress__oxzip]"]',
                'displaySelector': 'input[name="deladr[oxaddress__oxzip]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register postCodeAutocomplete Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.cityNameAutocompleteStatusIndicatorInv = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxcity]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxcity]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register postCodeAutocomplete Status indicator for del address
        setTimeout(function() {
            window.enderecoGlobal.cityNameAutocompleteStatusIndicatorDel = new StatusIndicator({
                'inputSelector': 'input[name="deladr[oxaddress__oxcity]"]',
                'displaySelector': 'input[name="deladr[oxaddress__oxcity]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register postCodeAutocomplete Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.streetAutocompleteStatusIndicatorInv = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxstreet]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxstreet]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register postCodeAutocomplete Status indicator for del address
        setTimeout(function() {
            window.enderecoGlobal.streetAutocompleteStatusIndicatorDel = new StatusIndicator({
                'inputSelector': 'input[name="deladr[oxaddress__oxstreet]"]',
                'displaySelector': 'input[name="deladr[oxaddress__oxstreet]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register house number Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.houseNumberStatusIndicatorInv = new StatusIndicator({
                'inputSelector': 'input[name="invadr[oxuser__oxstreetnr]"]',
                'displaySelector': 'input[name="invadr[oxuser__oxstreetnr]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register house number Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.houseNumberStatusIndicatorDel = new StatusIndicator({
                'inputSelector': 'input[name="deladr[oxaddress__oxstreetnr]"]',
                'displaySelector': 'input[name="deladr[oxaddress__oxstreetnr]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        [{if $oViewConf->getActiveTheme() == 'flow' }]
        // Register house number Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.countryStatusIndicatorInv = new StatusIndicator({
                'inputSelector': 'select[name="invadr[oxuser__oxcountryid]"]',
                'displaySelector': 'button[data-id="invCountrySelect"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register house number Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.countryStatusIndicatorDel = new StatusIndicator({
                'inputSelector': 'select[name="deladr[oxaddress__oxcountryid]"]',
                'displaySelector': 'button[data-id="delCountrySelect"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);
        [{else}]
        // Register house number Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.countryStatusIndicatorInv = new StatusIndicator({
                'inputSelector': 'select[name="invadr[oxuser__oxcountryid]"]',
                'displaySelector': 'select[name="invadr[oxuser__oxcountryid]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);

        // Register house number Status indicator for invoice address
        setTimeout(function() {
            window.enderecoGlobal.countryStatusIndicatorDel = new StatusIndicator({
                'inputSelector': 'select[name="deladr[oxaddress__oxcountryid]"]',
                'displaySelector': 'select[name="deladr[oxaddress__oxcountryid]"]',
                'colors' : window.enderecoGlobal.colorsStatusIndicator,
                'showIcons': true
            });
        }, 500);
        [{/if}]

    }

    // Add connection listener
    connectionListener = setInterval(
        function() {
            if (window.enderecoGlobal.connection) {
                clearInterval(connectionListener);
                initConfigs();
                [{if $enderecocstrs.bADDRESSSERVICE == 1}] initiateAddressServices(); [{/if}]
                [{if $enderecocstrs.bEMAILSERVICE == 1}] initiateEmailServices(); [{/if}]
                [{if $enderecocstrs.bNAMESERVICE == 1}] initiateNameServices(); [{/if}]
                [{if $enderecocstrs.bPHONESERVICE == 1}] initiatePhoneServices(); [{/if}]
                [{if $enderecocstrs.bSTATUSINDICATOR == 1}] initiateStatusIndicator(); [{/if}]
            }
        },
        300
    );
    checkConnection();
</script>

