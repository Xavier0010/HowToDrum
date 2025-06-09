function Timer(callback, timeInterval, options) {
    this.timeInterval = timeInterval;

    this.start = () => {
        this.expected = Date.now() + this.timeInterval;
        this.theTimeOut = null;

        if (options.immediate) {
            callback();
        }

        this.timeOut = setTimeout(this.round, this.timeInterval);
        console.log('Timer Started');
    }

    this.stop = () => {
        clearTimeout(this.timeOut);
        console.log('Timer Stopped');
    }

    this.round = () => {
        console.log('timeOut', this.timeOut);
        let drift = Date.now() - this.expected;
        if (drift > this.timeInterval) {
            if (options.errorCallback) {
                options.errorCallback();
            }
        }

        callback();
        this.expected += this.timeInterval;
        console.log('Drift:', drift);
        console.log('Next round time interval:', this.timeInterval - drift);
        this.timeOut = setTimeout(this.round, this.timeInterval - drift);
    }
}

export default Timer;