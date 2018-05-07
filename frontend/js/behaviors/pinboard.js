import { purgeProperties, forEach, triggerCustomEvent } from '@area17/a17-helpers';
import { mediaQuery } from '../functions';

const pinboard = function(container){

  let colCounts = {};
  let colCount = 0;
  let colCurrent = 0;
  let cols;
  let active = false;
  let maintainOrder = false;
  let primeLayout = container.className;
  let optionLayout = container.getAttribute('data-pinboard-option-layout');
  const re = /([0-9])-col@(\w*)/gi;

  // prime and option layouts *is* an F1 tyre reference 🏎

  function _getColCounts(classes) {
    // do a looped exec regex search on the class name to find matches
    // look for a number before -col@
    // and look for a breakpoint name after the -col@
    // then add to a local js obj
    let classListColInfo;
    while ((classListColInfo = re.exec(classes)) !== null) {
      colCounts[classListColInfo[2]] = classListColInfo[1];
    }
  }

  function _minOfArray(array) {
    // return smallest number in array
    return Math.min.apply(Math, array);
  }

  function _maxOfArray(array) {
    // return largest number in array
    return Math.max.apply(Math, array);
  }

  function _getMarginTop(node) {
    let style = window.getComputedStyle(node);
    return parseInt(style.getPropertyValue('margin-top'));
  }

  function _unpositionBlocks() {
    if (active) {
      forEach(container.children, function(index, block) {
        block.style.left = '';
        block.style.top = '';
        block.style.height = '';
        block.classList.remove('s-positioned');
      });
      container.style.height = '';
    }
  }

  function _positionBlocks(resetPreviousPositions) {
    let blocks = container.children;
    if (blocks.length === 0) {
      return;
    }
    let firstChild = container.firstElementChild;
    let colWidth = firstChild.offsetWidth;
    // margin is the total width, minus how many columns of content, divided by how many gutters (which is columns minus 1)
    let marginLeft = (container.offsetWidth - (colWidth * colCount)) / (colCount - 1);
    firstChild.classList.add('s-repositioning');
    let marginTop = _getMarginTop(firstChild);
    firstChild.classList.remove('s-repositioning');
    marginTop = (typeof marginTop === 'number') ? marginTop : 60;
    //
    forEach(blocks, function(index, block) {
      if (block.classList.contains('s-positioned') === false || resetPreviousPositions) {
        // reset the blocks height
        block.style.height = 'auto';
        // work out which col to drop into and how far left this is
        let smallestCol;
        let smallestColIndex;
        let leftPos;
        if (maintainOrder) {
          // always maintain DOM order
          smallestCol = cols[colCurrent];
          smallestColIndex = colCurrent;
          leftPos = smallestColIndex * (colWidth + marginLeft);
          colCurrent = (colCurrent < cols.length - 1) ? colCurrent + 1 : 0;
        } else {
          // best position like pinterest/masonry
          smallestCol = _minOfArray(cols);
          smallestColIndex = cols.indexOf(smallestCol);
          leftPos = smallestColIndex * (colWidth + marginLeft);
        }
        // calc and lock any image heights, make height is 4:3 ratio
        let img = block.querySelector('img');
        if (img && block.classList.contains('m-listing--variable-height')) {
          let blockWidth = block.offsetWidth;
          let maxHeight = Math.round(block.offsetWidth * 4/3);
          let imageNativeHeightAtThisWidth = Math.round((parseInt(img.getAttribute('height')) / parseInt(img.getAttribute('width'))) * blockWidth);
          if (imageNativeHeightAtThisWidth > maxHeight) {
            img.parentNode.style.height = maxHeight + 'px';
          } else {
            img.parentNode.style.height = imageNativeHeightAtThisWidth + 'px';
          }
        }
        // now get blocks new height
        let newHeight = block.offsetHeight;
        // position
        block.style.left = Math.round(leftPos) + 'px';
        block.style.top = Math.round(smallestCol) + 'px';
        block.style.height = Math.round(newHeight) + 'px';
        // stop being repositioned
        setTimeout(function(){
          block.classList.add('s-positioned');
        }, 250);
        // update col
        cols[smallestColIndex] = smallestCol + newHeight + marginTop;
        // update container height
        container.style.height = _maxOfArray(cols) + 'px';
        // tell the page
        triggerCustomEvent(document, 'page:updated');
      }
    });
  }

  function _setupBlocks() {
    colCount = colCounts[A17.currentMediaQuery];
    if (colCount) {
      cols = [];
      // create an array position for each column
      for (var i = 0; i < colCount; i++) {
        cols.push(0);
      }
      // go go go
      active = true;
      _positionBlocks(true);
    } else {
      _unpositionBlocks();
      active = false;
    }
  }

  function _contentAdded() {
    _positionBlocks();
  }

  function _resized() {
    setTimeout(function(){
      _getColCounts(document.documentElement.classList.contains('s-collection-filters-active') && optionLayout ? optionLayout : container.className);
      _setupBlocks();
    }, 32);
  }

  function _showFilters() {
    if (mediaQuery('medium+')) {
      setTimeout(function(){
        _getColCounts(optionLayout);
        _setupBlocks();
      }, 432);
    }
  }

  function _hideFilters() {
    if (mediaQuery('medium+')) {
      setTimeout(function(){
        _getColCounts(container.className);
        _setupBlocks();
      }, 432);
    }
  }

  function _init() {
    maintainOrder = (container.getAttribute('data-pinboard-maintain-order') === 'true');
    _getColCounts(document.documentElement.classList.contains('s-collection-filters-active') && optionLayout ? optionLayout : container.className);
    _setupBlocks();
    container.addEventListener('pinboard:contentAdded', _contentAdded, false);
    document.addEventListener('resized', _resized, false);
    document.addEventListener('ajaxPageLoad:complete', _resized, false);
    document.addEventListener('collectionFilters:open', _showFilters, false);
    document.addEventListener('collectionFilters:close', _hideFilters, false);
  }

  this.destroy = function() {
    // remove specific event handlers
    container.removeEventListener('pinboard:contentAdded', _contentAdded);
    document.removeEventListener('resized', _resized);
    document.removeEventListener('ajaxPageLoad:complete', _resized);
    document.removeEventListener('collectionFilters:open', _showFilters);
    document.removeEventListener('collectionFilters:close', _hideFilters);

    // remove properties of this behavior
    A17.Helpers.purgeProperties(this);
  };

  this.init = function() {
    _init();
  };

};

export default pinboard;
