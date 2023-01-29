/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.css';
import Camera from './src/Camera.js';
import Config from './src/Config.js';

// start the Stimulus application
import './bootstrap';

function main() {

    const camera = new Camera;
    const config = new Config;

    if(camera.checkDeviceSuport()){
        camera.startStream(config.constraints);

    }

}

main();
