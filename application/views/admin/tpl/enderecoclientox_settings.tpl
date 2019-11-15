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
            <tr style="display: none;">
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_ENDPOINT"}]
                </td>
                <td>
                    <input type="text" class="editinput" name="cstrs[sSERVICEURL]" readonly value="[{$cstrs.sSERVICEURL}]">
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_SOURCE" }]
                </td>
            </tr>
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_KEEP"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" name="cstrs[bKEEPSETTINGS]" value="true" [{if $cstrs.bKEEPSETTINGS == true}]checked="checked"[{/if}]>
                </td>
            </tr>
        </table>
    </fieldset>

    <fieldset>
        <legend><strong>[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_ENDPOINT"}]</strong></legend>
        <table class="ettm-table">
            <!-- START Status Indicator . -->
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_STATUSINDICATOR"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" size="60" maxlength="255" name="cstrs[bSTATUSINDICATOR]" id="endereco-statusindicator" value="true" [{if $cstrs.bSTATUSINDICATOR == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_STATUSINDICATOR" }]
                </td>
            </tr>
            <tr [{if $cstrs.bSTATUSINDICATOR != true}]style="display:none;"[{/if}] class="endereco-colors">
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_SUCCESSCOLOR"}]
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sSUCCESSCOLOR]" value="[{$cstrs.sSUCCESSCOLOR}]">
                </td>
            </tr>
            <tr [{if $cstrs.bSTATUSINDICATOR != true}]style="display:none;"[{/if}] class="endereco-colors">
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_WARNINGCOLOR"}]
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sWARNINGCOLOR]" value="[{$cstrs.sWARNINGCOLOR}]">
                </td>
            </tr>
            <!-- END Status Indicator -->

            <!-- START Addresses Service -->
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_ADDRESSSERVICE"}]
                </td>
                <td>
                    <input type="checkbox" id="endereco-adressservices" class="editinput" size="60" maxlength="255" name="cstrs[bADDRESSSERVICE]" value="true" [{if $cstrs.bADDRESSSERVICE == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_ADDRESSSERVICE" }]
                </td>
            </tr>
            <tr [{if $cstrs.bADDRESSSERVICE != true}]style="display:none;"[{/if}] class="endereco-adressservicesext">
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_ALWAYSCHECK"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" size="60" maxlength="255" name="cstrs[bADDRESSALWAYSCHECK]" value="true" [{if $cstrs.bADDRESSALWAYSCHECK == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_ALWAYSCHECK" }]
                </td>
            </tr>
            <!-- deactivated untill its possible to define dropdown colorvalue for autocomplete services -->
            <!--<tr [{if $cstrs.bADDRESSSERVICE != true}]style="display:none;"[{/if}] class="endereco-adressservicesext">
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_ADRESSSERV_COLOR1"}]
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sADDRESSSERVCOLOR1]" value="[{$cstrs.sADDRESSSERVCOLOR1}]">
                </td>
            </tr>-->
            <tr [{if $cstrs.bADDRESSSERVICE != true}]style="display:none;"[{/if}] class="endereco-adressservicesext">
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_ADRESSSERV_COLOR2"}]
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sADDRESSSERVCOLOR2]" value="[{$cstrs.sADDRESSSERVCOLOR2}]">
                </td>
            </tr>
            <tr [{if $cstrs.bADDRESSSERVICE != true}]style="display:none;"[{/if}] class="endereco-adressservicesext">
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_ADRESSSERV_COLOR3"}]
                </td>
                <td>
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sADDRESSSERVCOLOR31]" value="[{$cstrs.sADDRESSSERVCOLOR31}]">/
                    <input type="color" class="editinput" size="60" maxlength="255" name="cstrs[sADDRESSSERVCOLOR32]" value="[{$cstrs.sADDRESSSERVCOLOR32}]">
                </td>
            </tr>
            <!-- END Addresses Service -->

            <!-- START Email Service -->
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_EMAILSERVICE"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" size="60" maxlength="255" name="cstrs[bEMAILSERVICE]" value="true" [{if $cstrs.bEMAILSERVICE == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_EMAILSERVICE" }]
                </td>
            </tr>
            <!-- END Addresses Service -->

            <!-- START Name Service -->
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_NAMESERVICE"}]
                </td>
                <td>
                    <input type="checkbox" class="editinput" size="60" maxlength="255" name="cstrs[bNAMESERVICE]" value="true" [{if $cstrs.bNAMESERVICE == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_NAMESERVICE" }]
                </td>
            </tr>
            <!-- END Name Service -->

            <!-- START Phone Service -->
            <tr>
                <td>
                    [{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PHONESERVICE"}]
                </td>
                <td>
                    <input type="checkbox" id="endereco-phoneservice" class="editinput" size="60" maxlength="255" name="cstrs[bPHONESERVICE]" value="true" [{if $cstrs.bPHONESERVICE == true}]checked="checked"[{/if}]>
                    &nbsp;[{ oxinputhelp ident="ENDERECOCLIENTOX_HELP_PHONESERVICE" }]
                </td>
            </tr>
            <tr [{if $cstrs.bPHONESERVICE != true}]style="display:none;"[{/if}] class="endereco-phoneserviceformat">
                <td>
                    &nbsp;&nbsp;&nbsp;&nbsp;[{oxmultilang ident="ENDERECOCLIENTOX_SETTINGS_PHONEFORMAT"}]
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
            <!-- END Phone Service -->
        </table>
    </fieldset>
    <script>
        var statusfield = document.getElementById('endereco-statusindicator');
        var statusext = document.querySelectorAll('.endereco-colors');
        statusfield.addEventListener('change', function() {
            if (this.checked) {
                statusext.forEach( function(element) {
                    element.style.display = 'table-row';
                });
            } else {
                statusext.forEach( function(element) {
                    element.style.display = 'none';
                });
            }
        });
    </script>
    <script>
        var prephonefield = document.getElementById('endereco-phoneservice');
        var prephoneext = document.querySelectorAll('.endereco-phoneserviceformat');
        prephonefield.addEventListener('change', function() {
            if (this.checked) {
                prephoneext.forEach( function(element) {
                    element.style.display = 'table-row';
                });
            } else {
                prephoneext.forEach( function(element) {
                    element.style.display = 'none';
                });
            }
        });
    </script>
    <script>
        var addresfield = document.getElementById('endereco-adressservices');
        var addresext = document.querySelectorAll('.endereco-adressservicesext');
        addresfield.addEventListener('change', function() {
            if (this.checked) {
                addresext.forEach( function(element) {
                    element.style.display = 'table-row';
                });
            } else {
                addresext.forEach( function(element) {
                    element.style.display = 'none';
                });
            }
        })
    </script>

    <input type="submit" class="edittext" name="save" value="&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[{oxmultilang ident="GENERAL_SAVE"}]&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" onClick="Javascript:document.myedit.fnc.value='save'"><br>

</form>

</div>

[{include file="bottomitem.tpl"}]
