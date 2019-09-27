<script type="text/javascript" src="[{$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/Promise.min.js')}]?v=1.0.0"></script>

<script type="text/javascript" src="[{$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/NameCheck.js')}]?v=1.3.0"></script>
<script type="text/javascript" src="[{$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/EmailCheck.js')}]?v=1.3.0"></script>
<script type="text/javascript" src="[{$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/PrephoneCheck.js')}]?v=1.3.1"></script>
<script type="text/javascript" src="[{$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/AddressCheck.js')}]?v=1.5.2"></script>
<script type="text/javascript" src="[{$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/CountryAutocomplete.js')}]?v=1.2.1"></script>
<script type="text/javascript" src="[{$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/PostCodeAutocomplete.js')}]?v=1.5.5"></script>
<script type="text/javascript" src="[{$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/CityNameAutocomplete.js')}]?v=1.5.3"></script>
<script type="text/javascript" src="[{$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/StreetAutocomplete.js')}]?v=1.5.3"></script>
<script type="text/javascript" src="[{$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/Accounting.js')}]?v=1.1.0"></script>
<script type="text/javascript" src="[{$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/StatusIndicator.js')}]?v=1.2.0"></script>


[{if $oViewConf->getActiveTheme() == 'flow' }]
<link rel="stylesheet" href="[{$oViewConf->getModuleUrl("enderecoclientox", "out/assets/css/flow_fix.css")}]">
[{/if}]

[{if $oViewConf->getActiveTheme() == 'wave' }]
<link rel="stylesheet" href="[{$oViewConf->getModuleUrl("enderecoclientox", "out/assets/css/wave_fix.css")}]">
[{/if}]

<script>
    window.enderecoGlobal = {
        connection: false,
        popUpId: ''
    }
</script>
<script>
    window.enderecoGlobal.referer = "[{$oView->getClassName()}]";
</script>

[{$smarty.block.parent}]
