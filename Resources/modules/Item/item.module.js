import angular from 'angular/index'

import 'angular-bootstrap'
import 'angular-ui-translation/angular-translation'

// import '../../../../../../../../claroline/main/core/Resources/modules/services/module'
// //form components
// import '../../../../../../../../claroline/main/core/Resources/modules/form/module'

import ItemService from './Service/ItemService'
import ItemCtrl from './Controller/ItemController'

angular
.module('ItemModule', [
  'ui.bootstrap'
])
.service('ItemService', ItemService)
.controller('ItemController', [
    'ItemService',
    itemController
])
//translations
.filter('trans', () => (string, domain = 'platform') =>
    Translator.trans(string, domain)
)
