import ItemSelectorController from './../Controller/ItemSelectorController'
import template from './../Partial/itemList.html'

export default class ItemListDirective {
  constructor() {
    this.restrict = 'A'
    this.template = template
    this.controller = ItemSelectorController
    this.controllerAs = 'isc'
    this.bindToController = true
  }
}
