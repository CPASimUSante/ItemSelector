import ItemSelectorController from './../Controller/ItemSelectorController'
import template from './../Partial/tabHeader.html'

export default class TabHeaderDirective {
  constructor() {
    this.restrict = 'A'
    this.template = template
    this.controller = ItemSelectorController
    // this.controllerAs = 'isc'
    // this.bindToController = true
  }
}
