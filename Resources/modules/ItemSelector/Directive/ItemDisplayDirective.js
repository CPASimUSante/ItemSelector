import ItemSelectorController from './../Controller/ItemSelectorController'
import template from './../Partial/itemDisplay.html'

export default class ItemDisplayDirective {
  constructor() {
    this.restrict = 'E'
    this.replace = true
    this.controller = ItemSelectorController
    this.controllerAs = 'isc'
    this.template = template
    this.bindToController = true
  }
}
