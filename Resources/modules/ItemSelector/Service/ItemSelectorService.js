/*global Routing*/
/*global Translator*/
//import documentSelectionTemplate from '../Partial/document_model_selection_modal.html'

export default class ItemSelectorService {
  constructor ($http, $uibModal) {
    this.$http = $http
    this.$uibModal = $uibModal
  }

  getMainResource() {
    let resource = {}
    return resource
  }

  getItems() {
    let items = {}
    return items
  }
}
