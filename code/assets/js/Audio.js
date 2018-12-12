let audioElement;
let currentPlaylist = [];
let currentIndex = 0;

class Audio {
    constructor() {
        this.currentlyPlaying;
        this.audio = document.createElement('audio');
    }

    setSrc(track) {
        this.currentlyPlaying = track;
        this.audio.src = track.path;
    }

    play() {
        this.audio.play();
    }

    pause() {
        this.audio.pause();
    }

    setTime(seconds) {
        this.audio.currentTime = seconds;
    }
}