import angular from 'angular/index'

import 'angular-bootstrap'
import 'angular-ui-translation/angular-translation'
import 'angular-ui-resource-picker/angular-resource-picker'
//to use the 'url' service
import '#/main/core/fos-js-router/module'

import ItemSelectorController from './Controller/ItemSelectorController'
import ItemSelectorService from './Service/ItemSelectorService'
import ItemSelectorFormDirective from './Directive/ItemSelectorFormDirective'
import ItemsListDirective from './Directive/ItemsListDirective'
import ItemDisplayDirective from './Directive/ItemDisplayDirective'
import TabHeaderDirective from './Directive/TabHeaderDirective'
import TabContentDirective from './Directive/TabContentDirective'

angular
.module('ItemSelectorModule', [
  'ui.bootstrap',
  'ui.resourcePicker',
  'ui.fos-js-router',
])
.service('ItemSelectorService', ItemSelectorService)
.controller('ItemSelectorController', [
    '$scope',
    'url',
    'ItemSelectorService',
    ItemSelectorController
])
.directive('itemSelectorForm', [
    () => new ItemSelectorFormDirective()
])
.directive('itemsList', [
    () => new ItemsListDirective()
])
.directive('itemDisplay', [
    () => new ItemDisplayDirective()
])
.directive('tabHeader', [
    () => new TabHeaderDirective()
])
.directive('tabContent', [
    () => new TabContentDirective()
])
//translations
.filter('trans', () => (string, domain = 'platform') =>
    Translator.trans(string, domain)
)
.filter('trustAsResourceUrl', ['$sce', $sce => text => $sce.trustAsResourceUrl(text)])
//TODO : remove before merge
.filter('debug', function() {
  return function(input) {
    if (input === '') return 'empty string';
    return input ? input : ('' + input);
  };
})
