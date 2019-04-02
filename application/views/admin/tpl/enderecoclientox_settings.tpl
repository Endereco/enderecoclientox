[{include file="headitem.tpl" title="[ Endereco Einstellungen ]"}]
[{ if $readonly }]
    [{assign var="readonly" value="readonly disabled"}]
[{ else }]
    [{assign var="readonly" value=""}]
[{ /if }]

<link rel="stylesheet" href="[{$oViewConf->getModuleUrl("enderecoclientox", "out/admin/css/styles.css")}]">
<div class="endereco-admin-page">

<form name="myedit" id="myedit" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{$oViewConf->getHiddenSid()}]
    <input type="hidden" name="cl" value="enderecosettings" />
    <input type="hidden" name="fnc" value="" />
    <input type="hidden" name="oxid" value="[{$oxid}]" />

    <fieldset>
        <legend><strong>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_HEADLINE1"}]</strong></legend>
        <table class="ettm-table">
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_API_KEY"}]
                </td>
                <td>
                    <input type="text" class="editinput" size="60" maxlength="255" name="cstrs[sAPIKEY]" value="[{$cstrs.sAPIKEY}]">
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_API_KEY" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_STATUS"}]
                </td>
                <td>
                    [{if $cstrs.sCONNSTATUS == 1}]
                        <span class="endereco-green-status">
                            <strong>
                                [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_STATUS_OK"}]
                            </strong>
                            [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_STATUS_OK_LONG"}]
                            &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_SETTINGS_STATUS_OK_HELP" }]
                        </span>
                    [{else}]
                        <span class="endereco-red-status">
                            <strong>
                                [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL"}]
                            </strong>
                            [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL_LONG"}]
                            &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_SETTINGS_STATUS_FAIL_HELP" }]
                        </span>
                    [{/if}]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_ENDPOINT"}]
                </td>
                <td>
                    <select type="text" class="editinput" name="cstrs[sSERVICEURL]">
                        <option value="https://endereco-service.de/rpc/v1" [{if $cstrs.sSERVICEURL == 'https://endereco-service.de/rpc/v1'}]selected="selected"[{/if}]>https://endereco-service.de/rpc/v1 ([{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_ENDPOINT_LIVE"}])</option>
                        <option value="https://sandbox.endereco-service.de/rpc/v1" [{if $cstrs.sSERVICEURL == 'https://sandbox.endereco-service.de/rpc/v1'}]selected="selected"[{/if}]>https://sandbox.endereco-service.de/rpc/v1 ([{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_ENDPOINT_SANDBOX"}])</option>
                    </select>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_SOURCE" }]
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset>
        <legend><strong>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_ENDPOINT"}]</strong></legend>
        <table class="ettm-table">
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_STATUSINDICATOR"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" size="60" maxlength="255" name="cstrs[bSTATUSINDICATOR]" value="1" [{if $cstrs.bSTATUSINDICATOR == 1}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_STATUSINDICATOR" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_POSTCODEA"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" size="60" maxlength="255" name="cstrs[bPOSTCODEAUTOCOMPLETE]" value="1" [{if $cstrs.bPOSTCODEAUTOCOMPLETE == 1}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_POSTCODEAUTOCOMPLETE" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_CITYNAMEA"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" size="60" maxlength="255" name="cstrs[bCITYNAMEAUTOCOMPLETE]" value="1" [{if $cstrs.bCITYNAMEAUTOCOMPLETE == 1}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_CITYNAMEAUTOCOMPLETE" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_STREETA"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" size="60" maxlength="255" name="cstrs[bSTREETAUTOCOMPLETE]" value="1" [{if $cstrs.bSTREETAUTOCOMPLETE == 1}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_STREETAUTOCOMPLETE" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_EMAILCHECK"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" size="60" maxlength="255" name="cstrs[bEMAILCHECK]" value="1" [{if $cstrs.bEMAILCHECK == 1}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_EMAILCHECK" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_NAMECHECK"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" size="60" maxlength="255" name="cstrs[bNAMECHECK]" value="1" [{if $cstrs.bNAMECHECK == 1}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_NAMECHECK" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PREPHONECHECK"}]
                </td>
                <td>
                    <input id="endereco-prephone" type="checkbox" class="editinput" size="60" maxlength="255" name="cstrs[bPREPHONECHECK]" value="1" [{if $cstrs.bPREPHONECHECK == 1}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_PREPHONECHECK" }]
                </td>
            </tr>
            <tr id="endereco-prephoneformat" [{if $cstrs.bPREPHONECHECK != '1'}] style="display:none"[{/if}]>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT"}]
                </td>
                <td>
                    <select  type="text" class="editinput" name="cstrs[sPHONEFORMAT]">
                        <option value="0" [{if $cstrs.sPHONEFORMAT == '0'}]selected="selected"[{/if}]>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_0"}]</option>
                        <option value="1" [{if $cstrs.sPHONEFORMAT == '1'}]selected="selected"[{/if}]>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_1"}]</option>
                        <option value="2" [{if $cstrs.sPHONEFORMAT == '2'}]selected="selected"[{/if}]>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_2"}]</option>
                        <option value="3" [{if $cstrs.sPHONEFORMAT == '3'}]selected="selected"[{/if}]>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_3"}]</option>
                        <option value="4" [{if $cstrs.sPHONEFORMAT == '4'}]selected="selected"[{/if}]>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_4"}]</option>
                        <option value="5" [{if $cstrs.sPHONEFORMAT == '5'}]selected="selected"[{/if}]>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_5"}]</option>
                        <option value="6" [{if $cstrs.sPHONEFORMAT == '6'}]selected="selected"[{/if}]>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_6"}]</option>
                        <option value="7" [{if $cstrs.sPHONEFORMAT == '7'}]selected="selected"[{/if}]>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_7"}]</option>
                        <option value="8" [{if $cstrs.sPHONEFORMAT == '8'}]selected="selected"[{/if}]>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_8"}]</option>
                        <option value="9" [{if $cstrs.sPHONEFORMAT == '9'}]selected="selected"[{/if}]>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT_9"}]</option>
                    </select>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_PHONEFORMAT" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_ADDRESSCHECK"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" size="60" maxlength="255" name="cstrs[bADDRESSCHECK]" value="1" [{if $cstrs.bADDRESSCHECK == 1}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_ADDRESSCHECK" }]
                </td>
            </tr>
        </table>
    </fieldset>

    <script>
        var prephonefield = document.getElementById('endereco-prephone');
        var prephoneext = document.getElementById('endereco-prephoneformat');
        prephonefield.addEventListener('change', function() {
            if (this.checked) {
                prephoneext.style.display = 'table-row';
            } else {
                prephoneext.style.display = 'none';
            }
        })
    </script>

    <fieldset>
        <legend><strong>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_HEADLINE3"}]</strong></legend>
        <table class="ettm-table">
            <tr>
                <td></td>
                <td>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_COLOR_COL1"}]</td>
                <td>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_COLOR_COL2"}]</td>
                <td>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_COLOR_COL3"}]</td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PRIMARYCOLOR"}]
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sPRIMARYCOLOR]" value="[{$cstrs.sPRIMARYCOLOR}]">
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sPRIMARYCOLORHOVER]" value="[{$cstrs.sPRIMARYCOLORHOVER}]">
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sPRIMARYCOLORTEXT]" value="[{$cstrs.sPRIMARYCOLORTEXT}]">
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_SECONDARYCOLOR"}]
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sSECONDARYCOLOR]" value="[{$cstrs.sSECONDARYCOLOR}]">
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sSECONDARYCOLORHOVER]" value="[{$cstrs.sSECONDARYCOLORHOVER}]">
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sSECONDARYCOLORTEXT]" value="[{$cstrs.sSECONDARYCOLORTEXT}]">
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_WARNINGCOLOR"}]
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sWARNINGCOLOR]" value="[{$cstrs.sWARNINGCOLOR}]">
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sWARNINGCOLORHOVER]" value="[{$cstrs.sWARNINGCOLORHOVER}]">
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sWARNINGCOLORTEXT]" value="[{$cstrs.sWARNINGCOLORTEXT}]">
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_SUCCESSCOLOR"}]
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sSUCCESSCOLOR]" value="[{$cstrs.sSUCCESSCOLOR}]">
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sSUCCESSCOLORHOVER]" value="[{$cstrs.sSUCCESSCOLORHOVER}]">
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sSUCCESSCOLORTEXT]" value="[{$cstrs.sSUCCESSCOLORTEXT}]">
                </td>
            </tr>
        </table>
    </fieldset>

    <input type="submit" class="edittext" name="save" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[{oxmultilang ident="GENERAL_SAVE"}]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" onClick="Javascript:document.myedit.fnc.value='save'"><br>

</form>

</div>

[{include file="bottomitem.tpl"}]
