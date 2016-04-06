# What is it ?
This resource allows to display a number of resources (exercises)
* First, you select the main resource to be attached.
* Then, you add one or several items (exercises resources)

When you save it, elements are displayed accordingly, and you can perform the exercises

# How to configure :
* mainResourceType : the resourceId in claro_resource_type of the main resource you want to attach  
* resourceType : the resourceId in claro_resource_type of the items you allow to Add
* namePattern : the pattern in the resourcename to be recognized as resourceType. It can be useful if for instance you choose Exercise, and you have 20 exercises in you WS, only the ones containing namePattern will be selected
    eg : for resource-name1, custom-resource-name2, resource-name3
    if namePattern is "custom", then only custom-resource-name2 will be displayed.
