class NET {

    debug = true;

    receivers = [];

    sendHandler = function (event, options) {
    };

    receive(event, callback) {
        this.receivers.push({
            event: event,
            callback: callback,
        })
    }

    emitReceive(event, options = {}) {

        for (let receiver of this.receivers) {
            if (receiver.event === event) {
                if (this.debug) {
                    console.log("NET RECEIVE: ", event, options);
                }
                receiver.callback(options);
            }
        }
    }

    send(event, options = {}) {
        if (this.debug) {
            console.log("NET SEND: ", event, options);
        }
        this.sendHandler(event, options);
    }
}

export default new NET();