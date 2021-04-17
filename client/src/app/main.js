import '../style/main.scss';
import NET from './NET'
import ScreensController from "./ScreensController";

window.net = NET;
let screensController = new ScreensController();

NET.emitReceive('screensController.showScreen', {
    screenName: 'userConfigScreen',
    hidePrev: true
});

let conn = new WebSocket('ws://localhost:8080');
conn.onopen = function(e) {
    console.log("Connection established!");
};

conn.onmessage = function(event) {
    let msg = JSON.parse(event.data);
    NET.emitReceive(msg.event, msg.options);
};

NET.sendHandler = function (event, options) {
    let msg = {
        event: event,
        options: options
    };
    conn.send(JSON.stringify(msg));
};