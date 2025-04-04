/*!
 * Salvattore 1.0.5 by @rnmp and @ppold
 * https://github.com/rnmp/salvattore
 */
(function(root, factory) {
  if (typeof define === 'function' && define.amd) {
    define([], factory);
  } else if (typeof exports === 'object') {
    module.exports = factory();
  } else {
    root.salvattore = factory();
  }
}(this, function() {
/*! matchMedia() polyfill - Test a CSS media type/query in JS. Authors & copyright (c) 2012: Scott Jehl, Paul Irish, Nicholas Zakas, David Knight. Dual MIT/BSD license */

if (!window.matchMedia) {
    window.matchMedia = function() {
        "use strict";

        // For browsers that support matchMedium api such as IE 9 and webkit
        var styleMedia = (window.styleMedia || window.media);

        // For those that don't support matchMedium
        if (!styleMedia) {
            var style       = document.createElement('style'),
                script      = document.getElementsByTagName('script')[0],
                info        = null;

            style.type  = 'text/css';
            style.id    = 'matchmediajs-test';

            script.parentNode.insertBefore(style, script);

            // 'style.currentStyle' is used by IE <= 8 and 'window.getComputedStyle' for all other browsers
            info = ('getComputedStyle' in window) && window.getComputedStyle(style, null) || style.currentStyle;

            styleMedia = {
                matchMedium: function(media) {
                    var text = '@media ' + media + '{ #matchmediajs-test { width: 1px; } }';

                    // 'style.styleSheet' is used by IE <= 8 and 'style.textContent' for all other browsers
                    if (style.styleSheet) {
                        style.styleSheet.cssText = text;
                    } else {
                        style.textContent = text;
                    }

                    // Test if media query is true or false
                    return info.width === '1px';
                }
            };
        }

        return function(media) {
            return {
                matches: styleMedia.matchMedium(media || 'all'),
                media: media || 'all'
            };
        };
    }();
}

/*! matchMedia() polyfill addListener/removeListener extension. Author & copyright (c) 2012: Scott Jehl. Dual MIT/BSD license */
(function(){
    "use strict";

    // Bail out for browsers that have addListener support
    if (window.matchMedia && window.matchMedia('all').addListener) {
        return false;
    }

    var localMatchMedia = window.matchMedia,
        hasMediaQueries = localMatchMedia('only all').matches,
        isListening     = false,
        timeoutID       = 0,    // setTimeout for debouncing 'handleChange'
        queries         = [],   // Contains each 'mql' and associated 'listeners' if 'addListener' is used
        handleChange    = function(evt) {
            // Debounce
            clearTimeout(timeoutID);

            timeoutID = setTimeout(function() {
                for (var i = 0, il = queries.length; i < il; i++) {
                    var mql         = queries[i].mql,
                        listeners   = queries[i].listeners || [],
                        matches     = localMatchMedia(mql.media).matches;

                    // Update mql.matches value and call listeners
                    // Fire listeners only if transitioning to or from matched state
                    if (matches !== mql.matches) {
                        mql.matches = matches;

                        for (var j = 0, jl = listeners.length; j < jl; j++) {
                            listeners[j].call(window, mql);
                        }
                    }
                }
            }, 30);
        };

    window.matchMedia = function(media) {
        var mql         = localMatchMedia(media),
            listeners   = [],
            index       = 0;

        mql.addListener = function(listener) {
            // Changes would not occur to css media type so return now (Affects IE <= 8)
            if (!hasMediaQueries) {
                return;
            }

            // Set up 'resize' listener for browsers that support CSS3 media queries (Not for IE <= 8)
            // There should only ever be 1 resize listener running for performance
            if (!isListening) {
                isListening = true;
                window.addEventListener('resize', handleChange, true);
            }

            // Push object only if it has not been pushed already
            if (index === 0) {
                index = queries.push({
                    mql         : mql,
                    listeners   : listeners
                });
            }

            listeners.push(listener);
        };

        mql.removeListener = function(listener) {
            for (var i = 0, il = listeners.length; i < il; i++){
                if (listeners[i] === listener){
                    listeners.splice(i, 1);
                }
            }
        };

        return mql;
    };
}());

// http://paulirish.com/2011/requestanimationframe-for-smart-animating/
// http://my.opera.com/emoller/blog/2011/12/20/requestanimationframe-for-smart-er-animating

// requestAnimationFrame polyfill by Erik Möller. fixes from Paul Irish and Tino Zijdel

// MIT license

(function() {
    "use strict";

    var lastTime = 0;
    var vendors = ['ms', 'moz', 'webkit', 'o'];
    for (var x = 0; x < vendors.length && !window.requestAnimationFrame; ++x) {
        window.requestAnimationFrame = window[vendors[x]+'RequestAnimationFrame'];
        window.cancelAnimationFrame = window[vendors[x]+'CancelAnimationFrame'] ||
            window[vendors[x]+'CancelRequestAnimationFrame'];
    }

    if (!window.requestAnimationFrame)
        window.requestAnimationFrame = function(callback, element) {
            var currTime = new Date().getTime();
            var timeToCall = Math.max(0, 16 - (currTime - lastTime));
            var id = window.setTimeout(function() { callback(currTime + timeToCall); },
              timeToCall);
            lastTime = currTime + timeToCall;
            return id;
        };

    if (!window.cancelAnimationFrame)
        window.cancelAnimationFrame = function(id) {
            clearTimeout(id);
        };
}());

// https://developer.mozilla.org/en-US/docs/Web/API/CustomEvent

if (typeof window.CustomEvent !== "function") {
  (function() {
    "use strict";
    function CustomEvent(event, params) {
      params = params || { bubbles: false, cancelable: false, detail: undefined };
      var evt = document.createEvent('CustomEvent');
      evt.initCustomEvent(event, params.bubbles, params.cancelable, params.detail);
      return evt;
     }

    CustomEvent.prototype = window.Event.prototype;

    window.CustomEvent = CustomEvent;
  })();
}

/* jshint laxcomma: true */
;var salvattore = (function (global, document, undefined) {
"use strict";

var self = {},
    grids = [],
    mediaRules = [],
    mediaQueries = [],
    add_to_dataset = function(element, key, value) {
      // uses dataset function or a fallback for <ie10
      if (element.dataset) {
        element.dataset[key] = value;
      } else {
        element.setAttribute("data-" + key, value);
      }
      return;
    },
    get_from_dataset = function(element, key, value) {
      // uses dataset function or a fallback for <ie10
      if (element.dataset) {
        return element.dataset[key];
      } else {
        return element.setAttribute("data-" + key);
      }
    };

self.obtain_grid_settings = function obtain_grid_settings(element) {
  // returns the number of columns and the classes a column should have,
  // from computing the style of the ::before pseudo-element of the grid.

  var computedStyle = global.getComputedStyle(element, ":before")
    , content = computedStyle.getPropertyValue("content").slice(1, -1)
    , matchResult = content.match(/^\s*(\d+)(?:\s?\.(.+))?\s*$/)
    , numberOfColumns
    , columnClasses
  ;

  if (matchResult) {
    numberOfColumns = matchResult[1];
    columnClasses = matchResult[2];
    columnClasses = columnClasses? columnClasses.split(".") : ["column"];
  } else {
    matchResult = content.match(/^\s*\.(.+)\s+(\d+)\s*$/);
    columnClasses = matchResult[1];
    numberOfColumns = matchResult[2];
    if (numberOfColumns) {
      numberOfColumns = numberOfColumns.split(".");
    }
  }

  return {
    numberOfColumns: numberOfColumns,
    columnClasses: columnClasses
  };
};


self.add_columns = function add_columns(grid, items) {
  // from the settings obtained, it creates columns with
  // the configured classes and adds to them a list of items.

  var settings = self.obtain_grid_settings(grid)
    , numberOfColumns = settings.numberOfColumns
    , columnClasses = settings.columnClasses
    , columnsItems = new Array(+numberOfColumns)
    , columnsFragment = document.createDocumentFragment()
    , i = numberOfColumns
    , selector
  ;

  while (i-- !== 0) {
    var column = document.createElement("div");
    column.className = columnClasses.join(" ");
    columnsFragment.appendChild(column);
  }

  grid.appendChild(columnsFragment);
  self.append_elements(grid, Array.prototype.slice.call(items.children));

  add_to_dataset(grid, 'columns', numberOfColumns);
};


self.remove_columns = function remove_columns(grid) {
  // removes all the columns from a grid, and returns a list
  // of items sorted by the ordering of columns.

  var range = document.createRange();
  range.selectNodeContents(grid);

  var columns = Array.prototype.filter.call(range.extractContents().childNodes, function filter_elements(node) {
    return node instanceof global.HTMLElement;
  });

  var numberOfColumns = columns.length
    , numberOfRowsInFirstColumn = columns[0].childNodes.length
    , sortedRows = new Array(numberOfRowsInFirstColumn * numberOfColumns)
  ;

  Array.prototype.forEach.call(columns, function iterate_columns(column, columnIndex) {
    Array.prototype.forEach.call(column.children, function iterate_rows(row, rowIndex) {
      sortedRows[rowIndex * numberOfColumns + columnIndex] = row;
    });
  });

  var container = document.createElement("div");
  add_to_dataset(container, 'columns', 0);

  sortedRows.filter(function filter_non_null(child) {
    return !!child;
  }).forEach(function append_row(child) {
    container.appendChild(child);
  });

  return container;
};


self.recreate_columns = function recreate_columns(grid) {
  // removes all the columns from the grid, and adds them again,
  // it is used when the number of columns change.

  global.requestAnimationFrame(function render_after_css_media_query_change() {
    self.add_columns(grid, self.remove_columns(grid));
    var columnsChange = new CustomEvent("columnsChange");
    grid.dispatchEvent(columnsChange);
  });
};


self.media_query_change = function media_query_change(mql) {
  // recreates the columns when a media query matches the current state
  // of the browser.

  if (mql.matches) {
    Array.prototype.forEach.call(grids, self.recreate_columns);
  }
};


self.get_css_rules = function get_css_rules(stylesheet) {
  // returns a list of css rules from a stylesheet

  var cssRules;
  try {
    cssRules = stylesheet.sheet.cssRules || stylesheet.sheet.rules;
  } catch (e) {
    return [];
  }

  return cssRules || [];
};


self.get_stylesheets = function get_stylesheets() {
  // returns a list of all the styles in the document (that are accessible).

  return Array.prototype.concat.call(
    Array.prototype.slice.call(document.querySelectorAll("style[type='text/css']")),
    Array.prototype.slice.call(document.querySelectorAll("link[rel='stylesheet']"))
  );
};


self.media_rule_has_columns_selector = function media_rule_has_columns_selector(rules) {
  // checks if a media query css rule has in its contents a selector that
  // styles the grid.

  // var i = rules.length
  //   , rule
  // ;

  try {
      var i = rules.length, rule;
  }
  catch (e) {
      var i = 0, rule;
  }

  while (i--) {
    rule = rules[i];
    if (rule.selectorText && rule.selectorText.match(/\[data-columns\](.*)::?before$/)) {
      return true;
    }
  }

  return false;
};


self.scan_media_queries = function scan_media_queries() {
  // scans all the stylesheets for selectors that style grids,
  // if the matchMedia API is supported.

  var newMediaRules = [];

  if (!global.matchMedia) {
    return;
  }

  self.get_stylesheets().forEach(function extract_rules(stylesheet) {
    Array.prototype.forEach.call(self.get_css_rules(stylesheet), function filter_by_column_selector(rule) {
      if (rule.media && rule.cssRules && self.media_rule_has_columns_selector(rule.cssRules)) {
        newMediaRules.push(rule);
      }
    });
  });

  // remove matchMedia listeners from the old rules
  var oldRules = mediaRules.filter(function (el) {
      return newMediaRules.indexOf(el) === -1;
  });
  mediaQueries.filter(function (el) {
    return oldRules.indexOf(el.rule) !== -1;
  }).forEach(function (el) {
      el.mql.removeListener(self.mediaQueryChange);
  });
  mediaQueries = mediaQueries.filter(function (el) {
    return oldRules.indexOf(el.rule) === -1;
  });

  // add matchMedia listeners to the new rules
  newMediaRules.filter(function (el) {
    return mediaRules.indexOf(el) == -1;
  }).forEach(function (rule) {
      var mql = global.matchMedia(rule.media.mediaText);
      mql.addListener(self.mediaQueryChange);
      mediaQueries.push({rule: rule, mql:mql});
  });

  // swap mediaRules with the new set
  mediaRules.length = 0;
  mediaRules = newMediaRules;
};


self.rescan_media_queries = function rescan_media_queries() {
    self.scan_media_queries();
    Array.prototype.forEach.call(grids, self.recreate_columns);
};


self.next_element_column_index = function next_element_column_index(grid, fragments) {
  // returns the index of the column where the given element must be added.

  var children = grid.children
    , m = children.length
    , lowestRowCount = 0
    , child
    , currentRowCount
    , i
    , index = 0
    , colsHeight = []
    , minColHeight
  ;

  var get_possible_height = function get_possible_height(el) {
    colsHeight[i] += self.get_height_from_element(el);
  };
  for (i = 0; i < m; i++) {
    // get used height
    colsHeight[i] = self.get_height_from_element(children[i]);
    // get probably used height
    Array.prototype.forEach.call(fragments[i].childNodes, get_possible_height);
  }
  minColHeight = Math.min.apply(Math, colsHeight);
  // we assume height were available if we have something
  // so we return the index of the column with the shortest height
  if (minColHeight > 0) {
    return colsHeight.indexOf(minColHeight);
  }

  // otherwise, previous method fallback
  for (i = 0; i < m; i++) {
    child = children[i];
    currentRowCount = child.children.length + (fragments[i].children || fragments[i].childNodes).length;
    if(lowestRowCount === 0) {
      lowestRowCount = currentRowCount;
    }
    if(currentRowCount < lowestRowCount) {
      index = i;
      lowestRowCount = currentRowCount;
    }
  }

  return index;
};


self.create_list_of_fragments = function create_list_of_fragments(quantity) {
  // returns a list of fragments

  var fragments = new Array(quantity)
    , i = 0
  ;

  while (i !== quantity) {
    fragments[i] = document.createDocumentFragment();
    i++;
  }

  return fragments;
};


self.append_elements = function append_elements(grid, elements) {
  // adds a list of elements to the end of a grid

  var columns = grid.children
    , numberOfColumns = columns.length
    , fragments = self.create_list_of_fragments(numberOfColumns)
    , heightContainer = document.createElement("div")
  ;

  // first of all, append all items to a column to be able to retrieve proper height
  // (if you try to do that hidden from the screen, you can miss the good DOM/CSS context)
  heightContainer.className = self.obtain_grid_settings(grid).columnClasses.join(" ");
  heightContainer.appendChild(self.create_fragment(elements));
  grid.appendChild(heightContainer);
  self.save_elements_height(elements);
  grid.removeChild(heightContainer);

  elements.forEach(function append_to_next_fragment(element) {
    var columnIndex = self.next_element_column_index(grid, fragments);
    fragments[columnIndex].appendChild(element);
  });

  Array.prototype.forEach.call(columns, function insert_column(column, index) {
    column.appendChild(fragments[index]);
  });
};


self.prepend_elements = function prepend_elements(grid, elements) {
  // adds a list of elements to the start of a grid

  var columns = grid.children
    , numberOfColumns = columns.length
    , fragments = self.create_list_of_fragments(numberOfColumns)
    , columnIndex = numberOfColumns - 1
  ;

  elements.forEach(function append_to_next_fragment(element) {
    var fragment = fragments[columnIndex];
    fragment.insertBefore(element, fragment.firstChild);
    if (columnIndex === 0) {
      columnIndex = numberOfColumns - 1;
    } else {
      columnIndex--;
    }
  });

  Array.prototype.forEach.call(columns, function insert_column(column, index) {
    column.insertBefore(fragments[index], column.firstChild);
  });

  // populates a fragment with n columns till the right
  var fragment = document.createDocumentFragment()
    , numberOfColumnsToExtract = elements.length % numberOfColumns
  ;

  while (numberOfColumnsToExtract-- !== 0) {
    fragment.appendChild(grid.lastChild);
  }

  // adds the fragment to the left
  grid.insertBefore(fragment, grid.firstChild);
};


self.register_grid = function register_grid (grid) {
  if (global.getComputedStyle(grid).display === "none") {
    return;
  }

  // retrieve the list of items from the grid itself
  var range = document.createRange();
  range.selectNodeContents(grid);

  var items = document.createElement("div");
  items.appendChild(range.extractContents());


  add_to_dataset(items, 'columns', 0);
  self.add_columns(grid, items);
  grids.indexOf(grid) === -1 && grids.push(grid);  // don't store instance if already registered
};

self.create_fragment = function create_fragment (elements) {
  var frag = document.createDocumentFragment();
  Array.prototype.forEach.call(elements, function create_fragment_loop(element) {
    frag.appendChild(element);
  });
  return frag;
};

self.get_height_from_element = function get_height_from_element(el) {
  var height = el.offsetHeight;
  if (!height) {
    var h = get_from_dataset(el, "salvatorreHeight");
    if (h) {
      height = parseInt(h, 10);
    }
  }
  return height;
};

self.save_elements_height = function save_elements_height (elements) {
  Array.prototype.forEach.call(elements, function save_element_height(el) {
    add_to_dataset(el, "salvatorreHeight", el.offsetHeight);
  });
};


self.init = function init() {
  // adds required CSS rule to hide 'content' based
  // configuration.

  var css = document.createElement("style");
  css.innerHTML = "[data-columns]::before{display:block;visibility:hidden;position:absolute;font-size:1px;}";
  document.head.appendChild(css);

  // scans all the grids in the document and generates
  // columns from their configuration.

  var gridElements = document.querySelectorAll("[data-columns]");
  Array.prototype.forEach.call(gridElements, self.register_grid);
  self.scan_media_queries();
};


self.init();

return {
  append_elements: self.append_elements,
  prepend_elements: self.prepend_elements,
  register_grid: self.register_grid,
  recreate_columns: self.recreate_columns,
  rescan_media_queries: self.rescan_media_queries
};

})(window, window.document);

    return salvattore;
}));
