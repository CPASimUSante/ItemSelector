import angular from 'angular/index'

import 'angular-bootstrap'
import 'angular-ui-translation/angular-translation'
import 'angular-ui-resource-picker/angular-resource-picker'

import ItemSelectorController from './Controller/ItemSelectorController'
import ItemSelectorService from './Service/ItemSelectorService'
import ItemSelectorFormDirective from './Directive/ItemSelectorFormDirective'
import ItemsListDirective from './Directive/ItemsListDirective'

angular
.module('ItemSelectorModule', [
  'ui.bootstrap',
  'ui.resourcePicker',
])
.service('ItemSelectorService', ItemSelectorService)
.controller('ItemSelectorController', [
    'ItemSelectorService',
    ItemSelectorController
])
.directive('itemSelectorForm', [
    () => new ItemSelectorFormDirective()
])
.directive('itemsList', [
    () => new ItemsListDirective()
])
//translations
.filter('trans', () => (string, domain = 'platform') =>
    Translator.trans(string, domain)
)
//TODO : remove before merge
.filter('debug', function() {
  return function(input) {
    if (input === '') return 'empty string';
    return input ? input : ('' + input);
  };
})
