import { Controller } from 'stimulus';
// import $ from 'jquery';
var $  = require( 'jquery' );
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
      });
      $('.backButton').on('click', function () {
        console.log('back');
        window.history.back();
      })

      function replaceClass(el, oldClass, newClass) {
        const element = $(`.${el}`);
        if (element.hasClass(oldClass)) {
          element.removeClass(oldClass)
        }
        element.addClass(newClass)
    }

      $('.prev').on('click', function (e) {
        e.preventDefault();
        replaceClass("first-part", "d-none", "d-block")
        replaceClass("second-part", "d-block", "d-none")
        replaceClass("prev", "visible", "invisible")
        replaceClass("next", "invisible", "visible")
        replaceClass("envoi", 'd-block', 'd-none')
        replaceClass("continue", 'd-block', 'd-none')
      })

      $('.next').on('click', function (e) {
        e.preventDefault();
        replaceClass("first-part", "d-block",  "d-none" )
        replaceClass("second-part", "d-none", "d-block")
        replaceClass("prev", "invisible", "visible")
        replaceClass("next", 'visible', 'invisible')
      })
    
     
   
      $('.biblio-select select').on('change', function () {
       
          if ($('.biblio-select select option:selected').val() == "oui") {
            replaceClass("continue", 'd-none', 'd-block')
            replaceClass("envoi", 'd-block', 'd-none')
            replaceClass("next", 'invisible', 'd-none')

            
          } else if($('.biblio-select select option:selected').val() == "non") {
            replaceClass("envoi", 'd-none', 'd-block')
            replaceClass("continue", 'd-block', 'd-none')
            replaceClass("next", 'invisible', 'd-none')

            
          } else {
            replaceClass("next", 'd-none', 'invisible')
            replaceClass("envoi", 'd-block', 'd-none')
            replaceClass("continue", 'd-block', 'd-none')
          
        } 
  })
  
      $('.continue').on('click', function () {
    replaceClass("prev", 'padding-footer', 's-padding')

  })
      
   
      
      
      
    }
   
}
