let audioElement;


class Audio {
    constructor() {
        this.audio = document.createElement('audio');
    }

    setSrc(track) {
        this.audio.src = track.path;
    }

    play() {
        this.audio.play();
    }

    pause() {
        this.audio.pause();
    }
}