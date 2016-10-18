/**
 * Manages Path form
 */
import ItemSelectorController from './../Controller/ItemSelectorController'
import template from './../Partial/itemSelectorForm.html'

export default class ItemSelectorFormDirective {
  constructor() {
    this.restrict = 'E'
    this.replace = true
    this.controller = ItemSelectorController
    this.controllerAs = 'isc'
    this.template = template
    this.bindToController = true
  }
}
