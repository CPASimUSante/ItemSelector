import ItemSelectorController from './../Controller/ItemSelectorController'
import template from './../Partial/itemsList.html'

export default class ItemsListDirective {
  constructor() {
    this.restrict = 'A'
    this.template = template
    // this.controller = ItemSelectorController
    // this.controllerAs = 'isc'
    // this.bindToController = true
  }
}
