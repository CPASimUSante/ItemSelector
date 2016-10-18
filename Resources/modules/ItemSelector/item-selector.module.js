import angular from 'angular/index'

import 'angular-bootstrap'
import 'angular-ui-translation/angular-translation'
import 'angular-ui-resource-picker/angular-resource-picker'

import ItemSelectorController from './Controller/ItemSelectorController'
import ItemSelectorService from './Service/ItemSelectorService'
import ItemSelectorFormDirective from './Directive/ItemSelectorFormDirective'

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
//translations
.filter('trans', () => (string, domain = 'platform') =>
    Translator.trans(string, domain)
)
