//the template for modals
//import addCategoryTemplate from '../Partial/modalAddCategory.html'

export default class ItemController {
    //no import of Angular stuff ($window, $scope…)
    constructor(ItemService) {
        //declaration of variables
        this.currentCategory    = {}
        this.currentParent      = null
        this.addedCategory      = {}
        this.editedCategory     = {}
        //variable containing the category to be deleted
        this._deletedCategory   = null
        this.errors             = []
        this.errorMessage       = null
        this._service           = ItemService
    }
}
