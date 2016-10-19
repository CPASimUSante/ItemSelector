import ItemSelectorController from './../Controller/ItemSelectorController'
import template from './../Partial/itemDisplay.html'

export default class ItemDisplayDirective {
  constructor() {
    this.restrict = 'E'
    this.replace = true
    this.template = template
    this.controller = ItemSelectorController
    // this.controllerAs = 'isc'
    // this.bindToController = true
  }
}
