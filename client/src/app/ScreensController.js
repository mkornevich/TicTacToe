import UserConfigScreen from "./Screens/UserConfigScreen";
import PartiesScreen from "./Screens/PartiesScreen";
import CreatePartyScreen from "./Screens/CreatePartyScreen";
import GameScreen from "./Screens/GameScreen";
import MessageScreen from "./Screens/MessageScreen";
import NET from "./NET";

export default class ScreensController {
    constructor() {
        this.screens = {
            userConfigScreen: new UserConfigScreen(),
            partiesScreen: new PartiesScreen(),
            createPartyScreen: new CreatePartyScreen(),
            gameScreen: new GameScreen(),
            messageScreen: new MessageScreen()
        };

        let self = this;
        NET.receive('screensController.showScreen', (options) => {
            self.show(options.screenName, options.hidePrev)
        });
    }

    show(screenName, hidePrev = true) {
        if (hidePrev) {
            this.hideScreens();
        }
        this.screens[screenName].element.classList.remove('hide');
    }

    hideScreens() {
        for (let screen of Object.values(this.screens)) {
            screen.element.classList.add('hide');
        }
    }
}