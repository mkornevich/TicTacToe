import $ from 'jquery'
import NET from "../NET";

export default class MessageScreen {
    constructor() {
        this.element = document.querySelector('#message-screen');

        $('#message-screen .js-close').click(function () {
            $('#message-screen').addClass('hide');
        });

        NET.receive('messageScreen.setMessage', options => {
            $('#message-screen .js-message').html(options.message)
        });
    }
}