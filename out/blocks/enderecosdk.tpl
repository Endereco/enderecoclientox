[{oxscript include=$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/NameCheck.js')}]
[{oxscript include=$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/EmailCheck.js')}]
[{oxscript include=$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/PrephoneCheck.js')}]
[{oxscript include=$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/AddressCheck.js')}]
[{oxscript include=$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/PostCodeAutocomplete.js')}]
[{oxscript include=$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/CityNameAutocomplete.js')}]
[{oxscript include=$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/StreetAutocomplete.js')}]
[{oxscript include=$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/Accounting.js')}]
[{oxscript include=$oViewConf->getModuleUrl('enderecoclientox', 'out/endereco-sdk/services/StatusIndicator.js')}]

[{if $oViewConf->getActiveTheme() == 'flow' }]
<link rel="stylesheet" href="[{$oViewConf->getModuleUrl("enderecoclientox", "out/assets/css/flow_fix.css")}]">
[{/if}]

[{if $oViewConf->getActiveTheme() == 'wave' }]
<link rel="stylesheet" href="[{$oViewConf->getModuleUrl("enderecoclientox", "out/assets/css/wave_fix.css")}]">
[{/if}]

[{oxid_include_widget cl="enderecoincludewidget"}]

[{$smarty.block.parent}]
