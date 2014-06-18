/*jslint browser:true*/
/*globals $, define*/

/**
 *  Polyfill for console debugger
 *  Since any jquery plugin will be placed here,
 *  we call jQuery as a parameter
 *
 *  @module plugin
 */

define(["jquery"], function ($) {

  /**
   *  Strict mode
   *  more infos at :
   *  http://ejohn.org/blog/ecmascript-5-strict-mode-json-and-more/
   *
   *  @property strict mode
   *  @type {String}
   *  @default "use strict"
   */
  "use strict";

  /**
   *  For maintanibility, it's better to regroup the var at the top
   *  of the file.
   *  This does not affect performance.
   */
  var method, methods,
    noop,
    length, console;

  /**
   *  Empty block
   *  @method noop
   */
  noop = function () {
  };

  /**
   * Define the console methods
   * @property methods
   *
   */
  methods = [
      'assert', 'clear', 'count', 'debug', 'dir', 'dirxml', 'error',
      'exception', 'group', 'groupCollapsed', 'groupEnd', 'info', 'log',
      'markTimeline', 'profile', 'profileEnd', 'table', 'time', 'timeEnd',
      'timeStamp', 'trace', 'warn'
  ];

  /**
   *  Define a console variable or an empty object
   *  @property console
   */
  console = window.console || {};

  /**
   * Instanciate the console methods with an empty block
   *
   */
  length = methods.length;
  while (length--) {
      method = methods[length];

      // Only stub undefined methods.
      if (!console[method]) {
          console[method] = noop;
      }
  }

  // Place any jQuery/helper plugins in here.

});

