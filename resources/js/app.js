import './bootstrap';

import Alpine from 'alpinejs';
import getData from "./getData.js";

window.Alpine = Alpine;
Alpine.data('getData', getData)
Alpine.start();
