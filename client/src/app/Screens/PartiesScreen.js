import TagifyHelper from "../TagifyHelper";
import $ from 'jquery';
import NET from "../NET";

export default class PartiesScreen {
    constructor() {
        this.element = document.querySelector('#parties-screen');
        this.tagsInput = new TagifyHelper($('#tags-s').get(0));

        let $template = $('#parties-screen .party-item');
        this.$partyItem = $template.clone();
        $template.remove();

        this.installListeners();
    }

    installListeners() {
        let self = this;

        $('#parties-screen .js-filter').click(function() {
            NET.send('partiesScreen.setFilter', {
               tags: self.tagsInput.tags
            });
        });

        $('#parties-screen .js-new-party').click(function() {
            NET.send('partiesScreen.startCreateNewParty');
        });


        $('#parties-screen .parties').on('click', 'button', function(){
            NET.send('partiesScreen.joinParty', {
                id: parseInt($(this).attr('data-id'))
            })
        });

        NET.receive('partiesScreen.setParties', function (options) {
            self.updateParties(options.parties)
        });

        NET.receive('partiesScreen.setAllTags', function (options) {
            self.tagsInput.suggestions = options.tags;
        });
    }

    updateParties(parties) {
        $('#parties-screen .party-item').each(function () {
            $(this).remove()
        });
        for (let party of parties) {
            this.appendPartyItem(party);
        }
    }

    appendPartyItem(party) {
        let $item = this.$partyItem.clone();
        $item.find('.card-header .card-title').text(party.name);
        $item.find('.card-header small').text(party.tags.join(', '));
        $item.find('.player1').text(party.player1 === false ? 'Ожидание...' : party.player1);
        $item.find('.player2').text(party.player2 === false ? 'Ожидание...' : party.player2)
        $item.find('button')
            .attr('data-id', party.id)
            .prop('disabled', party.player1 !== false && party.player2 !== false);
        $item.appendTo('#parties-screen .parties');
    }
}