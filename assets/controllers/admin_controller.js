import { Controller } from 'stimulus';
const $ = require('jquery');
require('bootstrap');

/*
 * This is an example Stimulus controller!
 *
 * Any element with a data-controller="hello" attribute will cause
 * this controller to be executed. The name "hello" comes from the filename:
 * hello_controller.js -> "hello"
 *
 * Delete this file or adapt it for your use!
 */
export default class extends Controller {
    connect() {
        // this.element.textContent = 'Hello Stimulus! Edit me in assets/controllers/hello_controller.js';
        $(".leftArrow").on('click', function () {
            console.log('works')
            const leftPos = $('.show').scrollLeft();
            $(".show").animate({scrollLeft: leftPos - 300}, 100);
          });
          
        $(".rightArrow").on('click', function () {
            const leftPos = $('.show').scrollLeft();
            $('.show').scrollLeft(leftPos + 150);
        });
      
      $('.modalbtn').on('click', function () {
        console.log("modal")
      $('#horairesModal').modal('show')
    })
    }
  

  
}
