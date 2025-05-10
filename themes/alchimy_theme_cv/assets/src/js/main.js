import { initNav } from "./nav";
import './contact-form.js';

////
//// FUNCTIONS
////
const initBaseInteractivity = () => {
  initNav();
};

////
//// EVENTS
////
window.onload = initBaseInteractivity;
