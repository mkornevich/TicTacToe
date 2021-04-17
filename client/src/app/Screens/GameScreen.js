import NET from "../NET";
import $ from 'jquery'
import GameFieldController from "../GameField/GameFieldController";

export default class GameScreen {
    constructor() {
        this.element = document.querySelector('#game-screen');

        this.$status = $('#game-screen .js-status');
        this.$player1 = $('#game-screen .js-player1');
        this.$player2 = $('#game-screen .js-player2');
        this.fieldController = new GameFieldController($('#game-canvas').get(0));

        this.installListeners();
    }

    installListeners() {
        let self = this;

        this.fieldController.onNewStep = function (row, col) {
            NET.send('gameScreen.setStep', {row: row, col: col});
        };

        $('#game-screen .js-leave').click(function () {
            NET.send('gameScreen.leaveParty');
        });

        NET.receive('gameScreen.updateState', function (options) {
            self.commonHandler(options);
            self[options.state + "Handler"](options);
        });
    }

    waitingJoinHandler(options) {
        this.$status.text('Ожидание участников...');
        this.fieldController.enabled = false;
    }

    waitingStepHandler(options) {
        let isMyStep = options.you === options.whoStep;
        this.$status.text(isMyStep ? 'Ваш ход.' : 'Ожидание хода противника...');
        this.fieldController.enabled = isMyStep;
    }


    gameFinishedHandler(options) {
        this.$status.text('Игра окончена.');
        this.fieldController.enabled = false;
    }

    commonHandler(options) {
        this.$player1.text(options.player1 === false ? 'Ожидание...' : options.player1);
        this.$player2.text(options.player2 === false ? 'Ожидание...' : options.player2);
        this.fieldController.field = options.field;
        this.fieldController.win = options.win;
    }


}