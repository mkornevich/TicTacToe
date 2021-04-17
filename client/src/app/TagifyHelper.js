import Tagify from '@yaireo/tagify'

export default class TagifyHelper {

    set tags(value) {
        this.tagify.addTags(value);
    }

    set suggestions(value) {
        this.tagify.settings.whitelist = value;
    }

    get tags() {
        return this.tagify.getTagElms().map(el => el.innerText);
    }

    constructor(element) {
        this.tagify = new Tagify(element, {
            maxTags: 5,
            dropdown: {
                maxItems: 5,
                enabled: 0,
                closeOnSelect: false
            }
        });
    }
}