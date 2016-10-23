import ItemSelectorController from './../Controller/ItemSelectorController'
import template from './../Partial/tabContent.html'

export default class TabContentDirective {
  constructor() {
    this.restrict = 'A'
    this.template = template
    this.controller = ItemSelectorController
    // this.controllerAs = 'isc'
    // this.bindToController = true
  }
}
