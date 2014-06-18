/*jslint browser:true*/
/*globals $*/

/**
 *  RequireJs config
 *  Main function
 *
 *  @module main
 */
require.config({

  /**
   *  Set the paths of the libraries
   *
   *  @property paths
   *
   */
  paths: {
    jquery: "../assets/js/vendor/jquery-2.1.0.min",
    modernizr: "../assets/js/vendor/modernizr-2.6.2.min",
    bootstrap: "../assets/js/vendor/bootstrap.min.js"
  },

  /**
   *  exports bind the library object to a shortcut
   *  deps list the dependencies, that is the libraries needed to be loaded before
   *
   *  @property shim
   */
  shim: {
    jquery: {
      exports: "$"
    },
    bootstrap: {
      exports: "Bootstrap",
      deps: ["jquery"]
    }
  },
});

/**
 * Assures that jQuery is loaded before executing the script
 * As a note, if Bootstrap is needed, you don't need to put
 * jQuery as a parameter since we defined jQuery as a Bootstrap
 * dependency in the shim object
 *
 *  @method require
 *  @param {String} shortcut of library
 *  @param {Object} library binded to this object
 *
 */
require(["jquery", "plugins"], function ($, Plugin) {

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
   * Options of the popover
   *
   * @property options
   */
  var options = {
    'html': true,
    'container': 'body'
  };

  /**
   * Show a popup  containing the city information
   *
   * @method popover
   * @param {Object} options
   */
  $('.city-info').popover(options);

});
