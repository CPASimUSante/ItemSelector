//the template for modals
//import addCategoryTemplate from '../Partial/modalAddCategory.html'

export default class ItemSelectorController {
    //no import of Angular stuff ($window, $scope…)
    constructor(ItemSelectorService) {
        //declaration of variables
        this.forms              = ItemSelectorService.getPeriods()
        this.errors             = []
        this.errorMessage       = null
        this._service           = ItemSelectorService
    }
}
