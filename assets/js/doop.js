import '../css/doop.scss';
import bsCustomFileInput from "bs-custom-file-input";

const $ = require('jquery');

require('bootstrap');

$(document).ready(function () {
    bsCustomFileInput.init()
});
