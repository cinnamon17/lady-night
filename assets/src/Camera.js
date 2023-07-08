export default class Camera {

    video = document.querySelector('video');

    checkDeviceSuport(){

        if ('mediaDevices' in navigator && 'getUserMedia' in navigator.mediaDevices) {
            return true
        }else{
            return false;
        }
    }

    requestUserPermission(){

        navigator.mediaDevices.getUserMedia({video: true})

    }

    async startStream(constraints){

        let buffer = [];
        if(this.video != null){
        this.requestUserPermission();
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
            this.video.srcObject = stream;

            const videoTrack = stream.getVideoTracks();
            const audioTrack = stream.getAudioTracks();

            console.log(videoTrack[0]);

        }
    }

}
