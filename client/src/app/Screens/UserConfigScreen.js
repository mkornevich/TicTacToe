import $ from 'jquery'
import NET from "../NET";

export default class UserConfigScreen {
    constructor() {
        this.element = document.querySelector('#user-config-screen');
        $('#user-config-screen .js-join').click(() => {
            NET.send('userConfigScreen.setUserConfig', {
               name: $('#nickname').val()
            });
        });
    }
}