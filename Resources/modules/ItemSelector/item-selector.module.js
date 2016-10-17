import angular from 'angular/index'

import 'angular-bootstrap'
import 'angular-ui-translation/angular-translation'

// import '../../../../../../claroline/main/core/Resources/modules/services/module'
// //form components
// import '../../../../../../claroline/main/core/Resources/modules/form/module'

import ItemSelectorService from './Service/ItemSelectorService'
import ItemSelectorFormDirective from './Directive/ItemSelectorFormDirective'
import ItemSelectorController from './Controller/ItemSelectorController'

angular
.module('ItemSelectorModule', [
  'ui.bootstrap'
])
.service('ItemSelectorService', ItemSelectorService)
.directive('itemSelectorForm', [
    () => new ItemSelectorFormDirective('PeriodController')
])
.controller('ItemSelectorController', [
    'ItemSelectorService',
    ItemSelectorController
])
//translations
.filter('trans', () => (string, domain = 'platform') =>
    Translator.trans(string, domain)
)
