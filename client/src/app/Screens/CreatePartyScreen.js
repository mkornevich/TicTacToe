import TagifyHelper from "../TagifyHelper";
import $ from 'jquery'
import NET from "../NET";

export default class CreatePartyScreen {
    constructor() {
        this.element = document.querySelector('#create-party-screen');
        this.tagsInput = new TagifyHelper($('#create-party-tags').get(0));

        this.installListeners();
    }

    installListeners() {
        let self = this;

        $('#create-party-screen .js-create-and-join').click(function() {
            NET.send('createPartyScreen.createNewParty', {
                tags: self.tagsInput.tags,
                name: $('#party-name').val()
            });
        });

        NET.receive('createPartyScreen.setAllTags', function (options) {
            self.tagsInput.suggestions = options.tags;
        });
    }
}